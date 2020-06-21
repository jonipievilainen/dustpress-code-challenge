<?php
/**
 * Theme functions.
 */


namespace DustPressStarter;

require_once __DIR__ . '/vendor/autoload.php';

// Enable DustPress.
if ( function_exists( 'dustpress' ) ) {
    \DustPress();
}
else {
    wp_die('DustPress must be installed when using the DustPress Starter Theme!');
}

// Enable DustPress.
if ( ! class_exists('ACF') ) {
    wp_die('Install and activate ACF plugin before theme activation.');
}

// Define some constants.
if ( ! defined( 'ASSETS_DIR' ) ) {
    define( 'ASSETS_DIR', get_template_directory_uri() . '/assets' );
}

// Define bootstrap.
if ( ! defined( 'BOOTSTRAP_DIR' ) ) {
    define( 'BOOTSTRAP_DIR', get_template_directory_uri() . '/vendor/twbs/bootstrap/dist' );
}

/**
 * Theme setup
 */
function setup() {
    // Make theme available for translation
    \load_theme_textdomain( 'dustpress-demo', get_template_directory() . '/lang' );
    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    \add_theme_support( 'title-tag' );
    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    \register_nav_menus( [
        'primary_navigation' => __( 'Primary navigation', 'dustpress-demo' ),
    ] );
    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    \add_theme_support( 'post-thumbnails' );
    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    \add_theme_support(
        'html5',
        [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ]
    );
}

\add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Add theme scripts and styles.
 */
function scripts_and_styles() {
    $theme      = \wp_get_theme();
    $version    = $theme->get( 'Version' );

    \wp_enqueue_script( 'theme-js', ASSETS_DIR . '/scripts/theme.js', [ 'jquery' ], $version, true );
    \wp_enqueue_script( 'dustpress-js', ASSETS_DIR . '/scripts/dustpress-min.js', [ 'jquery' ], $version, true );
    \wp_enqueue_style( 'normalize', ASSETS_DIR . '/stylesheets/normalize.css', [], '5.0.0', 'all' );
    \wp_enqueue_style( 'theme-css', ASSETS_DIR . '/stylesheets/theme.css', [], $version, 'all' );
    
    \wp_enqueue_style( 'bootstrap', BOOTSTRAP_DIR . '/css/bootstrap.min.css', [], '5.0.0', 'all' );
    \wp_enqueue_script( 'bootstrap-js', BOOTSTRAP_DIR . '/js/bootstrap.min.js', [ 'jquery' ], '5.0.0', true );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\scripts_and_styles' );

/**
 * Register Custom Post Type
 */
function event_post_type() {
    register_post_type('event',
        array(
            'labels'      => array(
                'name'          => __('Events', 'event'),
                'singular_name' => __('Event', 'event'),
            ),
            'public'      => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt')
        )
    );
}

add_action('init', __NAMESPACE__.'\\event_post_type');