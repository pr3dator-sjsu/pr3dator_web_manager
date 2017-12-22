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
<head>
<meta http-equiv="Content-Language" content="en-us">
</head>

<body link="#00FF00" vlink="#00FF00" alink="#00FF00" text="#00FF00" bgcolor="#000000">

<fieldset style="padding: 2">
<legend><font color="#FF0000"><b>SSO / API INTEGRATION (FOR ADMINS)</b></font></legend>
&nbsp;');

include("db_manager.php");

display_twitter_api_information();

display_facebook_api_information();

display_github_api_information();

echo ('<form method="GET" action="update_api_information.php">
	<p><input type="submit" value="SAVE RESULTS"> <input type="reset" value="Reset" name="B2"></p>
</form>
<p>&nbsp;</p>
</fieldset>
');} 
?>

