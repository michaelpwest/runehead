<?
include_once ("../design/top.php");

$auth->checkLogin();
$user = $auth->getUser();
$log = "";
if (isset($_REQUEST["log"])){
	$log = @mysql_escape_string($_REQUEST["log"]);
}
$reporttypes = array("Select One", "Offensive", "Pointless", "Friends List", "99 Skill List", "Non-Clan", "Other");
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
	
	if (isset($_REQUEST["clear"]) && $_REQUEST["clear"] != ""){
		$clear = $_REQUEST["clear"];
		$sql = "UPDATE USERS SET
				REPORTED = '0',
				REPORTED_INFO = ''
				WHERE USERNAME = '$clear'";
 		@mysql_query($sql);				
		if (mysql_affected_rows() > 0){
echo "
<div class='main'>
  <h1>Report Cleared</h1>
  <p>Username <b>$clear</b> report cleared</p>
</div>
";
		}
	}
$sql = "SELECT USERNAME, CLANNAME, ACTIVE, CATEGORY, WEBSITE, LOGINTIME, REGISTRATIONTIME, REPORTED, REPORTED_INFO
		FROM USERS
		WHERE REPORTED != '0'
		OR REPORTED_INFO != ''
		ORDER BY CLANNAME";
$result = @mysql_query($sql);
$size = @mysql_num_rows($result);
echo "
<div class='main'>
  <h1>Manage Reports</h1>
  <p><b>$size</b> reports found</p>
";
while ($row = @mysql_fetch_array($result)){
	$username1 = $row["USERNAME"];
	$clanname = $row["CLANNAME"];
	$active = $row["ACTIVE"];
	$category = $row["CATEGORY"];
	$website = $row["WEBSITE"];
	$logintime = flipDate($row["LOGINTIME"]);
	$registrationtime = flipDate($row["REGISTRATIONTIME"]);
	$reported = $reporttypes[$row["REPORTED"]];
	$reported_info = stripslashes($row["REPORTED_INFO"]);
echo "
  <table class='contenttable' border='1' style='font-size: 11px; text-align: center;'>
    <tr class='header'"; if ($active != 1){ echo " style='background-color: #AA1100;'"; } echo ">
      <td style='width: 5%;' class='tableborder'><b>Edit</b></td>
      <td style='width: 18%;' class='tableborder'><b>Username</b></td>
      <td style='width: 22%;' class='tableborder'><b>Category</b></td>
      <td style='width: 15%;' class='tableborder'><b>Last Login</b></td>
      <td style='width: 5%;' class='tableborder'><b>Site</b></td>
      <td style='width: 15%;' class='tableborder'><b>Reason</b></td>
      <td style='width: 15%;' class='tableborder'><b>Clear Report</b></td>
      <td style='width: 5%;' class='tableborder'><b>Ban</b></td>	  
    </tr>
    <tr>
      <td style='width: 5%;' class='tableborder'><a href='manageusers.php?type=edit&amp;name=$username1' target='_blank'>Edit</a></td>
      <td style='width: 18%;' class='tableborder'><a href='ml.php?clan=$username1'>$username1</a><br />$clanname</td>
      <td style='width: 22%;' class='tableborder'>$categories[$category]</td>
	  <td style='width: 15%;' class='tableborder' title='Registration Date: $registrationtime'>$logintime</td>
      <td style='width: 5%;' class='tableborder'><a href='$website' title='$website'>Here</a></td>
      <td style='width: 15%;' class='tableborder'>$reported</td>
	  <td style='width: 15%;' class='tableborder'><a href='managereports.php?clear=$username1'>Clear Report</a></td>
	  <td style='width: 5%;' class='tableborder'><a href='managereports.php?ban=$username1'>Ban</a></td>
	</tr>
    <tr>
	  <td style='width: 100%;' class='tableborder' colspan='8'>$reported_info</td>
	</tr>
  </table>
";
}
echo "
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