<?php 
DEFINE("PAGE_URL", "/dashboard/profile/");

$page_name = 'profile';

$user = new Users;

//look out for any params
$user_id = $_SESSION['login_id'];
$do = $app->request->post('do', null);

switch($do)
{
	case "view":
		//get the post values and assign it to $params
		$params = $app->request->post();

		//remove the do param from the array
		unset($params['do']);

		//push in the primary key into the array as a where array
		$where['user_id'] = $user_id;
		$data = $user->Update($params, $where);
	break;
}

//load up the users information
$where['user_id'] = $user_id;
$data = $user->Select($where);

$data = $data[0];

//what form elements does this page need?
$form_elements_array[] = array("type" => "textbox", "name" => "firstname", "value" => $data['firstname'], "title" => "Firstname", "attributes" => array("disabled" => "disabled"));
$form_elements_array[] = array("type" => "textbox", "name" => "lastname", "value" => $data['lastname'], "title" => "Lastname", "attributes" => array("disabled" => "disabled"));
$form_elements_array[] = array("type" => "textbox", "name" => "email", "value" => $data['email'], "title" => "Email", "attributes" => array("disabled" => "disabled"));
$form_elements_array[] = array("type" => "textbox", "name" => "password", "value" => "**********", "title" => "Password", "attributes" => array("disabled" => "disabled"));
$form_elements_array[] = array("type" => "textbox", "name" => "telephone", "value" => $data['telephone'], "title" => "Telephone", "attributes" => array("disabled" => "disabled"));

$render = new Form_render($form_elements_array);

$modal = false;
$view = 'dashboard/profile.html';
require(SYSTEM_VIEWS . '/base.dashboard.html');