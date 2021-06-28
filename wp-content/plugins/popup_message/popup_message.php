<?php
/**
 * Plugin Name: Popup Message
 * Plugin URI: ----
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: kalpana sharma
 * Author URI: -----
 */
 
 // Initialize the plugin and add the menu
add_action( 'admin_menu', 'pm_add_admin_menu' );
//add_action( 'admin_init', 'pm_settings_init' );

// Add an Admin Menu option for Settings
function pm_add_admin_menu( ) {
add_options_page( 'Popup Message', 'Popup Message',
'manage_options', 'popup_message', 'popup_message_options_page' );
}

