<?php
function randomFloat($min = 0, $max = 1) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

include 'vars3.php';

if (isset($_POST["location1"])) {
    session_start();
    session_destroy();
};

session_start();

$allpax = array( "Alex", "Becky", "Billy", "Gary", "James", "Farooq", "Olivia", "Sonja", "Knight", "Zoe" );
$goodridesmaster = array( $EventWorshipGood, $EventErrandGood, $EventEventGood, $EventRevelGood, $EventTravelGood, $EventCommuteGood );
$badridesmaster = array( $EventWorshipBad, $EventErrandBad, $EventEventBad, $EventRevelBad, $EventTravelBad, $EventCommuteBad );

if (isset($_POST["location1"])) {
    $_SESSION["startDay"] = $_POST["myDay"];
    $_SESSION["startTime"] = $_POST["myTime"];
    $strdate = $_SESSION["startDay"] . ", " . $_SESSION["startTime"];
    $_SESSION["thisdate"] = date_create($strdate);
    $futuredate = clone $_SESSION["thisdate"];
    $futuredate->add(new DateInterval("PT6H"));
    $_SESSION["endshift"] = date_format($futuredate, "D, H:i");


	
    $_SESSION["messages"] = "";
    $_SESSION["startLat"] = $_POST["location1"];
    $_SESSION["startLng"] = $_POST["location2"];
    $_SESSION["currentLat"] = $_SESSION["startLat"];
    $_SESSION["currentLng"] = $_SESSION["startLng"];
	
	$_SESSION["currentpax"] = "";
	$_SESSION["hostility"] = 1;
	$_SESSION["currentsurge"] = 0;
	$_SESSION["cheese"] = "";
	$_SESSION["paxhtml1"] = "";
	$_SESSION["paxhtml2"] = "";
	$_SESSION["rideover"] = false;

    $_SESSION["cleanliness"] = 3;
    $_SESSION["driverstress"] = 1;
	$_SESSION["odometer"] = 0;
	$_SESSION["earnings"] = 0;
	$_SESSION["totaltips"] = 0;
	$_SESSION["totalcheese"] = 0;
	$_SESSION["totalfare"] = 0;

	$_SESSION["paxx"] = $allpax;
	shuffle($_SESSION["paxx"]);

	$_SESSION["goodrides"] = $goodridesmaster;
	shuffle($_SESSION["goodrides"]);

	$_SESSION["badrides"] = $badridesmaster;
	shuffle($_SESSION["badrides"]);
};

$tempgood = $_SESSION["goodrides"];
$ctgood = count(array_values($tempgood));
if ($ctgood == 0) {
	$_SESSION["goodrides"] = $goodridesmaster;
	shuffle($_SESSION["goodrides"]);
}

$tempbad = $_SESSION["badrides"];
$ctbad = count(array_values($tempbad));
if ($ctbad == 0) {
	$_SESSION["badrides"] = $badridesmaster;
	shuffle($_SESSION["badrides"]);
}

$skipper = 1;
$surge = 0;
$tipper = 0;

$paxtypes = [
	"Event",
	"Revel",
	"Commute",
	"Errand",
	"Travel",
	"Worship"
];

if (isset($_POST["demandstatus"])) {
	$surgetop = rand(0,3);
	$multisurge = $surgetop * 0.25;
	
	switch ($_POST["demandstatus"]) {
		case "Balanced":
			$skipper = rand(2,4);
			$lowsurge = rand(0,2);
			$surge = $multisurge + $lowsurge;
			break;
		case "Surging":
			$skipper = 1;
			$lowsurge = rand(3,8);
			$surge = $multisurge + $lowsurge;
			break;
		case "Heavy Surging":
			$skipper = 1;
			$lowsurge = rand(9,25);
			$surge = $multisurge + $lowsurge;
			break;
		case "Too Many Drivers":
			$skipper = rand(5,8);
			$surge = 0;
			break;
		case "Way Too Many Drivers":
			$skipper = rand(10,15);
			$surge = 0;
	}
}

$errorloc = false;

if (isset($_POST["skiptime"])) {
    $skipper = round($_POST["skiptime"]);
	
	if ($_POST["skiptime"] <= 0) {
		$errorloc = true;
		$skipper = 1;
	}
};

// $vvrr = $_SESSION["currentpax"] . "Hostile" . $_SESSION["hostility"];
$vvrr = "EventHostile" . $_SESSION["hostility"];

if (isset($_POST["paxwait"])) {
	$skipper = rand($$vvrr[1], $$vvrr[2]);
} else if (isset($_POST["midride"])) {
	$skipper = 0;
}

$rndskiptime = round($skipper);
$_SESSION["thisdate"]->add(new DateInterval("PT" . $rndskiptime . "M"));
$formatdate = date_format($_SESSION["thisdate"], "D, H:i");
$hourdate = date_format($_SESSION["thisdate"], "H:i");

switch ($skipper) {
	case 1: $sayit = "minute has passed"; $saythis = " minute"; break;
	default: $sayit = "minutes have passed"; $saythis = " minutes";
}

$shiftover = false;
$timenow = strtotime($formatdate);
$timeend = strtotime($_SESSION["endshift"]);
if ($timenow >= $timeend) {
	$shiftover = true;
	$_SESSION["paxhtml1"] = "";
	$_SESSION["paxhtml2"] = "";
}

include 'vars.php';

$surge = number_format($surge, 2, '.', ',');

if (isset($_POST["location1"])) {
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>You turn the key, the engine sputters, coughs and rumbles to life. It's time to make some money!</p><p>You feel calm and rested after a good night's rest. You cleaned up the interior of the car somewhat after the end of the last shift, but it's still a bit dirty.</p><p>Click <i>Go Online</i> to begin matching with passengers.</div></div>\n            " . $_SESSION["messages"];
}

