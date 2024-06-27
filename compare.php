<?
include_once ("../design/top.php");
echo "<script src='compareAjax.js' type='text/javascript'></script>";
if (isset($_REQUEST["compare"]) && $_REQUEST["compare"] == true){
	$username1 = @mysql_escape_string($_REQUEST["username1"]);
	$username2 = @mysql_escape_string($_REQUEST["username2"]);
	$username3 = @mysql_escape_string($_REQUEST["username3"]);
	$username4 = @mysql_escape_string($_REQUEST["username4"]);
	$username5 = @mysql_escape_string($_REQUEST["username5"]);

	$sql = "SELECT USERNAME, CLANNAME, INITIALS
			FROM USERS
			WHERE (USERNAME = '$username1'
			OR USERNAME = '$username2'
			OR USERNAME = '$username3'
			OR USERNAME = '$username4'
			OR USERNAME = '$username5')";
	$result = @mysql_query($sql);
	
	if (isset($_REQUEST["compareType"])){
		$compareType= $_REQUEST["compareType"];
	}
	$numclans = 0;
	$maxNumbermembers = 0;
	$maxCmbAvg = 0;
	$maxF2pCmbAvg = 0;	
	$maxSkillAvg = 0;
	$sql = "SELECT MAX(A.NUMBERMEMBERS) AS MAXNUMBERMEMBERS, MAX(A.CMBAVG) AS MAXCMBAVG, MAX(A.F2PCMBAVG) AS MAXF2PCMBAVG, MAX(A.SKILLAVG) AS MAXSKILLAVG
			FROM AVERAGES A
			WHERE (";
	for ($a = 1; $a <= 5; $a++){
		if (${"username{$a}"} != ""){
			if ($numclans > 0){
				$sql .= "OR ";
			} else {
				$numclans++;
			}
			$sql .= "A.USERNAME = '" . ${"username{$a}"} . "' ";
		}
	}
	$sql .= ")";
	$maxResult = @mysql_query($sql);
	$maxRow = @mysql_fetch_array($maxResult);
	$maxNumbermembers = $maxRow["MAXNUMBERMEMBERS"];
	$maxCmbAvg = $maxRow["MAXCMBAVG"];
	$maxF2pCmbAvg = $maxRow["MAXF2PCMBAVG"];	
	$maxSkillAvg = $maxRow["MAXSKILLAVG"];
	
	if ($compareType == "all"){
		for ($a = 1; $a < sizeof($skills); $a++){
			${"max{$skills[$a]}Avg"} = 0;
		}
		$numclans = 0;
		for ($a = 1; $a <= 5; $a++){
			for ($b = 1; $b < sizeof($skills); $b++){
				${"{$skills[$b]}Avg"} = 0;
			}
			if (${"username{$a}"} != "") {
				$sql2 = "SELECT ";
				for ($b = 1; $b < sizeof($skills); $b++){
					$sql2 .= "`" . strtoupper($skills[$b]) . "`";
					if ($b < (sizeof($skills) - 1)){
						$sql2 .= ", ";
					}
				}
				$sql2 .= " FROM MEMBERS
						  WHERE USERNAME = '" . ${"username{$a}"} . "'";
				$result2 = @mysql_query($sql2);
				$num = 0;
				while ($row2 = @mysql_fetch_array($result2)){
					for ($b = 1; $b < sizeof($skills); $b++){
						if (strtolower($skills[$b]) != "duel tournament" && strtolower($skills[$b]) != "bounty hunters" && strtolower($skills[$b]) != "bounty hunter rogues" && strtolower($skills[$b]) != "fist of guthix"){
							${"{$skills[$b]}Avg"} += levelXP($row2[strtoupper($skills[$b])]);
						} else {
							${"{$skills[$b]}Avg"} += $row2[strtoupper($skills[$b])];
						}
					}
					$num++;
				}
				if ($num > 0){
					for ($b = 1; $b < sizeof($skills); $b++){
						${"{$skills[$b]}Avg"} = round(${"{$skills[$b]}Avg"} / $num, 2);
						if (${"{$skills[$b]}Avg"} > ${"max{$skills[$b]}Avg"}){
							${"max{$skills[$b]}Avg"} = ${"{$skills[$b]}Avg"};
						}
					}
				}
			}
		}
	} else {
		$maxAttackAvg = 0;
		$maxDefenceAvg = 0;
		$maxStrengthAvg = 0;
		$maxHitpointsAvg = 0;
		$maxRangedAvg = 0;
		$maxPrayerAvg = 0;
		$maxMagicAvg = 0;
		$maxSummoningAvg = 0;
	
		$numclans = 0;
		for ($a = 1; $a <= 5; $a++){
			$attackAvg = 0;
			$defenceAvg = 0;
			$strengthAvg = 0;
			$hitpointsAvg = 0;
			$rangedAvg = 0;
			$prayerAvg = 0;
			$magicAvg = 0;
			$summoningAvg = 0;
			if (${"username{$a}"} != "") {
				$sql2 = "SELECT ATTACK, DEFENCE, STRENGTH, HITPOINTS, RANGED, PRAYER, MAGIC, SUMMONING
						 FROM MEMBERS
						 WHERE USERNAME = '" . ${"username{$a}"} . "'";
				$result2 = @mysql_query($sql2);
				$num = 0;
				while ($row2 = @mysql_fetch_array($result2)){
					$attackAvg += levelXP($row2["ATTACK"]);
					$defenceAvg += levelXP($row2["DEFENCE"]);
					$strengthAvg += levelXP($row2["STRENGTH"]);
					$hitpointsAvg += levelXP($row2["HITPOINTS"]);
					$rangedAvg += levelXP($row2["RANGED"]);
					$prayerAvg += levelXP($row2["PRAYER"]);
					$magicAvg += levelXP($row2["MAGIC"]);
					$summoningAvg += levelXP($row2["SUMMONING"]);
					$num++;
				}
				if ($num > 0){
					$attackAvg = round($attackAvg / $num, 2);
					if ($attackAvg > $maxAttackAvg){
						$maxAttackAvg = $attackAvg;
					}
					$defenceAvg = round($defenceAvg / $num, 2);
					if ($defenceAvg > $maxDefenceAvg){
						$maxDefenceAvg = $defenceAvg;
					}
					$strengthAvg = round($strengthAvg / $num, 2);
					if ($strengthAvg > $maxStrengthAvg){
						$maxStrengthAvg = $strengthAvg;
					}
					$hitpointsAvg = round($hitpointsAvg / $num, 2);
					if ($hitpointsAvg > $maxHitpointsAvg){
						$maxHitpointsAvg = $hitpointsAvg;
					}
					$rangedAvg = round($rangedAvg / $num, 2);
					if ($rangedAvg > $maxRangedAvg){
						$maxRangedAvg = $rangedAvg;
					}
					$prayerAvg = round($prayerAvg / $num, 2);
					if ($prayerAvg > $maxPrayerAvg){
						$maxPrayerAvg = $prayerAvg;
					}
					$magicAvg = round($magicAvg / $num, 2);
					if ($magicAvg > $maxMagicAvg){
						$maxMagicAvg = $magicAvg;
					}
					$summoningAvg = round($summoningAvg / $num, 2);
					if ($summoningAvg > $maxSummoningAvg){
						$maxSummoningAvg = $summoningAvg;
					}
				}
			}
		}
	}
echo "
<div class='main'>
  <form action='' method='get'>
    <h1>Memberlist Compare Results</h1>
    <p><input type='hidden' name='username1' value='$username1' />
    <input type='hidden' name='username2' value='$username2' />
    <input type='hidden' name='username3' value='$username3' />
    <input type='hidden' name='username4' value='$username4' />
    <input type='hidden' name='username5' value='$username5' />
    <input type='hidden' name='compare' value='true' /></p>
    <table style='width: 450px; margin: 5px auto;' border='0' cellpadding='2'>
      <tr style='text-align: center;'>
        <td><b>Display:</b></td>
        <td><label for='combatSkills'>Combat Related Skills </label><input type='radio' id='combatSkills' name='compareType' value='combat' class='compareType'"; if ($compareType == "combat"){ echo " checked='checked'"; } echo " /></td>
        <td><label for='allSkills'>All Skills </label><input type='radio' id='allSkills' name='compareType' value='all' class='compareType'"; if ($compareType == "all"){ echo " checked='checked'"; } echo " /></td>
        <td><input type='submit' value='Compare' onclick='compareSubmit();' /></td>
	  </tr>
    </table>
  </form>
  <table class='contenttable' border='1'>
    <tr class='header'>
      <td style='width: 30%;' class='tableborder'>Averages</td>
";
	if (mysql_num_rows($result) > 0){
		$width = 70 / mysql_num_rows($result);
	} else {
		$width = 70;
	}
	while ($row = @mysql_fetch_array($result)){
		$username = $row["USERNAME"];
		$clanname = $row["CLANNAME"];
		$initials = $row["INITIALS"];
		if ($initials == ""){
			$initials = substr($clanname, 0, 1);
		}
		echo "<td style='width: $width%;' class='tableborder' title='$clanname'><a href='ml.php?clan=$username'>$initials</a></td>";
	}
echo "
    </tr>
    <tr>
      <td class='tableborder'>
";
	if ($compareType == "all"){
		echo "<p><b>Members</b></p>";
		echo "<p><b>P2P Combat</b></p>";
		echo "<p><b>F2P Combat</b></p>";
		echo "<p><b>Overall</b></p>";
		for ($a = 1; $a < sizeof($skills); $a++){
			echo "<p><b>" . $skills[$a] . "</b></p>";
		}
	} else {
		echo "<p><b>Members</b></p>";
		echo "<p><b>P2P Combat</b></p>";
		echo "<p><b>F2P Combat</b></p>";
		echo "<p><b>Overall</b></p>";
		echo "<p><b>Attack</b></p>";
		echo "<p><b>Defence</b></p>";
		echo "<p><b>Strength</b></p>";
		echo "<p><b>Hitpoints</b></p>";
		echo "<p><b>Ranged</b></p>";
		echo "<p><b>Prayer</b></p>";
		echo "<p><b>Magic</b></p>";
		echo "<p><b>Summoning</b></p>";
	}
	$sql = "SELECT USERNAME, NUMBERMEMBERS, CMBAVG, F2PCMBAVG, SKILLAVG
			FROM AVERAGES
			WHERE (USERNAME = '$username1'
			OR USERNAME = '$username2'
			OR USERNAME = '$username3'
			OR USERNAME = '$username4'
			OR USERNAME = '$username5')";
	$result = @mysql_query($sql);
	while ($row = @mysql_fetch_array($result)){
		$username = $row["USERNAME"];
		$numbermembers = $row["NUMBERMEMBERS"];
		$cmbAvg = $row["CMBAVG"];
		$f2pCmbAvg = $row["F2PCMBAVG"];		
		$skillavg = $row["SKILLAVG"];
echo "
      </td>
      <td style='text-align: center;' class='tableborder'>
";
		echo "<p><span "; if ($numbermembers == $maxNumbermembers){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $numbermembers . "</span></p>";
		echo "<p><span "; if ($cmbAvg == $maxCmbAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $cmbAvg . "</span></p>";
		echo "<p><span "; if ($f2pCmbAvg == $maxF2pCmbAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $f2pCmbAvg . "</span></p>";		
		echo "<p><span "; if ($skillavg == $maxSkillAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . number_format($skillavg) . "</span></p>";

		if ($compareType == "all"){
			for ($a = 1; $a < sizeof($skills); $a++){
				${"{$skills[$a]}Avg"} = 0;
				$sql2 = "SELECT `$skills[$a]`
						 FROM MEMBERS
						 WHERE USERNAME = '$username'";
				$result2 = @mysql_query($sql2);
				$num = 0;
				while ($row2 = @mysql_fetch_array($result2)){
					if (strtolower($skills[$a]) != "duel tournament" && strtolower($skills[$a]) != "bounty hunters" && strtolower($skills[$a]) != "bounty hunter rogues" && strtolower($skills[$a]) != "fist of guthix"){
						${"{$skills[$a]}Avg"} += levelXP($row2["$skills[$a]"]);
					} else {
						${"{$skills[$a]}Avg"} += $row2["$skills[$a]"];
					}
					$num++;
				}
				if ($num > 0){
					${"{$skills[$a]}Avg"} = round(${"{$skills[$a]}Avg"} / $num, 2);
				}
				echo "<p><span "; if (${"{$skills[$a]}Avg"} == ${"max{$skills[$a]}Avg"}){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . number_format(${"{$skills[$a]}Avg"}) . "</span></p>";				
			}
		} else {
			$attackAvg = 0;
			$defenceAvg = 0;
			$strengthAvg = 0;
			$hitpointsAvg = 0;
			$rangedAvg = 0;
			$prayerAvg = 0;
			$magicAvg = 0;
			$summoningAvg = 0;
			$sql2 = "SELECT ATTACK, DEFENCE, STRENGTH, HITPOINTS, RANGED, PRAYER, MAGIC, SUMMONING
					 FROM MEMBERS
					 WHERE USERNAME = '$username'";
			$result2 = @mysql_query($sql2);
			$num = 0;
			while ($row2 = @mysql_fetch_array($result2)){
				$attackAvg += levelXP($row2["ATTACK"]);
				$defenceAvg += levelXP($row2["DEFENCE"]);
				$strengthAvg += levelXP($row2["STRENGTH"]);
				$hitpointsAvg += levelXP($row2["HITPOINTS"]);
				$rangedAvg += levelXP($row2["RANGED"]);
				$prayerAvg += levelXP($row2["PRAYER"]);
				$magicAvg += levelXP($row2["MAGIC"]);
				$summoningAvg += levelXP($row2["SUMMONING"]);
				$num++;
			}
			if ($num > 0){
				$attackAvg = round($attackAvg / $num, 2);
				$defenceAvg = round($defenceAvg / $num, 2);
				$strengthAvg = round($strengthAvg / $num, 2);
				$hitpointsAvg = round($hitpointsAvg / $num, 2);
				$rangedAvg = round($rangedAvg / $num, 2);
				$prayerAvg = round($prayerAvg / $num, 2);
				$magicAvg = round($magicAvg / $num, 2);
				$summoningAvg = round($summoningAvg / $num, 2);
			}
			echo "<p><span "; if ($attackAvg == $maxAttackAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $attackAvg . "</span></p>";
			echo "<p><span "; if ($defenceAvg == $maxDefenceAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $defenceAvg . "</span></p>";
			echo "<p><span "; if ($strengthAvg == $maxStrengthAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $strengthAvg . "</span></p>";
			echo "<p><span "; if ($hitpointsAvg == $maxHitpointsAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $hitpointsAvg . "</span></p>";
			echo "<p><span "; if ($rangedAvg == $maxRangedAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $rangedAvg . "</span></p>";
			echo "<p><span "; if ($prayerAvg == $maxPrayerAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $prayerAvg . "</span></p>";
			echo "<p><span "; if ($magicAvg == $maxMagicAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $magicAvg . "</span></p>";
			echo "<p><span "; if ($summoningAvg == $maxSummoningAvg){ echo "style='font-weight: bold; color: #ffd700;'"; } echo ">" . $summoningAvg . "</span></p>";
		}
	}
echo "
      </td>
    </tr>	
  </table>
  <p style='text-align: center;'><a href='compare.php'>Compare Again</a></p>
</div>
";
} else {
echo "
<form id='compareForm' onsubmit='ajaxFunction(); return false;' action='' method='post' style='display: inline;'>
  <div class='main'>
    <h1>Memberlist Compare</h1>
    <div class='justify'>
      <p>Compare the stats of up to 5 memberlists.<br />
	  Use the name search and add buttons to select which memberlists you wish to compare.
	  Next select which stats you wish to display and click the \"Compare\" button to find
	  out who will come out on top in each stat.</p>
      <p>Clan / Group Name Search:
      <input id='clansearch' name='clansearch' value='' maxlength='50' style='width: 175px;' />
      <input onclick='ajaxFunction();' type='button' value='Search' />
      &nbsp;<img src='../design/images/ajax-loader.gif' alt='' style='display: none; border: 0px;' id='ajax-loader' /></p>
      <div id='ajaxDiv' style='max-height: 200px; overflow: auto; overflow-x: hidden;'></div>
    </div>
  </div>
  <div class='main' id='comparediv'>
    <h1>Memberlists to Compare</h1>
    <table class='contenttable' border='1'>
      <tr id='tableheader' class='header'>
	    <td style='width: 20%;' class='tableborder'>
		  <b>Action</b>
		</td>
		<td style='width: 60%;' class='tableborder'>
		  <b>Clan Name</b>
		</td>
		<td style='width: 20%;' class='tableborder'>
		  <b>Members</b>
		</td>
      </tr>
      <tr class='hovertr' style='cursor: default;'>
	    <td class='tableborder'><div id='username1a'><input type='hidden' id='usernamenumber1' value='' /></div></td>
		<td class='tableborder'><div id='username1b'>&nbsp;</div></td>
		<td class='tableborder'><div id='username1c'>&nbsp;</div></td>
	  </tr>
      <tr class='hovertr' style='cursor: default;'>
  	    <td class='tableborder'><div id='username2a'><input type='hidden' id='usernamenumber2' value='' /></div></td>
		<td class='tableborder'><div id='username2b'>&nbsp;</div></td>
		<td class='tableborder'><div id='username2c'>&nbsp;</div></td>
	  </tr>
      <tr class='hovertr' style='cursor: default;'>
	    <td class='tableborder'><div id='username3a'><input type='hidden' id='usernamenumber3' value='' /></div></td>
		<td class='tableborder'><div id='username3b'>&nbsp;</div></td>
		<td class='tableborder'><div id='username3c'>&nbsp;</div></td>
	  </tr>
      <tr class='hovertr' style='cursor: default;'>
	    <td class='tableborder'><div id='username4a'><input type='hidden' id='usernamenumber4' value='' /></div></td>
		<td class='tableborder'><div id='username4b'>&nbsp;</div></td>
		<td class='tableborder'><div id='username4c'>&nbsp;</div></td>
	  </tr>
      <tr class='hovertr' style='cursor: default;'>
	    <td class='tableborder'><div id='username5a'><input type='hidden' id='usernamenumber5' value='' /></div></td>
		<td class='tableborder'><div id='username5b'>&nbsp;</div></td>
		<td class='tableborder'><div id='username5c'>&nbsp;</div></td>
	  </tr>
    </table>		
    <table style='width: 450px; margin: 5px auto;' border='0' cellpadding='2'>
      <tr style='text-align: center;'>
        <td><b>Display:</b></td>
        <td><label for='combatSkills'>Combat Related Skills </label><input type='radio' id='combatSkills' name='compareType' value='combat' checked='checked' class='compareType' /></td>
        <td><label for='allSkills'>All Skills </label><input type='radio' id='allSkills' name='compareType' value='all' class='compareType' /></td>
        <td><input type='button' value='Compare' onclick='compareSubmit();' /></td>
      </tr>
    </table>
  </div>
</form>
";
}
include_once ("../design/bottom.php");
?>