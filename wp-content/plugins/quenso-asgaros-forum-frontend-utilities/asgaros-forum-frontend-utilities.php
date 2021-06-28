<?php
/*
 * Plugin Name: Frontend Utilities for Asgaros Forum
 * Plugin URI: https://www.asgaros.de
 * Description: Extends the frontend functionality of Asgaros Forum.
 * Author: Quenso
 * Author URI: https://quenso.de
 * Version: 1.1.1
 * Copyright: (c) 2020 Marcel Hellmund, All Rights Reserved.
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: af-front-utils
 * Domain Path: /language
 *
 * We are Open Source. You can redistribute and/or modify this software under the terms of the GNU General Public License (version 2 or later)
 * as published by the Free Software Foundation. See the GNU General Public License or the LICENSE file for more details.
 * This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
 */
if (!defined('ABSPATH')) exit;

class AFFrontUtils
{
	private static $_instance = NULL;
	private static $_template_dir = 'templates';
	
	private static $asgarosforum;
	
	// Define plugin data
	const PLUGIN_NAME				= 'Frontend Utilities for Asgaros Forum';
	const PLUGIN_VERSION			= '1.1.1';
	const PLUGIN_RELEASE			= ''; //ALPHA1, BETA1, RC1, '' for STABLE
	const PLUGIN_FILE				= __FILE__;
	const OPTION_KEY				= 'af_front_utils_config';

    private function __construct()
	{
		// Call AsgarosForum class
		global $asgarosforum;
		self::$asgarosforum = $asgarosforum;
		
		// Admin
        if (is_admin()) {
            add_action('admin_init', array(&$this, 'ready'));
        } else {
			// Enqueue scripts
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
			add_action('wp_footer', array(&$this, 'enqueue_scripts_data'), 1);
        }
		
		// Load textdomain
		add_action('plugins_loaded', array(&$this, 'load_textdomain'));
		// Custom avatar
		if (1 == AFFrontUtils::get_option('custom_avatars', 1)) {
			add_filter('get_avatar', array($this, 'filter_avatar'), 10, 5);
			add_filter('get_avatar_url', array($this,'filter_avatar_url'), 10, 3);
		}
		// Ajax forms - login - register - lost password - confirm registration
		add_action('asgarosforum_content_header', array(&$this, 'ajax_forms'), 10, 0);
		add_action('wp_ajax_affu_process_ajax_login', array(&$this, 'process_ajax_login'));
		add_action('wp_ajax_nopriv_affu_process_ajax_login', array(&$this, 'process_ajax_login'));
		add_action('wp_ajax_affu_process_ajax_register', array(&$this, 'process_ajax_register'));
		add_action('wp_ajax_nopriv_affu_process_ajax_register', array(&$this, 'process_ajax_register'));
		add_action('wp_ajax_affu_process_ajax_reset_password', array(&$this, 'process_ajax_reset_password'));
		add_action('wp_ajax_nopriv_affu_process_ajax_reset_password', array(&$this, 'process_ajax_reset_password'));
		add_action('wp_ajax_affu_process_ajax_resend_confirmation', array(&$this, 'process_ajax_resend_confirmation'));
		add_action('wp_ajax_nopriv_affu_process_ajax_resend_confirmation', array(&$this, 'process_ajax_resend_confirmation'));
		// Confirm registration
		add_action('init', array(&$this, 'process_confirm_registration'));
		add_action('init', array(&$this, 'check_confirmation_status'));
		add_action('manage_users_custom_column', array(&$this, 'confirmation_users_columns'), 10, 3);
		add_filter('manage_users_columns', function ($columns) {
			if (1 == AFFrontUtils::get_option('confirm_registration', 0)) { 
				$columns['affu_confirm_status'] = __('Account Status', 'af-front-utils');
				$columns['affu_confirm_manually'] = __('Confirm Manually', 'af-front-utils');
				$columns['affu_confirm_email'] = __('Confirmation Email', 'af-front-utils');
			}
			return $columns;
		});
		add_filter( 'wp_authenticate_user', function ($user) {
			if (!is_wp_error($user)) {
				$confirmed = get_user_meta($user->ID, 'affu_confirm_registration', true);
				if (1 == $confirmed) {
					$error = __('Please confirm your account!', 'af-front-utils');
					
					return new WP_Error('affu_confirm_registration', $error);
				}
			}
			return $user;
		});
		
		// Autoload classes
		$classes_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
		foreach (new DirectoryIterator(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes') as $file) {
			if ($file->isDot()) continue;
                
			require_once($classes_path . $file->getFilename());
		}
	}
	
	/************************************************************************
	 * Check for ready status
	 ************************************************************************/
    public static function ready()
	{
		if (!class_exists('AsgarosForum')){
			add_action('admin_notices', function(){
                ?>
                <div class="error peepso">
                    <strong>
                        <?php echo sprintf(__('The %s plugin requires Asgaros Forum to be installed and activated.', 'af-front-utils'), self::PLUGIN_NAME);?>
                    </strong>
                </div>
                <?php
            });

			unset($_GET['activate']);
			deactivate_plugins(plugin_basename(__FILE__));
			return (FALSE);
		}
		
		return (TRUE);
    }

	/************************************************************************
	 * Return singleton instance
	 ************************************************************************/
	public static function get_instance()
	{
		if (NULL === self::$_instance) {
			self::$_instance = new self();
		}
		return (self::$_instance);
	}
	
	/************************************************************************
	 * Enqueue assets
	 ************************************************************************/
	public function enqueue_scripts()
	{
		wp_enqueue_style('af-front-utils', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), self::PLUGIN_VERSION);
		
		wp_enqueue_script('af-front-utils', plugin_dir_url(__FILE__) . 'assets/js/ajax.js', array('jquery'), self::PLUGIN_VERSION, TRUE);
		
		// Get Asgaros Forum CSS
		wp_enqueue_style('af-front-utils-af-css', self::$asgarosforum->plugin_url . 'skin/style.css', array(), self::PLUGIN_VERSION);
		
		// Get Asgaros Forum custom CSS
		$custom_css_file = self::$asgarosforum->plugin_path.'skin/custom.css';
		if (file_exists($custom_css_file)) {
			wp_enqueue_style('af-front-utils-af-custom-css', self::$asgarosforum->appearance->get_current_theme_url().'/custom.css', array(), self::PLUGIN_VERSION);
		}
    }
	