if (isset($_POST["acceptride"]) || isset($_POST["startride"]) || isset($_POST["paxwait"]) || isset($_POST["midride"])) {
	$startlatlng = trim($_POST["pickuploc"],"( )");
	$thearray = explode(",", $startlatlng);
	
	if (in_array("error", $thearray)) {
		$thearray = array($_SESSION["startLat"],$_SESSION["startLng"]);
	}
	
	$startlatlng = $thearray[0] . "," . $thearray[1];
	
	if ( (! isset($_POST["paxwait"])) || ( ! isset($_POST["midride"]) ) ) {
		$_SESSION["startLat"] = $thearray[0];
		$_SESSION["startLng"] = $thearray[1];
		$_SESSION["currentLat"] = $thearray[0];
		$_SESSION["currentLng"] = $thearray[1];
	}
	
} else {
	$startlatlng = $_SESSION["currentLat"] . "," . $_SESSION["currentLng"];
}

if (isset($_POST["smoke"])) {
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>After feeling some irritation, you decide it's time to unwind with a quick smoke break. You light up a Marlboro from your old-school cigarette lighter. You feel the tension in your body relax and fade away.</p><p class=\"statschange\">+1 Car Dirtiness<br/>-2 Driver Stress<br/>5 minutes pass</p></div></div>\n           " . $_SESSION["messages"];
	$_SESSION["cleanliness"] = $_SESSION["cleanliness"] + 1;
	$_SESSION["driverstress"] = $_SESSION["driverstress"] - 2;
	if ($_SESSION["driverstress"] < 0) {
		$_SESSION["driverstress"] = 0;
	}
	if ($_SESSION["cleanliness"] > 10) {
		$_SESSION["cleanliness"] = 10;
	}
}

if (isset($_POST["break"])) {
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>Even the best drivers need to take breaks sometimes. You find a quiet spot to pull over. You roll down the window, shut your eyes and sink into your chair. The rides that stressed you out are behind you now. You start to feel better after just a few minutes of relaxing.</p><p class=\"statschange\">-4 Driver Stress<br/>15 minutes pass</p></div></div>\n           " . $_SESSION["messages"];
	$_SESSION["driverstress"] = $_SESSION["driverstress"] - 4;
	if ($_SESSION["driverstress"] < 0) {
		$_SESSION["driverstress"] = 0;
	}
}

if (isset($_POST["clean"])) {
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>Your car has gotten yucky! You reach under the seat and grab the portable vacuum. You open the doors to air out the odors in the car while you carefully clean the interior. You dust off the dashboard and take a moment to admire your work. You wonder if the next passenger will even notice your efforts.</p><p class=\"statschange\">-4 Car Dirtiness<br/>15 minutes pass</p></div></div>\n           " . $_SESSION["messages"];
	$_SESSION["cleanliness"] = $_SESSION["cleanliness"] - 4;
	if ($_SESSION["cleanliness"] < 0) {
		$_SESSION["cleanliness"] = 0;
	}
}

$stressedout = false;
$toodirty = false;
if ($_SESSION["driverstress"] > 9) {
	$stressedout = true;
}
if ($_SESSION["cleanliness"] > 9) {
	$toodirty = true;
}

if (!$stressedout && !$toodirty && !$shiftover) {
	$formhtml = "			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
				<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
				<input type=\"hidden\" name=\"onlineaction\" id=\"onlineaction\" value=\"true\" />
				<input type=\"hidden\" name=\"demandstatus\" id=\"demandstatus\" value=\"" . $demandstatus . "\" />
				<input type=\"submit\" class=\"optionblock goonline\" value=\"Go Online\" />
			</form>\n";
} else {
	$formhtml = "";
}

if ($_SESSION["driverstress"] > 0 && !$toodirty && !$shiftover) {
	$formhtml = $formhtml . "			<br/>
			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
				<input type=\"hidden\" name=\"smoke\" id=\"smoke\" value=\"true\" />
				<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"5\" />
				<input type=\"submit\" class=\"optionblock smoke\" value=\"Smoke\" />
			</form>\n";
}

if ($_SESSION["cleanliness"] > 0 && !$shiftover) {
	$formhtml = $formhtml . "			<br/>
			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
				<input type=\"hidden\" name=\"clean\" id=\"clean\" value=\"true\" />
				<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"15\" />
				<input type=\"submit\" class=\"optionblock clean\" value=\"Clean\" />
			</form>\n";
}

if ($_SESSION["driverstress"] > 0 && !$shiftover) {
	$formhtml = $formhtml . "			<br/>
			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
				<input type=\"hidden\" name=\"break\" id=\"break\" value=\"true\" />
				<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"15\" />
				<input type=\"submit\" class=\"optionblock break\" value=\"Break\" />
			</form>\n";
}

//$makesure = $shiftover && (! isset($_POST["startride"])) && (! isset($_POST["midride"])) && (! isset($_POST["paxwait"])) && (! isset($_POST["cancelride"])) && (! isset($_POST["onlineaction"]));
if ($shiftover) {
	$formhtml = "			<form method=\"POST\" action=\"leaders.php\" target=\"_self\" enctype=\"multipart/form-data\">
				<input type=\"hidden\" name=\"endmileage\" id=\"endmileage\" value=\"" . $_SESSION["odometer"] . "\" />
				<input type=\"hidden\" name=\"endearnings\" id=\"endearnings\" value=\"" . $_SESSION["earnings"] . "\" />
				<input type=\"hidden\" name=\"endkey\" id=\"endkey\" value=\"" . bin2hex(random_bytes(32)) . "\" />
				<input type=\"hidden\" name=\"endtime\" id=\"endtime\" value=\"" . time() . "\" />
				<input type=\"submit\" class=\"optionblock decline\" value=\"End Shift\" />
			</form>\n";
			
	$figurefare = number_format($_SESSION["totalfare"], 2, '.', ',');
	$figurecheese = number_format($_SESSION["totalcheese"], 2, '.', ',');
	$figuretips = number_format($_SESSION["totaltips"], 2, '.', ',');
	
	$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>That's it! Your shift is over. Time to head back to the barn.</p><table style=\"font-size:80%; line-height:150%;\"><tr><td colspan=\"2\"><u>Earnings Breakdown</u></td></tr><tr><td>Fares</td><td>$" . $figurefare . "</td></tr><td>Cheese</td><td>$" . $figurecheese . "</td></tr><tr><td>Tips</td><td>$" . $figuretips . "</td></tr></table></div></div>\n           " . $_SESSION["messages"];
}

