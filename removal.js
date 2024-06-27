var a = 0;
function showSearch(){
  if (document.getElementById("search").style.display == "none"){
    document.getElementById("search").style.display = "block";
  } else {
    document.getElementById("search").style.display = "none";
  }
}

function searchAdd(current, b){
  document.getElementById("memberlist").value = current;
}

function addMl(){
  a++;
  document.getElementById("memberlists").innerHTML += "<p><span class='success'>http://www.runehead.com/clans/ml.php?clan=</span><input class='success' name='memberlist[" + a + "]' id='memberlist' value='' maxlength='12' style='background-color: #727272; text-align: left;' /> <input type='button' onclick='showSearch(" + a + ");' value='Search' /></p>";
  document.getElementById("search").style.display = "none";
}