<?
include_once ("../design/top.php");

$auth->checkLogin();
$user = $auth->getUser();
$log = "";
if (isset($_REQUEST["log"])){
	$log = @mysql_escape_string($_REQUEST["log"]);
}
if ($auth->checkAuth() === "moderator"){
	if (isset($_REQUEST["usernamesearch"]) && $_REQUEST["usernamesearch"] != ""){
		$usernamesearch = $_REQUEST["usernamesearch"];
	}
	if (isset($_REQUEST["emailsearch"]) && $_REQUEST["emailsearch"] != ""){
		$emailsearch = $_REQUEST["emailsearch"];
	}	
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
	if (isset($_REQUEST["form_submitted"]) && $_REQUEST["form_submitted"] == 1 && ($usernamesearch != "" || $emailsearch != "")){	
		$sql = "SELECT USERNAME
				FROM USERS";
		if ($usernamesearch != ""){
			$sql .= " WHERE USERNAME = '$usernamesearch'";
		} else if ($emailsearch != ""){
			$sql .= " WHERE EMAIL = '$emailsearch'";
		}
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			
			$username1 = $row["USERNAME"];
			$password1 = generatePassword();
			
			$sql = "UPDATE USERS SET
					PASSWORD = '" . md5($password1) . "',
					VALIDATED = '1'
					WHERE USERNAME = '$username1'";
			mysql_query($sql);
		
			$message = "
	Hi,<br /><br />
	Try these details:<br />
	Username: $username1<br />
	Password: $password1<br /><br />
	Let me know if there are any problems.
			";	
echo "
<div class='main'>
  <h1>Manage Mail Password</h1>
  <p>$message</p>
</div>
";
		} else {
echo "
<div class='main'>
  <h1>Manage Mail Password</h1>
  <p>No results found</p>
</div>
";
		}
	}
echo "
<form action='' method='post'>
  <div class='main'>
    <h1>Manage Mail Password</h1>
    <table border='0' style='width: 40%;'>
      <tr style='text-align: center;'>
        <td class='tableborder' style='text-align: right;'>Username:</td>
        <td class='tableborder' style='text-align: left;'><input name='usernamesearch' value='' style='width: 200px;' /></td>
      </tr>
      <tr style='text-align: center;'>
        <td class='tableborder' style='text-align: right;'>Email:</td>
        <td class='tableborder' style='text-align: left;'><input name='emailsearch' value='' style='width: 200px;' /></td>
      </tr>
      <tr style='text-align: center;'>
        <td class='tableborder' colspan='2'>
          <input type='submit' value='Submit' />
          <input type='hidden' name='form_submitted' value='1' />
        </td>
      </tr>
    </table>
  </div>
</form>
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