<?
$fontfamily2 = @mysql_escape_string($_REQUEST["fontfamily"]);
if ($fontfamily2 != $fontfamily){
	$msg .= "<span class='success'>Font family updated</span><br />";
	$sql = "UPDATE USERS SET
			FONTFAMILY = '$fontfamily2'
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
}

$fontA = @mysql_escape_string($_REQUEST["fontcolour1"]);
if ($fontA != $fontcolour1){
	if ($fontA){
		if (check_if_contains($fontA,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
									 "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
									 "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Font can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					FONTCOLOUR1 = '$fontA'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Font colour updated</span><br />";
		}
	} else {
		$msg .= "Font colour cannot be blank<br />";
	}
}

$font2A = @mysql_escape_string($_REQUEST["fontcolour2"]);
if ($font2A != $fontcolour2){
	if ($font2A){
		if (check_if_contains($font2A,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
									  "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
									  "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Font colour 2 can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					FONTCOLOUR2 = '$font2A'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Font colour 2 updated</span><br />";
		}
	} else {
		$msg .= "Font colour 2 cannot be blank<br />";
	}
}

$bg2 = @mysql_escape_string($_REQUEST["bgcolour"]);
if ($bg2 != $bgcolour){
	if ($bg2){
		if (check_if_contains($bg2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
							       "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
								   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Background colour can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					BGCOLOUR = '$bg2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Background colour updated</span><br />";
		}
	} else {
		$msg .= "Background colour cannot be blank<br />";
	}
}

$table2 = @mysql_escape_string($_REQUEST["tablecolour"]);
if ($table2 != $tablecolour){
	if ($table2){
		if (check_if_contains($table2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
									  "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
									  "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Table colour can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					TABLECOLOUR = '$table2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Table colour updated</span><br />";
		}
	}
	else {
		$msg .= "Table colour cannot be blank<br />";
	}
}

$headerfont2 = @mysql_escape_string($_REQUEST["headerfont"]);
if ($headerfont2 != $headerfont){
	if ($headerfont2){
		if (check_if_contains($headerfont2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
										   "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
										   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Header font colour can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					HEADERFONT = '$headerfont2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Header font colour updated</span><br />";
		}
	} else $msg .= "Header font colour cannot be blank<br />";
}

$headerbg2 = @mysql_escape_string($_REQUEST["headerbg"]);
if ($headerbg2 != $headerbg){
	if ($headerbg2){
		if (check_if_contains($headerbg2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
										 "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
										 "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Header background colour can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					HEADERBG = '$headerbg2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Header background colour updated</span><br />";
		}
	} else $msg .= "Header background colour cannot be blank<br />";
}

$bordercolour2 = @mysql_escape_string($_REQUEST["bordercolour"]);
if ($bordercolour2 != $bordercolour){
	if ($bordercolour2){
		if (check_if_contains($bordercolour2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
											 "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
											 "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Border colour can only contain letters / numbers / spaces or #<br />";
		} else {
			$sql = "UPDATE USERS SET
					BORDERCOLOUR = '$bordercolour2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Border colour updated</span><br />";
		}
	} else $msg .= "Border colour cannot be blank<br />";
}

$displaytype2 = @mysql_escape_string($_REQUEST["displaytype"]);
if ($displaytype2 != $displaytype){
	$msg .= "<span class='success'>Rank display type updated</span><br />";
	$sql = "UPDATE USERS SET
			DISPLAYTYPE = '$displaytype2'
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
}

$personalfont2 = @mysql_escape_string($_REQUEST["personalfont"]);
if ($personalfont2 != $personalfont){
	$msg .= "<span class='success'>Personal page font colour updated</span><br />";
	$sql = "UPDATE USERS SET
			PERSONALFONT = '$personalfont2'
			WHERE USERNAME = '$user'";
	@mysql_query($sql);
}
?>