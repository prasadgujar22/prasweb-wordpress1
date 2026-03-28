<?php
/**
 * 404 template
 *
 * @package GuardianNews
 */

get_header();
?>

<div class="content-area">
    <main class="main-column" role="main">
        <h1 class="article-title"><?php esc_html_e( '404 – Page not found', 'guardian-news' ); ?></h1>
        <p class="hero-standfirst">
            <?php esc_html_e( 'The page you were looking for doesn\'t exist. It may have been moved or deleted.', 'guardian-news' ); ?>
        </p>
        <?php get_search_form(); ?>
    </main>
</div>

<?php get_footer(); ?>
