<div class="entry">
	<?php 
		if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink();?>">
			<?php the_post_thumbnail('blog_thumb', array('class'=>'align-left attachment')); ?>
			</a>
	<?php 	} ?>
	<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php h1_title(); ?></a></h3>
	<p><?php echo excerpt(30); ?> </p>
</div>