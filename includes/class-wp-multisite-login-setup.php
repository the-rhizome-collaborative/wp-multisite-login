<?php

class WP_Multisite_Login_Setup {

    public function __construct() {
		add_action('init', array($this, 'multisite_login'));
		add_action('wp_logout', array($this,  'multisite_logout'));
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

		// Ensure this is applied only when a user is logged in.
		if (is_user_logged_in()) {
			$user = wp_get_current_user();
			if ($user) {
				// Set cookies for both domains
				$cookie_domains = $this->get_multisites();

				foreach ($cookie_domains as $domain) {
					setcookie(
						LOGGED_IN_COOKIE,
						$_COOKIE[LOGGED_IN_COOKIE],
						time() + (2 * DAY_IN_SECONDS),
						COOKIEPATH,
						'.' . $domain,
						is_ssl(),
						true
					);
				}
			}
		}

	}

	/**
	 * Logout user from all multisites
	 */
	public function multisite_logout() {
		$cookie_domains = $this->get_multisites();
		foreach ($cookie_domains as $domain) {
			setcookie(
				LOGGED_IN_COOKIE,
				'',
				time() - 3600, // Expire the cookie
				COOKIEPATH,
				'.' . $domain,
				is_ssl(),
				true
			);
		}
	}
    
}