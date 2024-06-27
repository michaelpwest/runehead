<?
$sql = "SELECT COMBAT, F2PCOMBAT, HITPOINTS, OVERALL, MAGIC, RANGED
		FROM MEMBERS
		WHERE USERNAME = '$user'";
$membersResult = @mysql_query($sql);
$cmbavg = 0;
$f2pcmbavg = 0;
$hpavg = 0;
$skillavg = 0;
$rangedavg = 0;
$magicavg = 0;
$num = 0;
while ($membersRow = @mysql_fetch_array($membersResult)){
	$cmbavg += $membersRow["COMBAT"];
	$f2pcmbavg += $membersRow["F2PCOMBAT"];
	$hpavg += levelXP($membersRow["HITPOINTS"]);
	$skillavg += $membersRow["OVERALL"];
	$rangedavg += levelXP($membersRow["RANGED"]);
	$magicavg += levelXP($membersRow["MAGIC"]);
	$num++;
}
if ($num > 0){
	$cmbavg = round(($cmbavg / $num), 2);
	$f2pcmbavg = round(($f2pcmbavg / $num), 2);
	$hpavg = round(($hpavg / $num), 2);
	$skillavg = round($skillavg / $num);
	$rangedavg = round(($rangedavg / $num), 2);
	$magicavg = round(($magicavg / $num), 2);
}
$sql = "UPDATE AVERAGES SET
		NUMBERMEMBERS = '$num',
		CMBAVG = '$cmbavg',
		F2PCMBAVG = '$f2pcmbavg',
		HPAVG = '$hpavg',
		SKILLAVG = '$skillavg',
		RANGEDAVG = '$rangedavg',
		MAGICAVG = '$magicavg'
		WHERE USERNAME = '$user'";
@mysql_query($sql);
?>