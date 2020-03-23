<?php
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
			<img id="logo" src="images/logo1.png">
			<img id="banner" src="images/ad-banner1.gif">
		</div>
		
		<div class="menubar">
			<ul id="menu">
				<li><a href="#">Home</a></li>
				<li><a href="#">All Products</a></li>
				<?php

					if(isset($_SESSION['customer_email']))
					{
						echo "<li><a href='customer/my_account.php'>My Account</a></li>";
					}
					
				?>
				<li><a href="#">Sign Up</a></li>
				<li><a href="#">Shopping Cart</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
			<div id="form">
				<form method="get" action="results.php" enctype="multipart/form-data">
					<input type="text" name="user_query" placeholder="Seacrh a product">
					<input type="submit" name="search" value="Serach" >
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
						<b style="padding-left: 2px;">Shopping Cart </b>Total Items:<?php total_items(); ?> <a href="cart.php">Go to cart</a>
					</span>
				</div>
				<div id="products_box">
					<?php

						if(isset($_GET['pro_id']))
						{
							$product_id = $_GET['pro_id'];
							$get_pro = "select * from products where product_id = $product_id";
							$run_pro = mysqli_query($conn, $get_pro);

							while($row_pro = mysqli_fetch_array($run_pro))
							{
								$pro_id = $row_pro['product_id'];
								$pro_title = $row_pro['product_title'];
								$pro_price = $row_pro['product_price'];
								$pro_image = $row_pro['product_image'];
								$pro_desc = $row_pro['product_desc'];

								echo "
									<div id='single_product'>
										<h3>$pro_title</h3>
										<img src='admin_area/product_images/$pro_image'/>
										<p><b>Price: $ $pro_price</b></p>
										<h5>$pro_desc</h5>
										<a href='index.php' style='float:left'>Go Back</a>
										<a href='index.php?add_cart=$pro_id'><button sytle='float:right'>Add To Card</button></a>
									</div>
								";
							}
						}
					?>
				</div>
			</div>
		</div>
		
		<div id="footer"><h2>&copy; 2020</h2></div>
	
	</div>

</body>
</html>