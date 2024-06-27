<?
$playbase = @mysql_escape_string($_REQUEST["playbase"]);
$timebase = @mysql_escape_string($_REQUEST["timebase"]);
$capecolour = @mysql_escape_string($_REQUEST["capecolour"]);
$homeworld = @mysql_escape_string($_REQUEST["homeworld"]);
$initials = @mysql_escape_string($_REQUEST["initials"]);
$autoupdate = @mysql_escape_string($_REQUEST["autoupdate"]);
$clantype = @mysql_escape_string($_REQUEST["clantype"]);

$playbase2 = $row["PLAYBASE"];
$timebase2 = $row["TIMEBASE"];
$capecolour2 = $row["CAPECOLOUR"];
$homeworld2 = $row["HOMEWORLD"];
$initials2 = $row["INITIALS"];
$autoupdate2 = $row["AUTOUPDATE"];
$clantype2 = $row["CLANTYPE"];

if ($playbase != ""){
	if ($playbase != $playbase2){
		$sql = "UPDATE USERS SET
				PLAYBASE = '$playbase'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>F2P / P2P base updated</span><br />";
	}
}

if ($timebase != ""){
	if ($timebase != $timebase2){
		$sql = "UPDATE USERS SET
				TIMEBASE = '$timebase'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Time base updated</span><br />";
	}
}

if ($capecolour != ""){
	if ($capecolour != $capecolour2){
		$sql = "UPDATE USERS SET
				CAPECOLOUR = '$capecolour'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Cape colour updated</span><br />";
	}
}

if ($homeworld != "" || $homeworld == 0){
	if ($homeworld != $homeworld2){
		if (check_if_contains($homeworld,"1|2|3|4|5|6|7|8|9|0",1) == true){
			$msg .= "Home world can only be numbers<br />";
		} else {
			if ($homeworld <= $homeworldlimit){
				$sql = "UPDATE USERS SET
						HOMEWORLD = '$homeworld'
						WHERE USERNAME = '$user'";
				@mysql_query($sql);
				$msg .= "<span class='success'>Home world updated</span><br />";
			} else {
				$msg .= "Home world must be between 1 - $homeworldlimit<br />";
			}
		}
	} else if ($homeworld2 == 0 && $homeworld != 0){
		$sql = "UPDATE USERS SET
				HOMEWORLD = '$homeworld'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Home world updated</span><br />";
	}
}

if ($initials != $initials2){
	if (check_if_contains($initials,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
									"|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
									"|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|-|_| ",1) == true){
		$msg .= "Clan initials can only contain letters, number, - or _<br />";
	} else {
		$sql = "UPDATE USERS SET
				INITIALS = '$initials'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Clan initials updated</span><br />";
	}
}

if ($autoupdate == 0 || $autoupdate == 1){
	if ($autoupdate != $autoupdate2){
		$sql = "UPDATE USERS SET
				AUTOUPDATE = '$autoupdate'
				WHERE USERNAME = '$user'";
		@mysql_query($sql);		
		$msg .= "<span class='success'>Auto update details updated</span><br />";
	}
}
?>