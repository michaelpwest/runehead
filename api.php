<?
header("Content-type: text/plain");
$dblocation = '127.0.0.1';
$dbuser = 'runehead';
$dbpass = 'znBLDfKNA7Aj';
$db = 'rh_main';
$link = mysql_connect($dblocation, $dbuser, $dbpass);
mysql_select_db($db, $link);

if (!isset($_REQUEST["key"])) die("An API key is required.");

if ($_REQUEST["method"] == "addmember") {
		//include("updateaverages");
}

?>
