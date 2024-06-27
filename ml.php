<?
session_start();
$time_start = microtime(true);
include_once("info.php");
$clan = @mysql_escape_string($_REQUEST["clan"]);
$print = @mysql_escape_string($_REQUEST["print"]);
$combatType = @mysql_escape_string($_REQUEST["combatType"]);
if (isset($_REQUEST["hideBanner"])){
	$hideBanner = @mysql_escape_string($_REQUEST["hideBanner"]);
}
if (isset($_REQUEST["hideStats"])){
	$hideStats = @mysql_escape_string($_REQUEST["hideStats"]);
}
if (isset($_REQUEST["hideRanks"])){
	$hideRanks = @mysql_escape_string($_REQUEST["hideRanks"]);
}
if (isset($_REQUEST["hideDetails"])){
	$hideDetails = @mysql_escape_string($_REQUEST["hideDetails"]);
}
if (isset($_REQUEST["hideMembers"])){
	$hideMembers = @mysql_escape_string($_REQUEST["hideMembers"]);
}
if ($combatType == "P2P" || $combatType == "F2P"){
	$combatTypeLink = "&amp;combatType=$combatType";	
} else {
	$combatType = "P2P";
	$combatTypeLink = "";	
}

include_once("ml_functions.php");

if ($active == 1 && $validated == 1){
	$sort = strtolower(@mysql_escape_string($_REQUEST["sort"]));
	if ($sort != ""){
		$sortLink = "&amp;sort=$sort";
	} else {
		$sortLink = "";
	}

	$show = @mysql_escape_string($_REQUEST["show"]);
	if ($show != "" && $show > 0 && $show <= 138){
		if ($show == 138){
			$showDisplay = " - " . $show . " Combat";
		} else {
			$showDisplay = " - " . $show . "+ Combat";	
		}
		$showLink = "&amp;show=$show";	
	} else {
		$show = "";
		$showDisplay = "";
		$showLink = "";	
	}
	
	if (isset($_REQUEST["search"]) && $_REQUEST["search"] != ""){
		$search = cleanName(@mysql_escape_string($_REQUEST["search"]));
		$searchLink = "&amp;search=$search";
		if ($search == ""){
			$_SESSION["search"] = "";
		}
	} else {
		$search = "";
		$searchLink = "";
	}	
	
	$displayRank = @mysql_escape_string($_REQUEST["rank"]);
	if ($displayRank != ""){
		if ($displayRank == "all"){
			$_SESSION["displayRank"] = "";
		} else {
			$_SESSION["displayRank"] = $displayRank;
		}
	}
	$displayRank = @mysql_escape_string($_SESSION["displayRank"]);
	if ($displayRank != ""){
		$showRank = " - " . ${"rank$displayRank"};
	} else {
		$showRank = "";
	}
	
	$skill = @mysql_escape_string($_REQUEST["skill"]);
	if ($skill == ""){
		$skill = "Memberlist";
	} else {
		if (in_array($skill, $skills)){
			$skill = ucwords(strtolower($skill));
		} else {
			$skill = "Memberlist";
		}
	}	
	
	if ($skill == "Memberlist"){
		$sql = "SELECT *
				FROM MEMBERS
				WHERE USERNAME = '$clan'";
		$skillResult = @mysql_query($sql);
		$totalxp = 0;
		while ($skillRow = @mysql_fetch_array($skillResult)){
			$totalxp += $skillRow["OVERALLXP"];
		}
		if ($totalxp > 0){
			$totalxp = number_format($totalxp);
		}	
		$sql = "SELECT *
				FROM MEMBERS
				WHERE USERNAME = '$username'";
		if ($displayRank != ""){
			$sql .= " AND RANK = 'RANK" . $displayRank . "'";
		}
		if ($show != ""){
			if ($combatType == "F2P"){
				$sql .= " AND F2PCOMBAT >= '$show'";
			} else {
				$sql .= " AND COMBAT >= '$show'";			
			}
		}
		if ($search != ""){
			$sql .= " AND RSN LIKE '%$search%'";
		}
		$sql .= " ORDER BY ";
		if ($sort == "name"){
			$sql .= " TRIM(RSN) ASC";
		} else if($sort == "namerev"){
			$sql .= " TRIM(RSN) DESC";
		} else if ($sort == "hp") {
			$sql .= " HITPOINTS DESC";
		} else if ($sort == "hprev"){
			$sql .= " HITPOINTS ASC";		
		} else if ($sort == "overall") {
			$sql .= " OVERALL DESC, OVERALLXP DESC";
		} else if ($sort == "overallrev") {
			$sql .= " OVERALL ASC, OVERALLXP ASC";
		} else if ($sort == "cmbrev") {
			if ($combatType == "F2P"){
				$sql .= " F2PCOMBAT ASC, (ATTACK + DEFENCE + STRENGTH + HITPOINTS + PRAYER + RANGED + MAGIC) ASC";
			} else {
				$sql .= " COMBAT ASC, (ATTACK + DEFENCE + STRENGTH + HITPOINTS + PRAYER + RANGED + MAGIC + SUMMONING) ASC";
			}
		} else {
			if ($combatType == "F2P"){
				$sql .= " F2PCOMBAT DESC, (ATTACK + DEFENCE + STRENGTH + HITPOINTS + PRAYER + RANGED + MAGIC) DESC";
			} else {
				$sql .= " COMBAT DESC, (ATTACK + DEFENCE + STRENGTH + HITPOINTS + PRAYER + RANGED + MAGIC + SUMMONING) DESC";
			}
		}
	} else if ($skill == "Overall"){
		$sql = "SELECT OVERALL, OVERALLXP, OVERALLRANK
				FROM MEMBERS
				WHERE USERNAME = '$username'";
		$skillResult = @mysql_query($sql);
		$num = 0;
		$skillavg = 0;
		$skillrankavg = 0;
		$skillxpavg = 0;
		$skillxptotal = 0;
		while ($skillRow = @mysql_fetch_array($skillResult)){
			$num++;
			$skillavg += $skillRow["OVERALL"];
			$skillrankavg += $skillRow["OVERALLRANK"];
			$skillxpavg += $skillRow["OVERALLXP"];
		}
		if ($skillavg > 0){
			$skillavg = number_format(round(($skillavg / $num), 0));
		}
		if ($skillrankavg > 0){
			$skillrankavg = number_format(round(($skillrankavg / $num), 0));
		}
		if ($skillxpavg > 0){
			$skillxptotal = number_format($skillxpavg);
			$skillxpavg = number_format(round(($skillxpavg / $num), 0));
		}
		$sql = "SELECT RSN, RANK, OVERALL, OVERALLXP, OVERALLRANK
				FROM MEMBERS
				WHERE USERNAME = '$username'";
		if ($displayRank != ""){
			$sql .= " AND RANK = 'RANK" . $displayRank . "'";
		}
		if ($show != ""){
			if ($combatType == "F2P"){
				$sql .= " AND F2PCOMBAT >= '$show'";
			} else {
				$sql .= " AND COMBAT >= '$show'";			
			}
		}
		if ($search != ""){
			$sql .= " AND RSN LIKE '%$search%'";
		}
		$sql .= " ORDER BY ";
		if ($sort == "overallxp"){
			$sql .= " OVERALLXP DESC, OVERALL DESC";
		} else if ($sort == "overallxprev"){
			$sql .= " OVERALLXP ASC, OVERALL ASC";		
		} else if ($sort == "name"){
			$sql .= " TRIM(RSN) ASC";
		} else if ($sort == "namerev"){
			$sql .= " TRIM(RSN) DESC";
		} else if ($sort == "overallrev"){
			$sql .= " OVERALL ASC, OVERALLXP ASC";		
		} else {
			$sql .= " OVERALL DESC, OVERALLXP DESC";
		}
	} else {
		$sql = "SELECT `" . strtoupper($skill) . "`, `" . strtoupper($skill) . "RANK`
				FROM MEMBERS
				WHERE USERNAME = '$username'";	
		$skillResult = @mysql_query($sql);
		$num = 0;
		$skillavg = 0;
		$skillrankavg = 0;
		$skillxpavg = 0;
		$skillxptotal = 0;
		while ($skillRow = @mysql_fetch_array($skillResult)){
			$num++;
			$skillavg += levelXP($skillRow[strtoupper($skill)], $skill);
			$skillrankavg += $skillRow[strtoupper($skill) . "RANK"];
			$skillxpavg += $skillRow[strtoupper($skill)];
		}
		if ($skillavg > 0){		
			$skillavg = round(($skillavg / $num), 2);
		}
		if ($skillrankavg > 0){		
			$skillrankavg = number_format(round(($skillrankavg / $num), 0));
		}
		if ($skillxpavg > 0){		
			$skillxptotal = number_format(round($skillxpavg, 0));
			$skillxpavg = number_format(round(($skillxpavg / $num), 0));
		}
		$sql = "SELECT RSN, RANK, `" . strtoupper($skill) . "`, `" . strtoupper($skill) . "RANK`
				FROM MEMBERS
				WHERE USERNAME = '$username'";
		if ($displayRank != ""){
			$sql .= " AND RANK = 'RANK" . $displayRank . "'";
		}
		if ($show != ""){
			if ($combatType == "F2P"){
				$sql .= " AND F2PCOMBAT >= '$show'";
			} else {
				$sql .= " AND COMBAT >= '$show'";			
			}
		}		
		if ($search != ""){
			$sql .= " AND RSN LIKE '%$search%'";
		}	
		$sql .= " ORDER BY ";
		if ($sort == "name"){
			$sql .= " TRIM(RSN) ASC";
		} else if ($sort == "namerev"){
			$sql .= " TRIM(RSN) DESC";		
		} else if ($sort == "skillrev"){
			$sql .= "`" . strtoupper($skill) . "` ASC";		
		} else {
			$sql .= "`" . strtoupper($skill) . "` DESC";
		}
	}
	$membersResult = @mysql_query($sql);
	if (!$print){
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN'
'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
  <head>
    <title>$clanname Memberlist</title>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8' />
    <style type='text/css'>
";
		include_once ("ml_css.php");
echo "
    </style>
  </head>
  <body>
    <form method='post' id='ml' action='ml.php?clan=$clan'>
    <!-- BANNER ROW -->
";
		if (!isset($hideBanner)){
			if ($clanimage != ""){
				echo "<p style='margin: 0px;'><img src='$clanimage' alt='$clanname Memberlist' class='banner' style='text-align: center;' /></p>";
			} else {
				echo "<h1>$clanname Memberlist</h1>";
			}
		}
echo "
      <table cellspacing='0' cellpadding='0' id='wrapper' border='0'>
";
		include_once ("ml_top.php");
		if (!isset($hideStats) || !isset($hideRanks) || !isset($hideDetails)){
			include_once ("ml_stats_info.php");
		}
		//include_once ("ads/banner2google.php");
		if (!isset($hideMembers)){
			include_once ("ml_main.php");
		}
		include_once ("ml_footer.php");
echo "
	  </table>
    </form>

<script src=\"http://www.google-analytics.com/urchin.js\" 
type=\"text/javascript\">
</script>
<script type=\"text/javascript\">
_uacct = \"UA-680952-6\";
urchinTracker();
</script>	
	
  </body>
</html>
";
	} else {
		include_once ("ml_pdf.php");
	}
} else if ($active == 0 || $validated == 0){
	include_once ("../design/top.php");
echo "
<div class='main'>
  <h1>Memberlist Alert</h1>
  <p>This memberlist will not display until:";
	if ($active == 0){
		echo "<br />It is activated by logging in via <a href='admin.php'>http://www.runehead.com/clans/admin.php</a>";
	}
	if ($validated == 0){
		echo "<br />It is validated by an admin. This will usually happen within 24-48 hours.";	
	}
echo " 
  </p>
</div>
";
	include_once ("../design/bottom.php");
} else if ($active == 2 || $validated == 2){
	include_once ("../design/top.php");
echo "
<div class='main'>
  <h1>Memberlist Not Found</h1>
  <p>Memberlist not found.</p>
</div>
";
	include_once ("../design/bottom.php");
}
?>