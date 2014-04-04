	<?php get_template_part('includes/content','clients');?>
	<footer id="footer">
		<div id="footer-nav" class="menu visible-xs">
			<?php  wp_nav_menu( array( 'theme_location' =>'mobile_footer_nav','container'=>false)); ?>
		</div>
		<?php get_template_part('includes/content','tap_buttons');?>
		<div class="container">
			<div class="row">			
				<?php get_template_part('includes/content','social_media');?>				
				<div class="col-sm-9 copy">
					<p>&copy; 2014 Group Matrix - All Rights Reserved</p>
					<p>Site by <a href="www.Consultwebs.com">Consultwebs.com:</a> Law Firm Website Designers / Personal Injury Lawyer Marketing.</p>
				</div>				
			</div>
		</div>
	</footer>	
	<?php wp_footer(); ?>
	<script type="text/javascript">
		jQuery(function(){
			Matrix.init();
		})
	</script>
  </body>
</html>