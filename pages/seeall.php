<?php
	session_start();
	include("connection.php");
	include("function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BPS Social Media</title>

	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
			    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-thumbs-up fa-fw"></i> Post Like
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php
								$grouppostid = $_GET['id'];
								$id = $_SESSION['member_id'];
								$query2 = mysqli_query($con,"SELECT * FROM grouppostlike WHERE grouppost_id = '$grouppostid' AND member_id = '$id'") or die (mysqli_error());
								$numberOfRows = mysqli_NUM_ROWS($query2);
								if ($numberOfRows == 0){
									mysqli_query($con,"INSERT INTO grouppostlike(grouppost_id,member_id) VALUES('$grouppostid','$id') ")or die(mysqli_error());
								}else{
									$post = mysqli_query($con,"SELECT * FROM grouppostlike WHERE grouppost_id = '$grouppostid'")or die(mysqli_error());
									echo "<ul>";
									while ($row = mysqli_fetch_array($post)){
										$id = $row['member_id'];
										$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
										$numrow = mysqli_NUM_ROWS($hu_u);
										if ($numrow == 0){
											$hu_u = mysqli_query($con,"SELECT * FROM groups WHERE group_id = '$id'")or die(mysqli_error());
											$rows = mysqli_fetch_array($hu_u);
											echo "<li><img src='../image/groups/".$rows['photo']."' width='50' height ='50' alt=''/>  ".$rows['group_name']."</li>";
										}else{
											$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
											$rows = mysqli_fetch_array($hu_u);
											echo "<li><img src='../image/members/".$rows['photo']."' width='50' height ='50' alt=''/>  ".$rows['firstname']."".$rows['lastname']."</li>";
										}
									}
									echo "</ul>";
								}
							?>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
</body>
</html>

