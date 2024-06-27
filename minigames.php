<?
include_once ("../design/top.php");
$clantype = "clan";
$pagename = "minigames.php";
$title = "The RuneHead Hiscores Catalogue Minigames Database";
$intro = "See what clans / non-clan groups have the best scores in each of the minigames.<br />
		  Use the sort options at the top of the table to sort clans / non-clan groups in a specific
		  order. If the results are more than one page long you can display another
		  page with the drop down menu or by clicking next / previous page.<br /><br />
		  <span class='success'>Note: Only clans / non-clan groups that have 30 or more members will be displayed here.</span>"; 
$header = "Results";
include_once ("minigamesinclude.php");
include_once ("../design/bottom.php");
?>