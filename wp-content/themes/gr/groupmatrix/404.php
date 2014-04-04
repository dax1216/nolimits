<?php get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-12">
						<div class="page-header"><h1 class="page-title">Error 404: Page not found</h1></div>
						<div class="entry-content">      
							  <p>Sorry, the page you are looking for cannot be found.  Try using the search above:</p>
							  <?php get_search_form(); ?>						
						</div>
					</div>
				</div>
			</div>
		</div>			
	</div>
<?php get_footer(); ?>