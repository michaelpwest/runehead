<?
include_once ("../design/top.php");

$auth->checkLogin();
$user = $auth->getUser();
$log = "";
$clear1 = "";
$clear2 = "";
$clear3 = "";
$clearimage = "";
$clearimagerequest = "";
if (isset($_REQUEST["log"])){
	$log = @mysql_escape_string($_REQUEST["log"]);
}
if (isset($_REQUEST["clear1"])){
	$clear1 = @mysql_escape_string($_REQUEST["clear1"]);
}
if (isset($_REQUEST["clear2"])){
	$clear2 = @mysql_escape_string($_REQUEST["clear2"]);
}
if (isset($_REQUEST["clear3"])){
	$clear3 = @mysql_escape_string($_REQUEST["clear3"]);
}
if (isset($_REQUEST["clearimage"])){
	$clearimage = @mysql_escape_string($_REQUEST["clearimage"]);
}
if (isset($_REQUEST["clearimagerequest"])){
	$clearimagerequest = @mysql_escape_string($_REQUEST["clearimagerequest"]);
}
$msg = "";
$homeworldlimit = 169;
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
} else {
	$id = "";
}

if ($auth->checkAuth() == true){
	$fontfamilyArray = array("Verdana", "Arial", "Tahoma");
	$sql = "SELECT *
			FROM USERS
			WHERE USERNAME = '$user'";
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$email = $row["EMAIL"];
	$active = $row["ACTIVE"];
	$validated = $row["VALIDATED"];
	$clanname = $row["CLANNAME"];
	$image = $row["CLANIMAGE"];
	$bgcolour = $row["BGCOLOUR"];
	$tablecolour = $row["TABLECOLOUR"];
	$fontcolour1 = $row["FONTCOLOUR1"];
	$fontcolour2 = $row["FONTCOLOUR2"];
	$headerfont = $row["HEADERFONT"];
	$headerbg = $row["HEADERBG"];
	$bordercolour = $row["BORDERCOLOUR"];
	$personalfont = $row["PERSONALFONT"];
	$website = $row["WEBSITE"];
	$irc = $row["IRC"];
	$fontfamily = $row["FONTFAMILY"];
	$displaytype = $row["DISPLAYTYPE"];
	$requestedcategory = $row["REQUESTEDCATEGORY"];
	$requestedclanname = $row["REQUESTEDCLANNAME"];
	$requestedimage = $row["REQUESTEDIMAGE"];
	$requestedcategorymessage = $row["REQUESTEDCATEGORYMESSAGE"];
	$requestedclannamemessage = $row["REQUESTEDCLANNAMEMESSAGE"];
	$requestedimagemessage = $row["REQUESTEDIMAGEMESSAGE"];
	if ($clear1 == "Clear"){
		$sql = "UPDATE USERS SET
			  	REQUESTEDCATEGORYMESSAGE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Last Change Made - Memberlist Category message cleared</span><br />";
	} else if ($clear2 == "Clear"){
		$sql = "UPDATE USERS SET
				REQUESTEDCLANNAMEMESSAGE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Last Change Made - Clan / Group Name message cleared</span><br />";
	} else if ($clear3 == "Clear"){
		$sql = "UPDATE USERS SET
				REQUESTEDIMAGEMESSAGE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Last Change Made - Clan / Group Banner URL message cleared</span><br />";
	} else if ($clearimage == "Clear"){
		$sql = "SELECT CLANIMAGE
				FROM USERS
				WHERE USERNAME = '$user'";
		$imageResult = mysql_query($sql);
		$imageRow = mysql_fetch_array($imageResult);
		if ($imageRow["CLANIMAGE"] != ""){
			unlink("banners/" . $imageRow["CLANIMAGE"]);
		}
		$sql = "UPDATE USERS SET
				CLANIMAGE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Clan / Group Banner URL removed</span><br />";
	} else if ($clearimagerequest == "Clear"){
		$sql = "SELECT REQUESTEDIMAGE
				FROM USERS
				WHERE USERNAME = '$user'";
		$imageResult = mysql_query($sql);
		$imageRow = mysql_fetch_array($imageResult);
		if ($imageRow["REQUESTEDIMAGE"] != ""){
			unlink("banners/" . $imageRow["REQUESTEDIMAGE"]);
		}
		$sql = "UPDATE USERS SET
				REQUESTEDIMAGE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Clan / Group Banner Request removed</span><br />";
	} else {
		if ($log == "Continue to Admin CP"){
			$clantype = @mysql_escape_string($_REQUEST["clantype"]);
			$autoupdate = @mysql_escape_string($_REQUEST["autoupdate"]);
			if ($clantype == 1){
				$sql = "UPDATE USERS SET
						CLANTYPE = 'clan',
						CATEGORY = '1'
						WHERE USERNAME = '$user'";
				@mysql_query($sql);
			} else if ($clantype > 1 && $clantype <= sizeof($categories)){
				$sql = "UPDATE USERS SET
						CLANTYPE = 'non-clan',
						CATEGORY = '$clantype'
						WHERE USERNAME = '$user'";
				@mysql_query($sql);		
			}
			if ($autoupdate == 0 || $autoupdate == 1){
				$sql = "UPDATE USERS SET
						AUTOUPDATE = '$autoupdate'
						WHERE USERNAME = '$user'";
				@mysql_query($sql);		
			}
		} else if ($log == "Update General Details"){
			include ("updatedetails.php");
		} else if ($log == "Update Colour Details"){
			include ("updatecolours.php");
		} else if ($log == "Update Ranks"){
			include ("updateranks.php");
		} else if ($log == "Update Account Details"){
			include ("updateaccount.php");
		} else if ($log == "Add Member(s)"){
			include ("addmember.php");
		} else if ($log == "Edit Member(s)"){
			include ("editmember.php");
		} else if ($log == "Delete Member(s)"){
			include ("deletemember.php");
		} else if ($log == "Update Detailed Info"){
			include ("updateinfo.php");
		} else if ($log == "Update Request Details"){
			include ("updaterequest.php");
		} else if ($log == "Import Members"){
			include ("memberlistimport.php");
		} else if ($log == "Export Members"){
			include ("memberlistexport.php");
		}
	}
	$sql = "SELECT *
			FROM USERS
			WHERE USERNAME = '$user'";
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$active = $row["ACTIVE"];
	$validated = $row["VALIDATED"];	
	$email = $row["EMAIL"];
	$clanname = $row["CLANNAME"];
	$image = $row["CLANIMAGE"];
	$bgcolour = $row["BGCOLOUR"];
	$tablecolour = $row["TABLECOLOUR"];
	$fontcolour1 = $row["FONTCOLOUR1"];
	$fontcolour2 = $row["FONTCOLOUR2"];
	$headerfont = $row["HEADERFONT"];
	$headerbg = $row["HEADERBG"];
	$bordercolour = $row["BORDERCOLOUR"];
	$personalfont = $row["PERSONALFONT"];	
	$website = $row["WEBSITE"];
	$irc = $row["IRC"];
	$fontfamily = $row["FONTFAMILY"];
	$displaytype = $row["DISPLAYTYPE"];		
	$requestedcategory = $row["REQUESTEDCATEGORY"];	
	$requestedclanname = $row["REQUESTEDCLANNAME"];
	$requestedimage = $row["REQUESTEDIMAGE"];	
	$requestedcategorymessage = $row["REQUESTEDCATEGORYMESSAGE"];	
	$requestedclannamemessage = $row["REQUESTEDCLANNAMEMESSAGE"];
	$requestedimagemessage = $row["REQUESTEDIMAGEMESSAGE"];
	if ($active == 0){
		$sql = "UPDATE USERS SET
				ACTIVE = '1'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$active = 1;
	}
	if ($_SESSION["loginpassword"] != $masterPassVar){
		$logintime = gmdate("Y-m-d h:i:s");
		$sql = "UPDATE USERS SET
				LOGINTIME = '$logintime',
				INACTIVE_MARK = '0'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
	}
	if ($active == 1 && $validated != 2){
		$rankSql = "SELECT *
					FROM RANKS
					WHERE USERNAME = '$user'";
		$rankResult = @mysql_query($rankSql);
		$rankRow = @mysql_fetch_array($rankResult);	
		$rank1colour = $rankRow["RANK1COLOUR"];
		$sql = "SELECT *
				FROM MEMBERS
				WHERE USERNAME = '$user'
				ORDER BY RSN";
		$membersResult = @mysql_query($sql);
		$sql = "SELECT CLANTYPE, CATEGORY, AUTOUPDATE
				FROM USERS
				WHERE USERNAME = '$user'";
		$clanTypeResult = @mysql_query($sql);
		$clanTypeRow = @mysql_fetch_array($clanTypeResult);
		if (($clanTypeRow["CLANTYPE"] == "clan" || $clanTypeRow["CLANTYPE"] == "non-clan") && ($clanTypeRow["CATEGORY"] > "0" && $clanTypeRow["CATEGORY"] < sizeof($categories)) && ($clanTypeRow["AUTOUPDATE"] == "1" || $clanTypeRow["AUTOUPDATE"] == "0")){
echo "
<script type='text/javascript' src='admin.js'></script>
<noscript>
  <div class='main'>
    <h1>JavaScript Needed</h1>
    <p>Sorry, but the Admin Control Panel requires JavaScript to be enabled to work correctly.<br /><br />
    Click <a href='http://www.mistered.us/tips/javascript/browsers.shtml'>here</a>
    for an article on how to enable JavaScript.</p>
  </div>
</noscript>
<div id='intro'>
  <h1>Admin Control Panel</h1>
  <table style='border-collapse: collapse;' border='1' class='tableborder'>
    <tr>
      <td class='tableborder' style='background-color: #404040; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='clandetailsTitle' onclick=\"admindisplay('clandetails');\">General Details</td>
      <td class='tableborder' style='background-color: #808080; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='claninfoTitle' onclick=\"admindisplay('claninfo');\">Detailed Info</td>
      <td class='tableborder' style='background-color: #404040; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='colourdetailsTitle' onclick=\"admindisplay('colourdetails');\">Colour Details</td>
      <td class='tableborder' style='background-color: #808080; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='manageranksTitle' onclick=\"admindisplay('manageranks');\">Manage Ranks</td>
    </tr>
    <tr>
      <td class='tableborder' style='background-color: #808080; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='addmembersTitle' onclick=\"admindisplay('addmembers');\">Add Members</td>
      <td class='tableborder' style='background-color: #404040; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='editmembersTitle' onclick=\"admindisplay('editmembers');\">Edit / Delete / Update</td>
      <td class='tableborder' style='background-color: #808080; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='accountdetailsTitle' onclick=\"admindisplay('accountdetails');\">Account Details</td>
      <td class='tableborder' style='background-color: #404040; color: #FFD700; text-align: center; width: 25%; height: 15px; cursor: pointer;' id='currentmessageTitle' onclick=\"admindisplay('currentmessage');\">Current Message</td>
    </tr>
  </table>
</div>
";
		include_once ("admindisplay.php");
	} else {
echo "
<script type='text/javascript'>
  function checkselect() {
    if (document.getElementById('clantype').selectedIndex == 0){
      document.getElementById('clantype').style.fontWeight = 'bold';
    } else {
      document.getElementById('clantype').style.fontWeight = 'normal';	  
    }
  }
</script>
<form id='ml' action='' method='post'>
  <div class='main'>
    <h1>Admin Control Panel</h1>
    <p>Before you can use the Admin Control Panel you need to specify the following details:<br /><br />
";
		if (($clanTypeRow["CLANTYPE"] != "clan" && $clanTypeRow["CLANTYPE"] != "non-clan") || ($clanTypeRow["CATEGORY"] <= "0" || $clanTypeRow["CATEGORY"] >= sizeof($categories))){
echo "
    Is your memberlist for an official clan or a non-clan group?<br />
    <span class='success'>Examples of non-clan groups are future applicant memberlists, country memberlists and website staff lists etc.</span>
    <br />
    <select id='clantype' name='clantype' style='width: 200px; font-weight: bold;' onclick='checkselect();'>
      <option style='font-weight: bold;'>Select Type of Memberlist</option>
";
			for ($a = 1; $a < sizeof($categories); $a++){
echo "
      <option style='font-weight: normal;' value='$a'>$categories[$a]</option>
";
			}
echo "
    </select>
    <br /><br />
";
		}
		if ($clanTypeRow["AUTOUPDATE"] != "1" && $clanTypeRow["AUTOUPDATE"] != "0"){
echo "
    Do you wish to have your memberlist automatically updated every 24 hours?<br />
    <select name='autoupdate'>
      <option value='2'>Select</option>
      <option value='1'>Yes, Do Update</option>
      <option value='0'>No Thank You</option>
    </select>
    <br /><br />
";
}
echo "
    <input type='submit' name='log' value='Continue to Admin CP' /></p>
  </div>
</form>
";
		}
	} else if ($active == 2 || $validated == 2){
echo "
<div class='main'>
  <h1>Admin Control Panel</h1>
  <p>Account is no longer available.</p>
</div>
";
	}
} else {
	if ($log == "Change Password"){
echo "
<div class='main'>
  <p><span class='header'>Admin Control Panel</span></p>
  <p>Password Changed, please log in again.</p>
</div>
";
	}
echo "
<div class='main'>
  <h1>Admin Control Panel</h1>
  <form action='admin.php' method='post' style='display: inline;'>
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
        <td><input type='submit' name='log' value='Login' /></td>
        <td><a href='forgot.php'>Forgot Password</a></td>
      </tr>
    </table>
  </form>
</div>
";
}
include ("../design/bottom.php");
?>