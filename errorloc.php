<?php
$formhtml = "		<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
			<input type=\"hidden\" name=\"onlineaction\" id=\"onlineaction\" value=\"true\" />
			<input type=\"hidden\" name=\"demandstatus\" id=\"demandstatus\" value=\"" . $demandstatus . "\" />
			<input type=\"submit\" class=\"optionblock goonline\" value=\"Continue\" />
		</form>
		<br/>
		<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
			<input type=\"hidden\" name=\"offlineaction\" id=\"offlineaction\" value=\"true\" />
			<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"1\" />
			<input type=\"submit\" class=\"optionblock gooffline\" value=\"Go Offline\" />
		</form>\n";
$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p><i>Oops! Something went wrong...</i></p><p>Before you could accept the ride, it was snatched away. You scratch your head wondering what could have screwed it up. Oh well.</p></div></div>\n           " . $_SESSION["messages"];
?>