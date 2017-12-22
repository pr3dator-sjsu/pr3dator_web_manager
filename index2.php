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


<html>

<head>
<title>PR3DATOR WEB APP v1.0</title>
</head>

<frameset rows="152,*" border=1>
	<frame name="banner" scrolling="no" noresize target="contents" src="top.php">
	<frameset cols="289,*" border=1>
		<frame name="contents" target="main" src="menu.php">
		<frame name="main" src="main.php">
	</frameset>
	<noframes>
	<body>

	<p>This page uses frames, but your browser doesn\'t support them.</p>

	</body>
	</noframes>
</frameset>

</html>
');} 
?>
