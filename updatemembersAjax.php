<?
session_start();
include_once("info.php");
include_once("auth.php");
$user = $auth->getUser();
$hosts = gethostbynamel('hiscore.runescape.com');
$ip = $hosts[1];

if (isset($_REQUEST["selectedmembers"]) && $_REQUEST["selectedmembers"] != ""){
	$updating = explode(",", $_REQUEST["selectedmembers"]);
	$numselected = sizeof($updating);
} else {
	$numselected = 0;
}

$totalnum = 0;
$totalcombat = 0;
$totalf2pcombat = 0;
$totalhp = 0;
$totalskill = 0;
$totalranged = 0;
$totalmagic = 0;

$percent = 0;
if ($numselected >= 1 && $numselected <= 100 && $user != ""){
	for ($a = 0; $a < $numselected; $a++){
		$updatingCurrent = explode("|", $updating[$a]);
		$rsn = $updatingCurrent[0];
		$stats = StatsToArray($rsn);
		if($stats != false) {
			$attack = $stats['attack'][1];
			$strength = $stats['strength'][1];
			$defence = $stats['defence'][1];
			$hitpoints = $stats['hitpoints'][1];
			$magic = $stats['magic'][1];
			$ranged = $stats['ranged'][1];
			$prayer = $stats['prayer'][1];
			$summoning = $stats['summoning'][1];

			if(((($attack + $strength) < ($magic * 1.5)) && ($ranged <= $magic))) {
				$combat = (0.325*1.5*$magic + 0.25*$defence + 0.25 * $hitpoints + 0.125 * $prayer + 0.125 * $summoning);
				$f2pcombat = (0.325*1.5*$magic + 0.25*$defence + 0.25 * $hitpoints + 0.125 * $prayer);
				$based = "Magic";
			} else if (((($attack + $strength)<($ranged * 1.5)) && ($magic < $ranged))) {
				$combat = (0.325 * 1.5 * $ranged + 0.25 * $defence + 0.25 * $hitpoints + 0.125 * $prayer + 0.125 * $summoning);
				$f2pcombat = (0.325 * 1.5 * $ranged + 0.25 * $defence + 0.25 * $hitpoints + 0.125 * $prayer);
				$based = "Ranged";
			} else {
				$combat = (0.325 * $attack + 0.325 * $strength + 0.25 * $defence + 0.25 * $hitpoints + 0.125 * $prayer + 0.125 * $summoning);
				$f2pcombat = (0.325 * $attack + 0.325 * $strength + 0.25 * $defence + 0.25 * $hitpoints + 0.125 * $prayer);
				$based = "Melee";
			}
			$combat_exp = explode(".", $combat);
			$combat_exp_dec = (!isset($combat_exp[1]) ? "0" : "0.".$combat_exp[1]);
			if ($prayer % 2 && $combat_exp_dec <= 0.10) {
				$combat = $combat - 0.101;
			}
			$f2pcombat_exp = explode(".", $f2pcombat);
			$f2pcombat_exp_dec = (!isset($f2pcombat_exp[1]) ? "0" : "0.".$f2pcombat_exp[1]);
			if ($prayer % 2 && $f2pcombat_exp_dec <= 0.10) {
				$f2pcombat = $f2pcombat - 0.101;
			}
			$magranends = array(0.0000, 0.0125, 0.0250, 0.0375, 0.0500, 0.0625, 0.0875, 0.1000, 0.1125, 0.1375, 0.1625, 0.1875, 0.2125, 0.2375, 0.2625);
			if (($prayer % 2) && ($based == 'Magic' || $based == 'Ranged')) {
				for($i = 0; $i < 15; $i++) {
					if($combat_exp_dec == $magranends[$i]) $combat = $combat - 0.2626;
				}
			} else if (($prayer % 2 == 0) && ($based == 'Magic' || $based == 'Ranged') && in_array($combat_exp_dec, $magranends)) {
				$combat_exp = explode(".", $combat);
				$combat = $combat_exp[0];
			}
			if (($prayer % 2) && ($based == 'Magic' || $based == 'Ranged')) {
				for($i = 0; $i < 15; $i++) {
					if($f2pcombat_exp_dec == $magranends[$i]) $f2pcombat = $f2pcombat - 0.2626;
				}
			} else if (($prayer % 2 == 0) && ($based == 'Magic' || $based == 'Ranged') && in_array($f2pcombat_exp_dec, $magranends)) {
				$f2pcombat_exp = explode(".", $f2pcombat);
				$f2pcombat = $f2pcombat_exp[0];
			}
			if ($combat < 3){
				$combat = 3;
			}
			if ($f2pcombat < 3){
				$f2pcombat = 3;
			}
			$combat = round($combat, 2);
			$f2pcombat = round($f2pcombat, 2);

			$highskill = 'None';
			$highskillexp = 0;
			foreach($stats as $stat => $value) {
				if ($stat != 'dueltournament' && $stat != 'bountyhunters' && $stat != 'bountyhunterrogues' && $stat != 'fistofguthix' && $stat != 'mobilisingarmies' && $stat != 'baattackers' && $stat != 'badefenders' && $stat != 'bacollectors' && $stat != 'bahealers' && $stat != 'castlewarsgames'){
					if($stats[$stat][2] > $highskillexp && $stat != 'overall') {
						$highskill = $stats[$stat][1]." ".ucwords($stat);
						$highskillexp = $stats[$stat][2];
					}
				}
			}
			$sql = "UPDATE MEMBERS SET
					overall = '{$stats['overall'][1]}',
					overallxp = '{$stats['overall'][2]}',
					overallrank = '{$stats['overall'][0]}',
					attack = '{$stats['attack'][2]}',
					attackrank = '{$stats['attack'][0]}',
					defence = '{$stats['defence'][2]}',
					defencerank = '{$stats['defence'][0]}',
					strength = '{$stats['strength'][2]}',
					strengthrank = '{$stats['strength'][0]}',
					hitpoints = '{$stats['hitpoints'][2]}',
					hitpointsrank = '{$stats['hitpoints'][0]}',
					ranged = '{$stats['ranged'][2]}',
					rangedrank = '{$stats['ranged'][0]}',
					prayer = '{$stats['prayer'][2]}',
					prayerrank = '{$stats['prayer'][0]}',
					magic = '{$stats['magic'][2]}',
					magicrank = '{$stats['magic'][0]}',
					cooking = '{$stats['cooking'][2]}',
					cookingrank = '{$stats['cooking'][0]}',
					woodcutting = '{$stats['woodcutting'][2]}',
					woodcuttingrank = '{$stats['woodcutting'][0]}',
					fletching = '{$stats['fletching'][2]}',
					fletchingrank = '{$stats['fletching'][0]}',
					fishing = '{$stats['fishing'][2]}',
					fishingrank = '{$stats['fishing'][0]}',
					firemaking = '{$stats['firemaking'][2]}',
					firemakingrank = '{$stats['firemaking'][0]}',
					crafting = '{$stats['crafting'][2]}',
					craftingrank = '{$stats['crafting'][0]}',
					smithing = '{$stats['smithing'][2]}',
					smithingrank = '{$stats['smithing'][0]}',
					mining = '{$stats['mining'][2]}',
					miningrank = '{$stats['mining'][0]}',
					herblore = '{$stats['herblore'][2]}',
					herblorerank = '{$stats['herblore'][0]}',
					agility = '{$stats['agility'][2]}',
					agilityrank = '{$stats['agility'][0]}',
					thieving = '{$stats['thieving'][2]}',
					thievingrank = '{$stats['thieving'][0]}',
					slayer = '{$stats['slayer'][2]}',
					slayerrank = '{$stats['slayer'][0]}',
					farming = '{$stats['farming'][2]}',
					farmingrank = '{$stats['farming'][0]}',
					runecraft = '{$stats['runecraft'][2]}',
					runecraftrank = '{$stats['runecraft'][0]}',
					hunter = '{$stats['hunter'][2]}',
					hunterrank = '{$stats['hunter'][0]}',
					construction = '{$stats['construction'][2]}',
					constructionrank = '{$stats['construction'][0]}',
					summoning = '{$stats['summoning'][2]}',
					summoningrank = '{$stats['summoning'][0]}',
					dungeoneering = '{$stats['dungeoneering'][2]}',
					dungeoneeringrank = '{$stats['dungeoneering'][0]}',
					`duel tournament` = '{$stats['dueltournament'][1]}',
					`duel tournamentrank` = '{$stats['dueltournament'][0]}',					
					`bounty hunters` = '{$stats['bountyhunters'][1]}',
					`bounty huntersrank` = '{$stats['bountyhunters'][0]}',					
					`bounty hunter rogues` = '{$stats['bountyhunterrogues'][1]}',
					`bounty hunter roguesrank` = '{$stats['bountyhunterrogues'][0]}',
					`fist of guthix` = '{$stats['fistofguthix'][1]}',
					`fist of guthixrank` = '{$stats['fistofguthix'][0]}',
					`mobilising armies` = '{$stats['mobilisingarmies'][1]}',
					`mobilising armiesrank` = '{$stats['mobilisingarmies'][0]}',
					`ba attackers` = '{$stats['baattackers'][1]}',
					`ba attackersrank` = '{$stats['baattackers'][0]}',
					`ba defenders` = '{$stats['badefenders'][1]}',
					`ba defendersrank` = '{$stats['badefenders'][0]}',
					`ba collectors` = '{$stats['bacollectors'][1]}',
					`ba collectorsrank` = '{$stats['bacollectors'][0]}',
					`ba healers` = '{$stats['bahealers'][1]}',
					`ba healersrank` = '{$stats['bahealers'][0]}',
					`castle wars games` = '{$stats['castlewarsgames'][1]}',
					`castle wars gamesrank` = '{$stats['castlewarsgames'][0]}',
					combat = '{$combat}',
					f2pcombat = '{$f2pcombat}',
					topskill = '{$highskill}'
					WHERE RSN = '$rsn'
					AND USERNAME = '$user'";
			@mysql_query($sql);	
			$totalnum++;
			$totalcombat += $combat;
			$totalf2pcombat += $f2pcombat;
			$totalhp += $stats['hitpoints'][1];
			$totalskill += $stats['overall'][1];
			$totalranged += $stats['ranged'][1];
			$totalmagic += $stats['magic'][1];
		}
		$increment = 100 / sizeof($updating);
		$percent += $increment;
		if ($a + 1 == sizeof($updating)){
			echo "<span class='success' style='z-index: $a; position: absolute; background-color: #727272;'>Memberlist Updated</span>";
		} else {
			echo "<span class='success' style='z-index: $a; position: absolute; background-color: #727272;'>" . number_format($percent, 0) . "% completed</span>";
		}
		ob_flush();
		flush();
	}
	echo "<br />";
	$updatetime = gmdate("Y-m-d h:i:s");
	$sql = "UPDATE USERS SET
			UPDATETIME = '$updatetime'
			WHERE username = '$user'";
	@mysql_query($sql);
	include_once("updateaverages.php");
} else {
	echo "Please select 1-100<br />members to update<br />";
}

