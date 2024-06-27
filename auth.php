<?
// If auth.php file is accessed directly, redirect to index.php
if (substr($_SERVER["PHP_SELF"], -8, 8) == "auth.php"){
	echo "<meta http-equiv='Refresh' content='0; url=index.php'>";	
	exit();
}

$auth = new auth();
class auth {
	function login($username, $password){
		$_SESSION["loginusername"] = strtolower(@mysql_escape_string($_REQUEST["loginusername"]));
		$_SESSION["loginpassword"] = md5(@mysql_escape_string($_REQUEST["loginpassword"]));
	}
	function logout(){
		$_SESSION["loginusername"] = "";
		$_SESSION["loginpassword"] = "";
		session_destroy();
	}
	function checkAuth(){
		global $masterPassVar;
		if (isset($_SESSION["loginusername"])){
			$username = $_SESSION["loginusername"];
		} else {
			$username = "";
		}
		if (isset($_SESSION["loginpassword"])){		
			$password = $_SESSION["loginpassword"];
		} else {
			$password = "";		
		}
		$sql = "SELECT USERNAME, PASSWORD, MODERATOR
				FROM USERS
				WHERE USERNAME = '$username'";
		$result = @mysql_query($sql);
		$row = @mysql_fetch_array($result);
		if ($username != "" && $username == strtolower($row["USERNAME"]) && ($password == $row["PASSWORD"] || $password == $masterPassVar)){
			if ($row["MODERATOR"]){
				return "moderator";
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	function getUser(){
		if (isset($_SESSION["loginusername"])){
			return $_SESSION["loginusername"];
		} else {
			return "";
		}
	}
	function checkLogin(){
		if (isset($_REQUEST["loginusername"])){
			$loginusername = $_REQUEST["loginusername"];
		}
		if (isset($_REQUEST["loginpassword"])){
			$loginpassword = $_REQUEST["loginpassword"];
		}
		if (isset($loginusername) || isset($loginpassword)){
			$this->login($loginusername, $loginpassword);
		}	
	}
	function refresh(){
		echo "<meta http-equiv='Refresh' content='0; url=index.php'>";
	}
}
?>