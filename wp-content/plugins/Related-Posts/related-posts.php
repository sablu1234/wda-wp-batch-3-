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


if( ! defined( 'ABSPATH' )){
    return;
}

class hasan_related_post{
    private static $instance;
//this is constructor
    private function construct (){
        $this->define_constants();
        $this->load_classe();
    }

    public static function get_instance (){
        if( self::$instance ) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
    }
//function define_constants
    private function define_constants(){
        define( 'HASAN_RELATIVE_PLUGIN_PATH', plugin_dir_path( __FILE__ )  );
    }
    //for class loaded
    private function load_classe () {
        require_once HASAN_RELATIVE_PLUGIN_PATH . 'includes/related-posts.php';
    }
}

hasan_related_post::get_instance();