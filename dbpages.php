<?
echo "
<div id='intro'>
  <div class='justify'>
    <h1>$title</h1>
    <p>$intro</p>
  </div>
</div>
<!-- <div class='linkbanner'>
";
//include_once('ads/banner1.php');
echo "
</div> /-->
<div class='main'>
  <h1>
  $header
";
if (isset($_REQUEST["category"])){
	$category = @mysql_escape_string($_REQUEST["category"]);
} else {
	if ($pagetype == "nonclan"){
		$category = "0";
	} else {
		$category = "1";
	}
}
if (isset($category) && $category == -1){
	echo " - All Clans / Non-Clan Groups";
} else if (isset($category) && $category == 0){
	echo " - All Non-Clans";
} else if (isset($category) && $category < sizeof($categories)){
	echo " - $categories[$category]";
}
echo "</h1>";
if (isset($_REQUEST["sort"])){
	$sort = @mysql_escape_string($_REQUEST["sort"]);
} else {
	$sort = "cmb";
}

if (isset($_REQUEST["combatType"])){
	$combatType = @mysql_escape_string($_REQUEST["combatType"]);
} else {
	$combatType = "P2P";
}

$limitmembers = 30;
$link = "&amp;category=$category";
$sql = "SELECT SUM(NUMBERMEMBERS) AS TOTALMEMBERS, COUNT(U.USERNAME) AS TOTALCLANS
		FROM USERS U, AVERAGES A
		WHERE U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND A.NUMBERMEMBERS >= '$limitmembers'		
		AND U.USERNAME = A.USERNAME ";
if ($category == 0){			
	$sql .= "AND U.CLANTYPE = 'non-clan' ";
} else if ($category == 1){
	$sql .= "AND U.CLANTYPE = 'clan' ";
} else if ($category > 1 && $category <= sizeof($categories)){
	$sql .= "AND U.CLANTYPE = 'non-clan'
			 AND U.CATEGORY = '$category' ";
}
$result = @mysql_query($sql);
$row = @mysql_fetch_array($result);
$totalmembers = $row["TOTALMEMBERS"];
$totalclans = $row["TOTALCLANS"];
$pagelimit = ceil($totalclans / 100) + 1;
if ($pagelimit <= 1){
	$pagelimit = 2;
}

$sql = "SELECT U.USERNAME, U.CLANNAME, A.NUMBERMEMBERS, A.SKILLAVG, A.HPAVG, A.CMBAVG, A.F2PCMBAVG, A.MAGICAVG, A.RANGEDAVG
		FROM USERS U, AVERAGES A
		WHERE U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND A.NUMBERMEMBERS >= '$limitmembers'		
		AND U.USERNAME = A.USERNAME ";
if ($category == 0){			
	$sql .= "AND U.CLANTYPE = 'non-clan' ";
} else if ($category == 1){
	$sql .= "AND U.CLANTYPE = 'clan' ";
} else if ($category > 1 && $category <= sizeof($categories)){
	$sql .= "AND U.CLANTYPE = 'non-clan'
			 AND U.CATEGORY = '$category' ";
}
if ($sort == "name"){
	$sql .= "ORDER BY TRIM(U.CLANNAME) ";
} else if ($sort == "mem"){
	$sql .= "ORDER BY A.NUMBERMEMBERS DESC ";
} else if ($sort == "hp"){
	$sql .= "ORDER BY A.HPAVG DESC ";
} else if ($sort == "cmb"){
	if ($combatType == "F2P"){
		$sql .= "ORDER BY A.F2PCMBAVG DESC ";
	} else {
		$sql .= "ORDER BY A.CMBAVG DESC ";	
	}
} else if ($sort == "magic"){
	$sql .= "ORDER BY A.MAGICAVG DESC ";
}  else if ($sort == "ranged"){
	$sql .= "ORDER BY A.RANGEDAVG DESC ";
} else if ($sort == "overall"){
	$sql .= "ORDER BY A.SKILLAVG DESC ";
}
$page = @mysql_escape_string($_REQUEST["page"]);
$size = ($page * 100) - 100;
if ($page > 0){
	$rank = $size;
	$sql .= "LIMIT $size, 100";
} else {
	$sql .= "LIMIT 0, 100";
	$rank = 0;
	$page = 1;
}
$result = @mysql_query($sql);

