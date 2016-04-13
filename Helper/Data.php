<?php
namespace MagentoHackathon\ImprovedTemplateHints\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_ENABLED = 'dev/improved_template_hints/enabled';

    public function shouldShowTemplatePathHints()
    {

        $isActive = $this->isEnabled();
        $getParameter = $this->_getRequest()->getParam('ath');
        if ($getParameter == "1" && $isActive) {
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