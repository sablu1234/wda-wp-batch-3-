<?php
namespace HASAN_RP;

class Related_Post {


    public function __construct() {
        add_filter( 'the_content', [ $this, 'append_related_posts' ] );
    }

    public function append_related_posts( $content ) {
        if ( is_single() && get_post_type() === 'post' ) {
            global $post;

            $args = [
                'post_type'      => 'post',
                'posts_per_page' => 5,
                'post__not_in'   => [ $post->ID ],
                'orderby'        => 'rand',
                'tax_query'      => [
                    [
                        'taxonomy' => 'category',
                        'field'    => 'term_id',
                        'terms'    => wp_get_post_categories( $post->ID ),
                    ],
                ],
            ];

            $related_posts = new \WP_Query( $args );

            if ( $related_posts->have_posts() ) {
                ob_start();

                echo '<div class="related-posts">';
                echo '<h3>Related Posts</h3>';
                echo '<ul>';

                while ( $related_posts->have_posts() ) {
                    $related_posts->the_post();

                    $post_title = get_the_title();
                    $post_link = get_permalink();
                    $post_image = get_the_post_thumbnail( get_the_ID(), 'thumbnail' );

                    echo '<li>';
                    if ( $post_image ) {
                        echo '<a href="' . esc_url( $post_link ) . '">' . $post_image . '</a>';
                    }
                    echo '<a href="' . esc_url( $post_link ) . '">' . esc_html( $post_title ) . '</a>';
                    echo '</li>';
                }

                echo '</ul>';
                echo '</div>';

                $content .= ob_get_clean();

                wp_reset_postdata();
            }
        }

        return $content;
    }
}
