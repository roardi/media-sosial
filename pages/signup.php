<?php
session_start();
require('function.php');
require('connection.php');
	$v_username= "";
 	$v_firstname = "";
	$v_lastname = "";
	$v_password = "";
	$v_passwordRetype = "";
	$v_email= "";
	$v_gender = "";
	
	
	/***********/
	$username = "";
	$firstname = "";
	$lastname = "";
	$password = "";
	$passwordRetype = "";
	$email = "";
	$gender = "";
	

if (isset($_POST['register'])){
$username = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$password = $_POST['password'];
$passwordRetype = $_POST['passwordRetype'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$pattern = "/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i";

//validation start
	if ($firstname=="") {
		$v_firstname	= "<font color='red'>Required Field <br /> </font>";
		$error = "has-error";
	} else
		{
		$v_firstname	= "";$error = "";
		}
	if ($lastname=="") {
		$v_lastname= "<font color='red'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_lastname= "";$error = "";
	}
	if ($password=="") {
		$v_password= "<font color='red'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_password= "";$error = "";
	}	
	if ($password!=$passwordRetype) {
		$v_passwordRetype= "<font color='red'>Password did not match! <br /> </font>";
		$error = "has-error";
	} else {
		$v_passwordRetype= "";$error = "";
	}			
	if ($gender=="") {
		$v_gender= "<font color='red'>Required Field <br /> </font>";
	} else {
		$v_gender= "";
	}
	if ($email=="") {
		$v_email= "<font color='red'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_email= "";$error = "";
	}
	if ($username=="") {
		$v_username= "<font color='red'>Required Field <br /> </font>";
		$error = "has-error";
	} else {
		$v_username= "";$error = "";
	}
	
	
	if ($firstname!="" && $lastname!= "" && $password == $passwordRetype && $username!= "" && $email!= "" && $gender!= ""){
	
	$checkme=mysqli_query($con,"SELECT * FROM members WHERE username = '$username'") or die(mysqli_error());
	$checkmyid=mysqli_num_rows($checkme);
		if($checkmyid > 0){
			header("location:checkid.php");
		}else{
	
			mysqli_query($con,"INSERT INTO members (username, password, firstname, lastname, url, gender, status_id,account_status)
			VALUES ('$username','$password','$firstname','$lastname','$email','$gender','0','1')")or die(mysqli_error());
			echo $username;
			$wewness = mysqli_query($con,"SELECT * FROM members WHERE username = '$username'")or die(mysqli_error());
			$getid = mysqli_fetch_array($wewness);
			$_SESSION['member_id'] = $getid['member_id'];
			$_SESSION['login'] = 'maybe';
			//$_SESSION['member_id'] = $member_id;
			header("location:fill.php");
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
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" name="registerForm" method="post" action="">
                            <fieldset>
								<div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="First name" name="firstname" type="text">
									<label class="control-label" for="inputError"><?php echo $v_firstname;?></label>
                                </div>
								<div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="Last Name" name="lastname" type="text">
									<label class="control-label" for="inputError"><?php echo $v_lastname;?></label>
                                </div>
								<div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="Username" name="username" type="text">
									<label class="control-label" for="inputError"><?php echo $v_username;?></label>
                                </div>
                                <div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text">
									<label class="control-label" for="inputError"><?php echo $v_email;?></label>
                                </div>
                                <div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
									<label class="control-label" for="inputError"><?php echo $v_password;?></label>
                                </div>
								<div class="form-group <?php echo $error;?>">
                                    <input class="form-control" placeholder="Retype Password" name="passwordRetype" type="password" value="">
									<label class="control-label" for="inputError"><?php echo $v_passwordRetype;?></label>
                                </div>
								<div class="form-group">
									<select class="form-control" name="gender">
										<option>Male</option>
										<option>Female</option>
									</select>
								</div>
                                <input name="register" type="submit" class="btn btn-lg btn-success btn-block" value="Register">
                            </fieldset>
                        </form>
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
