define([
    "MagentoHackathon_ImprovedTemplateHints/js/opentip-jquery.min",
    "jquery",
    "underscore"
], function(opentip, $, _) {
    return function(config, node) {
        node = $(node);

        var id = node.attr('id');
        new Opentip(node);
        //node.on('mouseover', function (event) {
        //    event.preventDefault();
        //
        //    //new Tip(
        //    //    this,
        //    //    event,
        //    //    $(id + '-infobox').innerHTML,
        //    //    $(id + '-title').innerHTML,
        //    //    {
        //    //        style: 'slick',
        //    //        hideOn: 'click',
        //    //        fixed: true,
        //    //        group: 'ath'
        //    //    }
        //    //);
        //});
    }
});