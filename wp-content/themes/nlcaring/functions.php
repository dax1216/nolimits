<?php

 /*No Limits Codes Start Here*/
 
/*	Load Text Domain
/*-----------------------------------------------------------------------------------*/
    load_theme_textdomain( 'framework' ); 
 
 /*	Include Meta Box
/*-----------------------------------------------------------------------------------*/
    define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/framework/meta-box' ) );
    define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/framework/meta-box' ) );
    require_once RWMB_DIR . 'meta-box.php';
    require_once RWMB_DIR . 'config-meta-boxes.php';

/*	Include Custom Post Types
/*-----------------------------------------------------------------------------------*/
    require_once ( get_template_directory() . '/framework/include/caring-post-type.php' );


/*	Include Theme Options Framework
/*-----------------------------------------------------------------------------------*/
    require_once(get_template_directory() . '/framework/admin/admin-functions.php');
    require_once(get_template_directory() . '/framework/admin/admin-interface.php');
    require_once(get_template_directory() . '/framework/admin/theme-settings.php');

 

/*-----------------------------------------------------------------------------------*/
/*	Include Theme Functions for Various Important Features
/*-----------------------------------------------------------------------------------*/
    require_once(get_template_directory() . '/framework/functions/contact_form_handler.php');
    require_once(get_template_directory() . '/framework/functions/theme_comment.php');
    require_once(get_template_directory() . '/vendor/comment-images/comment-image.php');

