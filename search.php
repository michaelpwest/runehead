<?
include_once ("../design/top.php");
$searchType = @mysql_escape_string($_REQUEST["searchtype"]);
if ($searchType != "partial" && $searchType != "exact"){
	$searchType = "exact";
}
$searchQuery = cleanName(@mysql_escape_string($_REQUEST["search"]));
$mltype = @mysql_escape_string($_REQUEST["mltype"]);
$limit = @mysql_escape_string($_REQUEST['limit']);

if (isset($_REQUEST["combatType"])){
	$combatType = @mysql_escape_string($_REQUEST["combatType"]);
} else {
	$combatType = "P2P";
}

if ($searchType == "partial" && strlen($searchQuery) < 3){
echo "
  <div class='main'>
    <h1>Clan Member Search</h1>  
    <p>Partial Searches need to be at least <b>3</b> characters long.</p>
    <p style='text-align: center;'><a href='search.php'>Search Again</a></p>	
  </div>
";
} else {
	if ($searchQuery != ""){
		$sql = "SELECT U.USERNAME, U.CLANNAME, M.RSN, M.RANK, M.OVERALL, M.COMBAT, M.F2PCOMBAT, M.HITPOINTS, M.MAGIC, M.RANGED
				FROM MEMBERS M, USERS U
				WHERE U.USERNAME = M.USERNAME
				AND U.ACTIVE = '1'
				AND U.VALIDATED = '1'";
		if ($mltype == 1){
			$sql .= " AND U.CLANTYPE = 'clan'";
		} else if ($mltype == 2){
			$sql .= " AND U.CLANTYPE = 'non-clan'";
		}
		if ($searchType == "partial"){
			$sql .= " AND M.RSN LIKE '%$searchQuery%'";
		} else if ($searchType == "exact"){
			$sql .= " AND M.RSN = '$searchQuery'";
		}
		$sql .= " ORDER BY TRIM(M.RSN), U.CLANNAME";
		if (isset($limit) && is_numeric($limit)) {
			$sql .= " LIMIT " . $limit;
		}
		$result = @mysql_query($sql);
		$size = @mysql_affected_rows();
		if ($size > 0){
echo "
  <div class='main'>
    <h1>Clan Member Search</h1> 
";		
			if ($size == 1){
				echo "<p>The <b>$searchType</b> search <b>$searchQuery</b> returned <b>$size</b> result:</p>";
  			} else {
				echo "<p>The <b>$searchType</b> search <b>$searchQuery</b> returned <b>$size</b> results:</p>";
			}
echo "
    <form action='search.php' method='post' style='display: inline;'>
	  <p>
        Combat:
        <select name='combatType' style='width: 115px;' onchange='submit();'>
          <option value='P2P'"; if ($combatType == "P2P"){ echo "selected='selected'"; } echo ">P2P Combat</option>
          <option value='F2P'"; if ($combatType == "F2P"){ echo "selected='selected'"; } echo ">F2P Combat</option>
        </select>
	    <input type='hidden' name='searchType' value='$searchType' />
	    <input type='hidden' name='search' value='$searchQuery' />
	    <input type='hidden' name='mltype' value='$mltype' />
	    <input type='hidden' name='limit' value='$limit' />
	    <input type='submit' value='Show' />
      </p>
    </form>
    <div style='max-height: 400px; overflow: auto; overflow-x: hidden;'>
      <table class='contenttable' border='1'>
        <tr class='header'>
          <td style='width: 24%;'><b>RSN</b></td>
          <td style='width: 20%;' class='tableborder'><b>Memberlist</b></td>
          <td style='width: 20%;' class='tableborder'><b>Rank</b></td>
          <td style='width: 12%;' class='tableborder'><b>$combatType Cmb</b></td>";
echo "
          <td style='width: 12%;' class='tableborder'><b>HP</b></td>
          <td style='width: 12%;' class='tableborder'><b>Overall</b></td>
        </tr>
";
			while ($row = @mysql_fetch_array($result)){
				$username = $row["USERNAME"];
				$clanname = $row["CLANNAME"];
				$rsn = $row["RSN"];
				$rank = strtoupper($row["RANK"]);
				$sql = "SELECT $rank
						FROM RANKS
						WHERE USERNAME = '$username'";
				$rankResult = @mysql_query($sql);
				$rankRow = @mysql_fetch_array($rankResult);
				$rank = $rankRow[$rank];				
				$overall = number_format($row["OVERALL"]);
				if ($combatType == "F2P"){
					$combat = $row["F2PCOMBAT"];
				} else {
					$combat = $row["COMBAT"];				
				}
				$hitpoints = levelXP($row["HITPOINTS"]);
				$magic = levelXP($row["MAGIC"]);
				$ranged = levelXP($row["RANGED"]);
echo "
        <tr class='hovertr'>
          <td class='tableborder'><b>$rsn</b></td>
          <td class='tableborder'><a href='ml.php?clan=$username' title='View $clanname Memberlist'>$clanname</a></td>
          <td class='tableborder'>$rank</td>
          <td class='tableborder'>$combat</td>
          <td class='tableborder'>$hitpoints</td> 	  
          <td class='tableborder'>$overall</td>	  
        </tr>
";
}
echo "
      </table>
    </div>
    <p style='text-align: center;'><a href='search.php'>Search Again</a></p>	
  </div>
";
		} else {
echo "
  <div class='main'>
    <h1>Clan Member Search</h1>  
    <p>No results were found for the <b>$searchType</b> search <b>$searchQuery</b></p>
    <p style='text-align: center;'><a href='search.php'>Search Again</a></p>	
  </div>
";
		}
	} else {
echo "
  <form action='search.php' method='post' style='display: inline;'>
    <div class='main'>
      <h1>Clan Member Search</h1>  
	  <div class='justify'>
	    <p>Find whether a RuneScape name exists on a RuneHead Hiscores Catalogue Memberlist.<br />
	    To search enter a RuneScape Name, select whether you want the exact name to be found or
	    whether results containing that name at all will also be returned. Next click the \"Search\"
	    button to perform the search.<br /><br />
  	    <span class='success'>Note: Partial searches need to be at least 3 characters long.</span></p>
	  </div>
      <table style='width: 250px; margin: 5px auto;' border='0' cellpadding='2'>
        <tr style='text-align: center;'>
          <td colspan='2'>
            <input maxlength='12' size='16' name='search' style='width: 150px;' />&nbsp;
            <input type='submit' value='Search' />
          </td>
        </tr>
        <tr style='text-align: center;'>
          <td>
            <label for='exact2'>Exact</label>
            <input type='radio' name='searchtype' id='exact2' value='exact' class='exact' checked='checked' />
          </td>
          <td>
            <label for='partial2'>Partial</label>
            <input type='radio' name='searchtype' id='partial2' value='partial' class='partial' />
          </td>
        </tr>
		<tr>
		  <td style='text-align: right;'>Search In:</td>
          <td style='text-align: center;'>  
            <select name='mltype' style='width: 115px;'>
			  <option value='0'"; if ($mltype == "0"){ echo "selected='selected'"; } echo ">All</option>
			  <option value='1'"; if ($mltype == "1"){ echo "selected='selected'"; } echo ">Clans</option>
			  <option value='2'"; if ($mltype == "2"){ echo "selected='selected'"; } echo ">Non-Clans</option>
			</select>
		  </td>
		</tr>        
		<tr>
		  <td style='text-align: right;'>Combat:</td>
          <td style='text-align: center;'>
		    <select name='combatType' style='width: 115px;'>
			  <option value='P2P'"; if ($combatType == "P2P"){ echo "selected='selected'"; } echo ">P2P Combat</option>
			  <option value='F2P'"; if ($combatType == "F2P"){ echo "selected='selected'"; } echo ">F2P Combat</option>
			</select>
		  </td>
		</tr>
      </table>
	</div>
  </form>
";
	}
}
include_once ("../design/bottom.php");
?>