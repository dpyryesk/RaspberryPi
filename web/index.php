<?php
// Read current IP from a file
$file=fopen("ip.txt","r");
$ip = fgets($file);
fclose($file);

//echo "Redirecting to Pi: ".$ip;

// Call redirect
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
redirect("http://".$ip);
?>

<!DOCTYPE html>
<html>
<body>

<h1>Pi Experiment</h1>

<p>The frame below is running on a <a href="http://www.raspberrypi.org/" target="_blank">Raspberry Pi</a> microcomputer, which has full LAMP stack (Raspbian <strong>L</strong>inux OS, <strong>A</strong>pache 2 web server, <strong>M</strong>ySQL database and <strong>P</strong>HP 5 scripting engine).</p>

<iframe src="<?= "http://".$ip ?>" sandbox="" width="800px" height="600px">
  <p>Your browser does not support iframes.</p>
</iframe>
<br />
<img src="http://www.raspberrypi.org/wp-content/uploads/2012/03/Raspi_Colour_R.png" alt="Rapi Logo" width="149px" height="177px">

</body>
</html>