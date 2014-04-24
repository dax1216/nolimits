<?php get_header(); ?>
	<div id="pageBody">
			<?php 
			if ( have_posts() ) {
				 while ( have_posts() ) {
					 the_post();
					if(help_status()=='1'){
						 get_template_part('single/content','calltohelp');
					}elseif( help_status()=='2'){
						get_template_part('single/content','journey');
					}else{
						get_template_part('single/content','hero');
					}  
				}
			}
			?>
	</div>		
<?php get_footer(); ?>