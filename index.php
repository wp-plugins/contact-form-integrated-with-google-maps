<?php
/*
  Plugin Name:  Contact Form Intregrated With Google Maps
  Plugin URI: http://www.formget.com
  Description:  Contact Form Integrated With Google Maps allows to colligate geolocation information along with contact form in simple way.
  Version: 1.6
  Author: FormGet
  Author URI: http://www.formget.com
 */
function fg_admin_notice() {
    $fg_iframe_form = get_option('fg_iframe_embed_code');
    $string = "iframe";
    $pos = strpos($fg_iframe_form, $string);
    if ($pos == false) {
        global $current_user;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
        if (!get_user_meta($user_id, 'admin_ignore_notice')) {
            ?>
            <div class="fg_trial-notify">
                <p>
                    <a href='<?php echo admin_url('admin.php?page=fg_page'); ?>'>Click to Create your own Advance Contact Form.</a> You can add your built form to any Page, Post, Sidebar or as a Tabbed Content.<?php printf(__('<a class="fg_hide_notice", href="%1$s">Hide Notice</a>'), '?admin_nag_ignore=0'); ?></p>
            </div>
            <?php
        }
    }
}

add_action('admin_notices', 'fg_admin_notice');

	function value_option_table(){
	add_option('googleMap_latitude_position', '23.2500');
    add_option('googleMap_longitude_position','77.4167');
	add_option('map_zoom_value', '11');
		
	}
register_activation_hook( __FILE__, 'value_option_table' );



function fg_admin_nag_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if (isset($_GET['admin_nag_ignore']) && '0' == $_GET['admin_nag_ignore']) {
        add_user_meta($user_id, 'admin_ignore_notice', 'true', true);
    }
}

add_action('admin_init', 'fg_admin_nag_ignore');

function fg_delete_user_entry() {
    global $current_user;
    $user_id = $current_user->ID;
    delete_user_meta($user_id, 'admin_ignore_notice', 'true', true);
}

register_deactivation_hook(__FILE__, 'fg_delete_user_entry');

function fg_add_style() {
    wp_enqueue_style('form1_style1_sheet1', plugins_url('css/fgstyle.css', __FILE__));
    wp_enqueue_style('form_style_sheet1', plugins_url('css/formstyle.css', __FILE__));
}

add_action("init", "fg_add_style");


//setting page
add_action('admin_menu', 'fggm_menu_page');

function fggm_menu_page() {
    add_menu_page('fg', 'Contact Form', 'manage_options', 'fg_page', 'fggm_setting_page', plugins_url('image/favicon.ico', __FILE__), 119);
}

