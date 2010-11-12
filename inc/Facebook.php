<?php

require_once INC_DIR . '/Socialize.php';
require_once INC_DIR . '/FacebookButton.php';

class Facebook extends Socialize {

    public function signin() {
        $callback_url = urlencode(PLUGIN_URL . "/auth.php?service=Facebook&action=signin");

        if (!isset($_GET['code'])) {
            $url = "https://graph.facebook.com/oauth/authorize?client_id=" . CLIENT_ID . "&redirect_uri=$callback_url&scope=manage_pages,publish_stream,offline_access";
            header("Location: $url");

        } else {
            $code = $_GET['code'];
            $url = "https://graph.facebook.com/oauth/access_token?client_id=" . CLIENT_ID . "&redirect_uri=$callback_url&client_secret=" . CLIENT_SECRET . "&code=$code";
            $access_token = file_get_contents($url);
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
        $this->share(get_permalink($post->ID), null);
    }

    public function share($url, $description) {
        $page_id = get_option('facebook_page_id');
        $access_token = get_option('page_access_token');
        if (!empty($page_id) && !empty($access_token)) {
            $data = array(
                'link' => $url,
                'message' => $description,
                'actions' => '{"name": "' . SHARE_LABEL . '", "link": "http://www.facebook.com/sharer.php?u=' . urlencode($url) . '"}'
            );
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

