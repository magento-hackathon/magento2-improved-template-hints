<?php

namespace MagentoHackathon\ImprovedTemplateHints\Model\TemplateEngine\Decorator;

class DebugHints extends \Magento\Developer\Model\TemplateEngine\Decorator\DebugHints
{
    public function render(\Magento\Framework\View\Element\BlockInterface $block, $templateFile, array $dictionary = [])
    {
        return parent::render($block, $templateFile, $dictionary);
    }
}