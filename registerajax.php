<?
include_once ("info.php");

$requestedusername = @mysql_escape_string($_REQUEST["requestedusername"]);
$requestedclanname = @mysql_escape_string($_REQUEST["requestedclanname"]);
$requestedurl = @mysql_escape_string($_REQUEST["requestedurl"]);
$requestedemail = @mysql_escape_string($_REQUEST["requestedemail"]);
$error = 0;
$msg = "";

$sql = "SELECT USERNAME
		FROM USERS
		WHERE USERNAME = '$requestedusername'";
$result = @mysql_query($sql);
if (@mysql_num_rows($result) > 0){
	$msg .= "Username is already is use<br />";
	$error = 1;
}
$sql = "SELECT USERNAME
		FROM USERS
		WHERE EMAIL = '$requestedemail'";
$result = @mysql_query($sql);
if (@mysql_num_rows($result) > 0){
	$msg .= "Email address is already is use<br />";
	$error = 1;
}

if (check_if_contains($requestedusername,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K|L" .
										 "|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|_",1) == true){
	$msg .= "<span style='color: #ffd700;'>Memberlist username can only contain Letters, Digits or _</span><br />";
	$error = 1;
}
if ($requestedclanname && check_if_contains($requestedclanname,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
															   "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
															   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| ",1) == true){
	$msg .= "<span style='color: #ffd700;'>Clan / group name can only contain letters or numbers</span><br />";
	$error = 1;
}
if (($requestedurl && substr($requestedurl, 0, 7) != "http://") && ($requestedurl && substr($requestedurl, 0, 8) != "https://")){
	$msg .= "<span style='color: #ffd700;'>Website needs a 'http://' or 'https://' at the start</span><br />";
	$error = 1;
}
if ($requestedusername && strlen($requestedusername) < 4){
	$msg .= "<span style='color: #ffd700;'>Memberlist username must be at least 4 letters long</span><br />";
	$error = 1;
}
if ($requestedusername && strlen($requestedusername) > 12){
	$msg .= "<span style='color: #ffd700;'>Memberlist username must be less then 12 letters long</span><br />";
	$error = 1;
}
$email_check = substr_count($requestedemail, "@");
$email_check2 = substr_count($requestedemail, ".");	
if ($requestedemail && ($email_check == 0 || $email_check2 == 0)){
	$msg .= "<span style='color: #ffd700;'>Email address format incorrect</span><br />";
	$error = 1;
}
if ($error == 1){
	echo $msg;
}
?>