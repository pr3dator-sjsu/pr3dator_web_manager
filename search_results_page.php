<!DOCTYPE html>
<html lang="en">
<head>
  <title>SEARCH RESULTS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>SEARCH RESULTS</h2>  
  <div> 
  <form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<!--legend>DATA MANAGEMENT</legend-->

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Search Results For: </label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Customers</option>
      <option value="2">Employees</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submitbutton"></label>
  <div class="col-md-4">
    <button id="submitbutton" name="submitbutton" class="btn btn-primary">SUBMIT</button>
  </div>
</div>

</fieldset>
</form>
  </div>
  <table class="table table-striped ">
    <thead>
      <tr>
        <th>Title</th>
        <th>Customer Name</th>
        <th>Customer Contact</th>
        <th>Customer Location</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
        <td>Canada</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
        <td>USA</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td>UK</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
