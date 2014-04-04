<?php get_header(); ?>

<section id="contents">
	<?php get_template_part('includes/content','featured');?>
	<div class="recent-post">
		<div class="pull-right-bg hidden-xs"></div>
		<div class="container">
			<h1><span>This Brings Results To Your </span>Personal Injury Firm</h1>				
			<?php get_template_part('includes/content','portfolio')?>
		</div>
		<div id="footer-recent-post">
			<div class="container">
				<div class="moredetails">
					<p class="align-center"><a href="<?php echo get_page_link(14)?>" class="cwbtn cwbtn-green">Contact Us To See More &nbsp; &nbsp; &nbsp; <img src="<?php echo get_template_directory_uri(); ?>/images/btn-green-play.jpg" alt="#"/></a></p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>