if (isset($_POST["declineride"]) && !$shiftover) {
	$_SESSION["paxhtml1"] = "";
	$_SESSION["paxhtml2"] = "";
	$_SESSION["cheese"] = "";
	$_SESSION["currentpax"] = "";
	$_SESSION["currentcheese"] = 0;
	
    $formhtml = "			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
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
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\">Ride declined.</div></div>\n           " . $_SESSION["messages"];
}

if (isset($_POST["cancelride"]) && !$shiftover) {
	$paxtempn = $_SESSION["currentpax"];
	
	$_SESSION["paxhtml1"] = "";
	$_SESSION["paxhtml2"] = "";
	$_SESSION["cheese"] = "";
	$_SESSION["currentpax"] = "";
	$_SESSION["currentcheese"] = 0;
	
    $formhtml = "			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
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
	if (isset($_POST["nopax"])) {
		$msgcancel = "As you begin to pull away from the curb, you see someone in your rear-view mirror running toward you and flailing their arms. The sound of their muffled yelling through the glass fades as you drive away.";
	} else {
		$msgcancel = str_replace("paxname", $paxtempn, $$vvrr[3]);
	}
    $_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>You cancel the ride.</p>" . $msgcancel . "</div></div>\n           " . $_SESSION["messages"];
}

if ((isset($_POST["startride"]) && ! $_SESSION["rideover"]) && !$shiftover) {
	$paxtempname = $_SESSION["currentpax"];
	
	$_SESSION["paxhtml1"] = "";
	$_SESSION["paxhtml2"] = "";
	$_SESSION["cheese"] = "";
	$_SESSION["currentpax"] = "";
	$_SESSION["currentcheese"] = 0;
	$_SESSION["rideover"] = true;
	
	$floater2 = floatval($_POST["senddis"]);

	$_SESSION["odometer"] = $_SESSION["odometer"] + $floater2;
	
	$distantpickup = 0;
	if ($_POST["firstdur"] > 11) {
		$valdur = floatval($_POST["firstdur"]);
		$valdis = floatval($_POST["firstdis"]);
		$countpaidtime = $valdur - 11;
		$countpaidmile = $valdis * ( $countpaidtime / $valdur );
		$distantpickup = ( 0.135 * $countpaidtime ) + ( 0.72 * $countpaidmile );
	}
	
	$timeearner = $_POST["skiptime"] * 0.135;
	$timeearn = number_format($timeearner, 2, '.', ',');
	
	$mileearner = 0.72 * $floater2;
	$mileearn = number_format($mileearner, 2, '.', ',');
	
	$surgin = $_POST["cheesego"];
	$surger = "";
	if ($surgin > 0 ) {
		$surger = "<tr><td>Cheese</td><td>$" . number_format($surgin, 2, '.', ',') . "</td></tr>";
	}
	
	$longearn = "";
	if ($distantpickup > 0 ) {
		$longearn = "<tr><td>Distant Pick-up</td><td>$" . number_format($distantpickup, 2, '.', ',') . "</td></tr>";
	}
	
	$didtheytip = rand(0,1);
	if ($didtheytip == 1) {
		switch ($_SESSION["hostility"]) {
			case 0:
				$tipper = rand(3,7);
				break;
			case 1: 
				$tipper = rand(2,5);
				break;
			case 2: 
				$tipper = rand(1,4);
				break;
			case 3: 
				$tipper = rand(1,3);
				break;
			case 4: 
				$tipper = rand(0,1);
				break;
			case 5: 
				$tipper = rand(0,1);
				break;
			case 6: 
				$tipper = rand(0,1);
				break;
			case 7: 
				$tipper = 0;
				break;
			case 8: 
				$tipper = 0;
				break;
			case 9: 
				$tipper = 0;
				break;
			case 10: 
				$tipper = 0;
		}
		if ($_SESSION["hostility"] < 2) {
			$lottery = rand(0,3);
			if ($lottery == 3) {
				$addfive = rand(1,4);
				$tipper = $tipper + ( $addfive * 5 );
			}
		}
	}
	
	$tipthis = "";
	if ($tipper > 0 ) {
		$tipthis = "<tr><td>Tip</td><td>$" . number_format($tipper, 2, '.', ',') . "</td></tr>";
	}
	
	$fareearn = 0.75 + $timeearner + $mileearner + $distantpickup;
	$calcearn = $surgin + $fareearn + $tipper;
	$earnings = number_format($calcearn, 2, '.', ',');
	if ($earnings < 2.25) {
		$earnings = 2.25;
	}
	
	$_SESSION["earnings"] = $_SESSION["earnings"] + $earnings;
	$_SESSION["cleanliness"] = $_SESSION["cleanliness"] + 1;
	$_SESSION["driverstress"] = $_SESSION["driverstress"] + 1;
	$_SESSION["totaltips"] = $_SESSION["totaltips"] + $tipper;
	$_SESSION["totalcheese"] = $_SESSION["totalcheese"] + $surgin;
	$_SESSION["totalfare"] = $_SESSION["totalfare"] + $fareearn;
	
	if ($_SESSION["driverstress"] > 10) {
		$_SESSION["driverstress"] = 10;
	}
	if ($_SESSION["cleanliness"] > 10) {
		$_SESSION["cleanliness"] = 10;
	}
	
	$formhtml = "			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
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
	$completemsg = str_replace("paxname", $paxtempname, $$vvrr[4]);
	$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>Ride completed.</p>" . $completemsg . "<p class=\"statschange\">$" . $earnings . " earned<br/>" . $skipper . " " . $sayit . "<br/>" . $_POST["senddis"] . " miles driven<br/>+1 Car Dirtiness<br/>+1 Driver Stress</p><table style=\"font-size:80%; line-height:150%;\"><tr><td colspan=\"2\"><u>Fare Breakdown</u></td></tr><tr><td>Base Fare</td><td>$0.75</td></tr><td>Time</td><td>$" . $timeearn . "</td></tr><tr><td>Mileage</td><td>$" . $mileearn . "</td></tr>" . $surger . $longearn . $tipthis . "</table></div></div>\n           " . $_SESSION["messages"];
}

