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
	$category = "-1";
}
if (isset($category) && $category == -1){
	echo " - All Clans / Non-Clan Groups";
} else if (isset($category) && $category == 0){
	echo " - All Non-Clans";
} else if (isset($category) && $category < sizeof($categories)){
	echo " - $categories[$category]";
}
echo "</h1>";
if (isset($_REQUEST["minigame"])){
	$minigame = @mysql_escape_string($_REQUEST["minigame"]);
} else {
	$minigame = "0";
}
if (isset($_REQUEST["sort"])){
	$sort = @mysql_escape_string($_REQUEST["sort"]);
} else {
	$sort = "cmb";
}
$minigames = array("Duel Tournament","Bounty Hunters","Bounty Hunter Rogues","Fist of Guthix","Mobilising Armies","B.A Attackers","B.A Defenders","B.A Collectors","B.A Healers","Castle Wars Games");
$limitmembers = 30;
$link = "&amp;category=$category";
$sql = "SELECT SUM(NUMBERMEMBERS) AS TOTALMEMBERS, COUNT(U.USERNAME) AS TOTALCLANS
		FROM USERS U, AVERAGES A
		WHERE U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND A.NUMBERMEMBERS >= '$limitmembers'		
		AND U.USERNAME = A.USERNAME ";
if ($category == 0){			
	$sql .= "AND U.CLANTYPE = 'clan' ";
} else if ($category == 1){
	$sql .= "AND U.CLANTYPE = 'non-clan' ";
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

$sql = "SELECT U.USERNAME, U.CLANNAME, A.NUMBERMEMBERS, SUM(M.`" . strtoupper($minigames[$minigame]) . "`) AS TOTALSCORE, SUM(M.`" . strtoupper($minigames[$minigame]) . "`) / A.NUMBERMEMBERS AS TOTALAVERAGE
		FROM USERS U, AVERAGES A, MEMBERS M
		WHERE U.ACTIVE = '1'
		AND U.VALIDATED = '1'
		AND A.NUMBERMEMBERS >= '$limitmembers'	
		AND U.USERNAME = M.USERNAME	
		AND U.USERNAME = A.USERNAME ";
if ($category == 1){			
	$sql .= "AND U.CLANTYPE = 'clan' ";
} else if ($category == 0){
	$sql .= "AND U.CLANTYPE = 'non-clan' ";
} else if ($category > 1 && $category <= sizeof($categories)){
	$sql .= "AND U.CLANTYPE = 'non-clan'
			 AND U.CATEGORY = '$category' ";
}
$sql .= "GROUP BY U.USERNAME ";
if ($sort == "name"){
	$sql .= "ORDER BY TRIM(U.CLANNAME) ";
} else if ($sort == "mem"){
	$sql .= "ORDER BY A.NUMBERMEMBERS DESC ";
} else if ($sort == "score"){
	$sql .= "ORDER BY TOTALSCORE DESC, U.CLANNAME ASC ";
} else {
	$sql .= "ORDER BY TOTALAVERAGE DESC, U.CLANNAME ASC ";
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
	echo "<td style='text-align: left; width: 15%;'><a href='$pagename?sort=$sort&amp;page=" . ($page - 1) . "$link'>Previous Page</a></td>";
} else {
	echo "<td style='text-align: left; width: 15%;'>&nbsp;</td>";
}
echo "
        <td style='text-align: center; width: 70%;'>
          <select name='page' style='width: 80px;' onchange='submit();'>
";
for ($a = 1; $a < $pagelimit; $a++){
	echo "<option value='$a'"; if ($page == $a){ echo " selected='selected'"; } echo ">Page $a</option>";
}
echo "
          </select>
          <select name='category' style='width: 190px;' onchange='submit();'>
            <option value='-1'"; if ($category == -1){ echo " selected='selected'"; } echo ">All Clans / Non-Clan Groups</option>
            <option value='1'"; if ($category == 1){ echo " selected='selected'"; } echo ">" . $categories[1] . "</option>
            <option value='0'"; if ($category == 0){ echo " selected='selected'"; } echo ">All Non-Clans</option>
";
for ($a = 2; $a < sizeof($categories); $a++){
	echo "<option value='$a'"; if ($category == $a){ echo " selected='selected'"; } echo ">$categories[$a]</option>";
}
echo "
          </select>
          <select name='minigame' style='width: 155px;' onchange='submit();'>
";
for ($a = 0; $a < sizeof($minigames); $a++){
	echo "<option value='$a'"; if ($minigame == $a){ echo " selected='selected'"; } echo ">$minigames[$a]</option>";
}
echo "
          </select>		  
          <input type='submit' value='Go' />
        </td>
";
if ($page == ($pagelimit - 1) || $pagelimit == 1){
	echo "<td style='text-align: right; width: 15%;'>&nbsp;</td>";
} else {
	echo "<td style='text-align: right; width: 15%;'><a href='$pagename?sort=$sort&amp;page=" . ($page + 1) . "$link'>Next Page</a></td>";
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
        <td style='width: 34%;' class='tableborder'><a href='$pagename?sort=name$link&amp;minigame=$minigame&amp;page=$page' title='Sort by Name'><b>Name</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='$pagename?sort=mem$link&amp;minigame=$minigame&amp;page=$page' title='Sort by Number of Members'><b>Members</b></a></td>
        <td style='width: 25%;' class='tableborder'><a href='$pagename?sort=average$link&amp;minigame=$minigame&amp;page=$page' title='Sort by Average'><b>" . $minigames[$minigame] . " Average</b></a></td>
        <td style='width: 25%;' class='tableborder'><a href='$pagename?sort=score$link&amp;minigame=$minigame&amp;page=$page' title='Sort by Total Score'><b>" . $minigames[$minigame] . " Total Score</b></a></td>
      </tr>
";
while ($row = @mysql_fetch_array($result)){
	$mluser = $row["USERNAME"];
	$name = $row["CLANNAME"];
	$numbermembers = $row["NUMBERMEMBERS"];
	$totalscore = $row["TOTALSCORE"];
	$totalaverage = $row["TOTALAVERAGE"];
	$rank++;
echo "
      <tr class='hovertr'>
        <td class='tableborder'>$rank</td>
        <td class='tableborder'><a href='ml.php?clan=$mluser' title='View $name Memberlist'>$name</a></td>
        <td class='tableborder'>$numbermembers</td>
        <td class='tableborder'>" . number_format(round($totalaverage, 2)) . "</td>
        <td class='tableborder'>" . number_format($totalscore) . "</td>
      </tr>
";
}
echo "
    </table>
  </form>
</div>
";
?>