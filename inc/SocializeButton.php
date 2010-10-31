<?php

abstract class SocializeButton {

    public $_base = '';
    public $_base_label = '';
    protected $_options = array();

    public abstract function getCode();

    public function form(&$list) {
        $html = '';
        $html  = '<h3 class="title">' . $this->_base_label . '</h3>';
        $html .= '<table class="form-table">';

        foreach ($this->_options as $key => $data) {
            $html .= '<tr valign="top">';
            $html .= '<th scope="row">' . $data['label'] . '</th>';
            $html .= '<td>';

            $name = $this->_base . '_' . $key;
            switch ($data['type']) {
                case 'select':
                    $html .= '<select name="' . $name . '">';
                    foreach ($data['options'] as $value => $label) {
                        $html .= '<option value="' . $value . '"' . ($this->$key == $value ? ' selected="selected"' : '') . '>' . $label . '</option>';
                    }
                    $html .= '</select>';
                    break;

                case 'text':
                    $html .= '<input name="' .$name . '" type="text" value="' . $this->$key . '" />';
                    break;

                case 'checkbox':
                    $html .= '<input name="' .$name . '" type="checkbox" ' . ($this->$key ? ' checked="checked"' : '') . '/>';
                    break;
            }
            $list[] = $name;

            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
    }

    public function __get($key) {
        switch ($key) {
            case 'url':
                $value = get_permalink();
                break;
            case 'title':
                $value = get_the_title();
                break;
            default:
                $value = isset($this->_options[$key]) ? get_option($this->_base . '_' . $key, $this->_options[$key]['default']) : null;
        }
        return $value;
    }

    protected function _enable() {
        $enable = $this->enable;
        return !empty($enable);
    }

}

