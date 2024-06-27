<?
include_once ("../design/top.php");

$auth->checkLogin();
$user = $auth->getUser();
$log = "";
if (isset($_REQUEST["log"])){
	$log = @mysql_escape_string($_REQUEST["log"]);
}
if ($auth->checkAuth() === "moderator"){
echo "
<div class='main' style='text-align: center; font-size: 11px;'>
  <p><a href='managecensor.php'>Censor</a> |
  <a href='manageimages.php'>Images</a> |
  <a href='managemembers.php'>Removals</a> |
  <a href='managenamechanges.php'>Name Changes</a> |  
  <a href='managemailpassword.php'>Passwords</a> |
  <a href='managereports.php'>Reports</a> |
  <a href='managerequests.php'>Requests</a> |
  <a href='manageusers.php'>Manage Users</a> |
  <a href='manageregister.php'>Validation</a></p>
</div>
<script type='text/javascript'>
function confirmDelete() {
  var agree=confirm('Are you sure you wish to delete this entry?');
  if (agree){
    return true;
  } else {
    return false;
  }
}
function confirmImage() {
  var agree = confirm('Are you sure you want to remove the selected image?');
  if (agree){
    return true;
  } else {
    return false;
  }
}
function openimage(imagename) {
  window.open('banners/' + imagename, '', 'status = 1, resizable = 1, scrollbars = 1');
}
</script>
";
	if (isset($_REQUEST["button"])){
		$button = $_REQUEST["button"];
	} else {
		$button = "";
	}
	if (isset($_REQUEST["showActive"])){
		$showActive = $_REQUEST["showActive"];
	} else {
		$showActive = "All";
	}
	if (isset($_REQUEST["sort"])){
		$sort = $_REQUEST["sort"];
	} else {
		$sort = "username";
	}
	if (isset($_REQUEST["sortDirection"])){
		$sortDirection = $_REQUEST["sortDirection"];
	} else {
		$sortDirection = "asc";
	}
	$search = @mysql_escape_string($_REQUEST["search"]);
	$searchsize = 0;	
	if ($button == "Find"){
		$sql = "SELECT USERNAME, CLANNAME, ACTIVE, VALIDATED, MODERATOR, CATEGORY, WEBSITE, LOGINTIME, LOGINTIME, REGISTRATIONTIME, EMAIL, REGISTRATIONEMAIL
				FROM USERS";
	}
	if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Email" && $button == "Find"){
		$sql .= " WHERE EMAIL = '$search' OR REGISTRATIONEMAIL = '$search'";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Website" && $button == "Find"){
		$sql .= " WHERE WEBSITE LIKE '%$search%'";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Username" && $button == "Find"){
		$sql .= " WHERE USERNAME = '$search'";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Clanname" && $button == "Find"){
		$sql .= " WHERE CLANNAME LIKE '%$search%'";
	}
	if ($button == "Find"){
		$searchresult = @mysql_query($sql);
		$searchsize = @mysql_num_rows($searchresult);
		$alluserssize = @mysql_num_rows($searchresult);
	}	
	$sql = "SELECT RSN
			FROM MEMBERS M, USERS U
			WHERE U.USERNAME = M.USERNAME";
	if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Email" && $button == "Find"){
		$sql .= " AND (U.EMAIL = '$search' OR U.REGISTRATIONEMAIL = '$search')";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Website" && $button == "Find"){
		$sql .= " AND U.WEBSITE LIKE '%$search%'";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Username" && $button == "Find"){
		$sql .= " AND U.USERNAME = '$search'";
	} else if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Clanname" && $button == "Find"){
		$sql .= " AND U.CLANNAME LIKE '%$search%'";
	}
	$allmembers = @mysql_query($sql);
	$memberssize = @mysql_num_rows($allmembers);
	if (isset($_REQUEST["clanImageRemove"]) && $_REQUEST["clanImageRemove"] == "Remove"){
		$username2 = @mysql_escape_string($_REQUEST["username2"]);
		$sql = "SELECT CLANIMAGE
				FROM USERS
				WHERE USERNAME = '$username2'";
		$imageResult = mysql_query($sql);
		$imageRow = mysql_fetch_array($imageResult);
		if ($imageRow["CLANIMAGE"] != ""){
			unlink("banners/" . $imageRow["CLANIMAGE"]);
		}
		$sql = "UPDATE USERS SET
				CLANIMAGE = ''
				WHERE USERNAME = '$username2'";
		@mysql_query($sql);				
	}
	if (isset($_REQUEST["clanImageRequestRemove"]) && $_REQUEST["clanImageRequestRemove"] == "Remove"){
		$username2 = @mysql_escape_string($_REQUEST["username2"]);
		$sql = "SELECT REQUESTEDIMAGE
				FROM USERS
				WHERE USERNAME = '$username2'";
		$imageResult = mysql_query($sql);
		$imageRow = mysql_fetch_array($imageResult);
		if ($imageRow["REQUESTEDIMAGE"] != ""){
			unlink("banners/" . $imageRow["REQUESTEDIMAGE"]);	
		}
		$sql = "UPDATE USERS SET
				REQUESTEDIMAGE = ''
				WHERE USERNAME = '$username2'";
		@mysql_query($sql);
	}
	if (isset($_REQUEST["userlog"]) && $_REQUEST["userlog"] == "Edit User"){
		$username1 = @mysql_escape_string($_REQUEST["username1"]);
		$username2 = @mysql_escape_string($_REQUEST["username2"]);
		$password = @mysql_escape_string($_REQUEST["password"]);
		$clanname = @mysql_escape_string($_REQUEST["clanname"]);
		$active = @mysql_escape_string($_REQUEST["active"]);
		$validated = @mysql_escape_string($_REQUEST["validated"]);
		$moderator = @mysql_escape_string($_REQUEST["moderator"]);
		$reported = @mysql_escape_string($_REQUEST["reported"]);
		$clanimage = @mysql_escape_string($_REQUEST["clanimage"]);
		$clanimagerequest = @mysql_escape_string($_REQUEST["clanimagerequest"]);
		$website = @mysql_escape_string($_REQUEST["website"]);
		$email = @mysql_escape_string($_REQUEST["email"]);
		$category = @mysql_escape_string($_REQUEST["category"]);
		$usernametaken = false;
		$emailtaken = false;
		if ($username1 != $username2){
			$sql = "SELECT USERNAME FROM USERS
					WHERE USERNAME = '$username1'
					AND USERNAME != '$username2'";
			$result = @mysql_query($sql);
			if (@mysql_num_rows($result) > 0){
				$usernametaken = true;
			}
			if ($usernametaken == false){
				$sql = "UPDATE AVERAGES SET
						USERNAME = '$username1'
						WHERE USERNAME = '$username2'";
				@mysql_query($sql);
				$sql = "UPDATE MEMBERS SET
						USERNAME = '$username1'
						WHERE USERNAME = '$username2'";
				@mysql_query($sql);
				$sql = "UPDATE RANKS SET
						USERNAME = '$username1'
						WHERE USERNAME = '$username2'";
				@mysql_query($sql);	
			}
		}
		$sql = "SELECT EMAIL FROM USERS
				WHERE EMAIL = '$email'
				AND USERNAME != '$username2'";
		$result = @mysql_query($sql);
		if (@mysql_num_rows($result) > 0){
			$emailtaken = true;
		}
		if ($usernametaken == false && $emailtaken == false && $category != 0){
			if ($category == 1){
				$clantype = "clan";
			} else {
				$clantype = "non-clan";
			}
			$sql = "UPDATE USERS SET
					CLANNAME = '$clanname',
					ACTIVE = '$active',
					VALIDATED = '$validated',
					MODERATOR = '$moderator',
					REPORTED = '$reported',
					WEBSITE = '$website',
					EMAIL = '$email',
					USERNAME = '$username1',
					CLANTYPE = '$clantype',
					CATEGORY = '$category'";
			if ($password != ""){
				$password = md5($password);
				$sql .= ", PASSWORD = '$password'";
			}
			$sql .= " WHERE USERNAME = '$username2'";
			@mysql_query($sql);
			
			$sql = "SELECT REQUESTEDCATEGORY, REQUESTEDCLANNAME
					FROM USERS
					WHERE USERNAME = '$username2'";
			$detailsResult = @mysql_query($sql);
			$detailsRow = @mysql_fetch_array($detailsResult);
			if ($clanname == $detailsRow["REQUESTEDCLANNAME"]){
				$sql = "UPDATE USERS SET
						REQUESTEDCLANNAME = ''
						WHERE USERNAME = '$username2'";
				@mysql_query($sql);
			}
			if ($category == $detailsRow["REQUESTEDCATEGORY"]){
				$sql = "UPDATE USERS SET			
						REQUESTEDCATEGORY = '0'
						WHERE USERNAME = '$username2'";
				@mysql_query($sql);
			}
		} else if ($usernametaken){
			echo "<div class='main'><p>Username is in already use.</p></div>";
		} else if ($emailtaken){
			echo "<div class='main'><p>Email is in already use.</p></div>";
		}
	}

	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "edit"){
		$name = @mysql_escape_string($_REQUEST["name"]);
		if (isset($_REQUEST["username2"]) && $_REQUEST["username2"]){
			$name = $_REQUEST["username1"];
		}
		$sql = "SELECT USERNAME, CLANNAME, ACTIVE, VALIDATED, MODERATOR, REPORTED, CLANIMAGE, REQUESTEDIMAGE, WEBSITE, EMAIL, LOGINTIME, CATEGORY
				FROM USERS
				WHERE USERNAME = '$name'";
		$results = @mysql_query($sql);
		$row = @mysql_fetch_array($results);
		$username1 = $row["USERNAME"];
		$password = "";
		$password1 = generatePassword();
		$clanname = $row["CLANNAME"];
		$active = $row["ACTIVE"];
		$validated = $row["VALIDATED"];
		$moderator = $row["MODERATOR"];
		$reported = $row["REPORTED"];
		$clanimage = $row["CLANIMAGE"];
		$clanimagerequest = $row["REQUESTEDIMAGE"];
		$website = $row["WEBSITE"];
		$logintime = flipDate($row["LOGINTIME"], false);
		$email = $row["EMAIL"];
		$category = $row["CATEGORY"];
echo "
<div class='main'>
  <form action='' method='post'>
    <h1>Edit User $username1</h1>
    <table>
      <tr>
        <td style='text-align: right; width: 40%;'>Username:</td>
        <td style='text-align: left; width: 60%;'>
		  <input type='hidden' name='username2' value='$username1' />
		  <input name='username1' style='width: 200px;' value='$username1' maxlength='12' />
		  <a href='javascript:void(0);' onclick='window.open(\"ml.php?clan=$username1\");'>View</a>
		</td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Password:</td>
        <td style='text-align: left; width: 60%;'>
		  <input id='password' name='password' style='width: 200px;' value='$password' maxlength='50' />
		  <a href='javascript:void(0);' onclick='generate();'>Generate</a>
		</td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Clan Name:</td>
        <td style='text-align: left; width: 60%;'><input name='clanname' style='width: 200px;' value='$clanname' maxlength='50' /></td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Status:</td>
        <td style='text-align: left; width: 60%;'>
		  <select name='active' style='width: 200px;'>
		    <option value='0'"; if ($active == 0){ echo " selected='selected'"; } echo ">In-Active</option>
		    <option value='1'"; if ($active == 1){ echo " selected='selected'"; } echo ">Active</option>
		    <option value='2'"; if ($active == 2){ echo " selected='selected'"; } echo ">Banned</option>
		  </select>
		</td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Validated:</td>
        <td style='text-align: left; width: 60%;'>
		  <select name='validated' style='width: 200px;'>
		    <option value='0'"; if ($validated == 0){ echo " selected='selected'"; } echo ">No</option>
		    <option value='1'"; if ($validated == 1){ echo " selected='selected'"; } echo ">Yes</option>
		    <option value='2'"; if ($validated == 2){ echo " selected='selected'"; } echo ">Declined</option>			
		  </select>
		</td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Moderator:</td>
        <td style='text-align: left; width: 60%;'>
		  <select name='moderator' style='width: 200px;'>
		    <option value='0'"; if ($moderator == 0){ echo " selected='selected'"; } echo ">No</option>
		    <option value='1'"; if ($moderator == 1){ echo " selected='selected'"; } echo ">Yes</option>
		  </select>
		</td>
      </tr>	  
	  <tr>
        <td style='text-align: right; width: 40%;'>Reported:</td>
        <td style='text-align: left; width: 60%;'><input name='reported' style='width: 200px;' value='$reported' maxlength='1' /></td>
      </tr>
";
if ($clanimage != ""){
echo "
      <tr>
        <td style='text-align: right; width: 40%;'>Clan Image:</td>
        <td style='text-align: left; width: 60%; padding-left: 45px;'>
		  <input type='button' onclick='openimage(\"$clanimage\")' value='Here' />
		  <input type='submit' name='clanImageRemove' onclick='return confirmImage();' value='Remove' />
		</td>
      </tr>	  
";
}
if ($clanimagerequest != ""){
echo "
      <tr>
        <td style='text-align: right; width: 40%;'>Clan Image Request:</td>
        <td style='text-align: left; width: 60%; padding-left: 45px;'>
		  <input type='button' onclick='openimage(\"$clanimagerequest\")' value='Here' />
		  <input type='submit' name='clanImageRequestRemove' onclick='return confirmImage();' value='Remove' />
		</td>
      </tr>	    
";
}
echo "
      <tr>
        <td style='text-align: right; width: 40%;'>Website:</td>
        <td style='text-align: left; width: 60%;'><input name='website' style='width: 200px;' value='$website' /></td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Email:</td>
        <td style='text-align: left; width: 60%;'><input name='email' style='width: 200px;' value='$email' /></td>
      </tr>
      <tr>
        <td style='text-align: right; width: 40%;'>Category:</td>
        <td style='text-align: left; width: 60%;'>
		  <select name='category' style='width: 200px;'>
		    <option value='0'>Not Selected</option>
";
		for ($a = 1; $a < sizeof($categories); $a++){
echo "
            <option value='$a'"; if ($category == $a){ echo " selected='selected'"; } echo ">$categories[$a]</option>
";
		}		
echo "
		  </select>
		</td>
      </tr>
      <tr style='text-align: center;'>
        <td colspan='2'><input type='submit' name='userlog' value='Edit User' /></td>
      </tr>
    </table>
  </form>
</div>
<script type='text/javascript'>
  function generate(){
    document.getElementById('password').value = '$password1';
  }
</script>
";
	}

	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "delete"){
		$name = @mysql_escape_string($_REQUEST["name"]);
		if ($name != ""){
			$sql = "SELECT CLANIMAGE, REQUESTEDIMAGE
					FROM USERS
					WHERE USERNAME = '$name'";
			$imageResult = mysql_query($sql);
			$imageRow = mysql_fetch_array($imageResult);
			if ($imageRow["CLANIMAGE"] != ""){
				unlink("banners/" . $imageRow["CLANIMAGE"]);
			}
			if ($imageRow["REQUESTEDIMAGE"] != ""){
				unlink("banners/" . $imageRow["REQUESTEDIMAGE"]);
			}			
			$sql = "DELETE FROM AVERAGES
					WHERE USERNAME = '$name'";
			@mysql_query($sql);
			$sql = "DELETE FROM MEMBERS
					WHERE USERNAME = '$name'";
			@mysql_query($sql);
			$sql = "DELETE FROM RANKS
					WHERE USERNAME = '$name'";
			@mysql_query($sql);
			$sql = "DELETE FROM USERS
					WHERE USERNAME = '$name'";
			@mysql_query($sql);
		}
	}
