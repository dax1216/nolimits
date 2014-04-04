<?php
/*
* Template Name: Case Results
*/
 get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-9">
						<div class="page-header"><h1 class="page-title"><?php h1_title(); ?></h1></div>
						<div class="entry-content">
							<?php 
							$paged = get_query_var('paged') ? get_query_var('paged') : 1;
							$args = array(
								'post_type' 		=> 'cw_results',
								'posts_per_page'	=> 6,
								'paged' => $paged,
							);
							$query = new WP_Query( $args ); 
							if ( $query->have_posts() ) { ?>
								<?php	while ( $query->have_posts() ) { $query->the_post(); ?>
									<div class="entry">
										<?php 
											if ( has_post_thumbnail() ) { ?>
												<a href="<?php the_permalink();?>">
												<?php the_post_thumbnail('blog_thumb', array('class'=>'align-left attachment')); ?>
												</a>
										<?php 	} ?>
										<p><?php $ftext = get_field('featured_text'); 
											if(!empty($ftext)){
												echo '<span class="extra-strong">'.$ftext.'</span>';
											}
											echo excerpt(40);?></p>
									</div>
									
								<?php  wp_pagenavi(); 	} ?>
								<?php } else { ?>
								<p>No case result yet.</p>
							<?php } wp_reset_postdata(); 
								
							?>							
						</div>
					</div>
					<?php get_sidebar();?>
				</div>
			</div>
		</div>			
	</div>
<?php get_footer(); ?>