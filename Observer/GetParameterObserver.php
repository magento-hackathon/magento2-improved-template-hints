<?php
namespace MagentoHackathon\ImprovedTemplateHints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class GetParameterObserver implements ObserverInterface
{

    /**
     * @var \MagentoHackathon\ImprovedTemplateHints\Helper\Data $helper
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\Config\MutableScopeConfigInterface
     */
    protected $_mutableConfig;

    /**
     * @param \MagentoHackathon\ImprovedTemplateHints\Helper\Data $helper
     * @param \Magento\Framework\App\Config\MutableScopeConfigInterface $mutableConfig
     */
    public function __construct(
        \MagentoHackathon\ImprovedTemplateHints\Helper\Data $helper,
        \Magento\Framework\App\Config\MutableScopeConfigInterface $mutableConfig
    ) {
        $this->_helper          = $helper;
        $this->_mutableConfig   = $mutableConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_helper->shouldShowTemplatePathHints()) {

            $this->_mutableConfig->setValue(\MagePsycho\Easypathhints\Helper\Data::XML_PATH_DEV_DEBUG_TEMPLATE_HINTS_STOREFRONT, 1, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $this->_mutableConfig->setValue(\MagePsycho\Easypathhints\Helper\Data::XML_PATH_DEV_DEBUG_TEMPLATE_HINTS_ADMIN, 1, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $this->_mutableConfig->setValue(\MagePsycho\Easypathhints\Helper\Data::XML_PATH_DEV_DEBUG_TEMPLATE_HINTS_BLOCKS, 1, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);


        }
        return $this;
    }
}