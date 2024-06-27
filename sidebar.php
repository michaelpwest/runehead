<!-- START Right Column -->
<div id="right">
  <div class="nav">  
    <h3>Navigation</h3>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="register.php">Register a Memberlist</a></li>
      <li><a href="about.php">About</a></li>
    </ul>
  </div>
  <div class="nav">  
    <h3>Memberlists</h3>
    <ul>
      <li><a href="clandb.php">Clan Database</a></li>
      <li><a href="nonclandb.php">Non-Clan Database</a></li>
      <li><a href="minigames.php">Minigames Database</a></li>
      <li><a href="clansearch.php">Memberlist Search</a></li>
      <li><a href="compare.php">Memberlist Compare</a></li>
      <li><a href="displayml.php">Memberlist Embedding</a></li>
      <li><a href="http://www.draynor.net/clan_signatures.php">Clan Signatures</a></li>
    </ul>
  </div>  
  <div class="nav">
    <h3>Support</h3>
    <ul>
      <li><a href="admincphelp.php">Admin CP Guide</a></li>
	  <li><a href="guidelines.php">Guidelines</a></li>
	  <li><a href="faq.php">FAQ</a></li>
      <li><a href="/forum/index.php?showforum=3">Support Forum</a></li>
      <li><a href="contactus.php">Contact Us</a></li>	  
    </ul>
  </div>  
  <div class="right_box">
    <h3><a href="search.php">Clan Member Search</a></h3>
    <form action="search.php" method="post" style="display: inline;">
      <table style="width: 196px; margin: 5px auto;" border="0" cellpadding="2">
        <tr style="text-align: center;">
          <td colspan="2">
            <input maxlength="12" size="16" name="search" style="width: 100px;" />&nbsp;
            <input type="submit" value="Search" />
          </td>
        </tr>
        <tr style="text-align: center;">
          <td>
            <label for="exact">Exact</label>
            <input type="radio" name="searchtype" id="exact" value="exact" class="exact" checked="checked" />
          </td>
          <td>
            <label for="partial">Partial</label>
            <input type="radio" name="searchtype" id="partial" value="partial" class="partial" />
          </td>
        </tr>
		<tr>
		  <td style="text-align: right;">Search In:</td>
          <td style="text-align: center;">  
            <select name="mltype" style="text-align: left; width: 100px;">
			  <option value="0">All</option>
			  <option value="1">Clans</option>
			  <option value="2">Non-Clans</option>
			</select>
		  </td>
		</tr>        
		<tr>
		  <td style="text-align: right;">Combat:</td>
          <td style="text-align: center;">
		    <select name="combatType" style="text-align: left; width: 100px;">
			  <option value="p2p">P2P Combat</option>
			  <option value="f2p">F2P Combat</option>
			</select>
		  </td>
		</tr>
      </table>
    </form>
  </div>
  <div class="right_box">
    <h3><a href="admin.php">Admin Control Panel</a></h3>
	<? include ("login.php"); ?>
  </div>    
</div>
<!-- END Right column -->
