//$.noConflict();
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
        "margin-left": canvaswidth - 35,
		"z-index": "200000",
    });
    jQuery('div.fggm_contac_us_img').click(function() {
        jQuery('div#fggm-box-popup').css({
            "height": canvasheight,
            "width": canvaswidth,
            "opacity": "1.95",
            "display": "block",
            "color": "white",
            "z-index": "200000",
            "position": "fixed",
            "top": "0"
        });
        var lat = jQuery("div.gm_lat").text();
        var lng = jQuery("div.gm_lon").text();
      var zoom = parseInt(jQuery("div.gm_zoom").text());
    var maptype = jQuery("div.gm_type").text();
    var pattern = /ROAD/;
var exists = pattern.test(maptype);
var prototype = /SATELLITE/;
var occur = prototype.test(maptype);
var model = /HYBRID/;
var present = model.test(maptype);
var formatt = /TERRAIN/;
var obtain = formatt.test(maptype);
if(exists){
   var myCenter = new google.maps.LatLng(lat, lng);
        var marker;
        var mapProp = {
            'center': myCenter,
            'zoom': zoom,
            'mapTypeId': google.maps.MapTypeId.ROAD,
            'panControl': true,
            'scaleControl': true,
            'zoomControl': true,
            'mapTypeControl': true,
            'scrollWheel': true
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);
}
if(occur){
 var myCenter = new google.maps.LatLng(lat, lng);
        var marker;
        var mapProp = {
            'center': myCenter,
            'zoom': zoom,
            'mapTypeId': google.maps.MapTypeId.SATELLITE,
            'panControl': true,
            'scaleControl': true,
            'zoomControl': true,
            'mapTypeControl': true,
            'scrollWheel': true
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);    
}
    
 if(present){
   var myCenter = new google.maps.LatLng(lat, lng);
        var marker;
        var mapProp = {
            'center': myCenter,
            'zoom': zoom,
            'mapTypeId': google.maps.MapTypeId.HYBRID,
            'panControl': true,
            'scaleControl': true,
            'zoomControl': true,
            'mapTypeControl': true,
            'scrollWheel': true
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);   
 }   
 if(obtain){
   var myCenter = new google.maps.LatLng(lat, lng);
        var marker;
        var mapProp = {
            'center': myCenter,
            'zoom': zoom,
            'mapTypeId': google.maps.MapTypeId.TERRAIN,
            'panControl': true,
            'scaleControl': true,
            'zoomControl': true,
            'mapTypeControl': true,
            'scrollWheel': true
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        marker = new google.maps.Marker({
            position: myCenter,
            animation: google.maps.Animation.BOUNCE
        });

        marker.setMap(map);   
 }
    });
    jQuery('div#fggm_form_show').css({
        "margin-top": display_positon_top / 100,
        "margin-left": display_positon_left / 2
    });

    function initialize() {
        var address = (document.getElementById('my-address'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

});
function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("my-address").value;
    //alert(address);
    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();

            document.getElementById("latitude_value").value = latitude;
            document.getElementById("longitude_value").value = longitude;

        }

        else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}


	   