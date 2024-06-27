<? include_once ("../design/top.php");

if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
} else {
	$id = "";
}

if ($id == "") {
echo "
<div id='intro'>
  <h1>Admin Control Panel Guide</h1>
  <p>Find out how to use the the RuneHead Hiscores Catalogue's Admin Control Panel.<br />
  Below is a guide on how to use the Admin Control Panel.</p>  
  
  <p style='text-align: center;'>
  <b>Shortcuts to Information:</b><br />  
  <a href='#clan'>General Details</a> |
  <a href='#info'>Detailed Info</a> |
  <a href='#colour'>Colour Details</a> |
  <a href='#ranks'>Manage Ranks</a>
  <br />
  <a href='#add'>Add Members</a> |
  <a href='#edit'>Edit / Delete / Update</a> |
  <a href='#password'>Account Details</a> |  
  <a href='#message'>Current Message</a>
  </p>
  <p><span class='success'>Note: If you find something that doesn't make sense or is missing please <a href='contactus.php' style='color:#FFD700;'>contact us</a>.</span></p>
</div>
";
}

if ($id == "" || $id == "clandetails") {
echo "
<div class='main' id='clan'>
  <h1>General Details</h1>
  <div class='justify'>
    <p>The General Details section of the Admin Control Panel is where you can set general details about your clan / group such Website and request other changes
	such as Memberlist Category, Clan / Group Name and Banner.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Clan / Group Website URL (Optional)</b> - The URL of your clan / group's website. Must start with either http:// or https://</li>
	  <li><b>IRC Channel (Optional)</b> - The IRC Channel for your clan / group.</li>
	</ul>
  </div>
</div>
";
}

if ($id == "" || $id == "claninfo") {
echo "
<div class='main' id='info'>
  <h1>Detailed Info</h1>
  <div class='justify'>
    <p>The Detailed Info section of the Admin Control Panel allows you to set some more detailed information about your clan / group and memberlist.</p>
	<ul style='margin-top: 0px'>
	  <li><b>F2P / P2P Based (Optional)</b> - Select whether your clan is mainly a F2P or P2P clan or whether it operates under both F2P and P2P.</li>
	  <li><b>Time Base (Optional)</b> - Select what timezone your clan / group is mainly run under.</li>
	  <li><b>Cape Colour (Optional)</b> - Select what your clan / group's cape colour is.</li>
	  <li><b>Home World (Optional)</b> - Enter in what world your clan calls home.</li>
	  <li><b>Initials (Optional)</b> - If your clan / group has initials, you can enter them here.</li>
	  <li><b>Auto Update</b> - Define whether you want your memberlist's stats automatically updated once every 24 hours.</li>	  
	</ul>	
  </div>
</div>
";
}

if ($id == "" || $id == "colourdetails") {
echo "
<div class='main' id='colour'>
  <h1>Colour Details</h1>
  <div class='justify'>
    <p>The Colour Details section allows you to define how you want your memberlist to look.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Font Family</b> - Select which font you want to display your memberlist under. Default is Verdana.</li>
	  <li><b>Font Colour 1</b> - Select or enter the primary font colour for your memberlist.</li>
	  <li><b>Font Colour 2</b> - Select or enter what secondary font colour you want to have for your memberlist. This colour is used for tables displaying averages, ranks etc.</li>
	  <li><b>Background Colour</b> - Select or enter what background colour you want your memberlist to have.</li>
	  <li><b>Table Colour</b> - Select or enter what background colour you want to have for the tables in your memberlist.</li>
	  <li><b>Header Font Colour</b> - Select or enter what font colour you want to be used in the headers of each table.</li>
	  <li><b>Header Background Colour</b> - Select or enter what background colour you want each header to have.</li>
	  <li><b>Border Colour</b> - Select or enter what colour you want the borders on the memberlist to be.</li>
	  <li><b>Personal Page Font Colour</b> - Select which font colour is used on the Personal Stats page.</li>
	  <li><b>Rank Display Type</b> - Here you can select how you want the ranks to be displayed on your memberlist.<br />
	  If you select Cell Background each rank will have a background colour corresponding to what that rank's colour is.<br /><img src='images/help/cellbackgrounds.png' alt='' /><br />
	  If you select Font Colours each rank will have its corresponding colour as the font colour.<br /><img src='images/help/fontcolours.png' alt='' /></li>
	</ul>
  </div>
</div>
";
}

