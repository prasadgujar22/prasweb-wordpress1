<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'guardian-news' ); ?></a>

<!-- ===== TOP BAR ===== -->
<div class="site-topbar" role="banner">
    <div class="container">
        <div class="topbar-support">
            <a href="<?php echo esc_url( get_theme_mod( 'guardian_support_url', '#' ) ); ?>">
                <?php esc_html_e( 'Support us', 'guardian-news' ); ?>
            </a>
        </div>
        <div class="topbar-signin">
            <a href="<?php echo esc_url( wp_login_url() ); ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2C9.243 2 7 4.243 7 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5zm0 8c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3-1.346 3-3 3zm9 11v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h2v-1c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v1h2z"/>
                </svg>
                <?php esc_html_e( 'Sign in', 'guardian-news' ); ?>
            </a>
        </div>
    </div>
</div>

<!-- ===== SITE HEADER ===== -->
<header class="site-header">
    <div class="container">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <div class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <span class="edition-selector" aria-label="<?php esc_attr_e( 'Select edition', 'guardian-news' ); ?>">
            <?php echo esc_html( get_theme_mod( 'guardian_edition_label', 'Int' ) ); ?>
        </span>
    </div>
</header>

<!-- ===== PRIMARY NAVIGATION ===== -->
<div class="site-nav-wrapper" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'guardian-news' ); ?>">
    <div class="container">
        <nav class="primary-navigation" id="primary-navigation">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => '',
                'container'      => false,
                'walker'         => new Guardian_Nav_Walker(),
                'fallback_cb'    => 'guardian_fallback_menu',
            ] );
            ?>
        </nav>

        <button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'guardian-news' ); ?>">
            <span></span>
        </button>
    </div>
</div>

<!-- ===== SUB NAVIGATION ===== -->
<?php if ( has_nav_menu( 'secondary' ) ) : ?>
<div class="sub-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Section menu', 'guardian-news' ); ?>">
    <div class="container">
        <?php
        wp_nav_menu( [
            'theme_location' => 'secondary',
            'container'      => false,
            'walker'         => new Guardian_Nav_Walker(),
            'fallback_cb'    => false,
        ] );
        ?>
    </div>
</div>
<?php endif; ?>

<!-- ===== MAIN ===== -->
<div id="main-content" class="site-main">
    <div class="container">

<?php
/**
 * Fallback menu when no menu is assigned.
 */
function guardian_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'News', 'guardian-news' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'Opinion', 'guardian-news' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'Sport', 'guardian-news' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'Culture', 'guardian-news' ) . '</a></li>';
    echo '<li><a href="#">' . esc_html__( 'Lifestyle', 'guardian-news' ) . '</a></li>';
    echo '</ul>';
}
