<?php get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-8">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<div class="page-header"><h1 class="page-title"><?php h1_title(); ?></h1></div>
							<div class="entry-content">
								<?php 
									if ( has_post_thumbnail() ) { ?>
										<p><?php the_post_thumbnail('full', array('class'=>'attachment')); ?></p>
								<?php 	} ?>
								<?php the_content(); ?>
							</div>
						<?php endwhile; endif; ?>
					</div>
					<?php get_sidebar();?>
				</div>
			</div>
		</div>		
		<?php get_template_part('includes/content','featured');?>		
	</div>
<?php get_footer(); ?>