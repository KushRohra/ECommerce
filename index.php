<?php
	session_start();
	include("functions/function.php");
?>

<!DOCTYPE html> 
<html>
<head>
	<title>My Online Shop</title>
	<link rel="stylesheet" href="styles/style.css" type="text/css">
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
						<?php 
							if(!isset($_SESSION['customer_email']))
							{
								echo "<a href='checkout.php'>Login</a>";
							}
							else
							{
								echo "<a href='logout.php'>Logout</a>";	
							}
						?>
					</span>
				</div>
				<div id="products_box">
					<?php getPro(); ?>
					<?php getCatPro(); ?>
					<?php getBrandPro(); ?>
				</div>
			</div>
		</div>
		
		<div id="footer"><h2>&copy; 2020</h2></div>
	
	</div>

</body>
</html>