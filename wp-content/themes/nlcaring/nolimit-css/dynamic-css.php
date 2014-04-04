<?php
if( !function_exists( 'generate_dynamic_css' ) ){
    function generate_dynamic_css(){

        // Header
        $theme_header_bg_color = get_option('theme_header_bg_color');
        $theme_header_text_color = get_option('theme_header_text_color');
        $theme_header_link_hover_color = get_option('theme_header_link_hover_color');
        $theme_header_border_color = get_option('theme_header_border_color');

        // Drop Down Menu
        $theme_main_menu_text_color = get_option('theme_main_menu_text_color');
        $theme_menu_bg_color = get_option('theme_menu_bg_color');
        $theme_menu_text_color = get_option('theme_menu_text_color');
        $theme_menu_hover_bg_color = get_option('theme_menu_hover_bg_color');

        // Phone Icon and Number
        $theme_phone_bg_color = get_option('theme_phone_bg_color');
        $theme_phone_text_color = get_option('theme_phone_text_color');
        $theme_phone_icon_bg_color = get_option('theme_phone_icon_bg_color');

        $dynamic_css = array(

                            //Header background color
                            array(
                                'elements'	=>	'.header-wrapper',
                                'property'	=>	'background-color',
                                'value'		=> 	$theme_header_bg_color
                            ),
                            //Header Text color
                            array(
                                'elements'	=>	'.header-wrapper, #contact-email, #contact-email a, .user-nav a, .social_networks li a',
                                'property'	=>	'color',
                                'value'		=> 	$theme_header_text_color
                            ),
                            //Header Link Hover color
                            array(
                                'elements'	=>	'#contact-email a:hover, .user-nav a:hover',
                                'property'	=>	'color',
                                'value'		=> 	$theme_header_link_hover_color
                            ),
                            //Header Border color
                            array(
                                'elements'	=>	'#header-top, .social_networks li a, .user-nav a',
                                'property'	=>	'border-color',
                                'value'		=> 	$theme_header_border_color
                            ),

                            //Drop Down Menu Text color
                            array(
                                'elements'	=>	'.main-menu ul li a',
                                'property'	=>	'color',
                                'value'		=> 	$theme_main_menu_text_color
                            ),
                            //Drop Down Menu background color
                            array(
                                'elements'	=>	'.main-menu ul li.current-menu-ancestor > a, .main-menu ul li.current-menu-parent > a, .main-menu ul li.current-menu-item > a, .main-menu ul li.current_page_item > a, .main-menu ul li:hover > a, .main-menu ul li ul, .main-menu ul li ul li ul',
                                'property'	=>	'background-color',
                                'value'		=> 	$theme_menu_bg_color
                            ),
                            //Drop Down Menu Text color
                            array(
                                'elements'	=>	'.main-menu ul li.current-menu-ancestor > a, .main-menu ul li.current-menu-parent > a, .main-menu ul li.current-menu-item > a, .main-menu ul li.current_page_item > a, .main-menu ul li:hover > a, .main-menu ul li ul, .main-menu ul li ul li a, .main-menu ul li ul li ul, .main-menu ul li ul li ul li a',
                                'property'	=>	'color',
                                'value'		=> 	$theme_menu_text_color
                            ),
                            //Drop Down Menu hover background color
                            array(
                                'elements'	=>	'.main-menu ul li ul li:hover > a, .main-menu ul li ul li ul li:hover > a',
                                'property'	=>	'background-color',
                                'value'		=> 	$theme_menu_hover_bg_color
                            )

                        );


        $dynamic_css_above_980px = array(
            //Phone Number background color
            array(
                'elements'	=>	'.contact-number, .contact-number .outer-strip',
                'property'	=>	'background-color',
                'value'		=> 	$theme_phone_bg_color
            ),
            //Phone Number background color
            array(
                'elements'	=>	'.contact-number',
                'property'	=>	'color',
                'value'		=> 	$theme_phone_text_color
            ),
            //Phone Icon background color
            array(
                'elements'	=>	'.contact-number .fa-phone',
                'property'	=>	'background-color',
                'value'		=> 	$theme_phone_icon_bg_color
            )
        );




        $prop_count = count($dynamic_css);

        if($prop_count > 0)
        {
            echo "<style type='text/css' id='dynamic-css'>\n\n";

            foreach($dynamic_css as $css_unit )
            {
                if(!empty($css_unit['value']))
                {
                    echo $css_unit['elements']."{\n";
                    echo $css_unit['property'].":".$css_unit['value'].";\n";
                    echo "}\n\n";
                }
            }

            /* CSS For min width 980px */
            echo "@media (min-width: 980px) {\n";
            foreach($dynamic_css_above_980px as $css_unit )
            {
                if(!empty($css_unit['value']))
                {
                    echo $css_unit['elements']."{\n";
                    echo $css_unit['property'].":".$css_unit['value'].";\n";
                    echo "}\n\n";
                }
            }
            echo "}\n";

            echo '</style>';
        }
    }
}

add_action('wp_head', 'generate_dynamic_css');