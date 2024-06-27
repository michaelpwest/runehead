<?
print "@@start\n";
/***** Even if you get this password, our database still only allows localhost connections, so get lost smurf*****/
$link = @mysql_connect("localhost", "runehead_clans", "clandbsecret");
@mysql_select_db("runehead_clans", $link);

$searchQuery = @mysql_escape_string($_GET["user"]);
$searchQuery = @substr(str_replace("_", " ", $searchQuery), 0,12);
$searchQuery2 = @substr(str_replace(" ", "_", $searchQuery), 0,12);

$msg = "";

if (!empty($searchQuery))
{
  $sql = "SELECT username, clanname, website FROM users WHERE active='1' AND numbermembers > 0";
  $result = @mysql_query($sql);
	
  while ($row = @mysql_fetch_array($result))
	{
    $currentClan = $row["username"];
    $searchResults = @mysql_query("SELECT name FROM $currentClan WHERE name='$searchQuery' OR name='$searchQuery2'");
		
    if (@mysql_num_rows($searchResults))
	  {
       $msg .= $row["clanname"].'|'.$row["website"]."\n";
    }
  }
}
else $msg .= "@@Not Found\n";

if(empty($msg)) $msg .= "@@Not Found\n";

echo $msg;
print "@@end";
?>