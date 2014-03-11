<?php
/**
 * File Name: config-meta-boxes.php
 *
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 *
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'NO_LIMIT_';

global $meta_boxes;

$meta_boxes = array();



// 4th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'caring_details',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Caring Details','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'caring' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'high',

    // List of meta fields
    'fields' => array(
        // PLUPLOAD IMAGE UPLOAD (WP 3.3+)
        array(
            'name'             => __('Property Gallery Images','framework'),
            'id'               => "{$prefix}caring_images",
            'desc' => __('Provide images for gallery on property detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'),
            'type'             => 'image_advanced',
            'max_file_uploads' => 48
        ),
        array(
            'id'        => "{$prefix}caring_price",
            'name'      => __('Property Price','framework'),
            'desc'      => __('Provide Sale OR Rent Price. ( Plesae only provide digits ) Example Value: 435000','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_price_postfix",
            'name'      => __('Price Postfix Text','framework'),
            'desc'      => __('Text provided here will appear after price. ( You can also leave it empty ) Example Value: Per Month','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_size",
            'name'      => __('Property Size','framework'),
            'desc'      => __('Provide size ( Please only provide digits ) Example Value: 2500','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_size_postfix",
            'name'      => __('Size Postfix Text','framework'),
            'desc'      => __('Text provided here will appear after size. ( You can also leave it empty ) Example Value: Sq Ft','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_bedrooms",
            'name'      => __('Bedrooms','framework'),
            'desc'      => __('Provide number of bedrooms. Example Value: 4','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_bathrooms",
            'name'      => __('Bathrooms','framework'),
            'desc'      => __('Provide number of bathrooms. Example Value: 2','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_garage",
            'name'      => __('Garages','framework'),
            'desc'      => __('Provide number of garages. Example Value: 1','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_id",
            'name'      => __('Property ID','framework'),
            'desc'      => __('Text provided here will be used to search the property directly. ( You can also leave it empty )','framework'),
            'type'      => 'text',
            'std'       => ""
        ),
        array(
            'id'        => "{$prefix}caring_address",
            'name'      => __('Property Address','framework'),
            'desc'      => __('Provide property address.','framework'),
            'type'      => 'text',
            'std'       => '1903 Hollywood Boulevard, Hollywood, FL 33020, USA'
        ),
        array(
            'id'            => "{$prefix}caring_location",
            'name'          => __('Property Location at Google Map*','framework'),
            'desc'          => __('Drag the google map marker to point your property location. You can also use the address field above to search for your property.','framework'),
            'type'          => 'map',
            'std'           => '26.011812,-80.14524499999999,15',   // 'latitude,longitude[,zoom]' (zoom is optional)
            'style'         => 'width: 600px; height: 400px',
            'address_field' => "{$prefix}caring_address",         // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
        ),
        array(
            'id'        => "{$prefix}tour_video_url",
            'name'      => __('Virtual Tour Video URL','framework'),
            'desc'      => __('Provide virtual tour video URL. Theme supports YouTube, Vimeo, SWF File and MOV File','framework'),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Virtual Tour Video Image','framework'),
            'id'        => "{$prefix}tour_video_image",
            'desc'      => __('Provide the image that will be displayed as place holder and when a user clicks over it the video will be opened in a lightbox. You must provide this image as otherwise the video will not be displayed on property details page. Image should have minimum width of 818px and minimum height 417px. Bigger size images will be cropped automatically.','framework'),
            'type'      => 'image_advanced',
            'max_file_uploads' => 1
        ),
        array(
            'name'	    => __('Mark this Property as Featured', 'framework'),
            'desc'      => __('Marking this property featured will display it in featured properties sections across the theme.', 'framework'),
            'id'		=> "{$prefix}featured",
            'type'		=> 'checkbox',
            'std'		=> 1
        ),
        array(
            'name'      => __( 'Add in Homepage Slider', 'framework' ),
            'desc'      => __('Do you want to add this property in Homepage Slider ? If Yes, Then you also need to provide slider image below.', 'framework'),
            'id'        => "{$prefix}add_in_slider",
            'type'      => 'radio',
            'std'       => 'no',
            'options' => array(
                'yes' => __( 'Yes ', 'framework' ),
                'no' => __( 'No', 'framework' )
            )
        ),
        array(
            'name'      => __('Slider Image','framework'),
            'id'        => "{$prefix}slider_image",
            'desc'      => __('Provide the image that will be displayed in Homepage Slider. The recommended image size is 2000px by 700px. You can use bigger or little smaller image but try to keep the same height to width ratio and use the exactly same size images for all properties that will be added in slider.','framework'),
            'type'      => 'image_advanced',
            'max_file_uploads' => 1
        ),
      
    )
);


// 5th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'partners-meta-box',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Featured Patners Meta','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'partners' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'high',

    // List of meta fields
    'fields' => array(
        array(
            'name'             => __('Partner Url','framework'),
            'id'               => "{$prefix}partner_url",
            'desc' => __('Paste here Partner Website link','framework'),
            'type'             => 'text',
        )
    )
);




// 6th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'agent-meta-box',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Provide Related Information','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'agent' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'high',

    // List of meta fields
    'fields' => array(
        array(
            'name'      => __('Email Address','framework'),
            'id'        => "{$prefix}agent_email",
            'desc'      => __("Provide Agent's Email Address. Agent related messages from contact form on property details page, will be sent on this email address.","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Mobile Number','framework'),
            'id'        => "{$prefix}mobile_number",
            'desc'      => __("Provide Agent's mobile number","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Office Number','framework'),
            'id'        => "{$prefix}office_number",
            'desc'      => __("Provide Agent's office number","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Fax Number','framework'),
            'id'        => "{$prefix}fax_number",
            'desc'      => __("Provide Agent's fax number","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Facebook URL','framework'),
            'id'        => "{$prefix}facebook_url",
            'desc'      => __("Provide Agent's Facebook URL","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Twitter URL','framework'),
            'id'        => "{$prefix}twitter_url",
            'desc'      => __("Provide Agent's Twitter URL","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Google Plus URL','framework'),
            'id'        => "{$prefix}google_plus_url",
            'desc'      => __("Provide Agent's Google Plus URL","framework"),
            'type'      => 'text'
        ),
        array(
            'name'      => __('LinkedIn URL','framework'),
            'id'        => "{$prefix}linked_in_url",
            'desc'      => __("Provide Agent's LinkedIn URL","framework"),
            'type'      => 'text'
        )
    )
);


// 7th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'banner-meta-box',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Top Banner Area Settings','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'page','agent' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'high',

    // List of meta fields
    'fields' => array(
        array(
            'name'      => __('Banner Title','framework'),
            'id'        => "{$prefix}banner_title",
            'desc'      => __('Please provide the Banner Title, Otherwise the Page Title will be displayed in its place.','framework'),
            'type'      => 'text'
        ),
        array(
            'name'      => __('Banner Sub Title','framework'),
            'id'        => "{$prefix}banner_sub_title",
            'desc'      => __('Please provide the Banner Sub Title.','framework'),
            'type'      => 'textarea',
            'cols'      => '20',
            'rows'      => '2'
        ),
        array(
            'name'      => __('Banner Image','framework'),
            'id'        => "{$prefix}page_banner_image",
            'desc'      => __('Please upload the Banner Image. Otherwise the default banner image from theme options will be displayed.','framework'),
            'type'      => 'image_advanced',
            'max_file_uploads' => 1
        )
    )
);

// 8th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'property-banner-meta-box',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Top Banner','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'property' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'low',

    // List of meta fields
    'fields' => array(
        array(
            'name'      => __('Banner Image','framework'),
            'id'        => "{$prefix}page_banner_image",
            'desc'      => __('Please upload the Banner Image. Otherwise the default banner image from theme options will be displayed.','framework'),
            'type'      => 'image_advanced',
            'max_file_uploads' => 1
        )
    )
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function NO_LIMIT_register_meta_boxes()
{
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;

    global $meta_boxes;
    $meta_boxes = apply_filters('framework_theme_meta',$meta_boxes);
    foreach ( $meta_boxes as $meta_box ){
        new RW_Meta_Box( $meta_box );
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'NO_LIMIT_register_meta_boxes' );

?>