if ((isset($_POST["startride"]) && $_SESSION["rideover"]) && !$shiftover) {
	$formhtml = "			<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
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
}

$jscalculate = "";

$icony = "pax";
$scaledsize = ", scaledSize: new google.maps.Size(30, 50)";
$paxjava = "infowindow.open(map, newmark);";

if (isset($_POST["offlineaction"])) {
	$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>You've gone offline.</p></div></div>\n           " . $_SESSION["messages"];
}

if (isset($_POST["onlineaction"]) || isset($_POST["acceptride"]) || isset($_POST["paxwait"]) || isset($_POST["midride"])) {
	if (isset($_POST["acceptride"]) || isset($_POST["paxwait"]) || isset($_POST["midride"])) {
		$icony = "flag";
		$scaledsize = "";
		$paxjava = "";
	}
	
    $min = 1;
    $max = 9999;
    $min2 = 1;
    $max2 = 99999;
    $sendn = rand(0, 1);
    $sendw = rand(0, 1);
    $currlat = $_SESSION["currentLat"];
    $currlng = $_SESSION["currentLng"];

    $randlat = (mt_rand ($min, $max) / 1000000) * 0.7;
    $randlng = (mt_rand ($min, $max) / 1000000) * 0.7;
    if ($sendn) { $randlat = ($randlat * -1); };
    if ($sendw) { $randlng = ($randlng * -1); };
    $randlat2 = (mt_rand ($min2, $max2) / 1000000) * 0.7;
    $randlng2 = (mt_rand ($min2, $max2) / 1000000) * 0.7;
    if ($sendn) { $randlat2 = ($randlat2 * -1); };
    if ($sendw) { $randlng2 = ($randlng2 * -1); };

    $pckuplat = $randlat + $currlat;
    $pckuplng = $randlng + $currlng;
    $pckuplat2 = $randlat2 + $pckuplat;
    $pckuplng2 = $randlng2 + $pckuplng;

    if ( $pckuplat > $pckuplat2 ) { $gosouth = true; } else { $gosouth = false; };
    if ( $pckuplng > $pckuplng2 ) { $gowest = true; } else { $gowest = false; };
    if ( $gosouth && $gowest ) {
        $swlat = $pckuplat2;
        $swlng = $pckuplng2;
        $nelat = $pckuplat;
        $nelng = $pckuplng;
    };
    if ( $gosouth && ! $gowest ) {
        $swlat = $pckuplat2;
        $swlng = $pckuplng;
        $nelat = $pckuplat;
        $nelng = $pckuplng2;
    };
    if ( ! $gosouth && $gowest ) {
        $swlat = $pckuplat;
        $swlng = $pckuplng2;
        $nelat = $pckuplat2;
        $nelng = $pckuplng;
    };
    if ( ! $gosouth && ! $gowest ) {
        $swlat = $pckuplat;
        $swlng = $pckuplng;
        $nelat = $pckuplat2;
        $nelng = $pckuplng2;
    };

	if (isset($_POST["paxwait"]) || isset($_POST["midride"])) {
		$swlat = $_POST["swlat"];
		$swlng = $_POST["swlng"];
		$nelat = $_POST["nelat"];
		$nelng = $_POST["nelng"];
	}
	
    $jscalculate = "var squareit = new google.maps.LatLngBounds(
                new google.maps.LatLng(" . $swlat . ", " . $swlng . "),
                new google.maps.LatLng(" . $nelat . ", " . $nelng . ") 
            );
            
            var request = {
                bounds: squareit
            };
            
            var service = new google.maps.places.PlacesService(map);

            service.nearbySearch(request, callback);\n";

	if (isset($_POST["onlineaction"]) && !$shiftover) {
		$_SESSION["rideover"] = false;
		
		$pax = $_SESSION["paxx"];
		$thispax = $pax[0];
		$_SESSION["currentpax"] = $thispax;
		$_SESSION["currentsurge"] = $surge;
		
		$_SESSION["hostility"] = rand(0,10);
		
		if ($_SESSION["hostility"] >= 7) {
			$_SESSION["hostility"] = rand(5,10);
		}
		
		if ($_SESSION["hostility"] == 10) {
			$_SESSION["hostility"] = rand(9,10);
		}
		
		switch ($_SESSION["hostility"]) {
			case 0:
				$_SESSION["paxstar"] = 5;
				break;
			case 1: 
				$_SESSION["paxstar"] = randomFloat(4.92, 5);
				break;
			case 2: 
				$_SESSION["paxstar"] = randomFloat(4.91, 5);
				break;
			case 3: 
				$_SESSION["paxstar"] = randomFloat(4.9, 5);
				break;
			case 4: 
				$_SESSION["paxstar"] = randomFloat(4.85, 4.96);
				break;
			case 5: 
				$_SESSION["paxstar"] = randomFloat(4.84, 4.94);
				break;
			case 6: 
				$_SESSION["paxstar"] = randomFloat(4.83, 4.92);
				break;
			case 7: 
				$_SESSION["paxstar"] = randomFloat(4.82, 4.9);
				break;
			case 8: 
				$_SESSION["paxstar"] = randomFloat(4.81, 4.88);
				break;
			case 9: 
				$_SESSION["paxstar"] = randomFloat(4.8, 4.86);
				break;
			case 10: 
				$_SESSION["paxstar"] = randomFloat(4.4, 4.8);
		}
		
		if ($surge > 0) {
			$_SESSION["cheese"] = "<br/><img src=\"cheese.png\" alt=\"Cheese\" style=\"width:15%;height:15%;\"> <span style=\"font-size:50%;\">+$" . $surge . "</span>";
		} else {
			$_SESSION["cheese"] = "";
		}
		
		$starspaxx = number_format($_SESSION["paxstar"], 2, '.', ',');
		$_SESSION["paxhtml1"] = "<img style=\"width:75%;object-fit:contain;margin-left:13%;\" src=\"" . $thispax . ".png\" alt=\"" . $thispax . "\">";
		$_SESSION["paxhtml2"] = "<p style=\"font-weight:bold;font-size:300%;text-align:center;font-family:Georgia, serif;\"> " . $thispax . "<br/><img src=\"star.png\" alt=\"Star\" style=\"width:15%;height:15%;\"> <span style=\"font-size:50%;\">" . $starspaxx . "</span>" . $_SESSION["cheese"] . "</p>";
		
		unset($pax[0]);
		$pax = array_values($pax);
		$howmany = count($pax);
		$zeromany = $howmany == 0;
		if ( $zeromany ) {
			$_SESSION["paxx"] = $allpax;
			shuffle($_SESSION["paxx"]);
		} else {
			$_SESSION["paxx"] = $pax;
		};

		$formhtml = "<table class=\"datatables\">
					<tr><td colspan=\"2\" class=\"cleanstress\">Pick-Up Estimate</td></tr>
					<tr>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totaldistance\">0 Miles</td>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totalduration\">0 Minutes</td>
					</tr>
					<tr><td colspan=\"2\"></td></tr>
					<tr><td colspan=\"2\" class=\"cleanstress\">Rate Card</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Base Fare:</b> $0.75</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Time:</b> 13.5c / minute (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Mileage:</b> 72c / mile (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Time:</b> 13.5c / minute</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Mileage:</b> 72c / mile</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Minimum Earnings:</b> $2.25</td></tr>
				</table>
				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
					<input type=\"hidden\" name=\"pickuploc\" id=\"pickuploc\" value=\"error,error\" />
					<input type=\"hidden\" name=\"acceptride\" id=\"acceptride\" value=\"true\" />
					<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"-1\" />
					<input type=\"hidden\" name=\"trcheese\" id=\"trcheese\" value=\"" . $surge . "\" />
					<input type=\"hidden\" name=\"senddis\" id=\"senddis\" value=\"-1\" />
					<input type=\"hidden\" name=\"senddur\" id=\"senddur\" value=\"-1\" />
					
					<input type=\"submit\" class=\"optionblock accept\" value=\"Accept Request\" />
				</form>
				<br/>
				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"declineride\" id=\"declineride\" value=\"true\" />
					<input type=\"submit\" class=\"optionblock decline\" value=\"Decline Request\" />
				</form>\n";

		$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>After waiting " . $skipper . $saythis . " to be matched with a passenger, you get a Ride Request from " . $thispax . ".</p><p>You can see the route to the passenger's pick-up location. Time and mileage toward pick-up is unpaid until the minimum threshold has been reached.</p><p>Will you accept this ride request?</p></div></div>\n           " . $_SESSION["messages"];
	}
}

