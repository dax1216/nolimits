<?php get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div class="container"><div class="page-header"><h1 class="page-title"><?php h1_title(); ?></h1></div></div>		
		<div class="recent-post">
			<div class="container">	
				<?php get_template_part('includes/content','portfolio')?>
			</div>
			<div id="footer-recent-post">
				<div class="container">
					<div class="moredetails">
						<p class="align-center"><a href="#" class="cwbtn cwbtn-green">Contact Us To See More &nbsp; &nbsp; &nbsp; <img src="<?php echo get_template_directory_uri(); ?>/images/btn-green-play.jpg" alt="#"/></a></p>
					</div>
				</div>
			</div>
		</div>
		<br/>
		<div class="recent-post">
			<div class="container">	
				<?php get_template_part('includes/content','portfolio')?>
			</div>
		</div>		
	</div>
<?php get_footer(); ?>