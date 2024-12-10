<?php
/**
 * Plugin Name:         WP Multisite Login
 * Plugin URI:          https://github.com/the-rhizome-collaborative/wp-multisite-login
 * GitHub Plugin URI:   the-rhizome-collaborative/wp-multisite-login
 * Description:         Allow users to login/out of all sites in a multisite network
 * Author:              The Rhizome Collaborative
 * Author URI:          rhizomecollaborative.com
 * Text Domain:         wp-multisite-login
 * Domain Path:         /languages
 * Version:             0.0.02
 *
 * @package         WP_Multisite_Content_Sharing
 */

require_once plugin_dir_path(__FILE__) . 'includes/class-wp-multisite-login-setup.php';

// Load plugin
add_action('plugins_loaded', function () {
	new WP_Multisite_Login_Setup();
});


