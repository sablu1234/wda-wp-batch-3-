<?php 
namespace AB_Three;


if ( ! defined ( 'ABSPATH' ) ) {
    exit;
}

class Post_Type {

    public function __construct() {
        add_action( 'init', array ( $this, 'init' ) );

        add_filter( 'the_content', array( $this, 'the_content' ) );
        add_filter( 'manage_book_posts_columns', array($this, 'manage_book_posts_columns') );
        add_action( 'manage_book_posts_custom_column', array($this, 'manage_book_posts_custom_column'), 10, 2 );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post_book', array( $this, 'save_post_book' ) );

        if ( file_exists( AB_THREE_PLUGIN_PATH . 'lib/CMB2/init.php' ) ) {
            require_once AB_THREE_PLUGIN_PATH . 'lib/CMB2/init.php';
        }

        add_action( 'cmb2_admin_init', array( $this, 'cmb2_admin_init' ) );
    }

    public function init () {
        register_post_type( 'book', array(
            'labels' => array (
                'name' => 'Books',
                'singular_name' => 'book',
                'add_new' => 'Add New Book',
                'search_items' => 'Search Book',
                'view_item' => 'View Book',
                'not_found' => 'No Books Found',
            ),
            'public' =>true,
            'show_in_rest' => true,
            'supports' => array ( 'title','editor','thumbnail','page-attributes' ),
            'hierarchical' => true,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => true,
            'menu_position' => 3,
      
            'has_archive' => true,
            'rewrite' => array ( 'slug' => 'books' ),
        ) );

        register_taxonomy ( 'book_category', 'book', array(
            'labels' => array(
                'name' => 'Categories',
                'singular_name' => 'Categorie',
                'add_new_item'=> 'Add new Categories',
            ),

            'show_in_rest' =>true,
            'hierarchical' =>true,
            'rewrite' => array ( 'slug' => 'books-categories' ),
        ));


        register_taxonomy ( 'book_tags', 'book', array(
            'labels' => array(
                'name' => 'Tags',
                'singular_name' => 'Tag',
                'add_new_item'=> 'Add new Tag',
            ),

            'show_in_rest' =>true,
            'hierarchical' =>false,
        ));
    }



    public function the_content ( $contents ) {

        if ( ! is_singular ( 'book' ) ) {
            return $contents;
        }

        $terms = wp_get_post_terms( get_the_ID(), 'book_category');
        // print_r ($terms);
        $another_title = get_post_meta( get_the_ID(), 'another_title', true );
        $another_group = get_post_meta( get_the_ID(), 'another_title_group', true );
        ob_start();
        
        // print_r($another_group);
        foreach( $another_group as $single_group ){
            
            if(isset($single_group['another_title_second'])){
                // print_r($single_group['another_title_second']);
                $vari = $single_group['another_title_second'];
                foreach( $vari as $item ){
                    echo $item;
                }
            }
        }

        ?>
        <ul>
            <?php foreach ( $terms as $term ) :?>
            <li><a href="<?php echo  get_term_link( $term, 'book_category' );?>"><?php echo $term->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <h3>Another Title:<?php echo $another_title; ?></h3>
        <?php
        $html = ob_get_clean();

        return $contents .$html;
    }

    public function manage_book_posts_columns ($columns){

        $new_columns =array();
        foreach ($columns as $key=>$column ){
            if('title'== $key){
                $new_columns['cat']= 'Categories';
            }
            $new_columns[$key]=$column;
        }

        return $new_columns ;
    }

    public function manage_book_posts_custom_column($column_name, $post_id){
        // var_dump($column_name);
        
        if('cat' === $column_name){
            $terms = wp_get_post_terms($post_id, 'book_category');
            // var_dump($terms);
            if( ! empty($terms)){
                $term_name=array_map( function($term){
                    return $term->name;
                }, $terms );
                echo implode( ' ,', $term_name );
            }
        }
    }

    public function add_meta_boxes (){
        add_meta_box (
            'my-custom-metabox',
            'Custom Meta Box',
            array( $this, 'my_custom_metabox_callback' ),
            'book',
        );
    }

    public function my_custom_metabox_callback ( $post ){
        $book_subtitle = get_post_meta ( $post->ID, 'book_subtitle', true);
        ?>
        <p>
            <label for="">Subtitle</label>
            <input type="text" name="book_subtitle" value="<?php echo $book_subtitle; ?>">
        </p>
        <?php
    }

    public function save_post_book ( $post_id ){
        if (isset($_POST['book_subtitle'])){
            update_post_meta ( $post_id, 'book_subtitle', $_POST['book_subtitle'] );
        }
    }

    public function cmb2_admin_init () {
        $box1 = new_cmb2_box( array(
            'id' => 'custom-cmb2-box',
            'title' => 'Custom CMB2 Box',
            'object_types' => array( 'book' ),
        ) );

        $box1->add_field( array(
            'id' => 'another_title',
            'name' => 'Another Title',
            'desc' => 'Enter Another Title',
            'type' => 'text',
        ) );

        $group_field_id = $box1->add_field( array(
            'id' => 'another_title_group',
            'description' => 'Enter Another Title',
            'type' => 'group',
        ) );

        $box1->add_group_field( $group_field_id,array(
            'id' => 'another_title_second',
            'name' => 'Another Second Title',
            'desc' => 'Enter Second Another Title',
            'type' => 'text',
            'repeatable' => true,
        ) );

        $box1->add_group_field( $group_field_id,array(
            'id' => 'another_select_second',
            'name' => 'Another Select',
            'desc' => 'Enter Second Select',
            'type' => 'select',
            'options' => array(1,2,3),
        ) );




    }


    
   
}