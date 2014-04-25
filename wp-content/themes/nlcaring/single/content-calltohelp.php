<section class="wrapper">
	<div class="callToHelp">
		<?php  help_gallery(); ?>	
		<div class="helpSlogan col-half">
			<div class="artworkHeader"><h2><?php the_title();?> <?php edit_help_link(); ?></h2></div>
			<ul class="helpDetails">
				<li><?php the_author() ?> </li>
				<li>WHERE THIS HAPPENED</li>
				<li>LOCATION: <?php echo help_location(); ?></li>
				<li class="mapLink">GOOGLE MAP: <a href="#">link1234adaasdfkjlsldjf... </a></li>
			</ul>
			<div class="helpBadge">
				<?php help_badge('full'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div class="helpBody">
			<div  class="helpDescription full  ">
				<div id="description">
					<h4 class="heading">DESCRIPTION</h4>
					<?php the_content(); ?>
				</div>				
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="clearfix"></div>
