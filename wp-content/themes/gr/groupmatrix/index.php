<?php
 get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-9">
						<?php if( is_search() ) :?>
							<div class="page-header"><h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'groupmatrix' ), get_search_query() ); ?></h1></div>
						<?php else : ?>
						<div class="page-header"><h1 class="page-title"><?php h1_title(); ?></h1></div>
						<?php endif; ?>
						<div class="entry-content">							
							<?php if ( have_posts() ) : ?>
								<?php
									while ( have_posts() ) : the_post();
										get_template_part( 'includes/content', get_post_format() );
									endwhile;
									 wp_pagenavi(); 

								else : ?>
								<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'groupmatrix' ); ?></p>
									<?php get_search_form(); ?>
							<?php 	endif; ?>					
						</div>
					</div>
					<?php get_sidebar();?>
				</div>
			</div>
		</div>			
	</div>
<?php get_footer(); ?>