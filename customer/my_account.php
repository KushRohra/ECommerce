<?php
	session_start();
	include("functions/function.php");
?>

<!DOCTYPE html> 
<html>
<head>
	<title>My Online Shop</title>
	<link rel="stylesheet" href="./styles/style.css" type="text/css">
</head>
<body>

	<div class="main_wrapper">
		
		<div class="header_wrapper">
			<a href="../index.php"><img id="logo" src="./images/logo1.png"></a>
			<img id="banner" src="./images/ad-banner1.gif">
		</div>
		
		<div class="menubar">
			<ul id="menu">
				<li><a href="../index.php">Home</a></li>
				<li><a href="../all_products.php">All Products</a></li>
				<?php

					if(isset($_SESSION['customer_email']))
					{
						echo "<li><a href='customer/my_account.php'>My Account</a></li>";
					}
					
				?>
				<li><a href="#">Sign Up</a></li>
				<li><a href="../cart.php">Shopping Cart</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
			<div id="form">
				<form method="get" action="../results.php" enctype="multipart/form-data">
					<input type="text" name="user_query" placeholder="Search a product" >
					<input type="submit" name="search" value="Search" />
				</form>
			</div>
		</div>
		
		<div class="content_wrapper">
			<div id="sidebar">
				<div id="sidebar_title">My Account</div>
				<ul id="cats">
					<?php
					
						$user = $_SESSION['customer_email'];
						$get_img = "select * from customers where customer_email='$user'";
						$run_img = mysqli_query($conn, $get_img);
						$row_img = mysqli_fetch_array($run_img);
						$c_image = $row_img['customer_image'];
						$c_name = $row_img['customer_name'];
						echo "<p><img src='customer_image/$c_image'></p>";

					?>
					
					<li><a href="my_account.php?my_orders">My Cart</a></li>
					<li><a href="my_account.php?edit_account">Edit Account</a></li>
					<li><a href="my_account.php?change_pass">Change Password</a></li>
					<li><a href="my_account.php?delete_account">Delete Account</a></li>	
					<li><a href="../logout.php">Logout</a></li>	
				</ul>
			</div>
			<div id="content_area">
				<?php cart(); ?>
				<div class="shopping_cart">
					<span>
						<?php
							if(isset($_SESSION['customer_email']))
								echo "<b>Welcome:</b> User";
						?>
						<?php 
							if(!isset($_SESSION['customer_email']))
							{
								echo "<a href='../checkout.php'>Login</a>";
							}
							else
							{
								echo "<a href='../logout.php'>Logout</a>";	
							}
						?>
					</span>
				</div>
				<div id="products_box"> 
					<?php
						if(!isset($_GET['my_orders']))
						{
							if(!isset($_GET['edit_account']))
							{
								if(!isset($_GET['change_pass']))
								{
									if(!isset($_GET['delete_account']))
									{
										echo '<h2 style="padding: 20px;">Welcome: <?php echo $c_name; ?></h2><br>';
										/*echo '<b>You can see your order s progress by clicking this link <a href="my_account.php?my_orders">Link</a></b>';*/					
									}	
								}		
							}	
						}
					?>
					<?php
						if(isset($_GET['my_orders']))
						{
							echo "<script>window.open('../cart.php', '_self')</script>";
						}
						if(isset($_GET['edit_account']))
						{
							include("edit_account.php");
						}
						if(isset($_GET['change_pass']))
						{
							include("change_pass.php");
						}
						if(isset($_GET['delete_account']))
						{
							include("delete_account.php");
						}
					?>
				</div>
			</div>
		</div>
		
		<div id="footer"><h2>&copy; 2020</h2></div>
	
	</div>

</body>
</html>