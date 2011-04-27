<?php

/*
Plugin Name: Socializr
Plugin URI: http://www.github.com/blat/wp-socializr-plugin/
Version: 1.0
Author: Mickael BLATIERE
Author URI: http://www.blizzart.net/
*/

require_once dirname(__FILE__) . '/common.php';


////////////////////////////////
// ADMIN

add_action('admin_menu', 'socializr_admin_menu');
function socializr_admin_menu() {
    add_options_page('Socializr Options', 'Socializr', 'manage_options', PLUGIN_ID, 'socializr_manage_options');
    add_menu_page('Socializr', 'Socializr', 'publish_posts', PLUGIN_ID . '-share', 'socializr_share');
}

function socializr_manage_options() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    include dirname(__FILE__) . '/options.php';
}

function socializr_share() {
    if (!current_user_can('publish_posts')) {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    include dirname(__FILE__) . '/share.php';
}


////////////////////////////////
// WIDGETS

add_action('widgets_init', 'socializr_widgets_init');

function socializr_widgets_init() {
    global $allowed_services;
    foreach ($allowed_services as $service) {
        require_once INC_DIR . '/' . $service . 'Widget.php';
        register_widget($service . 'Widget');
    }
}


////////////////////////////////
// BUTTONS

add_filter('the_content', 'socializr_the_content');

function socializr_the_content($content) {
    $result = $content;
    if (is_single()) {
        global $allowed_services;
        foreach ($allowed_services as $service) {
            $class = $service . 'Button';
            $button = new $class();
            $result = $button->getCode() . $result;
        }
    }
    return $result;
}


////////////////////////////////
// ACTIONS HOOKS

add_action('post_submitbox_start', 'socializr_submitbox');
add_action('save_post', 'socializr_save_post');
add_action('publish_post', 'socializr_publish_post');

function socializr_submitbox() {
    global $post;
    if ($post->post_status == 'publish') return;
    echo "<div class='misc-pub-section'><input type='checkbox' name='share' checked='checked' /> Share on social networks?</div>";
}

function socializr_save_post($id) {
    $enable = isset($_POST['share']) && $_POST['share'] == 'on';
    if ($enable) {
        update_post_meta($id, 'enable_share', 1);
    } else {
        delete_post_meta($id, 'enable_share');
    }
}

function socializr_publish_post($id) {
    global $post;
    $enable = get_post_meta($id, 'enable_share');
    if ($enable && $post->post_status != 'publish') {
        $the_post = get_post($id);
        global $allowed_services;
        foreach ($allowed_services as $service) {
            global ${strtolower($service)};
            ${strtolower($service)}->sharePost($the_post);
        }
    }
    return $id;
}

