<?php
function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}

// Get parameters
$text = htmlspecialchars(str_replace("'", "", $_GET["Body"]));
$from = htmlspecialchars(str_replace("'", "", $_GET["From"]));
if (strlen($from) == 0) $from = "anonymous";
$ip = get_client_ip();
$location = htmlspecialchars(str_replace("'", "", $_GET["Loc"]));


// Save log to database
// Create connection
$con=mysqli_connect("localhost","www","yXaXyRB5XAecr7TA","pi");

// Check connection
if (!mysqli_connect_errno($con))
{
	// Insert data
	$sql = "INSERT INTO  `tts_log` (  `text` ,  `sender` ,  `ip` ,  `location` )
		VALUES ('" . $text . "', '" . $from . "', '" . $ip . "', '" . $location . "')";
	
	if (!mysqli_query($con, $sql))
	{
		die('Error: ' . mysqli_error($con));
	}
	
	// Close connection
	mysqli_close($con);
}

// Say text
$command = 'sh /home/www/tts.sh "' . $text . '" "' . $from . '" ' . $ip . ' 2>&1';
$output = exec($command);
echo $output;
?>