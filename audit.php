<?
function audit() {
	if (isset($_SESSION["digit"])){
		$digit = $_SESSION['digit'];
	} else {
		$digit = "";	
	}
	if (isset($_POST["userdigit"])){
		$userdigit = @mysql_escape_string($_POST["userdigit"]);
	}
	session_destroy();
	if (($digit == $userdigit) && ($digit > 1)) {
		return true;
	} else {
	return false;
	}
}
?>