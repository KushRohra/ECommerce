<?php

	include("includes/db.php");
	if(isset($_GET['edit_cat']))
	{
		$get_cat_id = $_GET['edit_cat'];
		$get_cat = "select * from categories where cat_id='$get_cat_id'";
		$run_cat = mysqli_query($conn, $get_cat);
		$row_cat = mysqli_fetch_array($run_cat);

		$cat_id = $row_cat['cat_id'];
		$cat_title = $row_cat['cat_title'];
	}

?>

<div style="width: 807px; margin-left: 10px; background: #187eae;">
	<form action="" method="post" style="padding: 20px;">

		<b style="margin: 15px;"> Update category: </b>
		<br>
		<input style="margin: 15px; border: 4px orange groove;" type="text" name="new_cat" value="<?php echo $cat_title; ?>">
		<br>
		<input style="margin: 20px; border: 3px skyblue groove;" type="submit" name="update_cat" value="Update Category">

	</form>	
</div>

<?php

	if(isset($_POST['update_cat']))
	{
		$update_id = $cat_id;
		$new_cat = $_POST['new_cat'];
		$update_cat = "update categories set cat_title='$new_cat' where cat_id='$update_id'";
		$run_cat = mysqli_query($conn, $update_cat);
		if($run_cat)
		{
			echo "<script>alert('A category has been updated')</script>";
			echo "<script>window.open('index.php?view_cats', '_self')</script>";
		}
	}
	else
	{
		echo mysqli_error($conn);
	}

?>