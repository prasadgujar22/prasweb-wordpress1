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
<!-- Override dark-mode plugin borders — placed after wp_footer() so it
     wins the cascade regardless of what the plugin enqueues -->
<style>
.article-card,
.sidebar-widget,
.widget,
.sidebar-sticky > *,
.sidebar > *{
    border-left-width:0!important;
    border-right-width:0!important;
    border-bottom-width:0!important;
}
</style>
</body>
</html>
