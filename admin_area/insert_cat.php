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

		<b style="margin: 15px;"> Insert New category: </b>
		<br>
		<input style="margin: 15px; border: 4px orange groove;" type="text" name="new_cat" required>
		<br>
		<input style="margin: 20px; border: 3px skyblue groove;" type="submit" name="add_cat" value="Add Category">

	</form>	
</div>

<?php

	include("includes/db.php");
	if(isset($_POST['add_cat']))
	{
		$new_cat = $_POST['new_cat'];
		$insert_cat = "insert into categories(cat_title) values('$new_cat')";
		$run_cat = mysqli_query($conn, $insert_cat);
		if($run_cat)
		{
			echo "<script>alert('A new category has been inserted')</script>";
			echo "<script>window.open('index.php?view_cats', '_self')</script>";
		}
	}
	else
	{
		echo mysqli_error($conn);
	}

?>
<?php } ?>