# Magento2 Improved Template Hints

Magento 2 module for improved template hints. Based on the Magento 1 module. [Aoe_TemplateHints](https://github.com/AOEpeople/Aoe_TemplateHints)

## Installation

* Configure the composer repository.
```
composer config repositories.magentohackathon-module-improvedtemplatehints git git@github.com:magento-hackathon/magento2-improved-template-hints.git
```

* Require the module & install.

```
composer require magento-hackaton/magento2-improved-template-hints:dev-master
```

* Enable module, run the module setup and flush cache
```
bin/magento module:enable --clear-static-content MagentoHackathon_ImprovedTemplateHints
bin/magento setup:upgrade 
bin/magento cache:flush
```

## ToDo

* Enable template path hints for admin.
* Add a system configuration for changing the display style of the template hints.
* Implement more decorators.
* Implement a developer toolbar to display more information.

Original Hackathon Issue Discussion: [magento-hackathon/pre-imagine-2016/issues/31](https://github.com/magento-hackathon/pre-imagine-2016/issues/31)
