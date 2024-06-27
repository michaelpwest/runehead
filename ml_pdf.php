<?
include_once("FPDF/mctable.php");	
class ML extends PDF_MC_Table {
	function Header(){
		global $pdf, $print, $clanname, $skill, $numbermembers, $cmbavg, $f2pcmbavg, $hpavg, $skillavg, $totalxp, $category, $categories, $updatetime, $playbase,
			   $timebase, $capecolour, $homeworld, $initials, $website, $websiteDisplay, $irc, $ircDisplay, $displayRank, $skillrankavg, $skillxpavg, $skillxptotal,
			   $showDisplay, $showRank, $combatType;
		for ($a = 1; $a <= 16; $a++){
			global ${"rank$a"};
			global ${"rank" . $a . "colour"};
		}
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(175, 3, "", "T L R", 1);
		$pdf->MultiCell(175, 6, "$clanname Memberlist", "L R", "C");
		$pdf->Cell(175, 3, "", "B L R", 1);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln(1.5);
		include ("ml_top.php");
		$pdf->Ln(1.5);
		include_once ("ml_stats_info.php");
		if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(175, 5, strtoupper("$clanname :: $skill$showRank$showDisplay"), 1, 1, "C");
			if ($skill == "Memberlist"){
				$pdf->SetWidths(array(10,30.5,30.5,26,26,26,26));
				$pdf->SetAligns(array("C","C","C","C","C","C","C"));
				$pdf->Row(array("Rank","RuneScape Name","Rank Name", "$combatType Combat Level","Hitpoints Level","Overall Level","Highest Skill"));
			} else if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix"){
				$pdf->SetWidths(array(10,30.5,30.5,52,52));
				$pdf->SetAligns(array("C","C","C","C","C","C"));
				$pdf->Row(array("Rank","RuneScape Name","Rank Name","$skill Rank","$skill XP"));
			} else {
				$pdf->SetWidths(array(10,30.5,30.5,34.66,34.67,34.67));
				$pdf->SetAligns(array("C","C","C","C","C","C"));
				$pdf->Row(array("Rank","RuneScape Name","Rank Name","$skill Rank","$skill Level","$skill XP"));
			}
		}
		$pdf->SetFont('Arial','',8);
	}
	
	function Footer(){
		global $pdf, $print;
		include ("ml_footer.php");
	}
}
$pdf = new ML();
$pdf->AliasNbPages();
$pdf->SetTitle("$clanname Memberlist");
$pdf->SetAuthor("RuneHead Hiscores Catalogue");
$pdf->SetMargins(17.5, 10);		
$pdf->AddPage();
if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
	include_once ("ml_main.php");
	$pdf->Output(str_replace(" ","_",$clanname) . "_" . $skill . "_" . gmdate("jS_M_Y") . ".pdf", "D");
} else {
	include_once ("personal_main.php");	
	$pdf->Output(str_replace(" ","_",$clanname) . "_" . $name . "_Stats_" . gmdate("jS_M_Y") . ".pdf", "D");
}
?>