<?php
// Create connection
$con=mysqli_connect("localhost","www","yXaXyRB5XAecr7TA","pi");

// Check connection
if (!mysqli_connect_errno($con))
{
	// Fetch data
	$result = mysqli_query($con,"SELECT * FROM tts_log");
	// Close connection
	mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Raspberry Pi : Voice Messae Log</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="tablesorter/themes/blue/style.css">

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="jQuery/jquery-2.0.3.min.js"></script>
<script src="tablesorter/jquery.tablesorter.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row-fluid">
		<div class="span12">
			<?php
			if (mysqli_connect_errno($con))
			{
				echo "<div class='alert alert-error'>" . "Failed to connect to MySQL: " . mysqli_connect_error() . "</div>";
			}
			?>
			<table class="table table-striped tablesorter" id="log" width="100%">
				<thead>
					<tr>
						<th>Timestamp</th>
						<th>Text</th>
						<th>From</th>
						<th>IP</th>
						<th width='10px'>Map</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($row = mysqli_fetch_array($result))
					{
						echo "<tr>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td>" . $row['text'] . "</td>";
						echo "<td>" . $row['sender'] . "</td>";
						echo "<td>" . $row['ip'] . "</td>";
						if ($row['location'] != "undefined") {
							echo "<td align='center'><a class='btn btn-mini btn-block' onClick='showMapFromString(\"" . $row['location'] . "\");'><span class='glyphicon glyphicon-map-marker'></span></a></td>";
						} else {
							echo "<td align='center'>???</td>";
						}
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	
	<!-- Map -->
	<div id="map_canvas" style="width:560px; height:400px;" align="center"></div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>

function showMapFromString(pos) {
	if (pos != "undefined") {
		var str = pos.split(" / ");
		showMap(str[0], str[1]);
	}
}

function showMap(lat, lng) {
  
  var latlng = new google.maps.LatLng(lat, lng);
  var mapOptions = {
    zoom: 15,
    center: latlng,
    mapTypeControl: false,
    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  
  var marker = new google.maps.Marker({
      position: latlng, 
      map: map, 
      title:"Here!"
  });
}

$(document).ready(function() 
    { 
        $("#log").tablesorter({
			headers: {
				4: { 
					sorter: false 
				}
			}
		});
    } 
);
</script>
</body>
</html>