function fggm_setting_page() {
    $url = plugins_url();
    ?><div id="fg_of_container" class="fg_wrap">
        <form id="fg_ofform" action="" method="POST">
            <div id="fg_header">
                <div class="fg_logo">
                    <h2>Contact Form Intregrated With Google Maps</h2>                   
                </div>
                <a target="#">
                    <div class="fg_icon-option"> </div>
                </a>
                <div class="clear"></div>
            </div>
            <div id="fg_main">

                <div id="fg_of-nav">
                    <ul>
                        <li> <a class="pn-view-a" href="#pn_content" title="Form Builder">Contact Form Builder </a></li>
                        <li> <a class="pn-view-a" href="#pn_displaysetting" title="Embed Code">Settings</a></li>
                        <li> <a class="pn-view-a" href="#pn_template" title="Help">Help</a></li>	
                        <li> <a class="pn-view-a" href="#pn_contactus" title="Help">Plugin Support</a></li>
                    </ul>
                </div>

                <div id="fg_content">
                    <div class="fg_group" id="pn_content">
                        <h2>Contact Form Builder</h2>

                        <div class="fg_section section-text">
                            <h3 class="fg_heading"> Create your custom form by just clicking the fields on left side of the panel. Visibility Problem Click here - <a href="http://www.formget.com/app" target="_blank">Building Contact Form</a></h3>
                            <div class="outer_div_builder_iframe">
							<div class="inner_div_builder_iframe">
                            <iframe src="http://www.formget.com/app" name="iframe" id="iframebox" style="width:100%; height:800px; border:1px solid #dfdfdf; align:center;">
                            </iframe>
							</div>
							</div>
                        </div>

                    </div>	

                    <div class="fg_group" id="pn_displaysetting">
                        <h2>Settings</h2>
                        <div class="fg_section section-text">
                            <h3 class="fg_heading">Click on the tab "Embed Form on Your Site". Copy Iframe code and paste in the below textarea.</h3>
                            <div class="option">
                                <div class="fg_controls">
                                    <textarea name="content[html]" cols="60" rows="10"   class="regular-text"  id="fg_content_html" style="width:500px"><?php embeded_code(); ?></textarea>
                                    <div class="color_selector">
                                        <h3 class="fg_heading" style="width:480px;">Paste or Select the background color that will complement your form</h3>
                                        <?php
                                        global $wpdb;
                                        $bg_color_value = get_option('fg_form_bgcolor');
                                        $GoogleMap_iframe = get_option('googleMap_iframe_code');
                                        $address_written = get_option('location_address');
                                        ?>
                                        <input class="color {hash:true,caps:false}" value="<?php echo $bg_color_value; ?>" style="width:250px;" >
                                    </div>

                                    <div class="fg_google_map">
                                        <div class="address_text">
                                            <h3 class="fg_heading">Write here Your Address </h3>
                                            <textarea name="content[html]" cols="60" rows="10"   class="address"  id="address" style="width:500px"> <?php echo $address_written; ?></textarea>     
                                        </div>
                                        <div class="google_map_iframe">
                                            <h3 class="fg_heading">Paste here Iframe code for google map </h3>
                                            <textarea name="content[html]" cols="60" rows="10"   class="googlemap_iframe"  id="googlemap_iframe" style="width:500px"> <?php echo stripslashes($GoogleMap_iframe); ?> </textarea>
                                        </div>
                                        <div class="lati_logi" >
                                            <h3 class="fg_heading" style="width:450px;">OR You can write your address in given input field and get the latitude and longitude OR you can also write latitude and longitude directly in respective fields</h3>
                                            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
                                            <div class="get_lat_lng">                              
                                                <input type="text" id="my-address" style="width:300px;"> 
                                                <div id="getCords" onClick="codeAddress();">Get Lat & Lng</div>
                                            </div>
                                            <label style="margin-right: 25px;"><b>Latitude </b>  </label><input type="text" class="latitude_value" id="latitude_value" name="latitude" value="<?php echo $GoogleMap_latitude = get_option('googleMap_latitude_position'); ?>" style="width:150px;"><br />
                                            <label style="margin-right: 15px;"><b>Longitude </b>  </label><input type="text" class="longitude_value" id="longitude_value" name="longituted" value="<?php echo $GoogleMap_longitude = get_option('googleMap_longitude_position'); ?>" style="width:150px;">
                                        </div>

                                        <label style="margin-right: 32.3px;"><b>Zoom : </b></label><input type="text" class="zoom_level" id="zoom_level" name="zoom" value="<?php echo  $GoogleMap_zoom = get_option('map_zoom_value');?>" style="width:150px;"><br />

                                        <label style="margin-right: 10.3px;"><b>Map Type : </b></label> <select name="map_type" id="map_type" style="width:250px;">
                                            <option value="ROAD">ROAD - Normal,default 2D map</option>
                                            <option value="SATELLITE">SATELLITE - Display satellite images </option>
                                            <option value="HYBRID">HYBRID - Photographic map  + road + city name</option>
                                            <option value="TERRAIN">TERRAIN - Display map with physical feature such as mountain, river ect</option>
                                        </select><br /><br />
                                    </div>

                                    <input id="submit-form" class="fg_embed_code_save button-primary" type="button" value="Save Changes" name="submit_form" style="display:none;">		
                                    <div id="loader_img" align="center" style="margin-left:460px; display:none;">
                                        <img src="<?php echo plugins_url('image/ajax-loader.gif', __FILE__); ?>">
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="fg_group" id="pn_template">
                        <h2>Steps to use Contact Form Integrated With Google Maps Plugin</h2>

                        <div class="fg_section section-text">
                            <h3></h3>
                            <div id="help_txt" style="width:900px;">
                                <img src="<?php echo plugins_url('image/help_img.png', __FILE__); ?>"><br /><br />
                                <div style="font-size:15px;"> <b> Thanks,</br>
                                        FormGet Team</i></b></div>
                            </div>
                        </div>

                    </div>


                    <div class="fg_group" id="pn_contactus">
                        <iframe height='570' allowTransparency='true' frameborder='0' scrolling='no' style='width:100%;border:none'  src='http://www.formget.com/app/embed/form/qQvs-639'>Your Contact </iframe>

                    </div>	

                </div>
                <div class="clear"></div>
            </div>

            <div class="fg_save_bar_top">



            </div>

        </form>
    </div>


    <?php
}

