<?php if (!defined('ABSPATH')) exit;

class AFFrontUtilsAdmin
{
	private static $_instance = NULL;
	
	public static function get_instance()
	{
		if (self::$_instance === NULL)
			self::$_instance = new self();
		return (self::$_instance);
	}
	
	private function __construct()
	{		
		add_action('admin_menu', array($this, 'add_admin_menu'));
		
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
	}
	
	public function enqueue_scripts()
	{
		wp_enqueue_style('AFFrontUtilsAdmin', plugin_dir_url(AFFrontUtils::PLUGIN_FILE) . 'assets/css/admin.css');
    }
	
	/************************************************************************
	 * Add admin menu
	 ************************************************************************/
	public function add_admin_menu()
	{
		add_submenu_page('asgarosforum-structure', __('Frontend Utilities by Quenso', 'af-front-utils'), __('Frontend Utilities', 'af-front-utils'), 'read', 'asgarosforum-frontend-utilities', array(&$this, 'admin_page'));
	}
	
	/************************************************************************
	 * Print admin page
	 ************************************************************************/
	public function admin_page()
	{
		$title = __('Frontend Utilities for Asgaros Forum', 'qnso-af-ps');
		
		// Print side header
		echo '<div id="quenso-wrap">';
			echo '<div class="header-left">';
				echo '<div class="title"><img src="'. plugin_dir_url(__DIR__) . 'assets/img/logo.png"></div>';
			echo '</div>';
			echo '<div class="header-left">';
				echo '<h1>'. $title .'</h1>';
			echo '</div>';
			echo '<div class="header-right">';
				echo '<a href="https://www.quenso.de/support/" target="_blank">';
					echo '<span class="link">'. __('Get support', 'qnso-af-ps') .'</span>';
				echo '</a>';
				echo '&bull;';
				echo '<a href="https://www.quenso.de/donate/" target="_blank">';
					echo '<span class="link">'. __('Donate', 'qnso-af-ps') .'</span>';
				echo '</a>';
			echo '</div>';
		echo '</div>';
		
		$options = array(
			'edit_profile',
			'login',
			'register',
			'confirm_registration',
			'reset_password',
			'custom_avatars',
		);
		
		$update_message = '';
		
		if ( isset( $_POST['submit'])) {
			$update_message = __( 'Updated successfully.', 'af-front-utils' );
							
			foreach ($options as $option) {
				if (isset($_POST[$option])) {
					AFFrontUtils::set_option($option, 1);
				} else {
					AFFrontUtils::set_option($option, 0);
				}
			}
		}
		
		$url = esc_url( add_query_arg( array( 'page' => 'asgarosforum-frontend-utilities' ), admin_url( 'admin.php' ) ) );
		$button_text = __( 'Save Settings', 'af-front-utils' );
		
		$edit_profile = AFFrontUtils::get_option('edit_profile', 1);
		$login = AFFrontUtils::get_option('login', 1);
		$register = AFFrontUtils::get_option('register', 1);
		$confirm_registration = AFFrontUtils::get_option('confirm_registration', 0);
		$reset_password = AFFrontUtils::get_option('reset_password', 1);
		$custom_avatars = AFFrontUtils::get_option('custom_avatars', 1);
		
		echo '<div id="quenso-options-wrap">';
			echo '<form action="'. $url .'" method="POST">';
				wp_nonce_field(AFFrontUtils::OPTION_KEY);
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="edit_profile">'. esc_html__('Frontend Profile Editing', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="edit_profile" class="edit_profile" type="checkbox" value="yes" name="edit_profile"';
							if (1 === $edit_profile) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('This will add an AJAX overlay to edit profile in frontend user profiles while clicking on "edit profile" link.', 'af-front-utils');
					echo '</div>';
				echo '</div>';
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="login">'. esc_html__('Frontend Login', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="login" class="login" type="checkbox" value="yes" name="login"';
							if (1 === $login) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('This will add an AJAX popup to login while clicking on "login" link in Asgaros Forum.', 'af-front-utils');
					echo '</div>';
				echo '</div>';
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="reset_password">'. esc_html__('Frontend Reset Password', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="reset_password" class="reset_password" type="checkbox" value="yes" name="reset_password"';
							if (1 === $reset_password) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('This will add an AJAX popup to reset password while clicking on "Forgot password" link in login popup. Needs Frontend Login to be enabled!', 'af-front-utils');
					echo '</div>';
				echo '</div>';
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="register">'. esc_html__('Frontend Register', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="register" class="register" type="checkbox" value="yes" name="register"';
							if (1 === $register) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('This will add an AJAX popup to register while clicking on "register" link in Asgaros Forum.', 'af-front-utils');
					echo '</div>';
				echo '</div>';
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="confirm_registration">'. esc_html__('Confirm Registrations', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="confirm_registration" class="confirm_registration" type="checkbox" value="yes" name="confirm_registration"';
							if (1 === $confirm_registration) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('Users need to confirm their registration via link in email.', 'af-front-utils');
					echo '</div>';
				echo '</div>';
				echo '<div class="quenso-options-row">';
					echo '<div class="quenso-options-column">';
						echo '<label for="custom_avatars">'. esc_html__('Custom Avatars', 'af-front-utils') .'</label>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						echo '<input id="custom_avatars" class="custom_avatars" type="checkbox" value="yes" name="custom_avatars"';
							if (1 === $custom_avatars) echo 'checked';
						echo '/>';
					echo '</div>';
					echo '<div class="quenso-options-column">';
						_e('This will add fully WordPress compatible custom avatars to your forum.', 'af-front-utils');
					echo '</div>';
				echo '</div>';
		echo '</div>';
		echo '<div id="quenso-options-submit">';
			submit_button($button_text);
			echo '<span class="success">'. $update_message .'</span>';
		echo '</div>';
			echo '</form>';
	}
}
AFFrontUtilsAdmin::get_instance();

//EOF