echo "
<div class='main'>
  <form action='' method='post'>
    <h1>Search</h1>
    <p style='text-align: center;'>
      <select name='searchselect'>
        <option value='Username'"; if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Username"){ echo " selected='selected'"; } echo ">Username</option>			  
        <option value='Email'"; if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Email"){ echo " selected='selected'"; } echo ">Email</option>
        <option value='Website'"; if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Website"){ echo " selected='selected'"; } echo ">Website</option>
		<option value='Clanname'"; if (isset($_REQUEST["searchselect"]) && $_REQUEST["searchselect"] == "Clanname"){ echo " selected='selected'"; } echo ">Clan Name</option>
      </select>
      <input name='search' value='$search' />
	  <input name='button' type='submit' value='Find' />
    </p>
    <h1>Show All</h1>
    <table style='width: 70%;'>
      <tr style='text-align: center;'>
        <td class='tableborder'><b>Type</b></td>
        <td class='tableborder'><b>Sort By</b></td>
        <td class='tableborder'><b>Direction</b></td>
		<td class='tableborder'>&nbsp;</td>
      </tr>
	  <tr style='text-align: center;'>
        <td class='tableborder'>
	      <select name='showActive' style='width: 125px;'>
            <option value='all'"; if ($showActive == "all"){ echo " selected='selected'"; } echo ">All</option>
            <option value='1'"; if ($showActive == "1"){ echo " selected='selected'"; } echo ">Active</option>			  
            <option value='2'"; if ($showActive == "2"){ echo " selected='selected'"; } echo ">Banned</option>
		    <option value='declined'"; if ($showActive == "declined"){ echo " selected='selected'"; } echo ">Declined</option>		
            <option value='0'"; if ($showActive == "0"){ echo " selected='selected'"; } echo ">In-Active</option>
            <option value='imageactive'"; if ($showActive == "imageactive"){ echo " selected='selected'"; } echo ">Banner Set</option>
            <option value='image'"; if ($showActive == "image"){ echo " selected='selected'"; } echo ">Banned with banner</option>
            <option value='autoupdate'"; if ($showActive == "autoupdate"){ echo " selected='selected'"; } echo ">Autoupdate On</option>
            <option value='nocategory'"; if ($showActive == "nocategory"){ echo " selected='selected'"; } echo ">No Category</option>		
          </select>
	    </td>
        <td class='tableborder'>		  
          <select name='sort' style='width: 125px;'>
            <option value='username'"; if ($sort == "username"){ echo " selected='selected'"; } echo ">Username</option>			  
            <option value='logintime'"; if ($sort == "logintime"){ echo " selected='selected'"; } echo ">Login Time</option>
		    <option value='logintime0'"; if ($sort == "logintime0"){ echo " selected='selected'"; } echo ">Login Time (Not 0)</option>
            <option value='registrationtime'"; if ($sort == "registrationtime"){ echo " selected='selected'"; } echo ">Create Time</option>		
          </select>	
        </td>
        <td class='tableborder'>
		  <select name='sortDirection' style='width: 125px;'>
            <option value='asc'"; if ($sortDirection == "asc"){ echo " selected='selected'"; } echo ">Ascending</option>			  
            <option value='desc'"; if ($sortDirection == "desc"){ echo " selected='selected'"; } echo ">Descending</option>
          </select>		    
	    </td>
		<td class='tableborder'>
          <input name='button' type='submit' value='Display' />
	    </td>
      </tr>
    </table>
  </form>
