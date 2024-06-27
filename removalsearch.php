<?
if (isset($_REQUEST["search"])){
	echo "<div class='justify' id='search' style='display: block;'>";
} else {
	echo "<div class='justify' id='search' style='display: none;'>";
}
echo "<h1>Memberlist Search</h1>";

if (isset($_REQUEST["search"])){
	if (isset($_REQUEST["searchRequest"])){
		$searchRequest = trim(@mysql_escape_string(strtolower($_REQUEST["searchRequest"])));
	} else {
		$searchRequest = "";	
	}
} else {
	$searchRequest = "";
}

if ($searchRequest != ""){
	$sql = "SELECT U.USERNAME, U.CLANNAME
			FROM USERS U, MEMBERS M
			WHERE U.ACTIVE = '1'
			AND U.VALIDATED = '1'
			AND (U.USERNAME LIKE '%$searchRequest%'
			OR U.USERNAME LIKE '%$searchRequest%'
			OR U.INITIALS LIKE '%$searchRequest%')
			AND U.USERNAME = M.USERNAME
			AND M.RSN = '$rsn'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) == 0){
		echo "<p>No memberlists found with your RuneScape Name.</p>";
	} else {
echo "
  <div style='max-height: 400px; overflow: auto; overflow-x: hidden;'>
    <table class='contenttable' border='1'>
      <tr class='header'>
        <td style='width: 80%;' class='tableborder'>Name</td>
        <td style='width: 20%;' class='tableborder'>Add</td>		
      </tr>
";
		while ($row = mysql_fetch_array($result)){
			$current = $row["USERNAME"];
			$clanname = $row["CLANNAME"];
echo "
      <tr class='hovertr'>
        <td class='tableborder'><a href='ml.php?clan=$current' title='View $clanname Memberlist'>$clanname</a></td>
        <td class='tableborder'><input type='button' onclick='searchAdd(\"$current\", 1);' value='Add' style='background-color: #000000;' /></td>
	  </tr>
";
		}
echo "
    </table>
  </div>
";
	}
}

echo "
  <p style='text-align: center;'>Name: <input name='searchRequest' value='$searchRequest' /> <input type='submit' name='search' value='Search' /></p>
</div> 
";
?>