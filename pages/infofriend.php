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
                            <i class="fa fa-clipboard fa-fw"></i> Personal Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php 
								$userid = $_GET['id'];
								$member_id = $_SESSION['member_id'];
								$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$userid'")or die(mysqli_error());
								$rows = mysqli_fetch_array($hu_u);
								$sql = mysqli_query($con,"SELECT * FROM friends WHERE (member_id = '$member_id' AND friends_with = '$userid' AND status='c') OR (member_id = '$userid' AND friends_with = '$member_id' AND status='c')")or die(mysqli_error());
								$num_sql = mysqli_num_rows($sql);
							?>
							<ul class="chat">
                                <li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="../image/members/<?php echo $rows['photo'];?>" alt="User Avatar" class="" width="40" height="40"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"><?php echo $rows['firstname']." ".$rows['lastname'];?></strong>
                                        </div>
                                    </div>
                                </li>
								<?php
								if($_SESSION['login'] == 'admingroup'){
								?>
								<li>Email:<span class="pull-right"><?php echo $rows['url'];?></span></li>
								<li>Birthdate:<span class="pull-right"><?php echo $rows['birthdate'];?></span></li>
								<li>Gender:<span class="pull-right"><?php echo $rows['gender'];?></span></li>
								<li>School Graduated:<span class="pull-right"><?php echo $rows['gradschool'];?></span></li>
								<li>School Year:<span class="pull-right"><?php echo $rows['gradyear'];?></span></li>
								<li>Contact:<span class="pull-right"><?php echo $rows['contact'];?></span></li>
								<li>Unit:<span class="pull-right"><?php echo $rows['unit'];?></span></li>
								<li>Position:<span class="pull-right"><?php echo $rows['position'];?></span></li>
								<?php
								}elseif ($num_sql != 0){
								?>
								<li>Email:<span class="pull-right"><?php echo $rows['url'];?></span></li>
								<li>Birthdate:<span class="pull-right"><?php echo $rows['birthdate'];?></span></li>
								<li>Gender:<span class="pull-right"><?php echo $rows['gender'];?></span></li>
								<li>School Graduated:<span class="pull-right"><?php echo $rows['gradschool'];?></span></li>
								<li>School Year:<span class="pull-right"><?php echo $rows['gradyear'];?></span></li>
								<li>Contact:<span class="pull-right"><?php echo $rows['contact'];?></span></li>
								<li>Unit:<span class="pull-right"><?php echo $rows['unit'];?></span></li>
								<li>Position:<span class="pull-right"><?php echo $rows['position'];?></span></li>
								<?php
								}else{
								?>
								<li>Unit:<span class="pull-right"><?php echo $rows['unit'];?></span></li>
								<li>Position:<span class="pull-right"><?php echo $rows['position'];?></span></li>
								<?php
								}
								?>
                            </ul>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
</body>
</html>

