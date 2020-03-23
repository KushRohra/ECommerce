<?php
	session_start();
	include("functions/function.php");
	include("includes/db.php");
?>

<!DOCTYPE html> 
<html>
<head>
	<title>My Online Shop</title>
	<link rel="stylesheet" href="styles/style.css" media="all" />
</head>
<body>

	<div class="main_wrapper">
		
		<div class="header_wrapper">
			<a href="index.php"><img id="logo" src="images/logo1.png"></a>
			<img id="banner" src="images/ad-banner1.gif">
		</div>
		
		<div class="menubar">
			<ul id="menu">
				<li><a href="index.php">Home</a></li>
				<li><a href="all_products.php">All Products</a></li>
				<?php

					if(isset($_SESSION['customer_email']))
					{
						echo "<li><a href='customer/my_account.php'>My Account</a></li>";
					}
					
				?>
				<li><a href="#">Sign Up</a></li>
				<li><a href="cart.php">Shopping Cart</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
			<div id="form">
				<form method="get" action="results.php" enctype="multipart/form-data">
					<input type="text" name="user_query" placeholder="Search a product" >
					<input type="submit" name="search" value="Search" />
				</form>
			</div>
		</div>
		
		<div class="content_wrapper">
			<div id="sidebar">
				<div id="sidebar_title">Categories</div>
				<ul id="cats">
					<?php getCats(); ?>
				</ul>
				<div id="sidebar_title">Brands</div>
				<ul id="cats">
					<?php getBrands(); ?>
				</ul>
			</div>
			<div id="content_area">
				<?php cart(); ?>
				<div class="shopping_cart">
					<span>
						<?php
							if(isset($_SESSION['customer_email']))
								echo "<b>Welcome:</b> User";
							else 
								echo "Welcome Guest";
						?>
						<b style="padding-left: 2px;">Shopping Cart </b>Total Items: <?php total_items(); ?> <a href="cart.php">Go to cart</a>
					</span>
				</div>
				<form action="customer_register.php" method="post" enctype="multipart/form-data">
					<table align="center" width="750">
						<tr align="center">
							<td colspan="6"><h2 style="margin-bottom: 10px;">Create an Account</h2></td>
						</tr>
						<tr>
							<td align="right">Customer Name:</td>
							<td><input type="text" name="c_name" required></td>
						</tr>
						<tr>
							<td align="right">Customer Email:</td>
							<td><input type="text" name="c_email" required></td>
						</tr>
						<tr>
							<td align="right">Customer password:</td>
							<td><input type="password" name="c_pass" required></td>
						</tr>
						<tr>
							<td align="right">Customer Image:</td>
							<td><input type="file" name="c_image" required></td>
						</tr>
						<tr>
							<td align="right">Customer Country:</td>
							<td>
								<select name="c_country">
									<option>Select a Country</option>
									<?php getCountry(); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">Customer City:</td>
							<td><input type="text" name="c_city" required></td>
						</tr>
						<tr>
							<td align="right">Customer Address:</td>
							<td><input type="text" name="c_address" required></textarea></td>
						</tr>
						<tr>
							<td align="right">Customer Contact:</td>
							<td><input type="text" name="c_contact" required></td>
						</tr>
						<tr>
							<td colspan="6"><input style="margin-left: 50px; margin-top: 10px" type="submit" name="register" value="Create Account"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
		<div id="footer"><h2>&copy; 2020</h2></div>
	
	</div>

</body>
</html>

<?php

	if(isset($_POST['register']))
	{
		$ip = getIp();

		$c_name = $_POST['c_name'];
		$c_email = $_POST['c_email'];
		$c_pass = $_POST['c_pass'];
		$c_image = $_FILES['c_image']['name'];
		$c_image_temp = $_FILES['c_image']['tmp_name'];
		$c_country = $_POST['c_country'];
		$c_city = $_POST['c_city'];
		$c_contact = $_POST['c_contact'];
		$c_address = $_POST['c_address'];

		move_uploaded_file ($c_image_temp, "customer/customer_image/$c_image");

		$insert_c = "insert into customers(customer_ip, customer_name, customer_email, customer_pass, customer_country, customer_city, customer_address, customer_contact,  customer_image) values('$ip', '$c_name', '$c_email', '$c_pass', '$c_country', '$c_city', '$c_address', '$c_contact', '$c_image')";
		$run_c = mysqli_query($conn, $insert_c);
		
		$sel_cart = "select * from cart where ip_add='$ip'";
		$run_cart = mysqli_query($conn, $sel_cart);
		$check_cart = mysqli_num_rows($run_cart);
		if($check_cart == 0)
		{
			$_SESSION['customer_email'] = $c_email;
			echo "<script>alert('Account has been created successfully, Enjoy your Shopping')</script>";
			echo "<script>window.open('customer/my_account.php', '_self')</script>";
		}
		else
		{
			$_SESSION['customer_email'] = $c_email;
			echo "<script>alert('Account has been created successfully, Enjoy your Shopping')</script>";
			echo "<script>window.open('checkout.php', '_self')</script>";	
		}
	}

?>