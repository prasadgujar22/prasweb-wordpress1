<?php
/**
 * Guardian News Theme Functions
 *
 * @package GuardianNews
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'GUARDIAN_VERSION', '1.0.0' );
define( 'GUARDIAN_DIR', get_template_directory() );
define( 'GUARDIAN_URI', get_template_directory_uri() );

// ============================================================
// THEME SETUP
// ============================================================

function guardian_setup() {
    load_theme_textdomain( 'guardian-news', GUARDIAN_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );

    // Custom logo
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    // Image sizes
    add_image_size( 'guardian-hero',    1200, 680, true );
    add_image_size( 'guardian-card',    600,  400, true );
    add_image_size( 'guardian-thumb',   300,  200, true );

    // Navigation menus
    register_nav_menus( [
        'primary'    => __( 'Primary Navigation', 'guardian-news' ),
        'secondary'  => __( 'Sub Navigation', 'guardian-news' ),
        'footer-col1' => __( 'Footer Column 1', 'guardian-news' ),
        'footer-col2' => __( 'Footer Column 2', 'guardian-news' ),
        'footer-col3' => __( 'Footer Column 3', 'guardian-news' ),
        'footer-col4' => __( 'Footer Column 4', 'guardian-news' ),
    ] );

    // Set default thumbnail size
    set_post_thumbnail_size( 600, 400, true );
}
add_action( 'after_setup_theme', 'guardian_setup' );

// ============================================================
// CONTENT WIDTH
// ============================================================

function guardian_content_width() {
    $GLOBALS['content_width'] = 1300;
}
add_action( 'after_setup_theme', 'guardian_content_width', 0 );

// ============================================================
// ENQUEUE SCRIPTS & STYLES
// ============================================================

function guardian_enqueue_assets() {
    // Main stylesheet
    wp_enqueue_style(
        'guardian-style',
        get_stylesheet_uri(),
        [],
        GUARDIAN_VERSION
    );

    // Google Fonts (Georgia fallback with display swap)
    wp_enqueue_style(
        'guardian-fonts',
        'https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@400;600;700&display=swap',
        [],
        null
    );

    // Theme JS
    wp_enqueue_script(
        'guardian-main',
        GUARDIAN_URI . '/js/main.js',
        [],
        GUARDIAN_VERSION,
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'guardian_enqueue_assets' );

// ============================================================
// WIDGETS / SIDEBARS
// ============================================================

function guardian_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Primary Sidebar', 'guardian-news' ),
        'id'            => 'sidebar-primary',
        'description'   => __( 'Widgets in the right sidebar.', 'guardian-news' ),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="sidebar-widget-title">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer Widget Area', 'guardian-news' ),
        'id'            => 'footer-widgets',
        'description'   => __( 'Widgets in the footer area.', 'guardian-news' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'guardian_widgets_init' );

// ============================================================
// CUSTOM EXCERPT LENGTH & MORE
// ============================================================

function guardian_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'guardian_excerpt_length' );

function guardian_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'guardian_excerpt_more' );

// ============================================================
// BODY CLASSES
// ============================================================

function guardian_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'single-view';
    }
    if ( ! is_singular() ) {
        $classes[] = 'archive-view';
    }
    return $classes;
}
add_filter( 'body_class', 'guardian_body_classes' );

// ============================================================
// HELPER: RELATIVE TIME
// ============================================================

function guardian_relative_time( $timestamp ) {
    $diff = time() - $timestamp;

    if ( $diff < 60 ) {
        return __( 'Just now', 'guardian-news' );
    } elseif ( $diff < 3600 ) {
        $mins = round( $diff / 60 );
        /* translators: %d: number of minutes */
        return sprintf( _n( '%d min ago', '%d mins ago', $mins, 'guardian-news' ), $mins );
    } elseif ( $diff < 86400 ) {
        $hrs = round( $diff / 3600 );
        /* translators: %d: number of hours */
        return sprintf( _n( '%d hour ago', '%d hours ago', $hrs, 'guardian-news' ), $hrs );
    } else {
        return get_the_date( 'j F Y', $timestamp );
    }
}

// ============================================================
// HELPER: SECTION COLOR
// ============================================================

function guardian_get_section_color( $category_slug = '' ) {
    $colors = [
        'world'         => '#990000',
        'us-news'       => '#004b7a',
        'uk-news'       => '#004b7a',
        'politics'      => '#333399',
        'environment'   => '#4B7F52',
        'science'       => '#990000',
        'technology'    => '#052962',
        'business'      => '#005689',
        'sport'         => '#003580',
        'culture'       => '#7D0068',
        'lifestyle'     => '#BB3B80',
        'opinion'       => '#e05E00',
    ];
    return isset( $colors[ $category_slug ] ) ? $colors[ $category_slug ] : '#052962';
}

// ============================================================
// CUSTOM WALKER FOR NAVBAR ACTIVE UNDERLINE
// ============================================================

class Guardian_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $class_string = $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';

        $atts = [];
        $atts['href']   = ! empty( $item->url ) ? $item->url : '#';
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';

        $atts_string = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $atts_string .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $output .= '<li' . $class_string . '>';
        $output .= '<a' . $atts_string . '>';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }
}

// ============================================================
// CUSTOMIZER ADDITIONS
// ============================================================

function guardian_customizer( $wp_customize ) {
    // Site Identity section already exists

    // Guardian Options panel
    $wp_customize->add_panel( 'guardian_options', [
        'title'    => __( 'Guardian Theme Options', 'guardian-news' ),
        'priority' => 130,
    ] );

    // Edition label
    $wp_customize->add_section( 'guardian_edition', [
        'title'  => __( 'Edition', 'guardian-news' ),
        'panel'  => 'guardian_options',
    ] );

    $wp_customize->add_setting( 'guardian_edition_label', [
        'default'           => 'Int',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'guardian_edition_label', [
        'label'   => __( 'Edition Label', 'guardian-news' ),
        'section' => 'guardian_edition',
        'type'    => 'text',
    ] );

    // Support URL
    $wp_customize->add_setting( 'guardian_support_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ] );

    $wp_customize->add_control( 'guardian_support_url', [
        'label'   => __( '"Support Us" Button URL', 'guardian-news' ),
        'section' => 'guardian_edition',
        'type'    => 'url',
    ] );

    // Tagline in footer
    $wp_customize->add_section( 'guardian_footer', [
        'title' => __( 'Footer', 'guardian-news' ),
        'panel' => 'guardian_options',
    ] );

    $wp_customize->add_setting( 'guardian_footer_tagline', [
        'default'           => 'Independent journalism, funded by readers. Support our work to keep it free and open for everyone.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ] );

    $wp_customize->add_control( 'guardian_footer_tagline', [
        'label'   => __( 'Footer Tagline', 'guardian-news' ),
        'section' => 'guardian_footer',
        'type'    => 'textarea',
    ] );
}
add_action( 'customize_register', 'guardian_customizer' );
