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
  function confirmAll() {
    var agree = confirm('Are you sure you want to accept all memberlists?');
    if (agree){
      return true;
    } else {
      return false;
    }
  }
  function msg1(){
    document.getElementById('deniedmsg').value = \"Sorry, the RuneHead Hiscores Catalogue is not for friendlists.\";
  }
  function msg2(){
    document.getElementById('deniedmsg').value = \"Offensive memberlists are against the RuneHead Hiscores Catalogue guidelines.\";
  }
  function msg3(){
    document.getElementById('deniedmsg').value = \"Sorry, the RuneHead Hiscores Catalogue is only for proper clan or non-clans groups.\";
  }
  function msg4(){
    document.getElementById('deniedmsg').value = \"Sorry, the RuneHead Hiscores Catalogue is not for 99 skill lists.\";
  } 
  function redirect(currentusername){
  	window.location = 'manageregister.php?decline=' + currentusername + '&deniedmsg=' + document.getElementById(\"deniedmsg\").value + '';
  }
  function website(id){
    if (document.getElementById('websitecheck[' + id + ']').value == 'false'){
      document.getElementById('website[' + id + ']').innerHTML = document.getElementById('websitefull[' + id + ']').value;
	  document.getElementById('websitecheck[' + id + ']').value = 'true';
	} else {
      document.getElementById('website[' + id + ']').innerHTML = document.getElementById('websiteshort[' + id + ']').value;	
	  document.getElementById('websitecheck[' + id + ']').value = 'false';
	}
  } 
</script>
";	
	if (isset($_REQUEST["acceptall"])) {
		$sql = "SELECT USERNAME, EMAIL, VALIDATED
				FROM USERS
				WHERE VALIDATED = '0'
				ORDER BY CLANNAME";
		$result = @mysql_query($sql);
		if (@mysql_num_rows($result) > 0){
			while ($row = @mysql_fetch_array($result)){
				$username = $row["USERNAME"];
				$email = $row["EMAIL"];
				$validated = $row["VALIDATED"];
				if ($validated == 0){
					$password = generatePassword();
					$password2 = $password;
					$password = md5($password);		
					$headers = "From: Hiscores@RuneHead.com\n";
					$headers .= "Reply-To: Hiscores@RuneHead.com\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/html; charset='iso-8859-1'\n";
					$emailmsg = "
<html>
  <body>
    <p>Your RuneHead Hiscores Catalogue memberlist has been validated and now is usable.<br /><br />
	Memberlist URL: <a href='http://www.runehead.com/clans/ml.php?clan=$username'>http://www.runehead.com/clans/ml.php?clan=$username</a><br />
    Username: $username<br />
    Password: $password2<br /><br />
    To activate your account log into the Admin Control Panel at <a href='http://www.runehead.com/clans/admin.php'>http://www.runehead.com/clans/admin.php</a><br />
    In the Admin Control Panel you will be able to modify your memberlist to get it to how you want it.<br /><br />
    For information on how the Admin Control Panel works visit <a href='http://www.runehead.com/clans/admincphelp.php'>http://www.runehead.com/clans/admincphelp.php</a><br /><br />	
    We hope you enjoy using your RuneHead Hiscores Catalogue Memberlist.<br /><br />
    Thanks,<br />
    RuneHead Staff.</p>
  </body>
</html>
					";
					mail($email, "RuneHead Hiscores Catalogue - Account Validated", $emailmsg, $headers);
					$sql = "UPDATE USERS SET
							PASSWORD = '$password',
							VALIDATED = '1'
							WHERE USERNAME = '$username'";
					@mysql_query($sql);	
				}
			}
echo "
<div class='main'>
  <h1>Validation</h1>
  <p><b>All memberlists validated</b></p>
</div>
";
		}			
	} else if (isset($_REQUEST["accept"])){
		$accept = $_REQUEST["accept"];
		$sql = "SELECT USERNAME, EMAIL, VALIDATED
				FROM USERS
				WHERE USERNAME = '$accept'
				AND VALIDATED = '0'";
		$result = @mysql_query($sql);		
		if (@mysql_num_rows($result) > 0){
			$row = @mysql_fetch_array($result);
			$username = $row["USERNAME"];
			$email = $row["EMAIL"];
			$validated = $row["VALIDATED"];
			if ($validated == 0){
				$password = generatePassword();
				$password2 = $password;
				$password = md5($password);		
				$headers = "From: Hiscores@RuneHead.com\n";
				$headers .= "Reply-To: Hiscores@RuneHead.com\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: text/html; charset='iso-8859-1'\n";
				$emailmsg = "
<html>
  <body>
    <p>Your RuneHead Hiscores Catalogue memberlist has been validated and now is usable.<br /><br />
	Memberlist URL: <a href='http://www.runehead.com/clans/ml.php?clan=$username'>http://www.runehead.com/clans/ml.php?clan=$username</a><br />
    Username: $username<br />
    Password: $password2<br /><br />
    To activate your account log into the Admin Control Panel at <a href='http://www.runehead.com/clans/admin.php'>http://www.runehead.com/clans/admin.php</a><br />
    In the Admin Control Panel you will be able to modify your memberlist to get it to how you want it.<br /><br />
    For information on how the Admin Control Panel works visit <a href='http://www.runehead.com/clans/admincphelp.php'>http://www.runehead.com/clans/admincphelp.php</a><br /><br />	
    We hope you enjoy using your RuneHead Hiscores Catalogue Memberlist.<br /><br />
    Thanks,<br />
    RuneHead Staff.</p>
  </body>
</html>
				";
				mail($email, "RuneHead Hiscores Catalogue - Account Validated", $emailmsg, $headers);
				$sql = "UPDATE USERS SET
						PASSWORD = '$password',
						VALIDATED = '1'
						WHERE USERNAME = '$username'";
				@mysql_query($sql);
echo "
<div class='main'>
  <h1>Validation</h1>
  <p><b>$accept validated</b></p>
</div>
";
			}
		}
	} else if (isset($_REQUEST["decline"])){
		$decline = $_REQUEST["decline"];
		$sql = "SELECT USERNAME, EMAIL, VALIDATED
				FROM USERS
				WHERE USERNAME = '$decline'
				AND VALIDATED = '0'";
		$result = @mysql_query($sql);
		if (@mysql_num_rows($result) > 0 && $_REQUEST["deniedmsg"] != ""){
			$row = @mysql_fetch_array($result);
			$username = $row["USERNAME"];
			$email = $row["EMAIL"];		
			$headers = "From: Hiscores@RuneHead.com\n";
			$headers .= "Reply-To: Hiscores@RuneHead.com\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset='iso-8859-1'\n";
			$deniedmsg = $_REQUEST["deniedmsg"];
			$emailmsg = "
<html>
  <body>
    <p>Unfortuantely your RuneHead Hiscores Memberlist validation has been denied for the reason:<br />
	$deniedmsg<br /><br />
	If you feel this has been done in error, please reply to this email.<br /><br />
	Thanks,<br />
    RuneHead Staff.</p>
  </body>
</html>
			";
			echo $emailmsg;		
			mail($email, "RuneHead Hiscores Catalogue - Account Validation Denied", $emailmsg, $headers);
			$sql = "UPDATE USERS SET
					VALIDATED = '2'
					WHERE USERNAME = '$decline'";
			@mysql_query($sql);	
		}
	}
	$sql = "SELECT USERNAME, CLANNAME, CATEGORY, EMAIL, WEBSITE
			FROM USERS
			WHERE VALIDATED = '0'
			ORDER BY CATEGORY, CLANNAME";
	$result = @mysql_query($sql);
	$numrows = @mysql_num_rows($result);	
echo "
<div class='main'>
  <h1>Manage Validation</h1>
  <p>Total of <b>$numrows</b> memberlists</p>
";
	$categoryTemp = "";
	$a = 0;
	while ($row = @mysql_fetch_array($result)){
		$category = $categories[$row["CATEGORY"]];	
		if ($category != $categoryTemp){			
			$categoryTemp = $category;
			if ($a != 0){
echo "
  </table>
";
			}
echo "
  <h2 style='color: #FFD700;'>$category</h2>
  <table class='contenttable' border='1'>
    <tr class='header'>
	  <td style='width: 18%;'>Username</td>
	  <td style='width: 30%;'>Name</td>
	  <td style='width: 40%;'>Website</td>	  
	  <td style='width: 12%;'>Action</td>
	</tr>
";
		}		
		$currentusername = $row["USERNAME"];
		$clanname = $row["CLANNAME"];

		$email = $row["EMAIL"];
		$website = $row["WEBSITE"];	
echo "
	<tr class='hovertr'>
	  <td><a href='ml.php?clan=$currentusername'>$currentusername</a></td>
	  <td>$clanname</td>
	  <td style='font-size: 11px; font-family: courier new;'>
	    <a id='website[$a]' title='$website' onclick='website($a);'>" . substr($website, strpos($website, "://") + 3, 36) . "</a>
		<input type='hidden' id='websiteshort[$a]' value='" . substr($website, strpos($website, "://") + 3, 36) . "' />
		<input type='hidden' id='websitefull[$a]' value='" . wordwrap($website, 50, "\n", true) . "' />
		<input type='hidden' id='websitecheck[$a]' value='false' />
	  </td>
	  <td>
	    <a href='manageregister.php?accept=$currentusername' title='Accept'>Acc</a> /
        <a onclick=\"redirect('$currentusername');\" style='cursor: pointer; text-decoration: underline;' title='Decline'>Dec</a>
	  </td>
	</tr>
";
		$a++;
	}
echo "
  </table>
";
	if (mysql_num_rows($result) > 0){
echo "
  <table style='margin-top: 0px;'>
    <tr style='text-align: center;'>
	  <td>
	    <a href='manageregister.php?acceptall=true' onclick='return confirmAll();'>Accept All</a>
	  </td>
	</tr>
  </table>
  <table>
    <tr style='text-align: center;'>
	  <td>Denied Message<br /><textarea id='deniedmsg' name='deniedmsg' rows='4' cols='50'></textarea></td>
	</tr>
    <tr style='text-align: center;'>
      <td>
        <a onclick='msg1();' style='cursor: pointer;'>Friendlist</a>
        |
        <a onclick='msg2();' style='cursor: pointer;'>Offensive</a>
		|
        <a onclick='msg3();' style='cursor: pointer;'>Pointless</a>
        |
        <a onclick='msg4();' style='cursor: pointer;'>99 Skill List</a>
      </td>
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