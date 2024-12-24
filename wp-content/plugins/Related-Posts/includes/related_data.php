<?php 
namespace HASAN_RP;

class related_post{
    public function __construct()
    {
        add_filter( 'the_content', array( $this, 'the_content' ) );
    }

    public function the_content () {
        if (is_single() && get_post_type()==='post' ){
            global $post;
            //query aeguments

            $args =[ 
                'post_type' => 'post',
                'posts_per_page' => 5,
               'post__not_in'   => [$post->ID],
               'orderby'   => 'rand',
               'orderby'   => 'rand',
               'tax_query'   => [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => wp_get_post_categories( $post->ID ),
                ],
               ],
             ];
             
             //get related posts

             $related_posts = new \WP_Query( $args );
        }
    }
}