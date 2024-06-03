<?php 
$message_file = fopen(FILES_STORE_ATTACHMENTS."\coding_qual_input.txt", "r") or die("Unable to open file!");

// print the decoded message
echo decode($message_file);

function decode($message_file)
 {
	$numbers = array();
	$stringsArray = array();

	// Output one line until end-of-file
	while(!feof($message_file)) 
	{
		$lines = fgets($message_file);
		$line = explode(" ", $lines);
		$numbers[] = $line[0]; // split all numbers of the string
		$stringsArray[$line[0]] = $line[1]; // and split all the words of the string
	}
	fclose($message_file);

	ksort($stringsArray); // rearrange the array in ascending order
	$strings = array_filter($stringsArray); // remove empty array elements
	sort($numbers, SORT_NUMERIC); // sort numbers in ascending order

	return	getDecodedString($strings, $numbers);
 }

 // arrange the strings in a pyramid structure
function getDecodedString($strings, $numbers)
{
	$fullString = "";
	$fullString .= '"';
	$n = 1; // initialize n
	// file has 300 inputs so in order to generate 300 inputs we need 24 iterations each line incrementing by 1 and display a pyramid
	for ($i = 0; $i < 24; $i++)
	{
		for ($j = 0; $j <= $i; $j++ )
		{
			// echo $n." ";
			$n = $n + 1;
		}
		// echo "<br/>";
		// check if the last character of a pyramid structure matches the key value of the string if matches display the last string of the match
		foreach($strings as $key=>$value){
			if ($key == $numbers[$n]-1){
				$fullString .= $value;
			}
		}
	}
	// print the last element of the array
	$fullString .= $strings[count($strings)].'"';

	return $fullString;
}

DEFINE('PAGE_URL', '/dashboard/user-files/');
DEFINE('PAGE_URL_EDIT', '/dashboard/user-files-edit/');

$page_name_main = 'files';
$page_name = 'user-files';

$f = new User_Files;

//look out for any params
$request = $app->request();
$files_id = isset($args[0]) ? $args[0] : null;

$status = $request->params('status', null);
$data = $f->Get_all();
$data_count = count($data);

switch($status)
{
	case 'delete':
		$f->Delete('id', $files_id);
		header('location: '.PAGE_URL.$files_id.'?status=deleted');
		exit;
	break;
}

$view = 'dashboard/user-files.html';
require_once(SYSTEM_VIEWS . '/base.dashboard.html');