function fg_colorpicker_script() {
    wp_enqueue_script('colorpicker_script', plugins_url('jscolor/jscolor.js', __FILE__), array('jquery'));
    wp_enqueue_script('popup_script', plugins_url('js/popup_script.js', __FILE__), array('jquery'));
}

add_action('init', 'fg_colorpicker_script');

function fg_embeded_script() {
    wp_enqueue_script('embeded_script', plugins_url('js/fg_script.js', __FILE__), array('jquery'));
    wp_localize_script('embeded_script', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('init', 'fg_embeded_script');

function fg_text_ajax_process_request() {
    $text_value = $_POST['value'];
    $form_background_color = $_POST['color'];
    $google_map_iframe_code = $_POST['iframe'];
    $map_latitude_position = $_POST['latitude'];
    $map_longitude_position = $_POST['longitude'];
    $location_address = $_POST['address'];
    $map_zoom_value = $_POST['zoom'];
    $map_type_id = $_POST['map_type'];
    update_option('fg_iframe_embed_code', $text_value);
    update_option('fg_form_bgcolor', $form_background_color);
    update_option('googleMap_iframe_code', $google_map_iframe_code);
    update_option('googleMap_latitude_position', $map_latitude_position);
    update_option('googleMap_longitude_position', $map_longitude_position);
    update_option('location_address', $location_address);
    update_option('map_zoom_value', $map_zoom_value);
    update_option('map_type_id', $map_type_id);
    echo 1;
    die();
}

add_action('wp_ajax_master_response', 'fg_text_ajax_process_request');
add_action('wp_ajax_nopriv_master_response', 'fg_text_ajax_process_request');


if (!function_exists('embeded_code')) {

    function embeded_code() {
        global $wpdb;
        $fg_iframe_form = get_option('fg_iframe_embed_code');
        $string = "iframe";
        $pos = strpos($fg_iframe_form, $string);
        if ($pos == true) {
            echo stripslashes($fg_iframe_form);
        }
    }

}
if (!function_exists('display_iframe_form')) {

    function display_iframe_form() {
        global $wpdb;
        $fg_iframe_form = get_option('fg_iframe_embed_code');
        $form_bg_color = get_option('fg_form_bgcolor');
        $address_of_location = get_option('location_address');
        $GoogleMap_iframe = get_option('googleMap_iframe_code');
        $GoogleMap_latitude = get_option('googleMap_latitude_position');
        $GoogleMap_longitude = get_option('googleMap_longitude_position');
        $GoogleMap_zoom = get_option('map_zoom_value');
        $GoogleMap_type_id = get_option('map_type_id');
        if ($GoogleMap_iframe == "" && $GoogleMap_latitude == "" && $GoogleMap_longitude == "") {
            $part_before_latitude = "23.2500 ";
            $part_before_longitude = "77.4167 ";
        } else {
            $string = "W";
            $strings = "S";

            $lat_pos = strpos($GoogleMap_latitude, $string);
            $lat_position = strpos($GoogleMap_latitude, $strings);
            if ($lat_pos == true || $lat_position == true) {
                $str = "-";
                $add_prefix_in_position_lat = sprintf("%s%s", $str, $GoogleMap_latitude);
                preg_match('/([^°#&%=]+)/', $add_prefix_in_position_lat, $matches);
                $part_before_latitude = $matches[1];
            } else {
                preg_match('/([^°#&%=]+)/', $GoogleMap_latitude, $matches);
                $part_before_latitude = $matches[1];
            }

            $lng_pos = strpos($GoogleMap_longitude, $string);
            $lng_position = strpos($GoogleMap_longitude, $strings);
            if ($lng_pos == true || $lng_position == true) {
                $strs = "-";
                $add_prefix_in_position_lng = sprintf("%s%s", $strs, $GoogleMap_longitude);
                preg_match('/([^°#&%=]+)/', $add_prefix_in_position_lng, $matche);
                $part_before_longitude = $matche[1];
            } else {
                preg_match('/([^°#&%=]+)/', $GoogleMap_longitude, $matche);
                $part_before_longitude = $matche[1];
            }
        }

        $string = "iframe";
        $pos = strpos($fg_iframe_form, $string);
        if ($pos == true) {
        ?>
        <div class="fggm_contac_us_img" id="fggm_contac_us_img" style="display:none"><img src="http://www.formget.com/app/code/contact_tab?c=Contact Us&amp;t_color=ffffff&amp;b_color=7d9f2b&amp;f_size=18" alt="Feedback &amp; Support" style="border:0; background-color: transparent; padding-left:7px; margin:0; padding-top: 40px;"> </div>
        <div id="fggm-box-popup"  style="display:none">
            <div id="fggm_form_show">
                <div id="fg_close_box" ><img class="close_popup_box" src="<?php echo plugins_url('/image/close.png', __FILE__); ?>"/></div>
                <div class="fg_form_area" style="overflow-y: scroll; background-color:<?php echo $form_bg_color; ?>">
        <?php
        echo stripslashes($fg_iframe_form);
        ?>
                </div> 
                    <?php
                    $chech_string = "iframe";
                    $check_position = strpos($GoogleMap_iframe, $chech_string);
                    if ($check_position == true) {
                        ?>
                    <div class="map_heading"> Business Location </div>
                    <div class="contact_address"> <?php echo $address_of_location; ?></div>
                    <div id="googleMap" style=" overflow:scroll; ">

                        <?php
                        echo stripslashes($GoogleMap_iframe);
                        ?> 
                    </div>
                </div>
            </div>

        <?php } else {
            ?>
            <script
                src="http://maps.googleapis.com/maps/api/js?&sensor=false">
            </script>
            <div class="gm_lat" style="color: black; display:none;"> <?php echo $part_before_latitude; ?> </div>
            <div class="gm_lon" style="color: black; display:none;"> <?php echo $part_before_longitude; ?></div>
            <div class="gm_zoom" style="color: black; display:none;"> <?php echo $GoogleMap_zoom; ?></div>
            <div class="gm_type" style="color: black; display:none;"> <?php echo $GoogleMap_type_id; ?></div>
            <div class="map_heading"> Business Address </div>
            <div class="contact_address"><?php echo $address_of_location; ?> </div>
            <div id="googleMap"></div>
            </div>
            </div> 
            <?php
        }
    }
	}
}

add_action('wp_head', 'display_iframe_form');

//schort code function
if (!function_exists('formget_shortcode')) {

    function formget_shortcode($atts, $content = null) {
        extract(shortcode_atts(array(
            'user' => '',
            'formcode' => '',
            'allowTransparency' => true,
            'height' => '500',
            'tab' => ''
                        ), $atts));
        $iframe_formget = '';
        $url = "http://www.formget.com/app/embed/form/" . $formcode;
        if ($tab == 'page') {
            $iframe_formget .="<iframe height='" . $height . "' allowTransparency='true' frameborder='0' scrolling='no' style='width:100%;border:none'  src='" . $url . "' >";
            $iframe_formget .="</iframe>";
            add_filter('widget_text', 'do_shortcode');
            return $iframe_formget;
        }
        if ($tab == 'tabbed') {
            $tabbed_formget = <<<EOD
<script type="text/javascript">
    var sideBar;
    (function(d, t) {
        var s = d.createElement(t),
                options = {
            'tabKey': '{$formcode}',
            'tabtext':'Contact Us',
            'height': '{$height}',
            'position': "",
            'textColor': 'ffffff',
            'tabColor': '7d9f2b',
            'fontSize': '16',
        };
        s.src = 'http://www.formget.com/app/app_data/user_js/widget.js';
        s.onload = s.onreadystatechange = function() {
            var rs = this.readyState;
            if (rs)
                if (rs != 'complete')
                    if (rs != 'loaded')
                        return;
            try {
                sideBar = new buildTabbed();
                sideBar.initializeOption(options);
                sideBar.loadContent();
                sideBar.buildHtml();
            } catch (e) {
            }
        };
        var scr = d.getElementsByTagName(t)[0], par = scr.parentNode;
        par.insertBefore(s, scr);
    })(document, 'script');
</script>
EOD;
            return $tabbed_formget;
        }
    }

}
add_shortcode('formget', 'formget_shortcode');
?>