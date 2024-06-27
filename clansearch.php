<?
include_once ("../design/top.php");

$capes = array("0", "black", "blue", "green", "orange", "purple", "red", "yellow");
$capes2 = array("0", "black", "blue", "green", "orange", "purple", "red", "yellow");
for ($a = 1; $a <= 50; $a++){
	$capes[] = "wilderness$a";
	$capes2[] = "Wilderness Cape $a";
}
$play = array("0", "f2p", "p2p", "f2pp2p");
$time = array("0", "usa", "europe", "australasia");

if (isset($_REQUEST["combatType"])){
	$combatType = @mysql_escape_string($_REQUEST["combatType"]);
} else {
	$combatType = "p2p";
}

if (isset($_REQUEST["search"]) && @mysql_escape_string($_REQUEST["search"]) == true){
	if (isset($_REQUEST["sort"])){
		$sort = @mysql_escape_string($_REQUEST["sort"]);
	} else {
		$sort = "name";
	}
	$criteria = "";
	
	$nameSearch = @mysql_escape_string($_REQUEST["nameSearch"]);
	$mlType = @mysql_escape_string($_REQUEST["mlType"]);

	$playbase = @mysql_escape_string($_REQUEST["playbase"]);
	$timebase = @mysql_escape_string($_REQUEST["timebase"]);
	$capecolour = @mysql_escape_string($_REQUEST["capecolour"]);
	$homeworld = @mysql_escape_string($_REQUEST["homeworld"]);

	$nummembersmin = @mysql_escape_string(trim($_REQUEST["nummembersmin"]));
	$nummembersmax = @mysql_escape_string(trim($_REQUEST["nummembersmax"]));	

	$cmbavgmin = @mysql_escape_string(trim($_REQUEST["cmbavgmin"]));
	$cmbavgmax = @mysql_escape_string(trim($_REQUEST["cmbavgmax"]));	

	$hpavgmin = @mysql_escape_string(trim($_REQUEST["hpavgmin"]));
	$hpavgmax = @mysql_escape_string(trim($_REQUEST["hpavgmax"]));	

	$magicavgmin = @mysql_escape_string(trim($_REQUEST["magicavgmin"]));
	$magicavgmax = @mysql_escape_string(trim($_REQUEST["magicavgmax"]));	

	$rangedavgmin = @mysql_escape_string(trim($_REQUEST["rangedavgmin"]));
	$rangedavgmax = @mysql_escape_string(trim($_REQUEST["rangedavgmax"]));	

	$overallavgmin = @mysql_escape_string(trim($_REQUEST["overallavgmin"]));
	$overallavgmax = @mysql_escape_string(trim($_REQUEST["overallavgmax"]));	
	
	if (trim($nameSearch) != "" || $mlType != "" || $playbase != 0 || $timebase != 0 || $capecolour != 0 || ($homeworld != 0 && is_numeric($homeworld)) || ($nummembersmin != "" && is_numeric($nummembersmin)) || ($nummembersmax != "" && is_numeric($nummembersmax)) || ($cmbavgmin != "" && is_numeric($cmbavgmin)) || ($cmbavgmax != "" && is_numeric($cmbavgmax)) || ($hpavgmin != "" && is_numeric($hpavgmin)) || ($hpavgmax != "" && is_numeric($hpavgmax)) || ($magicavgmin != "" && is_numeric($magicavgmin)) || ($magicavgmax != "" && is_numeric($magicavgmax)) || ($rangedavgmin != "" && is_numeric($rangedavgmin)) || ($rangedavgmax != "" && is_numeric($rangedavgmax)) || ($overallavgmin != "" && is_numeric($overallavgmin)) || ($overallavgmax != "" && is_numeric($overallavgmax))){
		$sql = "SELECT U.USERNAME, U.CLANNAME, U.PLAYBASE, U.TIMEBASE, U.CAPECOLOUR, U.HOMEWORLD,
				A.CMBAVG, A.F2PCMBAVG, A.HPAVG, A.SKILLAVG, A.NUMBERMEMBERS, A.MAGICAVG, A.RANGEDAVG
				FROM USERS U, AVERAGES A
				WHERE U.USERNAME = A.USERNAME
				AND U.ACTIVE = '1'
				AND U.VALIDATED = '1'
				AND U.UPDATETIME != '0000-00-00 00:00:00'				
				AND A.NUMBERMEMBERS > '0' ";
		if ($nameSearch != ""){
			$criteria .= "&amp;nameSearch=$nameSearch";
			$sql .= "AND (U.USERNAME = '$nameSearch'
					OR U.CLANNAME LIKE '%$nameSearch%'
					OR U.INITIALS LIKE '%$nameSearch%') ";
		}
		if ($mlType != ""){
			$criteria .= "&amp;mlType=$mlType";
			if ($mlType == "clan") {
				$sql .= "AND U.CLANTYPE = 'clan' ";
			} else if ($mlType == "non-clan") {
				$sql .= "AND U.CLANTYPE = 'non-clan' ";
			} else if ($mlType == "7"){
				$sql .= "AND (U.CATEGORY = '7' OR U.CATEGORY = '0') ";
			}  else if ($mlType > 1 && $mlType <= sizeof($categories)){
				$sql .= "AND U.CLANTYPE = 'non-clan'
						 AND U.CATEGORY = '$mlType' ";
			}
		}
		if ($playbase != ""){
			$criteria .= "&amp;playbase=$playbase";
			$sql .= "AND U.PLAYBASE = '$play[$playbase]' ";
		}
		if ($timebase != ""){
			$criteria .= "&amp;timebase=$timebase";
			$sql .= "AND U.TIMEBASE = '$time[$timebase]' ";
		}
		if ($capecolour != ""){
			$criteria .= "&amp;capecolour=$capecolour";
			$sql .= "AND U.CAPECOLOUR = '$capes[$capecolour]' ";
		}
		if ($homeworld != ""){
			$criteria .= "&amp;homeworld=$homeworld";
			$sql .= "AND U.HOMEWORLD = '$homeworld' ";
		}
		if ($nummembersmin != ""){
			$criteria .= "&amp;nummembersmin=$nummembersmin";
			$sql .= "AND A.NUMBERMEMBERS >= '$nummembersmin' ";		
		}
		if ($nummembersmax != ""){
			$criteria .= "&amp;nummembersmax=$nummembersmax";
			$sql .= "AND A.NUMBERMEMBERS <= '$nummembersmax' ";		
		}
		if ($cmbavgmin != ""){
			$criteria .= "&amp;cmbavgmin=$cmbavgmin";
			if ($combatType == "f2p"){
				$sql .= "AND A.F2PCMBAVG >= '$cmbavgmin' ";
			} else {
				$sql .= "AND A.CMBAVG >= '$cmbavgmin' ";			
			}
		}
		if ($cmbavgmax != ""){
			$criteria .= "&amp;cmbavgmax=$cmbavgmax";
			if ($combatType == "f2p"){
				$sql .= "AND A.F2PCMBAVG <= '$cmbavgmax' ";
			} else {
				$sql .= "AND A.CMBAVG <= '$cmbavgmax' ";			
			}
		}
		if ($hpavgmin != ""){
			$criteria .= "&amp;hpavgmin=$hpavgmin";
			$sql .= "AND A.HPAVG >= '$hpavgmin' ";		
		}
		if ($hpavgmax != ""){
			$criteria .= "&amp;hpavgmax=$hpavgmax";
			$sql .= "AND A.HPAVG <= '$hpavgmax' ";		
		}
		if ($magicavgmin != ""){
			$criteria .= "&amp;magicavgmin=$magicavgmin";
			$sql .= "AND A.MAGICAVG >= '$magicavgmin' ";		
		}
		if ($magicavgmax != ""){
			$criteria .= "&amp;magicavgmax=$magicavgmax";
			$sql .= "AND A.MAGICAVG <= '$magicavgmax' ";		
		}
		if ($rangedavgmin != ""){
			$criteria .= "&amp;rangedavgmin=$rangedavgmin";
			$sql .= "AND A.RANGEDAVG >= '$rangedavgmin' ";		
		}
		if ($rangedavgmax != ""){
			$criteria .= "&amp;rangedavgmax=$rangedavgmax";
			$sql .= "AND A.RANGEDAVG <= '$rangedavgmax' ";		
		}
		if ($overallavgmin != ""){
			$criteria .= "&amp;overallavgmin=$overallavgmin";
			$sql .= "AND A.SKILLAVG >= '$overallavgmin' ";		
		}
		if ($overallavgmax != ""){
			$criteria .= "&amp;overallavgmax=$overallavgmax";
			$sql .= "AND A.SKILLAVG <= '$overallavgmax' ";		
		}		
		if ($sort == "name"){
			$sql .= "ORDER BY TRIM(U.CLANNAME) ";
		} else if ($sort == "mem"){
			$sql .= "ORDER BY A.NUMBERMEMBERS DESC ";
		} else if ($sort == "hp"){
			$sql .= "ORDER BY A.HPAVG DESC ";
		} else if ($sort == "cmb"){
			if ($combatType == "f2p"){
				$sql .= "ORDER BY A.F2PCMBAVG DESC ";
			} else {
				$sql .= "ORDER BY A.CMBAVG DESC ";			
			}
		} else if ($sort == "magic"){
			$sql .= "ORDER BY A.MAGICAVG DESC ";
		}  else if ($sort == "ranged"){
			$sql .= "ORDER BY A.RANGEDAVG DESC ";
		} else if ($sort == "overall"){
			$sql .= "ORDER BY A.SKILLAVG DESC ";
		}
		$result = @mysql_query($sql);
		$size = @mysql_num_rows($result);
		if ($size > 0){
echo "<!-- <div class='linkbanner'>";
//include_once('ads/banner1.php');
echo "</div> /-->
<div class='main'>
  <h1>Memberlist Search Results</h1>
";
if ($size == 1){
  echo "<p><b>$size</b> result was found:</p>";
} else {
  echo "<p><b>$size</b> results were found:</p>";
}
echo "
  <form action='clansearch.php?search=true$criteria' method='post' style='display: inline;'>
    <p>
      Combat:
      <select name='combatType' style='width: 115px;' onchange='submit();'>
        <option value='p2p'"; if ($combatType == "p2p"){ echo "selected='selected'"; } echo ">P2P Combat</option>
        <option value='f2p'"; if ($combatType == "f2p"){ echo "selected='selected'"; } echo ">F2P Combat</option>
      </select>
	  <input type='submit' value='Show' />
    </p>
  </form>
  <div style='max-height: 400px; overflow: auto; overflow-x: hidden;'>
    <table class='contenttable' border='1'>
      <tr class='header'>
        <td style='width: 34%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=name&amp;combatType=$combatType$criteria' title='Sort by Name'><b>Name</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=mem&amp;combatType=$combatType$criteria' title='Sort by Number of Members'><b>Members</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=cmb&amp;combatType=$combatType$criteria' title='Sort by " . strtoupper($combatType) . " Combat Average'><b> " . strtoupper($combatType) . " Cmb</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=hp&amp;combatType=$combatType$criteria' title='Sort by Hitpoints Average'><b>HP</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=magic&amp;combatType=$combatType$criteria' title='Sort by Magic Average'><b>Magic</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=ranged&amp;combatType=$combatType$criteria' title='Sort by Ranged Average'><b>Ranged</b></a></td>
        <td style='width: 10%;' class='tableborder'><a href='clansearch.php?search=true&amp;sort=overall&amp;combatType=$combatType$criteria' title='Sort by Overall Average'><b>Overall</b></a></td>
      </tr>
";
			while ($row = @mysql_fetch_array($result)){
				$current = $row["USERNAME"];
				$clanmembers = $row["NUMBERMEMBERS"];
				$clanname = $row["CLANNAME"];
				if ($combatType == "f2p"){
					$cmbavg = $row["F2PCMBAVG"];	
				} else {
					$cmbavg = $row["CMBAVG"];
				}
				$hpavg = $row["HPAVG"];
				$magicavg = $row["MAGICAVG"];
				$rangedavg = $row["RANGEDAVG"];
				$overallavg = number_format($row["SKILLAVG"]);
echo "
      <tr class='hovertr'>
        <td style='width: 34%;' class='tableborder'><a href='ml.php?clan=$current' title='View $clanname Memberlist'>$clanname</a></td>
        <td style='width: 10%;' class='tableborder'>$clanmembers</td>
        <td style='width: 10%;' class='tableborder'>$cmbavg</td>
        <td style='width: 10%;' class='tableborder'>$hpavg</td>
        <td style='width: 10%;' class='tableborder'>$magicavg</td>
        <td style='width: 10%;' class='tableborder'>$rangedavg</td>
        <td style='width: 10%;' class='tableborder'>$overallavg</td>
	  </tr>
";
			}
echo "
    </table>
  </div>
  <p style='text-align: center;'><a href='clansearch.php'>Search Again</a></p>
</div>

";
		} else {
echo "
<div class='main'>
  <h1>Memberlist Search Results</h1>
  <p>No matching memberlists were found under the chosen search criteria.</p>
  <p style='text-align: center;'><a href='clansearch.php'>Search Again</a></p>
</div>
";
		}
	} else {
echo "
<div class='main'>
  <h1>Memberlist Search Results</h1>
  <p>You must select / enter at least one criteria to search by.</p>
  <p style='text-align: center;'><a href='clansearch.php'>Search Again</a></p>
</div>
";
	}
} else {
	$width = "150px";
	$widthinput = "65px";
echo "
<div id='intro'>
  <h1>Memberlist Search</h1>
  <div class='justify'>
    <p>Find a specific memberlist according to a search criteria.<br />
	Select or enter (by entering a min and / or max value) in the search criteria below and click the \"Search\"
	button to find memberlists matching that criteria.</p>
  </div>
</div>
<!-- <div class='linkbanner'>
";
//include_once('ads/banner1.php');
echo "
</div> /-->
<form action='' method='post'>
  <div class='main'>
    <h1>Search Criteria</h1>
    <table border='0' style='width: 600px;' cellpadding='2'>
      <tr>
        <td style='width: 220px;'>Name / Initials / Username:</td>
        <td style='width: 300px;'><input name='nameSearch' maxlength='50' style='width: $width;' /></td>
      </tr>
      <tr>
        <td style='width: 220px;'>Memberlist Category:</td>
        <td style='width: 300px;'>
          <select name='mlType' style='width: $width;'>
            <option value=''>Any</option>
            <option value='clan'>Official Clan List</option>
            <option value='non-clan'>All Non-Clans</option>
";
			for ($a = 2; $a < sizeof($categories); $a++){
				echo "<option value='$a'>$categories[$a]</option>";	
			}
echo "
          </select>
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>F2P or P2P Based:</td>
        <td style='width: 300px;'>
          <select name='playbase' style='width: $width;'>
            <option value=''>Any</option>
            <option value='1'>F2P Based</option>
            <option value='2'>P2P Based</option>
            <option value='3'>F2P &amp; P2P Based</option>
          </select>
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Time Base:</td>
        <td style='width: 300px;'>
          <select name='timebase' style='width: $width;'>
            <option value=''>Any</option>
            <option value='1'>America</option>
            <option value='2'>Europe</option>
            <option value='3'>Asia-Pacific</option>
          </select>
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Cape Colour:</td>
        <td style='width: 300px;'>
          <select name='capecolour' style='width: $width;'>
            <option value=''>Any</option>
            <option value='1'>Black</option>
            <option value='2'>Blue</option>
            <option value='3'>Green</option>
            <option value='4'>Orange</option>
            <option value='5'>Purple</option>
            <option value='6'>Red</option>
            <option value='7'>Yellow</option>
";
			for ($a = 8; $a <= 57; $a++){
				echo "<option value='$a'>" . $capes2[$a] . "</option>";
			}	  
echo "
          </select>
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Home World:</td>
        <td style='width: 300px;'><input name='homeworld' maxlength='3' style='width: $width;' value='' /></td>
      </tr>
      <tr>
        <td style='width: 220px;'>Number of Members:</td>
        <td style='width: 300px;'>
          <input name='nummembersmin' style='width: $widthinput;' maxlength='3' /> -
		  <input name='nummembersmax' style='width: $widthinput;' maxlength='3' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Combat Average:</td>
        <td style='width: 300px;'>
          <input name='cmbavgmin' style='width: $widthinput;' maxlength='3' /> -
		  <input name='cmbavgmax' style='width: $widthinput;' maxlength='3' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Hitpoints Average:</td>
        <td style='width: 300px;'>
          <input name='hpavgmin' style='width: $widthinput;' maxlength='2' /> -
		  <input name='hpavgmax' style='width: $widthinput;' maxlength='2' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Magic Average:</td>
        <td style='width: 300px;'>
          <input name='magicavgmin' style='width: $widthinput;' maxlength='2' /> -
		  <input name='magicavgmax' style='width: $widthinput;' maxlength='2' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Ranged Average:</td>
        <td style='width: 300px;'>
          <input name='rangedavgmin' style='width: $widthinput;' maxlength='2' /> -
		  <input name='rangedavgmax' style='width: $widthinput;' maxlength='2' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Overall Average:</td>
        <td style='width: 300px;'>
          <input name='overallavgmin' style='width: $widthinput;' maxlength='4' /> -
		  <input name='overallavgmax' style='width: $widthinput;' maxlength='4' />
        </td>
      </tr>
      <tr>
        <td style='width: 220px;'>Combat Style:</td>
        <td style='width: 300px;'>
		  <select name='combatType' style='width: $width;'>
		    <option value='p2p'"; if ($combatType == "p2p"){ echo " selected='selected'"; } echo ">P2P Combat</option>
			<option value='f2p'"; if ($combatType == "f2p"){ echo " selected='selected'"; } echo ">F2P Combat</option>
		  </select>
        </td>
      </tr>	  
      <tr>
        <td style='text-align: center;' colspan='2'>
          <input type='submit' value='Search' />&nbsp;
          <input type='reset' value='Reset' />
          <input type='hidden' value='true' name='search' />
        </td>
      </tr>
    </table>
  </div>
</form>
";
}
include_once ("../design/bottom.php");
?>