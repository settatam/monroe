<?php
//session_start(); //No need for a session currently?
//define('SITE_URL','https://www.tollbrothers.com/');
define('SITE_URL','http://monroe.localhost');

require_once('helper_class.php');
$helpers = new helpers;

//buildToggle gets replaced via gulp prepbuild/prepdev commands - can be manually adjusted if required.
$buildToggle = FALSE;


//cacheBusterNumber Updates automatically via the gulp prepbuild command - dont touch. It should look like this: $cacheBusterNumber="1462196632142";
$cacheBusterNumber="1462196632142";


//Base64 blank image src:
$blankImageSRC = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
$blackImageSRC = "data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=";


//set params from URL - ie. /pagename/param1/param2 <-- set in the .htaccess file.
$param1 = isset($_GET['param1']) ? $_GET['param1'] : "";
$param2 = isset($_GET['param2']) ? $_GET['param2'] : "";
$param3 = isset($_GET['param3']) ? $_GET['param3'] : "";
$param4 = isset($_GET['param4']) ? $_GET['param4'] : "";

//Get Site Data from Local JSON File:
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/comm_data.json");


//For testing purposes: (This should always be pointed to comm_data.json in production)
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/683.json"); //Porter Ranch
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/691.json"); //Toll Brothers at Robertson Ranch
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/74.json"); //HasenTree (master comm)
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/12411.json");  //Horsham Valley Estates (single comm)
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/10766.json"); // interactive photos - harding model
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/11107.json"); //HasenTree - Golf Villas Collection (single comm)
//$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/12412.json"); //HasenTree (master comm)

function getCommData($wsu) {
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$wsu);
	$result=curl_exec($ch);
	$_SESSION['comm_data'] = json_decode($result, true);
	return $_SESSION['comm_data'];
}

//$comm_data = json_decode($jsonFile, true);
$comm_data = getCommData('https://www.tollbrothers.com/api/mastercommunity/715');
$communityList = isset($comm_data['communityList']) ? $comm_data['communityList'] : array($comm_data);

$commDataObj = new commDataObj;
$commDataObj->initData($comm_data);

//Get Privacy, About, and Legal HTML from API based on file name:
$getPageServiceURL = "https://www.tollbrothers.com/api/pages/getPage?page=";
$pageName = basename($_SERVER['PHP_SELF']);

if ($pageName == "privacy.php") {
	$privacy_data = getPageData("privacy");
} elseif ($pageName == "about.php") {
	$about_data = getPageData("about");
} elseif ($pageName == "legal.php") {
	$legal_data = getPageData("legal");
}

function getPageData($thePage) {
	global $getPageServiceURL;
	$serviceURL = $getPageServiceURL . $thePage;
	$content = callAPI($serviceURL);
	return $content["contents"];
}

function callAPI($theURL) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$theURL);
	$result=curl_exec($ch);
	return json_decode($result, true);
}


function URLifyString($dirty) {
	$clean = str_replace(" ","-",str_replace(" - ","-",$dirty));

	return urlencode($clean);
}

function getCommOBJfromURL($commString) {
	$theComm = null;
	global $communityList;

	foreach ( $communityList as $community) {
		if(URLifyString($community['name']) == $commString) {
			$theComm = $community;
		}
	} 

	return $theComm;
}




//Saving this for future. Waiting on Seth's Class...
/*
$jsonIterator = new RecursiveIteratorIterator(
new RecursiveArrayIterator($comm_data),
RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
        echo "$key:<br/>";
    } else {
        echo "$key => $val<br/>";
    }
}
*/




?>