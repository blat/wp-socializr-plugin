<?php

define('ROOT_DIR', dirname(__FILE__));
define('PLUGIN_DIR', basename(ROOT_DIR));

define("PLUGIN_ID", "socialize");
define("BASE_URL", "http://" . $_SERVER['SERVER_NAME']);
define("PLUGIN_URL", BASE_URL . "/wp-content/plugins/" . PLUGIN_DIR . "/");
define("SETTINGS_URL", BASE_URL . "/wp-admin/options-general.php?page=" . PLUGIN_ID);

define('LIB_DIR', ROOT_DIR . '/lib');
define('INC_DIR', ROOT_DIR . '/inc');

require_once ROOT_DIR . '/config.php';

$allowed_services = array('Facebook', 'Twitter');
foreach ($allowed_services as $service) {
    require_once INC_DIR . '/' . $service . '.php';
    ${strtolower($service)} = new $service();
}


////////////////////////////////
// FUNCTIONS

function shortify($url) {
    $parse_url = parse_url($url);
    if (empty($parse_url['scheme'])) return false;

    $content = http_build_query(array('url' => $url));
    $headers  = 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
    $headers .= 'Content-Length: ' . strlen($content);

    $opts = array(
        'http' => array(
            'method'        => 'POST',
            'header'        => $headers,
            'content'       => $content,
            'timeout'       => 1,
            'max_redirects' => 1,
        )
    );
    $context = stream_context_create($opts);

    @file_get_contents('http://goo.gl/api/shorten', false, $context);

    foreach ($http_response_header as $header_response) {
        if (stripos($header_response, 'Location:') === 0) {
            return preg_replace('`Location:[\s]*`i', '', $header_response);
        }
    }

    return false;
}

