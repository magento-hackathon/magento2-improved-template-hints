# Magento2 Improved Template Hints

Magento 2 module for improved template hints. Based on the Magento 1 module. [Aoe_TemplateHints](https://github.com/AOEpeople/Aoe_TemplateHints)


## Quick Installation

        composer config repositories.hackathon_improved-template-hints vcs git@github.com:magento-hackathon/magento2-improved-template-hints.git
        composer require magento-hackaton/magento2-improved-template-hints:dev-master
        bin/magento module:enable MagentoHackathon_ImprovedTemplateHints
        bin/magento setup:upgrade

## Normal Installation

1. Add the repository to the repositories section of your composer.json file:
```
"repositories": [
    {
     "type": "vcs",
     "url": "git@github.com:magento-hackathon/magento2-improved-template-hints.git"
    }
],
```
2. Require the module & install

```
composer require magento-hackaton/magento2-improved-template-hints:dev-master
```

Original Hackathon Issue Discussion: [magento-hackathon/pre-imagine-2016/issues/31](https://github.com/magento-hackathon/pre-imagine-2016/issues/31)

## Usage

To show the template hints simply add ?ath=1 to the shop URL after installing this module. 
        
### Block Colors:
[GREEN] Block is cached -> Magento2 Default Behaviour

[RED] Block is not cached and the whole Page is not cached

[ORANGE] Private Block: Block will be retrieved trough AJAX

[BLUE] Shared Block: Block will be retrieved trough ESI
        
