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
    if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('ajaxDiv');
      if (ajaxRequest.responseText.length > 2){
        ajaxDisplay.innerHTML = "Error in Registration:<br /><span style='color:#ffd700;'>" + ajaxRequest.responseText + "<br /></span>";
      } else {
        ajaxDisplay.innerHTML = "";
      }
    }
  }
  var requestedusername = document.getElementById('requestedusername').value;
  var requestedclanname = document.getElementById('requestedclanname').value;
  var requestedurl = document.getElementById('requestedurl').value;
  var requestedemail = document.getElementById('requestedemail').value;
  var queryString = "?requestedusername=" + requestedusername + "&requestedclanname=" + requestedclanname + "&requestedurl=" + requestedurl + "&requestedemail=" + requestedemail;
  ajaxRequest.open("GET", "registerajax.php" + queryString, true);
  ajaxRequest.send(null);
}