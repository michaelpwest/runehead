<?
if (isset($registerPage) && $registerPage){
	// skip
} else {
	include_once ("../design/top.php");	
}

echo "
<div class='main'>
";
if (isset($registerPage) && $registerPage){
	echo "<h1>Guidelines - Read before registering</h1>";
} else {
	echo "<h1>Guidelines</h1>";
}
echo "
  <div class='justify'>
	<p>1 memberlist per clan / group is strongly recommended in order to reduce confusion. It is also recommended that you don't use
	your RuneScape Name as your username to avoid problems if you hand the memberlist over to another leader.</p>
";
if (isset($registerPage) && $registerPage){
echo "
    <p>All memberlist registrations are subject to validation to ensure only appropriate memberlists are activated.
	This validation will happen in under 24-48 hours usually. You will be emailed after validation is complete.</p>
";
}
echo "
    <p>If you misuse this service you risk your account being removed without any warning and may face further punishment such as
	IP banning.</p>
	<p>To ensure this doesn't happen, you must read and follow the guidelines belows:</p>
	<ul style='margin-top: 0px;'>
	  <li>Memberlists must be in English so we can ensure that the service is safe for everyone to view.</li>
	  <li>Never add someone to your memberlist against their will.</li>
	  <li>Never refuse to remove someone from your memberlist. This includes any clan ending lists, even if the person was in the clan at some point.</li>
	  <li>Never add anything racist, sexist or generally offensive on your memberlist.</li>
	  <li>Only register an appropriate memberlist as specified below.</li>
	</ul>	
	<p style='text-decoration: underline;'><b>Appropriate memberlists</b></p>
	<ul style='margin-top: 0px;'>
	  <li>Official clan memberlists. Every official clan will need to have a valid website / forum.</li>
	  <li>Future applicant memberlists.</li>
	  <li>PC Groups.</li>
 	  <li>Castle Wars Groups.</li>
  	  <li>Country Listing.</li>
	  <li>Website staff / members.</li>
	  <li>Miscellaneous lists (clan ending lists, members + future applicants lists, units etc.).<br />Note: These lists are subject to approval.</li>
	</ul>
	<p style='text-decoration: underline;'><b>Inappropriate memberlists</b></p>
	<ul style='margin-top: 0px;'>
	  <li>Anything racist, sexist or generally offensive.</li>
	  <li>Anything pointless.</li>
	  <li>Anything that lists people against their will.</li>
	  <li>Hate Lists.</li>
	  <li>Friends lists.</li>
	  <li>99 skill lists.</li>
	</ul>
	<p>Your cooperation in following these guidelines is greatly appreciated to ensure the RuneHead Hiscores Catalogue is an open
	and welcome place for everyone to use.</p>
  </div>
</div>
";

if (isset($registerPage) && $registerPage){
	// skip
} else {
	include_once ("../design/bottom.php");	
}
?>