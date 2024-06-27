<? include_once ("../design/top.php"); ?>
<script type="text/javascript">
function update(){
  document.getElementById("ml_username2").innerHTML = document.getElementById("ml_username").value;
  document.getElementById("ml_width2").innerHTML = document.getElementById("ml_width").value;
  document.getElementById("ml_height2").innerHTML = document.getElementById("ml_height").value;
  document.getElementById("options").innerHTML = "";
  if (document.getElementById("option1").checked){
    document.getElementById("options").innerHTML += "hideBanner = true<br />";
  }
  if (document.getElementById("option2").checked){
    document.getElementById("options").innerHTML += "hideStats = true<br />";
  }
  if (document.getElementById("option3").checked){
    document.getElementById("options").innerHTML += "hideDetails = true<br />";
  }
  if (document.getElementById("option4").checked){
    document.getElementById("options").innerHTML += "hideRanks = true<br />";
  }
  if (document.getElementById("option5").checked){
    document.getElementById("options").innerHTML += "hideMembers = true<br />";
  }
}
</script>
<div id="intro">
  <h1>Memberlist Embedding</h1>
  <div class="justify">
    <p>Follow the below steps and you can have a RuneHead Hiscores Catalogue memberlist display on your website.</p>
  </div>
</div>
<noscript>
  <div class="main">
    <h1>JavaScript Needed</h1>
    <p>This features requires JavaScript to be enabled to work correctly.<br /><br />
    <a href="http://www.mistered.us/tips/javascript/browsers.shtml">Click here</a>
    for an article on how to enable JavaScript.</p>
  </div>
</noscript>
<form id="displayml" action="" method="post">
  <div class="main">
    <p>1. Enter the memberlist username into the box below:<br />
    <span class="success">http://www.runehead.com/clans/ml.php?clan=</span><input class="success" name="ml_username" id="ml_username" value="" maxlength="12" style="background-color: #727272; text-align: left;" onkeyup="update();" /></p>
    <p>2. Enter the width and height of the frame you wish to display your memberlist in.<br />
    <span class="success">Width:</span> <input id="ml_width" name="ml_width" value="900" style="width: 50px;" maxlength="4" onkeyup="update();" />
    <span class="success">Height:</span> <input id="ml_height" name="ml_height" value="600" style="width: 50px;" maxlength="4" onkeyup="update();" /></p>
    <p>3. Select optional parameters:<br />
    <input type="checkbox" id="option1" name="option1" onclick="update();" value="true" /> <label for="option1"><span class="success">Hide Banner</span></label><br />
    <input type="checkbox" id="option2" name="option2" onclick="update();" value="true" /> <label for="option2"><span class="success">Hide Stats</span></label><br />
    <input type="checkbox" id="option3" name="option3" onclick="update();" value="true" /> <label for="option3"><span class="success">Hide Clan Details</span></label><br />
    <input type="checkbox" id="option4" name="option4" onclick="update();" value="true" /> <label for="option4"><span class="success">Hide Ranks</span></label><br />
    <input type="checkbox" id="option5" name="option5" onclick="update();" value="true" /> <label for="option5"><span class="success">Hide Members</span></label></p>
    <p>4. Add the code below to your website:</p>
    <div class="success" style="background-color: #555555; width: 97%; margin: 0px auto 5px auto;">
      &lt;script type=&quot;text/javascript&quot;&gt;<br />
      &lt;!-- Modify values below accordingly. --&gt;<br />
      username = &quot;<span id="ml_username2"></span>&quot;<br />
      width = &quot;<span id="ml_width2">900</span>&quot;<br />
      height = &quot;<span id="ml_height2">600</span>&quot;<br />
      <span id="options"></span>
      &lt;/script&gt;<br />
      &lt;!-- Do not edit below or memberlist may not appear. --&gt;<br />
      &lt;script type=&quot;text/javascript&quot; src=&quot;http://www.runehead.com/clans/displayml.js&quot;&gt;&lt;/script&gt;
    </div>
    <p>You can edit the values in the resulting code manually if required at a later stage.</p>
  </div>
</form>
<? include_once ("../design/bottom.php"); ?>