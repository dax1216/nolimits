<div class="widget">
	<h3 class="title">Our Results Can<br> Be Your Results</h3>
	<?php 
		$args = array(
			'post_type' => 'cw_results',
			'posts_per_page' => 1,
			'orderby' => 'rand'
		);
		$query = new WP_Query( $args ); 
		if ( $query->have_posts() ) { ?>
			<?php	while ( $query->have_posts() ) { $query->the_post(); ?>
				<div class="box">
					<p><?php $ftext = get_field('featured_text'); 
					if(!empty($ftext)){
						echo '<span class="extra-strong">'.$ftext.'</span>';
					} echo excerpt(35); ?></p>
				</div>
			<?php	} ?>
			<p class="more"><a href="<?php echo get_page_link(12); ?>">See more results <i class="fa fa-angle-double-right"></i></a></p>
		<?php } else { ?>
			<p>No Result yet.</p>
		<?php }
		wp_reset_postdata(); ?>
</div>