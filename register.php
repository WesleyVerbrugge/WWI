<?php include_once "header.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
<!--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>-->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>

<div class = "container">
	<div class="wrapper">
		<form action="register-back-end.php" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome to WideWorldImporters</h3>
			  <br>
			  
			  <input type="text" class="form-control rounded" name="fname" placeholder="First name"" required="" autofocus="" />
              <input type="text" class="form-control rounded" name="bname" placeholder="Prepositions"/>
              <input type="text" class="form-control rounded" name="sname" placeholder="Last name" required=""/>
              <input type="text" class="form-control rounded" name="email" placeholder="Email" required="" autofocus="" />
              <input type="text" class="form-control rounded" name="country" placeholder="Country" required=""/>
              <input type="text" class="form-control rounded" name="city" placeholder="City" required=""/>
              <input type="text" class="form-control rounded" name="adress" placeholder="Adress" required"" autofocus="" />
              <input type="text" class="form-control rounded" name="housenumber" placeholder="Housenumber" required=""/>
              <input type="text" class="form-control rounded" name="postalcode" placeholder="Postalcode" required=""/>
              <input type="text" class="form-control rounded" name="phone" placeholder="Phone" autofocus="" />
              <hr>
              <input type="password" class="form-control rounded" name="pwd" placeholder="Password" required="" autofocus="" />
              <input type="password" class="form-control rounded" name="pwd2" placeholder="Confirm password" required=""/>
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">register</button>
            <a href="login.php" class="btn-block" style="text-align: center">Heb je al een bestaand account?</a>
		</form>			
	</div>
</div>
</body>
</html>