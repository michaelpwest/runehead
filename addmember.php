<?
if (!isset($rsnameArray)){
	$rsname = $_REQUEST["rsname"];
	$rsname = explode("\n", $rsname);
	$rsname = implode("|", $rsname);
	$rsname = explode("\r", $rsname);
	$rsname = implode("|", $rsname);
	$tok = strtok($rsname,"||");	
	$t = 0;
	$u = array();
	
	$rsnameArray = array();
	$rankArray = array();
	while ($tok) {
		$rsnameArray[] = $tok;
		$rankArray[] = $_REQUEST["rank"];
		$tok = strtok("||");
		$t++;
	}
}
foreach ($rsnameArray as $key => $value) {
	$currentname = cleanName($value);
	if ($rankArray[$key] >= 1 && $rankArray[$key] <= 16){
		$rank = "rank" . trim($rankArray[$key]);
	} else {
		$rank = "rank1";
	}
	
	$sql = "SELECT RSN
			FROM MEMBERS
			WHERE RSN = '$currentname'
			AND USERNAME = '$user'";
	$name_exists = @mysql_query($sql);
	$name_exists1 = @mysql_num_rows($name_exists);
	if (strlen($currentname) > 0){
		if ($name_exists1 == 0){
			if (check_if_contains($currentname,"1|2|3|4|5|6|7|8|9|a|b|c|d|e|f" .
											   "|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K" .
											   "|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|_| ",1) == true){
				$msg .= "$currentname can only have either letters / numbers / spaces or _<br />";
			} else {
				$sql = "SELECT RSN
						FROM MEMBERS
						WHERE USERNAME = '$user'";
				$number_members = @mysql_query($sql);
				$number_members2 = @mysql_num_rows($number_members);
				if ($number_members2 < 2000){
					if ($user != ""){
						$sql = "INSERT INTO MEMBERS (USERNAME, RSN, RANK, TOPSKILL)
								VALUES ('$user', '$currentname', '$rank', '')";
						@mysql_query($sql);
					}
					$msg .= "<span class='success'>New member $currentname added</span><br />";
				} else {
					$msg .= "2000 member limit reached<br />";
					break;
				}
			}
		} else {
			$msg .= "$currentname has already been added<br />";
		}
	}
}
include_once("updateaverages.php");
?>
