<?
// If auth.php file is accessed directly, redirect to index.php
if (substr($_SERVER["PHP_SELF"], -9, 9) == "login.php"){
	echo "<meta http-equiv='Refresh' content='0; url=index.php'>";	
	exit();
}

$auth->checkLogin();
$user = $auth->getUser();
echo "<script type='text/javascript' src='login.js'></script>";

if ($user != ""){
	if (isset($_REQUEST["log"]) && @mysql_escape_string($_REQUEST["log"]) == "Logout"){
		$auth->logout();
		$user = "";
echo "
<form action='admin.php' method='post' style='display:inline;'>
  <table style='width:196px; margin: 5px auto;' cellpadding='2'>
    <tr>
      <td>Username:</td><td><input name='loginusername' value='$user' maxlength='12' style='width:100px;' /></td>
    </tr>
    <tr>
      <td>Password:</td><td><input name='loginpassword' type='password' style='width:100px;' onkeypress='capsDetect(event);' onkeyup='capsToggle(event);' onblur='capsReset(event);' /></td>
    </tr>
    <tr>
	  <td colspan='2' style='color: #FFD700;'>Logged Out.</td>
	</tr>
	<tr>
	  <td colspan='2'><div id='capsWarning' style='display: none; color: #FFD700;'>Warning: Caps Lock On</div></td>
	</tr>	
    <tr>
      <td><input type='submit' name='log' value='Login' /></td>
      <td><a href='forgot.php' style='font-size: 12px;'>Forgot Password</a></td>
    </tr>	
  </table>
</form>	
";
	} else if ($auth->checkAuth() == true){
echo "
<form action='index.php' method='post' style='display:inline;'>
  <table style='width:190px; margin: 10px auto;' cellpadding='2'>
    <tr>
      <td>Logged in as $user<br /></td>
    </tr>
    <tr>
      <td><a href='admin.php'>Admin Control Panel<br /></a></td>
    </tr>
    <tr>
      <td><a href='ml.php?clan=$user'>View Memberlist<br /></a></td>
    </tr>
    <tr>
      <td><input type='submit' name='log' value='Logout' /></td>
    </tr>
  </table>
</form>
";
	} else if ($auth->checkAuth() == false){
echo "
<form action='admin.php' method='post' style='display:inline;'>
  <table style='width:196px; margin: 5px auto;' cellpadding='2'>
    <tr>
      <td>Username:</td><td><input name='loginusername' value='$user' maxlength='12' style='width:100px;' /></td>
    </tr>
    <tr>
      <td>Password:</td><td><input name='loginpassword' type='password' style='width:100px;' onkeypress='capsDetect(event);' onkeyup='capsToggle(event);' onblur='capsReset(event);' /></td>
    </tr>
    <tr>
	  <td colspan='2' style='color: #FFD700;'>Login Incorrect.</td>
	</tr>
	<tr>
	  <td colspan='2'><div id='capsWarning' style='display: none; color: #FFD700;'>Warning: Caps Lock On</div></td>
	</tr>	
    <tr>
      <td><input type='submit' name='log' value='Login' /></td>
      <td><a href='forgot.php' style='font-size: 12px;'>Forgot Password</a></td>
    </tr>
  </table>
</form>
";
	}
} else {
echo "
<form action='admin.php' method='post' style='display:inline;'>
  <table style='width:196px; margin: 5px auto;' cellpadding='2'>
    <tr>
      <td>Username:</td>
	  <td><input name='loginusername' value='$user' maxlength='12' style='width:100px;' /></td>
    </tr>
    <tr>
      <td>Password:</td>
	  <td><input name='loginpassword' type='password' style='width:100px;' onkeypress='capsDetect(event);' onkeyup='capsToggle(event);' onblur='capsReset(event);' /></td>
    </tr>
	<tr>
	  <td colspan='2'><div id='capsWarning' style='display: none; color: #FFD700;'>Warning: Caps Lock On</div></td>
	</tr>
    <tr>
      <td><input type='submit' name='log' value='Login' /></td>
      <td><a href='forgot.php' style='font-size: 12px;'>Forgot Password</a></td>
    </tr>
  </table>
</form>
";
}
?>