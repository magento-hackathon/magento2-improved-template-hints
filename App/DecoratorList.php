<?php

namespace MagentoHackathon\ImprovedTemplateHints\Model;

use MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator\AbstractDecorator;

class DecoratorList
{
    protected $objectManager;

    protected $decoratorList;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $decoratorList
    ) {
        $this->objectManager = $objectManager;
        $this->decoratorList = $decoratorList;
        $this->decoratorList = array_filter(
            $decoratorList,
            function ($item) {
                return $item['name'] && $item['class'] && ($item['class'] instanceof AbstractDecorator);
            }
        );
    }


    /**
     * Retrieve decorator instance by id
     *
     * @param string $decoratorId
     * @return AbstractDecorator
     */
    protected function getDecoratorInstance($decoratorId)
    {
        if (!isset($this->decoratorList[$decoratorId]['object'])) {
            $this->decoratorList[$decoratorId]['object'] = $this->objectManager->create(
                $this->decoratorList[$decoratorId]['class']
            );
        }
        return $this->decoratorList[$decoratorId]['object'];
    }

    /**
     * Retrieve decorator instance by id
     *
     * @param string $decoratorId
     * @return AbstractDecorator
     */
    protected function getCssFile($decoratorId)
    {
        return !isset($this->decoratorList[$decoratorId]['css']) ? $this->decoratorList[$decoratorId]['css'] : null;
    }
    
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return AbstractDecorator
     */
    public function current()
    {
        return $this->getRouterInstance($this->key());
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->decoratorList);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return string|int|null
     */
    public function key()
    {
        return key($this->decoratorList);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !!current($this->decoratorList);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->decoratorList);
    }
}