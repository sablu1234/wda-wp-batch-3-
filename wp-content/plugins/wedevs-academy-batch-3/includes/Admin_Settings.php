<?php
namespace AB_Three;

class Admin_Settings{
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu(){
        add_menu_page(
            'Admin Settings',
            'Admin Settings',
            'manage_options',
            'ab_three_admin_settings',
            array( $this, 'ab_three_admin_settings' ),
           'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBmaWxsPSIjZmZmIj48IS0tIUZvbnQgQXdlc29tZSBGcmVlIDYuNy4yIGJ5IEBmb250YXdlc29tZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tIExpY2Vuc2UgLSBodHRwczovL2ZvbnRhd2Vzb21lLmNvbS9saWNlbnNlL2ZyZWUgQ29weXJpZ2h0IDIwMjUgRm9udGljb25zLCBJbmMuLS0+PHBhdGggZD0iTTQ5NS45IDE2Ni42YzMuMiA4LjcgLjUgMTguNC02LjQgMjQuNmwtNDMuMyAzOS40YzEuMSA4LjMgMS43IDE2LjggMS43IDI1LjRzLS42IDE3LjEtMS43IDI1LjRsNDMuMyAzOS40YzYuOSA2LjIgOS42IDE1LjkgNi40IDI0LjZjLTQuNCAxMS45LTkuNyAyMy4zLTE1LjggMzQuM2wtNC43IDguMWMtNi42IDExLTE0IDIxLjQtMjIuMSAzMS4yYy01LjkgNy4yLTE1LjcgOS42LTI0LjUgNi44bC01NS43LTE3LjdjLTEzLjQgMTAuMy0yOC4yIDE4LjktNDQgMjUuNGwtMTIuNSA1Ny4xYy0yIDkuMS05IDE2LjMtMTguMiAxNy44Yy0xMy44IDIuMy0yOCAzLjUtNDIuNSAzLjVzLTI4LjctMS4yLTQyLjUtMy41Yy05LjItMS41LTE2LjItOC43LTE4LjItMTcuOGwtMTIuNS01Ny4xYy0xNS44LTYuNS0zMC42LTE1LjEtNDQtMjUuNEw4My4xIDQyNS45Yy04LjggMi44LTE4LjYgLjMtMjQuNS02LjhjLTguMS05LjgtMTUuNS0yMC4yLTIyLjEtMzEuMmwtNC43LTguMWMtNi4xLTExLTExLjQtMjIuNC0xNS44LTM0LjNjLTMuMi04LjctLjUtMTguNCA2LjQtMjQuNmw0My4zLTM5LjRDNjQuNiAyNzMuMSA2NCAyNjQuNiA2NCAyNTZzLjYtMTcuMSAxLjctMjUuNEwyMi40IDE5MS4yYy02LjktNi4yLTkuNi0xNS45LTYuNC0yNC42YzQuNC0xMS45IDkuNy0yMy4zIDE1LjgtMzQuM2w0LjctOC4xYzYuNi0xMSAxNC0yMS40IDIyLjEtMzEuMmM1LjktNy4yIDE1LjctOS42IDI0LjUtNi44bDU1LjcgMTcuN2MxMy40LTEwLjMgMjguMi0xOC45IDQ0LTI1LjRsMTIuNS01Ny4xYzItOS4xIDktMTYuMyAxOC4yLTE3LjhDMjI3LjMgMS4yIDI0MS41IDAgMjU2IDBzMjguNyAxLjIgNDIuNSAzLjVjOS4yIDEuNSAxNi4yIDguNyAxOC4yIDE3LjhsMTIuNSA1Ny4xYzE1LjggNi41IDMwLjYgMTUuMSA0NCAyNS40bDU1LjctMTcuN2M4LjgtMi44IDE4LjYtLjMgMjQuNSA2LjhjOC4xIDkuOCAxNS41IDIwLjIgMjIuMSAzMS4ybDQuNyA4LjFjNi4xIDExIDExLjQgMjIuNCAxNS44IDM0LjN6TTI1NiAzMzZhODAgODAgMCAxIDAgMC0xNjAgODAgODAgMCAxIDAgMCAxNjB6Ii8+PC9zdmc+',
           3,
        );


        add_submenu_page(
            'ab_three_admin_settings',
            'Sub Menu',
            'Sub Menu',
            'manage_options',
            'ab_three_admin_settings_sub_menu',
            array( $this, 'sub_menu' ),
        );

        // remove_submenu_page( 'ab_three_admin_settings', 'ab_three_admin_settings' );


    }

    public function ab_three_admin_settings(){

        var_dump( $_GET['page'] );
        //check the form is submited
        if(isset($_POST['submit'])){
            //verify nonce.
            if( ! wp_verify_nonce( $_POST['ab_three_nonce'], 'ab_three' ) ){
                echo 'you are not valid';
                return;
            }

            $ab_three_title = isset( $_POST['ab_three_title'] ) ? sanitize_text_field($_POST['ab_three_title']) : '';
            $ab_three_email = isset( $_POST['ab_three_email'] ) ? sanitize_text_field($_POST['ab_three_email']) : '';
            $ab_three_option = isset( $_POST['ab_three_option'] ) ? sanitize_text_field($_POST['ab_three_option']) : '';


            $post_array = array(
                'ab_three_title' => $ab_three_title,
                'ab_three_email' => $ab_three_email,
                'ab_three_option' => $ab_three_option,
            );
            update_option( 'ab_three_settings', $post_array );
        }

        $settings_data = get_option( 'ab_three_settings', array() );
        var_dump($settings_data);

        $ab_three_option_value = isset( $settings_data['ab_three_option']) ?  $settings_data['ab_three_option'] : '1';

        ?>
        <div class="wrap">
            <h1>Admin Settings</h1>
            <form action="<?php echo esc_url(admin_url());?>admin.php?page=ab_three_admin_settings" method="post">
                <input type="hidden" name="ab_three_nonce" value="<?php echo wp_create_nonce('ab_three')?>">
                <?php echo wp_nonce_field( 'ab_three', 'ab_three_nonce' );?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <label>Ttile</label>
                            </th>
                            <td>
                                <input type="text" class="regular-text" name="ab_three_title" value="<?php echo isset( $settings_data['ab_three_title']) ? wp_unslash(esc_attr($settings_data['ab_three_title'])) : '' ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Email</label>
                            </th>
                            <td>
                                <input type="text" class="regular-text" name="ab_three_email" value="<?php echo isset( $settings_data['ab_three_email']) ? wp_unslash(esc_attr($settings_data['ab_three_email'])) : '' ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Choose One</label>
                            </th>
                            <td>
                                <select name="ab_three_option">
                                    <option value="1" <?php echo $ab_three_option_value== '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?php echo $ab_three_option_value== '2' ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?php echo $ab_three_option_value== '3' ? 'selected' : '' ?>>3</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
        </div>
        <?php
    }

    public function sub_menu(){
        ?>
        Sub menu
        <?php
    }




}