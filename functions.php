<?php
if ( ! function_exists( 'theme_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     */
    function theme_setup() {
     
        /**
         * Make theme available for translation.
         * Translations can be placed in the /languages/ directory.
         */
        load_theme_textdomain( 'goicc', get_template_directory() . '/languages' );
     
        /**
         * Add default posts and comments RSS feed links to <head>.
         */
        add_theme_support( 'automatic-feed-links' );
     
        /**
         * Enable support for post thumbnails and featured images.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Enable support for custom logo.
         */
        add_theme_support( 'custom-logo' );
     
        /**
         * Add support for two custom navigation menus.
         */
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'goicc' ),
            'secondary' => __('Secondary Menu', 'goicc' )
        ) );
     
        /**
         * Enable support for the following post formats:
         * aside, gallery, quote, image, and video
         */
        add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
        
        /**
         * Register Custom Navigation Walker
         */
        require_once get_template_directory() . '/modules/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';
    }
} // theme_setup
add_action( 'after_setup_theme', 'theme_setup' );

function my_login_stylesheet() {
    wp_enqueue_style( 'style-login', get_stylesheet_directory_uri().'/assets/css/style-login.css', array(), filemtime(get_stylesheet_directory().'/assets/css/style-login.css') );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return esc_attr(get_bloginfo('name'));
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

// Add customize options
function goicc_theme_customize_register( $wp_customize ) {
	
	$wp_customize->add_setting( 'goicc_account_page', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'goicc_sanitize_dropdown_pages',
	) );
	
	$wp_customize->add_control( 'goicc_account_page', array(
		'type' => 'dropdown-pages',
		'section' => 'title_tagline', // Add a default or your own section
		'label' => __( 'Account page' ),
		//'description' => __( 'This is a custom dropdown pages option.' ),
    ) );
    

    $wp_customize->add_setting( 'goicc_checkout_page', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'goicc_sanitize_dropdown_pages',
	) );
	
	$wp_customize->add_control( 'goicc_checkout_page', array(
		'type' => 'dropdown-pages',
		'section' => 'title_tagline', // Add a default or your own section
		'label' => __( 'Checkout page' ),
    ) );
    

    $wp_customize->add_setting( 'goicc_thankyou_page', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'goicc_sanitize_dropdown_pages',
	) );
	
	$wp_customize->add_control( 'goicc_thankyou_page', array(
		'type' => 'dropdown-pages',
		'section' => 'title_tagline', // Add a default or your own section
		'label' => __( 'Thank You page' ),
	) );
}
add_action( 'customize_register', 'goicc_theme_customize_register' );

function goicc_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer widgets 1', 'goicc' ),
			'id'            => 'footer-widgets-1', 
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'goicc' ),
			'before_widget' => '<section id="%1$s" class="widget mb-4 %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget-title h4 font-weight-light text-light">',
			'after_title'   => '</div>',
		)
    );
    register_sidebar(
		array(
			'name'          => __( 'Footer widgets 2', 'goicc' ),
			'id'            => 'footer-widgets-2', 
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'goicc' ),
			'before_widget' => '<section id="%1$s" class="widget mb-4 %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget-title h4 font-weight-light text-light">',
			'after_title'   => '</div>',
		)
    );
    register_sidebar(
		array(
			'name'          => __( 'Footer widgets 3', 'goicc' ),
			'id'            => 'footer-widgets-3', 
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'goicc' ),
			'before_widget' => '<section id="%1$s" class="widget mb-4 %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget-title h4 font-weight-light text-light">',
			'after_title'   => '</div>',
		)
    );
    register_sidebar(
		array(
			'name'          => __( 'Footer widgets 4', 'goicc' ),
			'id'            => 'footer-widgets-4', 
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'goicc' ),
			'before_widget' => '<section id="%1$s" class="widget mb-4 %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget-title h4 font-weight-light text-light">',
			'after_title'   => '</div>',
		)
    );
}
add_action( 'widgets_init', 'widgets_init' );

// ACF options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Theme Options');
}

