<?php
/**
 * Plugin Name: WP ajax
 * Description: A Test plugin for Ajax
 * version: 1.0.0
 * Author: weDevs academy
 * License: GPLv2
 * Author URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: test-plugin
*/

//Exit if access directly

if(!defined('ABSPATH')){
    exit;
}

class Simple_Auth{
    public function __construct()
    {
        add_shortcode( 'simple-auth', [$this, 'render_shortcode'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );

        //login and profile update
        add_action( 'wp_ajax_simple-auth-profile-form', [$this, 'update_profile'] );
    }

    public function enqueue_scripts(){
        wp_enqueue_style( 'simple-auth-style', plugin_dir_url(__FILE__). 'assets/css/auth.css' );
        wp_enqueue_script( 'simple-auth-js', plugin_dir_url(__FILE__). 'assets/js/auth.js',['jquery', 'wp-util'] );
        wp_localize_script( 'simple-auth-js','simpleAuthAjax',[
            'ajax_url'=> admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('simple-auth-profile'),
        ] );
    }

    public function render_shortcode(){
        if(is_user_logged_in()){
            return $this->render_profile_spage();
        } else {
            return $this->render_auth_page();
        }
    }

    public function update_profile () {
        if( ! wp_verify_nonce( $_POST['_wpnonce'], 'simple-auth-profile' ) ) {
            return wp_send_json_error([
                'message' => 'nonce verification faild',
            ]);
        }

        $display_name = sanitize_text_field( $_POST['display_name'] );
        $email = sanitize_email( $_POST['email'] );

        wp_update_user([
            'ID' => get_current_user_id(),
            'display_name' => $display_name,
            'user_email' => $email,
        ]);
        
        wp_send_json_success( [
            'message' => 'Profile updated',
        ] );   
    }

    public function render_profile_spage(){
        $user= wp_get_current_user();
        ob_start();
        ?>
        <div id="simple-auth-profile" >
        <h2>Update Profile</h2>
        <div id="profile-update-message" ></div>

        <form method="post" id="profile-form" >
            <label>
                Display Name
                <input type="text" name="display_name" required value="<?php echo esc_attr($user->display_name);?>" >
            </label>

            <label>
                Email
                <input type="text" name="email" required value="<?php echo esc_attr($user->user_email); ?>" >
            </label>

            <input type="hidden" name="action" value="simple-auth-profile-form" />
            <button type="submit">Update Profile</button>
        </form>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_auth_page(){
        return 'login form';
    }

}

new Simple_Auth();