<?php
/*
* Plugin Name: Sablu hasan practice
* Plugin URI: https://example.com
* Description: Hi i am hasan this is my practice perpase plugin
* Version: 1.0.1
* Author: sablu hasan
* Author URI: www.sablu.com
* License: GPLv2
* License URI:  https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wedevs_academy_batch_3.php
*/



class HASAN_PRACTICE_CLASS {
    private static $instance;

    private function __construct() {
        add_filter( 'the_content', array( $this, 'the_content' ) );
        add_action( 'wp_footer', array( $this, 'wp_footer' ) );

    }

    public static function get_instance(){
        if( self::$instance ) {
            return self::$instance;
        }

        self::$instance = new self();
    }


    
    public function the_content( $content ){

    $url = get_the_permalink();
    $image = '<p><img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt=""></p>';
    $content.= $image;
    return $content;
    }

    public function wp_footer(){
        $url = home_url();
        $image = '<p><img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt=""></p>';

        echo $image;
    }
}
HASAN_PRACTICE_CLASS::get_instance();





 