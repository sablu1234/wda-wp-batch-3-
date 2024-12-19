<?php 

/*
* Plugin Name: My Custom
*/


function academy_show_post_content_qr_code_callback () {
    return false;
}
add_filter( 'academy_show_post_content_qr_code', 'academy_show_post_content_qr_code_callback', 10 );

function academy_show_post_content_qr_code_callback2 () {
    return true;
}

add_filter( 'academy_show_post_content_qr_code', 'academy_show_post_content_qr_code_callback2', 11 );

function before_footer_qr_code_callback ($args) {
    print_r($args);
    echo "this is berore";
}
add_action( 'before_footer_qr_code', 'before_footer_qr_code_callback',20, 1 );

//Another plugin/code
// remove_action( 'before_footer_qr_code', 'before_footer_qr_code_callback', 20 );

add_filter('qr_code_css_classes', function ($classes) {
    print_r($classes);
    $classes[]='my-custom-class';
    return $classes;
}, 10, 1 );

?>