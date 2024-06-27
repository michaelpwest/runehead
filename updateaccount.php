<?
if ($_REQUEST["oldpass"] != "" || $_REQUEST["newpass"] != "" || $_REQUEST["newpass2"] != ""){
	if (md5($_REQUEST["oldpass"]) == $row["PASSWORD"]){
		if ($_REQUEST["newpass"] != "" || $_REQUEST["newpass2"] != ""){
			if ($_REQUEST["newpass"] == $_REQUEST["newpass2"]){
				if (strlen($_REQUEST["newpass"]) >= 5 && strlen($_REQUEST["newpass"]) <= 20){
					$newpass = md5($_REQUEST["newpass"]);
					$sql = "UPDATE USERS SET
							PASSWORD = '$newpass'
							WHERE USERNAME = '$user'";
					@mysql_query($sql);
					$msg .= "<span class='success'>Password changed, please login again</span><br />";
					$auth->logout();
					$auth->refresh();
				} else {
					$msg .= "New password must be at least 5 characters and no more than 20 characters, cannot change password<br />";
				}
			} else {
				$msg .= "New passwords much match, cannot change password<br />";
			}
		} else {
			$msg .= "New password cannot be left blank, cannot change password<br />";
		}
	} else {
		$msg .= "Current password incorrect, cannot change password<br />";
	}
}

if ($_REQUEST["oldpassemail"] != "" || $_REQUEST["newemail"] != ""){
	if (md5($_REQUEST["oldpassemail"]) == $row["PASSWORD"]){
		$newemail = $_REQUEST["newemail"];
		if ($newemail != ""){
			$sql = "SELECT USERNAME
					FROM USERS
					WHERE EMAIL = '$newemail'";
			$emailResult = @mysql_query($sql);
			if (@mysql_num_rows($emailResult) == 0){
				$email_check = substr_count($newemail, "@");
				$email_check2 = substr_count($newemail, ".");	
				if ($email_check == 0 || $email_check2 == 0){			
					$msg .= "Email address format incorrect, cannot change email address";
				} else {			
					$sql = "UPDATE USERS SET
							EMAIL = '$newemail'
							WHERE USERNAME = '$user'";
					$msg .= "Email address changed to $newemail";
					@mysql_query($sql);				
				}
			} else {
				$msg .= "Email address already in use, cannot change email address";
			}
		} else {
			$msg .= "Email cannot be left blank, cannot change email address";
		}
	} else {
		$msg .= "Current password incorrect, cannot change email address";
	}
}
?>