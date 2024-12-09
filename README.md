# WP Multisite Login

The **WP Multisite Login** plugin will keep users logged in across all sites in a network, provided they have an account on all sites in the network. This is only required if the sites are on different domains.

---

## Configuration
Add the following to the wp-config file for the primary site in the network.

```php
define('COOKIE_DOMAIN', '');
define('ADMIN_COOKIE_PATH', '/');
define('COOKIEPATH', '/');
define('SITECOOKIEPATH', '/');
````
---

## Installation

1. **Download the Plugin:**  
   Clone or download the plugin from the [GitHub repository](https://github.com/the-rhizome-collaborative/wp-multisite-login).

2. **Activate the Plugin:**  
   From the Network Admin dashboard, navigate to **Plugins**, and activate the plugin across the network.

---

## Troubleshooting
If this is installed after the sites have launched and users have logged in, you can reset the site salts to reset the cookies.
Get refreshed salts from the [Wordpress Key Generator](https://api.wordpress.org/secret-key/1.1/salt/).

