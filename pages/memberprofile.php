<?php
	session_start();
	include("connection.php");
	include("function.php");
	if($_SESSION['login'] != 'admingroup'){
		header("location:index.php");
	}
	$id = $_SESSION['member_id'];
	$userid = $_GET['id'];
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
                            <a href="grouphome.php"><i class="fa fa-home fa-fw"></i>Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Profile<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <?php 
								$sql=mysqli_query($con,"SELECT * FROM members WHERE member_id='$userid'") or die(mysqli_error());
								$row=mysqli_fetch_array($sql);
								echo "<li><center><img src='../image/members/".$row['photo']."' width='130px' height='230px' alt='Image cannot be dispalyed'></center></li>";
								echo '<li><a href=memberprofile.php?id='.$userid.' style="text-decoration:none;">'.$row['firstname'].' '.$row['lastname'].'</a></li>';
								echo "<li><a href=infofriend.php?id=".$userid." rel='facebox' style='text-decoration:none;'>Info</a></li>";
								echo "<li><a href='#' style='text-decoration:none;'>Photos of ".$row['firstname']." ".$row['lastname']."</a></li>";
								echo "<li><a href='mails.php?id=".$userid." rel='facebox' style='text-decoration:none;'>Send a message</a></li>";
							?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $row['firstname'];?>'s Members<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
								$post = mysqli_query($con,"SELECT * FROM friends WHERE (friends_with = '$userid' OR member_id = '$userid') AND status = 'c' ")or die(mysqli_error());
								$num_rows  =mysqli_num_rows($post);
								if ($num_rows != 0 ){
									while($row = mysqli_fetch_array($post)){
										$myfriend = $row['member_id'];
										$member_id=$_SESSION['member_id'];
										if($myfriend == $userid){
											$myfriend1 = $row['friends_with'];
											$friends = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$myfriend1'")or die(mysqli_error());
											$friendsa = mysqli_fetch_array($friends);
											echo '<li> <a href=infofriend.php?id='.$friendsa["member_id"].' rel="facebox" style="text-decoration:none;"><img src="../image/members/'. $friendsa['photo'].'" height="30" width="30"> '.$friendsa['firstname'].' '.$friendsa['lastname'].' </a> </li>';
										}else{
											$myfriend1 = $row['member_id'];
											$friends = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$myfriend1'")or die(mysqli_error());
											$friendsa = mysqli_fetch_array($friends);
											echo '<li> <a href=infofriend.php?id='.$friendsa["member_id"].' rel="facebox" style = "text-decoration:none;"><img src="../image/members/'. $friendsa['photo'].'" height="30" width="30"> '.$friendsa['firstname'].' '.$friendsa['lastname'].' </a></li>';
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
                        <div class="panel-body">
							<?php
							$post = mysqli_query($con,"SELECT * FROM groups WHERE group_id = '$group_id'")or die(mysqli_error());
							$row = mysqli_fetch_array($post); 
							?>
                            <table>
								<tr><td width="100" height="30"><font size="2">Group Name:</font></td><td><font size="2"><strong><?php echo $row['group_name'];?></strong></td></tr> 
								<tr><td width="100" height="30"><font size="2">Description:</td><td><font size="2"><?php echo $row['info'];?></td></tr>
							</table>
                        </div>
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
								<div align='left' style='margin-top:0px;'><a href='uploadfile.php?id="<?php echo $admingroup_id;?>' rel='facebox' style='text-decoration:none;'>Upload File</a></div>
                            </div>
                        </div>
                        <!-- /.panel-footer -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Recent Group Posts
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php	
								if(isset($_POST['searchp'])){
									$search = $_POST['searchpost'];
									if ($search==""){
										$post = mysqli_query($con,"SELECT * FROM groupposts WHERE group_id = '$group_id' ORDER by date DESC")or die(mysqli_error());
										$result ="";
									}else{
										$post = mysqli_query($con,"SELECT * FROM groupposts WHERE posts LIKE '%$search%' AND group_id = '$group_id'ORDER by date DESC")or die(mysqli_error());
										if (mysqli_num_rows($post)==0){
											$result = "<strong><font color='red' size='2' >No result found!</font></strong>";
										}else{
											$result = "<strong><font size='2' >Search result</font></strong>";
									}}
								}else{
									$post = mysqli_query($con,"SELECT * FROM groupposts WHERE group_id = '$group_id' ORDER by date DESC")or die(mysqli_error());
									$result ="";
								}		
								echo $result;
								while($row = mysqli_fetch_array($post)){
								$id = $row['member_id']; 
								if ($id==$group_id){
									$hu_u = mysqli_query($con,"SELECT * FROM groups WHERE group_id = '$group_id'")or die(mysqli_error());
									$rows = mysqli_fetch_array($hu_u);
									$name = $rows['group_name'];
									$photo = "../image/groups/".$rows['photo'];
								}else{
									$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
									$rows = mysqli_fetch_array($hu_u);
									$name = $rows['firstname']." ".$rows['lastname'];
									$photo = "../image/members/".$rows['photo'];
								}
								$cekfile = $row['file'];
								if ($cekfile!=""){
									$msg = '<br><a href="../image/files/'. $cekfile .'" style="margin-left:-35px;"><img src="../image/files/'. $cekfile .'" width="100" height="100" align="center"/></a>';
								}
								else{
									$msg = "";
								}
								$iyaid = $row['grouppost_id'];
								$allcomm = mysqli_query($con,"SELECT * FROM grouppostcomments WHERE grouppost_id = '$iyaid'")or die(mysqli_error());
									$counters = 0;
									WHILE($stat = mysqli_fetch_array($allcomm)){
									$counters++;
								}
								$allcount = $counters;
								
								$all_like = mysqli_query($con,"SELECT * FROM grouppostlike WHERE grouppost_id = '$iyaid'")or die(mysqli_error());
									$counterss = 0;
									WHILE($stat = mysqli_fetch_array($all_like)){
									$counterss++;
								}
								$allcounts = $counterss;
							?>	
                            <ul class="chat">
                                <li class="left clearfix">
									<input type='hidden' value='<?php echo $row['grouppost_id'];?>' name='cantseeme'/>
                                    <span class="chat-img pull-left">
                                        <img src="<?php echo $photo;?>" alt="User Avatar" class="img-circle" width="40" height="40"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"><?php echo $name;?></strong>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> <?php echo $row['date'];?>
                                            </small>
                                        </div>
                                        <p>
											<?php echo $row['posts'];?>
                                        </p>
										<?php
										if ($row['status']==2){
											echo"<div style='float:right;'><img src='../images/green.png' width='13' height ='13' alt='' align='right'/></div>";}
										elseif ($row['status']==1){
											echo"<div style='float:right;'><img src='../images/yellow.jpg' width='13' height ='13' alt='' align='right'/></div>";}
										else{
											echo"<div style='float:right;'><img src='../images/red.png' width='13' height ='13' alt='' align='right'/></div>";}
											echo"<hr /><div style='float:left; margin-top:-10px;'><a href='seeall.php?id=".$row['grouppost_id']."' rel='facebox' style='text-decoration:none;'><i class='fa fa-thumbs-o-up'></i>  (".$allcounts.")</a></div>";
											echo"<div align='center' style=' margin-top:-10px;'><a href='groupcomment.php?id=".$row['grouppost_id']."' rel='facebox' style='text-decoration:none;'>Comments(".$allcount.")</a></div>";
											if ($row['member_id'] == $_SESSION['member_id']){
												echo "<div style='float:right; margin-top:-20px;'><a href='deletegrouppostm.php?id=".$row['grouppost_id']."&gid=".$row['group_id']."' style='text-decoration:none;'>&nbsp;&nbsp;Delete</a></div>";
												echo "<div style='float:right; margin-top:-20px; margin-right:100px;'><a href='editgrouppost.php?id=".$row['grouppost_id']."' rel='facebox' style='text-decoration:none;'>Edit</a></div>";}
											else {
											}
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
                        <div class="panel-body">
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
                        <!-- /.panel-body -->
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
