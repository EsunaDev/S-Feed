<?php
/**
 * Creates an option page.
 */
function sfeed_custom_admin_menu() {
    add_menu_page('S-Feed', 'S-Feed', 'manage_options', 's-feed', 'sfeed_options_page', 'dashicons-camera', 58);
}
add_action( 'admin_menu', 'sfeed_custom_admin_menu' );

/**
 * Callback function for the options page.
 */
function sfeed_options_page() {
    require_once(SFEED_PLUGIN_PATH . 'src/templates/admin.php');
}
