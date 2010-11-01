<?php

require_once INC_DIR . '/SocializeWidget.php';

class TwitterWidget extends SocializeWidget {

    protected $_options = array(
        'title'             => array('type' => 'text',     'label' => 'Title',                 'default' => 'Twitter'),
        'live'              => array('type' => 'checkbox', 'label' => 'Poll for new results?', 'default' => 'off'),
        'scrollbar'         => array('type' => 'checkbox', 'label' => 'Include scrollbar?',    'default' => 'off'),
        'rpp'               => array('type' => 'text',     'label' => 'Number of Tweets',      'default' => '4'),
        'avatars'           => array('type' => 'checkbox', 'label' => 'Show avatars?',         'default' => 'off'),
        'timestamp'         => array('type' => 'checkbox', 'label' => 'Show timestamps?',      'default' => 'on'),
        'hastags'           => array('type' => 'checkbox', 'label' => 'Show hashtags?',        'default' => 'on'),
        'shell_background'  => array('type' => 'text',     'label' => 'Shell background',      'default' => '#fff'),
        'shell_color'       => array('type' => 'text',     'label' => 'Shell text',            'default' => '#888'),
        'tweets_background' => array('type' => 'text',     'label' => 'Tweet background',      'default' => '#fff'),
        'tweets_color'      => array('type' => 'text',     'label' => 'Tweet text',            'default' => '#333'),
        'tweets_links'      => array('type' => 'text',     'label' => 'Links',                 'default' => '#06c'),
        'width'             => array('type' => 'text',     'label' => 'Width',                 'default' => '250'),
        'height'            => array('type' => 'text',     'label' => 'Height',                'default' => '300'),
        'style'             => array('type' => 'text',     'label' => 'Additional style',      'default' => 'border: 1px solid #555;'),
    );

    public function __construct() {
        parent::__construct('twitter-widget', 'Twitter Widget', array('description' => 'Widgets let you display Twitter updates on your website or social network page.'));

        $this->_user = get_option('twitter_username');
    }

    public function widget($args, $instance) {
        if (empty($this->_user)) return;
        parent::widget($args, $instance);
        extract($args);

        echo $before_widget;
        if ($this->_title) echo $before_title . $this->_title . $after_title;
        echo "<div style='$this->_style'>";
        echo "<script src='http://widgets.twimg.com/j/2/widget.js'></script>";
        echo "<script>
            new TWTR.Widget({
                version: 2,
                type: 'profile',
                rpp: $this->_rpp,
                interval: 6000,
                width: '$this->_width',
                height: '$this->_height',
                theme: {
                    shell: {
                        background: '$this->_shell_background',
                        color: '$this->_shell_color'
                    },
                    tweets: {
                        background: '$this->_tweets_background',
                        color: '$this->_tweets_color',
                        links: '$this->_tweets_links'
                    }
                },
                features: {
                    scrollbar: $this->_scrollbar,
                    loop: false,
                    live: $this->_live,
                    hashtags: $this->_hastags,
                    timestamp: $this->_timestamp,
                    avatars: $this->_avatars,
                    behavior: 'default'
                }
            }).render().setUser('$this->_user').start();
        </script>";
        echo "</div>";
        echo $after_widget;
    }

}