if (isset($_POST["paxwait"])) {
	$waitmiddisplay = "<table class=\"datatables\">
					<tr><td colspan=\"2\" class=\"cleanstress\">Ride Estimate</td></tr>
					<tr>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totaldistance\">0 Miles</td>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totalduration\">0 Minutes</td>
					</tr>
					<tr><td colspan=\"2\"></td></tr>
					<tr><td colspan=\"2\" class=\"cleanstress\">Rate Card</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Base Fare:</b> $0.75</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Time:</b> 13.5c / minute (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Mileage:</b> 72c / mile (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Time:</b> 13.5c / minute</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Mileage:</b> 72c / mile</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Minimum Earnings:</b> $2.25</td></tr>
				</table>";
	$waitmidbutton = "Start";
	$waitmidgoto = "midride";
	$waitmidmsg = str_replace("paxname", $_SESSION["currentpax"], $$vvrr[0]);
	$waitmidstats = $skipper . " " . $sayit;
	$cancelornot = "				<br/>
				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"cancelride\" id=\"cancelride\" value=\"true\" />
					<input type=\"submit\" class=\"optionblock decline\" value=\"Cancel Ride\" />
				</form>\n";
	$colorbutton = "accept";
} else if (isset($_POST["midride"])) {
	$waitmiddisplay = "<div id=\"totaldistance\" style=\"display:none;\"></div><div id=\"totalduration\" style=\"display:none;\"></div>";
	$waitmidbutton = "Continue";
	$waitmidgoto = "startride";
	$cancelornot = "";
	$colorbutton = "break";
	
	$picktype = array_rand($custtypes, 1);
	$dotype = $paxtypes[$picktype];
	
	$isbad = false;
	if (($_SESSION["hostility"] == 4) || ($_SESSION["hostility"] == 5)) {
		$chances = rand(0,2);
		if ($chances == 2) {
			$isbad = true;
		}
	} else if ($_SESSION["hostility"] > 5) {
		$isbad = true;
	}
	
	if ($isbad) {
		// $dogb = "Bad";
		$badrides = $_SESSION["badrides"];
		$varstrr = $badrides[0];

		unset($badrides[0]);
		$badrides = array_values($badrides);
		$_SESSION["badrides"] = $badrides;
	} else {
		// $dogb = "Good";
		$goodrides = $_SESSION["goodrides"];
		$varstrr = $goodrides[0];

		unset($goodrides[0]);
		$goodrides = array_values($goodrides);
		$_SESSION["goodrides"] = $goodrides;
	}
	// $varstrr = $_SESSION["currentpax"] . $dotype . $dogb;
	// $$varstrr[1]
	// $varstrr = "Event" . $dotype . $dogb;
	$waitmidmsg = str_replace("paxname", $_SESSION["currentpax"], $varstrr[0]);
	
	if ( $varstrr[1] != 0 ) {
		$_SESSION["hostility"] = $_SESSION["hostility"] + $varstrr[1];
		if ($_SESSION["hostility"] < 0) {
			$_SESSION["hostility"] = 0;
		}
		if ($_SESSION["hostility"] > 10) {
			$_SESSION["hostility"] = 10;
		}
		if ($varstrr[1] > 0) {
			$pluss = "+";
		} else {
			$pluss = "";
		}
		$midhostile = $pluss . $varstrr[1] . " Passenger Hostility<br/>";
	} else {
		$midhostile = "";
	}
	
	if ( $varstrr[2] != 0 ) {
		$_SESSION["driverstress"] = $_SESSION["driverstress"] + $varstrr[2];
		if ($_SESSION["driverstress"] < 0) {
			$_SESSION["driverstress"] = 0;
		}
		if ($_SESSION["driverstress"] > 10) {
			$_SESSION["driverstress"] = 10;
		}
		if ($varstrr[2] > 0) {
			$plusss = "+";
		} else {
			$plusss = "";
		}
		$midstress = $plusss . $varstrr[2] . " Driver Stress<br/>";
	} else {
		$midstress = "";
	}
	
	if ( $varstrr[3] != 0 ) {
		$_SESSION["cleanliness"] = $_SESSION["cleanliness"] + $varstrr[3];
		if ($_SESSION["cleanliness"] < 0) {
			$_SESSION["cleanliness"] = 0;
		}
		if ($_SESSION["cleanliness"] > 10) {
			$_SESSION["cleanliness"] = 10;
		}
		if ($varstrr[3] > 0) {
			$plus = "+";
		} else {
			$plus = "";
		}
		$midclean = $plus . $varstrr[3] . " Car Dirtiness";
	} else {
		$midclean = "";
	}
	
	$waitmidstats = $midhostile . $midstress . $midclean;
}

