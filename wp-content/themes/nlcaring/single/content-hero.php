<div class="section-heading main">
	<div class="wrapper">
		<h1 class="page-title">HERO RALLY <?php edit_help_link(); ?></h1>
	</div>
</div>
<section class="wrapper">
	<div class="callToHelp">
		<?php 
			get_template_part('help-details/content','stickynote'); 
			help_gallery('hero'); 
			help_slogan();
			?>
			<div class="clearfix"></div>
			<div class="helpBody">
				<div  class="helpDescription full  ">
					<div id="description" class="hidden">
						<h4 class="heading">DESCRIPTION</h4>
						<?php the_content(); ?>
					</div>
					<?php get_template_part('help-details/content','instructions'); 	?>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php	comments_template();?>
	</div>
</div>
<div class="clearfix"></div>
