<?php

require_once INC_DIR . '/Socializr.php';
require_once INC_DIR . '/FacebookButton.php';

class Facebook extends Socializr {

    public function signin() {
        if (!isset($_GET['access_token'])) {
            $url = 'http://socializr.blizzart.net/facebook.php?callback_url=' . urlencode(PLUGIN_URL . "/auth.php?service=Facebook&action=signin");
            header("Location: $url");
        } else {
            $access_token = $_GET['access_token'];
            if (!empty($access_token)) header("Location: " . SETTINGS_URL . "&access_token=$access_token");
        }
    }

    public function signout() {
        delete_option('user_access_token');
        delete_option('page_access_token');
        delete_option('facebook_page_id');
    }

    public function isLogged() {
        $result = false;

        if (isset($_REQUEST['access_token'])) {
            update_option('user_access_token', $_REQUEST['access_token']);
        }

        $user_access_token = get_option('user_access_token');
        if (!empty($user_access_token)) {
            $url = "https://graph.facebook.com/me/accounts?$user_access_token";
            $pages = json_decode(file_get_contents($url), true);

            if (!empty($pages) && !empty($pages['data'])) {
                $this->isLogged = true;
                $this->pages = $pages['data'];

                $this->page_id = get_option('facebook_page_id');
                if (!empty($this->page_id)) {
                    foreach ($this->pages as $page) {
                        if ($page['id'] == $this->page_id) {
                            update_option('page_access_token', $page['access_token']);
                            break;
                        }
                    }
                } else {
                    $page = current($this->pages);
                    update_option('page_access_token', $page['access_token']);
                    $this->page_id = $page['id'];
                }
            }
        }

        return $this->isLogged;
    }

    protected function _form(&$elements) {
        $html  = '<select name="facebook_page_id">';
        foreach ($this->pages as $page) {
            $html .= '<option value="' . $page['id'] . '" ';
            if (!empty($this->page_id) && $this->page_id == $page['id']) {
                $html .= 'selected="selected"';
            }
            $html .= '>' . $page['name'] . '</option>';
        }
        $html .= '</select>';
        $elements[] = 'facebook_page_id';
        return $html;
    }

    public function sharePost($post) {
        $data = array(
            'link' => get_permalink($post->ID),
            'name' => $post->post_title,
            'picture' => wp_get_attachment_url(get_post_thumbnail_id($post->ID))
        );
        $this->_share($data);
    }

    public function share($url, $description) {
        $data = array(
            'link' => $url,
            'message' => $description
        );
        $this->_share($data);
    }

    private function _share($data) {
        $page_id = get_option('facebook_page_id');
        $access_token = get_option('page_access_token');
        if (!empty($page_id) && !empty($access_token)) {
            if (!empty($data['link'])) {
                $data['actions'] = '{"name": "' . SHARE_LABEL . '", "link": "http://www.facebook.com/sharer.php?u=' . urlencode($data['link']) . '"}';
            }
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($opts);
            $url = "https://graph.facebook.com/$page_id/feed?access_token=$access_token";
            file_get_contents($url, false, $context);
        }
    }

}

