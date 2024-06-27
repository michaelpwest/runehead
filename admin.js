var admincp = new Array("clandetails", "colourdetails", "manageranks", "accountdetails", "addmembers", "editmembers", "claninfo", "currentmessage");

function admindisplay(display) {
  for (var a = 0; a < admincp.length; a++) {
    if (admincp[a] == display) {
      document.getElementById(admincp[a]).style.display = "block";
	  document.getElementById(admincp[a] + "Title").style.color = "#FFD700";
    } else {
      document.getElementById(admincp[a]).style.display = "none";
	  document.getElementById(admincp[a] + "Title").style.color = "#FFFFFF";
    }
  }
}

function addmember(){
  numnames = document.getElementById("rsname").value.split("\n").length;
  if (document.getElementById("rsname").value == ""){
	document.getElementById("rsnamesentered").innerHTML = "<span class='success'><b>0</b> names entered<br />of a max of <b>100</b></span>";
  } else if (numnames == 1){
	document.getElementById("rsnamesentered").innerHTML = "<span class='success'><b>" + numnames + "</b> name entered<br />of a max of <b>100</b></span>";
  } else if (numnames > 100){
    document.getElementById("rsnamesentered").innerHTML = "Names entered (<b>" + numnames + "</b>)<br />exceeds max of <b>100</b>";
  } else {
    document.getElementById("rsnamesentered").innerHTML = "<span class='success'><b>" + numnames + "</b> names entered<br />of a max of <b>100</b></span>";
  }
}

function editingname() {
  var count = 0;
  for (var a = 0; a < document.forms["editmembersForm"].elements['member[]'].length; a++) {
    var b = document.forms["editmembersForm"].elements['member[]'][a].selected;
    if (b == true) {
      count++;
    }
  }
  if (count > 1) {
    document.forms["editmembersForm"].rsname2.value = "";
    document.forms["editmembersForm"].rsname2.disabled = true;
  } else {
    rsname = document.forms["editmembersForm"].elements['member[]'].value;
    rsname = rsname.split("|");
    rsname = rsname[0];
    document.forms["editmembersForm"].rsname2.disabled = false;
    document.forms["editmembersForm"].rsname2.value = rsname;
  }
}

function editingrank() {
  clanrank = document.forms["editmembersForm"].member[document.forms["editmembersForm"].member.selectedIndex].value;
  clanrank = clanrank.split("|");
  clanrank = clanrank[1];
  document.forms["editmembersForm"].rank2.selectedIndex = clanrank;
}

function colours(id) {
  window.open('colours.php?id=' + id, '', 'status = 1, height = 320, width = 290, resizable = 1');
}

function admincphelp(id) {
  window.open('admincphelp.php?id=' + id, '', 'status = 1, height = 600, width = 800, resizable = 1, scrollbars = 1');
}

function guidelines() {
  window.open('guidelines.php', '', 'status = 1, height = 800, width = 800, resizable = 1, scrollbars = 1');
}

function openimage(imagename) {
  window.open('banners/' + imagename, '', 'status = 1, resizable = 1, scrollbars = 1');
}

function importFunction() {
  document.getElementById('importmembersfile2').value = document.getElementById('importmembersfile').value;
}

function clanBannerFunction() {
  document.getElementById('clanbannerfile2').value = document.getElementById('clanbannerfile').value;
}

function homeworldcheck(homeworld,limit) {
  if (homeworld > limit){
    document.forms["claninfoForm"].homeworld.value = limit;
  }
}

function confirmDelete() {
  var agree = confirm("Are you sure you want to remove the select member(s)?");
  if (agree){
    return true;
  } else {
    return false;
  }
}

function removeMsg(name){
  var agree = confirm("Are you sure you want to remove the selected message?");
  if (agree){
	return true;
  } else {
    return false;
  }
}

function removeMsg2(){
  var agree = confirm("Are you sure you want to remove your Clan / Group Banner?");
  if (agree){
	return true;
  } else {
    return false;
  }
}

function removeMsg3(){
  var agree = confirm("Are you sure you want to remove your Clan / Group Banner request?");
  if (agree){
	return true;
  } else {
    return false;
  }
}

