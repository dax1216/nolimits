<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<div id="pageBody">
		<div class="section-heading main">
			<div class="wrapper">
				<h1 class="page-title">CALL TO HELP</h1>
			</div>
		</div>
		<section class="wrapper">
			<div class="callToHelp">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>

		</div><!-- #content -->	
			<div class="clearfix"></div>
			</div>
		</section>
	</div>	
<?php
get_footer();
