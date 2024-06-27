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
    var agree = confirm('Are you sure you want to accept all images?');
    if (agree){
      return true;
    } else {
      return false;
    }
  } 
</script>
";	
	if (isset($_REQUEST["accept"]) && $_REQUEST["accept"] == "true"){
		$sql = "SELECT USERNAME, CLANIMAGE
				FROM USERS
				WHERE REQUESTEDIMAGE != ''";
		if (isset($_REQUEST["imageusername"]) && $_REQUEST["imageusername"] != ""){
			$sql .= " AND USERNAME = '" . $_REQUEST["imageusername"] . "'";
		}
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)){		
			if ($row["CLANIMAGE"] != ""){
				unlink("banners/" . $row["CLANIMAGE"]);
			}
			$sql = "UPDATE USERS SET
					CLANIMAGE = REQUESTEDIMAGE,
					REQUESTEDIMAGE = '',
					REQUESTEDIMAGEMESSAGE = '" . date("jS M Y") . " - Clan / Group Banner URL changed'
					WHERE REQUESTEDIMAGE != ''
					AND USERNAME = '" . $row["USERNAME"] . "'";
			@mysql_query($sql);				
			if (mysql_affected_rows() > 0){
				if (isset($_REQUEST["imageusername"]) && $_REQUEST["imageusername"] != ""){
echo "
<div class='main'>
  <h1>" . ucwords($_REQUEST["imageusername"]) . " Image Change Accepted</h1>
</div>  
";
				}
			}
		}
		if (!isset($_REQUEST["imageusername"])){
echo "
<div class='main'>
  <h1>Image Changes Accepted</h1>
</div>  
";
		}
	} else if (isset($_REQUEST["decline"]) && $_REQUEST["decline"] == "true"){
		$sql = "SELECT REQUESTEDIMAGE
				FROM USERS
				WHERE USERNAME = '" . $_REQUEST["imageusername"] . "'";
		$imageResult = mysql_query($sql);
		$imageRow = mysql_fetch_array($imageResult);
		if ($imageRow["REQUESTEDIMAGE"] != ""){
			unlink("banners/" . $imageRow["REQUESTEDIMAGE"]);	
		}
		$sql = "UPDATE USERS SET
				REQUESTEDIMAGE = ''
				WHERE USERNAME = '" . $_REQUEST["imageusername"] . "'";
		@mysql_query($sql);
echo "
<div class='main'>
<h1>" . ucwords($_REQUEST["imageusername"]) . " Image Change Declined</h1>
</div>
";
	}
	$sql = "SELECT USERNAME, ACTIVE, CATEGORY, REQUESTEDIMAGE, WEBSITE, LOGINTIME, REGISTRATIONTIME, REPORTED
			FROM USERS
			WHERE REQUESTEDIMAGE != ''
			ORDER BY USERNAME";
	$result = @mysql_query($sql);
	$numrows = @mysql_num_rows($result);
echo "
<div class='main'>
  <h1>Manage Images</h1>
  <p><b>$numrows</b> image changes found</p>
";
	if ($numrows > 0){
echo "
<table class='contenttable' border='1' style='font-size: 11px; text-align: center;'>
    <tr class='header'>
      <td style='width: 10%;' class='tableborder'><b>Edit</b></td>
      <td style='width: 20%;' class='tableborder'><b>Username</b></td>
      <td style='width: 20%;' class='tableborder'><b>Category</b></td>
      <td style='width: 10%;' class='tableborder'><b>Image</b></td>
      <td style='width: 20%;' class='tableborder'><b>Last Login</b></td>
      <td style='width: 10%;' class='tableborder'><b>Site</b></td>
	  <td style='width: 10%;' class='tableborder'><b>Action</b></td>
    </tr>
";
	$images = array();
	while ($row = @mysql_fetch_array($result)){
		$username1 = $row["USERNAME"];
		$active = $row["ACTIVE"];
		$reported = $row["REPORTED"];
		$category = $row["CATEGORY"];
		$clanimage = $row["REQUESTEDIMAGE"];
		$images[] = $clanimage;
		$website = $row["WEBSITE"];
		$logintime = flipDate($row["LOGINTIME"]);
		$registrationtime = flipDate($row["REGISTRATIONTIME"]);
echo "
    <tr "; if ($active != 1 || $reported != 0){ echo " style='background-color: #AA1100;'"; } echo ">
      <td class='tableborder'><a href='manageusers.php?type=edit&amp;name=$username1' target='_blank'>Edit</a></td>
      <td class='tableborder'><a href='ml.php?clan=$username1'>$username1</a></td>
      <td class='tableborder'>$categories[$category]</td>
      <td class='tableborder'><a href='banners/$clanimage' target='_blank'>Here</a></td>
      <td class='tableborder' title='Registration Date: $registrationtime'>$logintime</td>
      <td class='tableborder'><a href='$website' title='$website'>Here</a></td>
	  <td class='tableborder'>
	    <a href='manageimages.php?accept=true&amp;imageusername=$username1'>Acc</a> /
		<a href='manageimages.php?decline=true&amp;imageusername=$username1'>Dec</a>
	  </td>
	</tr>
";
	}
echo "
  </table>
  <table>
    <tr style='text-align: center;'>
	  <td>
		<script type='text/javascript'>
		  function openAll(){
";
		for ($a = 0; $a < count($images); $a++){
			echo "window.open('banners/$images[$a]');";
		}
echo "
		  }
		</script>
        <a onclick='openAll();' style='cursor: pointer; text-decoration: underline;'>Open All Images</a> |
	    <a href='manageimages.php?accept=true' onclick='return confirmAll();'>Accept All</a>
	  </td>
	</tr>
  </table>
";
	}
echo "</div>";
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