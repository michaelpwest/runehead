<?
// If admindisplay.php file is accessed directly, redirect to admin.php
if (substr($_SERVER["PHP_SELF"], -16, 16) == "admindisplay.php"){
	echo "<meta http-equiv='Refresh' content='0; url=admin.php'>";	
	exit();
}
$clantype = $row["CLANTYPE"];
if ($clantype == "clan"){
	$clantypedisplay = "Clan";
} else {
	$clantypedisplay = "Non-Clan";
}
$category = $row["CATEGORY"];
echo "
<div id='clandetails' class='main' style='display: none;'>
  <form id='clandetailsForm' action='' method='post' style='display: inline;'>
  <h1>General Details <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('clandetails');\" /></h1>
  <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
    <tr>
      <td style='width: 30%; text-align: right;'>Memberlist Category:</td>
	  <td style='text-align: center;'><b>$clantypedisplay - $categories[$category]</b></td>
	  <td style='width: 5%; text-align: center; vertical-align: top;'>&nbsp;</td>	  
	</tr>
    <tr>
      <td style='text-align: right;'>Clan / Group Name:</td>
      <td style='text-align: center;'><b>$clanname</b></td>
	  <td style='width: 5%; text-align: center; vertical-align: top;'>&nbsp;</td>
    </tr>
    <tr>
      <td style='text-align: right;'>Clan / Group Banner:</td>
      <td style='text-align: center;'><b>"; if ($image != ""){ echo "<span onclick='openimage(\"$image\");' style='cursor: pointer; text-decoration: underline;'>$image</span>"; } else { echo "&nbsp;"; } echo "</b></td>
	  <td style='width: 5%; text-align: center; vertical-align: top;'>"; if ($image != ""){ echo "<input type='submit' name='clearimage' id='clearimage' value='Clear' style='width: 60px;' onclick='return removeMsg2();' />"; } else { echo "&nbsp;"; } echo "</td>
    </tr>
    <tr>
      <td style='text-align: right;'>Clan / Group Website URL:</td>
      <td><input style='width: 100%;' name='website' value='$website' maxlength='150' /></td>
    </tr>
	<tr>
      <td style='text-align: right;'>IRC Channel:</td>
      <td><input style='width: 100%;' name='irc' value='$irc' maxlength='100' /></td>
    </tr>
    <tr>
      <td colspan='3' style='text-align: center;'><input type='submit' id='clandetailsbutton' name='log' value='Update General Details' /></td>
    </tr>
  </table>
  </form>
  <form id='requestedChangesForm' action='' method='post' style='display: inline;' enctype='multipart/form-data'>
  <h1>Requested Changes</h1>
  <div class='justify'>
    <p>If you wish to change your Memberlist Category, Clan / Group Name or Clan / Group Banner enter the details below and submit the changes.
    Your requests will be looked at usually within 24-48 hours and the change will be made if the requests don't break the <span style='text-decoration: underline; cursor: pointer;' onclick='guidelines();'>guidelines</span>.</p>
  </div>
  <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
    <tr>
      <td style='width: 30%; text-align: right;'>Memberlist Category:</td>
	  <td style='padding-left: 48px;' colspan='2'>
	    <select id='requestedcategory' name='requestedcategory' style='width: 302px;'>
		  <option value='0'>None</option>
";
	for ($a = 1; $a < sizeof($categories); $a++){
		if ($a != $category){
echo "
		  <option value='$a'"; if ($a == $requestedcategory){ echo " selected='selected'"; } echo ">$categories[$a]</option>
";
		}
	}
echo "
		</select>
        <input type='button' value='Clear' style='width: 60px;' onclick='document.getElementById(\"requestedcategory\").selectedIndex=\"0\"' />
	  </td>
	</tr>
    <tr>
      <td style='text-align: right;'>Clan / Group Name:</td>
      <td style='padding-left: 48px;' colspan='2'>
	    <input id='requestedclanname' name='requestedclanname' value='$requestedclanname' style='width: 300px;' maxlength='50' />
	    <input type='button' value='Clear' style='width: 60px;' onclick='document.getElementById(\"requestedclanname\").value=\"\"' />
	  </td>
    </tr>
