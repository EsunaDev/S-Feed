<?php
/*
Plugin Name: S-Feed
Plugin URI:  https://raindrop.agency/plugins/
Description: Fetches simple Instagram data using the Basic Display API.
Version:     1.0.1
Author:      Raindrop Agency
Author URI:  https://www.marcopelloni.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset
*/

if ( ! defined( 'ABSPATH' ) ) {
    die();
}

// Definitions
define('SFEED_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('SFEED_PLUGIN_URL', plugin_dir_url( __FILE__ ));

// Classes
require_once(SFEED_PLUGIN_PATH . 'src/php/admin.php');
require_once(SFEED_PLUGIN_PATH . 'src/php/functions.php');
require_once(SFEED_PLUGIN_PATH . 'src/php/users.php');

// Updates
require 'includes/plugin-update-checker-4.4/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://social-feed.tech/plugins/sfeed/update.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'sfeed'
);
?>
