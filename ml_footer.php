<?
if (!$print){
echo "
<!-- FOOTER ROW -->
<tr>
  <td valign='top' colspan='2'>
    <table cellspacing='0' id='footer'>
      <tr class='headerfooter'>
        <td>
          <p style='line-height: 150%;'>Copyright &copy; 2005-" . gmdate("Y") . " RuneHead ::
          <a href='http://www.runehead.com/RuneHead+Credits-x'>Credits</a> ::
          <a href='http://www.runehead.com/Privacy+Policy-x'>Privacy Policy</a> ::
          <a href='http://validator.w3.org/check?uri=referer'>XHTML 1.1</a> ::
          <a href='http://jigsaw.w3.org/css-validator/check/referer'>CSS</a><br />
		  You're being served by www6.runehead.com [hades] | Page generation time: ";
$time_end = microtime(true);
$time = $time_end - $time_start;
printf('%.3f seconds', $time);
echo "
          </p>
        </td>
      </tr>
    </table>
  </td>
</tr>				
";
} else {
	$pdf->SetY(-10);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(175, 4, "Page " . $pdf->PageNo() . "/{nb}", 0, 1, "C");
	$pdf->Cell(175, 5, "Copyright &copy; 2005-" . gmdate("Y") . " RuneHead", 0, 1, "C");
	$pdf->SetFont('Arial','',8);
}
?>