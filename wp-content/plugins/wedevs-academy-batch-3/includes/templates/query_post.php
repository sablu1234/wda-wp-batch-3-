


<div class="wrap">
    <h1>Query Post</h1>
    <div class="tablenav top">
       <form action="<?php echo admin_url();?>admin.php" method="GET">
       <div class="alignleft actions">
        <input type="hidden" name="page" value="ab_three_query_post">
            <select name="filter_cat" id="cat" class="postform">
                <option value="0">All Categories</option>
                <?php foreach ($terms as $term) :?>
                <option  value="<?php echo $term->term_id; ?>" <?php echo $filter_cat == $term->term_id ? 'selected' : ''; ?>><?php echo $term->name; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" class="button" value="Filter">
        </div>
       </form>
    </div>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
           
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Categoris</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $posts as $post ) : ?>
            <tr>
                <td><?php echo $post->post_title; ?></td>
                <td>
                    <?php 
                    $user = get_user_by( 'id',$post->post_author );
                    echo $user->display_name;
                    ?>
                </td>
                <td>
                    <?php 
                   $terms = wp_get_post_terms($post->ID, 'category');
                   $term_names = array_map( function( $term ) {
                    return $term->name; 
                   }, $terms);
                   echo implode(', ',$term_names);
                    ?>
                </td>
                <td><?php echo wp_date(' d F, Y ', strtotime($post->post_date) ); ?></td>
            </tr>
        </tbody>
        <?php endforeach;?>
    </table>
</div>