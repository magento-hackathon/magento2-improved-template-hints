<?php

namespace MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Store\Model\ScopeInterface;

class AbstractDecorator extends \Magento\Developer\Model\TemplateEngine\Decorator\DebugHints
{
    const TYPE_CACHED = 'cached';
    const TYPE_NOTCACHED = 'notcached';
    const TYPE_IMPLICITLYCACHED = 'implicitlycached';

    const XML_PATH_REMOTE_CALL_URL_TEMPLATE = 'dev/improved_template_hints/remote_call_url_template';
    const XML_PATH_ENABLE_PHPSTORM_REMOTE_CALL = 'dev/improved_template_hints/enable_phpstorm_remote_call';


    protected $classMethodCache = array();
    protected $remoteCallEnabled;
    protected $remoteCallUrlTemplate;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \MagentoHackathon\ImprovedTemplateHints\Helper\ClassInfo
     */
    protected $classInfoHelper;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\TemplateEngineInterface $subject,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \MagentoHackathon\ImprovedTemplateHints\Helper\ClassInfo $classInfoHelper,
        $showBlockHints
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->classInfoHelper = $classInfoHelper;
        parent::__construct($subject, $showBlockHints);
    }

    /**
     * Get block information
     *
     * @param AbstractBlock $block
     * @param bool $fullInfo
     * @return array
     */
    public function getBlockInfo(AbstractBlock $block, $fullInfo=true) {
        $info = array(
            'name' => $block->getNameInLayout(),
            'alias' => $block->getBlockAlias(),
        );

        if (!$fullInfo) {
            return $info;
        }

        $info['class'] = get_class($block);

        if ($this->getRemoteCallEnabled()) {
            $fileAndLine = $this->classInfoHelper->findFileAndLine($info['class']);
            if ($fileAndLine) {
                $url = sprintf($this->getRemoteCallUrlTemplate(), $fileAndLine['file'], $fileAndLine['line']);
                $info['class'] = sprintf($this->getRemoteCallLinkTemplate(),
                    $url,
                    $info['class']
                );
            }
        }

        $info['module'] = $block->getModuleName();

        if ($block instanceof \Magento\Cms\Block\Block) {
            $info['cms-blockId'] = $block->getBlockId();
        }
        if ($block instanceof \Magento\Cms\Block\Page) {
            $info['cms-pageId'] = $block->getPage()->getIdentifier();
        }
        $templateFile = $block->getTemplateFile();
        if ($templateFile) {
            $info['template'] = $templateFile;

            if ($this->getRemoteCallEnabled()) {
               $url = sprintf($this->getRemoteCallUrlTemplate(), $templateFile, 0);
                $info['template'] = sprintf($this->getRemoteCallLinkTemplate(),
                   $url,
                   $templateFile
               );
            }

        }

        // cache information
        $info['cache-status'] = self::TYPE_NOTCACHED;

        $cacheLifeTime = $block->getCacheLifetime();
        if (!is_null($cacheLifeTime)) {

            $info['cache-lifetime'] = (intval($cacheLifeTime) == 0) ? 'forever' : intval($cacheLifeTime) . ' sec';
            $info['cache-key'] = $block->getCacheKey();
            $info['cache-key-info'] = is_array($block->getCacheKeyInfo())
                ? implode(', ', $block->getCacheKeyInfo())
                : $block->getCacheKeyInfo()
            ;
            $info['tags'] = implode(',', $block->getCacheTags());

            $info['cache-status'] = self::TYPE_CACHED;
        } elseif ($this->isWithinCachedBlock($block)) {
            $info['cache-status'] = self::TYPE_IMPLICITLYCACHED; // not cached, but within cached
        }

        $info['methods'] = $this->getClassMethods(get_class($block));

        return $info;
    }



    /**
     * Check if remote call is enabled in configuration
     *
     * @return bool
     */
    public function getRemoteCallEnabled() {
        if (is_null($this->remoteCallEnabled)) {
            $this->remoteCallEnabled = $this->scopeConfig->getValue(
                self::XML_PATH_ENABLE_PHPSTORM_REMOTE_CALL,
                ScopeInterface::SCOPE_STORE
            );
        }
        return $this->remoteCallEnabled;
    }



    /**
     * Get remote call url template
     *
     * @return mixed
     */
    public function getRemoteCallUrlTemplate() {
        if (is_null($this->remoteCallUrlTemplate)) {
            $this->remoteCallUrlTemplate = $this->scopeConfig->getValue(
                self::XML_PATH_REMOTE_CALL_URL_TEMPLATE,
                ScopeInterface::SCOPE_STORE
            );
        }
        return $this->remoteCallUrlTemplate;
    }



    /**
     * Get link template for remote calls
     *
     * @return string
     */
    public function getRemoteCallLinkTemplate() {
        return '<a href="%s" onclick="var ajax = new XMLHttpRequest(); ajax.open(\'GET\', this.href); ajax.send(null); return false">%s</a>';
    }



    /**
     * Get block methods (incl. methods of parent classes)
     *
     * @param string $className
     * @return array
     */
    public function getClassMethods($className) {

        if (!isset($this->classMethodCache[$className])) {

            $info = array();

            $rClass = new \ReflectionClass($className);

            $currentClass = $rClass;
            $currentClassName = $currentClass->getName();
            $currentMethods = get_class_methods($currentClass->getName());
            $parentClass = $currentClass->getParentClass();

            $level = 1;
            while ($parentClass && $level < 6) {

                $parentClassName = $parentClass->getName();

                if (!in_array($currentClassName, array('\Magento\Framework\View\Element\AbstractBlock', '\Magento\Framework\View\Element\Template'))) {
                    $parentMethods = get_class_methods($parentClassName);
                    $tmp = array_diff($currentMethods, $parentMethods);
                    $info[$currentClassName] = array();

                    // render methods to "methodName($paramter1, $parameter2, ...)"
                    foreach ($tmp as $methodName) {

                        $parameters = array();
                        foreach ($currentClass->getMethod($methodName)->getParameters() as $parameter) { /* @var $parameter \ReflectionParameter */
                            $parameters[] = '$'. $parameter->getName();
                        }

                        if (count($parameters) > 3) {
                            $parameters = array_slice($parameters, 0, 2);
                            $parameters[] = '...';
                        }

                        $info[$currentClassName][] = $methodName . '(' . implode(', ', $parameters) . ')';
                    }
                } else {
                    $info[$currentClassName] = array('(skipping)');
                    $parentMethods = array();
                }

                $level++;

                $currentClass = $parentClass;
                $currentClassName = $currentClass->getName();
                $currentMethods = $parentMethods;
                $parentClass = $currentClass->getParentClass();
            }

            $this->classMethodCache[$className] = $info;
        }

        return $this->classMethodCache[$className];
    }



    /**
     * Get path information of a block
     *
     * @param AbstractBlock $block
     * @return string
     */
    public function getBlockPath(AbstractBlock $block) {
        $blockPath = array();
        $step = $block->getParentBlock();
        $i = 0;
        while ($i++ < 20 && $step instanceof AbstractBlock) {
            $blockPath[] = $this->getBlockInfo($step, false);
            $step = $step->getParentBlock();
        }
        return $blockPath;
    }



    /**
     * Check if a block is within another one that is cached
     *
     * @param AbstractBlock $block
     * @return bool
     */
    public function isWithinCachedBlock(AbstractBlock $block) {
        $step = $block;
        $i = 0;
        while ($i++ < 20 && $step instanceof AbstractBlock) {
            if (!is_null($step->getCacheLifetime())) {
                return true;
            }
            $step = $step->getParentBlock();
        }
        return false;
    }



    /**
     * Render title
     *
     * @param array $info
     * @return string
     */
    public function renderTitle(array $info) {
        $title = $info['name'];
        if ($info['name'] != $info['alias'] && $info['alias']) {
            $title .= ' (alias: ' . $info['alias'] . ')';
        }
        return $title;
    }

    public function render(\Magento\Framework\View\Element\BlockInterface $block, $templateFile, array $dictionary = [])
    {
        return parent::render($block, $templateFile, $dictionary);
    }
}