<div class="widget">
	<h3 class="title">Our Clients Says</h3>
	<?php 
		$args = array(
			'post_type' => 'cw_testimonial',
			'posts_per_page' => 1,
			'orderby' => 'rand'
		);
		$query = new WP_Query( $args ); 
		if ( $query->have_posts() ) { ?>
			<?php	while ( $query->have_posts() ) { $query->the_post(); ?>
				<div class="box">
					<p class="quote"><?php echo excerpt(30);?></p>
				</div>
			<?php	} ?>
			<p  class="more"><a href="<?php echo get_page_link(140); ?>">See more testimonial <i class="fa fa-angle-double-right"></i></a></p>
		<?php } else { ?>
			<p>No Testimonial yet.</p>
		<?php } wp_reset_postdata(); ?>
</div>