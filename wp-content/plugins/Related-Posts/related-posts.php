<?php

/*
 * Plugin Name:       Related Posts Plugin
 * Plugin URI:        https://Related-Posts
 * Description:       Show relative post on default view page.
 * Version:           .0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            sablu-hasan
 * Author URI:        https://www.facebook.com/md.doulot.3
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://www.facebook.com/md.doulot.3
 * Text Domain:       wda-batch-3
*/



namespace AB_Three;

class Relatd_Posts {

    public function __construct() {
        // Hook to add content below single post content
        add_filter('the_content', [$this, 'append_related_posts']);
    }

    public function append_related_posts($content) {
        if (is_single() && get_post_type() === 'post') {
            global $post;

            // Query arguments
            $args = [
                'post_type'      => 'post',
                'posts_per_page' => 5,
                'post__not_in'   => [$post->ID],
                'orderby'        => 'rand',
                'tax_query'      => [
                    [
                        'taxonomy' => 'category',
                        'field'    => 'term_id',
                        'terms'    => wp_get_post_categories($post->ID),
                    ],
                ],
            ];

            // Get related posts
            $related_posts = new \WP_Query($args);

            if (!empty($related_posts)) {
                ob_start();
            

                if ($related_posts->have_posts()) {
                    while ($related_posts->have_posts()) :
                        $related_posts->the_post();
                        $post_title = get_the_title();
                        $post_link = get_the_permalink();
                        $post_excerpt = wp_trim_words(get_the_content(), 10);
                        $post_image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                        ?>

                        <li>
                        <?php echo '<a href="'.get_the_permalink().'">.'.$post_image.'</a>'.'<br>' ?>
                        <?php echo '<a href="'.get_the_permalink().'">.'.$post_title.'</a>'.'<br><br>' ?>
                        <?php echo '<a href="'.get_the_permalink().'">'.$post_excerpt.'</a>'.'<br><br><br>';?>
                        </li>
                    
                        
                    
                    <?php
                    endwhile;
                    
                }

                echo '</ul>';
                echo '</div>';

                $content .= ob_get_clean();
            }
        }
        return $content;
    }

  
}

// Initialize the plugin
new Relatd_Posts();
