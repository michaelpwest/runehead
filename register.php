<?
include_once ("../design/top.php");
if (isset($_SESSION["Registration"]) && $_SESSION["Registration"] == "Done"){
echo "
<div class='main'>
  <h1>Registration Already Complete</h1>	
  <div class='justify'>
    <p>A registration for a memberlist has already been completed.
    Please wait for your memberlist to be validated before you can use it.
    If you wish to change your memberlist username or haven't received your
	validation email, please <a href='contactus.php'>contact us</a> rather than register
	another memberlist.</p>
  </div>
</div>
";
} else {
	echo "<script src='registerAjax.js' type='text/javascript'></script>";

	$msg = "Registration could not be completed since:";
	$error = 0;
	$requestedusername = "";
	$requestedclanname = "";
	$requestedurl = "";
	$requestedemail = "";
	$userdigit = 0;

	if (isset($_REQUEST["requestedusername"])){
		$requestedusername = trim(@mysql_escape_string(strtolower($_REQUEST["requestedusername"])));
	}
	if (isset($_REQUEST["requestedclanname"])){
		$requestedclanname = trim(@mysql_escape_string($_REQUEST["requestedclanname"]));
	}
	if (isset($_REQUEST["requestedurl"])){
		$requestedurl = @mysql_escape_string($_REQUEST["requestedurl"]);
	}
	if (isset($_REQUEST["requestedemail"])){
		$requestedemail = trim(@mysql_escape_string($_REQUEST["requestedemail"]));
	}
	if (isset($_REQUEST["requestedtype"])){
		$requestedtype = @mysql_escape_string($_REQUEST["requestedtype"]);
	}
	if (isset($_REQUEST["userdigit"])){
		$userdigit = @mysql_escape_string($_REQUEST["userdigit"]);
	}

	if ((isset($_REQUEST["form_submitted"]) && $_REQUEST["form_submitted"] == 1)){
		if (!$requestedusername || !$requestedclanname || !$requestedurl || !$requestedemail || !$userdigit){
			$msg .= "<br /><span style='color: #ffd700;'>Not all fields were filled in</span>";
			$error = 1;
		}
		$sql = "SELECT USERNAME
				FROM USERS
				WHERE USERNAME = '$requestedusername'";
		$result = @mysql_query($sql);
		if (@mysql_num_rows($result) > 0){
			$msg .= "<br /><span style='color: #ffd700;'>Username is already is use</span>";
			$error = 1;
		}
		$sql = "SELECT USERNAME
				FROM USERS
				WHERE EMAIL = '$requestedemail'";
		$result = @mysql_query($sql);
		if (@mysql_num_rows($result) > 0){
			$msg .= "<br /><span style='color: #ffd700;'>Email address is already is use</span>";
			$error = 1;
		}
		$email_check = substr_count($requestedemail, "@");
		$email_check2 = substr_count($requestedemail, ".");	
		if ($requestedemail && ($email_check == 0 || $email_check2 == 0)){
			$msg .= "<br /><span style='color: #ffd700;'>Email address format incorrect</span>";
			$error = 1;
		}
		if (check_if_contains($requestedusername,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K|L" .
												 "|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|_",1) == true){
			$msg .= "<br /><span style='color: #ffd700;'>Memberlist username can only contain Letters, Digits or _</span>";
			$error = 1;
		}
		if ($requestedclanname && check_if_contains($requestedclanname,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
																	   "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
																	   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| ",1) == true){
			$msg .= "<br /><span style='color: #ffd700;'>Clan / group name can only contain letters or numbers</span>";
			$error = 1;
		}
		if (($requestedurl && substr($requestedurl, 0, 7) != "http://") && ($requestedurl && substr($requestedurl, 0, 8) != "https://")){
			$msg .= "<br /><span style='color: #ffd700;'>Website needs a 'http://' or 'https://' at the start</span>";
			$error = 1;
		}
		if ($requestedusername && strlen($requestedusername) < 4){
			$msg .= "<br /><span style='color: #ffd700;'>Memberlist username must be at least 4 letters long</span>";
			$error = 1;
		}
		if ($requestedusername && strlen($requestedusername) > 12){
			$msg .= "<br /><span style='color: #ffd700;'>Memberlist username must be less then 12 letters long</span>";
			$error = 1;
		}
		if ($requestedtype < 1 || $requestedtype > sizeof($categories)){
			$msg .= "<br /><span style='color: #ffd700;'>No memberlist category was selected</span>";
			$error = 1;	
		}
		include_once ("audit.php");
		if ($userdigit && audit() == false) {
			$msg .= "<br /><span style='color: #ffd700;'>Image validation code is incorrect</span>";
			$error = 1;
		}
	}
	if ((isset($_REQUEST["form_submitted"]) && $_REQUEST["form_submitted"] == 1) && $error == 0){
		$password = generatePassword();
		$password2 = $password;
		$password = md5($password);
		if ($requestedtype == 1){
			$clantype = "clan";
		} else if ($requestedtype > 1 && $requestedtype <= sizeof($categories)){
			$clantype = "non-clan";
		}
		$sql = "INSERT INTO USERS (USERNAME, PASSWORD, MODERATOR, EMAIL, REGISTRATIONEMAIL, ACTIVE, VALIDATED, CLANTYPE, CATEGORY, AUTOUPDATE, REGISTRATIONTIME,
				LOGINTIME, UPDATETIME, CLANNAME, CLANIMAGE, WEBSITE, IRC, DISPLAYTYPE, FONTFAMILY, BGCOLOUR, TABLECOLOUR, FONTCOLOUR1, FONTCOLOUR2, HEADERFONT,
				HEADERBG, BORDERCOLOUR, PERSONALFONT, PLAYBASE, TIMEBASE, CAPECOLOUR, HOMEWORLD, INITIALS, INACTIVE_MARK, REQUESTEDCLANNAME, REQUESTEDCATEGORY,
				REQUESTEDIMAGE, REQUESTEDCLANNAMEMESSAGE, REQUESTEDCATEGORYMESSAGE, REQUESTEDIMAGEMESSAGE, REPORTED, REPORTED_INFO)
				VALUES ('$requestedusername', '$password', '0', '$requestedemail', '$requestedemail', '0', '0', '$clantype', '$requestedtype', '2', '" . gmdate("Y-m-d h:i:s") . "',
				'" . gmdate("Y-m-d h:i:s") . "', '0000-00-00 00:00:00', '$requestedclanname', '', '$requestedurl', '', '0', 'verdana', '#000000', '#000000',
				'#FFFFFF', '#FFFFFF', '#FFFFFF', '#222222', '#404040', '2', '', '', '', '0', '', '0', '', '0', '', '', '', '', '0', '')";
		@mysql_query($sql);
		$sql = "INSERT INTO RANKS (USERNAME, RANK1, RANK2, RANK3, RANK4, RANK5, RANK6, RANK7, RANK8, RANK9, RANK10,
				RANK11, RANK12, RANK13, RANK14, RANK15, RANK16, RANK1COLOUR, RANK2COLOUR, RANK3COLOUR,
				RANK4COLOUR, RANK5COLOUR, RANK6COLOUR, RANK7COLOUR, RANK8COLOUR, RANK9COLOUR,
				RANK10COLOUR, RANK11COLOUR, RANK12COLOUR, RANK13COLOUR, RANK14COLOUR, RANK15COLOUR, RANK16COLOUR)
				VALUES ('$requestedusername', 'Member', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
				'#000000', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";
		@mysql_query($sql);
		$sql = "INSERT INTO AVERAGES (USERNAME)
				VALUES ('$requestedusername')";
		@mysql_query($sql);
		$headers = "From: Hiscores@RuneHead.com\n";
		$headers .= "Reply-To: Hiscores@RuneHead.com\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset='iso-8859-1'\n";
		$emailmsg = "
<html>
  <body>
    <p>Welcome to the RuneHead Hiscores Catalogue.<br /><br />
    Your account details are as follows:<br />
	Memberlist URL: <a href='http://www.runehead.com/clans/ml.php?clan=$requestedusername'>http://www.runehead.com/clans/ml.php?clan=$requestedusername</a><br />
    Username: $requestedusername<br />
    You will not be able to use your account until it is validated by an admin. Validation will usually happen within 24-48 hours and you will receive an email
	when this is done with your password.<br /><br />	
    We hope you enjoy using your RuneHead Hiscores Catalogue Memberlist.<br /><br />
    Thanks,<br />
    RuneHead Staff.</p>
  </body>
</html>
		";
		mail($requestedemail, "RuneHead Hiscores Catalogue - Welcome / Account Details", $emailmsg, $headers);
echo "
<div class='main'>
  <h1>Registration Complete</h1>
  <div class='justify'>
    <p>Registration for <span style='color: #ffd700;'>$requestedusername</span> is complete.
    <br /><br />Very soon, usually within 5-10 mins, you will receive an email from RuneHead
	to confirm your registration. After you account is validated (usually within 24-48 hours),
	you will receive another email with your password and what to do next.
    <br /><br /><b>Note: Please check the Junk / Spam Mail Box of your email provider as the email
    may go there.</b>
    <br /><br />We hope you enjoy using the RuneHead Hiscores Catalogue for your memberlist needs.</p>
  </div>
</div>
";
		@session_start();
		$_SESSION["Registration"] = "Done";
	} else if ($error == 1 || !isset($_REQUEST["form_submitted"])) {
echo "
<div class='main'>
  <h1>Register a RuneHead Hiscores Catalogue Memberlist</h1>
  <div class='justify'>
    <p>Thankyou for your interest in the RuneHead Hiscores Catalogue. In order to register a memberlist
    first read the following guidelines then fill out the registration form.</p>
  </div>
</div>
";
		$registerPage = true;
		include_once("guidelines.php");
		if ($error == 1){
			$msg .= "<br /><br />";
		} else {
			$msg = "";
		}
echo "
<div class='main' id='register'>
  <h1>Registration Form</h1>
  <div class='justify'>
    <form action='#register' method='post' style='display: inline;'>
	  <div id='ajaxDiv' style='text-align: center;'>$msg</div>
      <p>1. Enter your requested memberlist username into the box below.<br />
      <span class='success'>http://www.runehead.com/clans/ml.php?clan=</span><input class='success' onblur='ajaxFunction();' name='requestedusername' id='requestedusername' value='$requestedusername' maxlength='12' style='background-color: #727272; text-align: left;' /></p>
	  <p>2. Enter your email address.<br />
	  <input onblur='ajaxFunction();' id='requestedemail' name='requestedemail' value='$requestedemail' style='width: 260px;' maxlength='50' /></p>
	  <p>3. What is your Clan / Group's name?<br />
	  <input onblur='ajaxFunction();' id='requestedclanname' name='requestedclanname' value='$requestedclanname' style='width: 260px;' maxlength='50' /></p>
	  <p>4. What is your Clan / Group's website / forum?<br />
	  <input onblur='ajaxFunction();' id='requestedurl' name='requestedurl' value='$requestedurl' style='width: 260px;' maxlength='150' /></p>
	  <p>5. Choose a category that best describes your Clan / Group.<br />
      <select id='requestedtype' name='requestedtype' style='width: 260px;'>
        <option value=''>Select One</option>
";
		for ($a = 1; $a < sizeof($categories); $a++){
echo "
        <option value='$a'"; if (isset($requestedtype) && $requestedtype == $a){ echo " selected='selected'"; } echo ">$categories[$a]</option>
";
		}
echo "			
      </select></p>
	  <p>6. Finally, enter the image code validation below.<br />
	  <input name='userdigit' value='' style='width: 260px;' maxlength='5' /><br />
	  <img src='button.php?" . rand(1,10000) . "' alt='' style='margin-top: 1px;' /></p>
	  <div style='text-align: center; margin-bottom: 10px;'>
	    <input type='submit' name='register' value='Submit Registration' />
        <input type='hidden' name='form_submitted' value='1' style='width: 100px;' />
	  </div>
    </form>
  </div>
</div>
";
	}
}
include_once ("../design/bottom.php");
?>