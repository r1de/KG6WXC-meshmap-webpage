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

$node_info_result = mysqli_query($sql_connection, "SELECT * FROM node_info") or die("Could not run node info query.");
$topology_info_result = mysqli_query($sql_connection, "SELECT * FROM topology") or die("Could not run topology query.");

//grab the polling info
$pollingInfo = array();
$q = mysqli_query($sql_connection, "SELECT * from map_info") or die("Could not run polling info query");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			$pollingInfo[$k] = $v;
		}
	}
}

//all the node info
$noRFDevices = array();
$nineDevices = array();
$twoDevices = array();
$threeDevices = array();
$fiveDevices = array();

$q = mysqli_query($sql_connection, "SELECT * FROM node_info WHERE meshRF = 'off' or channel = 'none'") or die("Could not run node info query.");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			if($k === "loadavg") {
				$loadavg = array();
				$loadavg = @unserialize($v);
				$row[$k] = $loadavg;
			}
			if($k === "services") {
				$services = array();
				$services = @unserialize($v);
				$row[$k] = $services;
			}
			if($k === "link_info") {
				$link_info = array();
				$link_info = @unserialize($v);
				$row[$k] = $link_info;
			}
		}
		$noRFDevices[] = $row;
	}
}

$q = mysqli_query($sql_connection, "SELECT * FROM node_info WHERE board_id = '0xe009' or board_id = '0xe1b9' or board_id = '0xe239'") or die("Could not run node info query.");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			if($k === "loadavg") {
				$loadavg = array();
				$loadavg = @unserialize($v);
				$row[$k] = $loadavg;
			}
			if($k === "services") {
				$services = array();
				$services = @nserialize($v);
				$row[$k] = $services;
			}
			if($k === "link_info") {
				$link_info = array();
				$link_info = @unserialize($v);
				$row[$k] = $link_info;
			}
		}
		$nineDevices[] = $row;
	}
}

$q = mysqli_query($sql_connection, "SELECT * FROM node_info WHERE channel <= 11 and channel != 'none'") or die("Could not run node info query.");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			if($k === "loadavg") {
				$loadavg = array();
				$loadavg = @unserialize($v);
				$row[$k] = $loadavg;
			}
			if($k === "services") {
				$services = array();
				$services = @unserialize($v);
				$row[$k] = $services;
			}
			if($k === "link_info") {
				$link_info = array();
				$link_info = @unserialize($v);
				$row[$k] = $link_info;
			}
		}
		$twoDevices[] = $row;
	}
}

$q = mysqli_query($sql_connection, "SELECT * FROM node_info WHERE (channel >= 76 and channel <= 99) or (channel >= 3000)") or die("Could not run node info query.");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			if($k === "loadavg") {
				$loadavg = array();
				$loadavg = @unserialize($v);
				$row[$k] = $loadavg;
			}
			if($k === "services") {
				$services = array();
				$services = @unserialize($v);
				$row[$k] = $services;
			}
			if($k === "link_info") {
				$link_info = array();
				$link_info = @unserialize($v);
				$row[$k] = $link_info;
			}
		}
		$threeDevices[] = $row;
	}
}

$q = mysqli_query($sql_connection, "SELECT * FROM node_info WHERE (channel >= 37 and channel <= 64) or (channel >= 100 and channel <= 184)") or die("Could not run node info query.");
if(mysqli_num_rows($q)) {
	while($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
		foreach($row as $k => $v) {
			if($k === "loadavg") {
				$loadavg = array();
				$loadavg = @unserialize($v);
				$row[$k] = $loadavg;
			}
			if($k === "services") {
				$services = array();
				$services = @unserialize($v);
				$row[$k] = $services;
			}
			if($k === "link_info") {
				$link_info = array();
				$link_info = @unserialize($v);
				$row[$k] = $link_info;
			}
		}
		$fiveDevices[] = $row;
	}
}

$allDevices = array();
$allDevices['noRF'] = $noRFDevices;
$allDevices['900'] = $nineDevices;
$allDevices['2ghz'] = $twoDevices;
$allDevices['3ghz'] = $threeDevices;
$allDevices['5ghz'] = $fiveDevices;

$info = "pollingInfo = " . json_encode($pollingInfo, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT) . ";\n";
$info .= "allDevices = " . json_encode($allDevices, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT) . ";";

header("Content-Type: text/javascript");
echo $info;
?>
