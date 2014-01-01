jQuery(document).ready(function() {
    jQuery('.fg_group').hide();
    jQuery('.fg_group:first').fadeIn();
    jQuery('#fg_of-nav li:first').addClass('current');
    jQuery('#fg_of-nav li a').click(function(evt) {
        jQuery('#fg_of-nav li').removeClass('current');
        jQuery(this).parent().addClass('current');
        if (jQuery(this).attr("title") == "Embed Code") {
            jQuery(".fg_embed_code_save").css("display", "block");
            jQuery(".fg_embed_code_save").css("float", "left");
            jQuery(".fg_embed_code_save").css("width", "120px");
            jQuery(".fg_embed_code_save").css("height", "40px");
        }
        else {
            jQuery(".fg_embed_code_save").css("display", "none");
        }
        var clicked_group = jQuery(this).attr('href');
        jQuery('.fg_group').hide();
        jQuery(clicked_group).fadeIn();
        evt.preventDefault();
    });
    jQuery('.fg_embed_code_save').click(function() {
        
        var text_value = jQuery('textarea#fg_content_html').val();
        var bg_color = jQuery('input.color').val();
        var googlemap_code = jQuery('textarea.googlemap_iframe').val();
        var latitude_map = jQuery('input.latitude_value').val();
        var longitude_map = jQuery('input.longitude_value').val();
        var location_address = jQuery('textarea.address').val();
        var zoom_level = jQuery('input.zoom_level').val();
        var map_type_id = jQuery('#map_type option:selected').val();
        if (text_value == "") {
            alert("Please insert iframe code");
            jQuery('div#loader_img').css("display", "none");
        }
        else {
            var pattern = /iframe/;
            var exists = pattern.test(text_value);
            if (exists) {
				jQuery('div#loader_img').css("display", "block");
                var data = {
                    action: 'master_response',
                    value: text_value,
                    color: bg_color,
                    iframe: googlemap_code,
                    latitude: latitude_map,
                    longitude: longitude_map,
                    address: location_address,
                    zoom: zoom_level,
                    map_type:map_type_id 
                };
                jQuery.post(script_call.ajaxurl, data, function(response) {
                    if (response) {
                        //alert(response);
                        jQuery('div#loader_img').css("display", "none");
                    }
                    else {
                        //alert("error");
                        jQuery('div#loader_img').css("display", "none");
                    }
                });
            }
            if (!exists) {
                alert("Please paste the correct iframe code");
                jQuery('div#loader_img').css("display", "none");
            }
        }
    });
});