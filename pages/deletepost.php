<?php
  require ("connection.php");  
?>  
	
<?php
	$id =$_GET['id'];
	mysqli_query ($con,"DELETE FROM postcomments WHERE post_id = '$id'")
	or die(mysqli_error());
	mysqli_query ($con,"DELETE FROM postlike WHERE post_id = '$id'")
	or die(mysqli_error());
	mysqli_query($con,"DELETE FROM posts WHERE post_id = '$id'")
	or die(mysqli_error());  	
	header("Location: home.php");
?>