<?
if (!$print){
echo "
<!-- MAIN MEMBERLIST TABLE-->
<tr>
  <td valign='top' colspan='2'>
    <table cellspacing='0' class='main'>
      <tr class='selectrow'>
        <td colspan='6'>
          <b>Combat:</b>
          <select name='combatType' onchange='submit();' style='width: 60px;'>
            <option value='P2P'"; if ($combatType == "P2P"){ echo " selected='selected'"; } echo ">P2P</option>
            <option value='F2P'"; if ($combatType == "F2P"){ echo " selected='selected'"; } echo ">F2P</option>
          </select>
          <b>Show:</b>
          <select name='show' onchange='submit();'>
            <option value=''>All Members</option>
";
	for ($a = 0; $a < sizeof($showArray); $a++){
		echo "<option value='$showArray[$a]'"; if ($showArray[$a] == $show){ echo " selected='selected'"; } echo ">$showArray[$a]"; if ($showArray[$a] != 138){ echo "+"; } echo " Combat</option>";
	}
echo "
          </select>
          <b>Display:</b>
          <select name='skill' onchange='submit();'>
            <option value='Memberlist'>Memberlist</option>";
	for ($a = 0; $a < sizeof($skills); $a++){
		echo "<option value='$skills[$a]'"; if ($skills[$a] == $skill){echo " selected='selected'";} echo ">$skills[$a]</option>";
	}
echo "
          </select>
		  <b>Search: </b><input name='search' class='search' maxlength='12' value='$search' />
          <input type='submit' value='Submit' style='cursor: pointer;' />
        </td>
      </tr>
      <tr class='header'>
        <td colspan='6'>$clanname :: $skill$showRank$showDisplay</td>
      </tr>
";
}
if ($skill == "Memberlist"){
	if (!$print){
echo "
      <tr class='subheader'>
        <td style='width: 7%;'>Rank</td>
";
		if ($sort == "name"){
			echo "<td style='width: 24%;'><a href='ml.php?clan=$clan&amp;sort=namerev$showLink$searchLink' title='Sort by RuneScape Name (Reverse)' style='color: $fontcolour2;'>RuneScape Name <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 24%;'><a href='ml.php?clan=$clan&amp;sort=name$showLink$searchLink' title='Sort by RuneScape Name' style='color: $fontcolour2;'>RuneScape Name <img src='images/arrowdown.png' alt='' /></a></td>";
		}	
		if ($sort == "cmb" || $sort == ""){	
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=cmbrev$showLink$searchLink' title='Sort by $combatType Combat Level (Reverse)' style='color: $fontcolour2;'>$combatType Combat Level <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=cmb$showLink$searchLink' title='Sort by $combatType Combat Level' style='color: $fontcolour2;'>$combatType Combat Level <img src='images/arrowdown.png' alt='' /></a></td>";	
		}	
		if ($sort == "hp"){
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=hprev$showLink$searchLink' title='Sort by Hitpoints Level (Reverse)' style='color: $fontcolour2;'>Hitpoints Level <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=hp$showLink$searchLink' title='Sort by Hitpoints Level' style='color: $fontcolour2;'>Hitpoints Level <img src='images/arrowdown.png' alt='' /></a></td>";
		}	
		if ($sort == "overall"){
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=overallrev$showLink$searchLink' title='Sort by Overall Level (Reverse)' style='color: $fontcolour2;'>Overall Level <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 18%;'><a href='ml.php?clan=$clan&amp;sort=overall$showLink$searchLink' title='Sort by Overall Level' style='color: $fontcolour2;'>Overall Level <img src='images/arrowdown.png' alt='' /></a></td>";	
		}
echo "
        <td style='width: 18%;'>Highest Skill</td>
      </tr>
";
	}
} else if ($skill == "Overall"){
	if (!$print) {
echo "
      <tr class='subheader'>
        <td style='width:7%;'>Rank</td>
";
		if ($sort == "name"){
			echo "<td style='width: 33%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=namerev' title='Sort by RuneScape Name (Reverse)' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 33%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=name' title='Sort by RuneScape Name' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowdown.png' alt='' /></a></td>";
		}
		if ($sort != "name" && $sort != "namerev" && $sort != "overallrev" && $sort != "overallxp" && $sort != "overallxprev"){
echo "
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=overallrev' title='Sort by Overall Rank (Reverse)' style='color: $fontcolour2;'><b>Overall Rank</b> <img src='images/arrowup.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=overallrev' title='Sort by Overall Level (Reverse)' style='color: $fontcolour2;'><b>Overall Level</b> <img src='images/arrowup.png' alt='' /></a></td>
";
		} else {
echo "
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink' title='Sort by Overall Rank' style='color: $fontcolour2;'><b>Overall Rank</b> <img src='images/arrowdown.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink' title='Sort by Overall Level' style='color: $fontcolour2;'><b>Overall Level</b> <img src='images/arrowdown.png' alt='' /></a></td>
";	
		}
		if ($sort == "overallxp"){
			echo "<td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=overallxprev' title='Sort by Overall XP (Reverse)' style='color: $fontcolour2;'><b>Overall XP</b> <img src='images/arrowup.png' alt='' /></a></td>";
		} else {
			echo "<td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=Overall$showLink$searchLink&amp;sort=overallxp' title='Sort by Overall XP' style='color: $fontcolour2;'><b>Overall XP</b> <img src='images/arrowdown.png' alt='' /></a></td>";
		}
echo "
      </tr>
";
	}
} else if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix" || strtolower($skill) == "mobilising armies" || strtolower($skill) == "ba attackers" || strtolower($skill) == "ba defenders" || strtolower($skill) == "ba collectors" || strtolower($skill) == "ba healers" || strtolower($skill) == "castle wars games"){
	if (!$print){
echo "
      <tr class='subheader'>
        <td style='width: 7%;'>Rank</td>
";
		if ($sort == "name"){
			echo "<td style='width: 33%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=namerev' title='Sort by RuneScape Name (Reverse)' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowup.png' alt='' /></a></td>";	
		} else {
			echo "<td style='width: 33;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=name' title='Sort by RuneScape Name' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowdown.png' alt='' /></a></td>";
		}
		if ($sort != "name" && $sort != "name" && $sort != "skillrev"){
echo "
        <td style='width: 30%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=skillrev' title='Sort by $skill Rank (Reverse)' style='color: $fontcolour2;'><b>$skill Rank</b> <img src='images/arrowup.png' alt='' /></a></td>
        <td style='width: 30%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=skillrev' title='Sort by $skill Score (Reverse)' style='color: $fontcolour2;'><b>$skill Score</b> <img src='images/arrowup.png' alt='' /></a></td>
";
		} else {
echo "
        <td style='width: 30%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink' title='Sort by $skill Rank' style='color: $fontcolour2;'><b>$skill Rank</b> <img src='images/arrowdown.png' alt='' /></a></td>
        <td style='width: 30%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink' title='Sort by $skill Score' style='color: $fontcolour2;'><b>$skill Score</b> <img src='images/arrowdown.png' alt='' /></a></td>
";
		}
echo "
      </tr>
";
	}
} else {
	if (!$print){
echo "
      <tr class='subheader'>
        <td style='width: 7%;'>Rank</td>
";
		if ($sort == "name"){
			echo "<td style='width: 33%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=namerev' title='Sort by RuneScape Name (Reverse)' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowup.png' alt='' /></a></td>";	
		} else {
			echo "<td style='width: 33%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=name' title='Sort by RuneScape Name' style='color: $fontcolour2;'><b>RuneScape Name</b> <img src='images/arrowdown.png' alt='' /></a></td>";
		}
		if ($sort != "name" && $sort != "name" && $sort != "skillrev"){
echo "
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=skillrev' title='Sort by $skill Rank (Reverse)' style='color: $fontcolour2;'><b>$skill Rank</b> <img src='images/arrowup.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=skillrev' title='Sort by $skill Level (Reverse)' style='color: $fontcolour2;'><b>$skill Level</b> <img src='images/arrowup.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink&amp;sort=skillrev' title='Sort by $skill XP (Reverse)' style='color: $fontcolour2;'><b>$skill XP</b> <img src='images/arrowup.png' alt='' /></a></td>
";
		} else {
echo "
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink' title='Sort by $skill Rank' style='color: $fontcolour2;'><b>$skill Rank</b> <img src='images/arrowdown.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink' title='Sort by $skill Level' style='color: $fontcolour2;'><b>$skill Level</b> <img src='images/arrowdown.png' alt='' /></a></td>
        <td style='width: 20%;'><a href='ml.php?clan=$clan&amp;skill=" . urlencode($skill) . "$showLink$searchLink' title='Sort by $skill XP' style='color: $fontcolour2;'><b>$skill XP</b> <img src='images/arrowdown.png' alt='' /></a></td>
";
		}
echo "
      </tr>
";
	}
}
if (mysql_num_rows($membersResult) > 0){
	if ($skill == "Memberlist"){
		$a = 0;
		while ($membersRow = @mysql_fetch_array($membersResult)){
			$rsn = $membersRow["RSN"];
			$personalName = urlencode($rsn);		
			if ($combatType == "F2P"){
				$combat = $membersRow["F2PCOMBAT"];
			} else {
				$combat = $membersRow["COMBAT"];			
			}
			$cmbatt = levelXP($membersRow["ATTACK"]);
			$cmbdef = levelXP($membersRow["DEFENCE"]);
			$cmbstr = levelXP($membersRow["STRENGTH"]);
			$cmbhp = levelXP($membersRow["HITPOINTS"]);
			$cmbranged = levelXP($membersRow["RANGED"]);
			$cmbprayer = levelXP($membersRow["PRAYER"]);
			$cmbmagic = levelXP($membersRow["MAGIC"]);
			$cmbsummoning = levelXP($membersRow["SUMMONING"]);
			$hitpoints = levelXP($membersRow["HITPOINTS"]);
			$hitpointsxp = $membersRow["HITPOINTS"];
			$overall = $membersRow["OVERALL"];
			$overallxp = $membersRow["OVERALLXP"];
			$rank = str_replace("rank", "", $membersRow["RANK"]);
			if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
				$rankColour = $colourarray[$rank];
			} else {
				$rankColour = @${"rank{$rank}colour"};
			}
			$topskill = trim($membersRow['TOPSKILL']);
			$topskill2 = strtoupper(substr($topskill, 3));	
			if (!empty($topskill) && strtolower($topskill) != 'none'){
				$topskillTitle = number_format($membersRow[$topskill2]) . " XP";
			} else {
				$topskill = "None";
				$topskillTitle = "";		
			}
			$a++;
			if (!$print){
				if ($displaytype == 1){				
echo "
      <tr style='background-color: $tablecolour; color: $rankColour;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $rankColour;'>$rsn</a></td>
        <td><a title='$cmbatt Att | $cmbdef Def | $cmbstr Str | $cmbhp HP | $cmbprayer Prayer | $cmbranged Ranged | $cmbmagic Magic | $cmbsummoning Summoning' style='text-decoration: none; color: $rankColour;'>$combat</a></td>
        <td><a title='".number_format($hitpointsxp)." XP' style='text-decoration: none; color: $rankColour;'>$hitpoints</a></td>
        <td><a title='".number_format($overallxp)." XP' style='text-decoration: none; color: $rankColour;'>".number_format($overall)."</a></td>
        <td><a title='$topskillTitle' style='text-decoration: none; color: $rankColour;'>$topskill</a></td>	
      </tr>
";
				} else {
echo "
      <tr style='background-color: $rankColour; color: $fontcolour1;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $fontcolour1;'>$rsn</a></td>
        <td><a title='$cmbatt Att | $cmbdef Def | $cmbstr Str | $cmbhp HP | $cmbprayer Prayer | $cmbranged Ranged | $cmbmagic Magic | $cmbsummoning Summoning' style='text-decoration: none; color: $fontcolour1;'>$combat</a></td>
        <td><a title='".number_format($hitpointsxp)." XP' style='text-decoration: none; color: $fontcolour1;'>$hitpoints</a></td>
        <td><a title='".number_format($overallxp)." XP' style='text-decoration: none; color: $fontcolour1;'>".number_format($overall)."</a></td>
        <td><a title='$topskillTitle' style='text-decoration: none; color: $fontcolour1;'>$topskill</a></td>	
      </tr>
";
				}
			} else {
				$pdf->Row(array($a, $rsn, ${"rank$rank"}, $combat, $hitpoints, number_format($overall), $topskill));
			}
		}
	} else if ($skill == "Overall") {
		$a = 0;
		while ($membersRow = @mysql_fetch_array($membersResult)){
			$rsn = $membersRow["RSN"];
			$personalName = urlencode($rsn);
			$overallrank = number_format($membersRow["OVERALLRANK"]);
			$overall = number_format($membersRow["OVERALL"]);
			$overallxp = number_format($membersRow["OVERALLXP"]);
			$rank = str_replace("rank", "", $membersRow["RANK"]);
			if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
				$rankColour = $colourarray[$rank];
			} else {
				$rankColour = @${"rank{$rank}colour"};
			}
			$a++;
			if (!$print){
				if ($displaytype == 1){
	echo "
      <tr style='background-color: $tablecolour; color: $rankColour;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $rankColour;'>$rsn</a></td>
        <td>$overallrank</td>
        <td>$overall</td>
        <td>$overallxp</td>
      </tr>
";
				} else {
echo "
      <tr style='background-color: $rankColour; color: $fontcolour1;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $fontcolour1;'>$rsn</a></td>
        <td>$overallrank</td>
        <td>$overall</td>
        <td>$overallxp</td>
      </tr>
";
				}
			} else {
				$pdf->Row(array($a, $rsn, ${"rank$rank"}, $overallrank, $overall, $overallxp));
			}
		}
	} else if (strtolower($skill) == "duel tournament" || strtolower($skill) == "bounty hunters" || strtolower($skill) == "bounty hunter rogues" || strtolower($skill) == "fist of guthix" || strtolower($skill) == "mobilising armies" || strtolower($skill) == "ba attackers" || strtolower($skill) == "ba defenders" || strtolower($skill) == "ba collectors" || strtolower($skill) == "ba healers" || strtolower($skill) == "castle wars games"){
		$a = 0;
		while ($membersRow = @mysql_fetch_array($membersResult)){
			$rsn = $membersRow["RSN"];
			$personalName = urlencode($rsn);
			$skillrank = number_format($membersRow[strtoupper($skill) . "RANK"]);
			$skillxp = number_format($membersRow[strtoupper($skill)]);
			$skilllevel = levelXP($membersRow[strtoupper($skill)]);
			$rank = str_replace("rank", "", $membersRow["RANK"]);
			if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
				$rankColour = $colourarray[$rank];
			} else {
				$rankColour = @${"rank{$rank}colour"};
			}
			$a++;
			if (!$print){
				if ($displaytype == 1){
echo "
      <tr style='background-color: $tablecolour; color: $rankColour;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $rankColour;'>$rsn</a></td>
        <td>$skillrank</td>
        <td>$skillxp</td>
      </tr>
";
				} else {

echo "
      <tr style='background-color: $rankColour; color: $fontcolour1;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $fontcolour1;'>$rsn</a></td>
        <td>$skillrank</td>
        <td>$skillxp</td>
      </tr>
";
				}
			} else {
				$pdf->Row(array($a, $rsn, ${"rank$rank"}, $skillrank, $skillxp));
			}
		}
	} else {
		$a = 0;
		while ($membersRow = @mysql_fetch_array($membersResult)){
			$rsn = $membersRow["RSN"];
			$personalName = urlencode($rsn);
			$skillrank = number_format($membersRow[strtoupper($skill) . "RANK"]);
			$skillxp = number_format($membersRow[strtoupper($skill)]);
			$skilllevel = levelXP($membersRow[strtoupper($skill)]);
			$rank = str_replace("rank", "", $membersRow["RANK"]);
			if (($style == "simple" || (isset($_SESSION["style"]) && $_SESSION["style"] == "simple")) && $style != "default"){
				$rankColour = $colourarray[$rank];
			} else {
				$rankColour = @${"rank{$rank}colour"};
			}
			$a++;
			if (!$print){
				if ($displaytype == 1){
echo "
      <tr style='background-color: $tablecolour; color: $rankColour;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $rankColour;'>$rsn</a></td>
        <td>$skillrank</td>
        <td>$skilllevel</td>
        <td>$skillxp</td>
      </tr>
";
				} else {

echo "
      <tr style='background-color: $rankColour; color: $fontcolour1;'>
        <td>$a</td>
        <td><a title='Visit Personal Stats Page for $rsn' href='personal.php?name=$personalName&amp;clan=".strtolower($username)."' style='color: $fontcolour1;'>$rsn</a></td>
        <td>$skillrank</td>
        <td>$skilllevel</td>
        <td>$skillxp</td>
      </tr>
";
				}
			} else {
				$pdf->Row(array($a, $rsn, ${"rank$rank"}, $skillrank, $skilllevel, $skillxp));
			}
		}
	}
} else {
	if (!$print){
echo "
      <tr class='subheader' style='letter-spacing: 2px;'>
	    <td colspan='6'><b>NO MEMBERS FOUND</b></td>
	  </tr>
";
	} else {
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(170, 5, "NO MEMBERS FOUND", 1, 1, "C");
		$pdf->SetFont('Arial','',8);
	}
}
if (!$print){
echo "
    </table>
  </td>
</tr>
";
}
?>
