<?php 
$page_name = 'register';

$users = new Users;

//look out for any params
$request = $app->request();
$user_id = is_numeric($args[0]) ? $args[0] : 0; //user_id argument from the URL

//get the status to display success message
$status = $request->get('status', null);

$do = $request->post('do');
$email = $request->post('email');
$where['email'] = $email;
$data = $users->Select($where);
if ($data)
{
	header("location: /dashboard/register/register?status=user_already_exists");
	exit;
}
switch($do)
{
	case 'register':
		//get the post values and assign it to $params
		$params = $request->post();

		unset($params['do']);

		$password = $params["password"];
		$confirm_password = $params["confirm-password"];
		if ($password != $confirm_password)
		{
			header("location: /dashboard/register/?status=error");
			exit;
		}
		if($password == "" || $confirm_password == "")
		{
			header("location: /dashboard/registerd/?status=empty");
			exit;			
		} 
		unset($params['confirm-password']);
		if($user_id == 0)
		{
			$params['password'] = $password;
			$data = $users->Save($params, 'user_id');
			$user_id = $data[0]['user_id'];
		}

		header("location: /dashboard/login/?status=registered");
		exit;
	break;
}

//load up the users information
$where = array();
$where['user_id'] = $user_id;
$data = $users->Select($where);
$data = $data[0];

//what form elements does this page need?
$form_elements[] = array('type' => 'textbox', 'name' => 'firstname', 'value' => $data['firstname'], 'title' => 'Firstname', 'attributes' => array('required' => 'required'));
$form_elements[] = array('type' => 'textbox', 'name' => 'lastname', 'value' => $data['lastname'], 'title' => 'Lastname', 'attributes' => array('required' => 'required'));
$form_elements[] = array('type' => 'textbox', 'name' => 'email', 'value' => $data['email'], 'title' => 'Email', 'attributes' => array('required' => 'required'));
$form_elements[] = array('type' => 'password', 'name' => 'password', 'value' => null, 'title' => 'Password', 'attributes' => array('required' => 'required'), 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}');
$form_elements[] = array('type' => 'password', 'name' => 'confirm-password', 'value' => null, 'title' => 'Confirm Password', 'attributes' => array('required' => 'required'), 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}');
$form_elements[] = array('type' => 'textbox', 'name' => 'company', 'value' => $data['company'], 'title' => 'Company');
$form_elements[] = array('type' => 'textbox', 'name' => 'telephone', 'value' => $data['telephone'], 'title' => 'Telephone');

$render = new Form_render($form_elements);

$view = 'dashboard/register.html';
require(SYSTEM_VIEWS . '/base.dashboard.html');