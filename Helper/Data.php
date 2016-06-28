<?php
namespace MagentoHackathon\ImprovedTemplateHints\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_ENABLED = 'dev/improved_template_hints/enabled';
    const XML_PATH_DEBUG_TEMPLATE_FRONT = 'dev/debug/template_hints_storefront';
    const XML_PATH_DEBUG_TEMPLATE_ADMIN = 'dev/debug/template_hints_admin';
    const XML_PATH_DEBUG_BLOCKS         = 'dev/debug/template_hints_blocks';
    /**
     * @var \Magento\Developer\Helper\Data
     */
    protected $devHelper;

    /**
     * @param \MagentoHackathon\ImprovedTemplateHints\Helper\Data $helper
     */
    public function __construct(
        \Magento\Developer\Helper\Data $devHelper,
        \Magento\Framework\App\Helper\Context $context
    )
    {
        parent::__construct($context);
        $this->devHelper = $devHelper;

    }

    public function shouldShowTemplatePathHints()
    {

        $isActive = $this->isEnabled();
        $getParameter = $this->_getRequest()->getParam('ath');
        $isDevAllowed = $this->devHelper->isDevAllowed();
        if ($getParameter == "1" && $isActive && $isDevAllowed) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if enabled
     *
     * @return string|null
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }


}