</div>
";
	if ($searchsize > 0){
echo "
<div class='main'>
  <h1>Manage Users</h1>
  <p><b>" . number_format($alluserssize) . "</b> accounts found with <b>" . number_format($memberssize) . "</b> members</p>
  <table class='contenttable' border='1'>
    <tr class='header'>
      <td style='width: 6%;' class='tableborder'><b>Edit</b></td>
      <td style='width: 16%;' class='tableborder'><b>Username</b></td>
      <td style='width: 6%;' class='tableborder'><b>Active</b></td>
      <td style='width: 6%;' class='tableborder'><b>Valid</b></td>
      <td style='width: 12%;' class='tableborder'><b>Category</b></td>
      <td style='width: 16%;' class='tableborder'><b>Last Login</b></td>
      <td style='width: 6%;' class='tableborder'><b>Site</b></td>
      <td style='width: 26%;' class='tableborder'><b>Email</b></td>
      <td style='width: 6%;' class='tableborder'><b>Delete</b></td>
    </tr>
";
		while ($row = @mysql_fetch_array($searchresult)){
			$username1 = $row["USERNAME"];
			$clanname = $row["CLANNAME"];
			if ($row["ACTIVE"] == 2){
				$active = "Banned";
			} else if ($row["ACTIVE"] == 1){
				$active = "Active";
			} else {
				$active = "In-Active";
			}
			if ($row["VALIDATED"] == 2){
				$validated = "Declined";
			} else if ($row["VALIDATED"] == 1){
				$validated = "Yes";
			} else {
				$validated = "No";
			}
			$moderator = $row["MODERATOR"];
			$category = $row["CATEGORY"];
			$website = $row["WEBSITE"];
			$logintime = flipDate($row["LOGINTIME"]);
			$registrationtime = flipDate($row["REGISTRATIONTIME"]);
			$email = $row["EMAIL"];
			$email2 = substr($email,0,25);
			$registrationemail = $row["REGISTRATIONEMAIL"];				
echo "
    <tr class='hovertr' style='font-size: 11px;'>
      <td class='tableborder'><a href='?type=edit&amp;name=$username1'>Edit</a></td>
      <td class='tableborder'><a href='ml.php?clan=$username1' title='$clanname'>$username1</a></td>
      <td class='tableborder'>$active</td>
      <td class='tableborder'>$validated</td>
      <td class='tableborder'>$categories[$category]</td>
      <td class='tableborder' title='Registration Date: $registrationtime'>$logintime</td>
      <td class='tableborder'><a href='$website' title='$website'>Here</a></td>
      <td class='tableborder' title='Registration Email: $registrationemail'>$email2</td>
      <td class='tableborder'><a href='?type=delete&amp;name=$username1' onclick='return confirmDelete();'>Delete</a></td>
    </tr>
";
		}
echo "
  </table>
</div>
";
	}
	if ($button == "Display"){
		$sql = "SELECT USERNAME, ACTIVE, VALIDATED, MODERATOR, CATEGORY, WEBSITE, LOGINTIME, LOGINTIME, REGISTRATIONTIME, EMAIL, REGISTRATIONEMAIL
				FROM USERS
				WHERE 1";
		if ($showActive == "autoupdate"){
			$sql .=	" AND ACTIVE = '1'
			          AND AUTOUPDATE = '1'";
		} else if ($showActive == "imageactive"){
			$sql .=	" AND CLANIMAGE != ''";
		} else if ($showActive == "image"){
			$sql .=	" AND ACTIVE = '2'
					  AND CLANIMAGE != ''";
		} else if ($showActive == "nocategory"){
			$sql .=	" AND ACTIVE = '1'
					  AND CATEGORY = '0'";
		} else if ($showActive == "declined"){
			$sql .=	" AND VALIDATED = '2'";
		} else if ($showActive != "all"){
			$sql .=	" AND ACTIVE = '$showActive'";
		}
		if ($sort == "logintime0"){
			$sql .= " AND LOGINTIME != '0000-00-00 00:00:00'";
			$sort = "LOGINTIME";
		} else {
			$sort = strtoupper($sort);
		}
		if ($sortDirection == "desc"){
			$sql .=	" ORDER BY $sort DESC";
		} else {
			$sql .=	" ORDER BY $sort ASC";		
		}
		$allusers = @mysql_query($sql);
		$alluserssize = @mysql_num_rows($allusers);
		
		$sql = "SELECT RSN
				FROM MEMBERS M, USERS U
				WHERE U.USERNAME = M.USERNAME";
		if ($showActive == "autoupdate"){
			$sql .=	" AND U.ACTIVE = '1'
			          AND U.AUTOUPDATE = '1'";
		} else if ($showActive == "imageactive"){
			$sql .=	" AND U.CLANIMAGE != ''";
		} else if ($showActive == "image"){
			$sql .=	" AND U.ACTIVE = '2'
					  AND U.CLANIMAGE != ''";
		} else if ($showActive == "nocategory"){
			$sql .=	" AND U.ACTIVE = '1'
					  AND U.CATEGORY = '0'";		
		} else if ($showActive == "declined"){
			$sql .=	" AND U.VALIDATED = '2'";
		} else if ($showActive != "all"){
			$sql .=	" AND U.ACTIVE = '$showActive'";
		}
		$allmembers = @mysql_query($sql);
		$memberssize = @mysql_num_rows($allmembers);
echo "
<div class='main'>
  <h1>Manage Users</h1>
  <p><b>" . number_format($alluserssize) . "</b> accounts found with <b>" . number_format($memberssize) . "</b> members</p>
  <table class='contenttable' border='1'>
    <tr class='header'>
      <td style='width: 6%;' class='tableborder'><b>Edit</b></td>
      <td style='width: 16%;' class='tableborder'><b>Username</b></td>
      <td style='width: 6%;' class='tableborder'><b>Active</b></td>
	  <td style='width: 6%;' class='tableborder'><b>Valid</b></td>
      <td style='width: 12%;' class='tableborder'><b>Category</b></td>
      <td style='width: 16%;' class='tableborder'><b>Last Login</b></td>
      <td style='width: 6%;' class='tableborder'><b>Site</b></td>
      <td style='width: 26%;' class='tableborder'><b>Email</b></td>
      <td style='width: 6%;' class='tableborder'><b>Delete</b></td>
    </tr>
";
		$a = 0;		
		while ($row = @mysql_fetch_array($allusers)){
			$a++;
			$username1 = $row["USERNAME"];
			if ($row["ACTIVE"] == 2){
				$active = "Banned";
			} else if ($row["ACTIVE"] == 1){
				$active = "Active";
			} else {
				$active = "In-Active";
			}
			if ($row["VALIDATED"] == 2){
				$validated = "Declined";
			} else if ($row["VALIDATED"] == 1){
				$validated = "Yes";
			} else {
				$validated = "No";
			}
			$moderator = $row["MODERATOR"];
			$category = $row["CATEGORY"];
			$website = $row["WEBSITE"];
			$logintime = flipDate($row["LOGINTIME"], false);
			$registrationtime = flipDate($row["REGISTRATIONTIME"]);
			$email = $row["EMAIL"];
			$email2 = substr($email,0,25);
			$registrationemail = $row["REGISTRATIONEMAIL"];			
echo "
    <tr class='hovertr' style='font-size: 11px;'>
      <td class='tableborder'><a href='?type=edit&amp;name=$username1'>Edit</a></td>
      <td class='tableborder'><a href='ml.php?clan=$username1'>$a - $username1</a></td>
      <td class='tableborder'>$active</td>
	  <td class='tableborder'>$validated</td>
      <td class='tableborder'>$categories[$category]</td>
      <td class='tableborder' title='Registration Date: $registrationtime'>$logintime</td>
      <td class='tableborder'><a href='$website' title='$website'>Here</a></td>
      <td class='tableborder' title='Registration Email: $registrationemail'>$email2</td>
      <td class='tableborder'><a href='?type=delete&amp;name=$username1' onclick='return confirmDelete();'>Delete</a></td>
    </tr>
";
		}	
echo "
  </table>
</div>
";
	}
} else {
echo "
<div class='main'>
  <h1>Moderator Control Panel</h1>
  <form action='' method='post' style='display: inline;'>
    <table style='width: 196px; margin: 5px auto;' cellpadding='2'>
      <tr>
        <td>Username:</td><td><input name='loginusername' value='$user' maxlength='12' style='width: 150px;' /></td>
      </tr>
      <tr>
        <td>Password:</td><td><input name='loginpassword' type='password' style='width: 150px;' onkeypress='capsDetect(event);' onkeyup='capsToggle(event);' onblur='capsReset(event);' /></td>
      </tr>
  	  <tr style='height:0px;'>
	    <td colspan='2'><div id='capsWarningAdmin' style='display: none; color: #FFD700;'>Warning: Caps Lock On</div></td>
	  </tr>
";
if ($log == "Login"){
echo "
      <tr>
	    <td colspan='2' style='color: #FFD700;'>Login Incorrect.</td>
  	  </tr>
";
}
echo "
      <tr>
        <td colspan='2'><input type='submit' name='log' value='Login' /></td>
      </tr>
    </table>
  </form>
</div>
";
}
include ("../design/bottom.php");
?>