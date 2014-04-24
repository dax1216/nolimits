<div id="footerHolder">
		<footer id="footer">
			<div class="wrapper">
				<div class="footerTop">
					<div class="logo"><a href="/caring/"><img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="No Limits Caring"></a></div>
					<nav id="footerNav">
						<?php wp_nav_menu(array(
							'theme_location'=>'main_nav',
							'container'=>false
						));?>
					</nav>
					<div class="clearfix"></div>
				</div>
				<div class="footerBtm">
					<div class="copyright">Copyright  &copy; No Limits Creations</div>
					<div class="contactInfo">Call us +9 123.456.789 </div>
					<div class="clearfix"></div>
				</div>
			</div>
		</footer>
	</div>
	<?php wp_footer(); ?>
    <script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>
    <script text/javascript>
		(function($){
			noLimits.init();
			noLimits.masonry(jQuery);		
		})(jQuery)
		
		
		jQuery(document).ready(function() {
			jQuery(".fancybox").fancybox({
				maxWidth	: 790,
				maxHeight	: 867,
				fitToView	: false,
				width		: '80%',
				height		: '95%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
		
	</script>
	
	<?php if(is_singular('caring')) :?>
			  <script type="text/javascript">	
				jQuery(window).load(function(){
						noLimits.slider(jQuery);				
				});
			</script>
	<?php endif;?>
</body>
</html>