function charsleft(){
  var charsleft = 500 - document.getElementById('information').value.length;
  if (charsleft < 0){
    charsleft = 0;
  }
  if (charsleft < 1){
    document.getElementById('information').value = document.getElementById('information').value.substring(0, 500);
  }
  document.getElementById('charsleft').innerHTML = '<b>' + charsleft + '</b>';
}