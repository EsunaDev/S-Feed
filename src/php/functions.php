<?php
/**
 * Retrieve the user's Instagram data with a S-Feed URL.
 *
 * @param [type] $endpoint
 * @return void
 */
function sfeed_get_instagram($endpoint) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $endpoint
    ]);
    
    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

/**
 * Retrieve all feeds gathered by the S-Feed plugin.
 *
 * @return void
 */
function sfeed_get_data() {
    $data = [];
    $users = sfeed_users_load();
    
    foreach ($users as $key => $user) {
        $feed = sfeed_get_instagram($user['url']);
        $data[] = $feed;
    }

    return $data;
}

/**
 * Retrieve a specific user's Instagram feed.
 *
 * @return void
 */
function sfeed_get_user($username) {
    $endpoint = sfeed_get_endpoint($username);
    
    if ($endpoint) {
        return sfeed_get_instagram($endpoint);
    }

    return false;
}

/**
 * Enqueuing styles and scripts.
 */
function sfeed_styles_and_scripts() {
    // Styles
    wp_register_style( 's-feed', SFEED_PLUGIN_URL . 'dist/s-feed.min.css', [], filemtime(SFEED_PLUGIN_PATH . 'dist/s-feed.min.css') );
    wp_enqueue_style( 's-feed' );
  
    // Scripts
    wp_register_script( 's-feed', SFEED_PLUGIN_URL . 'dist/s-feed.min.js', [], filemtime(SFEED_PLUGIN_PATH . 'dist/s-feed.min.js'), true );
    
    $localize_data = [
      'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
    ];
  
    wp_localize_script( 's-feed', 'sfeed', $localize_data);
    wp_enqueue_script( 's-feed' );
}
add_action( 'wp_enqueue_scripts', 'sfeed_styles_and_scripts' );
add_action( 'admin_enqueue_scripts', 'sfeed_styles_and_scripts' );

function sfeed_parse_url($endpoint) {
    $data = parse_url($endpoint);
    parse_str($data['query'], $query);
    return $query;
}

function sfeed_get_endpoint($username) {
    $users = sfeed_users_load();

    foreach ($users as $key => $user) {
        if (strpos($user['url'], $username) !== false) {
            return $user['url'];
        }
    }
}

function sfeed_shortcode($atts) {
    $endpoint = sfeed_get_endpoint($atts['user']);
    $feed = sfeed_get_instagram($endpoint);

    if ($atts['grid']) {
        $grid = $atts['grid'];
    } else {
        $grid = 3;
    }

    if ($atts['limit']) {
        $limit = $atts['limit'];
    } else {
        $limit = 3;
    }

    ob_start();
    if ($feed) {
        echo '<div class="sfeed-grid sfeed-grid-' . $grid . '">';
        foreach ($feed as $key => $value) {
            if ($key > $limit - 1) {
                continue;
            }

            echo '<div class="sfeed-aspect"><a href="' . $value['permalink'] .'"><img src="' . $value['image_url'] . '" /></a></div>';
        }
        echo '</div>';
    }
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
} 
add_shortcode('sfeed', 'sfeed_shortcode'); 
    