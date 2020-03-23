<h2 style="text-align: center;">Do you really want to <strong>DELETE</strong> your account</h2>

<form method="post" action="">
	<br>
	<input type="submit" name= "yes" value="YES">
	<br>
	<br>
	<input type="submit" name="no" value="NO">	
</form>

<?php

	include("includes/db.php");
	$user = $_SESSION['customer_email'];

	if(isset($_POST['yes']))
	{
		$delete_customer = "delete from customers where customer_email='$user'";
		$run_delete = mysqli_query($conn, $delete_customer);
		echo "<script>alert('Your account has been deleted!')</script>";
		echo "<script>window.open('../index.php', '_self')</script>";
	}
	if(isset($_POST['no']))
	{
		echo "<script>window.open('my_account.php', '_self')</script>";
	}

?>