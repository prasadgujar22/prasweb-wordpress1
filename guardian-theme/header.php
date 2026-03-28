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

<!-- ===== STICKY HEADER WRAPPER (logo + nav together) ===== -->
<div class="site-header-wrapper">

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

            <!-- Hamburger: visible only on mobile/tablet -->
            <button class="menu-toggle"
                    aria-controls="primary-navigation"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e( 'Open menu', 'guardian-news' ); ?>">
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
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

</div><!-- .site-header-wrapper -->

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
