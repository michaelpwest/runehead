<?
include_once ("../design/top.php"); 
require_once("../functions.php");

$news = @mysql_query("SELECT `id`, `time`, `title`, `content` FROM news WHERE `cat` = 4 ORDER BY `time` DESC, `title` DESC");
while ($row = @mysql_fetch_row($news))
  $dNews[] = $row;

?>
<div class='main'>
  <h1>All News Items</h1>
  <div class='justify'>
  <? foreach($dNews as $row) : ?>
    <h2><?=date("d-M-Y", $row[1]);?> - <?=$row[2];?></h2>
    <?=BBcodeToHTML(substr($row[3], 0, 400), false);?>
    <span style='margin-left: 13px;'><a href='news.php?id=<?=$row[0];?>'>View Entire Article</a></span><br /><br /><br />
  <? endforeach; ?>
  </div>
</div>
<? include_once ("../design/bottom.php"); ?>
