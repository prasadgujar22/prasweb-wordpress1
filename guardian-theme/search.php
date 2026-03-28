<?php
/**
 * Search results template
 *
 * @package GuardianNews
 */

get_header();
?>

<div class="content-area">

    <main class="main-column" role="main">

        <h1 class="article-title">
            <?php
            /* translators: %s: search query */
            printf( esc_html__( 'Search results for: %s', 'guardian-news' ), '<span>' . get_search_query() . '</span>' );
            ?>
        </h1>

        <?php get_search_form(); ?>

        <?php if ( have_posts() ) : ?>

        <div class="articles-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/card', 'article' ); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_navigation(); ?>

        <?php else : ?>
        <p><?php esc_html_e( 'No stories matched your search.', 'guardian-news' ); ?></p>
        <?php endif; ?>

    </main>

    <?php get_sidebar(); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
