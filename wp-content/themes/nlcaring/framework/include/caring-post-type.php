<?php
/* Property Custom Post Type */
if( !function_exists( 'create_caring_post_type' ) ){
    function create_caring_post_type(){

      $labels = array(
            'name' => __( 'Call to help','framework'),
            'singular_name' => __( 'Help','framework' ),
            'add_new' => __('Add New','framework'),
            'add_new_item' => __('Add New Help','framework'),
            'edit_item' => __('Edit Help','framework'),
            'new_item' => __('New Help','framework'),
            'view_item' => __('View Help','framework'),
            'search_items' => __('Search Help','framework'),
            'not_found' =>  __('No Help found','framework'),
            'not_found_in_trash' => __('No Help found in Trash','framework'),
            'parent_item_colon' => ''
          );

      $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 5,
            'supports' => array('title','editor','thumbnail','author','comments'),
            'rewrite' => array( 'slug' => __('caring', 'framework') )
      );

      register_post_type('caring',$args);

    }
}
add_action('init', 'create_caring_post_type');


/* Create Property Taxonomies */
/*if( !function_exists( 'build_taxonomies' ) ){
    function build_taxonomies(){
       

        $status_labels = array(
            'name' => __( 'Help Status', 'framework' ),
            'singular_name' => __( 'Help Status', 'framework' ),
            'search_items' =>  __( 'Search Help Status', 'framework' ),
            'popular_items' => __( 'Popular Help Status', 'framework' ),
            'all_items' => __( 'All Help Status', 'framework' ),
            'parent_item' => __( 'Parent Help Status', 'framework' ),
            'parent_item_colon' => __( 'Parent Help Status:', 'framework' ),
            'edit_item' => __( 'Edit Help Status', 'framework' ),
            'update_item' => __( 'Update Help Status', 'framework' ),
            'add_new_item' => __( 'Add New Help Status', 'framework' ),
            'new_item_name' => __( 'New Help Status Name', 'framework' ),
            'separate_items_with_commas' => __( 'Separate Help Status with commas', 'framework' ),
            'add_or_remove_items' => __( 'Add or remove Help Status', 'framework' ),
            'choose_from_most_used' => __( 'Choose from the most used Help Status', 'framework' ),
            'menu_name' => __( 'Help Status', 'framework' )
        );

        register_taxonomy(
            'help-status',
            array( 'caring' ),
            array(
                'hierarchical' => true,
                'labels' => $status_labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => array('slug' => __('help-status', 'framework'))
            )
        );
    }
}
add_action( 'init', 'build_taxonomies', 0 );

*/
/* Add Custom Columns */
if( !function_exists( 'help_edit_columns' ) ){
    function help_edit_columns($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Help Title','framework' ),
            "thumb" => __( 'Thumbnail','framework' ),
            "address" => __('Address','framework'),
            "status" => __('Status','framework'),
        );

        return $columns;
    }
}
add_filter("manage_edit-caring_columns", "help_edit_columns");

if( !function_exists( 'property_custom_columns' ) ){
    function property_custom_columns($column){
        global $post;
		$prefix = 'NO_LIMIT_';
		
        switch ($column)
        {
            case 'thumb':
                if(has_post_thumbnail($post->ID)){
                    ?>
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <?php the_post_thumbnail('post-thumbnail');?>
                    </a>
                    <?php
                }
                else{
                    _e('No Thumbnail','framework');
                }
                break;
            case 'address':
                $address = get_post_meta($post->ID,$prefix.'caring_address',true);
                if(!empty($address)){
                    echo $address;
                }
                else{
                    _e('No Address Provided!','framework');
                }
                break;
            case 'status':
                $status = get_post_meta($post->ID,$prefix.'help_status',true);
                if(!empty($status)){
                    echo $status;
                }
                break;
        }
    }
}
add_action("manage_posts_custom_column", "property_custom_columns");


/*-----------------------------------------------------------------------------------*/
/*	Add Metabox to Display Property Payment Information
/*-----------------------------------------------------------------------------------*/
add_action( 'add_meta_boxes', 'add_payment_meta_box' );

if( !function_exists( 'add_payment_meta_box' ) ){
    function add_payment_meta_box(){
        add_meta_box( 'payment-meta-box', __('Project Requirement', 'framework'), 'payment_meta_box', 'caring', 'normal', 'core' );
    }
}

if( !function_exists( 'payment_meta_box' ) ){
    function payment_meta_box( $post ){

        $values = get_post_custom( $post->ID );
        $not_available  = __('Not Available','framework');

        $txn_id         = isset( $values['txn_id'] ) ? esc_attr( $values['txn_id'][0] ) : $not_available;
        $payment_date   = isset( $values['payment_date'] ) ? esc_attr( $values['payment_date'][0] ) : $not_available;
        $payer_email    = isset( $values['payer_email'] ) ? esc_attr( $values['payer_email'][0] ) : $not_available;
        $first_name     = isset( $values['first_name'] ) ? esc_attr( $values['first_name'][0] ) : $not_available;
        $last_name      = isset( $values['last_name'] ) ? esc_attr( $values['last_name'][0] ) : $not_available;
        $payment_status = isset( $values['payment_status'] ) ? esc_attr( $values['payment_status'][0] ) : $not_available;
        $payment_gross  = isset( $values['payment_gross'] ) ? esc_attr( $values['payment_gross'][0] ) : $not_available;
        $payment_currency  = isset( $values['mc_currency'] ) ? esc_attr( $values['mc_currency'][0] ) : $not_available;

        ?>
        <div class="hproductDetails">
			<p>This project requires thte purchase of non printable items:</p>
			<table width="100%" style="text-align:left;">
				<tbody>
				<tr>
					<th>Name:</th>
					<th>Manufacturer:</th>
					<th>Price:</th>
					<th></th>
				</tr>
				<tr>
					<td>Copper Springs</td>
					<td>Aztec Solutions</td>
					<td class="price">$3.95</td>
					<td><a href="#">Take me there</a></td>
				</tr>
				<tr>
					<td>Soft gel shoe insert</td>
					<td>Shoeis</td>
					<td class="price">$8.42</td>
					<td><a href="#">Take me there</a></td>
				</tr>
				<tr>
					<td>Laces</td>
					<td>Shoel Lace Express</td>
					<td class="price">$2.14</td>
					<td><a href="#">Take me there</a></td>
				</tr>
			</tbody></table>
		</div>
        <?php
    }
}

?>