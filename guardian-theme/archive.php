<?php
/**
 * Archive template (categories, tags, dates, authors)
 *
 * @package GuardianNews
 */

get_header();
?>

<div class="content-area">

    <main class="main-column" role="main">

        <header class="archive-header">
            <?php the_archive_title( '<h1 class="article-title">', '</h1>' ); ?>
            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
        </header>

        <?php if ( have_posts() ) : ?>

        <div class="section-header">
            <h2 class="section-title"><?php esc_html_e( 'Stories', 'guardian-news' ); ?></h2>
        </div>

        <div class="articles-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/card', 'article' ); ?>
            <?php endwhile; ?>
        </div>

        <?php
        the_posts_navigation( [
            'prev_text' => '&larr; ' . __( 'Older stories', 'guardian-news' ),
            'next_text' => __( 'Newer stories', 'guardian-news' ) . ' &rarr;',
        ] );
        ?>

        <?php else : ?>
        <p><?php esc_html_e( 'No stories found.', 'guardian-news' ); ?></p>
        <?php endif; ?>

    </main>

    <?php get_sidebar(); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
