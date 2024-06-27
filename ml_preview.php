<?
if ($auth->checkAuth() == true){
	if ($rankRow["RANK1COLOUR"] != ""){
		$rank1colour = $rankRow["RANK1COLOUR"];
	} else {
		$rank1colour = "#555555;";
	}
	if ($fontfamily == "tahoma" || $fontfamily == "arial"){
		$fontsize = "12px";
	} else {
		$fontsize = "11px";
	}
echo "
  <h1>Memberlist Preview</h1>
  <table id='previewTable1' style='background-color: $bgcolour;'><tr><td>
  <table border='1' id='previewTable2' style='margin: 10px auto 10px auto; width: 95%; border-collapse: collapse; background-color: $bgcolour; color: $fontcolour1; font-family: $fontfamily; font-size: $fontsize; line-height: 130%; border: 1px solid $bordercolour;'>
    <tr id='previewHeader' style='text-align: center; background-color: $headerbg; color: $headerfont;'>
      <td id='previewHeaderDisplay' colspan='4' style='letter-spacing: 1px; border: 1px solid $bordercolour;'>
        <b>Show:</b>
        <select id='selectBox2' style='background-color: $headerbg; color: $headerfont; border: 1px solid $bordercolour; font-family: $fontfamily; font-size: $fontsize;'>
          <option>All Members</option>
        </select>		
        &nbsp;&nbsp;
		<b>Display:</b>
        <select id='selectBox' style='background-color: $headerbg; color: $headerfont; border: 1px solid $bordercolour; font-family: $fontfamily; font-size: $fontsize;'>
          <option>Memberlist</option>
        </select>
  	    &nbsp;&nbsp;<input type='button' value='Submit' id='submitButton' style='background-color: $headerbg; color: $headerfont; border: 1px solid $bordercolour; font-family: $fontfamily; font-size: $fontsize;' />
      </td>
    </tr>
    <tr id='previewHeader2' style='text-align: center; background-color: $headerbg; color: $headerfont; letter-spacing: 2px;'>
      <td id='previewHeader2Username' colspan='4' style='border: 1px solid $bordercolour;'><b>USERNAME :: MEMBERLIST</b></td>
    </tr>
    <tr id='previewMainHeader' style='text-align: center; background-color: $tablecolour; color: $fontcolour2;'>
      <td id='previewMainHeaderRank' style='width: 7%; border: 1px solid $bordercolour;'><b>Rank</b></td>
      <td id='previewMainHeaderRSN' style='width: 43%; border: 1px solid $bordercolour;'><span style='text-decoration: underline; cursor: pointer;'><b>RuneScape Name <img src='images/arrowdown.png' alt='' /></b></span></td>
      <td id='previewMainHeaderCombat' style='width: 25%; border: 1px solid $bordercolour;'><span style='text-decoration: underline; cursor: pointer;'><b>Combat Level</b> <img src='images/arrowdown.png' alt='' /></span></td>
      <td id='previewMainHeaderHP' style='width: 25%; border: 1px solid $bordercolour;'><span style='text-decoration: underline; cursor: pointer;'><b>Hitpoints Level</b> <img src='images/arrowdown.png' alt='' /></span></td>
    </tr>
";
if ($displaytype == 1){
echo "
    <tr id='previewMain' style='text-align: center; background-color: $tablecolour; color: $rank1colour;'>
";
} else {
echo "
    <tr id='previewMain' style='text-align: center; background-color: $rank1colour; color: $fontcolour1;'>
";
}
echo "
      <td id='previewMainRank' style='border: 1px solid $bordercolour;'>1</td>
      <td id='previewMainRSN' style='border: 1px solid $bordercolour;'><span style='text-decoration: underline; cursor: pointer;'>Username</span></td>
      <td id='previewMainCombat' style='border: 1px solid $bordercolour;'>126.23</td>
      <td id='previewMainHP' style='border: 1px solid $bordercolour;'>99</td>
    </tr>	  
  </table>
  </td></tr></table>
";
}
?>