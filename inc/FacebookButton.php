<?php

require_once INC_DIR . '/SocializrButton.php';

class FacebookButton extends SocializrButton {

    public $_base = 'facebook';
    public $_base_label = 'Facebook Share';

    protected $_options = array(
        'enable' => array(
            'type' => 'checkbox',
            'label' => 'Enable',
            'default' => ''
        ),
        'type' => array(
            'type' => 'select',
            'label' => 'Layout',
            'options' => array(
                'box_count'    => 'Box count',
                'button_count' => 'Button count',
                'icon_link'    => 'Icon link',
                'icon'         => 'Icon'
            ),
            'default' => 'button_count'
        ),
        'label' => array(
            'type' => 'text',
            'label' => 'Label',
            'default' => 'Share'
        ),
        'style' => array(
            'type' => 'text',
            'label' => 'Style',
            'default' => ''
        )
    );

    public function getCode() {
        if (!$this->_enable()) return;
        return '<p style="' . $this->style . '"><a name="fb_share" type="' . $this->type . '" share_url="' . $this->url . '">' . $this->label . '</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script></p>';
    }

}

