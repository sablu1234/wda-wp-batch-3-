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
        print_r ($terms);
        ob_start();

        ?>
        <ul>
            <?php foreach ( $terms as $term ) :?>
            <li><a href="<?php echo  get_term_link( $term, 'book_category' );?>"><?php echo $term->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
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


    
   
}