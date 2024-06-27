<?
include_once ("info.php");
$clansearch = @mysql_escape_string($_REQUEST["clansearch"]);
if (trim($clansearch) != ""){
	$sql = "SELECT U.USERNAME, U.CLANNAME, A.NUMBERMEMBERS
			FROM USERS U, AVERAGES A
			WHERE U.USERNAME = A.USERNAME
			AND A.NUMBERMEMBERS > '0'
			AND U.ACTIVE = '1'
			AND U.VALIDATED = '1'
			AND (U.USERNAME LIKE '%$clansearch%'
			OR U.CLANNAME LIKE '%$clansearch%'
			OR U.INITIALS LIKE '%$clansearch%')
			ORDER BY TRIM(U.CLANNAME)";
	$result = @mysql_query($sql);
	$size = @mysql_num_rows($result);
	if ($size > 0){
		echo "<div class='justify'>";
		if ($size == 1){
			echo "<p><b>$size</b> result was found:</p>";
		} else {
			echo "<p><b>$size</b> results were found:</p>";
		}
echo "
</div>
  <table class='contenttable' border='1'>
    <tr class='header'>
      <td style='width: 20%;' class='tableborder'><b>Action</b></td>
      <td style='width: 60%;' class='tableborder'><b>Clan Name</b></td>
      <td style='width: 20%;' class='tableborder'><b>Members</b></td>
    </tr>
";
	} else {
		echo "<p>No results were found.</p>";
	}

	while ($row = @mysql_fetch_array($result)){
		$username = $row["USERNAME"];
		$clanname = $row["CLANNAME"];
		$numbermembers = $row["NUMBERMEMBERS"];
echo "
    <tr class='hovertr' style='cursor: default;'>
      <td class='tableborder'><input type='button' style='background-color: #000000; cursor: pointer;' onclick=\"compareAdd('$username', '$clanname', '$numbermembers');\" value='Add'/></td>
      <td class='tableborder'><a href='ml.php?clan=$username' title='View $clanname Memberlist'>$clanname</a></td>
      <td class='tableborder'>$numbermembers</td>
    </tr>
";
	}
echo "</table>";
} else {
	echo "<p>Please enter a name to search.</p>";
}
?>