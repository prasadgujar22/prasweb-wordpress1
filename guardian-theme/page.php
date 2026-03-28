<?php
/**
 * Page template
 *
 * @package GuardianNews
 */

get_header();
?>

<div class="content-area">

    <main class="main-column" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>

            <h1 class="article-title"><?php the_title(); ?></h1>

            <?php if ( has_post_thumbnail() ) : ?>
            <figure class="article-featured-image">
                <?php the_post_thumbnail( 'guardian-hero', [ 'alt' => get_the_title() ] ); ?>
            </figure>
            <?php endif; ?>

            <div class="article-content">
                <?php the_content(); ?>
            </div>

        </article>

        <?php endwhile; ?>

    </main>

    <?php get_sidebar(); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
