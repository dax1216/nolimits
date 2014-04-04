<?php get_header(); ?>
	<div id="contents" class="cols">
		<?php get_template_part('includes/content','breadcrumbs');?>	
		<div id="page-content">
			<div class="container">	
				<div class="row">
					<div id="main-col" class="col-sm-8">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<div class="page-header"><h1 class="page-title"><?php h1_title(); ?></h1></div>
							<div class="entry-content">
								<?php //the_content(); ?>
								<div class="form style2 nice">
									<?php echo do_shortcode('[contact-form-7 id="166" title="Contact form"]');?>
									<!--p  class="required"><span>*</span> Required Information</p>
									<div class="textfield">
										<p><input type="text" placeholder="Name *"/></p>
										<p><input type="tel" placeholder="Phone *"/></p>
										<p><input type="email" placeholder="Email *"/></p>
										<p><input type="text" placeholder="Organization *"/></p>
										<p><input type="text" placeholder="Position *"/></p>
									</div>
									<h3 class="title">Types of cases (Check all that apply)</h3>
									<div class="radiofield">
										<ul>
											<li><input type="checkbox" name="cases"/>Auto Accidents</li>
											<li><input type="checkbox" name="cases"/>Insurance Defense</li>
											<li><input type="checkbox" name="cases"/>Medical Malpractice</li>
											<li><input type="checkbox" name="cases"/>Corporate</li>
											<li><input type="checkbox" name="cases"/>Product Liability</li>
											<li><input type="checkbox" name="cases"/>General Practice</li>
											<li><input type="checkbox" name="cases"/>Mass Tort / Class Action</li>
											<li><input type="checkbox" name="cases"/>Other</li>
											<li><input type="checkbox" name="cases"/>Contract</li>
										</ul>
									</div>
									<div class="messagefield">
										<textarea placeholder="Questions / Comments" rows="5"></textarea>
									</div>
									<h3 class="title">Optional Information</h3>
									<div class="textfield">
										<p><input type="text" placeholder="Total company sales"/></p>
										<p><input type="text" placeholder="Docket size"/></p>
										<p><input type="text" placeholder="Number of employees"/></p>
										<p><input type="text" placeholder="Years in practice"/></p>
										<p><input type="text" placeholder="Advertising expenses year to date"/></p>
									</div>
									<p><input type="submit" value="Click to send this information to our experts"/></p-->
								</div>
							</div>
						<?php endwhile; endif; ?>
					</div>
					<?php get_sidebar('contact');?>
				</div>
			</div>
		</div>			
	</div>
<?php get_footer(); ?>