/*-----------------------------------------------------------------------------------*/
// Generate Hirarchical Options
/*-----------------------------------------------------------------------------------*/
if(!function_exists('generate_hirarchical_options')){
    function generate_hirarchical_options($taxonomy_name, $taxonomy_terms, $searched_term, $prefix = " " ){
        if (!empty($taxonomy_terms)) {
            foreach ($taxonomy_terms as $term) {
                if ($searched_term == $term->slug) {
                    echo '<option value="' . $term->slug . '" selected="selected">' . $prefix . $term->name . '</option>';
                } else {
                    echo '<option value="' . $term->slug . '">' . $prefix . $term->name . '</option>';
                }
                $child_terms = get_terms($taxonomy_name, array(
                    'hide_empty' => false,
                    'parent' => $term->term_id
                ));

                if (!empty($child_terms)) {
                    /* Recursive Call */
                    generate_hirarchical_options( $taxonomy_name, $child_terms, $searched_term, "- ".$prefix );
                }
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
// Propert Submit/Edit Form Helper Function
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'is_valid_image' ) ){
    function is_valid_image($file_name){
        $valid_image_extensions = array( "jpg", "jpeg", "gif", "png" );
        $exploded_array = explode('.',$file_name);
        if( !empty($exploded_array) && is_array($exploded_array) ){
            $ext = array_pop( $exploded_array );
            return in_array( $ext, $valid_image_extensions );
        }else{
            return false;
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Get Default Banner
/*-----------------------------------------------------------------------------------*/
if(!function_exists('get_default_banner')){
    function get_default_banner(){
        $banner_image_path = get_option('theme_general_banner_image');
        return empty($banner_image_path)? get_template_directory_uri().'/images/banner.jpg' :$banner_image_path;
    }
}



/*-----------------------------------------------------------------------------------*/
/*	Get Lightbox Plugin Class
/*-----------------------------------------------------------------------------------*/
if(!function_exists('get_lightbox_plugin_class')){
    function get_lightbox_plugin_class(){
        $lightbox_plugin_class = get_option('theme_lightbox_plugin');
        if($lightbox_plugin_class){
            return $lightbox_plugin_class;
        }else{
            return 'swipebox';
        }
    }
}



/*-----------------------------------------------------------------------------------*/
/*	Generate Gallery Attribute
/*-----------------------------------------------------------------------------------*/
if(!function_exists('generate_gallery_attribute')){
    function generate_gallery_attribute(){
        $lightbox_plugin_class = get_lightbox_plugin_class();
        if($lightbox_plugin_class == 'pretty-photo'){
            return 'data-rel="prettyPhoto[real_homes]"';
        }
        return '';
    }
}




/*-----------------------------------------------------------------------------------*/
// Propert Edit Form - Gallery Image Removal
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_remove_gallery_image', 'remove_gallery_image' );

if( !function_exists( 'remove_gallery_image' ) ){
    function remove_gallery_image(){
        if( isset($_POST['help_id']) && (!empty($_POST['help_id'])) && isset($_POST['gallery_img_id']) && (!empty($_POST['gallery_img_id'])) ){
            $help_id = $_POST['help_id'];
            $gallery_img_id = $_POST['gallery_img_id'];
            if(delete_post_meta($help_id, 'NO_LIMIT_caring_images', $gallery_img_id)){
                echo 3;
                /* Removed successfully! */
            }else{
                echo 2;
                /* Failed to remove! */
            }
        }else{
            echo 1;
            /* Invalid parameters! */
        }
        die;
    }
}



/*-----------------------------------------------------------------------------------*/
// Propert Edit Form - Featured Image Removal
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_remove_badge_image', 'remove_badge_image' );

if( !function_exists( 'remove_badge_image' ) ){
    function remove_badge_image(){
        if( isset($_POST['help_id']) && (!empty($_POST['help_id'])) ){
            $help_id = $_POST['help_id'];
            if(delete_post_meta( $help_id, 'NO_LIMIT_caring_badge')){
                echo 3;
                /* Removed successfully! */
            }else{
                echo 2;
                /* Failed to remove! */
            }
        }else{
            echo 1;
            /* Invalid parameters! */
        }
        die;
    }
}


/*-----------------------------------------------------------------------------------*/
// Propert Edit Form - Featured Image Removal
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_remove_featured_image', 'remove_featured_image' );

if( !function_exists( 'remove_featured_image' ) ){
    function remove_featured_image(){
        if( isset($_POST['help_id']) && (!empty($_POST['help_id'])) ){
            $help_id = $_POST['help_id'];
            if(delete_post_meta( $help_id, '_thumbnail_id' )){
                echo 3;
                /* Removed successfully! */
            }else{
                echo 2;
                /* Failed to remove! */
            }
        }else{
            echo 1;
            /* Invalid parameters! */
        }
        die;
    }
}


/*-----------------------------------------------------------------------------------*/
// Propert Submit/Edit Form Helper Function
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'is_valid_image' ) ){
    function is_valid_image($file_name){
        $valid_image_extensions = array( "jpg", "jpeg", "gif", "png" );
        $exploded_array = explode('.',$file_name);
        if( !empty($exploded_array) && is_array($exploded_array) ){
            $ext = array_pop( $exploded_array );
            return in_array( $ext, $valid_image_extensions );
        }else{
            return false;
        }
    }
}



/*-----------------------------------------------------------------------------------*/
// Alert
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'alert' ) ){
    function alert( $heading = '', $message = '' ){
        echo '<div class="alert">';
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo '<strong>'.$heading.'</strong> <span>'.$message.'</span>';
        echo '</div>';
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Insert Attachment Method for help Submit Template
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'insert_attachment' ) ){
    function insert_attachment( $file_handler, $post_id, $setthumb = false ){

        // check to make sure its a successful upload
        if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attach_id = media_handle_upload( $file_handler, $post_id );

        if ($setthumb){
            update_post_meta($post_id,'_thumbnail_id',$attach_id);
        }

        return $attach_id;
    }
}
/*-----------------------------------------------------------------------------------*/
//	Theme Pagination Method
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'theme_pagination' ) ){
    function theme_pagination($pages = ''){
        global $paged;

        if(is_page_template('template-home.php')){
            $paged = intval(get_query_var( 'page' ));
        }

        if(empty($paged))$paged = 1;

        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 2; // only change it to show more links
        $showitems = ($range * 2)+1;

        if($pages == ''){
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages){
                $pages = 1;
            }
        }


        if(1 != $pages){
            echo "<div class='pagination'>";
            echo ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<a href='".get_pagenum_link(1)."' class='real-btn'>&laquo; ".__('First', 'framework')."</a> ":"";
            echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' class='real-btn' >&laquo; ". __('Previous', 'framework')."</a> ":"";

            for ($i=1; $i <= $pages; $i++){
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                    echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='real-btn current' >".$i."</a> ":"<a href='".get_pagenum_link($i)."' class='real-btn'>".$i."</a> ";
                }
            }

            echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."' class='real-btn' >". __('Next', 'framework') ." &raquo;</a> " :"";
            echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."' class='real-btn' >". __('Last', 'framework') ." &raquo;</a> ":"";
            echo "</div>";
        }
    }
}



