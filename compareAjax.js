var add = 1;
var usernames = new Array();
var usernameslength = 0;
var compareType = "";
var found = false;
var full = false;

function ajaxFunction(){
  var ajaxRequest;
  try {
    ajaxRequest = new XMLHttpRequest();
  } catch (e){
    try {
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        return false;
      }
    }
  }
  ajaxRequest.onreadystatechange = function(){
    var ajaxDisplay = document.getElementById('ajaxDiv');
    if(ajaxRequest.readyState == 4) {
      document.getElementById('ajax-loader').style.display = "none";
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
    } else {
      document.getElementById('ajax-loader').style.display = "inline";
	  ajaxDisplay.innerHTML = "";
 	}
  }
  var clansearch = document.getElementById('clansearch').value;
  var queryString = "?clansearch=" + clansearch;
  ajaxRequest.open("GET", "compareAjax.php" + queryString, true);
  ajaxRequest.send(null);

return false;
}

function compareAdd(username, clanname, numbermembers){
  found = false;
  full = false;
  for (a = 1; a <= 5; a++){
    if (usernames[a - 1] == username){
      found = true;
	  break;
	}
  }
  if (!found){
    for (a = 1; a <= 5; a++){
      if (usernames[a - 1] == null){
        usernames[a - 1] = username;
        document.getElementById("username" + a + "a").innerHTML = "<input type='hidden' id='usernamenumber" + a + "' value='" + username + "' /><input type='button' style='background-color: #000000; cursor: pointer;' onclick=\"compareRemove('" + username + "', '" + clanname + "', '" + numbermembers + "');\" value='Remove'/>";
        document.getElementById("username" + a + "b").innerHTML = "<a href='ml.php?clan=" + username + "'>" + clanname + "</a>";
        document.getElementById("username" + a + "c").innerHTML = numbermembers;
        break;
      }
      if (a == 5){
	    full = true;	
	  }
    }
  }
  if (full){
    alert("5 memberlists already added. Remove 1 to add another.");	  
  }
}

function compareRemove(username, clanname, numbermembers){
  for (a = 1; a <= 5; a++){
	if (usernames[a - 1] == username){
      usernames[a - 1] = null;
      document.getElementById("username" + a + "a").innerHTML = "<input id=\"usernamenumber" + a + "\" value=\"\" type=\"hidden\">";
      document.getElementById("username" + a + "b").innerHTML = "&nbsp;";
      document.getElementById("username" + a + "c").innerHTML = "&nbsp;";
      break;
    }
  }
}

function compareSubmit(){
  if (document.forms["compareForm"].compareType[1].checked){
    compareType = "all";
  } else {
    compareType = "combat";
  }
  document.forms["compareForm"].action = "compare.php?username1=" + document.forms["compareForm"].usernamenumber1.value + "&username2=" + document.forms["compareForm"].usernamenumber2.value + "&username3=" + document.forms["compareForm"].usernamenumber3.value + "&username4=" + document.forms["compareForm"].usernamenumber4.value + "&username5=" + document.forms["compareForm"].usernamenumber5.value + "&compare=true&compareType=" + compareType;
  document.forms["compareForm"].submit();
}
