    </div><!-- .container -->
</div><!-- .site-main -->

<footer class="site-footer" role="contentinfo">
    <div class="container">

        <!-- Logo -->
        <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php bloginfo( 'name' ); ?>
        </a>

        <!-- Tagline -->
        <p class="footer-tagline">
            <?php echo esc_html( get_theme_mod( 'guardian_footer_tagline', 'Independent journalism, funded by readers. Support our work to keep it free and open for everyone.' ) ); ?>
        </p>

        <!-- Footer nav columns -->
        <div class="footer-grid">

            <?php
            $footer_menus = [
                'footer-col1' => __( 'News', 'guardian-news' ),
                'footer-col2' => __( 'Opinion', 'guardian-news' ),
                'footer-col3' => __( 'Sport', 'guardian-news' ),
                'footer-col4' => __( 'About', 'guardian-news' ),
            ];

            foreach ( $footer_menus as $location => $label ) :
            ?>
            <div class="footer-column">
                <p class="footer-column-title"><?php echo esc_html( $label ); ?></p>
                <?php
                if ( has_nav_menu( $location ) ) {
                    wp_nav_menu( [
                        'theme_location' => $location,
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ] );
                } else {
                    // Fallback static links
                    echo '<ul>';
                    if ( $location === 'footer-col1' ) {
                        $links = [ 'World', 'UK', 'US', 'Europe', 'Asia', 'Middle East' ];
                    } elseif ( $location === 'footer-col2' ) {
                        $links = [ 'Columnists', 'Letters', 'Editorials', 'Cartoons' ];
                    } elseif ( $location === 'footer-col3' ) {
                        $links = [ 'Football', 'Cricket', 'Tennis', 'Rugby' ];
                    } else {
                        $links = [ 'About us', 'Contact us', 'Advertise', 'Privacy policy', 'Terms' ];
                    }
                    foreach ( $links as $link ) {
                        echo '<li><a href="#">' . esc_html( $link ) . '</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <?php endforeach; ?>

        </div><!-- .footer-grid -->

        <!-- Footer bottom bar -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( 'All rights reserved.', 'guardian-news' ); ?>
            </p>
            <a class="footer-support-btn" href="<?php echo esc_url( get_theme_mod( 'guardian_support_url', '#' ) ); ?>">
                <?php esc_html_e( 'Support us', 'guardian-news' ); ?>
            </a>
        </div>

    </div><!-- .container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
