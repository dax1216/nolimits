
<?php 
		
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		add_action('comment_form_logged_in_after', 'add_attachement');
		
		// add image field
		
		function add_attachement(){
			$html = '<p class="attachment-txt">Attached Images to this comment</p>';
			$html .='<input type="file" name="c_image_attached"  accept="image/*" multiple/>';
			echo $html;
		}
		
		//saving images
		
		add_action( 'comment_post', 'save_attached_comment_meta_data' );
		
		function save_attached_comment_meta_data($comment_id){
			if( isset( $_POST['c_image_attached'] )  && $_POST['c_image_attached']  != '' ){
				$images = $_POST['c_image_attached'];
				add_comment_meta( $comment_id, 'c_image_attached', $images, false );
			}
		
		}
		
		//retrieving image
		add_filter( 'comment_text', 'modify_comment');
		
		function modify_comment( $text ){
			if( $images = get_comment_meta(  get_comment_ID(), 'c_image_attached', false )  ){
				
					var_dump($images);
				
				return $text;
				
			}else{
				return $text;
			}
				

		}
	
?>