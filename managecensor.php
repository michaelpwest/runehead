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
";		
	if (isset($_REQUEST["ban"]) && $_REQUEST["ban"] != ""){
		$ban = $_REQUEST["ban"];
		$sql = "UPDATE USERS SET
				ACTIVE = '2',
				REPORTED = '0',
				REPORTED_INFO = ''
				WHERE USERNAME = '$ban'";
 		@mysql_query($sql);				
		if (mysql_affected_rows() > 0){
echo "
<div class='main'>
  <h1>Ban</h1>
  <p>Username <b>$ban</b> banned</p>
</div>
";
		}
	}
	$resultsArray = array();
	$fileopen = fopen ("censor/censor.txt", "r");
	if ($fileopen) {
		$a = 0;
		while (!feof($fileopen)) {
			$lines[] = fgets($fileopen, 4096);
			$search = trim($lines[$a]);
			if ($a > 0){			
				$sql = "SELECT U.USERNAME, U.CLANNAME, U.INITIALS, U.LOGINTIME, U.REGISTRATIONTIME
						FROM USERS U, RANKS R
						WHERE U.ACTIVE = '1'
						AND U.VALIDATED = '1'
						AND U.USERNAME = R.USERNAME
						AND (U.USERNAME LIKE '%$search%'
						OR (U.CLANNAME LIKE '%$search%')
						OR (U.INITIALS LIKE '%$search%')
						OR (U.WEBSITE LIKE '%$search%')
						OR (R.RANK1 LIKE '%$search%')
						OR (R.RANK2 LIKE '%$search%')
						OR (R.RANK3 LIKE '%$search%')
						OR (R.RANK4 LIKE '%$search%')
						OR (R.RANK5 LIKE '%$search%')
						OR (R.RANK6 LIKE '%$search%')
						OR (R.RANK7 LIKE '%$search%')
						OR (R.RANK8 LIKE '%$search%')
						OR (R.RANK9 LIKE '%$search%')
						OR (R.RANK10 LIKE '%$search%')
						OR (R.RANK11 LIKE '%$search%')
						OR (R.RANK12 LIKE '%$search%')
						OR (R.RANK13 LIKE '%$search%')
						OR (R.RANK14 LIKE '%$search%')
						OR (R.RANK15 LIKE '%$search%')
						OR (R.RANK16 LIKE '%$search%'))
						ORDER BY U.CLANNAME";
				$result = @mysql_query($sql);
				while ($row = @mysql_fetch_array($result)){
					$found = false;
					for ($b = 0; $b < sizeof($resultsArray); $b++){
						if ($resultsArray[$b][1] == $row["USERNAME"]){
							$found = true;
							$value = $b;
							break;
						}
					}
					if ($found){
						$resultsArray[$value][0] .= ", $search";
					} else {					
						$resultsArray[] = array($search, $row["USERNAME"], $row["CLANNAME"], $row["INITIALS"], $row["LOGINTIME"], $row["REGISTRATIONTIME"]);
					}
				}
			}
			$a++;
		}
		fclose($fileopen);
	}
echo "
<div class='main'>
  <h1>Manage Censor</h1>
  <p><b>" . sizeof($resultsArray) . "</b> results found:</p>
  <div style='max-height: 400px; overflow: auto; overflow-x: hidden;'>
    <table class='contenttable' border='1'>
      <tr class='header'>
	    <td style='width: 10%;' class='tableborder'><b>Edit</b></td>
        <td style='width: 20%;' class='tableborder'><b>Word(s)</b></td>	  
        <td style='width: 25%;' class='tableborder'><b>Clan Name</b></td>
        <td style='width: 15%;' class='tableborder'><b>Initials</b></td>
        <td style='width: 20%;' class='tableborder'><b>Login Time</b></td>
        <td style='width: 10%;' class='tableborder'><b>Action</b></td>		
      </tr>
";	
	for ($a = 0; $a < sizeof($resultsArray); $a++){
echo "
      <tr class='hovertr' style='cursor: default;'>
        <td class='tableborder'><a href='manageusers.php?type=edit&amp;name=" . $resultsArray[$a][1] . "' target='_blank'>Edit</a></td>
		<td class='tableborder'>" . $resultsArray[$a][0] . "</td>
        <td class='tableborder'><a href='ml.php?clan=" . $resultsArray[$a][1] . "'>" . $resultsArray[$a][1] . "</a><br />" . $resultsArray[$a][2] . "</td>
        <td class='tableborder'>" . $resultsArray[$a][3] . "</td>
        <td class='tableborder' title='Registration Date: " . $resultsArray[$a][5] . "'>" . $resultsArray[$a][4] . "</td>
        <td class='tableborder'><a href='managecensor.php?ban=" . $resultsArray[$a][1] . "'>Ban</a></td>
      </tr>
";
	}			
echo "
    </table>
  </div>
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