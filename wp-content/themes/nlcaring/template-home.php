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
					?>
					<?php get_template_part('help-details/content','help'); ?>		
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