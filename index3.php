<!DOCTYPE html>
<html lang="en">
<head>
  <title>PR3DATOR WEBAPP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend align="center">PROVIDE YOUR USER CREDENTIAL</legend>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">USERNAME</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="Username" class="form-control input-md" required="">
  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">PASSWORD</label>
  <div class="col-md-4">
    <input id="passwordinput" name="passwordinput" type="password" placeholder="Password" class="form-control input-md" required="">
    
  </div>
</div>
<div class="form-group">
 <div class="checkbox">
    <label class="col-md-4 control-label"><input type="checkbox">Remember me</label>
  </div> 
  </div>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
   <!-- <button id="submit" name="submit" class="btn btn-primary" href="login.php">Access</button>-->
<a class="btn btn-primary btn-lg btn-login btn-block" href="login.php">SignIn</a>
  </div>
</div>



</fieldset>
</form>


</body>
</html>

