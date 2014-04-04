<div id="sidebar" class="col-sm-3">
	<div class="widgets">
		<?php if(is_page('about')) { 
			get_template_part('includes/widget','contact_form');
			} elseif( is_page('results')) { 			
				get_template_part('includes/widget','contact_form');
				get_template_part('includes/widget','client_says');	
				get_template_part('includes/widget','video');
			}else{
				get_template_part('includes/widget','contact_form');
				get_template_part('includes/widget','client_says');	
				get_template_part('includes/widget','results');
				get_template_part('includes/widget','video');
			}
			dynamic_sidebar( 'right-sidebar' );
			?>
	</div>
</div>