<?php
$boldstart = "";
$boldend = "";

if (isset($_POST["endkey"])) {
	$readJSON = file_get_contents('leaders.json');
	$tempJSON = json_decode($readJSON, true);
	
	$newrecord->endkey = $_POST["endkey"];
	$newrecord->endmileage = $_POST["endmileage"];
	$newrecord->endearnings = $_POST["endearnings"];
	$newrecord->endtime = $_POST["endtime"];
	$tempJSON[] = $newrecord;
	
	$tempJSON = array_values( array_unique( $tempJSON, SORT_REGULAR ) );
	$newJSON = json_encode($tempJSON);
	file_put_contents('leaders.json', $newJSON);
	
	$boldstart = "<b>";
	$boldend = "</b>";
}

$readtable = file_get_contents('leaders.json');
$decodetable = json_decode($readtable, true);
$decodetable = array_reverse( array_values( array_unique( $decodetable, SORT_REGULAR ) ) );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Fare Chaser Leaderboard</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="title" content="Fare Chaser Leaderboard" />
	<meta name="description" content="Run a transportation business. A simple browser game that uses Google Maps." />
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" type="image/png" href="favicon.png">
	<link rel="manifest" href="manifest.json">
  </head>

  <body>
	  <script>
		  "use strict";
		  let map;

		  function initMap() {
			  map = new google.maps.Map(document.getElementById("map"), {
				  center: {
					  lat: 40.821142, 
					  lng: 14.425728
				  },
				  zoom: 14,
				  mapTypeId: 'satellite'
			  });
		  }
	  </script>
    <div id="map"></div>
	
	<div id="theSettings">
		<div id="topFrame">
			<h1>RIDESHARE GAME</h1><h2><a href="mailto:farechaser@gmail.com">Feedback</a></h2>
		</div>
		<div id="bottomFrame">
			<form method="POST" action="index.html" target="_self">
				<input type="submit" class="optionblock break" value="Start Over" />
			</form>
			<br/>
			<h1>Leaderboard</h1>
			<table class="datatables">
				<tr>
					<th>Time (GMT)</th>
					<th>Miles</th>
					<th>Earnings</th>
					<th>$/Hr</th>
					<th>$/Mi</th>
				</tr>
<?php
$temp = "";
for($i = 0; $i < sizeof($decodetable); $i++) {
	$hmmtime = $decodetable[$i]["endtime"];
	$hmmearn = $decodetable[$i]["endearnings"];
	$hmmmile = $decodetable[$i]["endmileage"];
	
	$dt = new DateTime("@$hmmtime");
	$formtime = date_format($dt, "n-t-y, H:i");
	
	$hourly = number_format(($hmmearn / 4), 2, '.', '');
	$milely = number_format(($hmmearn / $hmmmile), 2, '.', '');
	$fixearn = number_format($hmmearn, 2, '.', '');
	
	if ($i > 0) {
		$boldstart = "";
		$boldend = "";
	}
	
	$temp .= "				<tr>";
	$temp .= "					<td class=\"leadrow\">" . $boldstart . $formtime . $boldend . "</td>";
	$temp .= "					<td class=\"leadrow\">" . $boldstart . $hmmmile . $boldend . "</td>";
	$temp .= "					<td class=\"leadrow\">$" . $boldstart . $fixearn . $boldend . "</td>";
	$temp .= "					<td class=\"leadrow\">$" . $boldstart . $hourly . $boldend . "</td>";
	$temp .= "					<td class=\"leadrow\">$" . $boldstart . $milely . $boldend . "</td>";
	$temp .= "				</tr>";
}
echo $temp;
?>
			</table>
		</div>
	</div>
  </body>
  <script>
	  initMap();
  </script>
</html>
