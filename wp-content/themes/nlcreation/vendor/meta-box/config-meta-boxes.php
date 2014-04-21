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
$prefix = 'creation_';

global $meta_boxes;

$meta_boxes = array();



// 4th meta box
$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'creation_instructions',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __('Instructions','framework'),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'product' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'low',

    // List of meta fields
    'fields' => array(
	   array(
			'id'        => "{$prefix}instruction",
			'type'      => 'wysiwyg',
			'cols'		=> '10',
			'rows'	=> '2'
		),
	  
    )
);


function product_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( isset( $meta_box['only_on'] ) && ! esf_maybe_include( $meta_box['only_on'] ) ) {
				continue;
			}

			new RW_Meta_Box( $meta_box );
		}
	}
}

add_action( 'admin_init', 'product_register_meta_boxes' );

?>