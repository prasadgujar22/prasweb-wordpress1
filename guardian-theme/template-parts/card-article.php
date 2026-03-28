<?php
/**
 * Article card partial — used in index, archive, search templates
 *
 * @package GuardianNews
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card' ); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="article-card-image">
        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
            <?php the_post_thumbnail( 'guardian-card', [ 'alt' => '' ] ); ?>
        </a>
    </div>
    <?php endif; ?>

    <?php
    $cats = get_the_category();
    if ( $cats ) :
        $cat   = $cats[0];
        $color = guardian_get_section_color( $cat->slug );
    ?>
    <p class="article-card-section">
        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
           style="color:<?php echo esc_attr( $color ); ?>;">
            <?php echo esc_html( $cat->name ); ?>
        </a>
    </p>
    <?php endif; ?>

    <?php if ( has_tag( 'live' ) ) : ?>
    <span class="live-badge"><?php esc_html_e( 'Live', 'guardian-news' ); ?></span>
    <?php endif; ?>

    <h3>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>

    <?php if ( get_the_excerpt() ) : ?>
    <p class="article-card-standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>

    <p class="article-card-meta">
        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
            <?php echo esc_html( guardian_relative_time( get_the_time( 'U' ) ) ); ?>
        </time>
    </p>

</article>
