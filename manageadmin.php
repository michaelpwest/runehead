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
<div class='main'>
  <h1>Manage Admin</h1>
  <p><a href='managecensor.php'>Manage Censor</a></p>
  <p><a href='manageimages.php'>Manage Images</a></p>
  <p><a href='managemembers.php'>Manage Name Removals</a></p>
  <p><a href='managenamechanges.php'>Manage Name Changes</a></p>  
  <p><a href='managemailpassword.php'>Manage Mail Password</a></p>
  <p><a href='managereports.php'>Manage Reports</a></p>  
  <p><a href='managerequests.php'>Manage Requests</a></p>
  <p><a href='manageusers.php'>Manage Users</a></p>  
  <p><a href='manageregister.php'>Manage Validation</a></p>
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