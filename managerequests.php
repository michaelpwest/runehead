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
  var agree = confirm('Are you sure you want to accept all requests?');
  if (agree){
    return true;
  } else {
    return false;
  }
}
function confirmDecline() {
  var agree = confirm('Are you sure you want decline the request?');
  if (agree){
    return true;
  } else {
    return false;
  }
}
</script>
";
	if (isset($_REQUEST["acceptall"])) {
		$sql = "SELECT USERNAME, CLANNAME, REQUESTEDCLANNAME
				FROM USERS
				WHERE REQUESTEDCLANNAME != ''";
		$result = @mysql_query($sql);
		while ($row = @mysql_fetch_array($result)){
			$requsername = $row["USERNAME"];
			$clanname = $row["CLANNAME"];
			$requestedclanname = $row["REQUESTEDCLANNAME"];
			$requestedclannamemessage = date("jS M Y") . " - Clan / Group name changed from $clanname to $requestedclanname";
			$requestedclannamemessage .= "";
			if (trim($requestedclanname) != ""){		
				$sql = "UPDATE USERS SET 
						CLANNAME = '$requestedclanname',
						REQUESTEDCLANNAME = '',
						REQUESTEDCLANNAMEMESSAGE = '$requestedclannamemessage'
						WHERE USERNAME = '$requsername'";
				@mysql_query($sql);
			}
		}		
		$sql = "SELECT USERNAME, CATEGORY, REQUESTEDCATEGORY
				FROM USERS
				WHERE REQUESTEDCATEGORY != ''";
		$result = @mysql_query($sql);
		while ($row = @mysql_fetch_array($result)){
			$requsername = $row["USERNAME"];
			$category = $row["CATEGORY"];
			$requestedcategory = $row["REQUESTEDCATEGORY"];
			if ($requestedcategory != "" && $requestedcategory != 0){
				if ($requestedcategory == 1){
					$clantype = "clan";
				} else if ($requestedcategory > 1 && $requestedcategory <= sizeof($categories)){
					$clantype = "non-clan";
				}
				$requestedcategorymessage = date("jS M Y") . " - Memberlist category changed from $categories[$category] to $categories[$requestedcategory]";
				$sql = "UPDATE USERS SET 
						CATEGORY = '$requestedcategory',
						CLANTYPE = '$clantype',
						REQUESTEDCATEGORY = '0',
						REQUESTEDCATEGORYMESSAGE = '$requestedcategorymessage'
						WHERE USERNAME = '$requsername'";
				@mysql_query($sql);
			}
		}
echo "
<div class='main'>
  <h1>All Requests Accepted</h1>
</div>
";
	} else if (isset($_REQUEST["acceptcategory"]) && @mysql_escape_string($_REQUEST["acceptcategory"]) == "Acc"){
		$requsername = @mysql_escape_string($_REQUEST["requsername"]);
		$sql = "SELECT CATEGORY, REQUESTEDCATEGORY
				FROM USERS
				WHERE USERNAME = '$requsername'";
		$result = @mysql_query($sql);
		$row = @mysql_fetch_array($result);
		$category = $row["CATEGORY"];
		$requestedcategory = $row["REQUESTEDCATEGORY"];
		if ($requestedcategory != "" && $requestedcategory != 0){
			if ($requestedcategory == 1){
				$clantype = "clan";
			} else if ($requestedcategory > 1 && $requestedcategory <= sizeof($categories)){
				$clantype = "non-clan";
			}
			$requestedcategorymessage = date("jS M Y") . " - Memberlist category changed from $categories[$category] to $categories[$requestedcategory]";
			$sql = "UPDATE USERS SET 
					CATEGORY = '$requestedcategory',
					CLANTYPE = '$clantype',
					REQUESTEDCATEGORY = '0',
					REQUESTEDCATEGORYMESSAGE = '$requestedcategorymessage'
					WHERE USERNAME = '$requsername'";
			@mysql_query($sql);
echo "
<div class='main'>
  <h1>" . ucwords($requsername) . " Category Request Accepted</h1>
</div>
";
		}
	} else if (isset($_REQUEST["acceptcategory"]) && @mysql_escape_string($_REQUEST["acceptcategory"]) == "Dec"){
		$requsername = @mysql_escape_string($_REQUEST["requsername"]);
		$sql = "UPDATE USERS SET 
				REQUESTEDCATEGORY = '0'
				WHERE USERNAME = '$requsername'";
		@mysql_query($sql);
echo "
<div class='main'>
  <h1>" . ucwords($requsername) . " Category Request Declined</h1>
</div>
";
	}
	if (@mysql_escape_string($_REQUEST["acceptclanname"]) == "Acc"){
		$requsername = @mysql_escape_string($_REQUEST["requsername"]);
		$sql = "SELECT CLANNAME, REQUESTEDCLANNAME
				FROM USERS
				WHERE USERNAME = '$requsername'";
		$result = @mysql_query($sql);
		$row = @mysql_fetch_array($result);
		$clanname = $row["CLANNAME"];
		$requestedclanname = $row["REQUESTEDCLANNAME"];
		$requestedclannamemessage = date("jS M Y") . " - Clan / Group name changed from $clanname to $requestedclanname";
		$requestedclannamemessage .= "";
		if (trim($requestedclanname) != ""){		
			$sql = "UPDATE USERS SET 
					CLANNAME = '$requestedclanname',
					REQUESTEDCLANNAME = '',
					REQUESTEDCLANNAMEMESSAGE = '$requestedclannamemessage'
					WHERE USERNAME = '$requsername'";
			@mysql_query($sql);
echo "
<div class='main'>
  <h1>" . ucwords($requsername) . " Clan Name Request Accepted</h1>
</div>
";
		}
	} else if (isset($_REQUEST["acceptclanname"]) && @mysql_escape_string($_REQUEST["acceptclanname"]) == "Dec"){
		$requsername = @mysql_escape_string($_REQUEST["requsername"]);
		$sql = "UPDATE USERS SET 
				REQUESTEDCLANNAME = ''
				WHERE USERNAME = '$requsername'";
		@mysql_query($sql);
echo "
<div class='main'>
  <h1>" . ucwords($requsername) . " Clan Name Request Declined</h1>
</div>
";
	}
	$sql = "SELECT USERNAME, CLANNAME, CATEGORY, REQUESTEDCATEGORY, REQUESTEDCLANNAME, ACTIVE, REPORTED
			FROM USERS
			WHERE REQUESTEDCLANNAME != '' 
			OR REQUESTEDCATEGORY != ''";
	$result = @mysql_query($sql);
	$numrows = @mysql_num_rows($result);	
