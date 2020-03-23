<?php

	include("includes/db.php");
	if(isset($_GET['edit_brand']))
	{
		$get_brand_id = $_GET['edit_brand'];
		$get_brand = "select * from brands where brand_id='$get_brand_id'";
		$run_brand = mysqli_query($conn, $get_brand);
		$row_brand = mysqli_fetch_array($run_brand);

		$brand_id = $row_brand['brand_id'];
		$brand_title = $row_brand['brand_title'];
	}

?>

<div style="width: 807px; margin-left: 10px; background: #187eae;">
	<form action="" method="post" style="padding: 20px;">

		<b style="margin: 15px;"> Update Brand: </b>
		<br>
		<input style="margin: 15px; border: 4px orange groove;" type="text" name="new_brand" value="<?php echo $brand_title; ?>">
		<br>
		<input style="margin: 20px; border: 3px skyblue groove;" type="submit" name="update_brand" value="Update Brand">

	</form>	
</div>

<?php

	if(isset($_POST['update_brand']))
	{
		$update_id = $brand_id;
		$new_brand = $_POST['new_brand'];
		$update_brand = "update brands set brand_title='$new_brand' where brand_id='$update_id'";
		$run_brand = mysqli_query($conn, $update_brand);
		if($run_brand)
		{
			echo "<script>alert('A Brand has been updated')</script>";
			echo "<script>window.open('index.php?view_brands', '_self')</script>";
		}
	}
	else
	{
		echo mysqli_error($conn);
	}

?>