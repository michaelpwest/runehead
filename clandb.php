<?
include_once ("../design/top.php");
$pagename = "clandb.php";
if (!isset($pagetype)){
	$pagetype = "clan";
}
$title = "The RuneHead Hiscores Memberlist Database";
$intro = "See what clans / non clan groups are using the RuneHead Hiscores Catalogue.<br />
		  Use the sort options at the top of the table to sort memberlists in a specific
		  order. If the results are more than one page long you can display another
		  page with the drop down menu or by clicking next / previous page.<br /><br />
		  <span class='success'>Note: Only memberlists that have 30 or more members will be displayed here.</span>"; 
$header = "Results";
include_once ("dbpages.php");
include_once ("../design/bottom.php");
?>