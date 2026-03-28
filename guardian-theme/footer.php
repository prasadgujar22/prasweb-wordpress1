    </div><!-- .container -->
</div><!-- .site-main -->

<footer class="site-footer" role="contentinfo">
    <div class="container">

        <!-- Footer bottom bar -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( 'All rights reserved.', 'guardian-news' ); ?>
            </p>
        </div>

    </div><!-- .container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
