<?php
/**
 * Dokan functions and definitions
 *
 * @package Dokan
 * @since Dokan 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Dokan 1.0
 */

if ( !isset( $content_width ) )
    $content_width = 640; /* pixels */

// Backwards compatibility for older than PHP 5.3.0
if ( !defined( '__DIR__' ) ) {
    define( '__DIR__', dirname( __FILE__ ) );
}

define( 'DOKAN_DIR', __DIR__ );
define( 'DOKAN_INC_DIR', __DIR__ . '/includes' );
define( 'DOKAN_LIB_DIR', __DIR__ . '/lib' );

/**
 * Autoload class files on demand
 *
 * `Dokan_Installer` becomes => installer.php
 * `Dokan_Template_Report` becomes => template-report.php
 *
 * @param string $class requested class name
 */

 /*Custom Code*/
require_once(get_template_directory() . '/vendor/wp-days-ago/wp_days_ago.php');
require_once(get_template_directory() . '/vendor/woo-remove-qty.php');

function getSeller(){
	 global $product;

    $author = get_user_by( 'id', $product->post->post_author );
	?>
		
	<?php printf('<a class="thumb" href="%s">%s</a>', dokan_get_store_url( $author->ID ) , get_avatar( $author->ID, 80 )) ; ?>
	<span class="name">by
			<?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), $author->display_name ); ?>
	</span>
<?php	
}

if ( ! function_exists( 'trimText' ) ) :

    function trimText($text, $max_char, $moretext) {
        if (strlen($text) > $max_char) {
            $text = substr($text, 0, $max_char - 3). $moretext;
        }
        return $text;
    }

endif;

/*End custom */

function dokan_autoload( $class ) {
    if ( stripos( $class, 'Dokan_' ) !== false ) {
        $class_name = str_replace( array('Dokan_', '_'), array('', '-'), $class );
        $file_path = __DIR__ . '/classes/' . strtolower( $class_name ) . '.php';

        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }
}