/*-----------------------------------------------------------------------------------*/
/*	Load Required CSS Styles
/*-----------------------------------------------------------------------------------*/
    if(!function_exists('load_theme_styles')){
        function load_theme_styles(){
            if (!is_admin()){

                // enqueue required fonts
                $protocol = is_ssl() ? 'https' : 'http';
                wp_enqueue_style( 'theme-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic&subset=latin,cyrillic" );
                wp_enqueue_style( 'theme-lato', "$protocol://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" );

                // register styles
                wp_register_style('bootstrap-css',  get_template_directory_uri() . '/nolimit-css/bootstrap.css', array(), '2.2.2', 'all');
                wp_register_style('pretty-photo-css',  get_template_directory_uri() . '/nolimit-js/prettyphoto/prettyPhoto.css', array(), '3.1.4', 'all');
                wp_register_style('swipebox-css',  get_template_directory_uri() . '/nolimit-js/swipebox/swipebox.css', array(), '3.1.4', 'all');
                wp_register_style('flexslider-css',  get_template_directory_uri() . '/nolimit-js/flexslider/flexslider.css', array(), '2.1', 'all');
                wp_register_style('main-css',  get_template_directory_uri() . '/nolimit-css/default.css', array(), '1.3', 'all');
                wp_register_style('custom-responsive-css',  get_template_directory_uri() . '/nolimit-css/custom-responsive.css', array(), '1.0', 'all');
                wp_register_style('custom-css',  get_template_directory_uri() . '/nolimit-css/custom.css', array(), '1.0', 'all');
                wp_register_style('fancybox',  get_template_directory_uri() . '/vendor/fancybox/jquery.fancybox.css', array(), '2.1.5', 'all');

                wp_enqueue_style('fancybox');
                wp_enqueue_style('main-css');
          
            }
        }
    }
    add_action('wp_enqueue_scripts', 'load_theme_styles');




/*-----------------------------------------------------------------------------------*/
/*	Load Required JS Scripts
/*-----------------------------------------------------------------------------------*/
    if(!function_exists('load_theme_scripts')){
        function load_theme_scripts(){
            if (!is_admin()) {

                // Defining scripts directory url
                $java_script_url = get_template_directory_uri().'/nolimit-js/';
                $java_script_url1 = get_template_directory_uri().'/js/';
                $vendor_url = get_template_directory_uri().'/vendor/';

                // Registering Scripts
				  wp_register_script('flexslider', $java_script_url.'flexslider/jquery.flexslider-min.js', array('jquery'), '2.1', false);
                wp_register_script('easing', $java_script_url.'elastislide/jquery.easing.1.3.js', array('jquery'), '1.3', false);
                wp_register_script('elastislide', $java_script_url.'elastislide/jquery.elastislide.js', array('jquery'), false);
                wp_register_script('pretty-photo', $java_script_url.'prettyphoto/jquery.prettyPhoto.js', array('jquery'), '3.1.4', false);
                wp_register_script('isotope', $java_script_url.'jquery.isotope.min.js', array('jquery'), '1.5.25', false);
                wp_register_script('jcarousel', $java_script_url.'jquery.jcarousel.min.js', array('jquery'), '0.2.9', false);
                wp_register_script('jqvalidate', $java_script_url.'jquery.validate.min.js', array('jquery'), '1.11.1', false);
                wp_register_script('jqform', $java_script_url.'jquery.form.js', array('jquery'), '3.40', false);
                wp_register_script('selectbox', $java_script_url.'jquery.selectbox.js', array('jquery'), '1.2', false);
                wp_register_script('jqtransit', $java_script_url.'jquery.transit.min.js', array('jquery'), '0.9.9', false);
                wp_register_script('bootstrap', $java_script_url.'bootstrap.min.js', array('jquery'), false);
                wp_register_script('swipebox', $java_script_url.'swipebox/jquery.swipebox.min.js', array('jquery'),'1.2.1', false);
                wp_register_script('masonry', $java_script_url1.'masonry.pkgd.min.js', array('jquery'),'3.1.5', false);
                wp_register_script('fancybox', $vendor_url.'fancybox/jquery.fancybox.pack.js', array('jquery'),'2.1.5', false);
                wp_register_script('google-map-api', '//maps.google.com/maps/api/js?sensor=true', array(), '', false);

                // Custom Script
                wp_register_script('custom',$java_script_url.'custom.js', array('jquery'), '1.0', true);

                // Enqueue Scripts that are needed on all the pages
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-autocomplete');
                wp_enqueue_script('flexslider');
                wp_enqueue_script('easing');
                wp_enqueue_script('elastislide');
                wp_enqueue_script('pretty-photo');
                wp_enqueue_script('swipebox');
                wp_enqueue_script('isotope');
                wp_enqueue_script('jcarousel');
                wp_enqueue_script('jqvalidate');
                wp_enqueue_script('jqform');
                wp_enqueue_script('selectbox');
                wp_enqueue_script('jqtransit');
                wp_enqueue_script('bootstrap');
                wp_enqueue_script('masonry');
                wp_enqueue_script('fancybox');
                wp_enqueue_script('google-map-api');

                if(is_singular('post') || is_page()){
                    wp_enqueue_script( 'comment-reply' );
                }

                wp_enqueue_script('custom');

                // Responsive Navigation Title Translation Support - Ref : http://codex.wordpress.org/Function_Reference/wp_localize_script
                $localized_array = array('nav_title' => __('Go to...','framework'));
                wp_localize_script( 'custom', 'localized', $localized_array );
            }
        }
    }
    add_action('wp_enqueue_scripts', 'load_theme_scripts');


	
add_action( 'comment_form_after', 'tinyMCE_comment_form' );
function tinyMCE_comment_form() {
?>
    <script type="text/javascript" src="<?php echo includes_url( 'js/tinymce/tiny_mce.js' ); ?>"></script>
    <script type="text/javascript">
        tinyMCE.init({
            theme : "advanced",
            mode: "specific_textareas",
            language: "",
            skin: "default",
            theme_advanced_buttons1: 'bold, italic, underline, blockquote,strikethrough, bullist, numlist, undo, redo, link, unlink',
            theme_advanced_buttons2: '',
            theme_advanced_buttons3: '',
            theme_advanced_buttons4: '',
            elements: 'comment',
            theme_advanced_toolbar_location : "top",
        });
    </script>
<?php
}
 
 /*End of No Limits Codes*/
 
 

add_theme_support( 'post-thumbnails' );
add_image_size('blog_thumb', 220, 168, true);
add_image_size( 'help-thumb-image', 90, 64, true);        // For Home page posts thumbnails/Featured Properties carousels thumb
add_image_size( 'default_help', 220, 157, true);             
add_image_size( 'gallery_image', 421, 300, true);             
add_image_size( 'gallery_hero_image', 335, 239, true);        

add_image_size( 'post-featured-image', 830, 323, true);         // For Standard Post Thumbnails

add_image_size( 'gallery-two-column-image', 536, 269, true);    // For Gallery Two Column property Thumbnails


add_image_size( 'property-detail-slider-image', 770, 386, true);// For Property detail page slider image
add_image_size( 'property-detail-slider-thumb', 82, 60, true);  // For Property detail page slider thumb
add_image_size( 'property-detail-video-image', 818, 417, true); // For Property detail page video image

add_image_size( 'agent-image', 210, 210, true);                 // For Agent Picture
add_image_size( 'grid-view-image', 246, 162, true);             // For Property Listing Grid view,  image


add_theme_support( 'menus' );
register_nav_menus( array(
	'main_nav' => 'Main Navigation', 
));


/* remove [...] from default excerpt */
function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/* Custom excerpt lengths */
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}


