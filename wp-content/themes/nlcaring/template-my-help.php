<?php
/*
*  Template Name: My Properties Template
*/

get_header();
?>


    <!-- Content -->
   <div id="pageBody">
		<div class="section-heading main">
			<div class="wrapper">
				<h1 class="page-title">CALL TO HELP</h1>
			</div>
		</div>
        <section class="wrapper">
            <div class="span12 main-wrap">
                <?php
                if( isset($_GET['deleted']) && ( intval($_GET['deleted']) == 1 ) ){
                    alert( __('Success!','framework'),__('Help removed.','framework') );
                }
                ?>

                <!-- Main Content -->
                <div class="main">

                    <?php
                    if(is_user_logged_in()){

                        // Get User Id
                        global $current_user;
                        get_currentuserinfo();

                        // My properties arguments
                        $my_props_args = array(
                            'post_type' => 'caring',
                            'posts_per_page' => 10,
                            'paged' => $paged,
                            'post_status' => array( 'pending', 'draft', 'publish', 'auto-draft', 'future' ),
                            'author' => $current_user->ID
                        );
				
						$sorty_by = get_option('theme_sorty_by');					
							if( !empty($sorty_by) ){
								if( $sorty_by == 'hero-to-call' ){
									$my_props_args['orderby'] = 'meta_value_num';
									$my_props_args['meta_key'] = 'NO_LIMIT_help_status';
									$my_props_args['order'] = 'DESC';
								}elseif( $sorty_by == 'call-to-hero' ){
									$my_props_args['orderby'] = 'meta_value';
									$my_props_args['meta_key'] = 'NO_LIMIT_help_status';
									$my_props_args['order'] = 'ASC';
								}
							}
				
                        $my_properties_query = new WP_Query( $my_props_args );
                        if ( $my_properties_query->have_posts() ) :

                            /* Get Payment Related Options before while loop */
                            $payments_enabled   = get_option( 'theme_enable_paypal' );
                            $paypal_merchant_id = get_option( 'theme_paypal_merchant_id' );
                            $enable_sandbox     = get_option( 'theme_enable_sandbox' );
                            $payment_amount     = get_option( 'theme_payment_amount' );
                            $currency_code      = get_option( 'theme_currency_code' );

                            while ( $my_properties_query->have_posts() ) :
                                $my_properties_query->the_post();

								 $status  = help_field_value('NO_LIMIT_help_status');
								 
                                ?>
                                <div class="my-property clearfix <?php echo ( $status == '3')  ? 'hero-rally' :  (($status == '2') ? 'journey'  : 'call-to-help' ); ?>">

                                    <div class="property-thumb cell">
                                        <?php
                                        if(has_post_thumbnail($post->ID)){
                                            the_post_thumbnail('help-thumb-image',array(
                                                'alt'	=> get_the_title($post->ID),
                                                'title'	=> get_the_title($post->ID)
                                            ));
                                        }
                                        ?>
                                    </div>

                                    <div class="property-title cell">
                                        <h5><?php the_title(); ?></h5>
                                    </div>

                                    <div class="property-date cell">
                                        <h5><i class="fa fa-calendar"></i>&nbsp;<?php _e('Posted on :','framework');?>&nbsp;<?php the_time("d F 'y"); ?></h5>
                                    </div>

                                    <div class="property-publish-status cell">
                                        <h5><?php show_status(); ?></h5>
                                    </div>
									
									
									<div class="property-location cell">
                                        <h5><?php echo help_field_value('NO_LIMIT_caring_address'); ?></h5>
                                    </div>

                                    <div class="property-controls">
                                        <?php
                                        /* Edit Post Link */
                                        $submit_url = get_option('theme_submit_url');
                                        if(!empty($submit_url)){
                                            $edit_link = add_query_arg( 'edit_help', $post->ID , $submit_url );
                                            ?><a href="<?php echo $edit_link; ?>"><i class="fa fa-pencil"></i></a><?php
                                        }

                                      
                                                ?>
												<a target="_blank" href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i></a>
												<?php
                                      

                                        /* Delete Post Link Bypassing Trash */
                                        if ( current_user_can('delete_posts') ) {
                                            $delete_post_link = get_delete_post_link( $post->ID, '', true );
                                            if(!empty($delete_post_link)){
                                                ?><a href="<?php echo $delete_post_link; ?>"><i class="fa fa-times"></i></a><?php
                                            }
                                        }
                                        ?>
                                    </div>



                                </div>
                                <?php

                            endwhile;
                            wp_reset_query();
                        else:
                            ?>
                            <div class="alert-wrapper">
                                <p class="error message"><?php _e('No Properties Found!', 'framework') ?></p>
                            </div>
                            <?php
                        endif;

                        theme_pagination( $my_properties_query->max_num_pages);

                    }else{
                        ?>
                        <div class="alert-wrapper">
                        <p class="error message"><?php _e('Please, <a href="/my-account/">Log in</a> to view your help!', 'framework') ?></p>
                        </div>
                        <?php
                    }

                    ?>

                </div><!-- End Main Content -->

            </div> <!-- End span12 -->

        </div><!-- End contents row -->

    </div><!-- End Content -->

<?php get_footer(); ?>