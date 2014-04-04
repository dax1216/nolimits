<?php get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-9">
						<div class="page-header"><h1 class="page-title"><?php echo h1_title() ?></h1></div>
						<div class="entry-content">
							<?php 
							if ( have_posts() ) { ?>
								<?php	while ( have_posts() ) { the_post(); ?>
									<div class="entry">
										<?php 
											if ( has_post_thumbnail() ) { ?>
												<a href="<?php the_permalink();?>">
												<?php the_post_thumbnail('blog_thumb', array('class'=>'align-left attachment')); ?>
												</a>
										<?php 	} ?>
										<?php the_content(); ?>
									</div>
							<?php  } } ?>							
						</div>
					</div>
					<?php get_sidebar();?>
				</div>
			</div>
		</div>			
	</div>
<?php get_footer(); ?>