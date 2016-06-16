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
/*
define([
    "MagentoHackathon_ImprovedTemplateHints/js/opentip-jquery.min",
    "jquery",
    "underscore"
], function(opentip, $, _) {

    return function(config, node) {
        console.log("Test");




    }

});

$(".tpl-hint").each(function(node) {
    var id = node.getAttribute('id');
    node.observe('mouseover', function(event) {
        event.preventDefault();
        new Opentip(
            this,
            $(id + '-infobox').innerHTML,
            $(id + '-title').innerHTML,
            {
                style: 'slick',
                hideOn: 'click',
                fixed: true,
                group: 'ath'
            }
        );
    });
});
    */