<?
include_once ("info.php");
include_once ("auth.php");
include_once ("../functions.php");
$auth->checkLogin();
$user = $auth->getUser();
if (isset($user) && $user != ""){
	$filename = "import/" . rand(1000000, 9999999) . ".txt";
	if ($_FILES["importmembersfile"]["name"] != ""){
		if (substr($_FILES["importmembersfile"]["name"], -4) == ".txt" || substr($_FILES["importmembersfile"]["name"], -4) == ".csv"){
			if (move_uploaded_file($_FILES["importmembersfile"]["tmp_name"], $filename)){
				$file = fopen($filename, "r");
				if (filesize($filename) > 0){				
					$contents = fread($file, filesize($filename));
					$contents = explode("\n", $contents);
					
					$rsnameArray = array();
					$rankArray = array();
					$filesize = sizeof($contents);
					
					for ($a = 0; $a < $filesize; $a++){
						$contents[$a] = str_replace(",", "\t", $contents[$a]);
						
						$contents2 = explode("\t", $contents[$a]);		
						$rsnameArray[] = $contents2[0];
						$rankArray[] = $contents2[1];
					}
					include_once("addmember.php");
				} else {
					$msg .= "Import failed<br />File can't be empty";	
				}
				fclose($file);
				unlink($filename);				
			} else {
				$msg .= "Import failed<br />";
			}
		} else {
			$msg .= "Import failed<br />File needs to be a text tab delimited (.txt) or comma separated values (.csv) file<br />";		
		}
	}
}
?>