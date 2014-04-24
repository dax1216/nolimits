<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
?>
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #main .site-main -->
<div id="footerHolder">
<footer id="footer">
	<div class="wrapper">
		<div class="footerTop">
			<div class="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.png" alt="No Limits Caring"></a></div>
			<nav id="footerNav">
					<?php
							wp_nav_menu( array(
								'menu'              => 'primary',
								'theme_location'    => 'primary',
								'container'         => false,
								'menu_class'        => 'menu',
								));
						?>
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
</div><!-- #page .hfeed .site -->
<?php wp_footer(); ?>
<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
</body>
</html>