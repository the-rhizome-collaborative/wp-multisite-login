<?php

class WP_Multisite_Login_Setup {

    public function __construct() {
		add_action('init', array($this, 'multisite_login'));
		add_action('wp_logout', array($this, 'handle_cross_domain_logout'));
		//add_action('wp_footer', array($this, 'debug_auth_cookies')); // Debugging
    }


	/** Get all multisites in the network
	 * Can be filtered in the future to exclude certain sites
	 *
	 * @return array
	 */
	public function get_multisites() {
		// Get all sites in the network
		$sites = get_sites();
		$multisites = array();
		foreach ($sites as $site) {
			$multisites[] = $site->domain;
		}
		return apply_filters('shared_login_multisites', $multisites);
	}

	/**
	 * Set cookies for all multisites
	 */
	public function multisite_login() {

		// Get all domains in the network
		$sites = get_sites([
			'public'   => 1,
			'archived' => 0,
			'spam'     => 0,
			'deleted'  => 0,
		]);

		// Get the current user's login status
		$logged_in = is_user_logged_in();

		// Set cookies for all domains
		foreach ($sites as $site) {
			$domain = parse_url(get_site_url($site->blog_id), PHP_URL_HOST);

			// Skip if it's the current domain
			if ($domain === $_SERVER['HTTP_HOST']) {
				continue;
			}

			// Set authentication cookies for other domains
			if ($logged_in) {
				nocache_headers();
				wp_clear_auth_cookie($domain);
				wp_set_auth_cookie(get_current_user_id(), true, '', $domain);
			}
		}

	}



	/**
	 * Logout user from all multisites
	 */

	function handle_cross_domain_logout() {
		$sites = get_sites([
			'public'   => 1,
			'archived' => 0,
			'spam'     => 0,
			'deleted'  => 0,
		]);

		foreach ($sites as $site) {
			$domain = parse_url(get_site_url($site->blog_id), PHP_URL_HOST);
			wp_clear_auth_cookie($domain);
		}
	}

	function debug_auth_cookies() {


			print_r($_COOKIE);


	}
    
}