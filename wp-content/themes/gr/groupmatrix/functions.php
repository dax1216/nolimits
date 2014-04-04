<?php

add_theme_support( 'post-thumbnails' );
add_image_size('blog_thumb', 220, 168, true);


add_theme_support( 'menus' );
register_nav_menus( array(
	'main_nav' => 'Main Navigation', 
	'top_nav' => 'Top Navigation', 
	'mobile_top_nav' => 'Mobile Header Menu',
	'mobile_footer_nav' => 'Mobile Footer Menu'
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


/* Enqueue scripts and styles */

function groupmatrix_theme_scripts() {
	
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
	wp_enqueue_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic');
	wp_enqueue_style( 'archivo-narrow', 'http://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic');
	wp_enqueue_style( 'groupmatrix-theme-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.0.3', true );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'), '3.1.4', true );
//	wp_enqueue_script( 'jqplayer', get_template_directory_uri() . '/js/jwplayer/jwplayer.js', array('jquery'), '3.1.4', true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'groupmatrix_theme_scripts' );

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

//remove_filter( 'the_content', 'wpautop' );

function cw_videofn( $atts, $content = null ){
	extract( shortcode_atts( array(
			'src' => '',
			'thumbnail'=>'',
			'alt' => '',
			'title'=>'',
			'class'=>''
		), $atts ) );
		
	return '<div class="widget video '.$class.'">
				<div class="attachment">
					<img class="thumb" src="'.$thumbnail.'" alt="'.$alt.'">
					<a href="'.$src.'" class="btn-play"><img src="'.get_template_directory_uri().'/images/btn-play-video.png" alt="#"></a>
				</div>
				<div class="box">
					<h3>'.$title.'</h3>
				</div>
			</div>';
}
add_shortcode( 'addvideo', 'cw_videofn' );

function cw_videosinglefn( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'row' => ''
	), $atts ) );
	
	return '<div class="content-widget float row-'.$row.'">'.do_shortcode($content).'</div>';
}
add_shortcode( 'videosingle', 'cw_videosinglefn' );

function groupmatrix_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'groupmatrix' ),
		'id'            => 'right-sidebar',
		'description'   => __( 'Main sidebar that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="title">',
		'after_title'   => '</h3><div class="box">',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Contact Page Sidebar', 'groupmatrix' ),
		'id'            => 'contact-right-sidebar',
		'description'   => __( 'Contact Page sidebar that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="title">',
		'after_title'   => '</h3><div class="box">',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Management', 'groupmatrix' ),
		'id'            => 'management',
		'description'   => __( 'Contact Page: Management Area that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<a href="#">',
		'after_title'   => '</a>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Office Administration', 'groupmatrix' ),
		'id'            => 'office_administration',
		'description'   => __( 'Contact Page: Office Administration Area that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<a href="#">',
		'after_title'   => '</a>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Media Analyst', 'groupmatrix' ),
		'id'            => 'media_analyst',
		'description'   => __( 'Contact Page: Media Analyst that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<a href="#">',
		'after_title'   => '</a>',
	) );
	register_sidebar( array(
		'name'          => __( 'Client Relations', 'groupmatrix' ),
		'id'            => 'client_relation',
		'description'   => __( 'Contact Page: Client Relations that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<a href="#">',
		'after_title'   => '</a>',
	) );
	register_sidebar( array(
		'name'          => __( 'Client Services', 'groupmatrix' ),
		'id'            => 'client_services',
		'description'   => __( 'Contact Page: Client Services that appears on the right.', 'groupmatrix' ),
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<a href="#">',
		'after_title'   => '</a>',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Address', 'groupmatrix' ),
		'id'            => 'contact_adress',
		'description'   => __( 'Contact Page sidebar that appears on the bootm right.', 'groupmatrix' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="title">',
		'after_title'   => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'groupmatrix_widgets_init' );
?>