echo "
<div class='main'>
  <h1>Manage Requests</h1>
  <p>Total of <b>$numrows</b> memberlists</p>
";
	if ($numrows > 0){
echo "
  <form action='' method='post'>
  <table class='contenttable' border='1'>  
    <tr class='header'>
	  <td>Edit</td>
	  <td>Username</td>
	  <td>Category</td>	  
	  <td>Req Category</td>
 	  <td>Action</td>	
	  <td>Clanname</td>
	  <td>Req Clanname</td>	 	  	  
	  <td>Action</td>		  
	</tr>
";
		while ($row = @mysql_fetch_array($result)){
			$username = $row["USERNAME"];
			$active = $row["ACTIVE"];
			$reported = $row["REPORTED"];
			$clanname = $row["CLANNAME"];
			$category = $categories[$row["CATEGORY"]];
			$requestedcategory = $row["REQUESTEDCATEGORY"];
			if ($requestedcategory == 0){
				$requestedcategory = "* None *";
			} else {
				$requestedcategory = $categories[$requestedcategory];
			}
			$requestedclanname = $row["REQUESTEDCLANNAME"];
			if (trim($requestedclanname) == ""){
				$requestedclanname = "* None *";
			}
echo "
    <tr class='hovertr'"; if ($active != 1 || $reported != 0){ echo " style='background-color: #AA1100;'"; } echo ">
	  <td><a href='manageusers.php?type=edit&amp;name=$username' target='_blank'>Edit</a></td>
	  <td><a href='ml.php?clan=$username'>$username</a><input type='hidden' name='requsername' value='$username' />
	  </td>
	  <td>$category</td>	  
	  <td>$requestedcategory</td>
	  <td>"; if ($requestedcategory != "* None *"){ echo "<a href='managerequests.php?acceptcategory=Acc&amp;requsername=$username'>Acc</a><br /><a href='managerequests.php?acceptcategory=Dec&amp;requsername=$username' onclick='return confirmDecline();'>Dec</a>"; } else { echo "&nbsp;"; } echo "</td>
	  <td>$clanname</td>
	  <td>$requestedclanname</td>
	  <td>"; if ($requestedclanname!= "* None *"){ echo "
	    <a href='managerequests.php?acceptclanname=Acc&amp;requsername=$username'>Acc</a><br /><a href='managerequests.php?acceptclanname=Dec&amp;requsername=$username' onclick='return confirmDecline();'>Dec</a>"; } else { echo "&nbsp;"; } echo "
	  </td>
	</tr>
";
		}
echo "
  </table>
  <table style='margin-top: 0px;'>
    <tr style='text-align: center;'>
	  <td>
	    <a href='managerequests.php?acceptall=true' onclick='return confirmAll();'>Accept All</a>
	  </td>
	</tr>
  </table>
";
	}
echo "
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