<?
date_default_timezone_set("Europe/London");
// If info.php file is accessed directly, redirect to index.php
if (substr($_SERVER["PHP_SELF"], -8, 8) == 'info.php'){
	echo "<meta http-equiv='Refresh' content='0; url=index.php'>";	
	exit();
}

//$dblocation = '10.212.17.6';
$dblocation = '127.0.0.1';
$dbuser = 'runehead_runehea';
$dbpass = 'znBLDfKNA7Aj';
$db = 'runehead_main';
$masterPassVar = 'a185588f3438669802ce3bba4421a392';
$link = mysql_connect($dblocation, $dbuser, $dbpass);
@mysql_select_db($db, $link);

$skills = array('Overall','Attack','Defence','Strength','Hitpoints','Ranged','Prayer','Magic','Cooking','Woodcutting','Fletching','Fishing','Firemaking','Crafting','Smithing','Mining','Herblore','Agility','Thieving','Slayer','Farming','Runecraft','Hunter','Construction','Summoning','Dungeoneering','Duel Tournament','Bounty Hunters','Bounty Hunter Rogues','Fist of Guthix','Mobilising Armies','BA Attackers','BA Defenders','BA Collectors','BA Healers','Castle Wars Games');
$categories = array('', 'Official Clan List', 'Future Applicant List', 'Pest Control Group', 'Soul Wars Group', 'God Wars Dungeon Group', 'Castle Wars Group', 'Country Listing', 'Website Staff / Members', 'Miscellaneous');

function check_if_contains($form_value,$value_to_search,$allow_zero){
	$form_error = 1;
	$form_error_real = 0;
	$value_length = strlen($form_value);
	for ($loop = 0; $loop < $value_length; $loop++){
		$parts = $form_value[$loop];
		if (strcmp($parts,'0') != 0) {
			$tok = strtok($value_to_search,'|');
			while ($tok) {
				$value_check = substr_count($parts,$tok);
				$tok = strtok('|');
				if ($value_check == 1) {
					$form_error = 0;
					$value_check = 0;
					break;
				} else {
					$form_error = 1;
				}
			}
			if ($form_error == 1) {
				return true;
			}
		}
		else {
			if ($allow_zero != 1) {
				return true;
			}
		}
	}
}
function generatePassword ($length = 8){
	$password = '';
	$possible = '0123456789bcdfghjkmnpqrstvwxyz';
	$i = 0;
	while ($i < $length){
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($password, $char)) {
			$password .= $char;
			$i++;
		}
	}
	return $password;
}
function levelXP($exp, $skill = ""){
	if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix" || strtolower($skill) == "mobilising armies" || strtolower($skill) == "ba attackers" || strtolower($skill) == "ba defenders" || strtolower($skill) == "ba collectors" || strtolower($skill) == "ba healers" || strtolower($skill) == "castle wars games"){
		return "-";
	}
	$points = 0;
	$output = 0;
	for ($lvl = 1; $lvl <= 150; $lvl++){
		$points = $points + floor($lvl + 300 * pow(2, $lvl / 7.));
		if ($lvl >= 1){
			if ($output > $exp){
				$lvl = $lvl - 1;
				if ($lvl == '0'){
					return '1';
				} else if ($lvl > '99'){
					return '99';
				}
				else {
					return $lvl;
				}
			}
			$output = floor($points / 4);
		}
	}
	return 0;
}
function flipdate($date, $showTime = true){
	$time = substr($date, -8, 8);
	$date = substr($date, 0, 10);
	$date = explode("-", $date);
	$date = $date[2] . "-" . $date[1] . "-" . $date[0];
	if ($showTime){
		$date .= " " . $time;
	}
	return $date;
}
function cleanName($name) {
	$name = stripcslashes($name);
	$name = preg_replace('/[^a-z0-9]/i', ' ', $name);
	$name = ucwords(strtolower(str_replace('_', ' ', $name)));
	return substr(str_replace(' ', '_', $name), 0, 12);
}
?>
