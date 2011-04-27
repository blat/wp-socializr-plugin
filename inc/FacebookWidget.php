<?php

require_once INC_DIR . '/SocializrWidget.php';

class FacebookWidget extends SocializrWidget {

    protected $_options = array(
        'title'        => array('type' => 'text',     'label' => 'Title',             'default' => 'Facebook'),
        'connections'  => array('type' => 'text',     'label' => 'Connections',       'default' => '10'),
        'stream'       => array('type' => 'checkbox', 'label' => 'Show stream',       'default' => 'on'),
        'header'       => array('type' => 'checkbox', 'label' => 'Show header',       'default' => 'on'),
        'width'        => array('type' => 'text',     'label' => 'Width',             'default' => '292'),
        'height'       => array('type' => 'text',     'label' => 'Height',            'default' => '587'),
        'style'        => array('type' => 'text',     'label' => 'Additional style',  'default' => ''),
    );

    public function __construct() {
        parent::__construct('like-box-widget', 'Facebook Like Box', array('description' => 'The Like Box enables users to:
            see how many users already like this page, and which of their friends like it too ;
            read recent posts from the page ;
            like the page with one click, without needing to visit the page.'));

        $page = get_option('facebook_page_id');
        $this->_page = empty($page) ? null : 'http://www.facebook.com/profile.php?id=' . $page;
    }

    public function widget($args, $instance) {
        if (empty($this->_page)) return;
        parent::widget($args, $instance);
        extract($args);

        echo $before_widget;
        if ($this->_title) echo $before_title . $this->_title . $after_title;
        echo "<div style='$this->_style'>";
        echo "<iframe src='http://www.facebook.com/plugins/likebox.php?href=$this->_page&amp;width=$this->_width&amp;connections=$this->_connections&amp;stream=$this->_stream&amp;header=$this->_header&amp;height=$this->_height' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:{$this->_width}px; height:{$this->_height}px;' allowTransparency='true'></iframe>";
        echo "</div>";
        echo $after_widget;
    }

}

