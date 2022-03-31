<?php
switch ($_SESSION["startDay"]) {
    case "Sunday":
        $daynum = "01";
        $passengers = [2,3,5];
        $strPass = "Worshipers,<br/>Errand Runners,<br/>Events";
		$custtypes = [ "Worship","Errand","Event" ];
        break;
    case "Monday":
        $daynum = "02";
        $passengers = [0,4,5];
        $strPass = "Commuters,<br/>Travelers,<br/>Errand Runners";
		$custtypes = [ "Commute","Travel","Errand" ];
        break;
    case "Tuesday":
        $daynum = "03";
        $passengers = [0,2,4];
        $strPass = "Commuters,<br/>Travelers,<br/>Events";
		$custtypes = [ "Commute","Travel","Event" ];
        break;
    case "Wednesday":
        $daynum = "04";
        $passengers = [1,3,5];
        $strPass = "Worshipers,<br/>Revelers,<br/>Commuters";
		$custtypes = [ "Worship","Revel","Commute" ];
        break;
    case "Thursday":
        $daynum = "05";
        $passengers = [2,3,4];
        $strPass = "Commuters,<br/>Errand Runners,<br/>Events";
		$custtypes = [ "Commute","Errand","Event" ];
        break;
    case "Friday":
        $daynum = "06";
        $passengers = [0,1,2];
        $strPass = "Travelers,<br/>Revelers,<br/>Events";
		$custtypes = [ "Travel","Revel","Event" ];
        break;
    case "Saturday":
        $daynum = "07";
        $passengers = [0,1,3];
        $strPass = "Worshipers,<br/>Revelers,<br/>Travelers";
		$custtypes = [ "Worship","Revel","Travel" ];
        break;
    default:
        $daynum = "01";
        $passengers = [2,3,5];
        $strPass = "Worshipers,<br/>Errand Runners,<br/>Events";
		$custtypes = [ "Worship","Errand","Event" ];
}

$custtypes = [ "Worship","Errand","Event","Revel","Travel","Commute" ];

