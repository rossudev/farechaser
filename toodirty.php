<?php
$formhtml = "		<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
			<input type=\"hidden\" name=\"offlineaction\" id=\"offlineaction\" value=\"true\" />
			<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"1\" />
			<input type=\"submit\" class=\"optionblock gooffline\" value=\"Go Offline\" />
		</form>\n";
$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p><i>Your car is way too dirty to take any passengers right now!</i></p><p>You really need to log out and spend some time cleaning up this car.</p></div></div>\n           " . $_SESSION["messages"];
?>