if ((isset($_POST["paxwait"]) && !$shiftover) || isset($_POST["midride"]) ) {
	if ($errorloc) {
		include 'errorloc.php';
	} else if ($toodirty) {
		include 'toodirty.php';
	} else if ($stressedout) {
		include 'stressedout.php';
	} else {
		$formhtml = "			" . $waitmiddisplay . "\n				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $_POST["directionstart"] . "\" />
					<input type=\"hidden\" name=\"" . $waitmidgoto . "\" id=\"" . $waitmidgoto . "\" value=\"true\" />
					<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"" . $_POST["skiptime"] . "\" />
					<input type=\"hidden\" name=\"senddis\" id=\"senddis\" value=\"" . $_POST["senddis"] . "\" />
					<input type=\"hidden\" name=\"cheesego\" id=\"cheesego\" value=\"" . $_POST["cheesego"] . "\" />
					<input type=\"hidden\" name=\"senddur\" id=\"senddur\" value=\"" . $_POST["senddur"] . "\" />
					<input type=\"hidden\" name=\"firstdis\" id=\"firstdis\" value=\"" . $_POST["firstdis"] . "\" />
					<input type=\"hidden\" name=\"firstdur\" id=\"firstdur\" value=\"" . $_POST["firstdur"] . "\" />
					<input type=\"hidden\" name=\"demandstatus\" id=\"demandstatus\" value=\"" . $_POST["demandstatus"] . "\" />
					<input type=\"hidden\" name=\"pickuploc\" id=\"pickuploc\" value=\"" . $_POST["pickuploc"] . "\" />
					<input type=\"hidden\" name=\"swlat\" id=\"swlat\" value=\"" . $swlat . "\" />
					<input type=\"hidden\" name=\"swlng\" id=\"swlng\" value=\"" . $swlng . "\" />
					<input type=\"hidden\" name=\"nelat\" id=\"nelat\" value=\"" . $nelat . "\" />
					<input type=\"hidden\" name=\"nelng\" id=\"nelng\" value=\"" . $nelng . "\" />

					<input type=\"submit\" class=\"optionblock " . $colorbutton . "\" value=\"" . $waitmidbutton . " Ride\" />
				</form>" . $cancelornot;
		
		$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\">" . $waitmidmsg . "<p class=\"statschange\">" . $waitmidstats . "</p></div></div>\n           " . $_SESSION["messages"];
	}
}

