<?
include_once ("../design/top.php");

$auth->checkLogin();
$user = $auth->getUser();
$log = "";
if (isset($_REQUEST["log"])){
	$log = @mysql_escape_string($_REQUEST["log"]);
}
if ($auth->checkAuth() === "moderator"){
echo "
<div class='main' style='text-align: center; font-size: 11px;'>
  <p><a href='managecensor.php'>Censor</a> |
  <a href='manageimages.php'>Images</a> |
  <a href='managemembers.php'>Removals</a> |
  <a href='managenamechanges.php'>Name Changes</a> |  
  <a href='managemailpassword.php'>Passwords</a> |
  <a href='managereports.php'>Reports</a> |
  <a href='managerequests.php'>Requests</a> |
  <a href='manageusers.php'>Manage Users</a> |
  <a href='manageregister.php'>Validation</a></p>
</div>
<script type='text/javascript'>
function confirmDelete() {
  var agree = confirm('Are you sure you want delete this member?');
  if (agree){
    return true;
  } else {
    return false;
  }
}
function selectmember(a){
  if (document.getElementById('usernamearray' + a).checked == true){
    document.getElementById('usernamearray' + a).checked = false;
	document.getElementById('usernamerow' + a).bgColor = '#000000';
  } else {
    document.getElementById('usernamearray' + a).checked = true;
	document.getElementById('usernamerow' + a).bgColor = '#777777';
  }
}
</script>
";	

	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "delete"){
		$rsn = @mysql_escape_string($_REQUEST["rsn"]);
		$username = @mysql_escape_string($_REQUEST["username"]);
		$usernamearray = $_REQUEST["usernamearray"];
		for ($a = 0; $a < sizeof($usernamearray); $a++){
			if ($rsn != "" && $usernamearray[$a] != ""){
				$sql = "DELETE FROM MEMBERS
						WHERE RSN = '$rsn'
						AND USERNAME = '" . $usernamearray[$a] . "'";
				@mysql_query($sql);
			}
		}
		$user = $username;
		include_once("updateaverages.php");
		include_once("auth.php");	
		$user = $auth->getUser();
	}
	
	$searchQuery = @mysql_escape_string(trim($_REQUEST["search"]));
	$searchQuery = cleanName($searchQuery);
	$search = $searchQuery;

echo "
<div class='main'>
  <h1>Manage Name Removals</h1>
";

	if ($searchQuery){
		$found = 0;
		$total = 0;
		$sql = "SELECT U.USERNAME, U.CLANNAME, U.WEBSITE, M.RSN, M.RANK, M.COMBAT
				FROM MEMBERS M, USERS U
				WHERE U.USERNAME = M.USERNAME
				AND U.ACTIVE = '1'
				AND U.VALIDATED = '1'
				AND M.RSN = '$searchQuery'
				ORDER BY U.USERNAME";
		$result = @mysql_query($sql);
		$size = @mysql_num_rows($result);
		if ($size > 0){
echo "
  <p>The search <b>$searchQuery</b> returned <b>$size</b> result(s):</p>
  <form action='' method='post'>
  <table class='contenttable' border='1'>
    <tr class='header'>
      <td style='width: 6%;' class='tableborder'><b>Edit</b></td>
	  <td style='width: 20%;' class='tableborder'><b>RSN</b></td>
      <td style='width: 20%;' class='tableborder'><b>Username</b></td>
	  <td style='width: 20%;' class='tableborder'><b>Memberlist</b></td>
      <td style='width: 5%;' class='tableborder'><b>Website</b></td>	  
      <td style='width: 19%;' class='tableborder'><b>Rank</b></td>
      <td style='width: 10%;' class='tableborder'><b>Combat</b></td>
    </tr>
";
			$a = 0;
			while ($row = @mysql_fetch_array($result)){
				$username = $row["USERNAME"];
				$clanname = $row["CLANNAME"];
				$website = $row["WEBSITE"];
				if ($website == ""){
					$website = "http://";
				}
				$rsn = $row["RSN"];
				$rank = strtoupper($row["RANK"]);
				$sql = "SELECT $rank
						FROM RANKS
						WHERE USERNAME = '$username'";
				$rankResult = @mysql_query($sql);
				$rankRow = @mysql_fetch_array($rankResult);
				$rank = $rankRow[$rank];
				$combat = $row["COMBAT"];
echo "
    <tr style='text-align: center;' id='usernamerow$a' onclick='selectmember($a)'>
	  <td class='tableborder'>
	    <input type='checkbox' id='usernamearray$a' name='usernamearray[]' value='$username' style='display: none;' />
		<input type='hidden' name='rsn' value='$rsn' />
		<input type='hidden' name='search' value='$search' />
		<input type='hidden' name='type' value='delete' />
		<a href='manageusers.php?type=edit&amp;name=$username' target='_blank'>Edit</a>
	  </td>
	  <td class='tableborder'><b>$rsn</b></td>
      <td class='tableborder'><a href='ml.php?clan=$username' target='_blank'>$username</a></td>
	  <td class='tableborder'><a href='ml.php?clan=$username' target='_blank'>$clanname</a></td>
	  <td class='tableborder'><a href='$website' target='_blank'>Here</a></td>
      <td class='tableborder'>$rank</td>
      <td class='tableborder'>$combat</td>
    </tr>
";
				$a++;
			}
echo "
  </table>
  <table style='width: 450px; margin: 5px auto;' border='0' cellpadding='2'>
    <tr style='text-align: center;'>
	  <td><input type='submit' value='Remove' onclick='return confirmDelete();' /></td>
	</tr>
  </table>
  </form>
";
		} else {
			echo "<p>No results were found for the search <b>$searchQuery</b></p>";
		}
	}
echo "
  <form action='' method='post'>
    <table style='text-align: center;'>
      <tr>
        <td>
          <input name='search' id='search' value='$search' maxlength='12' onclick='document.getElementById(\"search\").select();' />
          <input type='submit' value='Search' />
        </td>
      </tr>
    </table>
  </form>
</div>
";
} else {
echo "
<div class='main'>
  <h1>Moderator Control Panel</h1>
  <form action='' method='post' style='display: inline;'>
    <table style='width: 196px; margin: 5px auto;' cellpadding='2'>
      <tr>
        <td>Username:</td><td><input name='loginusername' value='$user' maxlength='12' style='width: 150px;' /></td>
      </tr>
      <tr>
        <td>Password:</td><td><input name='loginpassword' type='password' style='width: 150px;' onkeypress='capsDetect(event);' onkeyup='capsToggle(event);' onblur='capsReset(event);' /></td>
      </tr>
  	  <tr style='height:0px;'>
	    <td colspan='2'><div id='capsWarningAdmin' style='display: none; color: #FFD700;'>Warning: Caps Lock On</div></td>
	  </tr>
";
if ($log == "Login"){
echo "
      <tr>
	    <td colspan='2' style='color: #FFD700;'>Login Incorrect.</td>
  	  </tr>
";
}
echo "
      <tr>
        <td colspan='2'><input type='submit' name='log' value='Login' /></td>
      </tr>
    </table>
  </form>
</div>
";
}
include ("../design/bottom.php");
?>