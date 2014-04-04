<?php 
/* Template Name: Front Page */

get_header();

$show_banner  = get_option('theme_homepage_module');
if(!$show_banner || $show_banner =='help-static-banner'){
	get_template_part('content','banner');
}



?>
	<div id="pageBody">
		<section class="wrapper">
			<div class="callToHelp">
				<header class="tools">Featured Call to Help &nbsp; &nbsp;<a href="#">View All</a></header>
				<?php 
					if ( is_front_page()  ) {
						$paged = (get_query_var('page')) ? get_query_var('page') : 1;
					}
					
					 /* List of Help on Homepage */
						$number_of_help = intval(get_option('theme_help_on_home'));
						 if(!$number_of_properties){
								$number_of_properties = 8;
						  }
						
					$home_args = array(
						'post_type' => 'caring',
						'posts_per_page' => $number_of_help,
						'paged' => $paged
					);
					
					   $home_helps_query = new WP_Query( $home_args );
						if ( $home_helps_query->have_posts() ) :									
				?>
				<ul class="grid masonry">
					<?php  
					  while ( $home_helps_query->have_posts() ) :
						$home_helps_query->the_post();									
						 $status  = help_field_value('NO_LIMIT_help_status');
					?>
					<li class="cell <?php echo ( $status == 'Hero Rally')  ? 'hero-rally' :  (($status == 'Journey') ? 'journey'  : 'call-to-help' ); ?>">
						<a href="<?php the_permalink(); ?>" title="" class="thumbnail">	
						<?php
							if( has_post_thumbnail( $post->ID ) ){
								echo get_the_post_thumbnail( $post->ID, 'default_help', array( 'class'=>'help_thumb') );
							}else{
								echo '<img width="220" height="157" src="'.get_template_directory_uri().'/contents/images/default.jpg" />';
							}
						?>
						<span class="cover"><span class="status">JOURNEY ACTIVATED</span></span> <?php echo ($status =='Hero Rally')  ? '<span class="btn-help"></span>' : '' ?></a>
						<div class="box-body">
							<header class="title">
							<?php													
								$caring_badge = get_post_meta( $post->ID, $prefix.'caring_badge',true);  
								$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
								if(  isset($caring_badge[0])  ){
									echo '<img class="badge" width="30" src="'.$caring_badge[0].'" />';						
								}else{
									echo '<img  class="badge" width="30" src="'.get_template_directory_uri().'/contents/images/badge-default.png" />';		
								}
								?>
								<h3><?php  the_title(); ?> <br/><?php the_author() ?> <br/><?php echo get_post_meta($post->ID, 'NO_LIMIT_caring_address', true);  ?></h3>
								<div class="clearfix"></div>
							</header>
							<div class="excerpt"><p>lorem vulputate porttitor et ornare enim. Praesent sit amet nulla elementum, feugiat nibh ut, gravida quam. Proin dui felis, congue eu tempor a..</p></div>
						</div>
					</li>		
				<?php
						endwhile;
						wp_reset_query(); 								
				?>
				</ul>
				    <?php endif; ?>
					<?php theme_pagination( $home_helps_query->max_num_pages); ?>
				<div class="clearfix"></div>
			</div>
		</section>
	</div>
<?php get_footer();?>