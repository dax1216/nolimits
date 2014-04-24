<?php
/**
 * Template Name: Call to help
 *
 */


get_header(); ?>
<div id="pageBody">
		<div class="section-heading main">
			<div class="wrapper">
				<h1 class="page-title">CALL TO HELP</h1>
			</div>
		</div>
		<section class="wrapper">
			<div class="callToHelp">
				<?php 			
					
						$number_of_help = intval(get_option('theme_number_of_helps'));
						 if(!$number_of_help){
								$number_of_help = 8;
						  }
						
						$help_args = array(
							'post_type' => 'caring',
							'posts_per_page' => $number_of_help,
							'paged' => $paged
						);
						
						$sorty_by = get_option('theme_sorty_by');
					
							if( !empty($sorty_by) ){
								if( $sorty_by == 'hero-to-call' ){
									$help_args['orderby'] = 'meta_value_num';
									$help_args['meta_key'] = 'NO_LIMIT_help_status';
									$help_args['order'] = 'DESC';
								}elseif( $sorty_by == 'call-to-hero' ){
									$help_args['orderby'] = 'meta_value';
									$help_args['meta_key'] = 'NO_LIMIT_help_status';
									$help_args['order'] = 'ASC';
								}
							}
					
					   $home_helps_query = new WP_Query( $help_args );
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

<?php get_footer(); ?>
