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
	if (isset($_REQUEST["oldusername"]) && $_REQUEST["oldusername"] != ""){
		$oldusername = $_REQUEST["oldusername"];
	}
	if (isset($_REQUEST["newusername"]) && $_REQUEST["newusername"] != ""){
		$newusername = $_REQUEST["newusername"];
	}	
	if (isset($_REQUEST["form_submitted"]) && $_REQUEST["form_submitted"] == 1 && ($oldusername != "" || $newusername != "")){	
		$sql = "UPDATE MEMBERS SET
				RSN = '" . cleanName($newusername) . "'
				WHERE RSN = '" . cleanName($oldusername) . "'";
		mysql_query($sql);
echo "
<div class='main'>
  <h1>Manage Name Changes</h1>
  <p>" . $oldusername . " Changed to " . $newusername . " on " . mysql_affected_rows() . " memberlists.</p>
</div>
";
	}
echo "
<div class='main'>
  <form action='' method='post'>
  <h1>Manage Name Changes</h1>
    <table border='0' style='width: 50%;'>
      <tr style='text-align: center;'>
        <td class='tableborder' style='text-align: right;'>Old RuneScape Name:</td>
        <td class='tableborder' style='text-align: left;'><input name='oldusername' value='' maxlength='12' /></td>
      </tr>
      <tr style='text-align: center;'>
        <td class='tableborder' style='text-align: right;'>New RuneScape Name:</td>
        <td class='tableborder' style='text-align: left;'><input name='newusername' value='' maxlength='12' /></td>
      </tr>
      <tr style='text-align: center;'>
        <td class='tableborder' colspan='2'>
          <input type='submit' value='Submit' />
          <input type='hidden' name='form_submitted' value='1' />
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