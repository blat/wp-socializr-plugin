<?php

class SocializrWidget extends WP_Widget {

    protected $_options = array(
        'title'        => array('type' => 'text',     'label' => 'Title',             'default' => ''),
    );

    public function widget($args, $instance) {
        extract($args);
        foreach ($this->_options as $option => $data) {
            $$option = $this->_get($option, $instance);
            switch ($data['type']) {
                case 'checkbox':
                    $$option = ($$option) ? 'true' : 'false';
                    break;
            }
            $this->{'_' . $option} = $$option;
        }
        $this->_title = apply_filters('widget_title', $this->_title);
    }

    public function form($instance) {
        foreach ($this->_options as $option => $data) {
            $label = $data['label'];
            $id = $this->get_field_id($option);
            $name = $this->get_field_name($option);
            $value = $this->_get($option, $instance);
            switch ($data['type']) {
                case 'text':
                    echo "<p><label for='$id'>$label:</label><br/><input id='$id' name='$name' type='text' value='$value' style='width: 100%;' /></p>";
                    break;
                case 'checkbox':
                    $value = ($value) ? "checked='checked'" : "";
                    echo "<p><input id='$id' name='$name' type='checkbox' $value /> <label for='$id'>$label</label></p>";
                    break;
            }
        }
    }

    public function update($new_instance, $old_instance) {
        foreach ($this->_options as $option => $data) {
            switch ($data['type']) {
                case 'checkbox':
                    if (!isset($new_instance[$option])) {
                        $new_instance[$option] = 'off';
                    }
                    break;
            }
        }
        return $new_instance;
    }

    private function _get($key, $instance) {
        $value = empty($instance[$key]) ? $this->_options[$key]['default'] : esc_attr($instance[$key]);
        switch ($this->_options[$key]['type']) {
            case 'checkbox':
                $value = ($value == 'on');
                break;
        }
        return $value;
    }

}

