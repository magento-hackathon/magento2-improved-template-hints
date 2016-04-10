<?php
namespace MagentoHackathon\ImprovedTemplateHints\Block;

class Head extends \Magento\Framework\View\Element\Template {

    protected function _construct() {
        /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();

        /** @var \Magento\Framework\View\Page\Config $page */
        $page = $om->get('Magento\Framework\View\Page\Config');
        $page->addPageAsset('MagentoHackathon_ImprovedTemplateHints::opentip.css');
        $page->addPageAsset('MagentoHackathon_ImprovedTemplateHints::aoe_templatehints.css');
    }

}