";
	if ($requestedimage != ""){
echo "
	<tr>
      <td style='text-align: right;'>Clan / Group Banner:</td>
      <td style='padding-left: 48px; width: 301px; text-align: center;'><b><span onclick='openimage(\"$requestedimage\");' style='cursor: pointer; text-decoration: underline;'>$requestedimage</span></b></td>
	  <td><input type='submit' name='clearimagerequest' id='clearimagerequest' value='Clear' style='width: 60px;' onclick='return removeMsg3();' /></td>
    </tr>
";
	} else {
echo "
    <tr>
      <td style='text-align: right;'>Clan / Group Banner:</td>
	  <td style='padding-left: 48px;' colspan='2'>
        <div style='position: relative;'>
          <input type='file' name='clanbannerfile' id='clanbannerfile' size='47' style='position: relative; -moz-opacity:0; filter: alpha(opacity: 0); opacity: 0; z-index: 2;' onclick='clanBannerFunction();' onkeyup='clanBannerFunction();' onmouseover='clanBannerFunction();' onmouseout='clanBannerFunction();' />
          <div style='position: absolute; top: 0px; left: 0px; z-index: 1;'>
            <input value='' name='clanbannerfile2' id='clanbannerfile2' size='48' style='margin-bottom: 4px;' onkeyup='clanBannerFunction();' onmouseover='clanBannerFunction();' onmouseout='clanBannerFunction();' />
            <img src='images/browse.png' alt='' />
          </div>
        </div>
	  </td>
	</tr>
";
	}
echo "
    <tr>
      <td colspan='3' style='text-align: center;'><input type='submit' id='requestsbutton' name='log' value='Update Request Details' /></td>
    </tr>	
  </table>
  <h1>Last Change Made</h1>
  <div class='justify'>
    <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
	  <tr>
	    <td style='width: 30%; text-align: right; vertical-align: top;'>Memberlist Category:</td>
	    <td style='width: 65%; text-align: left; padding-left: 20px;'>$requestedcategorymessage</td>
        <td style='width: 5%; text-align: center; vertical-align: top;'>"; if ($requestedcategorymessage != ""){ echo "<input type='submit' id='clear1' name='clear1' value='Clear' style='width: 60px;' onclick='return removeMsg(\"clear1\");' />"; } else { echo "&nbsp;"; } echo "</td>
	  </tr>
	  <tr>
	    <td style='width: 30%; text-align: right; vertical-align: top;'>Clan / Group Name:</td>
	    <td style='width: 65%; text-align: left; padding-left: 20px;'>$requestedclannamemessage</td>
        <td style='width: 5%; text-align: center; vertical-align: top;'>"; if ($requestedclannamemessage != ""){ echo "<input type='submit' id='clear2' name='clear2' value='Clear' style='width: 60px;' onclick='return removeMsg(\"clear2\");' />"; } else { echo "&nbsp;"; } echo "</td>
	  </tr>
	  <tr>
	    <td style='width: 30%; text-align: right; vertical-align: top;'>Clan / Group Banner:</td>
	    <td style='width: 65%; text-align: left; padding-left: 20px;'>$requestedimagemessage</td>
        <td style='width: 5%; text-align: center; vertical-align: top;'>"; if ($requestedimagemessage != ""){ echo "<input type='submit' id='clear3' name='clear3' value='Clear' style='width: 60px;' onclick='return removeMsg(\"clear3\");' />"; } else { echo "&nbsp;"; } echo "</td>
	  </tr>	  
    </table>
  </div>
  </form>
</div>
";

echo "
<div id='colourdetails' class='main' style='display: none;'>
  <form id='colourdetailsForm' action='' method='post' style='display: inline;'>
";
include_once ("ml_preview.php");
echo "<h1>Colour Details <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('colourdetails');\" /></h1>";
if ((isset($tablecolour) && substr($tablecolour, 0, 1) != "#") || (isset($fontcolour2) && substr($fontcolour2, 0, 1) != "#") ){
	echo "<span class='success'>Note: Ad colours will only work properly if the Font Colour 2 and Table Colour are html codes (#000000) and not words (black).</span>";
}
echo "
  <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
    <tr>	  
	  <td style='text-align: right;'>Font Family:</td>
      <td>
        <select id='fontfamily' name='fontfamily' onchange='mlPreview(\"$rank1colour\");'>
