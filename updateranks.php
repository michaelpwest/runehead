<?
for ($a = 1; $a <= 16; $a++){
	$rankerror = 0;
	$rankname = "RANK" . $a;
	$rankcolour = "RANK" . $a . "COLOUR";
	$rankname2 = @mysql_escape_string($_REQUEST["displayrank" . $a]);
	$rankcolour2 = @mysql_escape_string($_REQUEST["displayrankcolour" . $a]);
	$sql = "SELECT RANK" . $a . ", RANK" . $a . "COLOUR
			FROM RANKS
			WHERE USERNAME = '$user'";
	$rankCheckResult = @mysql_query($sql);
	$rankCheckRow = @mysql_fetch_array($rankCheckResult);
	if ($rankCheckRow["RANK" . $a . ""] != $rankname2 || $rankCheckRow["RANK" . $a . "COLOUR"] != $rankcolour2){
		if (check_if_contains($rankname2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |-|_",1) == true
			|| check_if_contains($rankcolour2,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z| |#",1) == true){
			$msg .= "Rank $a - $rankname2 must only have letters / numbers / spaces - or _ and rank colours must only have letters / numbers / spaces or #<br />";
			$rankerror = 1;
		}
		if ($rankerror == 0){
			$sql = "UPDATE RANKS SET
					$rankname = '$rankname2',
					$rankcolour = '$rankcolour2'
					WHERE USERNAME = '$user'";
			@mysql_query($sql);
			$msg .= "<span class='success'>Rank $a - $rankname2 updated</span><br />";		
		}
	}
}
?>