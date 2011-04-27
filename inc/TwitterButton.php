<?php

require_once INC_DIR . '/SocializrButton.php';

class TwitterButton extends SocializrButton {

    public $_base = 'twitter';
    public $_base_label = 'Tweet Button';

    protected $_options = array(
        'enable' => array(
            'type' => 'checkbox',
            'label' => 'Enable',
            'default' => ''
        ),
        'count' => array(
            'type' => 'select',
            'label' => 'Count',
            'options' => array(
                'vertical'      => 'Vertical count',
                'horizontal'    => 'Horizontal count',
                'none'          => 'No count'
            ),
            'default' => 'vertical'
        ),
        'language' => array(
            'type' => 'select',
            'label' => 'Language',
            'options' => array(
                'en'            => 'English',
                'fr'            => 'French',
                'de'            => 'German',
                'es'            => 'Spanish',
                'ja'            => 'Japanese'
            ),
            'default' => 'en'
        ),
        'style' => array(
            'type' => 'text',
            'label' => 'Style',
            'default' => ''
        )
    );

    public function getCode() {
        if (!$this->_enable()) return;
        return '<p style="' . $this->style . '"><a href="http://twitter.com/share" class="twitter-share-button" data-url="' . $this->url . '" data-text="' . $this->title . '" data-count="' . $this->count . '" data-via="' . $this->username . '" data-lang="' . $this->language . '">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></p>';
    }

}

