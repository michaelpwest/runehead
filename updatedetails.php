<?
$website2 = @mysql_escape_string($_REQUEST["website"]);
$irc2 = @mysql_escape_string($_REQUEST["irc"]);
if ($website2 != $website){
	if (!$website2){
		$sql = "UPDATE USERS
				SET WEBSITE = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Clan / Group Website URL updated</span><br />";
	} else if ($website2){
		if ((substr($website2, 0, 7) == "http://") || (substr($website2, 0, 8) == "https://")){
			$sql = "UPDATE USERS SET
					WEBSITE = '$website2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Clan / Group Website URL updated</span><br />";
		} else {
			$msg .= "Clan / Group Website URL must begin with http:// or https://<br />";
		}
	}
}
if ($irc2 != $irc){
	if (!$irc2){
		$sql = "UPDATE USERS
				SET IRC = ''
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>IRC Channel updated</span><br />";
	} else if ($irc2){
		$sql = "UPDATE USERS SET
				IRC = '$irc2'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>IRC Channel updated</span><br />";
	}
}
?>