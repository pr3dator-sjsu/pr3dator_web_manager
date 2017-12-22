<?php
  require __DIR__ . '/vendor/autoload.php';
  require __DIR__ . '/dotenv-loader.php';
  use Auth0\SDK\Auth0;
  $domain        = getenv('AUTH0_DOMAIN');
  $client_id     = getenv('AUTH0_CLIENT_ID');
  $client_secret = getenv('AUTH0_CLIENT_SECRET');
  $redirect_uri  = getenv('AUTH0_CALLBACK_URL');
  $audience      = getenv('AUTH0_AUDIENCE');
  if($audience == ''){
    $audience = 'https://' . $domain . '/userinfo';
  }
  $auth0 = new Auth0([
    'domain' => $domain,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'audience' => $audience,
    'scope' => 'openid email profile app_metadata',
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
  ]);
  $userInfo = $auth0->getUser();
  $userEmail = $userInfo['email'];
  
  if((strpos($userEmail, 'pr3dator.com') !== FALSE)){
        $isAdmin = true;
  } else {
	$isAdmin = false;
  }
  
if (!$userInfo) {
    echo("<br>You are not logged in<br>");
}
else {
	
echo('
<body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" text="#FFFFFF" bgcolor="#000000">

<form method="GET" action="update_order_status.php">
	<fieldset style="padding: 2">
	<legend>
	<p style="margin-top: 0; margin-bottom: 0"><b><font color="#00FF00">ORDER STATUS UPDATE</font></b></p>
	</legend>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<div align="left">
		<table border="1" bgcolor="#808080" width="100%" bordercolorlight="#0000FF" bordercolordark="#0000FF">
			<tr>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Customer Number</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Customer Name</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Order Number</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Order Date</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Required Date</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Shipped Date</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>
				Status</b></font></td>
				<td bgcolor="#0000FF" align="center" bordercolorlight="#800000" bordercolordark="#800000"><font color="#FFFF00"><b>Select</b></font></td>
			</tr>
			<tr>');
			
			include("db_manager.php");
			display_orders_to_update();
			
	echo('</table>
	</div>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<p style="margin-top: 0; margin-bottom: 0">Change the item\'s selected status 
	to:&nbsp; <span style="background-color: #FFFF00">
	<select size="1" name="order_type">
	<option selected value="Shipped">Shipped</option>
	<option value="Resolved">Resolved</option>
	<option value="Cancelled">Cancelled</option>
	<option value="On Hold">On Hold</option>
	<option value="Disputed">Disputed</option>
	<option value="In Process">In Process</option>
	</select></span></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	</fieldset>&nbsp;<p><input type="submit" value="SAVE CHANGES">&nbsp; <input type="reset"></p>
</form>
');}
?>