switch (true) {
    case (( "00:00" <= $hourdate ) && ( $hourdate < "00:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "00:15" <= $hourdate ) && ( $hourdate < "00:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "00:30" <= $hourdate ) && ( $hourdate < "00:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "00:45" <= $hourdate ) && ( $hourdate < "01:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "01:00" <= $hourdate ) && ( $hourdate < "01:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "01:15" <= $hourdate ) && ( $hourdate < "01:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "01:30" <= $hourdate ) && ( $hourdate < "01:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "01:45" <= $hourdate ) && ( $hourdate < "02:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "02:00" <= $hourdate ) && ( $hourdate < "02:15" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "02:15" <= $hourdate ) && ( $hourdate < "02:30" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "02:30" <= $hourdate ) && ( $hourdate < "02:45" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "02:45" <= $hourdate ) && ( $hourdate < "03:00" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "03:00" <= $hourdate ) && ( $hourdate < "03:15" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "03:15" <= $hourdate ) && ( $hourdate < "03:30" )):
        $driverdemand = "Light";
        $passdemand = "Light";
        $demandstatus = "Balanced";
        break;
    case (( "03:30" <= $hourdate ) && ( $hourdate < "03:45" )):
        $driverdemand = "Light";
        $passdemand = "Light";
        $demandstatus = "Balanced";
        break;
    case (( "03:45" <= $hourdate ) && ( $hourdate < "04:00" )):
        $driverdemand = "Light";
        $passdemand = "Light";
        $demandstatus = "Balanced";
        break;
    case (( "04:00" <= $hourdate ) && ( $hourdate < "04:15" )):
        $driverdemand = "Light";
        $passdemand = "Light";
        $demandstatus = "Balanced";
        break;
    case (( "04:15" <= $hourdate ) && ( $hourdate < "04:30" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "04:30" <= $hourdate ) && ( $hourdate < "04:45" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "04:45" <= $hourdate ) && ( $hourdate < "05:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "05:00" <= $hourdate ) && ( $hourdate < "05:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "05:15" <= $hourdate ) && ( $hourdate < "05:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "05:30" <= $hourdate ) && ( $hourdate < "05:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "05:45" <= $hourdate ) && ( $hourdate < "06:00" )):
        $driverdemand = "Light";
        $passdemand = "Heavy";
        $demandstatus = "Heavy Surging";
        break;
    case (( "06:00" <= $hourdate ) && ( $hourdate < "06:15" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "06:15" <= $hourdate ) && ( $hourdate < "06:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "06:30" <= $hourdate ) && ( $hourdate < "06:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "06:45" <= $hourdate ) && ( $hourdate < "07:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Heavy";
        $demandstatus = "Surging";
        break;
    case (( "07:00" <= $hourdate ) && ( $hourdate < "07:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "07:15" <= $hourdate ) && ( $hourdate < "07:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "07:30" <= $hourdate ) && ( $hourdate < "07:45" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "07:45" <= $hourdate ) && ( $hourdate < "08:00" )):
        $driverdemand = "Light";
        $passdemand = "Heavy";
        $demandstatus = "Heavy Surging";
        break;
    case (( "08:00" <= $hourdate ) && ( $hourdate < "08:15" )):
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
        break;
    case (( "08:15" <= $hourdate ) && ( $hourdate < "08:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "08:30" <= $hourdate ) && ( $hourdate < "08:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "08:45" <= $hourdate ) && ( $hourdate < "09:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "09:00" <= $hourdate ) && ( $hourdate < "09:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "09:15" <= $hourdate ) && ( $hourdate < "09:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "09:30" <= $hourdate ) && ( $hourdate < "09:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "09:45" <= $hourdate ) && ( $hourdate < "10:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "10:00" <= $hourdate ) && ( $hourdate < "10:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "10:15" <= $hourdate ) && ( $hourdate < "10:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "10:30" <= $hourdate ) && ( $hourdate < "10:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "10:45" <= $hourdate ) && ( $hourdate < "11:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Light";
        $demandstatus = "Way Too Many Drivers";
        break;
    case (( "11:00" <= $hourdate ) && ( $hourdate < "11:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Light";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "11:15" <= $hourdate ) && ( $hourdate < "11:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "11:30" <= $hourdate ) && ( $hourdate < "11:45" )):
        $driverdemand = "Light";
        $passdemand = "Heavy";
        $demandstatus = "Heavy Surging";
        break;
    case (( "11:45" <= $hourdate ) && ( $hourdate < "12:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Heavy";
        $demandstatus = "Surging";
        break;
    case (( "12:00" <= $hourdate ) && ( $hourdate < "12:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "12:15" <= $hourdate ) && ( $hourdate < "12:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Light";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "12:30" <= $hourdate ) && ( $hourdate < "12:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Light";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "12:45" <= $hourdate ) && ( $hourdate < "13:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "13:00" <= $hourdate ) && ( $hourdate < "13:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Heavy";
        $demandstatus = "Surging";
        break;
    case (( "13:15" <= $hourdate ) && ( $hourdate < "13:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "13:30" <= $hourdate ) && ( $hourdate < "13:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "13:45" <= $hourdate ) && ( $hourdate < "14:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "14:00" <= $hourdate ) && ( $hourdate < "14:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "14:15" <= $hourdate ) && ( $hourdate < "14:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "14:30" <= $hourdate ) && ( $hourdate < "14:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "14:45" <= $hourdate ) && ( $hourdate < "15:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "15:00" <= $hourdate ) && ( $hourdate < "15:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "15:15" <= $hourdate ) && ( $hourdate < "15:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "15:30" <= $hourdate ) && ( $hourdate < "15:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "15:45" <= $hourdate ) && ( $hourdate < "16:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "16:00" <= $hourdate ) && ( $hourdate < "16:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "16:15" <= $hourdate ) && ( $hourdate < "16:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "16:30" <= $hourdate ) && ( $hourdate < "16:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "16:45" <= $hourdate ) && ( $hourdate < "17:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "17:00" <= $hourdate ) && ( $hourdate < "17:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "17:15" <= $hourdate ) && ( $hourdate < "17:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "17:30" <= $hourdate ) && ( $hourdate < "17:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "17:45" <= $hourdate ) && ( $hourdate < "18:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "18:00" <= $hourdate ) && ( $hourdate < "18:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "18:15" <= $hourdate ) && ( $hourdate < "18:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "18:30" <= $hourdate ) && ( $hourdate < "18:45" )):
        $driverdemand = "Moderate";
        $passdemand = "Moderate";
        $demandstatus = "Balanced";
        break;
    case (( "18:45" <= $hourdate ) && ( $hourdate < "19:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "19:00" <= $hourdate ) && ( $hourdate < "19:15" )):
        $driverdemand = "Moderate";
        $passdemand = "Heavy";
        $demandstatus = "Surging";
        break;
    case (( "19:15" <= $hourdate ) && ( $hourdate < "19:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "19:30" <= $hourdate ) && ( $hourdate < "19:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "19:45" <= $hourdate ) && ( $hourdate < "20:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "20:00" <= $hourdate ) && ( $hourdate < "20:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "20:15" <= $hourdate ) && ( $hourdate < "20:30" )):
        $driverdemand = "Moderate";
        $passdemand = "Heavy";
        $demandstatus = "Surging";
        break;
    case (( "20:30" <= $hourdate ) && ( $hourdate < "20:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "20:45" <= $hourdate ) && ( $hourdate < "21:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Light";
        $demandstatus = "Way Too Many Drivers";
        break;
    case (( "21:00" <= $hourdate ) && ( $hourdate < "21:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Light";
        $demandstatus = "Way Too Many Drivers";
        break;
    case (( "21:15" <= $hourdate ) && ( $hourdate < "21:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "21:30" <= $hourdate ) && ( $hourdate < "21:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Light";
        $demandstatus = "Way Too Many Drivers";
        break;
    case (( "21:45" <= $hourdate ) && ( $hourdate < "22:00" )):
        $driverdemand = "Moderate";
        $passdemand = "Light";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "22:00" <= $hourdate ) && ( $hourdate < "22:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "22:15" <= $hourdate ) && ( $hourdate < "22:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "22:30" <= $hourdate ) && ( $hourdate < "22:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Light";
        $demandstatus = "Way Too Many Drivers";
        break;
    case (( "22:45" <= $hourdate ) && ( $hourdate < "23:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "23:00" <= $hourdate ) && ( $hourdate < "23:15" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    case (( "23:15" <= $hourdate ) && ( $hourdate < "23:30" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "23:30" <= $hourdate ) && ( $hourdate < "23:45" )):
        $driverdemand = "Heavy";
        $passdemand = "Moderate";
        $demandstatus = "Too Many Drivers";
        break;
    case (( "23:45" <= $hourdate ) && ( $hourdate < "00:00" )):
        $driverdemand = "Heavy";
        $passdemand = "Heavy";
        $demandstatus = "Balanced";
        break;
    default:
        $driverdemand = "Light";
        $passdemand = "Moderate";
        $demandstatus = "Surging";
}

$strPass = "<table style=\"margin:0 auto 5px auto; border: 2px dotted #000; padding:10px; line-height: 150%;\"><tr><td><b>Today's Passengers</b></td></tr><tr><td>" . $strPass . "</td></tr></table>";

$strStuff = "                    <table style=\"width:auto; margin-right:0;float:right;border: 2px dotted #000; padding:1px;\">
                        <tr>
                            <td><b>Driver Supply</b></td>
                            <td id=\"x1\" style=\"text-align:right;\">" . $driverdemand . "</td>
                        </tr>
                        <tr><td colspan=\"2\"></td></tr>
                        <tr>
                            <td><b>Passenger Demand</b></td>
                            <td id=\"x2\" style=\"text-align:right;\">" . $passdemand . "</td>
                        </tr>
                        <tr><td colspan=\"2\"></td></tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td id=\"x3\" style=\"text-align:right;\">" . $demandstatus . "</td>
                        </tr>
                    </table>";
?>