";
for ($a = 0; $a < sizeof($fontfamilyArray); $a++){
	echo "<option value='" . strtolower($fontfamilyArray[$a]) . "'"; if (strtolower($fontfamily) == strtolower($fontfamilyArray[$a])){ echo " selected='selected'"; } echo ">" . $fontfamilyArray[$a] . "</option>";
}
echo "
		</select>
	  </td>
    </tr>
    <tr>
      <td style='text-align: right;'>Font Colour 1:</td>
      <td>
	    <input id='fontcolour1' name='fontcolour1' maxlength='25' value='$fontcolour1' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"fontcolour1\");' />
        &nbsp;<input disabled='disabled' id='fontcolour1Display' style='width: 16px; background-color: $fontcolour1;' />
	    &nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('fontcolour1');\" />
      </td>
    </tr>
    <tr>	  
      <td style='text-align: right;'>Font Colour 2:</td>
      <td>
        <input id='fontcolour2' name='fontcolour2' maxlength='25' value='$fontcolour2' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"fontcolour2\");' />
        &nbsp;<input disabled='disabled' id='fontcolour2Display' style='width: 16px; background-color: $fontcolour2;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('fontcolour2');\" />
      </td>
    </tr>
    <tr>
      <td style='text-align: right;'>Background Colour:</td>
      <td>
        <input id='bgcolour' name='bgcolour' maxlength='25' value='$bgcolour' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"bgcolour\");' />
        &nbsp;<input disabled='disabled' id='bgcolourDisplay' style='width: 16px; background-color: $bgcolour;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('bgcolour');\" />
      </td>
    </tr>
    <tr>	  
      <td style='text-align: right;'>Table Colour:</td>
      <td>
        <input id='tablecolour' name='tablecolour' maxlength='25' value='$tablecolour' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"tablecolour\");' />
        &nbsp;<input disabled='disabled' id='tablecolourDisplay' style='width: 16px; background-color: $tablecolour;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('tablecolour');\" />
      </td>
    </tr>
    <tr>
      <td style='text-align: right;'>Header Font Colour:</td>
      <td>
        <input id='headerfont' name='headerfont' maxlength='25' value='$headerfont' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"headerfont\");' />
        &nbsp;<input disabled='disabled' id='headerfontDisplay' style='width: 16px; background-color: $headerfont;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('headerfont');\" />
      </td>
    </tr>
    <tr>	  
      <td style='text-align: right;'>Header Background Colour:</td>
      <td>
        <input id='headerbg' name='headerbg' maxlength='25' value='$headerbg' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"headerbg\");' />
        &nbsp;<input disabled='disabled' id='headerbgDisplay' style='width: 16px; background-color: $headerbg;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('headerbg');\" />
      </td>
    </tr>
    <tr>
      <td style='text-align: right;'>Border Colour:</td>
      <td>
        <input id='bordercolour' name='bordercolour' maxlength='25' value='$bordercolour' style='width: 142px;' onkeyup='mlPreview(\"$rank1colour\");updateColour(\"bordercolour\");' />
        &nbsp;<input disabled='disabled' id='bordercolourDisplay' style='width: 16px; background-color: $bordercolour;' />
		&nbsp;<img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('bordercolour');\" />
      </td>
    </tr>
	<tr>
      <td style='text-align: right;'>Personal Page Font Colour:</td>
      <td>
	    <select name='personalfont'>
		  <option value='1'"; if ($row["PERSONALFONT"] == 1){ echo " selected='selected'"; } echo ">Font Colour 1</option>
		  <option value='2'"; if ($row["PERSONALFONT"] == 2){ echo " selected='selected'"; } echo ">Font Colour 2</option>
		</select>
	  </td>
	</tr>
    <tr>
      <td style='text-align: right;'>Rank Display Type:</td>
      <td>
        <select name='displaytype' id='displaytype' onchange='mlPreview(\"$rank1colour\");'>
          <option value='0'"; if ($row["DISPLAYTYPE"] == 0){ echo " selected='selected'"; } echo ">Cell Backgrounds</option>
          <option value='1'"; if ($row["DISPLAYTYPE"] == 1){ echo " selected='selected'"; } echo ">Font Colours</option>
        </select>
      </td>
    </tr>
    <tr style='text-align: center;'>
      <td colspan='2' valign='top' style='text-align: center;'>
        <input type='submit' id='colourdetailsbutton' name='log' value='Update Colour Details' />
      </td>
    </tr>
  </table>
  </form>
</div>
";

echo "
<div id='manageranks' class='main' style='display: none;'>
  <form id='manageranksForm' action='' method='post' style='display: inline;'>
  <h1>Manage Ranks <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('manageranks');\" /></h1>
  <table style='width: 50%; margin: 0px auto 0px auto;' border='0'>
    <tr style='text-align: center;'>
      <td>&nbsp;</td>
	  <td>Rank:</td>
      <td>Colour:</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
