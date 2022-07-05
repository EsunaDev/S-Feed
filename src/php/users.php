<?php

/**
 * Load locations out of wp_options.
 *
 * @return array The Curbside location data.
 */
function sfeed_users_load() {
    $option = get_option('sfeed:users');

    if (!$option) {
        return false;
    }

    return json_decode($option, true);
}

function sfeed_users_save() {
    $post_data = json_decode( stripslashes( $_POST['data'] ), true );
    $option_name = 'sfeed:users';

    if ( get_option( $option_name ) !== false ) {
        update_option( $option_name, json_encode($post_data));
    } else {
        $deprecated = null;
        $autoload = 'no';
        add_option( $option_name, json_encode($post_data), $deprecated, $autoload);
    }

    echo 'S-Feed data saved.';
    wp_die();
}
add_action('wp_ajax_sfeed_users_save', 'sfeed_users_save'); // wp_ajax_{action}

function sfeed_user_delete($username) {
    
}