// Enqueue Scrips and styles
function custom_enqueue_wp(){
    wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri().'/modules/bootstrap/dist/js/bootstrap.bundle.min.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/modules/bootstrap/dist/js/bootstrap.min.js'), true );
    wp_enqueue_script( 'lazy', get_stylesheet_directory_uri().'/modules/jquery.lazy-master/jquery.lazy.min.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/modules/jquery.lazy-master/jquery.lazy.min.js'), true );
    wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri().'/modules/fancybox/jquery.fancybox.min.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/modules/fancybox/jquery.fancybox.min.js'), true );
    //wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri().'/modules/bootstrap/dist/css/bootstrap.min.css', array(), filemtime(get_stylesheet_directory().'/modules/bootstrap/dist/css/bootstrap.min.css') );
    wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri().'/modules/fancybox/jquery.fancybox.min.css', array(), filemtime(get_stylesheet_directory().'/modules/fancybox/jquery.fancybox.min.css') );
    wp_enqueue_style( 'goicicons', get_stylesheet_directory_uri().'/assets/fonts/goicicons/style.css', '', filemtime( get_stylesheet_directory() . '/assets/fonts/goicicons/style.css') );
    wp_enqueue_style( 'main', get_stylesheet_directory_uri().'/assets/css/main.css', array(), filemtime(get_stylesheet_directory().'/assets/css/main.css') );
    wp_enqueue_style( 'styles', get_stylesheet_directory_uri().'/assets/css/styles.css', array(), filemtime(get_stylesheet_directory().'/assets/css/styles.css') );
    
    wp_enqueue_script( 'index', get_stylesheet_directory_uri().'/assets/js/index.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/assets/js/index.js'), true );
    wp_enqueue_script( 'user', get_stylesheet_directory_uri().'/assets/js/user.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/assets/js/user.js'), true );
    wp_enqueue_script( 'courses', get_stylesheet_directory_uri().'/assets/js/courses.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/assets/js/courses.js'), true );
    wp_enqueue_style( 'style', get_stylesheet_directory_uri().'/style.css', array(), filemtime(get_stylesheet_directory().'/style.css') );

    if(is_page_template('templates/template-checkout.php')){
      wp_enqueue_script( 'checkout', get_stylesheet_directory_uri().'/assets/js/checkout.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/assets/js/checkout.js'), true );
      wp_localize_script('checkout', 'AJAX_URL', admin_url('admin-ajax.php'));
    }
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_wp' );

function custom_enqueue_wp_admin() {
	wp_enqueue_script( 'admin', get_stylesheet_directory_uri().'/assets/js/admin.js', array( 'jquery'), filemtime(get_stylesheet_directory().'/assets/js/admin.js'), true );
}
add_action( 'admin_enqueue_scripts', 'custom_enqueue_wp_admin' );

// Setup from for wp_mail
add_filter( 'wp_mail_from_name', function( $name ) {
  return get_bloginfo('name');
} );

add_filter( 'wp_mail_from', function( $email ) {
  $url = get_bloginfo('url');
  $url_data = parse_url( $url );
  $domain = preg_replace('#^www\.(.+\.)#i', '$1', $url_data['host']);
  return 'noreply@' . $domain;
} );

require get_parent_theme_file_path( '/inc/functions-ecommerce.php' );
require get_parent_theme_file_path( '/inc/functions-declarations.php' );
require get_parent_theme_file_path( '/inc/functions-posttypes-taxonomies.php' );
require get_parent_theme_file_path( '/inc/functions-p2p.php' );
require get_parent_theme_file_path( '/inc/functions-custom-fields.php' );
require get_parent_theme_file_path( '/inc/functions-shortcodes.php' );
require get_parent_theme_file_path( '/inc/functions-users.php' );
require get_parent_theme_file_path( '/inc/functions-orders.php' );
require get_parent_theme_file_path( '/inc/functions-courses.php' );
require get_parent_theme_file_path( '/inc/functions-products.php' );
require get_parent_theme_file_path( '/inc/functions-checkout.php' );