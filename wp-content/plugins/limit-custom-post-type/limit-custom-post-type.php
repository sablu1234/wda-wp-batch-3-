<?php

/**
 * Plugin Name: Limit Custom Post Type
 * Description: Control the number of posts in custom post types and set the limit from the admin dashboard.
 * Version: 1.2
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Nababur_LimitCustomPostType
{
    private $option_name = 'nababur_limit_custom_post_settings';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'nababur_add_admin_menu']);
        add_action('admin_init', [$this, 'nababur_register_settings']);
        add_action('save_post', [$this, 'nababur_limit_posts'], 10, 3);
    }

    public function nababur_add_admin_menu()
    {
        add_options_page(
            'Limit Custom Post Settings',
            'Limit Custom Post',
            'manage_options',
            'nababur-limit-custom-post',
            [$this, 'nababur_settings_page']
        );
    }

    public function nababur_register_settings()
    {
        register_setting('nababur_custom_post_group', $this->option_name);

        add_settings_section(
            'nababur_limit_custom_post_section',
            'Settings',
            null,
            'nababur-limit-custom-post'
        );

        add_settings_field(
            'post_types',
            'Custom Post Types',
            [$this, 'nababur_post_types_field'],
            'nababur-limit-custom-post',
            'nababur_limit_custom_post_section'
        );

        add_settings_field(
            'max_posts',
            'Max Posts',
            [$this, 'nababur_max_posts_field'],
            'nababur-limit-custom-post',
            'nababur_limit_custom_post_section'
        );
    }

    public function nababur_post_types_field()
    {
        $options = get_option($this->option_name);
        $post_types = isset($options['post_types']) ? $options['post_types'] : [];
        $all_post_types = get_post_types(['public' => true], 'names');

        foreach ($all_post_types as $post_type) {
            $checked = in_array($post_type, $post_types) ? 'checked' : '';
            echo '<label><input type="checkbox" name="' . $this->option_name . '[post_types][]" value="' . esc_attr($post_type) . '" ' . $checked . '> ' . esc_html($post_type) . '</label><br />';
        }
    }

    public function nababur_max_posts_field()
    {
        $options = get_option($this->option_name);
        $max_posts = isset($options['max_posts']) ? $options['max_posts'] : 10;
        echo '<input type="number" name="' . $this->option_name . '[max_posts]" value="' . esc_attr($max_posts) . '" placeholder="Enter max posts" />';
    }

    public function nababur_settings_page()
    {
        echo '<div class="wrap">';
        echo '<h1>Limit Custom Post Settings</h1>';
        echo '<form method="post" action="options.php">';
        settings_fields('nababur_custom_post_group');
        do_settings_sections('nababur-limit-custom-post');
        submit_button();
        echo '</form>';
        echo '</div>';
    }

    public function nababur_limit_posts($post_id, $post, $update)
    {
        $options = get_option($this->option_name);
        $post_types = isset($options['post_types']) ? $options['post_types'] : [];
        $max_posts = isset($options['max_posts']) ? (int)$options['max_posts'] : 10;

        if (!in_array($post->post_type, $post_types) || wp_is_post_revision($post_id) || $post->post_status !== 'publish') {
            return;
        }

        foreach ($post_types as $post_type) {
            $query = new WP_Query([
                'post_type'      => $post_type,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ]);

            $posts = $query->posts;

            if (count($posts) > $max_posts) {
                $posts_to_delete = array_slice($posts, $max_posts);
                foreach ($posts_to_delete as $post_to_delete) {
                    wp_delete_post($post_to_delete, true);
                }
            }
        }
    }
}

new Nababur_LimitCustomPostType();
