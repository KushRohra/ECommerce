<?php

	if(!isset($_SESSION['user_email']))
	{
		echo "<script>window.open('login.php?not_admin=You are not an Admin!', '_self')</script>";
	}
	else
	{

?>

<div style="width: 807px; margin-left: 10px; background: #187eae;">
	<form action="" method="post" style="padding: 20px;">

		<b style="margin: 15px;"> Insert New Brand: </b>
		<br>
		<input style="margin: 15px; border: 4px orange groove;" type="text" name="new_brand" required>
		<br>
		<input style="margin: 20px; border: 3px skyblue groove;" type="submit" name="add_brand" value="Add Brand">

	</form>	
</div>

<?php

	include("includes/db.php");
	if(isset($_POST['add_brand']))
	{
		$new_brand = $_POST['new_brand'];
		$insert_brand = "insert into brands(brand_title) values('$new_brand')";
		$run_brand = mysqli_query($conn, $insert_brand);
		if($run_brand)
		{
			echo "<script>alert('A new Brand has been inserted')</script>";
			echo "<script>window.open('index.php?view_brands', '_self')</script>";
		}
	}

?>

<?php } ?>