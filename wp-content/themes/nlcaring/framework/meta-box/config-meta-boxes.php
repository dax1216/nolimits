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
            'name'             => __('Help Gallery Images','framework'),
            'id'               => "{$prefix}caring_images",
            'desc' => __('Provide images for gallery on call to help detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'),
            'type'             => 'image_advanced',
            'max_file_uploads' => 48
        ),
		
		
		  array(
            'name'             => __('Hero Gallery Images','framework'),
            'id'               => "{$prefix}caring_hero_images",
            'desc' => __('Provide images for gallery on call to help detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'),
            'type'             => 'image_advanced',
            'max_file_uploads' => 48
        ),
		
		
		 array(
            'name'             => __('Badge','framework'),
            'id'               => "{$prefix}caring_badge",
            'desc' => __('Image should have minimum width of 137px and minimum height of 137px. ( Bigger image will be cropped automatically )','framework'),
            'type'             => 'image',
			'max_file_uploads' => 1
        ),
   
   
        array(
            'id'        => "{$prefix}caring_address",
            'name'      => __('Location','framework'),
            'desc'      => __('Provide location address.','framework'),
            'type'      => 'text',
            'std'       => 'Cebu City, Philippines'
        ),
        array(
            'id'            => "{$prefix}caring_location",
            'name'          => __('Location at Google Map*','framework'),
            'desc'          => __('Drag the google map marker to point your help location. You can also use the address field above to search for your help location.','framework'),
            'type'          => 'map',
            'std'           => '10.315699,123.885437',   // 'latitude,longitude[,zoom]' (zoom is optional)
            'style'         => 'width: 400px; height: 200px',
            'address_field' => "{$prefix}caring_address",         // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
        ),		
		
		 array(
            'id'        => "{$prefix}postal_location",
            'name'      => __('Postal Location','framework'),
            'desc'      => __('Provide Postal location address.','framework'),
            'type'      => 'text',
        ),
		array (
				'id'			=>"{$prefix}help_status",
				'name'          => __('Help Status','framework'),
				'type'          => 'select',
				 'std'       => 'Call to help',
				'options' => array(
					1 => __( 'Call to help ', 'framework' ),
					2 => __( 'Journey', 'framework' ),
					3 => __( 'Hero Rally', 'framework' )
				)			
			
			),
			
	   array(
			'id'        => "{$prefix}video_url",
			'name'      => __('Virtual Tour Video URL','framework'),
			'desc'      => __('Provide instruction video URL. Theme supports YouTube, Vimeo, SWF File and MOV File','framework'),
			'type'      => 'text'
		),
      
	   array(
			'id'        => "{$prefix}instruction",
			'name'      => __('Instruction','framework'),
			'type'      => 'wysiwyg'
		),
		
		 array(
            'id'        => "{$prefix}caring_slogan",
            'name'      => __('Hero Slogan','framework'),
            'type'      => 'text',
        ),
		
				 array(
            'id'        => "{$prefix}caring_slogan_text",
            'name'      => __('Hero Rally Sloan Description','framework'),
            'type'      => 'textarea',
        ),
		
		 array(
            'name'             => __('Hero Rally Images','framework'),
            'id'               => "{$prefix}caring_hero_images",
            'desc' => __('Provide images for gallery on call to help detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'),
            'type'             => 'image_advanced',
            'max_file_uploads' => 48
        ),
	  
    )
);



// Project Requirements

$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'gallery-of-love',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Gallery','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'gallery_of_love' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'low',

    // List of meta fields
    'fields' => array(
        array(
            'id'               => "{$prefix}love_image_attached",
            'desc' => __('Upload Image','framework'),
            'type'             => 'thickbox_image',
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