function StatsToArray($playername) {
	unset($theskills);
	if(trim($playername) != '') {
		$text = http_socket('hiscore.runescape.com', '/index_lite.ws?player='.$playername);	
		if(!$text){
			return false;
		}
		if(substr_count($text, "404 - Page not found") == 0 && strlen($text) > 300) {
			$skills = "none|overall|attack|defence|strength|hitpoints|ranged|prayer|magic|cooking|woodcutting|fletching|fishing|firemaking|crafting|smithing|mining|herblore|agility|thieving|slayer|farming|runecraft|hunter|construction|summoning|dungeoneering|dueltournament|bountyhunters|bountyhunterrogues|fistofguthix|mobilisingarmies|baattackers|badefenders|bacollectors|bahealers|castlewarsgames";
			$cleanup = str_replace(',', ' ', $text);
			$cleanup = explode("\r\n\r\n", $cleanup);
			$cleanup = explode("\n", $cleanup[1]);
			$skillarr = explode("|", $skills);
			for($i = 1; $i < count($skillarr); $i++) {
				$left[$i] = explode(' ', $cleanup[$i - 1]);
				if (substr_count($skillarr[$i], "dueltournament") > 0 || substr_count($skillarr[$i], "bountyhunter") > 0 || substr_count($skillarr[$i], "bountyhunterrogues") > 0 || substr_count($skillarr[$i], "fistofguthix") > 0 || substr_count($skillarr[$i], "mobilisingarmies") > 0 || substr_count($skillarr[$i], "baattackers") > 0 || substr_count($skillarr[$i], "badefenders") > 0 || substr_count($skillarr[$i], "bacollectors") > 0 || substr_count($skillarr[$i], "bahealers") > 0 || substr_count($skillarr[$i], "castlewarsgames") > 0){
					if ($left[$i][0] == -1 || $left[$i][1] == -1){
						$left[$i][0] = 0;
						$left[$i][1] = 0;
					}
				} else {
					if ($left[$i][0] == -1 || $left[$i][1] == -1 || $left[$i][2] == -1){
						$left[$i][0] = 0;
						$left[$i][1] = 1;
						$left[$i][2] = 0;
					}				
				}
				$theskills[$skillarr[$i]] = $left[$i];
			}
		}
	}
	if(!isset($theskills)) {
		$theskills = false;
	}
	return $theskills;
}

function http_socket($host, $file, $socktimeout=5)  {	
	global $con, $version, $ip, $stime;
	$header = "GET {$file} HTTP/1.0
	Accept: text/html
	Host: {$host}
	Connection: Close
	User-Agent: RSHSC AutoUpdater/{$version}\r\n\r\n";
	$con = fsockopen($ip, '80', $errno, $errstr, $socktimeout);
	stream_set_timeout($con, $socktimeout);	
	fwrite($con, $header);
	$in = '';
	while (!feof($con)) {
		$in .= fread($con,65565);
	}
	fclose($con);
	return $in;
}
?>