<?
if (!$print){
echo "
<!-- TOP RUNEHEAD LINKS ROW -->
<tr>
  <td colspan='2'>
    <table cellspacing='0' id='runehead'>
      <tr class='headerfooter'>
        <td>Hosted by <a href='http://www.runehead.com'><b>RuneHead.com</b></a></td>
        <td style='text-align: right;'>
          <a href='http://www.runehead.com/clans'>Hiscores Catalogue</a> ::
          <a href='http://www.runehead.com/forum'>Forums</a> ::
";
	if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
		if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
			echo "<a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$combatTypeLink$showLink$searchLink&amp;style=default'>Default Style</a> ::";
		} else {
			echo "<a href='personal.php?clan=$clan&amp;name=$name&amp;style=default'>Default Style</a> ::";	
		}
	} else {
		if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
			echo "<a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$combatTypeLink$showLink$searchLink&amp;style=simple'>Simple Style</a> ::";
		} else {
			echo "<a href='personal.php?clan=$clan&amp;name=$name&amp;style=simple'>Simple Style</a> ::";	
		}
	}
	echo " <a href='report.php?clan=$clan'>Report List</a> ::";
	if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
		echo " <a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$combatTypeLink$showLink$searchLink&amp;print=true'>Printable Version</a>";
	} else {
		echo " <a href='personal.php?clan=$clan&amp;name=$name&amp;print=true'>Printable Version</a>";
	}
echo "
	    </td>
      </tr>
    </table>
  </td>
</tr>
";
} else {
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15, 5, " Hosted by ", "T B L");
	$startX = $pdf->GetX();
	$pdf->Write(5, "RuneHead.com", "http://www.runehead.com");
	$pdf->SetX($startX);
	$pdf->Cell(160, 5, gmdate("jS M Y - g:iA") . " GMT ", "T B R", 1, "R");
	$pdf->SetFont('Arial','',8);
}
?>