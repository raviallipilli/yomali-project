<?php

$visits = new Visits();

$data = json_decode(file_get_contents('php://input'), true);

$url = $data['url'];
$page_name = $data['page_name'];
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$entry_timestamp = $data['entry_timestamp'];
$exit_timestamp = $data['exit_timestamp'];
$user_id = $data['login_id'];

$visitData = [
    'user_id' => $user_id,
    'page_name' => $page_name,
    'url' => $url,
    'ip' => $ip,
    'user_agent' => $userAgent,
    'entry_timestamp' => $entry_timestamp,
    'exit_timestamp' => $exit_timestamp
];

$visits->Save($visitData);

// Output the received data for debugging purposes
echo json_encode(['status' => 'success', 'data' => $visitData]);