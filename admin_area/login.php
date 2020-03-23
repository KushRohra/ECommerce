<!DOCTYPE>
<html>
	<head>
		<title>Login Form</title>
		<link rel="stylesheet" type="text/css" href="styles/login_style.css" media="all">
	</head>

	<body>
		
		<div class="login">
			<h1>Admin Login</h1>
		    <form method="post">
		    	<input type="text" name="email" placeholder="Email" required="required" />
		        <input type="password" name="pass" placeholder="Password" required="required" />
		        <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Login</button>
		    </form>
		</div>

	</body>
</html>

<?php

	session_start();

	include("includes/db.php");

	if(isset($_POST['login']))
	{
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		$sel_user = "select * from admin where user_email='$email' AND user_pass='$pass'";
		$run_user = mysqli_query($conn, $sel_user);

		$check_user = mysqli_num_rows($run_user);
		if($check_user == 0)
		{
			echo "<script>alert('Email or Password is wrong. Try Again!')</script>";
		} 
		else
		{
			$_SESSION['user_email']=$email;

			echo "<script>alert('Redirecting')</script>";
			echo "<script>window.open('index.php?logged_in=You have succesfully Logged in', '_self')</script>";
		}
	}

?>