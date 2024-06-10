<?php

$INCLUDE_DIR = "/home/kg6wxc/KG6WXC-meshmap";
//$INCLUDE_DIR = "/home/ride/KG6WXC-meshmap";
require $INCLUDE_DIR . "/include/mysqlFunctions.inc";

global $USER_SETTINGS;

//load defaults into $USER_SETTINGS
if (file_exists($INCLUDE_DIR . "/settings/user-settings.ini-default")) {
        $DEFAULT_USER_SETTINGS = parse_ini_file($INCLUDE_DIR . "/settings/user-settings.ini-default");
}else {
        exit("settings/user-settings.ini-default is missing!\n\n");
}
 
//check for users custom settings
if (file_exists($INCLUDE_DIR . "/settings/user-settings.ini")) {
        $USER_SETTINGS = parse_ini_file($INCLUDE_DIR . "/settings/user-settings.ini");
}else {
        exit("\n\nYou **must** copy the user-settings.ini-default file to user-settings.ini and edit it!!\n\n");
}

//merge default settings and users custom settings
$USER_SETTINGS = array_merge($DEFAULT_USER_SETTINGS, $USER_SETTINGS);

$sql_connection = wxc_connectToMySQL();

$node_info_result = mysqli_query($sql_connection, "SELECT * FROM node_info where node is not null") or die("Could not run node info query.");

$allDevices = array();

if(mysqli_num_rows($node_info_result)) {
	while($row = mysqli_fetch_array($node_info_result, MYSQLI_ASSOC)) {
		$allDevices['data'][] = $row;
	}
}

header("Content-Type: application/json");
//echo "allDevices: " . json_encode($allDevices, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT) . ";";
echo json_encode($allDevices);
?>
