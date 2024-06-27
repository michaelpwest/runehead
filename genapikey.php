<?php
require("info.php");
//$clan = @mysql_escape_string($_REQUEST["clan"]);
$clan="diml";
$result=mysql_query("SELECT PASSWORD FROM USERS WHERE USERNAME='".$clan."'");
$x=mysql_result($result,0);
$apikey = md5(sprintf("%s.%s",$clan,$x));
echo "apikey for $clan: ".$apikey."\n";
?>