if (isset($_POST["acceptride"]) && !$shiftover) {
	$floater = floatval($_POST["senddis"]);
	if ($errorloc) {
		include 'errorloc.php';
	} else if ($toodirty) {
		include 'toodirty.php';
	} else if ($stressedout) {
		include 'stressedout.php';
	} else {
		$_SESSION["odometer"] = $_SESSION["odometer"] + $floater;
		$firstdur = $_POST["senddur"];
		$formhtml = "			<table class=\"datatables\">
					<tr><td colspan=\"2\" class=\"cleanstress\">Ride Estimate</td></tr>
					<tr>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totaldistance\">0 Miles</td>
						<td style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; text-align:center;\" id=\"totalduration\">0 Minutes</td>
					</tr>
					<tr><td colspan=\"2\"></td></tr>
					<tr><td colspan=\"2\" class=\"cleanstress\">Rate Card</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Base Fare:</b> $0.75</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Time:</b> 13.5c / minute (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Long Pick-Up Mileage:</b> 72c / mile (after 11 minutes)</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Time:</b> 13.5c / minute</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Ride Mileage:</b> 72c / mile</td></tr>
					<tr><td colspan=\"2\" class=\"smol\"><b>Minimum Earnings:</b> $2.25</td></tr>
				</table>
				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"directionstart\" id=\"directionstart\" value=\"" . $startlatlng . "\" />
					<input type=\"hidden\" name=\"paxwait\" id=\"paxwait\" value=\"true\" />
					<input type=\"hidden\" name=\"skiptime\" id=\"skiptime\" value=\"0\" />
					<input type=\"hidden\" name=\"senddis\" id=\"senddis\" value=\"0\" />
					<input type=\"hidden\" name=\"cheesego\" id=\"cheesego\" value=\"" . $_POST["trcheese"] . "\" />
					<input type=\"hidden\" name=\"senddur\" id=\"senddur\" value=\"0\" />
					<input type=\"hidden\" name=\"firstdis\" id=\"firstdis\" value=\"" . $floater . "\" />
					<input type=\"hidden\" name=\"firstdur\" id=\"firstdur\" value=\"" . $firstdur . "\" />
					<input type=\"hidden\" name=\"demandstatus\" id=\"demandstatus\" value=\"" . $demandstatus . "\" />
					<input type=\"hidden\" name=\"pickuploc\" id=\"pickuploc\" value=\"" . $_POST["pickuploc"] . "\" />
					<input type=\"hidden\" name=\"swlat\" id=\"swlat\" value=\"" . $swlat . "\" />
					<input type=\"hidden\" name=\"swlng\" id=\"swlng\" value=\"" . $swlng . "\" />
					<input type=\"hidden\" name=\"nelat\" id=\"nelat\" value=\"" . $nelat . "\" />
					<input type=\"hidden\" name=\"nelng\" id=\"nelng\" value=\"" . $nelng . "\" />

					<input type=\"submit\" class=\"optionblock clean\" value=\"Wait for " . $_SESSION["currentpax"] . "\" />
				</form>
				<br/>
				<form method=\"POST\" action=\"ride.php\" target=\"_self\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"cancelride\" id=\"cancelride\" value=\"true\" />
					<input type=\"hidden\" name=\"nopax\" id=\"nopax\" value=\"true\" />
					<input type=\"submit\" class=\"optionblock smoke\" value=\"Cancel Ride\" />
				</form>\n";
		$_SESSION["messages"] = "<div class=\"message\"><span class=\"smol\">" . $hourdate . "</span><br/><div style=\"margin:15px;\"><p>Ride accepted. You drive to the requested pick-up location. The passenger's destination is revealed. Is this ride worth waiting on " . $_SESSION["currentpax"] . " to arrive?</p><p class=\"statschange\">" . $skipper . " " . $sayit . "<br/>" . $_POST["senddis"] . " miles driven</p></div></div>\n           " . $_SESSION["messages"];
	}
}

if (isset($_POST["acceptride"]) || isset($_POST["startride"]) || isset($_POST["onlineaction"]) || isset($_POST["paxwait"]) || isset($_POST["midride"])) {
	$strPass = $_SESSION["paxhtml1"];
	$strStuff = $_SESSION["paxhtml2"];
}

include 'vars2.php';

