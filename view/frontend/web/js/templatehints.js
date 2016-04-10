define([
    "MagentoHackathon_ImprovedTemplateHints/js/opentip-jquery.min",
    "jquery",
    "underscore"
], function(opentip, $, _) {
    return function(config, node) {
        node = $(node);

        new Opentip(node);
    }
});