/* post view count */
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'rel_canonical'); 
remove_action('wp_head', 'rsd_link'); 
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'feed_links', 2); 
remove_action('wp_head', 'index_rel_link'); 
remove_action('wp_head', 'wlwmanifest_link'); 
remove_action('wp_head', 'feed_links_extra', 3); 
remove_action('wp_head', 'start_post_rel_link', 10, 0); 
remove_action('wp_head', 'parent_post_rel_link', 10, 0); 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); 


/* post thumbnail caption */
function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}


add_action( 'wp_head', function() {
	$html = '<!--[if lt IE 9]>';
	$html .= '<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>';
	$html .= '	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>';
	$html .= '	<![endif]-->';
	//$html .= '<script type="text/javascript">jwplayer.key="C2HHVM4LhJ+Ryl8Tu8EWnTkQ4pu44T910l0CMA==";</script>';
	echo $html;
} );

/* Remove url field from comments form */
function alter_comment_form_fields($fields){
    $fields['url'] = '';  //removes website field
    return $fields;
}
add_filter('comment_form_default_fields','alter_comment_form_fields');



/* Fix for WP SEO Local Plugin */
function locations_cpt($args){
	if (count($args)){
		$args['rewrite'] = array( 'slug' => 'locations' , 'with_front' => false);
	}
	return $args;
}
add_filter('wpseo_local_cpt_args', 'locations_cpt' );



