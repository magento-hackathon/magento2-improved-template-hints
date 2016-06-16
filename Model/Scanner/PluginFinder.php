<?php
namespace MagentoHackathon\ImprovedTemplateHints\Model\Scanner;

use Magento\Setup\Module\Di\Code\Scanner\ConfigurationScanner;

class PluginFinder
{
    protected $scanResult;
    /**
     * @var ConfigurationScanner
     */
    private $configurationScanner;
    /**
     * @var Plugin
     */
    private $pluginScanner;

    public function __construct(
        ConfigurationScanner $configurationScanner,
        Plugin $pluginScanner
    )
    {
        $this->configurationScanner = $configurationScanner;
        $this->pluginScanner = $pluginScanner;
        $files = $this->configurationScanner->scan('di.xml');
        $this->scanResult = $this->pluginScanner->getAllTypes($files);

    }

    /**
     * Get plugin types
     *
     * @return array
     */
    public function getPluginsForClass($className)
    {
        if(array_key_exists($className,$this->scanResult)){
            return $this->scanResult[$className];
        }else{
            return array();
        }

    }
}