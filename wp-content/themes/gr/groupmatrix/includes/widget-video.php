<?php 
	$args = array(
		'post_type' => 'cw_video',
		'posts_per_page' => 1,	
		'orderby' => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => 'cat_video',
				'field' => 'slug',
				'terms' => 'portfolio'
			)
		)
		
	);
	$query = new WP_Query( $args ); 
	if ( $query->have_posts() ) { ?>
		<?php	while ( $query->have_posts() ) { $query->the_post(); ?>
		<div class="widget video">
			<div  class="attachment">										
				<?php 	$vid_thumb = get_field('vid_thumbnail');
						$get_video_url = get_field('vid_url'); 
						$get_video_uploaded = get_field('upload_video'); 
				?>
				<?php if(!empty($vid_thumb)):?>
					<img height="191" class="thumb" src="<?php echo $vid_thumb['url'];?>" alt="<?php echo $vid_thumb['alt'];?>" />
					<a href="<?php echo (!empty($get_video_url)) ? $get_video_url : $get_video_uploaded; ?>" class="btn-play"><img src="<?php echo get_template_directory_uri(); ?>/images/btn-play-video.png" alt="#"/></a>
				<?php endif;?>
			</div>
			<div class="box">
				<?php $show_title = get_field('show_vid_title');
					if($show_title == 'Yes'){
						echo '<h3>'.get_the_title().'</h3>';
					}
				 
					$show_description = get_field('show_vid_description');
						if($show_description == 'Yes'){
							echo '<p>'.get_field('video_description').'</p>';
						}
						
					$link = get_field('add_link');
					if(!empty($link)){
						echo '<p class="more"><a href="'.$link.'" class="read-more">Visit their website <i class="fa fa-angle-double-right"></i></a></p>';
					}		
				
				?>
				
			</div>
		</div>
<?php	} ?>
<?php } wp_reset_postdata(); ?>			