if ($id == "" || $id == "manageranks") {
echo "
<div class='main' id='ranks'>
  <h1>Manage Ranks</h1>
  <div class='justify'>
    <p>RuneHead Hiscores Catalogue memberlists allow you to have up to 16 ranks. Each rank has its own name and colour and can be set under the Manage Ranks section.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Rank</b> - Enter in the name of the Rank.</li>
	  <li><b>Colour</b> - Select (by clicking the colour icon) or enter the colour you want to display on the memberlist for that rank.</li>
	</ul>
  </div>
</div>
";
}

if ($id == "" || $id == "addmembers") {
echo "
<div class='main' id='add'>
  <h1>Add Members</h1>
  <div class='justify'>
    <p>The Add Members section of the Admin Control Panel allows you to add members to your memberlist and choose
	what rank you want them to be.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Member Name(s)</b> - Here you can enter the member name(s) you want to add to your memberlist. Up to 50 members can be added at once with one per line.</li>
	  <li><b>Rank</b> - After entering in what member name(s) you want to add, you can select what rank you want them to be under.</li>
	  <li>
	    <b>Import Members</b> - This will allow you to import your members from a file. The selected file will need to be either a text tab delimited (.txt) or comma separated values (.csv). The first value in each row will be the RuneScape name while the second value will be the rank number which will correspond to your ranks under \"Manage Ranks\".<br />
	    <b>Example Files: <a href='images/help/example.txt'>.txt</a> | <a href='images/help/example.csv'>.csv</a></b>
	  </li>
	</ul>
  </div>
</div>
";
}

if ($id == "" || $id == "editmembers") {
echo "
<div class='main' id='edit'>
  <h1>Edit / Delete / Update</h1>
  <div class='justify'>
    <p>If you want to edit or delete members from your memberlist or update the stats of your members, it can be done in the Edit / Delete / Update section of the Admin Control Panel.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Rank</b> - If you want to change the rank of a member first select the member(s) you wish to update, select the new rank and then click the Edit Member(s) button.</li>
	  <li><b>Edit Member(s)</b> - This button will update the selected members' rank or name when clicked.</li>
	  <li><b>Delete Member(s)</b> - Select what members you want to delete and click this button to delete them from your memberlist.</li>
	  <li><b>Export All Members</b> - This will allow you to export your members by generating a text tab delimited file (.txt). This file will have 2 columns, RuneScape and Rank. Each rank will be a number (1-16) which will correspond to your ranks under \"Manage Ranks\". This option will only show if you at least 1 member on your memberlist.</li>
	  <li><b>Update Member(s)</b> - To update your memberlist, select 1-100 members at a time, click this button and wait for the process to complete (it may take up to 1-2 minutes to complete).</li>
	</ul>
  </div>
</div>
";
}

if ($id == "" || $id == "accountdetails") {
echo "
<div class='main' id='password'>
  <h1>Account Details</h1>
  <div class='justify'>
    <p>If you wish to change your RuneHead Hiscores Catalogue password or email address it can be done under the Account Details section. It is recommended that you change the provided password shortly after creating the account and that you don't use your RuneScape Password for this or any other site.</p>
	<h1>Change Password</h1>
	<ul style='margin-top: 0px'>
	  <li><b>Current Password</b> - Enter in your current RuneHead Hiscores Catalogue password.</li>
	  <li><b>New Password</b> - Enter in your new password.</li>
	  <li><b>Confirm Password</b> - Repeat your new password to ensure it has been entered correctly.</li>
	</ul>
	<h1>Change Email</h1>
	<ul style='margin-top: 0px'>
	  <li><b>Current Email</b> - The current email for your account.</li>
	  <li><b>Current Password</b> - Enter in your current RuneHead Hiscores Catalogue password.</li>
	  <li><b>New Email Address</b> - Enter in the new email address you wish to use.</li>	
	</ul>	  
  </div>
</div>
";
}

if ($id == "" || $id == "currentmessage") {
echo "
<div class='main' id='message'>
  <h1>Current Message</h1>
  <div class='justify'>
    <p>After any change is made in the Admin Control Panel and the page has reloaded it will take you to the Current Message section. The Current Message section will display whether a change was successful or not.</p>
	<ul style='margin-top: 0px'>
	  <li><b>Gold Messages</b> - If your change is successful the message will appear in a <span class='success'><b>gold</b></span> colour.</li>
	  <li><b>White Messages</b> - If your change is unsuccessful the message will appear in a white colour and explain how to make the correction.</li>
	</ul>
  </div>
</div>
";
}

include_once ("../design/bottom.php"); ?>