<?php

require_once dirname(__FILE__) . '/auth.php';
$current = isset($_GET['tab']) ? $_GET['tab'] : false;

echo '<div class="wrap">';
echo '<h2>Socializr</h2>';

echo '<ul class="subsubsub">';
echo '<li><a href="' . SETTINGS_URL . '"' . (!$current ? ' class="current"' : '') . '>General</a></li>';
global $allowed_services;
foreach ($allowed_services as $service):
    global ${strtolower($service)};
    if (!${strtolower($service)}->isLogged()) continue;
    $class = $service . 'Button';
    $button = new $class();
    echo '<li> | <a href="' . SETTINGS_URL . '&tab=' . $button->_base . '"' . ($current == $button->_base ? ' class="current"' : '') . '>' . $button->_base_label . '</a></li>';
    if ($current == $button->_base) $currentButton = $button;
endforeach;
echo '</ul>';
echo '<div class="clear"></div>';

echo '<form method="post" action="options.php">';

wp_nonce_field('update-options');

$elements = array();

if (!isset($currentButton)):
    global $allowed_services;
    foreach ($allowed_services as $service):
        global ${strtolower($service)};
        echo ${strtolower($service)}->form($elements);
    endforeach;
else:
    echo $currentButton->form($elements);
endif;

echo '<input type="hidden" name="action" value="update" />';
echo '<input type="hidden" name="page_options" value="' . implode(',', $elements) . '" />';

echo '<p class="submit"><input type="submit" class="button-primary" value="' . __('Save Changes') . '" /></p>';
echo '</form>';
echo '</div>';

