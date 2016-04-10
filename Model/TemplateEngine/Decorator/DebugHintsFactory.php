<?php
namespace MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator;

class DebugHintsFactory extends \Magento\Developer\Model\TemplateEngine\Decorator\DebugHintsFactory
{
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\MagentoHackathon\\ImprovedTemplateHints\\Model\\TemplateEngine\\Decorator\\Opentip')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Magento\Developer\Model\TemplateEngine\Decorator\Opentip
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
