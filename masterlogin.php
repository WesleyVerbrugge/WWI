<?php 
session_start();
include_once "header.php"; 
?>
<body>

<div class = "container">
	<div class="wrapper">
		<form action="master-login-back-end.php" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
			  <br>
			  
			  <input type="text" class="form-control rounded" name="Email" placeholder="Email" required="" autofocus="" />
			  <input type="password" class="form-control rounded" name="Password" placeholder="Password" required=""/>
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>
		</form>			
	</div>
</div>
</body>
</html>