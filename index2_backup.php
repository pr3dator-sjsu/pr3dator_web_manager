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
?>
<html>
    <head>
    </head>
    <body class="home">
        <div class="container">
            <div class="login-page clearfix">
              <?php if(!$userInfo): ?>
              <div class="login-box auth0-box before">
                <img src="https://i.cloudup.com/StzWWrY34s.png" />
                <h3>Auth0 Example</h3>
                <p>Zero friction identity infrastructure, built for developers</p>
                <a class="btn btn-primary btn-lg btn-login btn-block" href="login.php">SignIn</a>
              </div>
              <?php else: ?>
              <div class="logged-in-box auth0-box logged-in">
                <h2>Welcome <span class="nickname"><?php echo $userInfo['nickname'] ?></span></h2>
                <h2><?php echo $userInfo['email'] ?></span></h2>
                <h2><?php echo $userInfo['app_metadata']['roles'] ?></span></h2>
                <a class="btn btn-warning btn-logout" href="/logout.php">Logout</a>
              </div>
              <?php endif ?>
            </div>
        </div>
    </body>
</html>

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

	<p>This page uses frames, but your browser doesn't support them.</p>

	</body>
	</noframes>
</frameset>

</html>