spl_autoload_register( 'dokan_autoload' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Dokan 1.0
 */
class WeDevs_Dokan {

    function __construct() {

        //includes file
        $this->includes();

        // init actions and filter
        $this->init_filters();
        $this->init_actions();

        // initialize classes
        $this->init_classes();

        //for reviews ajax request
        $this->init_ajax();
    }

    /**
     * Initialize filters
     *
     * @return void
     */
    function init_filters() {
        add_filter( 'posts_where', array($this, 'hide_others_uploads') );
    }

    /**
     * Init action hooks
     *
     * @return void
     */
    function init_actions() {
        add_action( 'after_setup_theme', array($this, 'setup') );
        add_action( 'widgets_init', array($this, 'widgets_init') );

        add_action( 'wp_enqueue_scripts', array($this, 'scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
        add_action( 'login_enqueue_scripts', array($this, 'login_scripts') );

        add_action( 'admin_init', array($this, 'install_theme') );
        add_action( 'admin_init', array($this, 'block_admin_access') );
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    function init_classes() {
        if ( is_admin() ) {
            Dokan_Slider::init();
            new Dokan_Admin_User_Profile();
            new Dokan_Update();
        } else {
            new Dokan_Pageviews();
        }

        new Dokan_Rewrites();
        Dokan_Email::init();
    }

    /**
     * Init ajax classes
     *
     * @return void
     */
    function init_ajax() {
        $doing_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

        if ( $doing_ajax ) {
            Dokan_Ajax::init()->init_ajax();
            new Dokan_Pageviews();
        }
    }

    function includes() {
        $lib_dir = __DIR__ . '/lib/';
        $inc_dir = __DIR__ . '/includes/';
        $classes_dir = __DIR__ . '/classes/';

        require_once $inc_dir . 'theme-functions.php';
        require_once $inc_dir . 'widgets/menu-category.php';
        require_once $inc_dir . 'widgets/best-seller.php';
        require_once $classes_dir . 'customizer.php';
        require_once $inc_dir . 'wc-functions.php';

        if ( is_admin() ) {
            require_once $inc_dir . 'admin/admin.php';
            require_once $inc_dir . 'admin-functions.php';
        } else {
            require_once $lib_dir . 'bootstrap-walker.php';
            require_once $inc_dir . 'wc-template.php';
            require_once $inc_dir . 'template-tags.php';
        }
    }

    /**
     * Setup dokan
     *
     * @uses `after_setup_theme` hook
     */
    function setup() {

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         */
        load_theme_textdomain( 'dokan', get_template_directory() . '/languages' );

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Enable support for Post Thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
        // Tell the TinyMCE editor to use a custom stylesheet
        add_editor_style( '/assets/css/editor-style.css' );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'dokan' ),
        ) );

        add_theme_support( 'woocommerce' );
        add_post_type_support( 'product', 'author' );

        /*
         * This theme supports custom background color and image,
         * and here we also set up the default background color.
         */
        add_theme_support( 'custom-background', array(
            'default-color' => 'F7F7F7',
        ) );

        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

        // setup global tables
        global $wpdb;

        $wpdb->dokan_withdraw = $wpdb->prefix . 'dokan_withdraw';
        $wpdb->dokan_orders = $wpdb->prefix . 'dokan_orders';
    }

    function install_theme() {
        global $pagenow;

        if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
            $installer = new Dokan_Installer();
            $installer->do_install();
        }
    }

    /**
     * Register widgetized area and update sidebar with default widgets
     *
     * @since Dokan 1.0
     */
    function widgets_init() {

        $sidebars = array(
            array( 'name' => __( 'General Sidebar', 'dokan' ), 'id' => 'sidebar-1' ),
            array( 'name' => __( 'Home Sidebar', 'dokan' ), 'id' => 'sidebar-home' ),
            array( 'name' => __( 'Blog Sidebar', 'dokan' ), 'id' => 'sidebar-blog' ),
            array( 'name' => __( 'Header Sidebar', 'dokan' ), 'id' => 'sidebar-header' ),
            array( 'name' => __( 'Shop Archive', 'dokan' ), 'id' => 'sidebar-shop' ),
            array( 'name' => __( 'Single Product', 'dokan' ), 'id' => 'sidebar-single-product' ),
            array( 'name' => __( 'Footer Sidebar - 1', 'dokan' ), 'id' => 'footer-1' ),
            array( 'name' => __( 'Footer Sidebar - 2', 'dokan' ), 'id' => 'footer-2' ),
            array( 'name' => __( 'Footer Sidebar - 3', 'dokan' ), 'id' => 'footer-3' ),
            array( 'name' => __( 'Footer Sidebar - 4', 'dokan' ), 'id' => 'footer-4' ),
        );

        foreach ($sidebars as $sidebar) {
            register_sidebar( array(
                'name' => $sidebar['name'],
                'id' => $sidebar['id'],
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }
    }

    /**
     * Enqueue scripts and styles
     *
     * @since Dokan 1.0
     */
    function scripts() {
        $protocol = is_ssl() ? 'https' : 'http';
        $template_directory = get_template_directory_uri();
        $skin = dokan_get_option( 'color_skin', 'dokan_general', 'orange.css' );

        wp_register_style( 'jquery-ui', $template_directory . '/assets/css/jquery-ui-1.10.0.custom.css', false, null );
        wp_register_style( 'chosen-style', $template_directory . '/assets/css/chosen.min.css', false, null );

        wp_enqueue_style( 'bootstrap', $template_directory . '/assets/css/bootstrap.css', false, null );
        wp_enqueue_style( 'icomoon', $template_directory . '/assets/css/icomoon.css', false, null );
        wp_enqueue_style( 'fontawesome', $template_directory . '/assets/css/font-awesome.css', false, null );


        wp_enqueue_style( 'flexslider', $template_directory . '/assets/css/flexslider.css', false, null );
        wp_enqueue_style( 'dokan-style', $template_directory . '/assets/css/style.css', false, null );
        wp_enqueue_style( 'dokan-skin', $template_directory . '/assets/css/skins/' . $skin, false, null );
        wp_enqueue_style( 'dokan-opensans', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:400,700' );
        wp_enqueue_style( 'style', $template_directory . '/style.css', false, null );


        /****** Scripts ******/

        if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        if ( is_singular() && wp_attachment_is_image() ) {
            wp_enqueue_script( 'keyboard-image-navigation', $template_directory . '/assets/js/keyboard-image-navigation.js', array('jquery'), '20120202' );
        }

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui' );
        wp_enqueue_script( 'jquery-ui-datepicker' );

        wp_register_script( 'jquery-flot', $template_directory . '/assets/js/jquery.flot.min.js', false, null, true );
        wp_register_script( 'jquery-flot-time', $template_directory . '/assets/js/jquery.flot.time.min.js', false, null, true );
        wp_register_script( 'jquery-flot-pie', $template_directory . '/assets/js/jquery.flot.pie.min.js', false, null, true );
        wp_register_script( 'jquery-flot-stack', $template_directory . '/assets/js/jquery.flot.stack.min.js', false, null, true );
        wp_register_script( 'jquery-chart', $template_directory . '/assets/js/Chart.min.js', false, null, true );
        wp_register_script( 'dokan-product-editor', $template_directory . '/assets/js/product-editor.js', false, null, true );
        wp_register_script( 'dokan-order', $template_directory . '/assets/js/orders.js', false, null, true );
        wp_register_script( 'chosen', $template_directory . '/assets/js/chosen.jquery.min.js', array('jquery'), null, true );
        wp_register_script( 'reviews', $template_directory . '/assets/js/reviews.js', array('jquery'), null, true );

        wp_enqueue_script( 'form-validate', $template_directory . '/assets/js/form-validate.js', array('jquery'), null, true  );
        wp_enqueue_script( 'bootstrap-min', $template_directory . '/assets/js/bootstrap.min.js', false, null, true );
        wp_enqueue_script( 'flexslider', $template_directory . '/assets/js/jquery.flexslider-min.js', array('jquery') );

        wp_enqueue_script( 'dokan-scripts', $template_directory . '/assets/js/script.js', false, null, true );
        wp_localize_script( 'jquery', 'dokan', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'dokan_reviews' ),
            'ajax_loader' => $template_directory . '/assets/images/ajax-loader.gif',
            'seller' => array(
                'available' => __( 'Available', 'dokan' ),
                'notAvailable' => __( 'Not Available', 'dokan' )
            )
        ) );
    }

    function login_scripts() {
        wp_enqueue_script( 'jquery' );
    }

    /**
     * Scripts and styles for admin panel
     */
    function admin_enqueue_scripts() {
        $template_directory = get_template_directory_uri();

        wp_enqueue_script( 'dokan_slider_admin', $template_directory . '/assets/js/admin.js', array('jquery') );
    }

    /**
     * Hide other users uploads for `seller` users
     *
     * Hide media uploads in page "upload.php" and "media-upload.php" for
     * sellers. They can see only thier uploads.
     *
     * FIXME: fix the upload counts
     *
     * @global string $pagenow
     * @global object $wpdb
     * @param string $where
     * @return string
     */
    function hide_others_uploads( $where ) {
        global $pagenow, $wpdb;

        if ( ( $pagenow == 'upload.php' || $pagenow == 'media-upload.php') && current_user_can( 'dokandar' ) ) {
            $user_id = get_current_user_id();

            $where .= " AND $wpdb->posts.post_author = $user_id";
        }

        return $where;
    }

    /**
     * Block user access to admin panel for specific roles
     *
     * @global string $pagenow
     */
    function block_admin_access() {
        global $pagenow, $current_user;

        // bail out if we are from WP Cli
        if ( defined( 'WP_CLI' ) ) {
            return;
        }

        $no_access = dokan_get_option( 'admin_access', 'dokan_general', 'on' );
        $valid_pages = array('admin-ajax.php', 'admin-post.php', 'async-upload.php', 'media-upload.php');
        $user_role = reset( $current_user->roles );

        if ( ( $no_access == 'on' ) && (!in_array( $pagenow, $valid_pages ) ) && in_array( $user_role, array( 'seller', 'customer' ) ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }

}

$dokan = new WeDevs_Dokan();

function dokan_wc_email_recipient_add_seller( $admin_email, $order ) {
    $emails = array( $admin_email );

    $seller_id = dokan_get_seller_id_by_order( $order->id );

    if ( $seller_id ) {
        $seller_email = get_user_by( 'id', $seller_id )->user_email;

        if ( $admin_email != $seller_email ) {
            array_push( $emails, $seller_email );
        }
    }

    return $emails;
}

add_filter( 'woocommerce_email_recipient_new_order', 'dokan_wc_email_recipient_add_seller', 10, 2 );

// Add Toolbar Menus
function dokan_admin_toolbar() {
    global $wp_admin_bar;

    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    $args = array(
        'id'     => 'dokan',
        'title'  => __( 'Dokan', 'admin' ),
        'href'   => admin_url( 'admin.php?page=dokan' )
    );

    $wp_admin_bar->add_menu( $args );

    $wp_admin_bar->add_menu( array(
        'id'     => 'dokan-dashboard',
        'parent' => 'dokan',
        'title'  => __( 'Dokan Dashboard', 'dokan' ),
        'href'  => admin_url( 'admin.php?page=dokan' )
    ) );

    $wp_admin_bar->add_menu( array(
        'id'     => 'dokan-withdraw',
        'parent' => 'dokan',
        'title'  => __( 'Withdraw', 'dokan' ),
        'href'  => admin_url( 'admin.php?page=dokan-withdraw' )
    ) );

    $wp_admin_bar->add_menu( array(
        'id'     => 'dokan-sellers',
        'parent' => 'dokan',
        'title'  => __( 'All Sellers', 'dokan' ),
        'href'  => admin_url( 'admin.php?page=dokan-sellers' )
    ) );

    $wp_admin_bar->add_menu( array(
        'id'     => 'dokan-reports',
        'parent' => 'dokan',
        'title'  => __( 'Earning Reports', 'dokan' ),
        'href'  => admin_url( 'admin.php?page=dokan-reports' )
    ) );

    $wp_admin_bar->add_menu( array(
        'id'     => 'dokan-settings',
        'parent' => 'dokan',
        'title'  => __( 'Settings', 'dokan' ),
        'href'  => admin_url( 'admin.php?page=dokan-settings' )
    ) );
}

// Hook into the 'wp_before_admin_bar_render' action
add_action( 'wp_before_admin_bar_render', 'dokan_admin_toolbar' );


add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
 
	$tabs['description']['title'] = __( 'Thing Info' );		// Rename the description tab
	$tabs['seller']['title'] = __( 'Maker Info' );		// Rename the description tab
	//$tabs['additional_information']['title'] = __( 'Product Data' );	// Rename the additional information tab
 
	return $tabs;
 
}

// Add custom tab
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	global $post;
	$downloadable_files = get_post_meta( $post->ID, '_downloadable_files', false );
	// Add the new tab
	if(count($downloadable_files) ){
		$tabs['tab_files'] = array(
			'title' 	=> __( 'Thing Files', 'woocommerce' ),
			'priority' 	=> 30,
			'callback' 	=> 'woo_new_product_tab_content_files'
		);
	}
	$tabs['tab_intstuctions'] = array(
		'title' 	=> __( 'Instructions', 'woocommerce' ),
		'priority' 	=> 20,
		'callback' 	=> 'woo_new_product_tab_content_instructions'
	);
 
	return $tabs;
 
}
function woo_new_product_tab_content_files() { 
	// The new tab content
	global $post;	
	 $downloadable_files = get_post_meta( $post->ID, '_downloadable_files', false ); 	 
	 ?>
		<h2>Files</h2>
		<h4 class="details-header">File Name</h4>
		<h4 class="size-header">Size</h4>
		<div class="clear"></div>	
	<?php 
	foreach ($downloadable_files as $key =>  $values ) {
		foreach ($values as $key => $value) {
			$id = pn_get_attachment_id_from_url($value['file']);			
			$bytes = filesize(get_attached_file($id));
			$size = humanFileSize($bytes);
			$fileurl = $value['file'];
			$path = explode('/', $fileurl);
			$fielname = $path[7]; ?>			
			<div class="thing-file">
					<div class="details">
						<div class="filename"><?php echo $fielname; ?></div>
					</div>
					<span class="size"><?php echo $size; ?></span>
				<div class="clear"></div>
			</div>						
<?php			
		}
	}
 
?>

<?php	
}

function woo_new_product_tab_content_instructions() {
global $post; 
	// The new tab content
 
?>
<h2>Instructions</h2>
<?php	
$instructions = get_post_meta( $post->ID, 'creation_instruction', true ); 
	if(!empty($instructions)){
		echo $instructions;
	}else{
		echo '<p>Instructions will be posted soon!</p>';
	}
}


 /*	Include Meta Box
/*-----------------------------------------------------------------------------------*/
    define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/vendor/meta-box' ) );
    define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/vendor/meta-box' ) );
    require_once RWMB_DIR . 'meta-box.php';
    require_once RWMB_DIR . 'config-meta-boxes.php';
	
    
function pn_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

function humanFileSize($size,$unit="") {
	  if( (!$unit && $size >= 1<<30) || $unit == "GB")
		return number_format($size/(1<<30),2)."GB";
	  if( (!$unit && $size >= 1<<20) || $unit == "MB")
		return number_format($size/(1<<20),2)."MB";
	  if( (!$unit && $size >= 1<<10) || $unit == "KB")
		return number_format($size/(1<<10),2)."KB";
	  return number_format($size)." bytes";
}