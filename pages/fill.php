<?php
	session_start();
	include("connection.php");
	include("function.php");
	
	if($_SESSION['login'] != 'maybe'){
		header("location:index.php");
	}
	$v_unit="";
	$v_position="";
	
	if (isset($_POST['insert'])){
	
	$file_name = $_POST['cantseeme'];
	$contact = $_POST['contact'];
	$status = $_POST['status'];
	$bday = ($_POST['Month']).'-'.($_POST['Day']).'-'.($_POST['Year']); 
	$gradschool = $_POST['gradschool'];
	$gradyear = $_POST['gradyear'];
	$unit = $_POST['unit'];
	$position = $_POST['position'];
				
	$member=$_SESSION['member_id'];	
	if ($unit=="") {
		$v_unit= "<font color='red' size='2'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_unit= "";$error = "";
	}
	if ($position=="") {
		$v_position= "<font color='red' size='2'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_position= "";$error = "";
	}
	if ($unit!="" && $position!=""){
	mysqli_query($con,"UPDATE members SET photo = '$file_name', contact = '$contact', relationship = '$status',birthdate = '$bday', gradschool = '$gradschool', gradyear = '$gradyear', unit = '$unit', position = '$position', account_status = 2 WHERE member_id = '$member'") or die(mysqli_error());
	
	$_SESSION['login'] = 'true';
	header("Location:home.php");}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BPS Social Media</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
				<img src="../images/header4.png" class="col-xs-12 col-lg-12"></image>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!--<a class="navbar-brand" href="index.php">BPS Social Media</a>-->
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right" >
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->
			
            <div class="navbar-default sidebar" role="navigation" style="margin-top:;">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li style="margin-top:10px;">
                            <a href="#"><i class="fa fa-home fa-fw"></i>Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Profil<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
									$member_id = $_SESSION['member_id'];
									$post = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$member_id'")or die(mysqli_error());
									$row = mysqli_fetch_array($post); ?>
									<p align='center'><?php echo $row['firstname']." ".$row['lastname'];?></p>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
			    <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>More informations of you</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="col-lg-9">
								Upload your photos and make it as your primary picture so that friends may recognize you.<br><br>
								Select an image file on your computer (4MB max):<br><br>
								<form method="post" name="upload" enctype='multipart/form-data'>
									<input type="file" name="image"><br>
									<input type="submit" name="Submit" value="Upload" />
								</form>
								<?php
									if (isset($_POST['Submit'])){
										$member=$_SESSION['member_id'];
										
										$name = $_FILES["image"] ["name"];
										$type = $_FILES["image"] ["type"];
										$size = $_FILES["image"] ["size"];
										$temp = $_FILES["image"] ["tmp_name"];
										$error = $_FILES["image"] ["error"];
										if($name!=""){
											mysqli_query($con,"INSERT INTO upload(member_id,file_name,datetime) 
																VALUES ('$member','$name',NOW())") or die(mysqli_error());
											echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>Your photo has been successfully uploaded!!!</font><br>";
											if ($error > 0){
												die("<font size='2'>Error uploading file! Code $error.</font>");
											}else{
												if($size > 10000000) //conditions for the file
												{
												die("<font size='2'>Format is not allowed or file size is too big!</font>");
												}
												else
												{
												move_uploaded_file($temp,"../image/members/".$name);
												}
											}
										}else{
											die("<font size='2'>There is no file to upload<font>");
										}
									}
								?>
							</div>
							<div class="col-lg-12">
								
									<form name="insert" method="post">
										<?php 
										$id = $_SESSION['member_id'];
										$query = mysqli_query($con,"SELECT * FROM upload WHERE member_id = '$id'")or die(mysqli_error());
										$row_result = mysqli_num_rows($query);
										if($row_result > 0){
											$msg = '<div>';
											$row = mysqli_fetch_array($query);
											$fname = $row['file_name'];
											
											$msg .= '<span style="float:left;padding:10px;"><img src="../image/members/'. $fname .'" width="100" height="100"/></span>';
											$msg .= '</div>'; 
											echo $msg;
										?>
											<input type='hidden' value='<?php echo $fname;?>' name='cantseeme'/>														
										<?php
										}else{
											echo '<div style="margin:10px"><font size="2">No Photos Uploaded</font></div>';
											
										}
										?>
										<p align="center"><strong>More basic informations about you </strong></p>
										
											<table align="center">
                                            <tr><td width="200"><font size="2">Unit:</td>
                                            <td><div class="form-group <?php echo $error;?>">
												<input name="unit" class="form-control" placeholder="Unit">
												<?php echo $v_unit;?></div>
											</td></tr>
											<tr><td width="200"><font size="2">Position:</td>
                                            <td><div class="form-group <?php echo $error;?>">
												<input name="position" class="form-control" placeholder="Position">
												<?php echo $v_position;?></div>
											</td></tr>
											<tr><td width="200"><font size="2">Status:</td>
                                            <td><div class="form-group">
												<select name="status" class="form-control">
													<option>Single</option>
													<option>In a relationship</option>
													<option>Engaged</option>
													<option>Married</option>
													<option>Divorced</option>
													<option>Widowed</option>
												</select><div>
											</td></tr>
											<tr><td width="200"><font size="2">Birthdate:</td>
											<td><div class="form-group">
												<select name="Day" width="20" class="form-control">
												<?php
													$day_bd=1;
													while($day_bd<=31)
														{
												?>
													<option><?php echo $day_bd; ?></option>
														<?php $day_bd++; } ?>
												</select>
												<select name="Month" width="30" class="form-control">
													<option>January</option>
													<option>February</option>
													<option>March</option>
													<option>April</option>
													<option>May</option>
													<option>June</option>
													<option>July</option>
													<option>August</option>
													<option>September</option>
													<option>October</option>
													<option>November</option>
													<option>December</option>
												</select>
												<select name="Year" class="form-control">
												<?php
													$year_bd=1965;
													while($year_bd<=2016)
														{
												?>
													<option><?php echo $year_bd; ?></option>
														<?php $year_bd++; } ?>
												</select></div>
											</td></tr>
											<tr><td width="200"><font size="2">Contact No.:</td>
											<td><div class="form-group">
												<input name="contact" class="form-control" placeholder="Contact">
											</div></td></tr>
											<tr><td width="200"><font size="2">School Graduated:</td>
											<td><div class="form-group">
												<input name="gradschool" class="form-control" placeholder="Graduated">
											</div></td></tr>
											<tr><td width="150"><font size="2">Year Graduated:</td>
											<td><div class="form-group">
												<select name="gradyear" class="form-control">
												<?php
													$year_bd=1985;
													while($year_bd<=2016)
														{
												?>
													<option><?php echo $year_bd; ?></option>
													<?php $year_bd++; } ?></select>
											</div></td></tr>
											</table>
											<br>
											<div class="col-lg-3" style="margin-left:300px;"><input name="insert" type="submit" class="btn btn-lg btn-success btn-block" value="Save"></div>
                                        
									</form>
								
							</div>
							<!-- /.panel-footer -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                    <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                    <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                    <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-money fa-fw"></i> Payment Received
                                    <span class="pull-right text-muted small"><em>Yesterday</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Chat
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu slidedown">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-refresh fa-fw"></i> Refresh
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-check-circle fa-fw"></i> Available
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-times fa-fw"></i> Busy
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-clock-o fa-fw"></i> Away
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-sign-out fa-fw"></i> Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