if (isset($_POST["declineride"]) || isset($_POST["cancelride"]) || isset($_POST["startride"]) || isset($_POST["offlineaction"]) || isset($_POST["smoke"]) || isset($_POST["break"]) || isset($_POST["clean"]) || isset($_POST["location1"])) {
	$dirtstresshtml = "        <table class=\"datatables\">
            <tr><td colspan=\"10\" class=\"cleanstress\">Car Dirtiness</td></tr>
            <tr>
                <td id=\"clean1\" style=\"background-color:" . $clean1 . "\"></td>
                <td id=\"clean2\" style=\"background-color:" . $clean2 . "\"></td>
                <td id=\"clean3\" style=\"background-color:" . $clean3 . "\"></td>
                <td id=\"clean4\" style=\"background-color:" . $clean4 . "\"></td>
                <td id=\"clean5\" style=\"background-color:" . $clean5 . "\"></td>
                <td id=\"clean6\" style=\"background-color:" . $clean6 . "\"></td>
                <td id=\"clean7\" style=\"background-color:" . $clean7 . "\"></td>
                <td id=\"clean8\" style=\"background-color:" . $clean8 . "\"></td>
                <td id=\"clean9\" style=\"background-color:" . $clean9 . "\"></td>
                <td id=\"clean10\" style=\"background-color:" . $clean10 . "\"></td>
            </tr>
        </table>
        <table class=\"datatables\">
            <tr><td colspan=\"10\" class=\"cleanstress\">Driver Stress</td></tr>
            <tr>
                <td id=\"stress1\" style=\"background-color:" . $stress1 . "\"></td>
                <td id=\"stress2\" style=\"background-color:" . $stress2 . "\"></td>
                <td id=\"stress3\" style=\"background-color:" . $stress3 . "\"></td>
                <td id=\"stress4\" style=\"background-color:" . $stress4 . "\"></td>
                <td id=\"stress5\" style=\"background-color:" . $stress5 . "\"></td>
                <td id=\"stress6\" style=\"background-color:" . $stress6 . "\"></td>
                <td id=\"stress7\" style=\"background-color:" . $stress7 . "\"></td>
                <td id=\"stress8\" style=\"background-color:" . $stress8 . "\"></td>
                <td id=\"stress9\" style=\"background-color:" . $stress9 . "\"></td>
                <td id=\"stress10\" style=\"background-color:" . $stress10 . "\"></td>
            </tr>
        </table>";
} else if (isset($_POST["paxwait"]) || isset($_POST["midride"])) {
	$dirtstresshtml = "        <table class=\"datatables\">
            <tr><td colspan=\"10\" class=\"cleanstress\">Passenger Hostility</td></tr>
            <tr>
                <td id=\"hostile1\" style=\"background-color:" . $hostile1 . "\"></td>
                <td id=\"hostile2\" style=\"background-color:" . $hostile2 . "\"></td>
                <td id=\"hostile3\" style=\"background-color:" . $hostile3 . "\"></td>
                <td id=\"hostile4\" style=\"background-color:" . $hostile4 . "\"></td>
                <td id=\"hostile5\" style=\"background-color:" . $hostile5 . "\"></td>
                <td id=\"hostile6\" style=\"background-color:" . $hostile6 . "\"></td>
                <td id=\"hostile7\" style=\"background-color:" . $hostile7 . "\"></td>
                <td id=\"hostile8\" style=\"background-color:" . $hostile8 . "\"></td>
                <td id=\"hostile9\" style=\"background-color:" . $hostile9 . "\"></td>
                <td id=\"hostile10\" style=\"background-color:" . $hostile10 . "\"></td>
            </tr>
        </table>";
} else {
	$dirtstresshtml = "";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Fare Chaser</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="title" content="Fare Chaser" />
    <meta name="description" content="Run a transportation business. A simple browser game that uses Google Maps." />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH3HjD-8oLQlmJwJ61hNc7NzCTrl94QT4&libraries=places"></script>
    <script>
        "use strict";

        let map;

        function initMap() {
            var myLatLng = new google.maps.LatLng(<?php echo $_SESSION["startLat"]; ?>, <?php echo $_SESSION["startLng"]; ?>);
            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 13
            });
            const marker = new google.maps.Marker({
                position: myLatLng,
                icon: 'car.png',
                map: map,
                draggable: false,
                title: "Player"
            });
            <?php echo $jscalculate; ?>
        }

        function calcRoute(result0) {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true});
            var start = document.getElementById('directionstart').value;
            var end = result0.geometry.location;
			document.getElementById("pickuploc").value = end;
            var request = {
                origin: start,
                destination: end,
                travelMode: 'DRIVING',
                unitSystem: google.maps.UnitSystem.IMPERIAL,
                avoidTolls: true
            };
            directionsRenderer.setMap(map);
            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                }
            });

            var service2 = new google.maps.DistanceMatrixService();
            service2.getDistanceMatrix(
                {
                    origins: [start],
                    destinations: [end],
                    travelMode: 'DRIVING',
                    unitSystem: google.maps.UnitSystem.IMPERIAL,
                    avoidTolls: true
                }, callback2
            );

            createMarker(end);
        }

        function createMarker(posn) {
            let newmark = new google.maps.Marker({
                position: posn,
                icon: {
                    url: '<?php echo $icony; ?>.png'<?php echo $scaledsize; ?>
                },
                map: map,
                draggable: false,
                title: "Destination"
            });
			
			const infowindow = new google.maps.InfoWindow({
				content: '<?php echo $_SESSION["paxhtml1"]; echo $_SESSION["paxhtml2"]; ?>',
				maxWidth: 200,
			});
			<?php echo $paxjava; ?>
			
        }

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) { calcRoute(results[1]); }
        }
        function callback2(response, status) {
            if (status == 'OK') {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                var origin = origins[1];
                var destination = destinations[<?php
					$desties = array(0,1,2,3);
					$rand_dest = array_rand($desties, 1);
					echo $rand_dest;
				?>];
                var elements = response.rows[0].elements;
                var dur = elements[0].duration.text;
                var durSecs = elements[0].duration.value;
                var durMins = durSecs / 60;
                var dis = elements[0].distance.text;

				document.getElementById("totaldistance").innerHTML = dis;
				document.getElementById("totalduration").innerHTML = dur;
				
				document.getElementById("senddis").value = dis;
				document.getElementById("senddur").value = dur;
                document.getElementById("skiptime").value = durMins;
            }
        }
    </script>
    <link rel="stylesheet" href="style.css" />
	<link rel="shortcut icon" type="image/png" href="favicon.png">
	<link rel="manifest" href="manifest.json">
</head>

<body>
<div id="map"></div>
<div id="theSettings">
    <div id="topFrame">
        <h1>FARE CHASER</h1><h2><a href="index.html">Restart</a></h2>
    </div>
    <div id="bottomFrame">
        <div><span></span></div>
        <table class="datatables">
            <tr>
                <td class="shifty">Current Time: <b><?php echo $formatdate; ?></b></td>
                <td class="shifty">Shift Ends: <b><?php echo $_SESSION["endshift"]; ?></b></td>
            </tr>
			<tr>
                <td class="shifty">Odometer: <b><?php echo $_SESSION["odometer"]; ?> miles</b></td>
                <td class="shifty">Earnings: <b>$<?php echo number_format($_SESSION["earnings"], 2, '.', ','); ?></b></td>
            </tr>
			<tr><td></td><td></td></tr>
            <tr>
                <td class="smol"><?php echo $strPass; ?></td>
                <td class="smol"><?php echo $strStuff; ?></td>
            </tr>
        </table>
		<?php echo $dirtstresshtml; ?>
        <?php echo $formhtml; ?>
        <div>
            <?php echo $_SESSION["messages"]; ?>
        </div>
    </div>
</div>
<script>
    initMap();
</script>
</body>
</html>