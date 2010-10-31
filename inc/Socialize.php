<?php

abstract class Socialize {

    public abstract function signin();
    public abstract function signout();
    public abstract function isLogged();
    public abstract function sharePost($post);
    public abstract function share($url, $description);
    protected abstract function _form(&$elements);

    public function form(&$elements) {
        $class = get_class($this);

        $html .= '<table class="form-table">';
        $html .= '<tr valign="top">';

        $html .= '<th scope="row">' . $class . '</th>';
        $html .= '<td>';

        if ($this->isLogged()) {
            $html .= $this->_form($elements);
            $html .= ' <a href="' . SETTINGS_URL . '&service=' . $class . '&action=signout">reset</a>';
        } else {
            $html .= '<a href="' . PLUGIN_URL . '/auth.php?service=' . $class . '&action=signin"><img src="' . PLUGIN_URL . '/img/signin_' . strtolower($class) . '.png" /></a>';
        }

        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

}

