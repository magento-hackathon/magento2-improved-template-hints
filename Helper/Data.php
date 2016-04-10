<?php
namespace MagentoHackathon\ImprovedTemplateHints\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Theme\Model\View\Design
     */
    protected $_design;

    public function __construct(\Magento\Theme\Model\View\DesignInterface $design)
    {
        $this->_design = $design;
    }

    public function getSkinFileContent($file) {
        $areaBackup = $this->_design->getArea();
        $path = $this->_design
            ->setArea('frontend')
            ->getFilename($file, array('_type' => 'skin'));
        $content = file_get_contents($path);
        $package->setArea($areaBackup);
        return $content;
    }

}