	/************************************************************************
	 * Enqueue scripts data
	 ************************************************************************/
	 public function enqueue_scripts_data()
    {
		wp_localize_script('af-front-utils', 'affu_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'edit_profile_option' => AFFrontUtils::get_option('edit_profile', 1),
			'login_option' => AFFrontUtils::get_option('login', 1),
			'reset_password_option' => AFFrontUtils::get_option('reset_password', 1),
			'register_option' => AFFrontUtils::get_option('register', 1),
			'confirm_registration_option' => AFFrontUtils::get_option('confirm_registration', 0),
			'confirm_registration_redirect' => home_url()
		));
	}
	
	/************************************************************************
	 * Load Translations
	 ************************************************************************/
	public function load_textdomain()
    {
        $path = str_ireplace(WP_PLUGIN_DIR, '', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR;
        load_plugin_textdomain('af-front-utils', FALSE, $path);
    }
	
	/************************************************************************
	 * Get option by $name
	 ************************************************************************/
	public static function get_option($name, $default = NULL)
	{
		$options = get_option(self::OPTION_KEY);
		$value = (isset($options[$name]) ? $options[$name] : $default);
		return $value;
	}
	
	/************************************************************************
	 * Update $value for $option
	 ************************************************************************/
	public static function set_option($option, $value, $overwrite = TRUE)
	{		
		$options = get_option(self::OPTION_KEY);
		if (empty($options)) {
			$options = array();
		}
		if((!isset($options[$option])) || (isset($options[$option]) && TRUE == $overwrite)) {
			$sanitized_value = sanitize_key($value);
			
			if (is_numeric($sanitized_value)) {
				$options[$option] = (int) $sanitized_value;
			} else {
				$options[$option] = $sanitized_value;
			}
		}
		update_option(self::OPTION_KEY, $options);
	}
	/************************************************************************
	 * Execute template by $name, extract $data and $return_output
	 ************************************************************************/
	public static function exec_template($name, $data = NULL, $return_output = FALSE)
	{
		$template = locate_template('af-front-utils' . DIRECTORY_SEPARATOR . $name . '.php');
		if (empty($template)) {
			if (file_exists($file = plugin_dir_path(__FILE__) . self::$_template_dir . DIRECTORY_SEPARATOR . $name . '.php')) {
				$template = $file;
			}
		}
		
		if ($return_output) {
			ob_start();
		}
		
		if (NULL !== $data) {
			extract($data);
		}
		include($template);

		if ($return_output) {
			$display = ob_get_clean();
			return ($display);
		}
	}
	
	/************************************************************************
	 * Include AJAX forms
	 ************************************************************************/
	public function ajax_forms()
	{
		$process_messages = '';
		if (isset($_POST['affu_profile_editor_submit'])) {
			$process_messages = self::process_edit_profile($_POST, $_FILES);
			
			if (is_array($process_messages)) {
				foreach ($process_messages as $error){
					?><div class="error-message"><p><?php echo $error; ?></p></div><?php
				}
			} else {
				?><div class="success-message"><p><?php echo $process_messages; ?></p></div><?php
			}
		}
		
		global $current_user, $wp;
		
		$data = array(
			'asgarosforum'		=>	self::$asgarosforum,
			'user_id'			=>	$user_id      = get_current_user_id(),
			'userData'			=>	$userData	  = self::$asgarosforum->profile->get_user_data($user_id),
			'first_name'		=>	$first_name   = get_user_meta($user_id, 'first_name', true),
			'last_name'			=>	$last_name    = get_user_meta($user_id, 'last_name', true),
			'biography'			=>	$biography    = get_user_meta($user_id, 'description', true),
			'signature'			=>	$signature    = get_user_meta($user_id, 'asgarosforum_signature', true),
			'nickname'			=>	$nickname     = get_user_meta($user_id, 'nickname', true),
			'display_name'		=>	$display_name = $current_user->display_name,
			'process_messages'	=>	$process_messages,
			'current_user'		=>	$current_user,
			'wp'				=>	$wp
			);
		
		if (!is_user_logged_in()) {
			if (1 == AFFrontUtils::get_option('login', 1)) {
				self::exec_template('login', $data);
				if (1 == AFFrontUtils::get_option('reset_password', 1)) {
					self::exec_template('reset-password', $data);
				}
			}
			
			if (1 == AFFrontUtils::get_option('register', 1)) {
				self::exec_template('register', $data);
			}
		}
		
		$profile_user_id = self::$asgarosforum->current_element;
		
		if ($profile_user_id == get_current_user_id() && 1 == AFFrontUtils::get_option('edit_profile', 1)) {
			self::exec_template('edit-profile', $data);
		}
		
	}
	
	/************************************************************************
	 * Process profile editing data
	 ************************************************************************/
	public function process_edit_profile ($data, $files)
	{
		if (empty($_POST['affu_profile_editor_submit']) && !is_user_logged_in()) {
			return false;
		}

		// Nonce security
		if (!wp_verify_nonce($data['affu_profile_editor_nonce'], 'affu-profile-editor-nonce')) {
			return false;
		}

		$user_id = get_current_user_id();
		$old_user_data = get_userdata($user_id);

		$first_name   = isset($data['affu_first_name'])		? sanitize_text_field($data['affu_first_name'])			: $old_user_data->first_name;
		$last_name    = isset($data['affu_last_name'])		? sanitize_text_field($data['affu_last_name'])			: $old_user_data->last_name;
		$website      = isset($data['affu_website'])		? esc_url_raw($data['affu_website'])					: $old_user_data->user_url;
		$display_name = isset($data['affu_display_name'])	? sanitize_text_field($data['affu_display_name'])		: $old_user_data->display_name;
		$biography	  = isset($data['affu_biography'])		? sanitize_textarea_field($data['affu_biography'])		: '';
		$signature	  = isset($data['affu_signature'])		? $data['affu_signature']								: '';
		$nickname 	  = isset($data['affu_nickname'])		? sanitize_text_field($data['affu_nickname'])			: '';
		$email        = isset($data['affu_email'])			? sanitize_email($data['affu_email'])					: $old_user_data->user_email;

		$userdata = array(
			'ID'           => $user_id,
			'first_name'   => $first_name,
			'last_name'    => $last_name,
			'user_url'	   => $website,
			'display_name' => $display_name,
			'user_email'   => $email
		);
		
		if (class_exists('Easy_Digital_Downloads')) {
			$line1        = isset($data['affu_address_line1'])	? sanitize_text_field($data['affu_address_line1'])		: '';
			$line2        = isset($data['affu_address_line2'])	? sanitize_text_field($data['affu_address_line2'])		: '';
			$city         = isset($data['affu_address_city'])	? sanitize_text_field($data['affu_address_city'])		: '';
			$state        = isset($data['edd_address_state'])	? sanitize_text_field($data['edd_address_state'])		: '';
			$zip          = isset($data['affu_address_zip'])	? sanitize_text_field($data['affu_address_zip'])		: '';
			$country      = isset($data['edd_address_country'])	? sanitize_text_field($data['edd_address_country'])		: '';
			
			$address = array(
				'line1'    => $line1,
				'line2'    => $line2,
				'city'     => $city,
				'state'    => $state,
				'zip'      => $zip,
				'country'  => $country
			);
		}
		
		$error = array();
		
		// Validate password strength
		$pw_uppercase 	 = preg_match('@[A-Z]@', $data['affu_new_user_pass1']);
		$pw_lowercase    = preg_match('@[a-z]@', $data['affu_new_user_pass1']);
		$pw_number   	 = preg_match('@[0-9]@', $data['affu_new_user_pass1']);
		$pw_specialChars = preg_match('@[^\w]@', $data['affu_new_user_pass1']);
		
		// New password
		if (!empty($data['affu_new_user_pass1'])) {
			if ($data['affu_new_user_pass1'] !== $data['affu_new_user_pass2']) {
				$error['password_mismatch'] = esc_html__('The passwords you entered do not match. Please try again.', 'af-front-utils');
			} elseif (!$pw_uppercase || !$pw_lowercase || !$pw_number || !$pw_specialChars || strlen($data['affu_new_user_pass1']) < 8) {
				$error['password_strength'] = esc_html__('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.', 'af-front-utils');
			}else {
				wp_set_password($data['affu_new_user_pass1'], $user_id);
			}
		}

		// Change email
		if($email != $old_user_data->user_email) {
			// Make sure the new email is valid
			if(!is_email($email)) {
				$error['email_invalid'] = esc_html__('The email you entered is invalid. Please enter a valid email.', 'af-front-utils');
			}

			// Make sure the new email doesn't belong to another user
			if(email_exists($email)) {
				$error['email_exists'] = esc_html__('The email you entered belongs to another user. Please use another.', 'af-front-utils');
			}
		}
		
		// Process and change avatar
		if (!empty($files['affu_avatar']['type']) && self::$asgarosforum->options['enable_avatars']) {
			$new_filename = hash('md5', $files['affu_avatar']['name']);
			
			$upload_dir = WP_CONTENT_DIR . '/forum-avatars/' . $user_id .'/';
			$upload_file = $upload_dir . basename($files['affu_avatar']['name']);
			$upload_file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
			$avatar_dest = $upload_dir . $new_filename . '.' . $upload_file_type;
			$old_file = get_user_meta($user_id, 'asgarosforum_avatar_dest', true);
			
			if ($upload_file_type != 'jpg' && $upload_file_type != 'jpeg' && $upload_file_type != 'png' && $upload_file_type != 'gif') {
				$error['avatar_upload_failed'] = esc_html__('There was a problem uploading your new avatar. Please try again.', 'af-front-utils');
			} else {			
				if (!is_dir($upload_dir)) {
					wp_mkdir_p($upload_dir);
				}
				
				if (file_exists($avatar_dest)) {
					wp_delete_file($avatar_dest);
				}
				
				if (move_uploaded_file($files['affu_avatar']['tmp_name'], $upload_file)) {
					
					$max_width = 160;
					$max_height = 160;
					$imgsize = getimagesize($upload_file);
					$width = $imgsize[0];
					$height = $imgsize[1];
					$mime = $imgsize['mime'];
				 
					switch($mime){
						case 'image/gif':
							$image_create = "imagecreatefromgif";
							$image = "imagegif";
							break;			 
						case 'image/png':
							$image_create = "imagecreatefrompng";
							$image = "imagepng";
							$quality = 7;
							break;			 
						case 'image/jpeg':
						case 'image/jpg':
							$image_create = "imagecreatefromjpeg";
							$image = "imagejpeg";
							$quality = 80;
							$exif = exif_read_data($upload_file);
							break;			 
						default:
							return false;
							break;
					}
					
					$dst_img = imagecreatetruecolor($max_width, $max_height);					
					$src_img = $image_create($upload_file);					
					$width_new = $height * $max_width / $max_height;
					$height_new = $width * $max_height / $max_width;
					
					// Crop image
					if($width_new > $width){
						$h_point = (($height - $height_new) / 2);
						imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
					}else{
						$w_point = (($width - $width_new) / 2);
						imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
					}
					
					// Fix rotated mobile image uploads
					if(isset($exif['Orientation'])) {
						$orientation = (int) $exif['Orientation'];					
					
						switch ($orientation) {
							case 3:
								$dst_img = imagerotate($dst_img, 180, 0);
								break;
							case 6:
								$dst_img = imagerotate($dst_img, 270, 0);
								break;
							case 8:
								$dst_img = imagerotate($dst_img, 90, 0);
								break;
						}
					}
					
					// Create final image and delete temporary files
					$image($dst_img, $avatar_dest, $quality);
					if($dst_img)imagedestroy($dst_img);
					if($src_img)imagedestroy($src_img);
				}
				
				// Update user_meta
				if (file_exists($avatar_dest)) {
					$meta_avatar = update_user_meta($user_id, 'asgarosforum_avatar', home_url() . '/wp-content/forum-avatars/' . $user_id . '/' . $new_filename . '.' . $upload_file_type);
					$meta_avatar_dest = update_user_meta($user_id, 'asgarosforum_avatar_dest', $avatar_dest);
				} 
				
				// Delete old files
				wp_delete_file($upload_file);
				wp_delete_file($old_file);
			}
		}
		
		if (!empty(array_filter($error))) {
			return $error;
		} else {
			// Update the user
			if (self::$asgarosforum->options['enable_mentioning']) {
				if (isset($data['affu_mention'])) {
					$meta_mention = update_user_meta($user_id, 'asgarosforum_mention_notify', 'yes');
				} else {
					$meta_mention = update_user_meta($user_id, 'asgarosforum_mention_notify', 'no');
				}
			}
			if (self::$asgarosforum->options['allow_signatures'] && self::$asgarosforum->permissions->can_use_signature($user_id)) {
				if (self::$asgarosforum->options['signatures_html_allowed']) {
					$meta_signature = update_user_meta($user_id, 'asgarosforum_signature', trim(wp_kses_post(strip_tags($signature, self::$asgarosforum->options['signatures_html_tags']))));
				} else {
					$meta_signature = update_user_meta($user_id, 'asgarosforum_signature', trim(wp_kses_post(strip_tags($signature))));
				}
			}		
			$meta_biography = update_user_meta($user_id, 'description', $biography);
			$meta_nickname  = update_user_meta($user_id, 'nickname', $nickname);
			if (class_exists('Easy_Digital_Downloads')) {
				$meta_adress    = update_user_meta($user_id, '_edd_user_address', $address);
			}
			$updated        = wp_update_user($userdata);
			
			$success = esc_html__('Successfully updated.', 'af-front-utils');
			return $success;
		}
	}
	
	/************************************************************************
	 * Process ajax login
	 ************************************************************************/
	public function process_ajax_login ()
	{
		if (check_ajax_referer('affu_ajax_login_nonce', 'affu_nonce')) {
			$continue = TRUE;
		} else {
			$error = esc_html__('Something went wrong. Please try again.', 'af-front-utils');
			wp_send_json_error($error);
		}
		
		$login   	= isset($_POST['affu_login'])		? sanitize_text_field(strip_tags($_POST['affu_login']))		: FALSE;
		$user_pass 	= isset($_POST['affu_password']) 	? $_POST['affu_password']	 								: FALSE;
		$remember	= isset($_POST['affu_remember'])	? TRUE														: FALSE;
		$redirect 	= isset($_POST['affu_redirect'])	? esc_url_raw($_POST['affu_redirect'])						: home_url();

		if (is_email($login)) {
			// Get the user by email
			$user_data = get_user_by('email', $login);
		} else {
			// Get the user by login
			$user_data = get_user_by('login', $login);
		}
		
		if ($user_data) {
			// Check user_pass
			if ($user_pass) {
				// Check if password is valid
				if (!wp_check_password($user_pass, $user_data->user_pass, $user_data->ID)) {
					$continue = FALSE;
				} else {
					$valid_user_data = array(
						'user_id' => $user_data->ID,
						'user_login' => $user_data->user_login,
						'user_email' => $user_data->user_email,
						'user_first' => $user_data->first_name,
						'user_last' => $user_data->last_name,
						'user_pass' => $user_pass,
					);
				}
			} else {
				$continue = FALSE;
			}
		} else {
			$continue = FALSE;
		}
		
		$confirmed = get_user_meta($valid_user_data['user_id'], 'affu_confirm_registration', true);
		
		if (1 == $confirmed) {
			$nonce = wp_create_nonce('affu_ajax_resend_confirmation_nonce');
			$error = sprintf('%s<br/><a id="affu-resend-confirmation" class="affu-resend-confirmation" affu_uid="%s" affu_nonce="%s">%s</a>', esc_html__('Please confirm your account!', 'af-front-utils'), $valid_user_data['user_id'], $nonce, esc_html__('Resend confirmation email', 'af-front-utils'));
			wp_send_json_error($error);
		} elseif (TRUE == $continue) {
			wp_set_auth_cookie($valid_user_data['user_id'], $remember);
			wp_set_current_user($valid_user_data['user_id'], $valid_user_data['user_login']);
			do_action('wp_login', $valid_user_data['user_login'], get_userdata($valid_user_data['user_id']));
			
			wp_send_json_success($redirect);
		} else {
			$error = esc_html__('Wrong username or password!', 'af-front-utils');
			wp_send_json_error($error);
		}
	}
	
	/************************************************************************
	 * Process ajax register
	 ************************************************************************/
	public function process_ajax_register ()
	{
		
		if (check_ajax_referer('affu_ajax_register_nonce', 'affu_nonce')) {
			$continue = TRUE;
		} else {
			$error = esc_html__('Something went wrong. Please try again.', 'af-front-utils');
			wp_send_json_error($error);
		}
		
		if(is_user_logged_in()) {
			return;
		}
		
		$username 	= isset($_POST['affu_username'])		? sanitize_user($_POST['affu_username'])		: '';
		$email		= isset($_POST['affu_email'])			? sanitize_email($_POST['affu_email'])			: '';
		$password 	= isset($_POST['affu_password'])		? $_POST['affu_password']						: '';
		$password2	= isset($_POST['affu_password2'])		? $_POST['affu_password2']						: '';
		$redirect 	= isset($_POST['affu_redirect'])		? esc_url_raw($_POST['affu_redirect'])			: home_url();
		
		// Validate password strength
		$pw_uppercase 	 = preg_match('@[A-Z]@', $password);
		$pw_lowercase    = preg_match('@[a-z]@', $password);
		$pw_number   	 = preg_match('@[0-9]@', $password);
		$pw_specialChars = preg_match('@[^\w]@', $password);		
		
		if (empty($username)) {
			$error = esc_html__('Invalid username', 'af-front-utils');
			$continue = FALSE;
		} elseif (username_exists($username)) {
			$error = esc_html__('Username already taken', 'af-front-utils');
			$continue = FALSE;
		} elseif (!validate_username($username)) {
			$error = esc_html__('Invalid username', 'af-front-utils');
			$continue = FALSE;
		} elseif (email_exists($email)) {
			$error = esc_html__('Email address already taken', 'af-front-utils');
			$continue = FALSE;
		} elseif (empty($email) || !is_email($email)) {
			$error = esc_html__('Invalid email', 'af-front-utils');
			$continue = FALSE;
		} elseif (empty($password)) {
			$error = esc_html__('Please enter a password', 'af-front-utils');
			$continue = FALSE;
		} elseif (!$pw_uppercase || !$pw_lowercase || !$pw_number || !$pw_specialChars || strlen($password) < 8) {
			$error = esc_html__('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.', 'af-front-utils');
			$continue = FALSE;
		} elseif ((!empty($password) && empty($password2)) || ($password !== $password2)) {
			$error = esc_html__('Passwords do not match', 'af-front-utils');
			$continue = FALSE;
		} else {
			$continue = TRUE;
		}
		
		if (TRUE == $continue) {
			$args = array(
				'user_login'      => $username,
				'user_pass'       => $password,
				'user_email'      => $email,
				'user_registered' => date('Y-m-d H:i:s'),
				'role'            => get_option('default_role')
			);
			
			$user_id = wp_insert_user($args);
			
			if (is_wp_error($user_id)) {
				$error = esc_html__('Something went wrong. Please try again.', 'af-front-utils');
				wp_send_json_error($error);
			} elseif (1 == AFFrontUtils::get_option('confirm_registration', 0)) {
				do_action('affu_register_after', $args['user_login'], get_userdata($user_id));
				
				$mail = self::confirm_registration_email(get_userdata($user_id));
				
				add_user_meta($user_id, 'affu_confirm_registration', 1);
				
				if ($mail) {				
					$confirm_message = esc_html__('Registration successfully! We have sent an confirmation link to your email, please check your inbox.', 'af-front-utils');
					wp_send_json_success($confirm_message);
				} else {
					$error = esc_html__('Something went wrong. Please try again.', 'af-front-utils');
					wp_send_json_error($error);
				}
			} else {
				wp_set_current_user($user_id, $args['user_login']);
				wp_set_auth_cookie($user_id, TRUE);
				do_action('affu_register_after', $args['user_login'], get_userdata($user_id));
				do_action('wp_login', $args['user_login'], get_userdata($user_id));
				
				wp_send_json_success($redirect);
			}
		} else {
			wp_send_json_error($error);
		}
	}
	
	/************************************************************************
	 * Add content for confirmation to columns in users list
	 ************************************************************************/
	public function confirmation_users_columns ($value, $column_name, $user_id)
	{
		if (1 == AFFrontUtils::get_option('confirm_registration', 0)) {
			$confirmed = get_user_meta($user_id, 'affu_confirm_registration', true);
			
			// Confirmation status
			if ('affu_confirm_status' == $column_name) {
				if (user_can( $user_id, 'manage_options' )) {
					$status = __('Admin', 'af-front-utils');
				} elseif (!$confirmed) {
					$status = __('Confirmed', 'af-front-utils');
				} else {
					$status = __('Unconfirmed', 'af-front-utils');
				}
				return $status; 
			}
			
			// Confirm Manually
			if ('affu_confirm_manually' == $column_name) {
				if (user_can( $user_id, 'manage_options' )) {
					return;
				} elseif (isset($_GET['affu_confirm_manually']) && $_GET['affu_confirm_manually'] == $user_id) {
					$confirm = delete_user_meta((int) $_GET['affu_confirm_manually'], 'affu_confirm_registration');

					if ($confirm) {
						return esc_html__('Done!', 'af-front-utils');
					} else {
						return esc_html__('Error!', 'af-front-utils');
					}
				} elseif (isset($_GET['affu_revoke_confirmation']) && $_GET['affu_revoke_confirmation'] == $user_id) {
					$confirm = add_user_meta((int) $_GET['affu_revoke_confirmation'], 'affu_confirm_registration', 1);

					if ($confirm) {
						return esc_html__('Done!', 'af-front-utils');
					} else {
						return esc_html__('Error!', 'af-front-utils');
					}
				} elseif (!$confirmed) {
					$link = sprintf('<a href="?affu_revoke_confirmation=' . $user_id .'">%s</a>', esc_html__('Revoke', 'af-front-utils'));
					return $link;
				} else {
					$link = sprintf('<a href="?affu_confirm_manually=' . $user_id .'">%s</a>', esc_html__('Confirm', 'af-front-utils'));
					return $link;
				}
			}
			
			// Send confirmation email
			if ('affu_confirm_email' == $column_name) {
				if (isset($_GET['affu_confirm_email']) && $_GET['affu_confirm_email'] == $user_id) {
					$mail = self::confirm_registration_email(get_userdata((int) $_GET['affu_confirm_email']));
					
					if ($mail) {
						return esc_html__('Done!', 'af-front-utils');
					} else {
						return esc_html__('Error!', 'af-front-utils');
					}
				} elseif (!$confirmed) {
					return;
				} else {
					$link = sprintf('<a href="?affu_confirm_email=' . $user_id .'">%s</a>', esc_html__('Send mail', 'af-front-utils'));
					return $link;
				}
			}
		}
		
		return $value;
	}
	
	/************************************************************************
	 * Process ajax resend confirmation
	 ************************************************************************/
	public function process_ajax_resend_confirmation ()
	{
		$error = esc_html__('Something went wrong!', 'af-front-utils');
		
		if (check_ajax_referer('affu_ajax_resend_confirmation_nonce', 'affu_nonce')) {
			$user_id = isset($_POST['affu_uid']) ? (int) $_POST['affu_uid']		: 0;
			
			$mail = self::confirm_registration_email(get_userdata($user_id));
			if ($mail) {
				$success = esc_html__('Done! Please check your inbox.', 'af-front-utils');
				wp_send_json_success($success);
			} else {
				wp_send_json_error($error);
			}
		} else {
			wp_send_json_error($error);
		}
	}
	
	/************************************************************************
	 * Send confirm registration email
	 ************************************************************************/
	public function confirm_registration_email ($user_data)
	{
		$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		
		$user_login 	= $user_data->user_login;
		$user_email	 	= $user_data->user_email;
		$user_id		= $user_data->ID;
		
		$trans = get_transient('confirm_registration_url_' . $user_id);
		
		if (!$trans) {
			$token = wp_create_nonce('confirm_registration_' . $user_id);
			$url = get_site_url() . "/?action=confirm_registration&uid=$user_id&token=$token";
			
			set_transient('confirm_registration_url_' . $user_id, $url, 24 * HOUR_IN_SECONDS);
		} else {
			$url = $trans;
		}

		$to = $user_email;
		$subject = sprintf(esc_html__('[%s] Confirm Registration', 'af-front-utils'), $site_name);
		$sender = get_bloginfo('name');
		
		$message  = esc_html__('Someone registered an account with your email adress.', 'af-front-utils') . "<br/>";
		$message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.', 'af-front-utils') . "<br/><br/>";
		$message .= esc_html__('After confirmation you can login using the following data:', 'af-front-utils') . "<br/><br/>";
		$message .= sprintf(esc_html__('Username: %s'), $user_login) . "<br/>";
		$message .= esc_html__('Password: Your chosen password', 'af-front-utils') . "<br/><br/>";
		$message .= esc_html__('To confirm the registration, visit the following address:', 'af-front-utils') . "<br/>";
		$message .= $url;
		
		$headers[] = 'MIME-Version: 1.0' . "\r\n";
		$headers[] = 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers[] = "X-Mailer: PHP \r\n";
		$headers[] = 'From: '.$sender.' <'.$user_email.'>' . "\r\n";
		
		$confirmed = get_user_meta($user_id, 'affu_confirm_registration', true);
		
		$mail = wp_mail($to, $subject, $message, $headers);
		
		return $mail;
	}
		
	/************************************************************************
	 * Process confirm registration
	 ************************************************************************/
	public function process_confirm_registration ()
	{
		if(isset($_GET['action']) && $_GET['action'] == 'confirm_registration') {
			$user_id 	= isset($_GET['uid']) 		? (int) $_GET['uid'] 		: 0;
			$token 		= isset($_REQUEST['token'])	? sanitize_key($_REQUEST['token'])	: '';
			
			$confirmed = get_user_meta($user_id, 'affu_confirm_registration', true);
			
			$redirect = remove_query_arg(array('action', 'uid', 'token'));
			
			if (0 == $user_id || !$confirmed || !wp_verify_nonce($token , 'confirm_registration_' . $user_id)) {
				wp_redirect($redirect);
				exit;
			} else {
				delete_user_meta($user_id, 'affu_confirm_registration');
				
				$user = get_user_by('id', $user_id);
				
				wp_set_current_user($user_id, $user->user_login);
				wp_set_auth_cookie($user_id, TRUE);
				wp_redirect($redirect) ;
				exit;
			}
		}
	}
	
	/************************************************************************
	 * Check current users confirmation status
	 ************************************************************************/
	public function check_confirmation_status ()
	{
		$user_id = get_current_user_id();
		$confirmed = get_user_meta($user_id, 'affu_confirm_registration', true);
		
		if ($confirmed) {
			wp_logout();
		}
	}
	
	/************************************************************************
	 * Process ajax lost password
	 ************************************************************************/
	public function process_ajax_reset_password ()
	{
		check_ajax_referer('affu_ajax_reset_password_nonce', 'affu_nonce');
		
		$login     = isset($_POST['affu_login'])	? $_POST['affu_login']	: '';
		
		if (empty($login)) {
			$error = esc_html__('Enter a username or e-mail address.', 'af-front-utils');
			$continue = FALSE;		
		} elseif (is_email($_POST['affu_login'])) {
			$sanitized_login = sanitize_email($_POST['affu_login']);
			// Get the user by email
			$user_data = get_user_by('email', $sanitized_login);
		} else {
			$sanitized_login = sanitize_user($_POST['affu_login']);
			// Get the user by login
			$user_data = get_user_by('login', $sanitized_login);
		}

		$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		if (!$user_data) {
			$error = esc_html__('Invalid username or e-mail address.', 'af-front-utils');
			$continue = FALSE;
		} else {

			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;
			$key        = get_password_reset_key($user_data);

			$to = $user_email;
			$subject = sprintf(esc_html__('[%s] Password Reset', 'af-front-utils'), $site_name);
			$sender = get_bloginfo('name');
			
			$message = esc_html__('Someone has requested a password reset for the following account:', 'af-front-utils') . "<br/><br/>";
			/* translators: %s: Site name. */
			$message .= sprintf(esc_html__('Site Name: %s'), $site_name) . "<br/>";
			/* translators: %s: User login. */
			$message .= sprintf(esc_html__('Username: %s'), $user_login) . "<br/><br/>";
			$message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.') . "<br/>";
			$message .= esc_html__('To reset your password, visit the following address:') . "<br/>";
			$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "<br/>";
			
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = 'From: '.$sender.' <'.$user_email.'>' . "\r\n";
			
			$continue = TRUE;
		}
		
		if (TRUE == $continue) {
			$mail = wp_mail($to, $subject, $message, $headers);
			$return = esc_html__( 'We have sent an confirmation link to your email, please check your inbox.', 'af-front-utils' );
			wp_send_json_success($return);
		} else {
			wp_send_json_error($error);
		}
	}
	
	/************************************************************************
	 * Custom avatar filter
	 ************************************************************************/
	public function filter_avatar($avatar, $id_or_email, $size, $default, $alt)
	{
		$user_id = null;
		if(is_object($id_or_email)) {
		   if(!empty($id_or_email->comment_author_email)) {
			  $user_id = $id_or_email->user_id;
			}

		}else{
		  if (is_email($id_or_email)) {
			$user = get_user_by('email', $id_or_email);
			if($user) {
			  $user_id = $user->ID;
			}
		  } else {
			$user_id = $id_or_email;
		  }
		}
		$custom_avatar = get_user_meta($user_id, 'asgarosforum_avatar', true);
		
		if($custom_avatar) {
			$avatar = "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
		return $avatar;
	}
	
	/************************************************************************
	 * Custom avatar url filter
	 ************************************************************************/
	public function filter_avatar_url ($url, $id_or_email, $args)
	{
		$user_id = null;
		if(is_object($id_or_email)) {
		   if(!empty($id_or_email->comment_author_email)) {
			  $user_id = $id_or_email->user_id;
			}

		}else{
		  if (is_email($id_or_email)) {
			$user = get_user_by('email', $id_or_email);
			if($user) {
			  $user_id = $user->ID;
			}
		  } else {
			$user_id = $id_or_email;
		  }
		}
		$custom_avatar = get_user_meta($user_id, 'asgarosforum_avatar', true);
		
		if($custom_avatar) {
			$url = $custom_avatar;
		}
		return $url;
	}
}
AFFrontUtils::get_instance();

// EOF