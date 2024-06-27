<?
session_start();
include_once ("info.php");
include_once ("auth.php");
include_once ("../functions.php");
$auth->checkLogin();
$user = $auth->getUser();
if (isset($user) && $user != ""){
	header("Content-disposition: attachment; filename=" . $user . "_" . gmdate("jS_M_Y") . "_export.txt");
	//header("Content-type: text/plain");
	
	$sql = "SELECT RSN, RANK
			FROM MEMBERS
			WHERE USERNAME = '$user'
			ORDER BY RSN";
	$result = mysql_query($sql);
	$a = 0;
	while ($row = mysql_fetch_array($result)){
		if ($a != 0){
			echo "\n";
		}
		echo $row["RSN"] . "\t" . str_replace("rank", "", $row["RANK"]);
		$a++;
	}
}
?>