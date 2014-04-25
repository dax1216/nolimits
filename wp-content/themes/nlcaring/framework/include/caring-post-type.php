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

/*Gallery of Love Post type*/

if( !function_exists( 'create_gallery_of_love_post_type' ) ){
    function create_gallery_of_love_post_type(){

      $labels = array(
            'name' => __( 'Gallery Of Love','framework'),
            'singular_name' => __( 'Image','framework' ),
            'add_new' => __('Add New','framework'),
            'add_new_item' => __('Add New Image','framework'),
            'edit_item' => __('Edit Image','framework'),
            'new_item' => __('New Image','framework'),
            'view_item' => __('View Image','framework'),
            'search_items' => __('Search Image','framework'),
            'not_found' =>  __('No Image found','framework'),
            'not_found_in_trash' => __('No Image found in Trash','framework'),
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
            'supports' => array('title'),
            'rewrite' => array( 'slug' => __('gallery_of_love', 'framework') )
      );

      register_post_type('gallery_of_love',$args);

    }
}
add_action('init', 'create_gallery_of_love_post_type');



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
                        <?php the_post_thumbnail('thumbnail');?>
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
                show_status();
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
		$prefix = 'NO_LIMIT_';
	
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
		//echo json_encode($values);

        ?>
        <div class="hproductDetails">
			<script type="text/javascript">
				jQuery(document).ready(function(){	
					jQuery('#add_requirement').click(function(evt){
						evt.preventDefault();
						txtnum = jQuery('#txtnum').val();
						
						jQuery('#tbodyproject').append('<tr class="trproj_'+txtnum+'"><td><input id="pname_'+txtnum+'" name="pname_'+txtnum+'" type="text" class="" title="" value="" /></td><td><input id="pmanuf_'+txtnum+'" name="pmanuf_'+txtnum+'" type="text" class="" title="" value="" /></td><td class="price"><input id="pprice_'+txtnum+'" name="pprice_'+txtnum+'" type="text" class="" title="" value="" /></td><td><input id="plink_'+txtnum+'" name="plink_'+txtnum+'" type="text" class="" title="" value="" /></td><td><a id="apr_'+txtnum+'"  class="del_proj" rel="trproj_'+txtnum+'" href="#">Delete</a></td></tr>');
						
						txtnum++;
						jQuery('#txtnum').val(txtnum);
						
					});
					
					jQuery('#tbodyproject').on('click', '.del_proj', function(evt){
						evt.preventDefault();
						
						rel = jQuery(this).attr('rel');
						jQuery('.'+rel).remove();
						
						txtnum = jQuery('#txtnum').val();
						rel_val = rel.substring(7, rel.length);
						
						for(i_rel = rel_val; i_rel < txtnum; i_rel++) {
							i_rel = parseInt(i_rel);
							
							//change the anchor tag delete rel name
							jQuery('.trproj_'+(i_rel+1)+' td #apr_'+(i_rel+1)).attr('rel','trproj_'+i_rel);
							jQuery('.trproj_'+(i_rel+1)+' td #apr_'+(i_rel+1)).attr('id','apr_'+i_rel);
							//change plink
							jQuery('.trproj_'+(i_rel+1)+' td #plink_'+(i_rel+1)).attr('name','plink_'+i_rel);
							jQuery('.trproj_'+(i_rel+1)+' td #plink_'+(i_rel+1)).attr('id','plink_'+i_rel);
							//change pprice
							jQuery('.trproj_'+(i_rel+1)+' td #pprice_'+(i_rel+1)).attr('name','pprice_'+i_rel);
							jQuery('.trproj_'+(i_rel+1)+' td #pprice_'+(i_rel+1)).attr('id','pprice_'+i_rel);
							//change pmanuf
							jQuery('.trproj_'+(i_rel+1)+' td #pmanuf_'+(i_rel+1)).attr('name','pmanuf_'+i_rel);
							jQuery('.trproj_'+(i_rel+1)+' td #pmanuf_'+(i_rel+1)).attr('id','pmanuf_'+i_rel);
							//change pname
							jQuery('.trproj_'+(i_rel+1)+' td #pname_'+(i_rel+1)).attr('name','pname_'+i_rel);
							jQuery('.trproj_'+(i_rel+1)+' td #pname_'+(i_rel+1)).attr('id','pname_'+i_rel);
							//change trproj
							jQuery('.trproj_'+(i_rel+1)).attr('class','trproj_'+i_rel);
						}
						
						txtnum = parseInt(txtnum);
						if(txtnum != 0) {
							jQuery('#txtnum').val(txtnum-1);
						}
					});
					
				});
			</script>
			<?php  if(isset($values['NO_LIMIT_txtnum'][0])): ?>
				<input id="txtnum" name="txtnum" type="hidden" class="" title="" value="<?php echo $values['NO_LIMIT_txtnum'][0]; ?>" />
			<?php else: ?>
				<input id="txtnum" name="txtnum" type="hidden" class="" title="" value="1" />
			<?php endif; ?>
			<p>This project requires thte purchase of non printable items:</p>
			<table width="100%" style="text-align:left;">
				<thead>
					<tr>
						<th>Name:</th>
						<th>Manufacturer:</th>
						<th>Price:</th>
						<th>Link:</th>
					</tr>
				</thead>
				<tbody id="tbodyproject">
					<?php  if(empty($values['NO_LIMIT_txtnum'][0]) or  $values['NO_LIMIT_txtnum'][0] == '1') { ?>
						<tr class="trproj_0">
							<td>
								<input id="pname_0" name="pname_0" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pname_0'][0]; ?>" />
							</td>
							<td>
								<input id="pmanuf_0" name="pmanuf_0" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pmanuf_0'][0]; ?>" />
							</td>
							<td class="price">
								<input id="pprice_0" name="pprice_0" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pprice_0'][0]; ?>" />
							</td>
							<td>
								<input id="plink_0" name="plink_0" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_plink_0'][0]; ?>" />
							</td>
							<td>
								<a id="apr_0" class="del_proj" rel="trproj_0" href="#">Delete</a>
							</td>
						</tr>
						<?php 
							}else{
								for($inum_data = 0; $inum_data < $values['NO_LIMIT_txtnum'][0]; $inum_data++) {
						?>
									<tr class="trproj_<?php echo $inum_data; ?>">
										<td>
											<input id="pname_<?php echo $inum_data; ?>" name="pname_<?php echo $inum_data; ?>" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pname_'.$inum_data][0];  ?>" />
										</td>
										<td>
											<input id="pmanuf_<?php echo $inum_data; ?>" name="pmanuf_<?php echo $inum_data; ?>" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pmanuf_'.$inum_data][0];  ?>" />
										</td>
										<td class="price">
											<input id="pprice_<?php echo $inum_data; ?>" name="pprice_<?php echo $inum_data; ?>" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_pprice_'.$inum_data][0]; ?>" />
										</td>
										<td>
											<input id="plink_<?php echo $inum_data; ?>" name="plink_<?php echo $inum_data; ?>" type="text" class="" title="" value="<?php echo $values['NO_LIMIT_plink_'.$inum_data][0]; ?>" />
										</td>
										<td>
											<a id="apr_<?php echo $inum_data; ?>" class="del_proj" rel="trproj_<?php echo $inum_data; ?>" href="#">Delete</a>
										</td>
									</tr>
						<?php
								}
							}
						?>
						
				</tbody>
			</table>
			<br/>
			<button id="add_requirement" class="button real-btn"><?php _e('Add Requirement','framework'); ?></button>
		</div>
        <?php
    }
	function payment_meta_box_save( $post_id ) {
		
		$prefix = 'NO_LIMIT_';	
		
		if(isset($_POST['txtnum'])){
			update_post_meta($post_id, $prefix.'txtnum', $_POST['txtnum']);
		}
		
		// Attach instruction Post Meta
		for($inum = 0; $inum < $_POST['txtnum']; $inum++) {
			if(isset($_POST['pname_'.$inum])){
				update_post_meta($post_id, $prefix.'pname_'.$inum, $_POST['pname_'.$inum]);
			}		
			if(isset($_POST['pmanuf_'.$inum])){
				update_post_meta($post_id, $prefix.'pmanuf_'.$inum, $_POST['pmanuf_'.$inum]);
			}				
			if(isset($_POST['pprice_'.$inum])){
				update_post_meta($post_id, $prefix.'pprice_'.$inum, $_POST['pprice_'.$inum]);
			}				
			if(isset($_POST['plink_'.$inum])){
				update_post_meta($post_id, $prefix.'plink_'.$inum, $_POST['plink_'.$inum]);
			}		
		}

	}
}
add_action( 'save_post', 'payment_meta_box_save' );

?>