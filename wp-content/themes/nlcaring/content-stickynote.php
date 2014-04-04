<div class="stickyNote">
	<div class="stickyBody">
		<a class="thumbnail" href="#">
			<?php
				if( has_post_thumbnail( $post->ID ) ){
					echo get_the_post_thumbnail( $post->ID, 'default_help', array( 'class'=>'help_thumb') );
				}else{
					echo '<img width="220" height="157" src="'.get_template_directory_uri().'/contents/images/default.jpg" />';
				}
			?>
			<span class="cover"></span>
		</a>						
		<div class="title">
			<?php													
			$caring_badge = get_post_meta( $post->ID, $prefix.'caring_badge',true);  
			$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
			if(  isset($caring_badge[0])  ){
				echo '<img class="badge" width="30" src="'.$caring_badge[0].'" />';						
			}else{
				echo '<img  class="badge" width="30" src="'.get_template_directory_uri().'/contents/images/badge-default.png" />';		
			}
			?>								
			<h3><?php the_title(); ?> <br><?php the_author(); ?> <br><?php echo get_post_meta($post->ID, 'NO_LIMIT_caring_address', true);  ?> </h3>
			<p class="googlelink">GOOGLE MAP: <a href="#"> link1234adaasdfkj </a></p>
			<div class="clearfix"></div>
		</div>
		<p align="center"><a href="#" class="nl-btn red viewdetails">VIEW DETAILS</a></p>
	</div>
</div>