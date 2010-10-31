<?php

require_once dirname(__FILE__) . '/common.php';

$allowed_services = array('Facebook', 'Twitter');
$allowed_actions  = array('signin', 'signout');

$service = !empty($_GET['service']) && in_array($_GET['service'], $allowed_services) ? strtolower($_GET['service']) : false;
$action  = !empty($_GET['action'])  && in_array($_GET['action'], $allowed_actions)   ? $_GET['action']  : false;

if ($service && $action) {
    $$service->$action();
}