";
for ($a = 1; $a <= 16; $a++){
echo "
    <tr style='text-align: center;'>
      <td style='text-align: right;'>$a.</td>
	  <td><input name='displayrank$a' maxlength='30' value='" . $rankRow["RANK" . $a] . "' /></td>
      <td>
        <input id='displayrankcolour$a' name='displayrankcolour$a' maxlength='25'  value='" . $rankRow["RANK" . $a . "COLOUR"] . "' onkeyup=\"updateColour('displayrankcolour$a');\" />
      </td>
	  <td>
";
	if ($rankRow["RANK" . $a . "COLOUR"] != ""){
		echo "<input disabled='disabled' id='displayrankcolour$a" . "Display' style='width: 16px; background-color: " . $rankRow["RANK" . $a . "COLOUR"] . ";' />";
	} else {
		echo "<input disabled='disabled' id='displayrankcolour$a" . "Display' style='width: 16px;' />";
	}
echo "
	  </td>
	  <td>
        <img src='images/colours.png' alt='' style='vertical-align: bottom; cursor: pointer;' title='Choose Colour' onclick=\"colours('displayrankcolour$a');\" />	  
	  </td>
    </tr>
";
}
echo "
    <tr>
      <td colspan='5' style='text-align: center;'><input type='submit' id='manageranksbutton' name='log' value='Update Ranks' /></td>
    </tr>
  </table>
  </form>
</div>
";

echo "
<div id='accountdetails' class='main' style='display: none;'>
  <form id='accountdetailsForm' action='' method='post' style='display: inline;'>
  <h1>Account Details <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('accountdetails');\" /></h1>
  <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
    <tr>
	  <td colspan='2' style='text-align: center;'><b>Change Password</b></td>
	</tr>
    <tr>
      <td style='text-align: right;'>Current Password:</td>
      <td><input style='width: 200px;' name='oldpass' type='password' /></td>
    </tr>
    <tr>
      <td style='text-align: right;'>New Password:</td>
      <td><input style='width: 200px;' name='newpass' type='password' maxlength='20' /></td>
    </tr>
    <tr>
      <td style='text-align: right;'>Confirm Password:</td>
      <td><input style='width: 200px;' name='newpass2' type='password' maxlength='20' /></td>
    </tr>
    <tr>
	  <td colspan='2' style='text-align: center;'><b>Change Email</b></td>
	</tr>	
	<tr>
      <td style='text-align: right;'>Current Email:</td>
      <td><b>$email</b></td>	
	</tr>
    <tr>
      <td style='text-align: right;'>Current Password:</td>
      <td><input style='width: 200px;' name='oldpassemail' type='password' /></td>
    </tr>
    <tr>
      <td style='text-align: right;'>New Email Address:</td>
      <td><input style='width: 200px;' name='newemail' /></td>
    </tr>	
    <tr>
      <td colspan='2' style='text-align: center;'><input type='submit' id='accountdetailsbutton' name='log' value='Update Account Details' /></td>
    </tr>
  </table>
  </form>
</div>
";

echo "
<div id='addmembers' class='main' style='display: none;'>
  <form id='addmembersForm' action='' method='post' style='display: inline;' enctype='multipart/form-data'>
  <h1>Add Members <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('addmembers');\" /></h1>
  <table style='width: 520px; margin: 0px auto 0px auto;' border='0'>
    <tr style='text-align: center;'>
      <td rowspan='25' style='width: 200px; text-align: center;'>
        Member Name(s):<br />
        <textarea id='rsname' name='rsname' rows='24' cols='20' onkeyup='addmember();'></textarea>
      </td>
      <td style='text-align: left; vertical-align: top;'>
        Rank:
        <select name='rank' style='width: 125px;'>
";
$rankSql = "SELECT *
			FROM RANKS
			WHERE USERNAME = '$user'";
$rankResult = @mysql_query($rankSql);
$rankRow = @mysql_fetch_array($rankResult);
for ($a = 1; $a <= 16; $a++){
	if ($rankRow["RANK" . $a] != ""){
		echo "<option value='$a'>" . $rankRow["RANK" . $a] . "</option>";
	}
}
echo "
        </select><br /><br />
        <input type='submit' id='addmembersbutton' name='log' value='Add Member(s)' /><br /><br />
		<div id='rsnamesentered'><span class='success'><b>0</b> names entered<br />of a max of 100</span></div><br />
		Import Members:<br />		
        <div style='position: relative;'>
          <input type='file' name='importmembersfile' id='importmembersfile' size='30' style='position: relative; -moz-opacity:0; filter: alpha(opacity: 0); opacity: 0; z-index: 2;' onclick='importFunction();' onkeyup='importFunction();' onmouseover='importFunction();' onmouseout='importFunction();' />
          <div style='position: absolute; top: 0px; left: 0px; z-index: 1;'>
            <input value='' name='importmembersfile2' id='importmembersfile2' size='31' style='margin-bottom: 4px;' onkeyup='importFunction();' onmouseover='importFunction();' onmouseout='importFunction();' />
            <img src='images/browse.png' alt='' />
          </div>
        </div>
		<input type='submit' name='log' id='importmembersbutton' value='Import Members' style='margin-top: 10px;' /><br />
	  </td>
    </tr>
  </table>
  </form>