/* H1 title */
function h1_title($id=false, $echo=true){
	global $post;
	$title = "";
	if ($id)
		$title = get_field('h1_title', $id)? get_field('h1_title', $id) : get_the_title($id);
	else 
		$title = get_field('h1_title', $post->ID)? get_field('h1_title', $post->ID) : get_the_title($post->ID);
	if ($title != ""){
		if ($echo)
			echo $title;
		else 
			return $title;	
	}else{
		return false;
	}
}
function add_image_class($class){
	$class .= ' attachment';
	return $class;
}
add_filter('get_image_tag_class','add_image_class');

function templateUrl_func( $atts,  $content = null ) {
	extract( shortcode_atts( array(
		'directory' => '',
	), $atts ) );

	return get_template_directory_uri().'/'.$directory.'/'.$content;
}
add_shortcode( 'templateUrl', 'templateUrl_func' );

function nolimits_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'groupmatrix' ),
		'id'            => 'right-sidebar',
		'description'   => __( 'Main sidebar that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="title">',
		'after_title'   => '</h3><div class="box">',
	) );
	
	
}
add_action( 'widgets_init', 'nolimits_widgets_init' );

function help_field_value($key=NULL)
{
	if(isset($key)){
		global $post;
		return get_post_meta($post->ID, $key, true); 
	}
	
}

function help_status(){
		global $post;
		return get_post_meta($post->ID, 'NO_LIMIT_help_status', true); 	
}

function show_status(){
	$status =  help_field_value('NO_LIMIT_help_status'); 
	switch ($status){
	case '1':
		echo 'Call to Help';
		break;
	case '2':
		echo 'Journey';
		break;
	default;
		echo 'Hero Rally';
	}
}
function help_badge($size=NULL){
		global $post;
		$caring_badge = get_post_meta( $post->ID,'NO_LIMIT_caring_badge',true);  
		
		if(isset($size)){
			$caring_badge=wp_get_attachment_image_src( $caring_badge, $size );
			if(  isset($caring_badge[0])  ){
				echo '<img class="badge" width="137" src="'.$caring_badge[0].'" />';						
			}else{
				echo '<img  class="badge" width="137" src="'.get_template_directory_uri().'/contents/images/badge-big.png" />';						
			}
		
		}else{
			$caring_badge=wp_get_attachment_image_src( $caring_badge, 'full' );
			if(  isset($caring_badge[0])  ){
				echo '<img class="badge" width="30" src="'.$caring_badge[0].'" />';						
			}else{
				echo '<img  class="badge" width="30" src="'.get_template_directory_uri().'/contents/images/badge-default.png" />';		
			}
		}
			
}

function help_location(){
		global $post;
		echo get_post_meta($post->ID, 'NO_LIMIT_caring_address', true);
}

function help_thumbnail(){
		global $post;
		if( has_post_thumbnail( $post->ID ) ){
			echo get_the_post_thumbnail( $post->ID, 'default_help', array( 'class'=>'help_thumb') );
		}else{
			echo '<img width="220" height="157" src="'.get_template_directory_uri().'/contents/images/default.jpg" />';
		}
}

