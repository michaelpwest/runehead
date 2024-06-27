<?
include_once ("../design/top.php");

$reporttypes = array("Select One", "Offensive Memberlist", "Pointless Memberlist", "Friends List", "99 Skill List", "Should be a non-clan", "Other - Please Specify");
$reportsubmitted = 0;
$error = "";
$clan = "";
$reason = 0;
$information = "";
$userdigit = 0;

if (isset($_REQUEST["clan"]) && $_REQUEST["clan"] != ""){
	$clan = @mysql_escape_string($_REQUEST["clan"]); 
}
if (isset($_REQUEST["reason"]) && $_REQUEST["reason"] != 0){
	$reason = @mysql_escape_string($_REQUEST["reason"]);
}
if (isset($_REQUEST["information"]) && $_REQUEST["information"] != ""){
	$information = $_REQUEST["information"];
}
if (isset($_REQUEST["userdigit"]) && $_REQUEST["userdigit"] != 0){
	$userdigit = @mysql_escape_string($_REQUEST["userdigit"]);
}

$sql = "SELECT USERNAME, CLANNAME, REPORTED
		FROM USERS
		WHERE USERNAME = '$clan'
		AND ACTIVE = '1'
		AND VALIDATED = '1'";
$result = @mysql_query($sql);
$row = @mysql_fetch_array($result);
if (@mysql_num_rows($result) > 0){
	$username = $row["USERNAME"];
	$clanname = $row["CLANNAME"];
	$reported = $row["REPORTED"];
	if (isset($_REQUEST["form_submitted"]) && $_REQUEST["form_submitted"] == 1){	
		if ($reason == 0){
			$error .= "No reason selected<br />";
		}
		if ($reason == (sizeof($reporttypes) - 1) && trim($information) == ""){
			$error .= "No further information supplied after selecting \"Other - Please Specify\"<br />";
		}
		if (strlen($information) > 500){
			$error .= "Further information too long.<br />";
		}		
		include_once ("audit.php");
		if (audit() == false) {
			$error .= "Image Validation Code is incorrect<br />";
		}
		if ($error == ""){
			$information2 = @mysql_escape_string($information);
			$sql = "UPDATE USERS SET
					REPORTED = '$reason',
					REPORTED_INFO = '$information2'
					WHERE USERNAME = '$clan'";
			@mysql_query($sql);
			$reportsubmitted = 1;
			$reported = $reason;		
		}
	}
	if ($reported == 0){
echo "
<script type='text/javascript' src='report.js'></script>
<form action='' method='post'>
<div class='main'>
  <h1>Report a Memberlist</h1>
  <p>This feature of the RuneHead Hiscores Catalogue will allow you to report any memberlists that are either misusing the service
  or are under the incorrect memberlist category.</p>
  <p>To report a memberlist simply choose the reason for the report and if you have any further information that may be helpful, enter
  it in the \"Further Information\" box.</p>
  <p style='background-color: #555555;'><span class='success'><b>Note: This feature is NOT for \"Remove Me\" requests. Any reports of this nature will be ignored
  and no action will be taken.<br /><br />Please post these requests on the forum under the <a href='http://runehead.com/forum/index.php?showforum=4' class='success'>
  Hiscores Catalogue Abuse Reporting</a> section or <a href='contactus.php' class='success'>contact us</a> by email if you wish to be removed from a memberlist.</b></span></p>
  <table style='padding-left: 10px;'>
";
		if ($error != ""){
echo "
    <tr>
	  <td colspan='2' style='text-align: center;'>
	    Error in report:<br />
	    <span class='success'>$error</span>
	  </td>
	</tr>
";			
		}
echo "
    <tr>
      <td style='width: 40%;'><b>Memberlist Username:</b></td>
	  <td style='width: 60%;'><a href='ml.php?clan=$username'>$username</a></td>
	</tr>
    <tr>
      <td style='width: 40%;'><b>Clan / Group Name:</b></td>
	  <td style='width: 60%;'>$clanname</td>
	</tr>
    <tr>
      <td style='width: 40%;'><b>Reason for Report:</b></td>
	  <td style='width: 60%;'>
	    <select name='reason' style='width: 160px;'>	
";
		for ($a = 0; $a < sizeof($reporttypes); $a++){
echo "
          <option value='$a'"; if ($reason == $a){ echo " selected='selected'"; } echo ">$reporttypes[$a]</option>
";
		}
echo "
        </select>
      </td>
	</tr>
	<tr>
	  <td style='width: 40%; padding-right: 30px;' class='justify'>
	  <b>Further Information:</b><br />
	  If you have any further information which may be helpful, please provide it. This is optional unless the \"Other - Please Specify\" reason is chosen.<br />
	  <div id='charsleft' style='display: inline;'><b>500</b></div> characters left.</td>
      <td style='width: 60%;'><textarea id='information' name='information' rows='8' cols='50' onkeyup='charsleft();' onkeydown='charsleft();'>$information</textarea></td>
	</tr>
    <tr>
      <td style='width: 40%;'><b>Image Validation Code:</b></td>
      <td style='width: 60%;'><input onblur='ajaxFunction();' name='userdigit' value='' style='width:175px;' maxlength='5' /></td>
    </tr>
    <tr>
      <td colspan='2' style='text-align:center;'>&nbsp;<img src='button.php?" . rand(1,10000) . "' alt='' /></td>
    </tr>	
    <tr>
      <td colspan='2' style='text-align: center;'><input type='submit' value='Submit Report' /></td>
    </tr>
  </table>
  <input type='hidden' name='form_submitted' value='1' />
</div>
</form>
<script type='text/javascript'>
  charsleft();
</script>
";
	} else if ($reportsubmitted == 1) {
echo "
<div class='main' >
  <h1>Report a Memberlist</h1>
  <p>Thankyou, your report has been received for the reason <b>\"" . $reporttypes[$reported] . "\"</b> and the appropriate action will be taken.<br />
  If no action needs to be taken, this report will be removed.<br />
  If you have any concerns about this report or want to add to any additional information, you can <a href='contactus.php'>contact us</a>.</p>
</div>
";	
	} else {
echo "
<div class='main' >
  <h1>Report a Memberlist</h1>
  <p>Thankyou, but this memberlist has already been reported for the reason <b>\"" . $reporttypes[$reported] . "\"</b> and the appropriate action will be taken.<br />
  If no action needs to be taken, this report will be removed.<br />
  If you have any concerns about this report or want to add to any additional information, you can <a href='contactus.php'>contact us</a>.</p>
</div>
";		
	}
} else {
echo "
<div class='main' >
  <h1>Report a Memberlist</h1>
  <p>Memberlist username not found. Please use the \"Report List\" link at the top right of a memberlist.</p>
</div>
";
}

include_once ("../design/bottom.php");
?>
