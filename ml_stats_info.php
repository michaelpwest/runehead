<?
if (!$print){
echo "
<!-- STATS AND INFO ROW -->
<tr style='width: 100%;'>
";
	if (!isset($hideStats)){
		if (!isset($hideDetails) || !isset($hideRanks)){
			echo "<td valign='top' style='width: 35%;'>";
		} else {
			echo "<td valign='top' style='width: 100%;'>";
		}
echo "
    <table cellspacing='0' id='stats' style='height: 215px;'>
      <tr class='header'>
        <td class='border' style='height: 22px;'>Stats</td>
      </tr>
      <tr>
        <td>
          <ul>
            <li><b>Total Members:</b> $numbermembers</li>
";
	}
} else {
	$startY = $pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60, 5, "STATS", 1, 1, "C");
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','',8);
	$pdf->WriteText(4, " • <Total Members:> $numbermembers");
	$pdf->Ln(4);	
}
if ($skill == "Memberlist"){
	if (!$print){
		if (!isset($hideStats)){
echo "
            <li><b>Average P2P Combat:</b> $cmbavg</li>
            <li><b>Average F2P Combat:</b> $f2pcmbavg</li>			
            <li><b>Average Hitpoints:</b> $hpavg</li>
            <li><b>Average Overall:</b> $skillavg</li>
			<li class='gap'><b>Total XP:</b> $totalxp</li>
";
		}
	} else {
		$pdf->WriteText(4, " • <Average P2P Combat:> $cmbavg");
		$pdf->Ln(4);
		$pdf->WriteText(4, " • <Average F2P Combat:> $f2pcmbavg");
		$pdf->Ln(4);
		$pdf->WriteText(4, " • <Average Hitpoints:> $hpavg");
		$pdf->Ln(4);
		$pdf->WriteText(4, " • <Average Overall:> $skillavg");
		$pdf->Ln(4);
		$pdf->WriteText(4, " • <Total XP:> $totalxp");
		$pdf->Ln(4);
	}
} else {
	if (!$print){
		if (!isset($hideStats)){
echo "
            <li><b>Average $skill:</b> $skillavg</li>
            <li><b>Average $skill Rank:</b> $skillrankavg</li>
";
		}
		if (!isset($hideStats)){
			if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix"){
echo "
            <li><b>Average $skill Score:</b> $skillxpavg</li>
			<li class='gap'><b>Total $skill Score:</b> $skillxptotal</li>
";
			} else {
echo "
            <li><b>Average $skill XP:</b> $skillxpavg</li>
			<li class='gap'><b>Total $skill XP:</b> $skillxptotal</li>
";
			}
		}
	} else {
		$pdf->WriteText(4, " • <Average $skill:> $skillavg");
		$pdf->Ln(4);
		$pdf->WriteText(4, " • <Average $skill Rank:> $skillrankavg");
		$pdf->Ln(4);		
		if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix"){
			$pdf->WriteText(4, " • <Average $skill Score:> $skillxpavg");
			$pdf->Ln(4);
			$pdf->WriteText(4, " • <Total $skill Score:> $skillxptotal");
		} else {
			$pdf->WriteText(4, " • <Average $skill XP:> $skillxpavg");
			$pdf->Ln(4);
			$pdf->WriteText(4, " • <Total $skill XP:> $skillxptotal");
		}
		$pdf->Ln(4);		
	}
}
if (!$print){
	if (!isset($hideStats)){
echo "
            <li><b>Category:</b> $categories[$category]</li>		
            <li><b>Stats Last Updated:</b> $updatetime</li>
          </ul>
        </td>
      </tr>
    </table>
  </td>
";
	}
	if (!isset($hideDetails) || !isset($hideRanks)){
		if (!isset($hideStats)){
			echo "<td valign='top' style='width: 65%;'>";
		} else {
			echo "<td valign='top' style='width: 100%;'>";
		}
echo "
    <table cellspacing='0' id='info' style='height: 215px;'>
      <tr class='header'>
        <td class='border' style='height: 22px;'>Information</td>
      </tr>
      <tr>
        <td class='border'>
";
	}
	if (!isset($hideDetails)){
echo "
          <table id='details' cellspacing='0' border='0'>
            <tr>
              <td style='width: 230px; vertical-align: top;'>
                <p><b>F2P or P2P: </b>$playbase</p>
				<p><b>Cape Colour: </b>$capecolour</p>
                <p><b>Clan Initials: </b>$initials</p>
";
		if ($websiteDisplay != ""){
			echo "<p><b>Website: </b><a href='$website' title='$website'>$websiteDisplay</a></p>";
		}
echo "
              </td>
              <td style='width: 270px; vertical-align: top;'>
                <p><b>Time Base: </b>$timebase</p>
                <p><b>Home World: </b>$homeworldDisplay</p>
				<p><b>Clan Signature: <a href='http://www.draynor.net/clan_signatures.php?fill=".getCurrentPage()."' title='Clan Signatures'>Click here</a></b></p>
";
		if ($ircDisplay != ""){
			echo "<p><b>IRC Channel: </b><a href='$irc' title='$irc'>$ircDisplay</a></p>";
		}
echo "
              </td>
			</tr>
          </table>			
";
	}
} else {
	$pdf->Ln(4);
	$pdf->WriteText(4, " • <Category:> $categories[$category]");
	$pdf->Ln(4);
	$pdf->WriteText(4, " • <Stats Last Updated:> $updatetime");
	$pdf->Ln(7);
	$endY = $pdf->GetY();
	$pdf->SetY($startY);
	$pdf->Cell(61.5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(113.5, 5, "INFORMATION", 1, 1, "C");
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(61.5);
	$pdf->WriteText(4, " <F2P or P2P:> $playbase");
	$pdf->Ln(4);
	$pdf->Cell(61.5);
	$pdf->WriteText(4, " <Cape Colour:> $capecolour");
	$pdf->Ln(4);
	$pdf->Cell(61.5);	
	$pdf->WriteText(4, " <Clan Initials:> $initials");
	$pdf->Ln(4);	
	$pdf->Cell(61.5);	
	$pdf->WriteText(4, " <IRC Channel:> $ircDisplay", $website);
	$pdf->Ln(4);
	$pdf->SetY($pdf->GetY() - 16);
	$pdf->Cell(113.25);
	$pdf->WriteText(4, "<Time Base:> $timebase");
	$pdf->Ln(4);
	$pdf->Cell(113.25);	
	$pdf->WriteText(4, "<Home World:> $homeworld");
	$pdf->Ln(4);
	$pdf->Cell(113.25);
	$pdf->WriteText(4, "<Website:> $websiteDisplay", $website);
	$pdf->Ln(9.5);
}
if (!isset($hideRanks)){
	if (!$print){
echo "
          <table class='ranks' cellspacing='0' border='0' style='margin: 0px auto 0px auto;'>
            <tr>
              <td colspan='5' class='headerfooter' style='width: 500px;'><b>Ranks</b></td>
            </tr>
";
	} else {
		$pdf->Cell(63);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(110.5, 4, "Ranks", 1, 1, "C");
		$pdf->SetFont('Arial','',8);
	}
	$c4 = false;
	$c8 = false;
	$c12 = false;
	$b = 0;
	for ($a = 1; $a <= 16; $a++){
		if (trim(${"rank$a"}) != ""){
			$b++;
		}	
	}
	if ($b != 0 && $b < 4){
		if (!$print){
			$width = 500 / $b;
		} else {
			$width = 110.5 / $b;
		}
	} else {
		if (!$print){
			$width = 125;
		} else {
			$width = 27.625;
		}
	}
	$c = 0;
	if ($b > 0){
		if (!$print){
			echo "<tr>";
		} else {
			$pdf->Cell(63);
		}
	}
	$ranksPrint = array();
	$ranksWidths = array();
	$ranksAligns = array();
	for ($a = 1; $a <= 16; $a++){
		if (trim(${"rank$a"}) != ""){
			$c++;
			if (strpos($_SERVER["PHP_SELF"], "ml.php") > 0){
				if (!$print){
					if ($displaytype == 1) {
						echo "<td style='width:" . $width . "px; color: " . ${"rank" . $a . "colour"} . ";'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$showLink$searchLink&amp;rank=$a' style='color: " . ${"rank" . $a . "colour"} . ";' title='Display Rank: " . ${"rank$a"} . "'>" . ${"rank$a"} . "</a></td>";
					} else {
						echo "<td style='width:" . $width . "px; color: $fontcolour1; background-color: " . ${"rank" . $a . "colour"} . ";'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$showLink$searchLink&amp;rank=$a' style='color: $fontcolour1;' title='Display Rank: " . ${"rank$a"} . "'>" . ${"rank$a"} . "</a></td>";
					}			
				}
			} else {
				if (!$print){
					if ($displaytype == 1) {
						echo "<td style='width:" . $width . "px; color: " . ${"rank" . $a . "colour"} . ";'>" . ${"rank$a"} . "</td>";
					} else {
						echo "<td style='width:" . $width . "px; color: $fontcolour1; background-color: " . ${"rank" . $a . "colour"} . ";'>" . ${"rank$a"} . "</td>";
					}
				}	
			}
			if ($print){
				$ranksPrint[] = ${"rank$a"};
				$ranksWidths[] = $width;
				$ranksAligns[] = "C";
			}
		}	
		if ($c != $b){
			if ($c == 4 && !$c4) {
				$c4 = true;
				if (!$print){			
	echo "
				</tr>
				<tr>
	";
				} else {
					$pdf->SetWidths($ranksWidths);
					$pdf->SetAligns($ranksAligns);
					$pdf->Row($ranksPrint, 4);
					unset($ranksPrint, $ranksWidths, $ranksAligns);
					$pdf->Cell(63);
					$ranksPrint = array();
					$ranksWidths = array();
					$ranksAligns = array();				
				}
			} else if ($c == 8 && !$c8) {
				$c8 = true;		
				if (!$print){
	echo "
				</tr>
				<tr>
	";		
				} else {
					$pdf->SetWidths($ranksWidths);
					$pdf->SetAligns($ranksAligns);
					$pdf->Row($ranksPrint, 4);			
					unset($ranksPrint, $ranksWidths, $ranksAligns);			
					$pdf->Cell(63);
					$ranksPrint = array();
					$ranksWidths = array();
					$ranksAligns = array();				
				}
			} else if ($c == 12 && !$c12){
				$c12 = true;		
				if (!$print){			
	echo "
				</tr>
				<tr>
	";		
				} else {
					$pdf->SetWidths($ranksWidths);
					$pdf->SetAligns($ranksAligns);
					$pdf->Row($ranksPrint, 4);			
					unset($ranksPrint, $ranksWidths, $ranksAligns);			
					$pdf->Cell(63);
					$ranksPrint = array();
					$ranksWidths = array();
					$ranksAligns = array();				
				}
			}
		}
	}
	if ($b > 0){
		if (!$print){
			echo "</tr>";
		} else {
			$pdf->SetWidths($ranksWidths);
			$pdf->SetAligns($ranksAligns);
			$pdf->Row($ranksPrint, 4);
			unset($ranksPrint, $ranksWidths, $ranksAligns);	
			$endY2 = $pdf->GetY() + 1.5;		
			$pdf->Ln(max($endY, $endY2) - $pdf->GetY());
		}
	}
	if (!$print){
		echo "</table>";
	}
	if ($displayRank != ""){
		if (!$print){
	echo "
			  <table class='ranks' cellspacing='0' border='0' style='margin-top: 0px;'>
				<tr>
				  <td class='headerfooter' style='width: 500px;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$sortLink$showLink$searchLink&amp;rank=all' title='Display All Members'><b>Display All Members</b></a></td>
				</tr>
			  </table>
	";
		}
	}
}
if (!$print){
	if (!isset($hideDetails) || !isset($hideRanks)){
echo "
        </td>
      </tr>
    </table>
  </td>
";
	}
	echo "</tr>";
} else {
	$pdf->Rect($pdf->GetX(), $startY, 60, max($endY, $endY2) - $startY);
	$pdf->Rect($pdf->GetX() + 61.5, $startY, 113.5, max($endY, $endY2) - $startY);
	$pdf->Ln(1.5);
}
?>