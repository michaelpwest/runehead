<?
$showArray = array(138, 137, 136, 135, 134, 133, 132, 131, 130, 129, 128, 127, 126, 125, 124, 123, 122, 121, 120, 115, 110, 105, 100, 90, 80, 70, 60, 50);
$colourarray = array("", "#000000", "#8B0000", "#006400", "#00008B", "#DAA520", "#8B008B", "#008B8B", "#FF8C00", "#DF8090", "#555555", "#20B2AA", "#C71585", "#7B68EE", "#808000", "#A0522D", "#DC143C");
include_once("flagsinclude.php");

$sql = "SELECT U.USERNAME, U.ACTIVE, U.VALIDATED, U.CLANTYPE, U.CATEGORY, U.UPDATETIME,
		U.CLANNAME, U.CLANIMAGE, U.WEBSITE, U.IRC, U.DISPLAYTYPE, U.FONTFAMILY, U.BGCOLOUR,
		U.TABLECOLOUR, U.FONTCOLOUR1, U.FONTCOLOUR2, U.HEADERFONT, U.HEADERBG, U.BORDERCOLOUR,
		U.PERSONALFONT, U.PLAYBASE, U.TIMEBASE, U.CAPECOLOUR, U.HOMEWORLD, U.INITIALS,
		A.*, R.*
		FROM USERS U, AVERAGES A, RANKS R
		WHERE U.USERNAME = A.USERNAME
		AND R.USERNAME = A.USERNAME
		AND U.USERNAME = '$clan'";
$result = @mysql_query($sql);
$row = @mysql_fetch_array($result);
$username = $row["USERNAME"];
if (@mysql_num_rows($result) > 0){
	$active = $row["ACTIVE"];
	$validated = $row["VALIDATED"];
} else {
	$active = 2;
	$validated = 2;
}
$clantype = $row["CLANTYPE"];
if ($clantype == "clan"){
	$clantype = "Clan";
} else {
	$clantype = "Non-Clan";
}
$category = $row["CATEGORY"];
$updatetime = $row["UPDATETIME"];
if ($updatetime != "0000-00-00 00:00:00"){
	$updatetime = date("jS M Y", strtotime($updatetime));
} else {
	$updatetime = "None";
}
$clanname = $row["CLANNAME"];
if (substr_count($row["CLANIMAGE"], "http://") > 0){
	$clanimage = $row["CLANIMAGE"];
} else {
	$clanimage = "banners/" . $row["CLANIMAGE"];
}
if (!@fclose(@fopen($clanimage, "r")) || $clanimage == "banners/") {
	$clanimage = "";
}
$website = $row["WEBSITE"];
$irc = $row["IRC"];
if (strlen($website) > 20){
	$websiteDisplay = substr($website, 0, 20);
	$websiteDisplay .= "...";
} else {
	$websiteDisplay = $website; 
}
if (strlen($irc) > 18){
	$ircDisplay = substr($irc, 0, 18);
	$ircDisplay .= "...";
} else {
	$ircDisplay = $irc; 
}
if ((substr($irc, 0, 7) != "http://") && (substr($irc, 0, 8) != "https://")){
	$irc = "http://" . $irc;
}
$displaytype = $row["DISPLAYTYPE"];
$fontfamily = $row["FONTFAMILY"];
if ($fontfamily == "tahoma" || $fontfamily == "arial"){
	$fontsize = "12px";
} else {
	$fontfamily = "verdana";
	$fontsize = "11px";
}
$bgcolour = $row["BGCOLOUR"];
$tablecolour = $row["TABLECOLOUR"];
$fontcolour1 = $row["FONTCOLOUR1"];
$fontcolour2 = $row["FONTCOLOUR2"];
$headerfont = $row["HEADERFONT"];
$headerbg = $row["HEADERBG"];
$bordercolour = $row["BORDERCOLOUR"];
$personalfont = $row["PERSONALFONT"];
if ($personalfont == 1){
	$personalfont = $fontcolour1;
} else {
	$personalfont = $fontcolour2;
}

$playbase = $row["PLAYBASE"];
if ($playbase == "none" || $playbase == ""){
	$playbase = "Not Set";
} else if ($playbase == "f2p"){
	$playbase = "F2P Based";
} else if ($playbase == "p2p"){
	$playbase = "P2P Based";
} else if ($playbase == "f2pp2p"){
	$playbase = "F2P &amp; P2P Based";
}

$timebase = $row["TIMEBASE"];
if ($timebase == "all" || $timebase == ""){
	$timebase = "Not Set";
} else if ($timebase == "worldwide"){
	$timebase = "Worldwide";
} else if ($timebase == "usa"){
	$timebase = "America";
} else if ($timebase == "europe"){
	$timebase = "Europe";
} else if ($timebase == "australasia"){
	$timebase = "Asia-Pacific";
} else if ($timebase == "usaeur"){
	$timebase = "America &amp; Europe";
} else if ($timebase == "usaaus"){
	$timebase = "America &amp; Asia-Pacific";
} else if ($timebase == "euraus"){
	$timebase = "Europe &amp; Asia-Pacific";
}

$capecolour = $row["CAPECOLOUR"];
if ($capecolour == "none" || $capecolour == ""){
	$capecolour = "Not Set";
} else {
	$capecolour = str_replace("Wilderness", "Wilderness Cape ", ucwords($capecolour));
}

$homeworld = $row["HOMEWORLD"];
if ($homeworld == 0) {
	$homeworld = "Not Set";
	$flagimage = "None";	
	$homeworldDisplay = "Not Set";	
} else {
	$flagimage = $flag[$homeworld];
	if ($flagimage != ""){
		$homeworldDisplay = "$homeworld <img src='images/flags/$flagimage.png' alt='' title='$flagnames[$flagimage]' style='vertical-align: middle; padding-bottom: 1px;' />";
	} else {
		$homeworldDisplay = "$homeworld";
	}
}

$initials = $row["INITIALS"];
if ($initials == "") {
	$initials = "Not Set";
}

$numbermembers = $row["NUMBERMEMBERS"];
$f2pcmbavg = $row["F2PCMBAVG"];
$cmbavg = $row["CMBAVG"];
$hpavg = $row["HPAVG"];
$skillavg = number_format($row["SKILLAVG"]);
$magicavg = $row["MAGICAVG"];
$rangedavg = $row["RANGEDAVG"];

if (isset($_REQUEST["style"])){
	$style = $_REQUEST["style"];	
	if ($style == "default"){
		$_SESSION["style"] = "";
	}
} else {
	$style = "";
}
if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
	$_SESSION["style"] = "simple";
	$bgcolour = "#000000";
	$tablecolour = "#000000";
	$fontcolour1 = "#FFFFFF";
	$fontcolour2 = "#FFFFFF";
	$fontfamily = "verdana";
	$fontsize = "11px";
	$headerfont = "#FFFFFF";
	$headerbg = "#222222";
	$bordercolour = "#404040";
	$personalfont = "#FFFFFF";
	$displaytype = 0;
	$clanimage = "";
} else {
	$_SESSION["style"] = "";
}

for ($a = 1; $a <= 16; $a++){
	${"rank$a"} = $row["RANK$a"];
	if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
		${"rank" . $a . "colour"} = $colourarray[$a];
	} else {
		${"rank" . $a . "colour"} = $row["RANK" . $a . "COLOUR"];
	}
}

function getCurrentPage()
{
	//return "http://www.runehead.com/clans/ml.php?".$_SERVER['QUERY_STRING'];
	return $_GET['clan'];
}
?>
