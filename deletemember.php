<?
if (isset($_REQUEST["member"])){
	$delete = $_REQUEST["member"];
	foreach ($delete as $delete2){
		$delete2 = explode("|", $delete2);
		$delete2 = $delete2[0];
		$sql = "DELETE FROM MEMBERS
				WHERE RSN = '$delete2'
				AND USERNAME = '$user'";
		@mysql_query($sql);
	}
	$msg .= "<span class='success'>Selected members have been deleted from your memberlist</span><br />";
	include_once("updateaverages.php");
}
?>