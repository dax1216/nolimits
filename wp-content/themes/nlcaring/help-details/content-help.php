<?php $status  = help_status(); ?>
<li class="cell <?php echo ( $status == 'Hero Rally')  ? 'hero-rally' :  (($status == 'Journey') ? 'journey'  : 'call-to-help' ); ?>">
	<a href="<?php the_permalink(); ?>" title="" class="thumbnail">	
	<?php help_thumbnail();	?>
	<span class="cover"><span class="status">JOURNEY ACTIVATED</span></span> <?php echo ($status =='Hero Rally')  ? '<span class="btn-help"></span>' : '' ?></a>
	<div class="box-body">
		<header class="title">
		<?php help_badge(); ?>
			<h3><?php  the_title(); ?> <br/><?php the_author() ?> <br/><?php  help_location();  ?></h3>
			<div class="clearfix"></div>
		</header>
		<div class="excerpt"><p><?php echo excerpt(30); ?></p></div>
	</div>
</li>