<?php
$formhtml = "		<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
			<input type=\"hidden\" name=\"offlineaction\" id=\"offlineaction\" value=\"true\" />
			<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"1\" />
			<input type=\"submit\" class=\"optionblock gooffline\" value=\"Go Offline\" />
		</form>\n";
$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p><i>You are way too stressed out to take any passengers right now!</i></p><p>It's time to log out for a little while and take a break away from giving rides.</p></div></div>\n           " . $_SESSION["messages"];
?>