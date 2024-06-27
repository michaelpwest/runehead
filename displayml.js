if (width == 0){
  var width = 900;
}
if (height == 0){
  var height = 600;
}
if (hideBanner){
  var hideBanner = "&amp;hideBanner=true";
} else {
  var hideBanner = "";
}
if (hideStats){
  var hideStats = "&amp;hideStats=true";
} else {
  var hideStats = "";
}
if (hideDetails){
  var hideDetails = "&amp;hideDetails=true";
} else {
  var hideDetails = "";
}
if (hideRanks){
  var hideRanks = "&amp;hideRanks=true";
} else {
  var hideRanks = "";
}
if (hideMembers){
  var hideMembers = "&amp;hideMembers=true";
} else {
  var hideMembers = "";
}
document.write("<iframe src='http://www.runehead.com/clans/ml.php?clan=" + username + hideBanner + hideStats + hideDetails + hideRanks + hideMembers + "' style='width: " + width + "px; height: " + height + "px; overflow: auto; border: 0px;' frameborder='0'></iframe>");