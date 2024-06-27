<?
include_once ("../design/top.php");
echo "
<div class='main'>
  <h1>Forgot Password</h1>
";
$error = 0;
$username = "";
$emailaddress = "";
$userdigit = 0;
if (isset($_REQUEST["form_submitted"]) && @mysql_escape_string($_REQUEST["form_submitted"]) == 1){
	$username = trim(@mysql_escape_string($_REQUEST["forgotusername"]));
	$emailaddress = trim(@mysql_escape_string($_REQUEST["forgotemailaddress"]));
	$userdigit = @mysql_escape_string($_REQUEST["userdigit"]);	
	$sql = "SELECT EMAIL, ACTIVE, VALIDATED
			FROM USERS
			WHERE USERNAME = '$username'";
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$active = $row["ACTIVE"];
	$validated = $row["VALIDATED"];
	if (@mysql_num_rows($result) > 0){
		if ($active != 2 && $validated == 1){
			if (strtolower($emailaddress) == strtolower($row["EMAIL"])){
				include_once ("audit.php");
				if ($userdigit != "" && audit() == true) {
					$password = generatePassword();
					$password2 = $password;
					$password = md5($password);
					$sql = "UPDATE USERS SET
							PASSWORD = '$password'
							WHERE USERNAME = '$username'";
					@mysql_query($sql);
					$headers = "From: Hiscores@RuneHead.com\n";
					$headers .= "Reply-To: Hiscores@RuneHead.com\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/html; charset='iso-8859-1'\n";
					$emailmsg = "
<html>
  <body>
    <p>You requested your password to be reset under the Forgot Password page.<br />
    Your new account details are:<br />
	Username: $username<br />
    Password: $password2<br />
	You can login through <a href='http://www.runehead.com/clans/admin.php'>http://www.runehead.com/clans/admin.php</a><br />
    Thanks,<br />
    RuneHead Staff.</p>
  </body>
</html>
					";
					mail($emailaddress, 'The RuneHead Hiscores Catalogue - Forgot Password?', $emailmsg, $headers);			
echo "
  <p>Your password has been reset. The new password will be sent to your email.
  If you don't receive the email in your inbox please check the <b>Junk / Spam Mail Box</b>
  if your email provides one.</p>
</div>
";
				} else {
					$error = 1;
					echo "<p><b>Image validation code is incorrect</b></p>";
				}
			} else {
				$error = 1;
				echo "<p><b>Email did not match the username</b></p>";		
			}
		} else {
			if ($active == 2 || $validated == 2){
				$error = 1;			
				echo "<p><b>Account is no longer available</b></p>";
			} else if ($validated == 0){
				$error = 1;
				echo "<p><b>Your account needs to be validated before you can use this feature</b></p>";			
			}
		}
	} else {
		$error = 1;
		echo "<p><b>Username was not found</b></p>";
	}
}
if ($error == 1 || (!isset($_REQUEST["form_submitted"]))){
echo "
  <div class='justify'>
    <form action='forgot.php' method='post'>
      <p>To reset your password enter both the username and email address you registered with below.
	  Your new password will be sent to your email.<br /><br />
	  <span class='success'>Note: After this feature is used your old password with no longer work.<br />
	  If you don't receive the email in your inbox please check the <b>Junk / Spam Mail Box</b>
	  if your email provides one.
	  </span></p>
      <table border='0' style='width: 520px;'>
        <tr>
          <td>Username:</td>
          <td><input name='forgotusername' style='width: 250px;' value='$username' maxlength='12' /></td>
        </tr>
        <tr>
          <td>Email Address:</td>
          <td><input name='forgotemailaddress' style='width: 250px;' value='$emailaddress' /></td>
        </tr>
        <tr>
          <td>Image Validation Code:</td>
          <td><input name='userdigit' style='width: 250px;' value='' maxlength='5' /></td>
        </tr>
        <tr>
          <td colspan='2' style='text-align:center;'> <img src='button.php?" . rand(1,10000) . "' alt='' /></td>
        </tr>		
        <tr>
          <td colspan='2' style='text-align: center;'><input type='hidden' value='1' name='form_submitted' /><input type='submit' value='Submit' /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
";
}
include_once ("../design/bottom.php");
?>