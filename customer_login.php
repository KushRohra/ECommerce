<?php 
	include("includes/db.php");
?>

<div>
	<form method="post" action="">
		<table width="500" align="center" bgcolor="skyblue">
			<tr align="center" colspan="3">
				<td><h2>Login or Register to Buy!</h2></td>
			</tr>
			<tr align="right">
				<td><b>Email: </b></td>
				<td><input type="text" name="email" placeholder="Enter Email" required></td>
			</tr>
			<tr align="right">
				<td><b>Password: </b></td>
				<td><input type="password" name="pass" placeholder="Enter Password" required></td>
			</tr>
			<!--<tr align="right">
				<td colspan="3"><a  style="padding-right: 20px; text-decoration: none;" href="checkout.php?forgot_pass">Forgot Password</a></td>
			</tr>-->
			<tr align="center">
				<td colspan="3"><input type="submit" name="login" value="Login"></td>
			</tr>
		</table>
		<h2 style="float:right; padding-right: 20px;"><a style="text-decoration: none;" href="customer_register.php">New? Register Here</a></h2>
	</form>

	<?php

		if(isset($_POST['login']))
		{
			$c_email = $_POST['email'];
			$c_pass = $_POST['pass'];

			$sel_c = "select * from customers where customer_pass='$c_pass' AND customer_email='$c_email'" ;
			$run_c = mysqli_query($conn, $sel_c);
			$check_customer = mysqli_num_rows($run_c);

			if($check_customer == 0)
			{
				echo "<script>alert('Password or email is incorrect, pls try again!')</script>";
				exit();
			}
			$ip = getIp();
			$sel_cart = "select * from cart where ip_add='$ip'";
			$run_cart = mysqli_query($conn, $sel_cart);
			$check_cart = mysqli_num_rows($run_cart); 
			if($check_cart==0 AND $check_customer>0)
			{
				$_SESSION['customer_email']=$c_email;

				echo "<script>alert('You logged in succesfully.')</script>";
				echo "<script>window.open('customer/my_account.php', '_self')</script>";
			}
			else 
			{
				$_SESSION['customer_email']=$c_email;

				echo "<script>alert('You logged in succesfully.')</script>";
				echo "<script>window.open('checkout.php', '_self')</script>";
			}
		}

	?>

</div>