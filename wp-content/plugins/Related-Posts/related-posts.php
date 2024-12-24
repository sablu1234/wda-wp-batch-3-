<?php

/*
 * Plugin Name:       Related Posts Plugin
 * Plugin URI:        https://Related-Posts
 * Description:       Show related posts on the default view page.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sablu Hasan
 * Author URI:        https://www.facebook.com/md.doulot.3
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://www.facebook.com/md.doulot.3
 * Text Domain:       wda-batch-3
 */

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class Hasan_Related_Post {
    private static $instance;

    private function __construct() {
        $this->define_constants();
        $this->load_classes();
    }

    public static function get_instance() {
        if ( self::$instance ) {
            return self::$instance;
        }

        self::$instance = new self();
        return self::$instance;
    }

    private function define_constants() {
        define( 'HASAN_RELATIVE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    }

    private function load_classes() {
        require_once HASAN_RELATIVE_PLUGIN_PATH . 'includes/related_data.php';

          new HASAN_RP\Related_Post();
    }
}

// Initialize the plugin
Hasan_Related_Post::get_instance();
