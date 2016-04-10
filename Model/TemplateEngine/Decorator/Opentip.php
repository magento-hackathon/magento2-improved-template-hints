<?php

namespace MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator;

class Opentip extends \MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator\AbstractDecorator
{
    /**
     * @var \Magento\Framework\View\TemplateEngineInterface
     */
    private $_subject;

    /**
     * @var bool
     */
    private $_showBlockHints;

    /**
     * @var int
     */
    private $_hintId = 0;

    /**
     * @var bool
     */
    private $_init = true;

    /**
     * @var bool
     */
    protected $_afterHead = false;

    /**
     * @param \Magento\Framework\View\TemplateEngineInterface $subject
     * @param bool $showBlockHints Whether to include block into the debugging information or not
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\TemplateEngineInterface $subject,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \MagentoHackathon\ImprovedTemplateHints\Helper\ClassInfo $classInfoHelper,
        $showBlockHints)
    {
        $this->_subject = $subject;
        $this->_showBlockHints = $showBlockHints;
        parent::__construct($storeManager, $subject, $scopeConfig, $classInfoHelper, $showBlockHints);
    }

    public function render(\Magento\Framework\View\Element\BlockInterface $block, $templateFile, array $dictionary = [])
    {
        $result = $this->_subject->render($block, $templateFile, $dictionary);

        $path = $this->getBlockPath($block);
        $blockInfo = $this->getBlockInfo($block);

        $wrappedHtml = '';
        if ($this->_init && $this->_afterHead && $block->getNameInLayout()) {
            $wrappedHtml = '<!-- INIT TEMPLATEHINTS RENDERER START -->' . $this->getRenderer()->init($result) . '<!-- INIT TEMPLATEHINTS RENDERER STOP -->';
            $this->_init = false;
        }
        if ($block->getNameInLayout() == 'head') {
            $this->_afterHead = true;
        }

        $this->_hintId++;
        $wrappedHtml .= sprintf(
            '<div id="tpl-hint-%1$s" class="%2$s" data-ot-show-on="click" data-ot-fixed="true" data-ot-hide-trigger="closeButton" data-ot-tip-joint="top" data-ot-group="hints" data-ot-target="true" data-ot="%5$s" data-ot-title="%4$s" >
                %3$s
            </div>',
            $this->_hintId,
            $this->getHintClass() . ' ' . $blockInfo['cache-status'],
            $result,
            htmlentities($this->renderTitle($blockInfo)),
            htmlentities($this->renderBox($blockInfo, $path))
        );
        return $wrappedHtml;
    }

    protected function renderBox(array $info, array $path) {
        $output = '';
        $output .= '<dl>';
        $output .= $this->arrayToDtDd($info, array('name', 'alias', 'cache-status'));
        if (count($path) > 0) {
            $output .= '<dt>Block nesting:</dt><dd>';
            $output .= '<ul class="path">';
            foreach ($path as $step) {
                $output .= '<li>'.$this->renderTitle($step).'</li>';
            }
            $output .= '</ul>';
            $output .= '</dd>';
        }
        $output .= '</dl>';
        return $output;
    }

    protected function arrayToDtDd(array $array, array $skipKeys=array()) {
        $output = '<dl>';
        foreach ($array as $key => $value) {
            if (in_array($key, $skipKeys)) {
                continue;
            }
            if (is_array($value)) {
                $value = $this->arrayToDtDd($value);
            }
            if (is_int($key)) {
                $output .= $value . '<br />';
            } else {
                $output .= '<dt>'.ucfirst($key).':</dt><dd>';
                $output .= $value;
                $output .= '</dd>';
            }
        }
        $output .= '</dl>';
        return $output;
    }

    protected function getHintClass()
    {
        return 'tpl-hint tpl-hint-border';
    }

    public function init($wrappedHtml) {
//        todo change to use requirejs.
        $wrappedHtml = 'script';
//        $wrappedHtml .= '<script type="text/javascript">' . $helper->getSkinFileContent('aoe_templatehints/js/opentip.min.js') . '</script>';
//        $wrappedHtml .= '<script type="text/javascript">' . $helper->getSkinFileContent('aoe_templatehints/js/excanvas.js') . '</script>';
//        $wrappedHtml .= '<script type="text/javascript">' . $helper->getSkinFileContent('aoe_templatehints/js/aoe_templatehints.js') . '</script>';
//        $wrappedHtml .= '<style type="text/css">' . $helper->getSkinFileContent('aoe_templatehints/css/templatehints.css') . '</style>';
//        $wrappedHtml .= '<style type="text/css">' . $helper->getSkinFileContent('aoe_templatehints/css/opentip.css') . '</style>';
        return $wrappedHtml;
    }

}