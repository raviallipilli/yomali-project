<?php

// Define constants
DEFINE('PAGE_URL', '/dashboard/track-info/');
$page_name = 'track-info';

// Instantiate Visits class
$v = new Visits;

// Get request parameters
$request = $app->request();
$userId = $request->params('user_id', $_SESSION['login_id']);
$startDate = $request->params('startDate', null);
$endDate = $request->params('endDate', null);
$startTime = $request->params('startTime', null);
$endTime = $request->params('endTime', null);

// Set default values if parameters are not provided
$startDate = isset($startDate) ? $startDate : date('Y-m-d');
$startTime = isset($startTime) ? $startTime : '00:00';
$endDate = isset($endDate) ? $endDate : date('Y-m-d');
$endTime = isset($endTime) ? $endTime : '23:59';

// Set start and end date times
$startDateTime = $startDate . ' ' . $startTime . ':00';
$endDateTime = $endDate . ' ' . $endTime . ':59';

// Fetch data based on provided parameters
if (is_null($startDate) && is_null($endDate) && is_null($userId)) {
    $data = $v->Select();
} else {
    if ($_SESSION['is_admin']) {
        if ($userId) {
            $data = ($userId == 0) 
                ? $v->getUniqueVisits($startDateTime, $endDateTime) 
                : $v->getUniqueVisits($startDateTime, $endDateTime, $userId);
        } else {
            $data = $v->getUniqueVisits($startDateTime, $endDateTime);
        }
    } else {
        $data = $v->getUniqueVisits($startDateTime, $endDateTime, $userId);
    }
}

$data_count = count($data);

// Fetch users
$u = new Users;
$users = $u->Get_users();

// Render view
$view = 'dashboard/track-info.html';
require_once(SYSTEM_VIEWS . '/base.dashboard.html');
?>
