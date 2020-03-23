<?php

//Connect the database
$conn = mysqli_connect("localhost", "root", "", "ecommerce");
//errror message if database is not connected
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: ".mysqli_connect_errno();
}

//Get Ip addr of user
function getIp()
{
	$ip = $_SERVER['REMOTE_ADDR'];

	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	return $ip;
}

function cart()
{
	if(isset($_GET['add_cart']))
	{
		global $conn;
		$ip = getIp();
		$pro_id = $_GET['add_cart'];

		//Checking if the product has already added by the user or not
		$check_pro = "select * from cart where ip_add='$ip' AND p_id='$pro_id'";
		$run_check = mysqli_query($conn, $check_pro);
		if(mysqli_num_rows($run_check)>0)
		{
			/*echo "";
			*/
			$p_qty = mysqli_fetch_array($run_check);
			$qty1 = $p_qty['qty'] + 1;
			$update_qty = "update cart set qty='$qty1' where ip_add='$ip' AND p_id='$pro_id'";
			$run_update = mysqli_query($conn, $update_qty);
			echo "";
			/**/
		}
		else
		{
			$qty1  = 1;
			$insert_pro = "insert into cart(p_id, ip_add, qty) values('$pro_id', '$ip', '$qty1')";;
			$run_pro = mysqli_query($conn, $insert_pro);
			echo "<script>window.open('index.php', '_self')</script>";
		}
	}
}

//Getting the total added items
function total_items()
{
	global $conn;
	if(isset($_GET['add_cart']))
	{
		$ip = getIp();
		$get_items = "select * from cart where ip_add='$ip'";
		$run_items = mysqli_query($conn, $get_items);
		$count_items = mysqli_num_rows($run_items);
	}
	else
	{
		$ip = getIp();
		$get_items = "select * from cart where ip_add='$ip'";
		$run_items = mysqli_query($conn, $get_items);
		$count_items = mysqli_num_rows($run_items); 
	}
	echo $count_items;
}

//Getting total price of the items in the cart
function total_price()
{
	$total = 0;
	global $conn;
	$ip = getIp();
	$sel_price = "select * from cart where ip_add='$ip'";
	$run_price = mysqli_query($conn, $sel_price);
	while($p_price  = mysqli_fetch_array($run_price))
	{
		$pro_id = $p_price['p_id'];
		$pro_price = "select * from products where product_id='$pro_id'";
		$run_pro_price = mysqli_query($conn, $pro_price);
		while($pp_price = mysqli_fetch_array($run_pro_price))
		{
			$product_price = array($pp_price['product_price']);
			$values = array_sum($product_price);
			$total = $total + $values;
		}
	}
	echo "$".$total;
}

//getting the categories 
function getCats()
{
	global $conn;
	$get_cats = "select * from categories";
	$run_cats = mysqli_query($conn, $get_cats);

	while($row_cats = mysqli_fetch_array($run_cats))
	{
		$cat_id = $row_cats['cat_id'];
		$cat_title = $row_cats['cat_title'];
		echo "<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";
	}
}

//getting the brands 
function getBrands()
{
	global $conn;
	$get_brands = "select * from brands";
	$run_brands = mysqli_query($conn, $get_brands);

	while($row_brands = mysqli_fetch_array($run_brands))
	{
		$brands_id = $row_brands['brand_id'];
		$brands_title = $row_brands['brand_title'];
		echo "<li><a href='index.php?brand=$brands_id'>$brands_title</a></li>";
	}
}

function getPro()
{
	if(!isset($_GET['cat']))
	{
		if(!isset($_GET['brand']))
		{
			global $conn;
			$get_pro = "select * from products order by RAND() LIMIT 0,8";
			$run_pro = mysqli_query($conn, $get_pro);

			while($row_pro = mysqli_fetch_array($run_pro))
			{
				$pro_id = $row_pro['product_id'];
				$pro_cat = $row_pro['product_cat'];
				$pro_brand = $row_pro['product_brand'];
				$pro_title = $row_pro['product_title'];
				$pro_price = $row_pro['product_price'];
				$pro_image = $row_pro['product_image'];

				echo "
					<div id='single_product'>
						<h3>$pro_title</h3>
						<img src='admin_area/product_images/$pro_image' width='135px' height='160px' />
						<p><b>Price: $ $pro_price</b></p>
						<a href='details.php?pro_id=$pro_id' style='float:left'>Details</a>
						<a href='index.php?add_cart=$pro_id'><button sytle='float:right'>Add To Card</button></a>
					</div>
				";
			}
		}
	}
}

function getCatPro()
{
	if(isset($_GET['cat']))
	{
		$cat_id = $_GET['cat'];
		global $conn;
		$get_cat_pro = "select * from products where product_cat = $cat_id";
		$run_cat_pro = mysqli_query($conn, $get_cat_pro);

		$count_cat = mysqli_num_rows($run_cat_pro);
		if($count_cat == 0)
		{
			echo "<h2 style='padding: 20px;'>There is no product in this category</h2>";
			exit();
		}
		while($row_cat_pro = mysqli_fetch_array($run_cat_pro))
		{
			$pro_id = $row_cat_pro['product_id'];
			$pro_cat = $row_cat_pro['product_cat'];
			$pro_brand = $row_cat_pro['product_brand'];
			$pro_title = $row_cat_pro['product_title'];
			$pro_price = $row_cat_pro['product_price'];
			$pro_image = $row_cat_pro['product_image'];

			
			echo "
				<div id='single_product'>
					<h3>$pro_title</h3>
					<img src='admin_area/product_images/$pro_image' width='135px' height='160px' />
					<p><b>Price: $ $pro_price</b></p>
					<a href='details.php?pro_id=$pro_id' style='float:left'>Details</a>
					<a href='index.php?add_cart=$pro_id'><button sytle='float:right'>Add To Card</button></a>
				</div>
			";
		}
	}
}

function getBrandPro()
{
	if(isset($_GET['brand']))
	{
		$brand_id = $_GET['brand'];
		global $conn;
		$get_brand_pro = "select * from products where product_brand = $brand_id";
		$run_brand_pro = mysqli_query($conn, $get_brand_pro);

		$count_brand = mysqli_num_rows($run_brand_pro);
		if($count_brand == 0)
		{
			echo "<h2 style='padding: 20px;'>There is no product of this brand</h2>";
			exit();
		}
		while($row_brand_pro = mysqli_fetch_array($run_brand_pro))
		{
			$pro_id = $row_brand_pro['product_id'];
			$pro_cat = $row_brand_pro['product_cat'];
			$pro_brand = $row_brand_pro['product_brand'];
			$pro_title = $row_brand_pro['product_title'];
			$pro_price = $row_brand_pro['product_price'];
			$pro_image = $row_brand_pro['product_image'];

			
			echo "
				<div id='single_product'>
					<h3>$pro_title</h3>
					<img src='admin_area/product_images/$pro_image' width='135px' height='160px' />
					<p><b>Price: $ $pro_price</b></p>
					<a href='details.php?pro_id=$pro_id' style='float:left'>Details</a>
					<a href='index.php?add_cart=$pro_id'><button sytle='float:right'>Add To Card</button></a>
				</div>
			";
		}
	}
}

function getCountry()
{
	global $conn;
	$get_country = "select * from countries";
	$run_country = mysqli_query($conn, $get_country);

	while($row_country = mysqli_fetch_array($run_country))
	{
		$country_id = $row_country['country_id'];
		$country_title = $row_country['country_name'];
		echo "<option>$country_title</option>";
	}
}

?>