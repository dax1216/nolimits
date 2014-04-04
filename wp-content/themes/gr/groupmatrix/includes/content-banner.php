<?php 	$banner = get_field('banner_image');  
		$banner_video = get_field('add_banner_video'); 
		$get_video_url = get_field('vid_url',$banner_video->ID); 
		$get_video_uploaded = get_field('upload_video',$banner_video->ID); 
?>
<?php if(!empty($banner)) : ?>
	<section id="banner">
		<img class="banner" src="<?php echo $banner['url']; ?>" alt="<?php echo $banner['alt']; ?>"/>	
		<div class="container">
			<div class="caption">
				<?php the_field('banner_description'); ?>				
				<p class="cw-video-play hidden-xs"><a href="<?php echo (!empty($get_video_url)) ? $get_video_url : $get_video_uploaded; ?>">Who is Group Matrix? Watch our video. <img src="<?php echo get_template_directory_uri(); ?>/images/btn-play.png" alt="#" /></a></p>
				
			</div>	
		</div>	
	</section>
<?php endif; ?>
