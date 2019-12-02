
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>

<div class = "container">
	<div class="wrapper">
		<form action="register-back-end.php" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control" name="fname" placeholder="Volledige naam" required="" autofocus="" />
              <input type="text" class="form-control" name="pname" placeholder="Naam bij voorkeur" required=""/>  
              <input type="text" class="form-control" name="email" placeholder="Email" required="" autofocus="" />  
              <input type="text" class="form-control" name="pwd" placeholder="Wachtwoord" required="" autofocus="" />   	 	
              <input type="password" class="form-control" name="pwd2" placeholder="Bevestig wachtwoord" required=""/>   	  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">register</button>  			
		</form>			
	</div>
</div>
</body>
</html>