<?php
	session_start();
	include("connection.php");
	include("function.php");
	if($_SESSION['login'] != 'true'){
		header("location:index.php");
	}
	$id = $_SESSION['member_id'];
		if(isset($_POST['share'])){
			$post = $_POST['textarea'];
			if ($post !=""){
			mysqli_query($con,"INSERT INTO posts(member_id,posts,date) VALUE ('$id','$post',NOW())") or die(mysqli_error());}
		}
		if(isset($_POST['comment'])){
			$comment = $_POST['textarea'];
			$postid = $_POST['ucantseeme'];
			if ($comment !=""){
			mysqli_query($con,"INSERT INTO postcomments(post_id,member_id,date,comment) VALUE ('$postid','$id',NOW(),'$comment')")or die(mysqli_error());}
		}
		if(isset($_POST['uploadfile'])){
			$post = $_POST['textarea'];
			$name = $_FILES["file"] ["name"];
			$type = $_FILES["file"] ["type"];
			$size = $_FILES["file"] ["size"];
			$temp = $_FILES["file"] ["tmp_name"];
			$error = $_FILES["file"] ["error"];
			if($name!=""){
				mysqli_query($con,"INSERT INTO upload(member_id,file_name,datetime) 
									VALUES ('$id','$name',NOW())") or die(mysqli_error());
				//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>Your photo/video has been successfully uploaded!!!</font><br>";
				if ($error > 0){
					die("<font size='2'>Error uploading file! Code $error.</font>");
				}else{
					if($size > 100000000) //conditions for the file
					{
					die("<font size='2'>Format is not allowed or file size is too big!</font>");
					}
					else
					{
					move_uploaded_file($temp,"../image/files/".$name);
					mysqli_query($con,"INSERT INTO posts(member_id,posts,file,date) VALUE ('$id','$post','$name',NOW())") or die(mysqli_error());
					}
				}
			}else{
				die("<font size='2'>There is no file to upload<font>");
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

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<link href="../facebox1.2/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="../facebox1.2/src/facebox.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(" a[rel*=facebox]" ).facebox({
					loadingImage : " ../facebox1.2/src/loading.gif" ,
					closeImage   : " ../facebox1.2/src/del.jpg" 
				})
			})
			
	</script>
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
            <?php
			include "memberbar.php";
			?>
			
            <div class="navbar-default sidebar" role="navigation" style="margin-top:;">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li style="margin-top:10px;">
                            <a href="home.php"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Groups<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
								$member_id=$_SESSION['member_id'];							
								$post1 = mysqli_query($con,"SELECT * FROM groupmembers WHERE member_id = '$member_id' AND status='1' ")or die(mysqli_error());
								$num_rows  =mysqli_num_rows($post1);
								if ($num_rows != 0 ){
									while($rows = mysqli_fetch_array($post1)){
										$mygroup = $rows['group_id'];
										$group = mysqli_query($con,"SELECT * FROM groups WHERE group_id = '$mygroup'")or die(mysqli_error());
										$row = mysqli_fetch_array($group);
										echo '<li><a href=groups.php?id='.$row["group_id"].' style = "text-decoration:none;"><img src="../image/groups/'. $row['photo'].'" height="30" width="30" align="center">'." ".$row['group_name'].' </a></li>';
									}
								}else{
									echo 'You don\'t have groups </li>';
								}
								?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Friends<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
								$member_id=$_SESSION['member_id'];							
								$post = mysqli_query($con,"SELECT * FROM friends WHERE (friends_with = '$member_id' OR member_id = '$member_id') AND status = 'c' ")or die(mysqli_error());
								$num_rows  =mysqli_num_rows($post);
								if ($num_rows != 0 ){
									while($row = mysqli_fetch_array($post)){
									$myfriend = $row['member_id'];
									$member_id=$_SESSION['member_id'];
										if($myfriend == $member_id){
											$myfriend1 = $row['friends_with'];
											$friends = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$myfriend1'")or die(mysqli_error());
											$friendsa = mysqli_fetch_array($friends);
											echo '<li> <a href=myfriendsprofile.php?id='.$friendsa["member_id"].' style="text-decoration:none;"><img src="../image/members/'. $friendsa['photo'].'" height="30" width="30" align="center">'.$friendsa['firstname'].' '.$friendsa['lastname'].' </a> </li>';
										}else{
											$myfriend1 = $row['member_id'];
											$friends = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$myfriend1'")or die(mysqli_error());
											$friendsa = mysqli_fetch_array($friends);
											echo '<li> <a href=myfriendsprofile.php?id='.$friendsa["member_id"].' style = "text-decoration:none;"><img src="../image/members/'. $friendsa['photo'].'" height="30" width="30" align="center">'.$friendsa['firstname'].' '.$friendsa['lastname'].' </a></li>';
										}
								}
								}else{
									echo 'You don\'t have friends </li>';
								}
								?>
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
                            <strong><font size="2">Share your thought</font></strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="col-lg-3">
							<?php
								$member_id = $_SESSION['member_id'];
								$sql=mysqli_query($con,"SELECT * FROM members WHERE member_id='$member_id'") or die(mysqli_error());
								$row = mysqli_fetch_array($sql); 
								echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='../image/members/".$row['photo']."'width='120px' height='120px'>";
							?>
							</div>
						<div class="col-lg-4">
                            <div class="input-group">
								<?php
									echo "<a href='userprofiletest.php?id=$member_id'>".$row['firstname']." ".$row['lastname']."</a>";
								?>
								<form method="post" action="" enctype='multipart/form-data'>
								<div style="float:right;"><textarea name="textarea" class="form-control input-sm" style="width: 480px; height: 80px; margin-top: 10px;" placeholder="Share your thought here..." ></textarea></div>
								<div style="float:right;"><span class="input-group-btn">
                                    <button name="share" class="btn btn-primary btn-sm" id="btn-chat">
                                        Share
                                    </button>
                                </span></div>
								</form>
								<div align='left' style='margin-top:0px;'><a href='uploadfile.php?id="<?php echo $member_id;?>' rel='facebox' style='text-decoration:none;'>Upload File</a></div>
                            </div>
                        </div>
                        <!-- /.panel-footer -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Recent Posts
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php	
								$member_id=$_SESSION['member_id'];
								$poster = mysqli_query($con,"SELECT * FROM posts WHERE member_id = '$member_id' ORDER by date DESC LIMIT 0,5")or die(mysqli_error());
								while($row_post = mysqli_fetch_array($poster)){
								$id = $row_post['member_id']; 
								$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
								$rows = mysqli_fetch_array($hu_u);
								$iyaid = $row_post['post_id']; 
								$allcomm = mysqli_query($con,"SELECT * FROM postcomments WHERE post_id = '$iyaid'")or die(mysqli_error());
									$counters = 0;
									WHILE($stat = mysqli_fetch_array($allcomm)){
									$counters++;
								}
								$allcount = $counters;
								
								$all_like = mysqli_query($con,"SELECT * FROM postlike WHERE post_id = '$iyaid'")or die(mysqli_error());
									$counter = 0;
									WHILE($stat = mysqli_fetch_array($all_like)){
									$counter++;
								}
								$allcountlike = $counter;
								$postid = $row_post['post_id'];
							?>	
                            <ul class="chat">
                                <li class="left clearfix">
									<input type='hidden' value='<?php echo $row_post['post_id'];?>' name='cantseeme'/>
                                    <span class="chat-img pull-left">
                                        <img src="../image/members/<?php echo $rows['photo'];?>" alt="User Avatar" class="img-circle" width="40" height="40"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"><?php echo $rows['firstname']." ".$rows['lastname'];?></strong>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> <?php echo $row_post['date'];?>
                                            </small>
                                        </div>
                                        <p>
											<?php echo $row_post['posts'];?>
                                        </p>
										<?php
										echo"<hr /><div style='float:left; margin-top:-10px;'><a href='seeall.php?id=".$postid."' rel='facebox' style='text-decoration:none;'><i class='fa fa-thumbs-o-up'></i> (".$allcountlike.")</a></div>";
										echo"<div align='center' style=' margin-top:-10px;'><a href='comment.php?id=".$postid."' rel='facebox' style='text-decoration:none;'>Comments(".$allcount.")</a></div>";
										echo "<div style='float:right; margin-top:-15px;'><a href='deletepost.php?id=".$postid."' style='text-decoration:none;'>Delete</a></div>";
										?>
                                    </div>
                                </li>
                            </ul>
							<?php
								}
							?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-3">
                    <div class="panel panel-default">
						<div class="panel-heading">
                            <i class="fa fa-search fa-fw"></i> Search Groups or Friends
                        </div>
                        <!-- /.panel-heading -->
							<form name="search" method="post" action="search.php">
							<div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button name="search" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
								</span>
                            </div>
							</form>
                            <!-- /input-group -->
                    </div>
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-user-md fa-fw"></i> Friends you may know
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <ul class="chat">
                                    <?php
										$id = $_SESSION['member_id'];
										$sql = mysqli_query($con,"SELECT DISTINCT member_id FROM friends WHERE (member_id != '$id') AND (friends_with !='$id') ")or die(mysqli_error());
										while($rows = mysqli_fetch_array($sql)){
											$friends = $rows['member_id']; //echo $friends."<br>";
											$post = mysqli_query($con,"SELECT * FROM friends WHERE member_id='$friends' AND friends_with = '$id' ")or die(mysqli_error());
											$row = mysqli_fetch_array($post);
											if ($row==0){
												// $idf = $row['member_id']; echo $friends."<br>";
												$sql2 = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$friends' ")or die(mysqli_error());
												$rowfriends = mysqli_fetch_array($sql2);
												echo '
												<li>
													<p align="center"><a href="infofriend.php?id='.$rowfriends['member_id'].'" rel="facebox" style="text-decoration:none;" ><img src="../image/members/'.$rowfriends['photo'].'" alt="" height="50" width="50" border="0" class="left_bt" />
													</br>'.$rowfriends['firstname']." ".$rowfriends['lastname'].'
													</br><a href="addfriend.php?id='.$rowfriends['member_id'].'" rel="facebox" style="text-decoration:none;"  >Add as Friend</a></p>
												</li>';
												// }else{}
											}
										}
									?>
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