function mlPreview(rank1colour) {
  document.getElementById("selectBox").style.backgroundColor = document.getElementById("headerbg").value;
  document.getElementById("selectBox").style.color = document.getElementById("headerfont").value;
  document.getElementById("selectBox").style.borderColor = document.getElementById("bordercolour").value;

  document.getElementById("selectBox2").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("selectBox2").style.color = document.getElementById("headerfont").value;
  document.getElementById("selectBox2").style.backgroundColor = document.getElementById("headerbg").value;

  document.getElementById("submitButton").style.backgroundColor = document.getElementById("headerbg").value;
  document.getElementById("submitButton").style.color = document.getElementById("headerfont").value;
  document.getElementById("submitButton").style.borderColor = document.getElementById("bordercolour").value;
  
  document.getElementById("previewHeader").style.color = document.getElementById("headerfont").value;
  document.getElementById("previewHeader").style.backgroundColor = document.getElementById("headerbg").value;

  document.getElementById("previewHeader2").style.backgroundColor = document.getElementById("headerbg").value;
  document.getElementById("previewHeader2").style.color = document.getElementById("headerfont").value;
  
  document.getElementById("previewTable1").style.backgroundColor = document.getElementById("bgcolour").value;  
  document.getElementById("previewTable2").style.borderColor = document.getElementById("bordercolour").value;  
  document.getElementById("previewHeaderDisplay").style.borderColor = document.getElementById("bordercolour").value;  
  document.getElementById("previewHeader2Username").style.borderColor = document.getElementById("bordercolour").value;  
  
  document.getElementById("previewMainRank").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainRSN").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainCombat").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainHP").style.borderColor = document.getElementById("bordercolour").value;
  
  document.getElementById("previewMainHeaderRank").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainHeaderRSN").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainHeaderCombat").style.borderColor = document.getElementById("bordercolour").value;
  document.getElementById("previewMainHeaderHP").style.borderColor = document.getElementById("bordercolour").value;
  
  if (document.getElementById("fontfamily")[document.getElementById("fontfamily").selectedIndex].value == "verdana"){
    document.getElementById("previewTable2").style.fontSize = "11px";
    document.getElementById("selectBox").style.fontSize = "11px";
    document.getElementById("selectBox2").style.fontSize = "11px";
    document.getElementById("submitButton").style.fontSize = "11px";
  } else {
	document.getElementById("previewTable2").style.fontSize = "12px";
    document.getElementById("selectBox").style.fontSize = "12px";
    document.getElementById("selectBox2").style.fontSize = "12px";
    document.getElementById("submitButton").style.fontSize = "12px";	
  }
  document.getElementById("previewTable2").style.fontFamily = document.getElementById("fontfamily")[document.getElementById("fontfamily").selectedIndex].value;
  
  document.getElementById("previewMainHeader").style.color = document.getElementById("fontcolour2").value;
  document.getElementById("previewMainHeader").style.backgroundColor = document.getElementById("tablecolour").value;
  
  if (document.getElementById("displaytype").selectedIndex == 1){
    document.getElementById("previewMain").style.backgroundColor = document.getElementById("tablecolour").value;  
    document.getElementById("previewMain").style.color = rank1colour;
  } else {
    document.getElementById("previewMain").style.backgroundColor = rank1colour;  
    document.getElementById("previewMain").style.color = document.getElementById("fontcolour1").value;
  }
}

function showPreview(){
  document.getElementById("mlPreview").style.display = "block";	
}

function hidePreview(){
  document.getElementById("mlPreview").style.display = "none";	
}

function updateColour(id){
  document.getElementById(id + "Display").style.backgroundColor = document.getElementById(id).value;
}

function exportMembers(){
  window.open("memberlistexport.php");
}

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
      document.getElementById("updatemembersbutton").disabled = false;
      document.getElementById("updatemembersbutton").style.color = "#FFFFFF";
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
    } else {
      document.getElementById('ajax-loader').style.display = "inline";
      document.getElementById("updatemembersbutton").disabled = true;
      document.getElementById("updatemembersbutton").style.color = "#888888";
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
    }
  }  
  delete selectedmembers;
  var selectedmembers = new Array();
  for (var a = 0; a < document.forms["editmembersForm"].member.length; a++){
    if (document.forms["editmembersForm"].member[a].selected){
      selectedmembers.push(document.forms["editmembersForm"].member[a].value);
    }
  }
  ajaxRequest.open("GET", "updatemembersAjax.php?selectedmembers=" + selectedmembers, true);
  ajaxRequest.send(null);
}