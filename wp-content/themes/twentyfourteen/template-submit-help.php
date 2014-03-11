<?php
/*
*  Template Name: Submit Property Template
*/

$invalid_nonce = false;
$submitted_successfully = false;
$updated_successfully = false;

/* Check if action field is set and user is logged in */
if(isset($_POST['action']) && is_user_logged_in() ) {

    /* the nonce */
    if( wp_verify_nonce( $_POST['caring_nonce'], 'submit_help' ) ){

            // Start with basic array
            $new_property = array(
                'post_type'	    =>	'caring'
            );

            // Assign Title and Description
            $new_property['post_title']	= sanitize_text_field($_POST['title']);
            $new_property['post_content'] = $_POST['description'];

            // Assign Author
            global $current_user;
            get_currentuserinfo();
            $new_property['post_author'] = $current_user->ID;


            /* check the type of action */
            $action = $_POST['action'];
            if( $action == "add_property" ){
                $new_property['post_status'] = 'pending'; // Choose: publish, pending, future, draft, etc
                $property_id = wp_insert_post($new_property); // Insert Property and get Property ID
                if( $property_id > 0 ){
                    $submitted_successfully = true;
                    do_action('wp_insert_post', 'wp_insert_post'); // Post the Post
                }
            }elseif( $action == "update_property" ){
                $new_property['ID'] = intval($_POST['property_id']);
                $property_id = wp_update_post( $new_property ); // Update Property and get Property ID
                if( $property_id > 0 ){
                    $updated_successfully = true;
                }
            }

            if( $property_id > 0 ){

                // Attach Property Type with Newly Created Property
                if(isset($_POST['type']) && ($_POST['type'] != "-1") ){
                    wp_set_object_terms( $property_id , intval($_POST['type']), 'property-type' );
                }

                // Attach Property City with Newly Created Property
                if(isset($_POST['city']) && ($_POST['city'] != "-1") ){
                    wp_set_object_terms( $property_id , intval($_POST['city']), 'property-city' );
                }

                // Attach Property Status with Newly Created Property
                if(isset($_POST['status']) && ($_POST['status'] != "-1") ){
                    wp_set_object_terms( $property_id , intval($_POST['status']), 'property-status' );
                }

                // Attach Property Features with Newly Created Property
                if(isset($_POST['features'])){
                    if(!empty($_POST['features']) && is_array($_POST['features'])){
                        $property_features = array();
                        foreach($_POST['features'] as $property_feature_id){
                            $property_features[] = intval($property_feature_id);
                        }
                        wp_set_object_terms( $property_id , $property_features, 'property-feature' );
                    }
                }

                // Attach Price Post Meta
                if(isset($_POST['price'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_price', trim($_POST['price']));
                }
                if(isset($_POST['price-postfix'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_price_postfix', trim($_POST['price-postfix']));
                }

                // Attach Size Post Meta
                if(isset($_POST['size'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_size', $_POST['size']);
                }
                if(isset($_POST['area-postfix'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_size_postfix', $_POST['area-postfix']);
                }

                // Attach Bedrooms Post Meta
                if(isset($_POST['bedrooms'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_bedrooms', floatval($_POST['bedrooms']));
                }

                // Attach Bathrooms Post Meta
                if(isset($_POST['bathrooms'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_bathrooms', floatval($_POST['bathrooms']));
                }

                // Attach Garages Post Meta
                if(isset($_POST['garages'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_garage', floatval($_POST['garages']));
                }

                // Attach Address Post Meta
                if(isset($_POST['address'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_address', $_POST['address']);
                }

                // Attach Address Post Meta
                if(isset($_POST['location'])){
                    update_post_meta($property_id, 'NO_LIMIT_caring_location', $_POST['location']);
                }

                /* Upload Images */
                if($_FILES){
                    foreach( $_FILES as $submitted_file => $file_array ){
                        if( is_valid_image( $_FILES[$submitted_file]['name'] ) ){
                            $size = intval( $_FILES[$submitted_file]['size'] );
                            if( $size > 0 ){
                                if( $submitted_file == 'featured_image' ){
                                    /* Featured Image */
                                    $uploaded_file_id = insert_attachment( $submitted_file, $property_id, true );
                                }else{
                                    /* Gallery Images */
                                    $uploaded_file_id = insert_attachment( $submitted_file, $property_id );
                                    add_post_meta($property_id, 'NO_LIMIT_caring_images', $uploaded_file_id);
                                }
                            }
                        }else{
                            /* Skip the image upload if image do not has a valid file extension */
                        }
                    }
                }

                /* Send Email Notice on Property Submit */
                $action = $_POST['action'];
                if( $action == "add_property" ){
                    $submit_notice_email = get_option('theme_submit_notice_email');
                    if( !empty($submit_notice_email) ){
                        $current_user = wp_get_current_user();
                        $submitter_name = $current_user->display_name;
                        $submitter_email = $current_user->user_email;

                        $email_reply = 	__("You can contact the submitter", 'framework')
                            . " <b>" . $submitter_name . "</b> "
                            . __("via email", 'framework')
                            . " " .$submitter_email;

                        $email_subject = __('Property Submitted.', 'framework');
                        $email_html = __('A new property has been submitted on your website.', 'framework');
                        $email_html .= "<br/><br/>";

                        $preview_link = set_url_scheme( get_permalink( $property_id ) );
                        $preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
                        if(!empty($preview_link)){
                            $email_html .= __('You can preview it here','framework');
                            $email_html .= ': <a target="_blank" href="'. $preview_link .'">'.$_POST['title'].'</a>';
                            $email_html .= "<br/><br/>";
                        }
                        $email_html.= $email_reply;

                        wp_mail($submit_notice_email, $email_subject, $email_html, "Content-type: text/html\r\nFrom: $submitter_email\r\nReply-To: $submitter_email\r\nReturn-Path: $submitter_email\r\n","-f $submit_notice_email");
                    }
                }

            }

    }else{
        $invalid_nonce = true;
    }
}

get_header();
?>

    <!-- Page Head -->
    <?php get_template_part("banners/default_page_banner"); ?>

    <!-- Content -->
    <div class="container contents single">
        <div class="row">
            <div class="span12 main-wrap">
                <!-- Main Content -->
                <div class="main">

                    <div class="inner-wrapper">
                        <?php
                        if ( have_posts() ) :
                            while ( have_posts() ) :
                                the_post();
                                ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix"); ?>>
                                    <?php the_content(); ?>
                                </article>
                                <?php
                            endwhile;
                        endif;

                        /* If user logged */
                        if(is_user_logged_in()){

                            if($invalid_nonce){
                                alert( __('Error:','framework'),__('Security check failed!','framework') );
                            }else{

                                if($submitted_successfully){
                                    $submit_message = get_option('theme_submit_message');
                                    alert( __('Success:','framework'), $submit_message );
                                }elseif($updated_successfully){
                                    alert( __('Success:','framework'),__('Property updated successfully!','framework') );
                                }else{

                                    /* if passed parameter is properly set to edit property */
                                    if(isset($_GET['edit_property']) && !empty($_GET['edit_property'])){

                                        $edit_property_id = intval(trim($_GET['edit_property']));
                                        $target_property = get_post($edit_property_id);

                                        /* check if passed id is a proper property post */
                                        if( !empty( $target_property ) && ( $target_property->post_type == 'property' ) ){

                                            // Check Author
                                            global $current_user;
                                            get_currentuserinfo();

                                            /* check if current logged in user is the author of property */
                                            if( $target_property->post_author == $current_user->ID ){

                                                $post_meta_data = get_post_custom( $target_property->ID );
                                                ?>
                                                <form id="submit-property-form" class="submit-form" enctype="multipart/form-data" method="post">
                                                <div class="row-fluid">
                                                <div class="span6">

                                                    <div class="form-option">
                                                        <label for="title"><?php _e('Property Title','framework'); ?></label>
                                                        <input id="title" name="title" type="text" class="required" value="<?php echo $target_property->post_title; ?>" title="<?php _e( '* Please provide property title!', 'framework'); ?>" autofocus required/>
                                                    </div>

                                                    <div class="form-option">
                                                        <label for="description"><?php _e('Property Description','framework'); ?></label>
                                                        <textarea name="description" id="description" cols="30" rows="5"><?php echo $target_property->post_content; ?></textarea>
                                                    </div>

                                                    <div class="form-options-container clearfix">

                                                        <div class="form-option">
                                                            <label for="type"><?php _e('Type', 'framework'); ?></label>
                                                            <span class="selectwrap">
                                                                <select name="type" id="type" class="search-select">
                                                                    <?php edit_form_taxonomy_options( $target_property->ID, 'property-type'); ?>
                                                                </select>
                                                            </span>
                                                        </div>

                                                        <div class="form-option right">
                                                            <label for="city"><?php _e('City', 'framework'); ?></label>
                                                            <span class="selectwrap">
                                                                <select name="city" id="city" class="search-select">
                                                                    <?php edit_form_city_options( $target_property->ID, 'property-city'); ?>
                                                                </select>
                                                            </span>
                                                        </div>

                                                        <div class="form-option">
                                                            <label for="status"><?php _e('Status', 'framework'); ?></label>
                                                            <span class="selectwrap">
                                                                <select name="status" id="status" class="search-select">
                                                                    <?php edit_form_taxonomy_options( $target_property->ID, 'property-status'); ?>
                                                                </select>
                                                            </span>
                                                        </div>

                                                        <div class="form-option right">
                                                            <label for="bedrooms"><?php _e('Bedrooms', 'framework'); ?></label>
                                                            <input id="bedrooms" name="bedrooms" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_bedrooms']) ){ echo $post_meta_data['NO_LIMIT_caring_bedrooms'][0]; } ?>" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                        </div>

                                                        <div class="form-option">
                                                            <label for="bathrooms"><?php _e('Bathrooms', 'framework'); ?></label>
                                                            <input id="bathrooms" name="bathrooms" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_bathrooms']) ){ echo $post_meta_data['NO_LIMIT_caring_bathrooms'][0]; } ?>" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                        </div>

                                                        <div class="form-option right">
                                                            <label for="garages"><?php _e('Garages', 'framework'); ?></label>
                                                            <input id="garages" name="garages" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_garage']) ){ echo $post_meta_data['NO_LIMIT_caring_garage'][0]; } ?>" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                        </div>

                                                        <div class="form-option">
                                                            <label for="price"><?php _e('Sale OR Rent Price','framework'); ?></label>
                                                            <input id="price" name="price" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_price']) ){ echo $post_meta_data['NO_LIMIT_caring_price'][0]; } ?>" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>"  />
                                                        </div>

                                                        <div class="form-option right">
                                                            <label for="price-postfix"><?php _e('Price Postfix Text','framework'); ?></label>
                                                            <input id="price-postfix" name="price-postfix" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_price_postfix']) ){ echo $post_meta_data['NO_LIMIT_caring_price_postfix'][0]; } ?>" />
                                                        </div>

                                                        <div class="form-option">
                                                            <label for="size"><?php _e('Area','framework'); ?></label>
                                                            <input id="size" name="size" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_size']) ){ echo $post_meta_data['NO_LIMIT_caring_size'][0]; } ?>" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                        </div>

                                                        <div class="form-option right">
                                                            <label for="area-postfix"><?php _e('Area Postfix Text','framework'); ?></label>
                                                            <input id="area-postfix" name="area-postfix" type="text" value="<?php if( isset($post_meta_data['NO_LIMIT_caring_size_postfix']) ){ echo $post_meta_data['NO_LIMIT_caring_size_postfix'][0]; } ?>" />
                                                        </div>

                                                    </div>

                                                    <div class="form-option">
                                                        <label><?php _e('Features', 'framework'); ?></label>
                                                        <ul class="features-checkboxes clearfix">
                                                            <?php
                                                            /* Property Features */
                                                            $features_terms = get_the_terms( $target_property->ID,"property-feature" );
                                                            $property_features_ids = array();
                                                            if(!empty($features_terms)){
                                                                foreach($features_terms as $fet_trms){
                                                                    $property_features_ids[] = $fet_trms->term_id;
                                                                }
                                                            }

                                                            /* All Features */
                                                            $features_terms = get_terms(
                                                                array(
                                                                    "property-feature"
                                                                ),
                                                                array(
                                                                    'orderby'       => 'name',
                                                                    'order'         => 'ASC',
                                                                    'hide_empty'    => false
                                                                )
                                                            );

                                                            if(!empty($features_terms)){
                                                                $feature_count = 1;
                                                                foreach($features_terms as $feature){
                                                                    echo '<li>';
                                                                    if( in_array( $feature->term_id, $property_features_ids ) ){
                                                                        echo '<input type="checkbox" name="features[]" id="feature-'.$feature_count.'" value="'.$feature->term_id.'" checked />';
                                                                    }else{
                                                                        echo '<input type="checkbox" name="features[]" id="feature-'.$feature_count.'" value="'.$feature->term_id.'" />';
                                                                    }
                                                                    echo '<label for="feature-'.$feature_count.'">'.$feature->name.'</label>';
                                                                    echo '</li>';
                                                                    $feature_count++;
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>

                                                </div>

                                                <div class="span6">

                                                    <div class="form-option">
                                                        <label for="address"><?php _e('Address', 'framework'); ?></label>
                                                        <input type="text" class="required" name="address" id="address" value="<?php if( isset( $post_meta_data['NO_LIMIT_caring_address'] ) ){ echo $post_meta_data['NO_LIMIT_caring_address'][0]; } ?>" title="<?php _e( '* Please provide a property address!', 'framework'); ?>" required/>
                                                        <div class="map-wrapper">
                                                            <button class="real-btn goto-address-button" type="button" value="address"><?php _e( 'Find Address','framework' ); ?></button>
                                                            <div class="map-canvas"></div>
                                                            <input type="hidden" name="location" class="map-coordinate" value="<?php if( isset( $post_meta_data['NO_LIMIT_caring_location'] ) ){ echo $post_meta_data['NO_LIMIT_caring_location'][0]; } ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <label for="featured-image"><?php _e('Property Featured Image','framework'); ?></label>
                                                        <div id="featured-thumb-container" class="clearfix">
                                                            <?php
                                                            if( has_post_thumbnail( $target_property->ID ) ){
                                                                echo '<div class="gallery-thumb">';
                                                                echo get_the_post_thumbnail( $target_property->ID, 'thumbnail' );
                                                                echo '<a class="remove-featured-image" data-property-id="'.$target_property->ID.'" href="'. site_url("/wp-admin/admin-ajax.php") .'" ><i class="fa fa-trash-o"></i></a>';
                                                                echo '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
                                                                echo '</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div id="featured-file-container" class="<?php if(has_post_thumbnail( $target_property->ID )){ echo "hidden"; }?>" >
                                                            <input id="featured-image" name="featured_image" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image required" required/>
                                                            <div class="field-description">
                                                                <?php _e('Image should have minimum width of 770px and minimum height of 386px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <label><?php _e('Gallery Images','framework'); ?></label>
                                                        <div id="gallery-thumbs-container" class="clearfix">
                                                            <?php
                                                            $thumbnail_size = 'thumbnail';
                                                            $properties_images = rwmb_meta( 'NO_LIMIT_caring_images', 'type=plupload_image&size='.$thumbnail_size, $target_property->ID );
                                                            if( !empty($properties_images) ){
                                                                foreach( $properties_images as $prop_image_id=>$prop_image_meta ){
                                                                    echo '<div class="gallery-thumb">';
                                                                    echo '<img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" />';
                                                                    echo '<a class="remove-image" data-property-id="'.$target_property->ID.'" data-gallery-img-id="'.$prop_image_id.'" href="'. site_url("/wp-admin/admin-ajax.php") .'" ><i class="fa fa-trash-o"></i></a>';
                                                                    echo '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
                                                                    echo '</div>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <label><?php _e('Add more images to gallery','framework'); ?></label>
                                                        <div id="gallery-images-container">
                                                            <div class="controls-holder"><input class="gallery-image image" name="gallery_image_1" type="file" /></div>
                                                        </div>
                                                        <button id="add-more" class="real-btn"><?php _e('Add More','framework'); ?></button>
                                                        <div class="field-description">
                                                            <?php _e('Provide images for gallery on property detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'); ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <?php wp_nonce_field( 'submit_help', 'caring_nonce' ); ?>
                                                        <input type="hidden" name="action" value="update_property"/>
                                                        <input type="hidden" name="property_id" value="<?php echo $target_property->ID; ?>"/>
                                                        <input type="submit" value="<?php _e('Submit Property','framework');?>" class="real-btn" />
                                                    </div>

                                                    <div id="validation-errors"></div>

                                                </div>
                                                </div>

                                                </form>
                                                <?php

                                            }else{
                                                echo '<p class="text-error">';
                                                _e('Requested property does not belong to logged in user !','framework');
                                                echo '</p>';
                                            }

                                        }else{
                                            echo '<p class="text-error">';
                                            _e('Requested post is not a valid property post !','framework');
                                            echo '</p>';
                                        }

                                    }else{

                                        ?>
                                        <form id="submit-property-form" class="submit-form" enctype="multipart/form-data" method="post">
                                        <div class="row-fluid">

                                        <div class="span6">

                                            <div class="form-option">
                                                <label for="title"><?php _e('Call to help Title','framework'); ?></label>
                                                <input id="title" name="title" type="text" class="required" title="<?php _e( '* Please provide call to help title!', 'framework'); ?>" autofocus required/>
                                            </div>

                                            <div class="form-option">
                                                <label for="description"><?php _e('Help Description','framework'); ?></label>
                                                <textarea name="description" id="description" cols="30" rows="5"></textarea>
                                            </div>

                                            <div class="form-options-container clearfix">

                                                <div class="form-option">
                                                    <label for="type"><?php _e('Type', 'framework'); ?></label>
                                                    <span class="selectwrap">
                                                        <select name="type" id="type" class="search-select">
                                                            <option selected="selected" value="-1"><?php _e('None', 'framework'); ?></option>
                                                            <?php
                                                            /* Property Type */
                                                            $property_types_terms = get_terms(
                                                                array(
                                                                    "property-type"
                                                                ),
                                                                array(
                                                                    'orderby'       => 'name',
                                                                    'order'         => 'ASC',
                                                                    'hide_empty'    => false
                                                                )
                                                            );

                                                            if(!empty($property_types_terms)){
                                                                foreach($property_types_terms as $property_type){
                                                                    echo '<option value="'.$property_type->term_id.'">'.$property_type->name.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </span>
                                                </div>


                                                <div class="form-option">
                                                    <label for="status"><?php _e('Status', 'framework'); ?></label>
                                                    <span class="selectwrap">
                                                        <select name="status" id="status" class="search-select">
                                                            <option selected="selected" value="-1"><?php _e('None', 'framework'); ?></option>
                                                            <?php
                                                            /* Property Status */
                                                            $property_status_terms = get_terms(
                                                                array(
                                                                    "property-status"
                                                                ),
                                                                array(
                                                                    'orderby'     => 'name',
                                                                    'order'         => 'ASC',
                                                                    'hide_empty'    => false
                                                                )
                                                            );

                                                            if(!empty($property_status_terms)){
                                                                foreach($property_status_terms as $property_status){
                                                                    echo '<option value="'.$property_status->term_id.'">'.$property_status->name.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </span>
                                                </div>

                                                <div class="form-option right">
                                                    <label for="bedrooms"><?php _e('Bedrooms', 'framework'); ?></label>
                                                    <input id="bedrooms" name="bedrooms" type="text" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                </div>

                                                <div class="form-option">
                                                    <label for="bathrooms"><?php _e('Bathrooms', 'framework'); ?></label>
                                                    <input id="bathrooms" name="bathrooms" type="text" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                </div>

                                                <div class="form-option right">
                                                    <label for="garages"><?php _e('Garages', 'framework'); ?></label>
                                                    <input id="garages" name="garages" type="text" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                </div>

                                                <div class="form-option">
                                                    <label for="price"><?php _e('Sale OR Rent Price','framework'); ?></label>
                                                    <input id="price" name="price" type="text" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                </div>

                                                <div class="form-option right">
                                                    <label for="price-postfix"><?php _e('Price Postfix Text','framework'); ?></label>
                                                    <input id="price-postfix" name="price-postfix" type="text" />
                                                </div>

                                                <div class="form-option">
                                                    <label for="size"><?php _e('Area','framework'); ?></label>
                                                    <input id="size" name="size" type="text" title="<?php _e( '* Please provide the value in only digits!', 'framework'); ?>" />
                                                </div>

                                                <div class="form-option right">
                                                    <label for="area-postfix"><?php _e('Area Postfix Text','framework'); ?></label>
                                                    <input id="area-postfix" name="area-postfix" type="text" value="<?php _e('Sq Ft','framework'); ?>" />
                                                </div>

                                            </div>

                                            <div class="form-option">
                                                <label><?php _e('Features', 'framework'); ?></label>
                                                <ul class="features-checkboxes clearfix">
                                                    <?php
                                                    /* Property Features */
                                                    $features_terms = get_terms(
                                                        array(
                                                            "property-feature"
                                                        ),
                                                        array(
                                                            'orderby'       => 'name',
                                                            'order'         => 'ASC',
                                                            'hide_empty'    => false
                                                        )
                                                    );

                                                    if(!empty($features_terms)){
                                                        $feature_count = 1;
                                                        foreach($features_terms as $feature){
                                                            echo '<li>';
                                                            echo '<input type="checkbox" name="features[]" id="feature-'.$feature_count.'" value="'.$feature->term_id.'" />';
                                                            echo '<label for="feature-'.$feature_count.'">'.$feature->name.'</label>';
                                                            echo '</li>';
                                                            $feature_count++;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="span6">

                                            <div class="form-option">
                                                <label for="address"><?php _e('Address', 'framework'); ?></label>
                                                <input type="text" class="required" name="address" id="address" value="15421 Southwest 39th Terrace, Miami, FL 33185, USA" title="<?php _e( '* Please provide a property address!', 'framework'); ?>" required/>
                                                <div class="map-wrapper">
                                                    <button class="real-btn goto-address-button" type="button" value="address"><?php _e( 'Find Address','framework' ); ?></button>
                                                    <div class="map-canvas"></div>
                                                    <input type="hidden" name="location" class="map-coordinate" value="25.7308309,-80.44414899999998" />
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <label for="featured-image"><?php _e('Help Featured Image','framework'); ?></label>
                                                <input id="featured-image" name="featured_image" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image required" required/>
                                                <div class="field-description">
                                                    <?php _e('Image should have minimum width of 770px and minimum height of 386px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <label><?php _e('Gallery Images','framework'); ?></label>
                                                <div id="gallery-images-container">
                                                    <div class="controls-holder"><input class="gallery-image image" name="gallery_image_1" type="file" /></div>
                                                </div>
                                                <button id="add-more" class="real-btn"><?php _e('Add More','framework'); ?></button>
                                                <div class="field-description">
                                                    <?php _e('Provide images for gallery on call to help detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'); ?>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <?php wp_nonce_field( 'submit_help', 'caring_nonce' ); ?>
                                                <input type="hidden" name="action" value="add_property"/>
                                                <input type="submit" value="<?php _e('Send Help','framework');?>" class="real-btn" />
                                            </div>

                                        </div>
                                        </div>

                                        </form>
                                        <?php
                                    } /* end of add/edit property*/

                                } /* end of submitted/updated successfully */

                            } /* end of invalid nonce */

                        }else{
                            alert( __('Login Required:','framework'),__('Please login to submit property!','framework') );
                        }
                        ?>
                    </div>

                </div><!-- End Main Content -->

            </div><!-- End span12 -->

        </div><!-- End contents row -->

    </div><!-- End Content -->

<?php get_footer(); ?>