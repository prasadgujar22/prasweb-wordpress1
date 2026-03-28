<?php
/**
 * Single post template
 *
 * @package GuardianNews
 */

get_header();
?>

<div class="content-area">

    <main class="main-column" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>

            <?php
            $cats = get_the_category();
            if ( $cats ) :
                $cat   = $cats[0];
                $color = guardian_get_section_color( $cat->slug );
            ?>
            <p class="article-section-label" style="border-color:<?php echo esc_attr( $color ); ?>; color:<?php echo esc_attr( $color ); ?>;">
                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="color:inherit;">
                    <?php echo esc_html( $cat->name ); ?>
                </a>
            </p>
            <?php endif; ?>

            <?php if ( has_tag( 'live' ) ) : ?>
            <span class="live-badge"><?php esc_html_e( 'Live', 'guardian-news' ); ?></span>
            <?php endif; ?>

            <h1 class="article-title"><?php the_title(); ?></h1>

            <?php if ( get_the_excerpt() ) : ?>
            <p class="article-standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>

            <div class="article-byline">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', get_the_author(), [ 'class' => 'byline-avatar' ] ); ?>
                <span class="byline-name"><?php the_author_posts_link(); ?></span>
            </div>

            <p class="article-date">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php
                    $ts = get_the_time( 'U' );
                    echo esc_html( guardian_relative_time( $ts ) );
                    ?>
                </time>
                <?php if ( get_the_modified_time( 'U' ) > $ts + 300 ) : ?>
                &middot;
                <?php esc_html_e( 'Modified', 'guardian-news' ); ?>
                <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
                    <?php echo esc_html( guardian_relative_time( get_the_modified_time( 'U' ) ) ); ?>
                </time>
                <?php endif; ?>
            </p>

            <?php if ( has_post_thumbnail() ) : ?>
            <figure class="article-featured-image">
                <?php the_post_thumbnail( 'guardian-hero', [ 'alt' => get_the_title() ] ); ?>
                <?php
                $caption = get_the_post_thumbnail_caption();
                if ( $caption ) :
                ?>
                <figcaption class="article-image-caption"><?php echo esc_html( $caption ); ?></figcaption>
                <?php endif; ?>
            </figure>
            <?php endif; ?>

            <div class="article-content">
                <?php the_content(); ?>
            </div>

            <?php
            wp_link_pages( [
                'before' => '<div class="page-links">' . __( 'Pages:', 'guardian-news' ),
                'after'  => '</div>',
            ] );
            ?>

            <footer class="entry-footer">
                <?php the_tags( '<div class="entry-tags">', ', ', '</div>' ); ?>
            </footer>

        </article>

        <?php
        the_post_navigation( [
            'prev_text' => '<span class="nav-subtitle">' . __( 'Previous story', 'guardian-news' ) . '</span><span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . __( 'Next story', 'guardian-news' ) . '</span><span class="nav-title">%title</span>',
        ] );
        ?>

        <?php if ( comments_open() || get_comments_number() ) : ?>
            <?php comments_template(); ?>
        <?php endif; ?>

        <?php endwhile; ?>

    </main><!-- .main-column -->

    <?php get_sidebar(); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
