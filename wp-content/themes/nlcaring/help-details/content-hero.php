<?php
	$prefix = 'NO_LIMIT_';
?>
<a href="#inline" class="btn-hero fancybox"></a>							
<div id="inline" style="display:none;width:800px;">
	<div class="popupBody">
		<?php 
			if(is_user_logged_in()){

				// Get User Id
				global $current_user;
				get_currentuserinfo();

				$post_id = get_the_ID();
				$post_meta_data = get_post_custom($post_id);
				
				$caring_badge = get_post_meta( $post_id, $prefix.'caring_badge',true);  
				$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
			   
		?>
		<div class="popTop">
			<div class="hRally">
				<img src="<?php echo get_template_directory_uri(); ?>/contents/images/pop-heart.png" />
				<div class="hCount">
					<span class="label">Hero Rally:</span>
					<span class="hnumber"><span>#</span>23</span>
				</div>
			</div>
			<div class="hBadge">
				<div class="headerBadge">
					<div class="popBadge"><img class="popBadge" src="<?php echo $caring_badge[0];?>" /></div>
					<div class="heroText">
						<img src="<?php echo get_template_directory_uri(); ?>/contents/images/you-are-a-hero.png" />
						<h4>Super Shoe Badge</h4>
					</div>
					<div class="clearfix"></div>
				</div><!--.headerBadge-->
				<div class="hproductDetails">
					<p>This project requires thte purchase of non printable items:</p>
					<table width="100%">
						<tr>
							<th>Name:</th>
							<th>Manufacturer:</th>
							<th>Price:</th>
							<th></th>
						</tr>
							<?php
								for($inum_data = 0; $inum_data < $post_meta_data[$prefix.'txtnum'][0]; $inum_data++) {
							?>
								<tr>
									<td><?php echo $post_meta_data[$prefix.'pname_'.$inum_data][0]; ?></td>
									<td><?php echo $post_meta_data[$prefix.'pmanuf_'.$inum_data][0]; ?></td>
									<td class="price"><?php echo $post_meta_data[$prefix.'pprice_'.$inum_data][0]; ?></td>
									<td><a href="<?php echo $post_meta_data[$prefix.'plink_'.$inum_data][0]; ?>" target="_blank">Take me there</a></td>
								</tr>
							<?php
								}
							?>
						</table>
				</div>
			</div>
			<div class="clearfix"></div>
		</div><!--.popTop-->
		<div class="popBtm">
			<div class="artHeading">
				<h3>Thank you for your heroic action helping:</h3>											
			</div>
			<div class="needHelp">
				<div class="helpImg">
					<img src="<?php echo get_template_directory_uri(); ?>/contents/images/need-help.jpg" />
					<div class="cover"></div>
				</div>
				<div class="helpAddress">
					<h3>Children Need Shoes</h3>
					<p><strong>LOCATION: </strong><br/>
						Kudenga House, 3 Baines <br/>
						Avenue, Corner Prince<br/>
						Edward, St. Marher</p>
					<p>
						<strong>POSTAL ADDRESS:</strong><br/>
						P.O. Box 334, Horace, Zimbabwe</p>
				</div>
				<div class="clearfix"></div>
				<p class="helpCaption">My family and I need shoes! please help!</p>
			</div>
			<div class="helpProduct">
				<a  class="img"  href="<?php echo get_template_directory_uri(); ?>/contents/images/img-print-1.jpg"><img src="<?php echo get_template_directory_uri(); ?>/contents/images/img-print-1.jpg" /></a>
				<p align="center"><a href="#" class="nl-btn red large"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-download.png" /> &nbsp; Download and Print!</a></p>
			</div>
			<div class="clearfix"></div>
		</div><!--popTop-->
		<?php 
			}else{
				?>
				<div class="alert-wrapper">
					<h5><?php _e('Please, Log in to view your hero rally!', 'framework') ?></h5>
				</div>
				<?php
			}
		?>	
	</div>
</div>