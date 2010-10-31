<?php

require_once INC_DIR . '/SocializeButton.php';

class FacebookButton extends SocializeButton {

    public $_base = 'facebook_like';
    public $_base_label = 'Facebook Like Button';

    protected $_options = array(
        'enable' => array(
            'type' => 'checkbox',
            'label' => 'Enable',
            'default' => ''
        ),
        'layout' => array(
            'type' => 'select',
            'label' => 'Layout',
            'options' => array(
                'standard'      => 'Standard',
                'button_count'  => 'Button count',
                'box_count'     => 'Box count'
            ),
            'default' => 'standard'
        ),
        'show_faces' => array(
            'type' => 'checkbox',
            'label' => 'Show Faces',
            'default' => 'true'
        ),
        'width' => array(
            'type' => 'text',
            'label' => 'Width',
            'default' => '450'
        ),
        'height' => array(
            'type' => 'text',
            'label' => 'Height',
            'default' => '80'
        ),
        'action' => array(
            'type' => 'select',
            'label' => 'Verb To Display',
            'options' => array(
                'like'          => 'Like',
                'recommend'     => 'Recommend'
            ),
            'default' => 'like'
        ),
        'colorscheme' => array(
            'type' => 'select',
            'label' => 'Color Scheme',
            'options' => array(
                'light'         => 'Light',
                'dark'          => 'Dark'
            ),
            'default' => 'light'
        ),
        'style' => array(
            'type' => 'text',
            'label' => 'Style',
            'default' => ''
        )
    );

    public function getCode() {
        if (!$this->_enable()) return;
        return '<p style="' . $this->style . '"><iframe src="http://www.facebook.com/plugins/like.php?href=' . urlencode($this->url) . '&amp;layout=' . $this->layout . '&amp;show_faces=' . ($this->show_faces ? 'true' : 'false') . '&amp;width=' . $this->width . '&amp;action=' . $this->action . '&amp;colorscheme=' . $this->colorscheme . '&amp;height=' . $this->height . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $this->width . 'px; height:' . $this->height . 'px;" allowTransparency="true"></iframe></p>';
    }

}

