<?php
add_action('init','of_options');

if (!function_exists('of_options'))
{

    function of_options()
    {

        /*
        *	Theme Shortname
        */
        $themename = "theme";
        $shortname = "theme";

        /*
        *	Populate the options array
        */
        global $tt_options;

        $tt_options = get_option('of_options');

        /*
        *	Access the WordPress Pages via an Array
        */
        $tt_pages = array();

        $tt_pages_obj = get_pages('sort_column=post_parent,menu_order');

        foreach ($tt_pages_obj as $tt_page)
        {
            $tt_pages[$tt_page->ID] = $tt_page->post_name;
        }

        $tt_pages_tmp = array_unshift($tt_pages, "Select a page:" );


        /*
        *	Access the WordPress Categories via an Array
        */
        $tt_categories = array();
        $tt_categories_obj = get_categories('hide_empty=0');
        foreach ($tt_categories_obj as $tt_cat)
        {
            $tt_categories[$tt_cat->term_id] = $tt_cat->name;
        }
        $categories_tmp = array_unshift($tt_categories, "Select a category:");

        /*
		*	Access the WordPress Tags via an Array
		*/
        $tags_array = array();
        $tags_objects = get_tags('hide_empty=0');
        foreach ($tags_objects as $tag_inst)
        {
            $tags_array[$tag_inst->term_id] = $tag_inst->name;
        }
        $tags_tmp = array_unshift($tags_array, __('Select a Tag','framework'));

  


        /*
        *	Access the property-type terms via an Array
        */
        $types_array = array();
        $type_terms = get_terms('property-type');
        foreach ($type_terms as $type_term){
            $types_array[$type_term->slug] = $type_term->name;
        }

        /*
        *	Numbers Array
        */
        $numbers_array = array("1","2","3","4","5","6","7","8","9","10");
		$numbers_array_zero = array("0","1","2","3","4","5","6","7","8","9","10");

        /*
        *	Sample Advanced Array - The actual value differs from what the user sees
        */
        $sample_advanced_array = array("image" => "The Image","post" => "The Post");

        /*
        *	Folder Paths for "type" => "images"
        */
        $sampleurl =  get_template_directory_uri() . '/framework/admin/images/sample-layouts/';


        /*-----------------------------------------------------------------------------------*/
        /* Create The Custom Theme Options Panel
        /*-----------------------------------------------------------------------------------*/
        $options = array(); // do not delete this line - sky will fall


        /* Option Page - Header Options */
        $options[] = array( "name" => __('Header','framework'),
            "id" => $shortname."_header_heading",
            "type" => "heading");

        $options[] = array( "name" => __('Logo','framework'),
            "desc" => __('Upload logo for your Website.','framework'),
            "id" => $shortname."_sitelogo",
            "std" => "",
            "type" => "upload");

        $options[] = array( "name" => __('Favicon','framework'),
            "desc" => __('Upload a 16px by 16px PNG image that will represent your website favicon.','framework'),
            "id" => $shortname."_favicon",
            "std" => "",
            "type" => "upload");

        $options[] = array( "name" => __('Tracking Code','framework'),
            "desc" => __('Paste Google Analytics (or other) tracking code here.','framework'),
            "id" => $shortname."_google_analytics",
            "std" => "",
            "type" => "textarea");





        /* Home Page Options */
        $options[] = array( "name" => __('Home','framework'),
            "id" => $shortname."_home_heading",
            "type" => "heading");

        $options[] = array( "name" => __('What you want to display in area below header on homepage ?','framework'),
            "desc" => __('','framework'),
            "id" => $shortname . "_homepage_module",
            "std" => "help-no-banner",
            "type" => "radio",
            "options" => array(
                'help-no-banner' => __('Nope','framework'),
                'help-static-banner' => __('Display a static banner','framework'),
                'help-slider' => __('Display a slider from help content ( For future requrest )','framework'),
            ));


        $options[] = array( "name" => __('Static Banner Title','framework'),
            "id" => $shortname."_banner_title",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('Static Banner Text','framework'),
            "id" => $shortname."_banner_text",
            "std" => "",
            "type" => "textarea");
		
		$options[] = array( "name" => __('Static Banner Button Text','framework'),
            "id" => $shortname."_banner_link_text",
            "std" => "",
            "type" => "text");
		
		$options[] = array( "name" => __('Static Banner Button Link','framework'),
            "id" => $shortname."_banner_link",
            "std" => "",
            "type" => "text");


        $options[] = array( "name" => __('What Properties you want to display on Homepage ?','framework'),
            "desc" => __('','framework'),
            "id" => $shortname."_home_properties",
            "std" => "recent",
            "type" => "radio",
            "options" => array(
                'recent' => __('Recent Help','framework'),
                'based-on-selection' => __('Properties based on selected Types, Statuses and Cities.','framework')
            ));


      
       

        $options[] = array( "name" => __('Sort Help By ?','framework'),
            "desc" => __('','framework'),
            "id" => $shortname."_sorty_by",
            "std" => "recent",
            "type" => "radio",
            "options" => array(
                'recent' => __('Time - Recent First','framework'),
                'low-to-high' => __('Price - Low to High','framework'),
                'high-to-low' => __('Price - High to Low','framework')
            ));

        $options[] = array( "name" => __('Number of Help to display on Homepage','framework'),
            "id" => $shortname."_help_on_home",
            "std" => "8",
            "type" => "select",
            "options" => array(4,8,12,16,20,24,28));


        /* Call to help Options */
        $options[] = array( "name" => __('Call to help','framework'),
            "id" => $shortname."_property_heading",
            "type" => "heading");

        $property_detail_option = __( 'Do you want to display %s on property detail page ?', 'framework' );

        $options[] = array( "name" => sprintf( $property_detail_option, __('video','framework') ),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_display_video",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => sprintf( $property_detail_option, __('google map','framework') ),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_display_google_map",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => sprintf( $property_detail_option, __('agent information','framework') ),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_display_agent_info",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => sprintf( $property_detail_option, __('similar properties','framework') ),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_display_similar_properties",
            "std" => "true",
            "type" => "checkbox");




        /* Option Page - Gallery */
        $options[] = array( "name" => __('Galleries','framework'),
            "type" => "heading");

        $options[] = array( "name" => __('Banner Title','framework'),
            "desc" => __('Provide the Banner Title for Gallery Pages.','framework'),
            "id" => $shortname.'_gallery_banner_title',
            "std" => __('Properties Gallery', 'framework'),
            "type" => "text");

        $options[] = array( "name" => __('Banner Sub Title','framework'),
            "desc" => __('Provide the Banner Sub Title for Gallery Pages.','framework'),
            "id" => $shortname.'_gallery_banner_sub_title',
            "std" => __('Look for your desired property more efficiently', 'framework'),
            "type" => "text");




        /* Option Page - General */
        $options[] = array( "name" => __('General','framework'),
            "id" => $shortname."_general_heading",
            "type" => "heading");

        $options[] = array( "name" => __('What you want to display in area below header on Listing & Taxonomy pages ?','framework'),
            "desc" => __('','framework'),
            "id" => $shortname . "_listing_module",
            "std" => "simple-banner",
            "type" => "radio",
            "options" => array(
                'properties-map' => __('Display Google Map with Properties Markers','framework'),
                'simple-banner' => __('Display Simple Image Based Banner','framework')
            ));

        $options[] = array( "name" => __('Number of Properties to display in Property Listing Template','framework'),
            "desc" => '',
            "id" => $shortname."_number_of_properties",
            "std" => "3",
            "type" => "select",
            "options" => array(3,6,9,12,15,18,21,24,27));

        $options[] = array( "name" => __('Lightbox Plugin','framework'),
            "desc" => __('Select the lightbox plugin that you want to use','framework'),
            "id" => $shortname."_lightbox_plugin",
            "std" => "swipebox",
            "type" => "radio",
            "options" => array(
                'swipebox'      => __('Swipebox Plugin','framework'),
                'pretty-photo'  => __('Pretty Photo Plugin','framework')
            ));




        $options[] = array( "name" => __('Do you want to display reCAPTCHA in contact forms ?','framework'),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_show_reCAPTCHA",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => __('reCAPTCHA Public Key','framework'),
            "desc" => __('Get reCAPTCHA public and private keys for your website by <a href="http://www.google.com/recaptcha/whyrecaptcha" target="_blank">signing up here</a> ','framework'),
            "id" => $shortname."_recaptcha_public_key",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('reCAPTCHA Private Key','framework'),
            "desc" => __('','framework'),
            "id" => $shortname."_recaptcha_private_key",
            "std" => "",
            "type" => "text");


        /* Option Page - Contact */
        $options[] = array( "name" => __('Contact','framework'),
            "id" => $shortname."_contactus_heading",
            "type" => "heading");

        $options[] = array( "name" => __('Do you want to show Google Map on contact page ?','framework'),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_show_contact_map",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => __('Google Map Latitude','framework'),
            "desc" => __("Provide Google Map Latitude",'framework'),
            "id" => $shortname."_map_lati",
            "std" => "-37.817917",
            "type" => "text");

        $options[] = array( "name" => __('Google Map Longitude','framework'),
            "desc" => __("Provide Google Map Longitude",'framework'),
            "id" => $shortname."_map_longi",
            "std" => "144.965065",
            "type" => "text");

        $options[] = array( "name" => __('Google Map Zoom','framework'),
            "desc" => __("Provide Google Map Zoom Level. Example: 17",'framework'),
            "id" => $shortname."_map_zoom",
            "std" => "17",
            "type" => "text");

        $options[] = array( "name" => __('Do you want to show Contact Details Section on contact page ?','framework'),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_show_details",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => __('Contact Details Section Title','framework'),
            "desc" => __("Provide Title for contact details section.",'framework'),
            "id" => $shortname."_contact_details_title",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('Contact Address','framework'),
            "desc" => __("Provide address that will be displayed in contact details section.",'framework'),
            "id" => $shortname."_contact_address",
            "std" => "",
            "type" => "textarea");

        $options[] = array( "name" => __('Cell Number','framework'),
            "desc" => __("Provide Cell Number that will be displayed in contact details section.",'framework'),
            "id" => $shortname."_contact_cell",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('Phone Number','framework'),
            "desc" => __("Provide Phone Number that will be displayed in contact details section.",'framework'),
            "id" => $shortname."_contact_phone",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('Email Address','framework'),
            "desc" => __("Provide Email Address that will be displayed in contact details section.",'framework'),
            "id" => $shortname."_contact_display_email",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __('Contact Form Heading','framework'),
            "desc" => __("Provide heading for contact form.",'framework'),
            "id" => $shortname."_contact_form_heading",
            "std" => __("Send us a message", "framework"),
            "type" => "text");

        $options[] = array( "name" => __('Contact Email','framework'),
            "desc" => __("Provide target email address that will receive messages from contact form.",'framework'),
            "id" => $shortname."_contact_email",
            "std" => "",
            "type" => "text");



        /* Option Page - Footer */
        $options[] = array( "name" => __('Footer','framework'),
            "id" => $shortname."_footer_heading",
            "type" => "heading");
  

        $options[] = array( "name" => __('Footer Copyright Text','framework'),
            "desc" => __("Enter Footer Copyright Text here.",'framework'),
            "id" => $shortname."_copyright_text",
            "std" => "",
            "type" => "textarea");

        $options[] = array( "name" => __('Footer Designed by Text','framework'),
            "desc" => __("Enter Footer Designed by Text here.",'framework'),
            "id" => $shortname."_designed_by_text",
            "std" => "",
            "type" => "textarea");

        /* Option Page - Members */
        $options[] = array( "name" => __('Members','framework'),
            "id" => $shortname."_members_heading",
            "type" => "heading");

        $options[] = array( "name" => __('Do you want to enable header navigation for user Login and Register ?','framework'),
            "desc" => __('Yes','framework'),
            "id" => $shortname."_enable_user_nav",
            "std" => "true",
            "type" => "checkbox");

        $options[] = array( "name" => __('Login & Register Page URL','framework'),
            "desc" => __('Create a Page Using Login & Register Template and Provide its URL here.','framework'),
            "id" => $shortname."_login_url",
            "std" => '',
            "type" => "text");

        $options[] = array( "name" => __('Submit Call to Help Page URL','framework'),
            "desc" => __('Create a Page Using Submit Call to Help Template and Provide its URL here.','framework'),
            "id" => $shortname."_submit_url",
            "std" => '',
            "type" => "text");

        $options[] = array( "name" => __('Message After Successful Submit ?','framework'),
            "desc" => "",
            "id" => $shortname."_submit_message",
            "std" => __('Thanks for Submitting a call to help!','framework'),
            "type" => "text");

        $options[] = array( "name" => __('Submit Notice Email','framework'),
            "desc" => __("This email address will receive a message as any user submits a property.",'framework'),
            "id" => $shortname."_submit_notice_email",
            "std" => "",
            "type" => "text");

        $options[] = array( "name" => __( 'My Properties Page URL','framework' ),
            "desc" => __('Create a Page Using My Properties Template and Provide its URL here.','framework'),
            "id" => $shortname."_my_properties_url",
            "std" => '',
            "type" => "text");

       

        $options = apply_filters('framework_theme_options',$options);

        update_option('of_template',$options);
        update_option('of_themename',$themename);
        update_option('of_shortname',$shortname);

    }
}

?>