<?
if (!$print){
echo "
<!-- MAIN PERSONAL PAGE TABLE-->
<tr>
  <td valign='top' colspan='2'>
    <table cellspacing='0' class='main'>
      <tr class='header'>
        <td colspan='5'><b>Personal Stats of $name :: <a href='ml.php?clan=$clan' style='color: $headerfont'>$clanname</a></b></td>
      </tr>
      <tr class='header'>
        <td colspan='5'>Rank - $rank :: P2P Combat - $combat :: F2P Combat - $f2pcombat</td>
      </tr>
      <tr style='color: $personalfont;'>
        <td style='width:20%;'><b>Skill</b></td>
        <td style='width:20%;'><b>Clan Rank</b></td>
        <td style='width:20%;'><b>RS Rank</b></td>
        <td style='width:20%;'><b>Level</b></td>
        <td style='width:20%;'><b>XP / Score</b></td>
     </tr>
";
} else {
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(175, 5, strtoupper("Personal Stats of $name :: $clanname"), 1, 1, "C");
	$pdf->Cell(175, 5, strtoupper("Rank - $rank :: P2P Combat - $combat :: F2P Combat - $f2pcombat"), 1, 1, "C");
	$pdf->SetWidths(array(35,35,35,35,35));
	$pdf->SetAligns(array("C","C","C","C","C"));
	$pdf->Row(array("Skill","Clan Rank","RS Rank","Level","XP / Sc"));
	$pdf->SetFont('Arial','',8);	
}
$rankSql = "SELECT RSN
			FROM MEMBERS
			WHERE USERNAME = '$clan'
			ORDER BY OVERALL DESC, OVERALLXP DESC";
$rankResult = @mysql_query($rankSql);
$clanrank = 0;
while ($rankRow = @mysql_fetch_array($rankResult)){
	$clanrank++;
	if ($rankRow["RSN"] == $name){
		break;
	}
}
$overallrank = number_format($detailsRow["OVERALLRANK"]);
$overalllvl = number_format($detailsRow["OVERALL"]);
$overallxp = number_format($detailsRow["OVERALLXP"]);
if (!$print){
echo "
     <tr style='color: $personalfont;'>
       <td><a href='ml.php?clan=$clan&amp;skill=Overall' style='color: $personalfont;'>Overall</a></td>
       <td>$clanrank</td>
       <td>$overallrank</td>
       <td>$overalllvl</td>
       <td>$overallxp</td>
     </tr>
";
} else {
	$pdf->Row(array("Overall",$clanrank,$overallrank,$overalllvl,$overallxp));
}

$rankArray = array();
$sql = "SELECT `RSN`";
for ($a = 1; $a < sizeof($skills); $a++){
	$sql .= ", `" . strtoupper($skills[$a]) . "`";
}
$sql .= " FROM MEMBERS
		WHERE USERNAME = '$clan'";
$rankResult = @mysql_query($sql);
while ($rankRow = @mysql_fetch_array($rankResult)){
	for ($a = 1; $a < sizeof($skills); $a++){
		$rankArray[strtoupper($skills[$a])][$rankRow["RSN"]] = $rankRow[strtoupper($skills[$a])];
	}
}
for ($a = 1; $a < sizeof($skills); $a++){
	$skill = strtoupper($skills[$a]);
	$rankArrayTmp = $rankArray[$skill];
	asort($rankArrayTmp);
	$rankArrayTmp = array_reverse($rankArrayTmp, true);	
	$clanrank = 0;
	foreach ($rankArrayTmp as $key => $value) {
		$clanrank++;
		if ($key == $name){
			break;
		}
	}
	$skillrank = number_format($detailsRow[$skill . "RANK"]);
	$skillxp = $detailsRow[$skill];
	$skilllevel = levelXP($skillxp, $skill);
	$skillxp = number_format($skillxp);
	if (!$print){
echo "
      <tr style='color: $personalfont;'>
        <td><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skills[$a]) . "' style='color: $personalfont;'>$skills[$a]</a></td>
        <td>$clanrank</td>
        <td>$skillrank</td>
        <td>$skilllevel</td>
        <td>$skillxp</td>
      </tr>
";
	} else {
		$pdf->Row(array($skills[$a],$clanrank,$skillrank,$skilllevel,$skillxp));
	}
}

if (!$print){
$sql = "SELECT DISTINCT U.USERNAME, U.CLANNAME, A.NUMBERMEMBERS, A.F2PCMBAVG, A.CMBAVG, A.SKILLAVG
		FROM USERS U, AVERAGES A, MEMBERS M
		WHERE U.USERNAME = A.USERNAME
		AND U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND A.USERNAME = M.USERNAME
		AND M.RSN = '$name'
		ORDER BY U.CLANNAME";
$personalresult = mysql_query($sql);
$personalrows = mysql_num_rows($personalresult);
echo "
    </table>
	<table cellspacing='0' class='main'>
      <tr class='header'>
";
if ($personalrows == 1){
echo "<td colspan='5'>$name is on the following memberlist</td>";
} else {
echo "<td colspan='5'>$name is on the following $personalrows memberlists</td>";
}
echo "
      </tr>
      </tr>
      <tr style='color: $personalfont;'>
        <td style='width:20%;'><b>Name</b></td>
        <td style='width:20%;'><b>Members</b></td>
        <td style='width:20%;'><b>P2P Combat Avg</b></td>
        <td style='width:20%;'><b>F2P Combat Avg</b></td>
        <td style='width:20%;'><b>Overall Avg</b></td>
     </tr>
";
while ($personalrow = mysql_fetch_array($personalresult)){
	$clan = $personalrow["USERNAME"];
	$clanname = $personalrow["CLANNAME"];
	$numbermembers = $personalrow["NUMBERMEMBERS"];
	$cmbavg = $personalrow["CMBAVG"];
	$f2pcmbavg = $personalrow["F2PCMBAVG"];
	$skillavg = number_format($personalrow["SKILLAVG"]);
echo "
      <tr style='color: $personalfont;'>
        <td><a href='ml.php?clan=$clan' style='color: $personalfont;'>$clanname</a></td>
        <td>$numbermembers</td>
        <td>$cmbavg</td>
        <td>$f2pcmbavg</td>
        <td>$skillavg</td>
      </tr>
";	
}
echo "	  
	</table>
  </td>
</tr>
";
}
?>