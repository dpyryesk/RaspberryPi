<?php
require_once('tts_log.php');

$path = preg_replace('~^/api/~', '', $_SERVER['REQUEST_URI']);
$parts = explode('/', $path);
$resource = array_shift($parts);

$method = $_SERVER['REQUEST_METHOD'];
$data = $_REQUEST['data'];

if ($resource == 'tts_log') {
	$id = array_shift($parts);
	
	if (empty($id)) {
		handle_log_base($method);
	} else {
		handle_log_id($method, $id);
	}
} else {
	header('HTTP/1.1 404 Not Found');
	echo "Wrong request, sorry!";
}

function handle_log_base($method) {
	switch($method) {
		case 'PUT':
			create_log();
			break;
	 
		case 'GET':
			display_logs();
			break;
	 
		default:
			header('HTTP/1.1 405 Method Not Allowed');
			header('Allow: GET, PUT');
			break;
	}
}

function handle_log_id($method, $id) {
	switch($method) {
		case 'POST':
			update_log($id);
			break;
	 
		case 'GET':
			display_log($id);
			break;
	 
		default:
			header('HTTP/1.1 405 Method Not Allowed');
			header('Allow: GET, POST');
			break;
	}
}

function create_log() {
	echo 'create_log';
}

function display_logs() {
	// Create connection
	$con = mysqli_connect("localhost","www","yXaXyRB5XAecr7TA","pi");
	
	// Check connection
	if (!mysqli_connect_errno($con)) {
		// Fetch data
		$qry = mysqli_query($con, "SELECT * FROM tts_log");
		// Close connection
		mysqli_close($con);
		
		$result = array();
		
		while($row = mysqli_fetch_array($qry)) {
			$result[] = new ttsLog($row);
		}
		
		echo json_encode($result);
	} else {
		header('HTTP/1.1 500 Internal Server Error');
		echo "Server error: " . mysqli_connect_error($con);
	}
}

function update_log($id) {
	echo "update_log($id)";
}

function display_log($id) {
	echo "display_log($id)";
}
?>