</div>
";

echo "
<div id='editmembers' class='main' style='display: none;'>
  <form id='editmembersForm' action='' method='post' style='display: inline;'>
  <h1>Edit / Delete / Update <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('editmembers');\" /></h1>
  <table style='width: 80%; margin: 0px auto 0px auto;' border='0'>
    <tr style='text-align: center;'>
      <td>
";
if (@mysql_num_rows($membersResult) == 0){
echo " 
        <select multiple='multiple' id='member' name='member[]' style='font-family: courier new; width: 280px; text-align: left;' size='25' onchange='editingname();editingrank()' disabled='disabled'>
          <option>&nbsp;</option>
		</select>
";			
} else {
	echo "<select multiple='multiple' id='member' name='member[]' style='font-family: courier new; width: 280px; text-align: left;' size='25' onchange='editingname();editingrank()'>";
	$a1 = 0;
	$rankSql = "SELECT *
				FROM RANKS
				WHERE USERNAME = '$user'";
	$rankResult = @mysql_query($rankSql);
	$rankRow = @mysql_fetch_array($rankResult);
	while ($membersRow = @mysql_fetch_array($membersResult)){
		$name = $membersRow["RSN"];
		$clanrank = $membersRow["RANK"];
		$clanrank2 = (str_replace("rank", "", $clanrank)) - 1;
		$clanrank = strtoupper($clanrank);
		$clanrank = $rankRow[$clanrank];
		$a1++;
		if (@mysql_num_rows($membersResult) < 10){
			// skip
		} else if (@mysql_num_rows($membersResult) >= 100){
			if ($a1 < 10){
				$a1 = "00" . $a1;
			} else if ($a1 < 100){
				$a1 = "0" . $a1;
			}	
		} else {
			if ($a1 < 10){
				$a1 = "0" . $a1;
			}
		}
		echo "<option value='$name|$clanrank2'>$a1&nbsp;&nbsp;" . str_replace(" ", "&nbsp;", $name);
		for ($b = strlen($name); $b < 14; $b++){
			echo "&nbsp;";
		}
		echo "$clanrank</option>";
	}
	echo "</select>";
}
echo "
	  </td>
	  <td style='vertical-align: top; text-align: left;'>
        Rank:<br />
        <select name='rank2'>
";
for ($a = 1; $a <= 16; $a++){
	if ($rankRow["RANK" . $a] != ""){
		echo "<option value='$a'>" . $rankRow["RANK" . $a] . "</option>";
	}
}
echo "
        </select><br />
        Edit Member(s):<br />
        <input name='rsname2' maxlength='12' /><br />
        <input type='submit' name='log' id='editmembersbutton' value='Edit Member(s)' style='width: 135px;' /><br /><br />
        Delete Member(s):<br />
        <input type='submit' name='log' id='deletemembersbutton' value='Delete Member(s)' onclick='return confirmDelete();' style='width: 135px;' /><br /><br />
";
if (@mysql_num_rows($membersResult) > 0){
echo "
        Export All Members:<br />
		<input type='button' name='log' id='exportmembersbutton' value='Export All Members' style='width: 135px;' onclick='exportMembers();' /><br /><br />
";
}
echo "
        Update Memberlist:<br />
        <input type='button' name='log' id='updatemembersbutton' value='Update Member(s)' onclick='ajaxFunction();' style='width: 135px;' /><br /><br />
        <div id='ajax-loader' style='display: none;' class='success'>Updating ... <img src='../design/images/ajax-loader.gif' alt='' style='border: 0px;' /></div>
        <div id='ajaxDiv'>&nbsp;</div>
      </td>
	</tr>
  </table>
  </form>
</div>
";

