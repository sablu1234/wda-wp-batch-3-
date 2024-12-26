<?php
namespace HASAN_RELATED_POST;

class related_Post {

    public function __construct()
    {
        add_filter('the_content', array($this,'the_content'));
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    }

    public function the_content($content){
        global $post;
        $args=array(
            'post_type' => 'post',
            'posts_per_page' =>5,
            'post__not_in' =>array($post->ID),
            'orderby' =>'rand',
            'tax_query' =>array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => wp_get_post_categories($post->ID),
                )
            ),

        );

        $related_post = new \WP_Query($args);

        if($related_post->have_posts()){
            ob_start();
            while($related_post->have_posts()){
                $related_post->the_post();

               echo '<div class ="related-posts-wrapper">';
               echo '<a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>';
               echo '<p>'.get_the_title().'</p>';
               echo '<p>'.wp_trim_words(get_the_content(),10,'.....').'</p>';
               echo '</div>';
            }
            $content .=ob_get_clean();
        }
        wp_reset_postdata();
        return $content;
    }

    public function enqueue_styles() {
        // Enqueue your plugin's CSS file
        wp_enqueue_style(
            'related-posts-style', // Handle
            plugin_dir_url( __FILE__ ) . 'assets/style.css', // Path to the CSS file
            [], // Dependencies
            '1.0.0' // Version
        );
    }

}
