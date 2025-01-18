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
if( ! defined('ABSPATH') ){
    exit;
}

class Simple_Auth{
    public function __construct(){
        add_shortcode( 'simple-auth', [$this, 'render_shortocde']);
        add_action( 'wp_enqueue_scripts',[ $this, 'enqueue_scripts' ] );

        //login and profile update
        add_action( 'wp_ajax_simple-auth-profile-form', [$this, 'update_profile'] );
        add_action( 'wp_ajax_nopriv_simple_auth_login_form', [$this, 'handle_login'] );
    }

    public function enqueue_scripts(){
        wp_enqueue_style( 'simple-auth-style', plugin_dir_url(__FILE__) . 'assets/css/auth.css' );
        wp_enqueue_script( 'simple-auth-js', plugin_dir_url(__FILE__) . 'assets/js/auth.js',['jquery','wp-util'] );
        wp_localize_script( 'simple-auth-js', 'simpleAuthAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'simple-auth-profile' ),
        ] );
    }

    public function render_shortocde(){
        if( is_user_logged_in() ){
            return $this->render_profile_page();
        }else{
            return $this->render_auth_page();
        }
    }
    
    public function update_profile(){
        if( ! wp_verify_nonce($_POST['_wpnonce'], 'simple-auth-profile') ){
            return wp_send_json_error([
                'message' => 'Nonce Verification Failed',
            ]);
        }

        $dispaly_name = sanitize_text_field( $_POST['display_name'] );
        $email = sanitize_text_field( $_POST['email'] );

        $user = wp_update_user([
            'ID' => get_current_user_id(),
            'display_name' => $dispaly_name,
            'user_email' => $email,
        ]);

        wp_send_json_success([
            'message' => 'Profile Updated',
        ]);
    }

    public function handle_login(){
        check_ajax_referer( 'simple-auth-login');

        $username = sanitize_text_field( $_POST['username'] );
        $password = sanitize_text_field( $_POST['password'] );

        $user = wp_signon([
            'user_login' =>$username,
            'user_password' =>$password,
            'remember' => true,
        ]);

        if( is_wp_error($user) ){
            wp_send_json_error([
                'message' => $user->get_error_message(),
            ]);
        }

        wp_send_json_success([
            'message' => 'login success',
        ]);
    }

    public function render_profile_page(){
        $user = wp_get_current_user();

        ob_start();
        ?>
            <div id="simple-auth-profile">
            <h2>Update Profile</h2>
            <div id="profile-update-message" class="success-message hidden" ></div>
                <form method="POST" id="profile-form">
                    <label>
                        Display Name
                        <input type="text" name="display_name" required value="<?php echo esc_attr($user->display_name);?>">
                    </label>

                    <label>
                        Email
                        <input type="email" name="email" required value="<?php echo esc_attr($user->user_email);?>">
                    </label>

                    <input type="hidden" name="action" value="simple-auth-profile-form" />

                    <button type="submit">Update Profile</button>
                </form>
            </div>
        <?php
        return ob_get_clean();
    }

 

    public function render_auth_page(){
        $user = wp_get_current_user();

        ob_start();
        ?>
            <div id="simple-auth-profile">
            <h2>login</h2>

            <div id="login-message" class="hidden" ></div>
                <form method="POST" id="simple-auth-login-form">
                    <label>
                        Username
                        <input type="text" name="username" required value="" placeholder="username">
                    </label>

                    <label>
                        password
                        <input type="password" name="password" required value="" placeholder="password">
                    </label>

                    <input type="hidden" name="action" value="simple-auth-login-form" />

                    <?php wp_nonce_field( 'simple-auth-login' );?>

                    <button type="submit">login</button>
                </form>
            </div>
        <?php
        return ob_get_clean();
    }
}
new Simple_Auth();