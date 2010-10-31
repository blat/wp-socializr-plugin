<?php

require_once INC_DIR . '/Socialize.php';
require_once LIB_DIR . '/twitteroauth.php';
require_once INC_DIR . '/TwitterButton.php';

class Twitter extends Socialize {

    public function signin() {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $url = $_SERVER['HTTP_REFERER'];
            $request_token = $oauth->getRequestToken($url);
            if (200 == $oauth->http_code) {
                $token = $request_token['oauth_token'];
                $token_secret = $request_token['oauth_token_secret'];
                setcookie('oauth_token_secret', $token_secret, 0, '/');
                $url = $oauth->getAuthorizeURL($token);
                header('Location: ' . $url);
            }
        }
    }

    public function signout() {
        delete_option('access_token');
        delete_option('twitter_username');
    }

    public function isLogged() {
        $result = false;

        $access_token = get_option('access_token');
        if (!empty($access_token) && !empty($access_token['oauth_token']) && !empty($access_token['oauth_token_secret'])) {
            $oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $this->isLogged = true;

        } else {
            $oauth_token = $_REQUEST['oauth_token'];
            $oauth_token_secret = $_COOKIE['oauth_token_secret'];
            $oauth_verifier = $_REQUEST['oauth_verifier'];
            if (!empty($oauth_token) && !empty($oauth_token_secret) && !empty($oauth_verifier)) {
                $oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
                $access_token = $oauth->getAccessToken($oauth_verifier);
                if (200 == $oauth->http_code) {
                    update_option('access_token', $access_token);
                    $this->isLogged = true;
                }
            }
        }

        if ($this->isLogged) {
            $data = $oauth->get('account/verify_credentials');
            $this->username = $data->screen_name;
            update_option('twitter_username', $this->username);
        }

        return $this->isLogged;
    }

    protected function _form(&$elements) {
        $html = '<input type="text" name="twitter_username" value="' . $this->username . '" disabled="disabled" />';
        return $html;
    }

    public function sharePost($post) {
        $status  = '[';
        foreach((get_the_category($post->ID)) as $cat) {
            $status .= $cat->name;
        }
        $status .= '] ';
        $status .= $post->post_title;
        foreach (get_the_tags($post->ID) as $tag) {
            $status .= ' #'. $tag->name;
        }
        $this->share(get_permalink($post->ID), $status);
    }

    public function share($url, $description) {
        $access_token = get_option('access_token');
        if (!empty($access_token) && !empty($access_token['oauth_token']) && !empty($access_token['oauth_token_secret'])) {
            $status = $description . " " . shortify($url);
            $oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $oauth->post('statuses/update', array('status' => $status));
        }
    }

}