$playbase = $row["PLAYBASE"];
$timebase = $row["TIMEBASE"];
$capecolour = $row["CAPECOLOUR"];
$homeworld = $row["HOMEWORLD"];
$initials = $row["INITIALS"];
$autoupdate = $row["AUTOUPDATE"];

$playarray = array("none", "f2p", "p2p", "f2pp2p");
$playarray2 = array("None", "F2P Based", "P2P Based", "F2P &amp; P2P Based");
$timearray = array("all", "worldwide", "usa", "europe", "australasia", "usaeur", "usaaus", "euraus");
$timearray2 = array("None", "Worldwide", "America", "Europe", "Asia-Pacific", "America &amp; Europe", "America &amp; Asia-Pacific", "Europe &amp; Asia-Pacific");
$capearray = array("none","black", "blue", "green", "orange", "purple", "red", "yellow");
$capearray2 = array("None","Black", "Blue", "Green", "Orange", "Purple", "Red", "Yellow");
for ($a = 1; $a <= 50; $a++){
	$capearray[] = "wilderness$a";
	$capearray2[] = "Wilderness Cape $a";
}

$typearray = array("clan", "non-clan");
$typearray2 = array("Clan", "Non-Clan");

$updatearray = array("1", "0");
$updatearray2 = array("Yes", "No");

echo "
<div id='claninfo' class='main' style='display: none;'>
  <form id='claninfoForm' action='' method='post' style='display: inline;'>
  <h1>Detailed Info <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('claninfo');\" /></h1>
  <table style='width: 100%; margin: 0px auto 0px auto;' border='0'>
    <tr>
	  <td style='text-align: right;'>F2P / P2P Based:</td>
      <td>        
        <select name='playbase'>
";
for ($a = 0; $a < sizeof($playarray); $a++){
	echo "<option value='$playarray[$a]'"; if ($playarray[$a] == $playbase){ echo " selected='selected'"; } echo ">$playarray2[$a]</option>";
}
echo "
        </select>
      </td>
	</tr>
    <tr>
   	  <td style='text-align: right;'>Time Base:</td>
	  <td>        
        <select name='timebase'>
";
for ($a = 0; $a < sizeof($timearray); $a++){
	echo "<option value='$timearray[$a]'"; if ($timearray[$a] == $timebase){ echo " selected='selected'"; } echo ">$timearray2[$a]</option>";
}
echo "
        </select>
      </td>
	</tr>
	<tr>
   	  <td style='text-align: right;'>Cape:</td>
      <td>
        <select name='capecolour'>
";
for ($a = 0; $a < sizeof($capearray); $a++){
	echo "<option value='$capearray[$a]'"; if ($capearray[$a] == $capecolour){ echo " selected='selected'"; } echo ">$capearray2[$a]</option>";
}
echo "
        </select>
      </td>
    </tr>	
	<tr>	
   	  <td style='text-align: right;'>Home World:</td>
      <td>
        <input maxlength='3' name='homeworld' value='$homeworld' style='width: 142px;' onkeyup='homeworldcheck(document.forms[\"ml\"].homeworld.value, $homeworldlimit);' />
      </td>
    </tr>
    <tr>
      <td style='text-align: right;'>Initials:</td>
	  <td>
        <input maxlength='6' name='initials' style='width: 142px;' value='$initials' />
      </td>
    </tr>
	<tr>
      <td style='text-align: right;'>Auto Update:</td>
      <td>
        <select name='autoupdate'>
";
for ($a = 0; $a < sizeof($updatearray); $a++){
	echo "<option value='$updatearray[$a]'"; if ($updatearray[$a] == $autoupdate){ echo " selected='selected'"; } echo ">$updatearray2[$a]</option>";
}
echo "
        </select>
      </td>
    </tr>
    <tr style='text-align: center;'>
      <td colspan='2' style='text-align: center;'>
        <input type='submit' id='claninfobutton' name='log' value='Update Detailed Info' />
      </td>
    </tr>
  </table>
  </form>
</div>
";

if (isset($log) && $log != "Login"){
echo "
<div id='currentmessage' class='main' style='display: block;'>
  <h1>Current Message <img src='images/help.png' alt='' style='cursor: help;' title='Help' onclick=\"admincphelp('currentmessage');\" /></h1>
  <p><b>"; if ($msg != ""){ echo $msg; } else { echo "<span class='redc'>No changes to make</span>"; } echo "</b></p>
</div>
";
} else {
echo "
<div id='currentmessage' class='main' style='display: block;'>
  <h1>Welcome to the Admin Control Panel</h1>
  <p>Click on a tab above to continue.</p>
</div>
";
}
?>