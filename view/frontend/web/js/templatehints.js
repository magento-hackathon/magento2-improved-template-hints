define([
    "MagentoHackathon_ImprovedTemplateHints/js/opentip-jquery.min",
    "jquery",
    "underscore"
], function(opentip, $, _) {
    return function(config, node) {
        node = $(node);

        //console.log('loaded!');
        var id = node.attr('id');
        node.on('mouseover', function(event) {
            event.preventDefault();

            new Opentip(
                this,
                $("#"+id + '-infobox').html(),
                $("#"+id + '-title').html(),
                {
                    //style: 'slick',
                    hideOn: 'click',
                    fixed: true,
                    group: 'ath'
                }
            );
        });

    }
});