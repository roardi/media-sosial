<?php
session_start();
require('function.php');
require('connection.php');

if(isset($_POST['login'])){
		
	$username = $_POST['studid'];	
	$pass = $_POST['password'];

	$query2 = mysqli_query($con, "SELECT * FROM members WHERE username = '$username' AND password = '$pass' ") or die (mysqli_error());

	while($studid = mysqli_fetch_object($query2))
		{
		//echo "$studid->member_id";
		}
		$numberOfRows = mysqli_num_rows($query2);
		if ($numberOfRows == 0){
			$sql = "SELECT * FROM admin WHERE username='$username' and password='$pass'";
			$result=mysqli_query($con,$sql)or die(mysqli_error());
			$getid = mysqli_fetch_array($result);
			$count=mysqli_num_rows($result);
			if ($count==1){
				$_SESSION['login'] = 'admin';
				$_SESSION['member_id'] = $getid['admin_id'];
				header("location: adminhome.php");
			}
			else {
				$sql = "SELECT * FROM admingroup WHERE username='$username' and password='$pass'";
				$result=mysqli_query($con,$sql)or die(mysqli_error());
				$getid = mysqli_fetch_array($result);
				$count=mysqli_num_rows($result);
				if ($count==1){
					$_SESSION['login'] = 'admingroup';
					$_SESSION['member_id'] = $getid['admingroup_id'];
					header("location: grouphome.php");}
			}
		}
		else if ($numberOfRows > 0){
			$wewness = mysqli_query($con,"SELECT * FROM members WHERE username = '$username'")or die(mysqli_error());
			$getid = mysqli_fetch_array($wewness);
			if($getid['account_status']==0){
				$_SESSION['login'] = 'maybe';
				$_SESSION['member_id'] = $getid['member_id'];
				//$_SESSION['memberid'] = $getid['member_id'];
				header('location:registerexec.php');
			}elseif($getid['account_status']==2){
				$_SESSION['login'] = 'true';
				$_SESSION['member_id'] = $getid['member_id'];
				//$_SESSION['studentid'] = $getid['student_id'];
				header('location:home.php');
			
			}elseif($getid['account_status']==1){
				$_SESSION['login'] = 'maybe';
				$_SESSION['member_id'] = $getid['member_id'];
				//$_SESSION['studentid'] = $getid['student_id'];
				header('location:fill.php');
			
			}
		}
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
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" name="loginForm" method="post" action="">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="studid" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input name="login" type="submit" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
						<a href="signup.php">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
