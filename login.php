<?php include_once "header.php"; 
if(isset($_GET['rs'])) {
	echo '<div class="alert alert-success" role="alert">
	Register succesful!
  </div>' ;
}
?>
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
		<form action="login-back-end.php" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
			  <br>
			  
			  <input type="text" class="form-control rounded" name="Email" placeholder="Email" required="" autofocus="" />
			  <input type="password" class="form-control rounded" name="Password" placeholder="Password" required=""/>
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>
            <a href="register.php" class="btn-block" style="text-align: center">No account yet?</a>
		</form>			
	</div>
</div>
</body>
</html>