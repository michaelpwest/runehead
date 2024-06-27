<?
session_start();
$time_start = microtime(true);
include_once("info.php");
$name = cleanName(@mysql_escape_string($_REQUEST["name"]));
$clan = @mysql_escape_string($_REQUEST["clan"]);
$print = @mysql_escape_string($_REQUEST["print"]);
$skill = "Memberlist";
$sortLink = "";
$combatTypeLink = "";
$showLink = "";
$searchLink = "";
$displayRank = "";
$showRank = "";
$sql = "SELECT U.USERNAME, M.RSN, M.RANK
		FROM USERS U, MEMBERS M
		WHERE U.USERNAME = '$clan'
		AND U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND M.RSN = '$name'
		AND U.USERNAME = M.USERNAME";
$result = @mysql_query($sql);
$row = @mysql_fetch_array($result);
$clan = $row["USERNAME"];
$name = $row["RSN"];
$rank = $row["RANK"];
$sql = "SELECT $rank
		FROM RANKS
		WHERE USERNAME = '$clan'";
$rankResult = @mysql_query($sql);
$rankRow = @mysql_fetch_array($rankResult);
$rank = $rankRow[$rank];
if ($name != "" && $clan != ""){
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
			WHERE RSN = '$name'
			AND USERNAME = '$clan'";
	$detailsResult = @mysql_query($sql);
	$detailsRow = @mysql_fetch_array($detailsResult);
	$details = @mysql_num_rows($result);
	$combat = $detailsRow["COMBAT"];
	$f2pcombat = $detailsRow["F2PCOMBAT"];
	if ($details > 0){
		include_once("ml_functions.php");	
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
    <!-- BANNER ROW -->
";
			if ($clanimage != ""){
				echo "<p style='margin: 0px;'><img src='$clanimage' alt='$clanname Memberlist' class='banner' style='text-align: center;' /></p>";
			} else {
				echo "<h1>$clanname Memberlist</h1>";
			}
echo "
    <table cellspacing='0' cellpadding='0' id='wrapper' border='0'>
";
			include_once ("ml_top.php");
			include_once ("ml_stats_info.php");
			//include_once ("ads/banner2google.php");
			include_once ("personal_main.php");
			include_once ("ml_footer.php");
echo '
    </table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-680952-6";
urchinTracker();
</script>	
	
  </body>
</html>
';
		} else {
			include_once ("ml_pdf.php");
		}
	} else { 
		include_once ("../design/top.php");
echo "
<div class='main'>
  <h1>Error</h1>
  <p>Member or Clan not Found</p>
</div>
";
		include_once ("../design/bottom.php");
	}
} else {
	include_once ("../design/top.php");
echo "
<div class='main'>
  <h1>Error</h1>
  <p>Member or Clan not Found</p>
</div>
";
	include_once ("../design/bottom.php");
}
?>