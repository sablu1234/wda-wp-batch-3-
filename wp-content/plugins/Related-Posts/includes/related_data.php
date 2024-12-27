<?php
namespace HS_RELATED_POST;

class RELATED_POST_FRIST{
    public function __construct()
    {
        add_filter('the_content',array($this,'the_content'));
    }

    public function the_content($content){
        global $post;
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post__not_in' =>array($post->ID),
            'orderby' =>'rand',
            'tax_query' =>array(
                'taxonomy'=>'category',
                'field'=>'term_id',
                'terms'=>wp_get_post_categories($post->ID),
            ),
        );

        $related_posts = new \WP_Query( $args );

        if($related_posts->have_posts()){
          ob_start();
          while($related_posts->have_posts()){
            $related_posts->the_post();

            echo '<a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>';
            echo '<p>'.get_the_title().'</p>';
            echo '<p>'.wp_trim_words(get_the_content(), 10).'</p>';
        }
          $content .= ob_get_clean();
        }
        return $content;
    }
}