function help_instruction(){
		global $post;
		$instructions = get_post_meta( $post->ID,'NO_LIMIT_instruction',true);  
		if(!empty($instructions)){
			echo $instructions;
		}
}

function help_gallery($name=NULL){ 
	global $post;
	$thumbnail_big = 'gallery_image';
	$thumbnail_hero = 'gallery_hero_image';
	$thumbnail_small = 'thumbnail';
	if(isset($name)){
	?>
	<section class="slider">						
		<div id="slider" class="flexslider">								
		  <ul class="slides">
				<?php 
				
				$gallery_images = rwmb_meta( 'NO_LIMIT_caring_'.$name.'_images', 'type=plupload_image&size='.$thumbnail_hero, $post->ID );
				$thumb_images = rwmb_meta( 'NO_LIMIT_caring_'.$name.'_images', 'type=plupload_image&size='.$thumbnail_small, $post->ID );										
				if(!empty($gallery_images)) { 
					 foreach( $gallery_images as $prop_image_id=>$prop_image_meta ){
						echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li>';
					}						
				}else{
					 if( has_post_thumbnail( $post->ID ) ){ /*Set featured image if no gallery*/										
						echo '<li>'.get_the_post_thumbnail( $post->ID, $thumbnail_small ).'<span class="cover">&nbsp;</span></li>';
					}else{ /* if no all, Set Default Image*/
						echo '<li><img width="335" height="222" src="'.get_template_directory_uri().'/contents/images/default.jpg"></li>';
					}
				}										
				?>
		  </ul>
		</div>
		<div id="carousel" class="flexslider">
		  <ul class="slides">
			<?php 						
				 foreach( $thumb_images as $prop_image_id=>$prop_image_meta ){
					echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li></li>';
				}						
			?>
		  </ul>
		</div>					
	</section>	
<?php } else{ ?>
		<section class="slider big">						
			<div id="slider" class="flexslider">								
			  <ul class="slides big">
					<?php 
					$gallery_images = rwmb_meta( 'NO_LIMIT_caring_images', 'type=plupload_image&size='.$thumbnail_big, $post->ID );
					$thumb_images = rwmb_meta( 'NO_LIMIT_caring_images', 'type=plupload_image&size='.$thumbnail_small, $post->ID );										
					if(!empty($gallery_images)) { 
						 foreach( $gallery_images as $prop_image_id=>$prop_image_meta ){
							echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li>';
						}						
					}else{
						 if( has_post_thumbnail( $post->ID ) ){ /*Set featured image if no gallery*/										
							echo '<li>'.get_the_post_thumbnail( $post->ID, $thumbnail_small ).'<span class="cover">&nbsp;</span></li>';
						}else{ /* if no all, Set Default Image*/
							echo '<li><img width="335" height="222" src="'.get_template_directory_uri().'/contents/images/default.jpg"></li>';
						}
					}										
					?>
			  </ul>
			</div>
			<div id="carousel" class="flexslider">
			  <ul class="slides">
				<?php 						
					 foreach( $thumb_images as $prop_image_id=>$prop_image_meta ){
						echo '<li><img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" /><span class="cover">&nbsp;</span></li></li>';
					}						
				?>
			  </ul>
			</div>					
		</section>	
<?php 
	}
}

function help_slogan(){ ?>
	<div class="helpSlogan">
		<?php
			global $post;
			$slogan = get_post_meta( $post->ID,'NO_LIMIT_caring_slogan',true); 
			$sloganTxt = get_post_meta( $post->ID,'NO_LIMIT_caring_slogan_text',true); 
			if(!empty($slogan)){
				echo '<h2>'.$slogan.'</h2>';
			}
			if(!empty($sloganTxt)){
				echo '<div class="sloganTxt">'.$sloganTxt.'</div>';
			}
		?>
		<p class="version">Version No.: 4</p>
	</div>

<?php }

function block_dashboard() {
    $file = basename($_SERVER['PHP_SELF']);
    if (is_user_logged_in() && is_admin() && !current_user_can('edit_posts') && $file != 'admin-ajax.php'){
        wp_redirect( home_url() );
        exit();
    }
}

add_action('init', 'block_dashboard');

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
