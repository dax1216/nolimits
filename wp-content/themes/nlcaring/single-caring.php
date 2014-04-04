<?php get_header(); ?>
 <div id="pageBody">
		<?php if(help_status() =='Hero Rally' || help_status() =='Journey') : ?>	
			<div class="section-heading main">
				<div class="wrapper">
					<h1 class="page-title">HERO RALLY</h1>
				</div>
			</div>
		<?php endif; ?>
		<section class="wrapper">
			<div class="callToHelp">
			<?php
			$thumbnail_big = 'gallery_image';
			$thumbnail_small = 'thumbnail';
			 if ( have_posts() ) :
				 while ( have_posts() ) :
					the_post(); 			
			?>	
			<?php if(help_status() =='Hero Rally') : ?>	
					<?php get_template_part('content','stickynote'); ?>
					<section class="slider">						
						<div id="slider" class="flexslider">								
						  <ul class="slides">
								<?php 
								$gallery_images = rwmb_meta( 'NO_LIMIT_caring_hero_images', 'type=plupload_image&size='.$thumbnail_big, $post->ID );
								$thumb_images = rwmb_meta( 'NO_LIMIT_caring_hero_images', 'type=plupload_image&size='.$thumbnail_small, $post->ID );										
								if(!empty($gallery_images)) { 
									 foreach( $gallery_images as $prop_image_id=>$prop_image_meta ){
										echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li>';
									}						
								}else{
									 if( has_post_thumbnail( $post->ID ) ){ /*Set featured image if no gallery*/										
										echo '<li>'.get_the_post_thumbnail( $post->ID, 'thumbnail_big' ).'<span class="cover">&nbsp;</span></li>';
									}else{ /* if no all, Set Default Image*/
										echo '<li><img width="335" height="222" src="'.get_template_directory_uri().'/contents/images/default.jpg"></li>';
									}
								}										
								?>
						  </ul>
						</div>
						<div id="carousel" class="flexslider">
						  <ul class="slides">
							<?php 						
								 foreach( $thumb_images as $prop_image_id=>$prop_image_meta ){
									echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li></li>';
								}						
							?>
						  </ul>
						</div>					
					</section>
					<div class="helpSlogan">
						<?php
							$slogan = get_post_meta( $post->ID,'NO_LIMIT_caring_slogan',true); 
							$sloganTxt = get_post_meta( $post->ID,'NO_LIMIT_caring_slogan_text',true); 
							if(!empty($slogan)){
								echo '<h2>'.$slogan.'</h2>';
							}
							if(!empty($sloganTxt)){
								echo '<div class="sloganTxt">'.$sloganTxt.'</div>';
							}
						?>
						<p class="version">Version No.: 4</p>
					</div>
					<div class="clearfix"></div>
				<?php elseif( help_status() =='Call to Help' ): ?>
					<section class="slider big">						
						<div id="slider" class="flexslider">								
						  <ul class="slides big">
								<?php 
								$gallery_images = rwmb_meta( 'NO_LIMIT_caring_images', 'type=plupload_image&size='.$thumbnail_big, $post->ID );
								$thumb_images = rwmb_meta( 'NO_LIMIT_caring_images', 'type=plupload_image&size='.$thumbnail_small, $post->ID );										
								if(!empty($gallery_images)) { 
									 foreach( $gallery_images as $prop_image_id=>$prop_image_meta ){
										echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li>';
									}						
								}else{
									 if( has_post_thumbnail( $post->ID ) ){ /*Set featured image if no gallery*/										
										echo '<li>'.get_the_post_thumbnail( $post->ID, 'thumbnail_big' ).'<span class="cover">&nbsp;</span></li>';
									}else{ /* if no all, Set Default Image*/
										echo '<li><img width="335" height="222" src="'.get_template_directory_uri().'/contents/images/default.jpg"></li>';
									}
								}										
								?>
						  </ul>
						</div>
						<div id="carousel" class="flexslider">
						  <ul class="slides">
							<?php 						
								 foreach( $thumb_images as $prop_image_id=>$prop_image_meta ){
									echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li></li>';
								}						
							?>
						  </ul>
						</div>					
					</section>		
					<div class="helpSlogan col-half">
					<div class="artworkHeader"><h2><?php the_title();?></h2></div>
					<ul class="helpDetails">
						<li><?php the_author() ?> </li>
						<li>WHERE THIS HAPPENED</li>
						<li>LOCATION: <?php echo get_post_meta($post->ID, 'NO_LIMIT_caring_address', true);  ?></li>
						<li class="mapLink">GOOGLE MAP: <a href="#">link1234adaasdfkjlsldjf... </a></li>
					</ul>
					<div class="helpBadge">
					<?php													
							$caring_badge = get_post_meta( $post->ID,'NO_LIMIT_caring_badge',true);  
							$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
							if(  isset($caring_badge[0])  ){
								echo '<img class="badge" width="137" src="'.$caring_badge[0].'" />';						
							}else{
								echo '<img  class="badge" width="137" src="'.get_template_directory_uri().'/contents/images/badge-big.png" />';		
								
							}
						?>
					
					</div>
					<div class="clearfix"></div>
				</div>
			<?php endif; ?>			
				<div class="clearfix"></div>
				<div class="helpBody">
					<div  class="helpDescription full  ">
						<div id="description" class="<?php echo (help_status() =='Hero Rally'  ||  help_status() =='Journey' ) ? 'hidden' : '' ; ?>">
							<h4 class="heading">DESCRIPTION</h4>
							<?php the_content(); ?>
						</div>
						<?php 
						if(help_status() =='Hero Rally' ){
							get_template_part('content','instructions');
						}
						?>
					</div>
				</div>
				<div class="clearfix"></div>
			<?php
				 endwhile;
				if(help_status() !='Call to Help'){
					comments_template();
				}
				  
			 endif;
			 ?>	
			</div>
		</section>
	</div>		
<?php get_footer(); ?>