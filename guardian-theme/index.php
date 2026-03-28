<?php
/**
 * Main template file (Homepage / Blog Index)
 *
 * @package GuardianNews
 */

get_header();
?>

<!-- Date + Edition bar -->
<div class="date-edition-header">
    <span class="edition-name"><?php echo esc_html( get_theme_mod( 'guardian_edition_label', 'Int' ) ); ?></span>
    <span class="current-date"><?php echo esc_html( date_i18n( 'j F Y' ) ); ?></span>
</div>

<?php if ( have_posts() ) : ?>

    <div class="content-area">

        <!-- ===== MAIN COLUMN ===== -->
        <main class="main-column" role="main">

            <?php
            $post_count = 0;
            $hero_done  = false;

            while ( have_posts() ) :
                the_post();
                $post_count++;

                // First post = hero
                if ( ! $hero_done ) :
                    $hero_done = true;
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'hero-section' ); ?>>

                <?php
                // Live badge if "live" tag present
                if ( has_tag( 'live' ) ) :
                ?>
                <span class="live-badge"><?php esc_html_e( 'Live', 'guardian-news' ); ?></span>
                <?php endif; ?>

                <?php
                $cats = get_the_category();
                if ( $cats ) :
                ?>
                <p class="hero-kicker">
                    <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>">
                        <?php echo esc_html( $cats[0]->name ); ?>
                    </a>
                </p>
                <?php endif; ?>

                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                <?php if ( has_post_thumbnail() ) : ?>
                <div class="hero-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'guardian-hero', [ 'alt' => get_the_title() ] ); ?>
                    </a>
                </div>
                <?php endif; ?>

                <?php if ( get_the_excerpt() ) : ?>
                <p class="hero-standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <p class="hero-timestamp">
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                        <?php
                        $ts = get_the_time( 'U' );
                        echo esc_html( guardian_relative_time( $ts ) );
                        ?>
                    </time>
                </p>

            </article>

            <?php else : // Remaining posts as cards ?>

            <?php if ( $post_count === 2 ) : ?>
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'Latest', 'guardian-news' ); ?></h2>
            </div>
            <div class="articles-grid">
            <?php endif; ?>

                <?php get_template_part( 'template-parts/card', 'article' ); ?>

            <?php endif; // hero vs card ?>

            <?php endwhile; ?>

            <?php if ( $post_count > 1 ) : ?>
            </div><!-- .articles-grid -->
            <?php endif; ?>

            <?php
            the_posts_navigation( [
                'prev_text' => '&larr; ' . __( 'Older stories', 'guardian-news' ),
                'next_text' => __( 'Newer stories', 'guardian-news' ) . ' &rarr;',
            ] );
            ?>

        </main><!-- .main-column -->

        <!-- ===== SIDEBAR ===== -->
        <?php get_sidebar(); ?>

    </div><!-- .content-area -->

<?php else : ?>

    <p class="no-posts"><?php esc_html_e( 'No stories found.', 'guardian-news' ); ?></p>

<?php endif; ?>

<?php get_footer(); ?>
