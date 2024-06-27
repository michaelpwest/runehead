<?
$requestedcategory = @mysql_escape_string($_REQUEST["requestedcategory"]);
$requestedclanname = trim(@mysql_escape_string($_REQUEST["requestedclanname"]));
$requestedimage = trim(@mysql_escape_string($_REQUEST["requestedimage"]));

$sql = "SELECT REQUESTEDCATEGORY, REQUESTEDCLANNAME, REQUESTEDIMAGE
		FROM USERS
		WHERE USERNAME = '$user'";
$requestedResult = @mysql_query($sql);
$requestedRow = @mysql_fetch_array($requestedResult);

if ($requestedcategory != $requestedRow["REQUESTEDCATEGORY"]){
	$sql = "UPDATE USERS SET
			REQUESTEDCATEGORY = '$requestedcategory'
			WHERE USERNAME = '$user'";
	@mysql_query($sql);	
	$msg .= "<span class='success'>Requested Category updated</span><br />";
}

if ($requestedclanname && check_if_contains($requestedclanname,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
															   "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
															   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| ",1) == true){
	$msg .= "Requested Clan / Group Name can only contain letters or numbers<br />";
} else if (strtolower($requestedclanname) == strtolower($clanname)){
	$sql = "UPDATE USERS SET
			CLANNAME = '$requestedclanname',
			REQUESTEDCLANNAME = ''
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
	$msg .= "<span class='success'>Clan / Group Name updated</span>";
} else if ($requestedclanname != $requestedRow["REQUESTEDCLANNAME"]){
	$sql = "UPDATE USERS SET
			REQUESTEDCLANNAME = '$requestedclanname'
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
	$msg .= "<span class='success'>Requested Clan / Group Name updated</span><br />";
}

if (isset($_FILES["clanbannerfile"]["name"]) && $_FILES["clanbannerfile"]["name"] != ""){
	$requestedimage = $_FILES["clanbannerfile"]["name"];
	if (strtolower(substr($requestedimage, -4, 4)) == ".gif" || strtolower(substr($requestedimage, -4, 4)) == ".png" || strtolower(substr($requestedimage, -4, 4)) == ".jpg" || strtolower(substr($requestedimage, -5, 5)) == ".jpeg"){
		if (strtolower(substr($requestedimage, -4, 4)) == ".gif"){
			$ext = ".gif";
		} else if (strtolower(substr($requestedimage, -4, 4)) == ".png"){
			$ext = ".png";
		} else if (strtolower(substr($requestedimage, -4, 4)) == ".jpg"){
			$ext = ".jpg";
		} else if (strtolower(substr($requestedimage, -5, 5)) == ".jpeg"){
			$ext = ".jpeg";
		} else {
			$ext = "";
		}
		if ($ext != ""){
			while (true){
				$filename = strtolower($user) . "-" . rand(1000000, 9999999) . $ext;		
				if (!file_exists("banners/" . $filename)){
					break 1;
				}
			}
			if (@move_uploaded_file($_FILES["clanbannerfile"]["tmp_name"], "banners/" . $filename)){
				$sql = "UPDATE USERS SET
						REQUESTEDIMAGE = '$filename'
						WHERE USERNAME = '$user'";
				mysql_query($sql);
				$msg .= "<span class='success'>Requested Clan / Group Banner URL updated</span><br />";
			} else {
				$msg .= "Upload failed<br />";
			}
		} else {
			$msg .= "Requested Clan / Group Banner URL must be in .png .gif .jpg or .jpeg format<br />";		
		}
	} else {
		$msg .= "Requested Clan / Group Banner URL must be in .png .gif .jpg or .jpeg format<br />";
	}
}

/*if ($requestedimage == ""){
	$sql = "UPDATE USERS SET
			REQUESTEDIMAGE = ''
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
} else {
	if ($requestedimage != $image){
		if ((substr($requestedimage, 0, 7) == "http://") || (substr($requestedimage, 0, 8) == "https://")){
			if (substr($requestedimage, -4, 4) == ".gif" || substr($requestedimage, -4, 4) == ".png" || substr($requestedimage, -4, 4) == ".jpg" || substr($requestedimage, -5, 5) == ".jpeg"){
				$sql = "UPDATE USERS SET
						REQUESTEDIMAGE = '$requestedimage'
						WHERE USERNAME='$user'";
				@mysql_query($sql);
				$msg .= "<span class='success'>Requested Clan / Group Banner URL updated</span><br />";
			} else {
				$msg .= "Requested Clan / Group Banner URL must be in .png .gif .jpg or .jpeg format<br />";
			}
		} else {
			$msg .= "Requested Clan / Group Banner URL must begin with http:// or https://<br />";
		}
	}
}*/
?>