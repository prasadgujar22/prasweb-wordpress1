<?php
/**
 * Sidebar template
 *
 * @package GuardianNews
 */

if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
    $popular = new WP_Query( [
        'posts_per_page'      => 5,
        'orderby'             => 'comment_count',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ] );
    if ( $popular->have_posts() ) :
    ?>
    <aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'guardian-news' ); ?>">
        <div class="sidebar-sticky">
            <div class="sidebar-widget">
                <h3 class="sidebar-widget-title"><?php esc_html_e( 'Most popular', 'guardian-news' ); ?></h3>
                <ol class="popular-list">
                    <?php while ( $popular->have_posts() ) : $popular->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ol>
            </div>
        </div>
    </aside>
    <?php
    endif;
    return;
}
?>

<aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'guardian-news' ); ?>">
    <div class="sidebar-sticky">
        <?php dynamic_sidebar( 'sidebar-primary' ); ?>
    </div>
</aside>
