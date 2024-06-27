<?
$news = @mysql_query("SELECT `id`, `time`, `title` FROM news WHERE `cat` = 4 ORDER BY `time` DESC, `title` DESC LIMIT 0,3");

echo "<ul>";
while ($row = @mysql_fetch_row($news)){
  $date = date("d-M-Y", $row[1]);
  echo "
  <li>
    <a href='news.php?id={$row[0]}'>($date) {$row[2]}</a>
  </li>
  ";
}
echo "</ul><p><a href='newsall.php'>View all news</a></p>";
?>