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

if (!$isAdmin) {
    echo("<br>User not admin<br>");
}
else {
echo('

<body text="#FFFFFF" bgcolor="#000000" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">

<form method="GET" action="update_social_media.php">

<fieldset style="padding: 2">
<legend><font color="#FF0000"><b>SOCIAL NETWORK COMMUNICATIONS</b></font></legend>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">
<font color="#00FF00">&nbsp;Please, 
select what kind of actions you would like to share on the selected/available 
social network integration(s):</font></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">

<span style="background-color: #000000">');

include("db_manager.php");
display_social_network_information();

echo('
</font>
</span>
</fieldset>

<p align="left">&nbsp; <font color="#FF0000"> <input type="submit" value="SAVE CHANGES"></font>&nbsp;&nbsp;&nbsp;
	
<input type="reset" value="RESET" name="B2"></p>


</form>

');} 
?>
