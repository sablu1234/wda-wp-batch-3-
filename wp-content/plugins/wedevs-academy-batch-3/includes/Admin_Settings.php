<?php
namespace AB_Three;

class Admin_Settings{
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu(){
        //admin page add
        add_menu_page(
            'Admin settings',
            'Admin settings',
            'manage_options',
            'ab_three_admin_settings',//slug
            array($this,'ab_three_admin_page'),
            'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#ddd"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>'),
            30
        );

        //admin_submenu under admin page
        add_submenu_page(
            'ab_three_admin_settings',
            'Admin Submenu',
            'Admin Submenu',
            'manage_options',
            'ab_three_submenu',//slug
            array($this, 'ab_three_admin_submenu_callback'),
        );



       
    }

    public function ab_three_admin_page(){

        if(isset($_POST['submit'])){

            if( ! wp_verify_nonce($_POST['ab_three_nonce'], 'ab_three') ){
                echo 'You are not valid';
                return;
            }

            $ab_three_title = isset($_POST['ab_three_title']) ? sanitize_text_field($_POST['ab_three_title']) : '';
            $ab_three_title = isset($_POST['ab_three_email']) ? sanitize_text_field($_POST['ab_three_email']) : '';
            $ab_three_title = isset($_POST['ab_three_title']) ? sanitize_text_field($_POST['ab_three_option']) : '';
            update_option( 'ab_three_title', $ab_three_title );
            
        }
        ?>
       <div class="wrap">
        <h1>Admin settings</h1>
       <form action="<?php echo esc_url(admin_url(''));?>admin.php?page=ab_three_admin_settings" method="post">
        <input type="hidden" name="ab_three_nonce" value="<?php echo wp_create_nonce('ab_three');?>">

            <table class="form-table">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input type="text" class="regular-text" name="ab_three_title"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="text" class="regular-text" name="ab_three_email"></td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>
                            <select name="ab_three_option" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
        </form>
       </div>
        <?php
    }

    public function ab_three_admin_submenu_callback(){
        ?>
        submenu
        <?php
    }
}