<?php
/*
*  Template Name: Submit Help Template
*/

$invalid_nonce = false;
$submitted_successfully = false;
$updated_successfully = false;
$prefix = 'NO_LIMIT_';

/* Check if action field is set and user is logged in */
if(isset($_POST['action']) && is_user_logged_in() ) {

    /* the nonce */
    if( wp_verify_nonce( $_POST['caring_nonce'], 'submit_help' ) ){

            // Start with basic array
            $new_help = array(
                'post_type'	    =>	'caring'
            );

            // Assign Title and Description
            $new_help['post_title']	= sanitize_text_field($_POST['title']);
            $new_help['post_content'] = $_POST['description'];

            // Assign Author
            global $current_user;
            get_currentuserinfo();
            $new_help['post_author'] = $current_user->ID;


            /* check the type of action */
            $action = $_POST['action'];
            if( $action == "add_help" ){
                $new_help['post_status'] = 'publish'; // Choose: publish, pending, future, draft, etc
                $help_id = wp_insert_post($new_help); // Insert help and get help ID
                if( $help_id > 0 ){
                    $submitted_successfully = true;
                    do_action('wp_insert_post', 'wp_insert_post'); // Post the Post
                }
            }elseif( $action == "update_help" ){
                $new_help['ID'] = intval($_POST['help_id']);
                $help_id = wp_update_post( $new_help ); // Update help and get help ID
                if( $help_id > 0 ){
                    $updated_successfully = true;
                }
            }

            if( $help_id > 0 ){

				// Set Default Status
                 update_post_meta($help_id, $prefix.'help_status','Call to help');
                
               
                // Attach Address Post Meta
                if(isset($_POST['address'])){
                    update_post_meta($help_id, $prefix.'caring_address', $_POST['address']);
                }

                // Attach Address Post Meta
                if(isset($_POST['location'])){
                    update_post_meta($help_id, $prefix.'caring_location', $_POST['location']);
                }
				
				
				// Attach instruction Post Meta
                if(isset($_POST['postal_location'])){
                    update_post_meta($help_id, $prefix.'postal_location', $_POST['postal_location']);
                }
				
				// Attach instruction Post Meta
                if(isset($_POST['instruction'])){
                    update_post_meta($help_id, $prefix.'instruction', $_POST['instruction']);
                }
				
					// Attach instruction Post Meta
                if(isset($_POST['video_url'])){
                    update_post_meta($help_id, $prefix.'video_url', $_POST['video_url']);
                }
				
				

                /* Upload Images */
                if($_FILES){
                    foreach( $_FILES as $submitted_file => $file_array ){
                        if( is_valid_image( $_FILES[$submitted_file]['name'] ) ){
                            $size = intval( $_FILES[$submitted_file]['size'] );
                            if( $size > 0 ){
                                if( $submitted_file == 'featured_image' ){
                                    /* Featured Image */
                                    $uploaded_file_id = insert_attachment( $submitted_file, $help_id, true );
                                }
								elseif( $submitted_file == 'caring_badge' ){
                                    /* Badge */
									 $uploaded_file_id = insert_attachment( $submitted_file, $help_id );
									 add_post_meta($help_id, $prefix.'caring_badge', $uploaded_file_id);
                                }else{
                                    /* Gallery Images */
                                    $uploaded_file_id = insert_attachment( $submitted_file, $help_id );
                                    add_post_meta($help_id, $prefix.'caring_images', $uploaded_file_id);
                                }
                            }
                        }else{
                            /* Skip the image upload if image do not has a valid file extension */
                        }
                    }
                }

                /* Send Email Notice on Call to help Submit */
                $action = $_POST['action'];
                if( $action == "add_help" ){
                    $submit_notice_email = get_option('theme_submit_notice_email');
                    if( !empty($submit_notice_email) ){
                        $current_user = wp_get_current_user();
                        $submitter_name = $current_user->display_name;
                        $submitter_email = $current_user->user_email;

                        $email_reply = 	__("You can contact the submitter", 'framework')
                            . " <b>" . $submitter_name . "</b> "
                            . __("via email", 'framework')
                            . " " .$submitter_email;

                        $email_subject = __('Call to help Submitted.', 'framework');
                        $email_html = __('A new Call to help has been submitted on your website.', 'framework');
                        $email_html .= "<br/><br/>";

                        $preview_link = set_url_scheme( get_permalink( $help_id ) );
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


    <!-- pageBody -->
	<div id="pageBody">
	<div class="section-heading main">
			<div class="wrapper">
				<h1 class="page-title">CALL TO HELP</h1>
			</div>
		</div>
		<section class="wrapper">
			<div class="callToHelp">
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
                                    alert( __('Success:','framework'),__('Help updated successfully!','framework') );
                                }else{

                                    /* if passed parameter is properly set to edit help */
                                    if(isset($_GET['edit_help']) && !empty($_GET['edit_help'])){

                                        $edit_help_id = intval(trim($_GET['edit_help']));
                                        $target_help = get_post($edit_help_id);

                                        /* check if passed id is a proper help post */
                                        if( !empty( $target_help ) && ( $target_help->post_type == 'caring' ) ){

                                            // Check Author
                                            global $current_user;
                                            get_currentuserinfo();

                                            /* check if current logged in user is the author of help */
                                            if( $target_help->post_author == $current_user->ID ){

                                                $post_meta_data = get_post_custom( $target_help->ID );
                                                ?>
                                                <form id="submit-help-form" class="submit-form" enctype="multipart/form-data" method="post">
                                                <div class="row-fluid">
                                                <div class="span6">

                                                    <div class="form-option">
                                                        <label for="title"><?php _e('Title','framework'); ?></label>
                                                        <input id="title" name="title" type="text" class="required" value="<?php echo $target_help->post_title; ?>" title="<?php _e( '* Please provide title!', 'framework'); ?>" autofocus required/>
                                                    </div>
                                                    <div class="form-option">
                                                        <label for="description"><?php _e('Description','framework'); ?></label>	
															<?php
															$content = $target_help->post_content;
															$editor_id = 'description';
															$settings = array( 'quicktags'=>FALSE, 'teeny'=>TRUE, 'media_buttons'=>FALSE,'editor_class'=>'customTinyMCE','textarea_rows'=> get_option('default_post_edit_rows', 8));
															wp_editor( $content, $editor_id, $settings ); ?>
                                                    </div>  
											
											
											<div class="form-option">
                                                <label for="description"><?php _e('Instruction','framework'); ?></label>									
												<?php
												$content = $post_meta_data[$prefix.'instruction'][0];
												$editor_id = 'instruction';
												$settings = array( 'quicktags'=>FALSE, 'teeny'=>TRUE, 'media_buttons'=>FALSE,'editor_class'=>'customTinyMCE','textarea_rows'=> get_option('default_post_edit_rows', 8));
												wp_editor( $content, $editor_id, $settings );
												?>												
                                            </div>											
											 <div class="form-option">
                                                <label for="title"><?php _e('Video','framework'); ?></label>
                                                <input id="video_url" name="video_url" type="text" class="" title="" value="<?php if( isset( $post_meta_data[$prefix.'video_url'] ) ){ echo $post_meta_data[$prefix.'video_url'][0]; } ?>" />
												<div class="field-description">
                                                    <?php _e( 'Please provide instruction video,', 'framework'); ?>
                                                </div>
                                            </div>

											<div class="form-option">		
                                                <label for="badge-image"><?php _e('Badge','framework'); ?></label>
												
												<div id="featured-thumb-container" class="clearfix">
													<?php
													
													$caring_badge = get_post_meta( $target_help->ID, $prefix.'caring_badge',true);  
													$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
													
													
													if(  isset($caring_badge[0])  ){
														echo '<div class="gallery-thumb">';
														echo '<img width="137" height="137" src="'.$caring_badge[0].'" />';
														echo '<a class="remove-badge-image" data-help-id="'.$target_help->ID.'" href="'. site_url("/wp-admin/admin-ajax.php") .'" ><i class="fa fa-trash-o"></i></a>';
														echo '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
														echo '</div>';
													}
													?>
												</div>
											<div id="badge-file-container" class=" <?php if(  isset($caring_badge[0]) ){ echo "hidden"; }?>" >
											   <input id="caring_badge" name="caring_badge" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image" />
                                                <div class="field-description">
                                                    <?php _e('Image should have minimum width of 137px and minimum height of 137px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                </div>
												</div>
                                            </div>
                                              
                                            <div class="form-option">
                                                      <label for="featured-image"><?php _e('Featured Image','framework'); ?></label>
                                                        <div id="featured-thumb-container" class="clearfix">
                                                            <?php
                                                            if( has_post_thumbnail( $target_help->ID ) ){
                                                                echo '<div class="gallery-thumb">';
                                                                echo get_the_post_thumbnail( $target_help->ID, 'thumbnail' );
                                                                echo '<a class="remove-featured-image" data-help-id="'.$target_help->ID.'" href="'. site_url("/wp-admin/admin-ajax.php") .'" ><i class="fa fa-trash-o"></i></a>';
                                                                echo '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
                                                                echo '</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div id="featured-file-container" class="<?php if(has_post_thumbnail( $target_help->ID )){ echo "hidden"; }?>" >
                                                            <input id="featured-image" name="featured_image" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image required" required/>
                                                            <div class="field-description">
                                                                <?php _e('Image should have minimum width of 770px and minimum height of 386px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="span6">
                                                    <div class="form-option">
                                                        <label for="address"><?php _e('Address', 'framework'); ?></label>
                                                        <input type="text" class="required" name="address" id="address" value="<?php if( isset( $post_meta_data[$prefix.'caring_address'] ) ){ echo $post_meta_data[$prefix.'caring_address'][0]; } ?>" title="<?php _e( '* Please provide a help address!', 'framework'); ?>" required/>
                                                        <div class="map-wrapper">
                                                            <button class="real-btn goto-address-button" type="button" value="address"><?php _e( 'Find Address','framework' ); ?></button>
                                                            <div class="map-canvas"></div>
                                                            <input type="hidden" name="location" class="map-coordinate" value="<?php if( isset( $post_meta_data[$prefix.'caring_location'] ) ){ echo $post_meta_data[$prefix.'caring_location'][0]; } ?>" />
                                                        </div>
                                                    </div>
													
													<div class="form-option">
														<label for="title"><?php _e('Postal Location','framework'); ?></label>
														<input id="postal_location" name="postal_location" type="text" class="" title="" value="<?php if( isset( $post_meta_data[$prefix.'postal_location'] ) ){ echo $post_meta_data[$prefix.'postal_location'][0]; } ?>" />												
													</div>

                                                   

                                                    <div class="form-option">
                                                        <label><?php _e('Gallery Images','framework'); ?></label>
                                                        <div id="gallery-thumbs-container" class="clearfix">
                                                            <?php
                                                            $thumbnail_size = 'thumbnail';
                                                            $help_images = rwmb_meta( $prefix.'caring_images', 'type=plupload_image&size='.$thumbnail_size, $target_help->ID );
                                                            if( !empty($help_images) ){
                                                                foreach( $help_images as $prop_image_id=>$prop_image_meta ){
                                                                    echo '<div class="gallery-thumb">';
                                                                    echo '<img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" />';
                                                                    echo '<a class="remove-image" data-help-id="'.$target_help->ID.'" data-gallery-img-id="'.$prop_image_id.'" href="'. site_url("/wp-admin/admin-ajax.php") .'" ><i class="fa fa-trash-o"></i></a>';
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
                                                            <?php _e('Provide images for gallery on help detail page. Images should have minimum width of 770px and minimum height of 386px. ( Bigger images will be cropped automatically )','framework'); ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <?php wp_nonce_field( 'submit_help', 'caring_nonce' ); ?>
                                                        <input type="hidden" name="action" value="update_help"/>
                                                        <input type="hidden" name="help_id" value="<?php echo $target_help->ID; ?>"/>
                                                        <input type="submit" value="<?php _e('Submit Help','framework');?>" class="real-btn" />
                                                    </div>

                                                    <div id="validation-errors"></div>

                                                </div>
                                                </div>

                                                </form>
                                                <?php

                                            }else{
                                                echo '<p class="text-error">';
                                                _e('Requested help does not belong to logged in user !','framework');
                                                echo '</p>';
                                            }

                                        }else{
                                            echo '<p class="text-error">';
                                            _e('Requested post is not a valid help post !','framework');
                                            echo '</p>';
                                        }

                                    }else{

                                        ?>
                                        <form id="submit-help-form" class="submit-form" enctype="multipart/form-data" method="post">
                                        <div class="row-fluid">

                                        <div class="span6">

                                            <div class="form-option">
                                                <label for="title"><?php _e('Title','framework'); ?></label>
                                                <input id="title" name="title" type="text" class="required" title="<?php _e( '* Please provide call to help title!', 'framework'); ?>" autofocus required/>
                                            </div>

                                            <div class="form-option">
                                                <label for="description"><?php _e('Description','framework'); ?></label>
                                                <!--textarea name="description" id="description" cols="30" rows="5"></textarea-->												
												<?php
												$content = '';
												$editor_id = 'description';
												$settings = array( 'quicktags'=>FALSE, 'teeny'=>TRUE, 'media_buttons'=>FALSE,'editor_class'=>'customTinyMCE','textarea_rows'=> get_option('default_post_edit_rows', 8));

												wp_editor( $content, $editor_id, $settings );

												?>
                                            </div>
											
											<div class="form-option">
                                                <label for="description"><?php _e('Instruction','framework'); ?></label>									
												<?php
												$content = '';
												$editor_id = 'instruction';
												$settings = array( 'quicktags'=>FALSE, 'teeny'=>TRUE, 'media_buttons'=>FALSE,'editor_class'=>'customTinyMCE','textarea_rows'=> get_option('default_post_edit_rows', 8));
												wp_editor( $content, $editor_id, $settings );

												?>
                                            </div>
											
											 <div class="form-option">
                                                <label for="title"><?php _e('Video','framework'); ?></label>
                                                <input id="video" name="video" type="text" class="" title="" />
												<div class="field-description">
                                                    <?php _e('Provide instruction video URL. Theme supports YouTube, Vimeo, SWF File and MOV File', 'framework'); ?>
                                                </div>
                                            </div>

											<div class="form-option">
                                                <label for="caring_badge"><?php _e('Badge','framework'); ?></label>
                                                <input id="caring_badge" name="caring_badge" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image " />
                                                <div class="field-description">
                                                    <?php _e('Image should have minimum width of 137px and minimum height of 137px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                </div>
                                            </div>


                                              
                                            <div class="form-option">
                                                <label for="featured-image"><?php _e('Featured Image','framework'); ?></label>
                                                <input id="featured-image" name="featured_image" type="file" title="<?php _e( '* Please provide image with proper extension! Only .jpg .gif and .png are allowed.!', 'framework'); ?>" class="image required" required/>
                                                <div class="field-description">
                                                    <?php _e('Image should have minimum width of 770px and minimum height of 386px. ( Bigger image will be cropped automatically )','framework'); ?>
                                                </div>
                                            </div>
                                 

                                        </div>

                                        <div class="span6">

                                            <div class="form-option">
                                                <label for="address"><?php _e('Location', 'framework'); ?></label>
                                                <input type="text" class="required" name="address" id="address" value="Cebu City, Philippines" title="<?php _e( '* Please provide a help address!', 'framework'); ?>" required/>
                                                <div class="map-wrapper">
                                                    <button class="real-btn goto-address-button" type="button" value="address"><?php _e( 'Find location','framework' ); ?></button>
                                                    <div class="map-canvas"></div>
                                                    <input type="hidden" name="location" class="map-coordinate" value="10.3156992,123.88543660000005" />
                                                </div>
                                            </div>
												
											<div class="form-option">
                                                <label for="title"><?php _e('Postal Location','framework'); ?></label>
                                                <input id="postal_location" name="postal_location" type="text" class="" title="" />												
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
                                                <input type="hidden" name="action" value="add_help"/>
                                                <input type="submit" value="<?php _e('Send Help','framework');?>" class="real-btn" />
                                            </div>

                                        </div>
                                        </div>

                                        </form>
                                        <?php
                                    } /* end of add/edit help*/

                                } /* end of submitted/updated successfully */

                            } /* end of invalid nonce */

                        }else{
                            alert( __('Login Required:','framework'),__('Please login to submit call to help!','framework') );
                        }
                        ?>
			</div>
		</section>
    </div>      
<?php get_footer(); ?>