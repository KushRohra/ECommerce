<?php
	session_start();

	include("functions/function.php");
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
								echo "<b>Welcome</b> User";
							else 
								echo "Welcome Guest";
						?>
						<b style="padding-left: 2px;" >Shopping Cart </b>Total Items: <?php total_items(); ?> <a href="index.php">Back to Shop</a>
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
					<br>
					<form action="" method="post" enctype="multipart/form-data">
						<table align="center" width="700" bgcolor="skyblue">
							<tr align="center">
								<th>Remove</th>
								<th>Product(s)</th>
								<th>Qty</th>
								<th>Total Price</th>
							</tr>
							<?php
								$total = 0;
								$ip = getIp();
								$sel_price = "select * from cart where ip_add='$ip'";
								$run_price = mysqli_query($conn, $sel_price);
								while($p_price  = mysqli_fetch_array($run_price))
								{
									$pro_id = $p_price['p_id'];
									$quantity = $p_price['qty'];
									$pro_price = "select * from products where product_id='$pro_id'";
									$run_pro_price = mysqli_query($conn, $pro_price);
									while($pp_price = mysqli_fetch_array($run_pro_price))
									{
										$product_price = array($pp_price['product_price']);
										$len = count($product_price);
										$product_title = $pp_price['product_title'];
										$product_image = $pp_price['product_image'];
										$single_price = $pp_price['product_price'];
										$values = 0;
										for($i=0; $i<$len; $i++)
										{
											$values = $values + $single_price*$quantity;
										}
										//$values = array_sum($product_price);
										$total = $total + $values;									
								//echo "$".$total;
							?>
							<tr align="center">
								<td></td>
								<td><?php echo $product_title ?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"></td>
								<td><img src="admin_area/product_images/<?php echo $product_image ?>" width="60" height="60"></td>
								<td><?php echo $quantity ?></td>
								<td><?php echo "$".$single_price; ?></td>
							</tr>
						<?php } } ?>
						<tr align="right">
							<td colspan="4"><b>Sub Total:</b></td>
							<td><?php echo "$".$total ?></td>
						</tr>
						<tr align="center">
							<td colspan="2"><input type="submit" name="update_cart" value="Update Cart"></td>
							<td><input type="submit" name="continue" value="Continue Shopping"></td>
							<td><button><a href="checkout.php" style="text-decoration: none; color: black;">CheckOut</a></button></td>
						</tr>
						</table>						
					</form>

					<?php
						global $conn;
						$ip = getIp();
						if(isset($_POST['update_cart']))
						{
							foreach ($_POST['remove'] as $remove_id) 
							{
								$delete_product = "delete from cart where p_id='$remove_id' AND ip_add='$ip'";
								$run_delete = mysqli_query($conn, $delete_product);
								if($run_delete)
								{
									echo "<script>window.open('cart.php', '_self')</script>";
								}	
							}
						}
						if(isset($_POST['continue']))
						{
							echo "<script>window.open('index.php', '_self')</script>";
						}
					?>

				</div>
			</div>
		</div>
		
		<div id="footer"><h2>&copy; 2020</h2></div>
	
	</div>

</body>
</html>