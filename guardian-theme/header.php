<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <!-- Critical overflow fix — inline to bypass page cache -->
    <style>
    /* clip stops horizontal scroll without creating a scroll container,
       so position:sticky on .site-header-wrapper keeps working */
    html,body{max-width:100%!important;overflow-x:clip!important}

    /* Always: wide child elements scroll internally, not the page */
    pre{max-width:100%!important;overflow-x:auto!important;
        white-space:pre!important;word-wrap:normal!important}
    code{word-break:break-word!important;overflow-wrap:break-word!important}
    .article-content table,.entry-content table,
    figure.wp-block-table{display:block!important;
        overflow-x:auto!important;max-width:100%!important;
        -webkit-overflow-scrolling:touch}
    img,iframe,embed,object{max-width:100%!important}

    /* Mobile only: constrain text containers + disable sidebar sticky */
    @media(max-width:900px){
        .site-main,.content-area,.main-column,.single-article,
        .article-content,.entry-content,.container{
            max-width:100%!important;overflow-x:clip!important;
            word-wrap:break-word!important;overflow-wrap:break-word!important}

        /* Sidebar flows below article on mobile — sticky must be off */
        .sidebar-sticky{position:static!important;top:auto!important}

        /* Social share plugin buttons — prevent fixed/absolute overflow */
        .content-area,.main-column{position:relative!important}
    }
    </style>
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

            <div class="nav-actions">
                <!-- Search toggle -->
                <button class="search-toggle"
                        aria-controls="site-search-panel"
                        aria-expanded="false"
                        aria-label="<?php esc_attr_e( 'Open search', 'guardian-news' ); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M21.71 20.29l-5.01-5.01A8 8 0 1 0 15.29 16.7l5.01 5.01a1 1 0 0 0 1.41-1.42zM10 16a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                    </svg>
                </button>

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
    </div>

    <!-- ===== SEARCH PANEL ===== -->
    <div class="site-search-panel" id="site-search-panel" role="search" aria-hidden="true">
        <div class="container">
            <form class="site-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search"
                       class="site-search-input"
                       id="site-search-input"
                       name="s"
                       placeholder="<?php esc_attr_e( 'Search stories…', 'guardian-news' ); ?>"
                       value="<?php echo esc_attr( get_search_query() ); ?>"
                       autocomplete="off">
                <button type="submit" class="site-search-submit" aria-label="<?php esc_attr_e( 'Submit search', 'guardian-news' ); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M21.71 20.29l-5.01-5.01A8 8 0 1 0 15.29 16.7l5.01 5.01a1 1 0 0 0 1.41-1.42zM10 16a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                    </svg>
                </button>
                <button type="button" class="site-search-close" aria-label="<?php esc_attr_e( 'Close search', 'guardian-news' ); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </form>
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
