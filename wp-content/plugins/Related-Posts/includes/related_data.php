<?php
namespace HASAN_RP;

class Related_Post {


    public function __construct() {
        add_filter( 'the_content', array($this, 'the_content') );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

    }

    public function the_content( $content ) {
       
        
        global $post;

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 5,
            'post__not_in'   => array($post->ID),
            'orderby'        => 'rand',
            'tax_query'      => array(array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => wp_get_post_categories( $post->ID ),
            )),
        );

        $related_posts = new \WP_Query( $args );

        if($related_posts->have_posts()){
            ob_start();

          echo '<div class="related-posts-grid">';

          while($related_posts->have_posts()){
            $related_posts->the_post();

            echo '<div class="related_post">';
                echo '<div class="post_item">';

                    echo '<li style="list-style:none;">';

                    echo '<a href="' .get_permalink(). '">' .get_the_post_thumbnail( get_the_ID(), 'thumbnail' ). '</a>';
                    echo '<p>' .  get_the_title() . '</p>';
                    echo '<p>' . wp_trim_words(get_the_content(), 10) . '</p>';

                    echo '</li>';

                echo '</div>';
            echo '</div>';
        }
        $content .= ob_get_clean();
          echo "</div>";
        }
        return $content;
    }

    public function wp_enqueue_scripts (){
        wp_enqueue_style( 'related_post_style', plugin_dir_url(__FILE__) . 'css/related-posts.css' );
    }
}