echo "
  <form action='$pagename' method='post'>
    <table style='margin: 0px auto 5px auto;' border='0'>
      <tr>
";
if ($page > 1){
echo "
        <td style='text-align: left; width: 15%;'><a href='$pagename?sort=$sort&amp;page=" . ($page - 1) . "$link'>Previous Page</a></td>
";
} else {
echo "
        <td style='text-align: left; width: 15%;'>&nbsp;</td>
";
}
echo "
        <td style='text-align: center; width: 70%;'>
          <select name='page' style='width: 80px;' onchange='submit();'>
";
	for ($a = 1; $a < $pagelimit; $a++){
echo "
            <option value='$a'"; if ($page == $a){ echo " selected='selected'"; } echo ">Page $a</option>
";
	}
echo "
          </select>
          <select name='category' style='width: 190px;' onchange='submit();'>
            <option value='-1'"; if ($category == -1){ echo " selected='selected'"; } echo ">All Clans / Non-Clan Groups</option>
            <option value='1'"; if ($category == 1){ echo " selected='selected'"; } echo ">" . $categories[1] . "</option>
            <option value='0'"; if ($category == 0){ echo " selected='selected'"; } echo ">All Non-Clans</option>
";
	for ($a = 2; $a < sizeof($categories); $a++){
echo "
            <option value='$a'"; if ($category == $a){ echo " selected='selected'"; } echo ">$categories[$a]</option>
";
	}
echo "
          </select>
          <input type='submit' value='Go' />
        </td>
";
if ($page == ($pagelimit - 1) || $pagelimit == 1){
echo "
        <td style='text-align: right; width: 15%;'>&nbsp;</td>
";
} else {
echo "
        <td style='text-align: right; width: 15%;'><a href='$pagename?sort=$sort&amp;page=" . ($page + 1) . "$link'>Next Page</a></td>
";
}
echo "
      </tr>
    </table>
	<div>
      Total of <b>" . number_format($totalclans) . "</b> memberlists found with <b>" . number_format($totalmembers) . "</b> members
	</div>	
    <table class='contenttable' border='1'>
      <tr class='header'>
        <td style='width: 6%;' class='tableborder'><b>Rank</b></td>
        <td style='width: 34%;' class='tableborder'><a href='$pagename?sort=name$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Name'><b>Name</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=mem$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Number of Members'><b>Members</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=cmb$link&amp;combatType=$combatType&amp;page=$page' title='Sort by $combatType Combat Average'><b>$combatType Cmb</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=hp$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Hitpoints Average'><b>HP</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=magic$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Magic Average'><b>Magic</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=ranged$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Ranged Average'><b>Ranged</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=overall$link&amp;combatType=$combatType&amp;page=$page' title='Sort by Overall Average'><b>Overall</b></a></td>
      </tr>
";
while ($row = @mysql_fetch_array($result)){
	$mluser = $row["USERNAME"];
	$name = $row["CLANNAME"];
	$numbermembers = $row["NUMBERMEMBERS"];
	$skillavg = number_format($row["SKILLAVG"]);
	$hpavg = $row["HPAVG"];
	if ($combatType == "F2P"){
		$cmbavg = $row["F2PCMBAVG"];	
	} else {
		$cmbavg = $row["CMBAVG"];
	}
	$magicavg = $row["MAGICAVG"];
	$rangedavg = $row["RANGEDAVG"];
	$rank++;
echo "
      <tr class='hovertr'>
        <td class='tableborder'>$rank</td>
        <td class='tableborder'><a href='ml.php?clan=$mluser' title='View $name Memberlist'>$name</a></td>
        <td class='tableborder'>$numbermembers</td>
        <td class='tableborder'>$cmbavg</td>
        <td class='tableborder'>$hpavg</td>
        <td class='tableborder'>$magicavg</td>
        <td class='tableborder'>$rangedavg</td>
        <td class='tableborder'>$skillavg</td>
      </tr>
";
}
echo "
    </table>
  </form>
</div>
";
?>