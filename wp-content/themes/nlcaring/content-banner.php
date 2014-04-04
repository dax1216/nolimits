<div id="bannerHolder">
	<div class="wrapper">
		<section id="banner">
			<ul>
				<li>
					<img class="bannerImg" src="<?php echo get_template_directory_uri(); ?>/contents/images/heart.png" />
					<div class="bannerDesc">
						<h1><?php echo get_option('theme_banner_title'); ?></h1>
						<p><?php echo get_option('theme_banner_text'); ?></p>
						<?php $link = get_option('theme_banner_link'); ?>
						<?php if($link) :?>
							<a href="<?php echo $link; ?>" class="nl-btn red"><i class="fa fa-play"></i> &nbsp; <?php get_option('theme_banner_link_text'); ?></a>
						<?php endif; ?>
					</div>
					<div class="clearfix"></div>
				</li>
			</ul>
		</section>
	</div>
</div>