jQuery(document).ready(function() {
    var screen_height = window.screen.height;
    var screen_width = window.screen.width;
    var mid_height = screen_height / 2;
    var canvaswidth = jQuery(window).width();
    var canvasheight = jQuery(document).height();
    var display_positon_left = screen_width - 800;
    var display_positon_top = 13 * screen_height;
    jQuery("#fg_close_box").click(function() {
        jQuery('div#fggm-box-popup').css({
            "display": "none"
        });
    });
    jQuery('div.fggm_contac_us_img').css({
        "display": "block",
        "top": "0",
        "margin-top": mid_height - 100,
        "margin-left": canvaswidth - 35
    });
    jQuery('div.fggm_contac_us_img').click(function() {
        jQuery('div#fggm-box-popup').css({
            "height": canvasheight,
            "width": canvaswidth,
            "opacity": "1.95",
            "display": "block",
            "color": "white",
            "z-index": "2000",
            "position": "fixed",
            "top": "0"
        });
        var lat = jQuery("div.gm_lat").text();
        var lng = jQuery("div.gm_lon").text();
        var myCenter = new google.maps.LatLng(lat, lng);
        var marker;
        var mapProp = {
            center: myCenter,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROAD
        };

        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);
    });
    jQuery('div#fggm_form_show').css({
        "margin-top": display_positon_top / 100,
        "margin-left": display_positon_left / 2
    });

});    