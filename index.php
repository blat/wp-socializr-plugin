<?php

/*
Plugin Name: Socialize
Plugin URI: http://www.github.com/blat/wp-socialize-plugin/
Version: 1.0
Author: Mickael BLATIERE
Author URI: http://www.blizzart.net/
*/

require_once dirname(__FILE__) . '/common.php';


////////////////////////////////
// ADMIN

add_action('admin_menu', 'socialize_admin_menu');
function socialize_admin_menu() {
    add_options_page('Socialize Options', 'Socialize', 'manage_options', PLUGIN_ID, 'socialize_manage_options');
    add_menu_page('Socialize', 'Socialize', 'publish_posts', PLUGIN_ID . '-share', 'socialize_share');
}

function socialize_manage_options() {
    global $twitter, $facebook;
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    include dirname(__FILE__) . '/options.php';
}

function socialize_share() {
    global $twitter, $facebook;
    if (!current_user_can('publish_posts')) {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    include dirname(__FILE__) . '/share.php';
}


////////////////////////////////
// WIDGETS

add_action('widgets_init', 'socialize_widgets_init');

function socialize_widgets_init() {
    require_once INC_DIR . '/TwitterWidget.php';
    register_widget('TwitterWidget');
    require_once INC_DIR . '/FacebookWidget.php';
    register_widget('FacebookWidget');
}


////////////////////////////////
// BUTTONS

add_filter('the_content', 'socialize_the_content');

function socialize_the_content($content) {
    if (!is_single()) return $content;
    $twitter_button  = new TwitterButton();
    $facebook_button = new FacebookButton();
    return $twitter_button->getCode() . $facebook_button->getCode() . $content;
}


////////////////////////////////
// ACTIONS HOOKS

add_action('post_submitbox_start', 'socialize_submitbox');
add_action('save_post', 'socialize_save_post');
add_action('publish_post', 'socialize_publish_post');

function socialize_submitbox() {
    global $post;
    if ($post->post_status == 'publish') return;
    echo "<div class='misc-pub-section'><input type='checkbox' name='share' checked='checked' /> Share on social networks?</div>";
}

function socialize_save_post($id) {
    $enable = isset($_POST['share']) && $_POST['share'] == 'on';
    if ($enable) {
        update_post_meta($id, 'enable_share', 1);
    } else {
        delete_post_meta($id, 'enable_share');
    }
}

function socialize_publish_post($id) {
    global $post;
    $enable = get_post_meta($id, 'enable_share');
    if ($enable && $post->post_status != 'publish') {
        $the_post = get_post($id);
        global $twitter, $facebook;
        $twitter->sharePost($the_post);
        $facebook->sharePost($the_post);
    }
    return $id;
}

