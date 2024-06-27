<?
if (isset($_REQUEST["member"])){
	$edit = $_REQUEST["member"];
} else {
	$edit = "";
}

if (isset($_REQUEST["rank2"])){
	$rank = $_REQUEST["rank2"];
	$rank = "rank" . $rank;
} else {
	$rank = "";
}
if (sizeof($edit) > 1){
	foreach ($edit as $edit2){
		$edit2 = explode("|", $edit2);
		$edit2 = $edit2[0];
		$sql = "UPDATE MEMBERS SET
				RANK = '$rank'
				WHERE RSN = '$edit2'
				AND USERNAME = '$user'";
		@mysql_query($sql);
		$msg .= "<span class='success'>Member $edit2 updated</span><br />";				
	}
} else if (sizeof($edit) == 1 && $edit != ""){
	$oldname = $edit[0];
	$oldname = explode("|", $oldname);
	$oldname = $oldname[0];
	$rsname = cleanName(trim($_REQUEST["rsname2"]));
	$sql = "SELECT RSN
			FROM MEMBERS
			WHERE RSN = '$rsname'
			AND USERNAME = '$user'";
	$result = @mysql_query($sql);
	$name_exists1 = @mysql_num_rows($result);
	if ($rsname && $rank){
		if ($name_exists1 == 0 || $oldname == $rsname){
			if (check_if_contains($rsname,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
										  "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
										  "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|_| ",1) == true){
				$msg .= "$rsname can only have either letters / numbers / spaces or _<br />";
			} else {
				if (cleanName(trim($oldname)) != cleanName(trim($rsname))){
					$sql = "DELETE FROM MEMBERS
							WHERE RSN = '$oldname'
							AND USERNAME = '$user'";
					@mysql_query($sql);				
					$sql = "INSERT INTO MEMBERS (USERNAME, RSN, RANK, TOPSKILL)
							VALUES ('$user', '$rsname', '$rank', '')";
					@mysql_query($sql);				
					$msg .= "<span class='success'>Member $rsname updated</span><br />";
				} else {
					$sql = "UPDATE MEMBERS SET
							RSN = '$rsname',
							RANK = '$rank'
							WHERE USERNAME = '$user'
							AND RSN = '$oldname'";
					@mysql_query($sql);
				}
			}
		} else {
			$msg .= "The name $rsname has already been added<br />";
		}
	} else {
		$msg .= "Fields cannot be left blank<br />";
	}
}
include_once("updateaverages.php");
?>