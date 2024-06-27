<? 
include_once ("../design/top.php"); 
require_once("../functions.php");

$id = intval($_GET['id']);

$result = mysql_query("SELECT * FROM `news` WHERE `state` = 1 AND `cat` = 4 AND `id` = $id");
$news = mysql_fetch_assoc($result); ?>
		  <div class="main">
		  <? if(!empty($news)) : ?>
            <h1><?=$news['title'];?></h1>
            <p>Posted by <b><?=$news['by'];?></b> on <b><?=date("d-M-Y", $news['time']);?></b></p>
            <div class="justify">
<?=BBcodeToHTML($news['content']);?>
            </div>
			<? else: echo e_(404); endif; ?>
          </div>
<? include_once ("../design/bottom.php"); ?>