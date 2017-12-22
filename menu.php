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
<head> <b><font face="Arial" size="4" color="#D0D3D4">&lt;&lt;| MAIN MENU |&gt;&gt;</font></b><font face="Arial"><b><font size="4" color="#D0D3D4">
</head>');
  
echo('<br><br>' . $userEmail . '<br>');

echo('</font></b>

<body link="#0000FF" vlink="#0000FF" text="#0000FF" bgcolor="#000080" alink="#0000FF" background="vision01.jpg">
</font>
<div>
<font face="Verdana"><br><b><font color="#D0D3D4">&gt;&gt;</font></b>
<a href="app_integration_users.php" target="main">API INTEGRATION
</a></font>
<p><font face="Verdana"><br><b><font color="#D0D3D4">&gt;&gt;</font></b>
<a href="order_status_update.php" target="main">ORDER STATUS UPDATE</a><br>&nbsp;</font></p>
<p><font face="Verdana"><b><font color="#D0D3D4">&gt;&gt;</font></b>
<a href="social_media_intg.php" target="main">SOCIAL MEDIA POSTING</a></font></p>
<p align="left"><font face="Verdana"><u><font size="4" color="#FFFFFF">
<a target="main" href="logout.php" onClick="changeUrl()">&lt; LOGOUT</a></font></u><a target="main" href="logout.php"><font color="#FFFFFF" size="4">
</font></a></font><u><font size="4" face="Arial" color="#FFFFFF">

</font></u></p>
<p>&nbsp;</div>
</body>
');}
?>
