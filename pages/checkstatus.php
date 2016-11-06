<?php
	session_start();
	include("connection.php");
	include("function.php");
	if($_SESSION['login'] != 'admingroup'){
		header("location:index.php");
	}
	$id = $_SESSION['member_id'];
	$grouppost_id = $_GET['id'];
		if(isset($_POST['status'])){
			$status = $_POST['accept'];
			$postid = $_POST['cantseeme'];
			mysqli_query($con,"UPDATE groupposts SET status='$status' WHERE grouppost_id='$postid'")or die(mysqli_error());
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
			include "groupbar.php";
			?>
			
            <div class="navbar-default sidebar" role="navigation" style="margin-top:;">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li style="margin-top:10px;">
                            <a href="grouphome.php"><i class="fa fa-home fa-fw"></i>Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Members<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php 
								$group_id=$_SESSION['member_id'];
								$group = mysqli_query($con,"SELECT * FROM groupmembers WHERE group_id = '$group_id' AND status='1' ")or die(mysqli_error());
								while ($row = mysqli_fetch_array($group)){
									$member_id = $row['member_id'];
									$sql = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$member_id' ")or die(mysqli_error());
									$rows = mysqli_fetch_array($sql);
									echo '<li> <a href=memberprofile.php?id='.$rows["member_id"].' style = "text-decoration:none;"><img src="../image/members/'. $rows['photo'].'" height="30" width="30" align="center">'.$rows['firstname'].' '.$rows['lastname'].' </a></li>';
								}			
							?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Recent Active Members<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
								$post_a = mysqli_query($con,"SELECT DISTINCT member_id FROM groupposts WHERE group_id = '$id' ORDER by date DESC LIMIT 0,5")or die(mysqli_error());
								$num_rows  =mysqli_num_rows($post_a);
							
								if ($num_rows != 0 ){
									while($row = mysqli_fetch_array($post_a)){
									$member = $row['member_id'];
									$member_id=$_SESSION['member_id'];
									if ($member!=$member_id){
										$friends = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$member'")or die(mysqli_error());
										$friendsa = mysqli_fetch_array($friends);
											
										echo '<li> <a href=memberprofile.php?id='.$friendsa["member_id"].' style = "text-decoration:none;"><img src="../image/members/'. $friendsa['photo'].'" height="30" width="30" align="center">'.$friendsa['firstname'].' '.$friendsa['lastname'].' </a></li>';
										$cekid2 = $member;
									}else {}
									}
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
                            <i class="fa fa-clipboard fa-fw"></i> Check Post Status
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php	
								$admingroup_id = $_SESSION['member_id'];
								$post = mysqli_query($con,"SELECT * FROM groupposts WHERE group_id = '$admingroup_id' AND grouppost_id='$grouppost_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($post);
								$id = $row['member_id']; 
								if ($id==$admingroup_id){
									$hu_u = mysqli_query($con,"SELECT * FROM groups WHERE group_id = '$admingroup_id'")or die(mysqli_error());
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
                                        <div>
											<?php echo $row['posts'];?>
                                        </div>
										<div style="margin-left:30px;">
											<?php echo $msg;?>
                                        </div>
										<div style="margin-top:10px;">
										<form method="post" action="">
											<input type='hidden' value='<?php echo $row['grouppost_id'];?>' name='cantseeme'/>
											<select name='accept'>
												<option selected value=''>----Status----</option>
												<option value='0'>Not Accepted</option>
												<option value='1'>Still Considered</option>
												<option value='2'>Accepted</option>
											</select>
											<input type="submit" id="searchbutton2" value="Change" name="status"/>
										<?php
										if ($row['status']==2){
											echo"<div style='float:right;'><img src='../images/green.png' width='13' height ='13' alt='' align='right'/></div>";}
										elseif ($row['status']==1){
											echo"<div style='float:right;'><img src='../images/yellow.jpg' width='13' height ='13' alt='' align='right'/></div>";}
										else{
											echo"<div style='float:right;'><img src='../images/red.png' width='13' height ='13' alt='' align='right'/></div>";}
											echo"</form></div>";
											echo"<hr /><div style='float:left; margin-top:-10px;'><a href='seeall.php?id=".$row['grouppost_id']."' rel='facebox' style='text-decoration:none;'><i class='fa fa-thumbs-o-up'></i>  (".$allcounts.")</a></div>";
											echo"<div align='center' style=' margin-top:-10px;'><a href='groupcomment.php?id=".$row['grouppost_id']."' rel='facebox' style='text-decoration:none;'>Comments(".$allcount.")</a></div>";
											echo "<div style='float:right; margin-top:-15px;'><a href='deletegrouppost.php?id=".$row['grouppost_id']."&gid=".$row['group_id']."' style='text-decoration:none;'>Delete</a></div>";
										?>
                                    </div>
                                </li>
                            </ul>
							
                        </div>
                        <!-- /.panel-body -->
						<div class="panel-heading">
                            <i class="fa fa-clipboard fa-fw"></i> Similar Posts
                        </div>
                        <!-- /.panel-heading -->
						<div class="panel-body">
						<?php
							$data = $grouppost_id;
							$data2 = '11';

							// Execute the python script with the JSON data
							$command = print_r(shell_exec("C:\Python27\word2vec\maclearn.py $data"),true);
							$rows = json_decode($command,true);
							
							$data = $rows['row'];
							if ($data !=NULL){
								foreach ($data as $key => $row){
									$similarity[$key]=$row['similarity'];
								}
								array_multisort($similarity,SORT_DESC,$data);
							}
							for($i=0;$i<count($data);$i++){
						?>
								<div class="chat-body clearfix">
									<div>
										<?php echo $data[$i]['data'];?>
									</div>
									<span class="pull-right">
										<i><?php echo "Similarity: ".$data[$i]['similarity']." %  "."<progress value=".$data[$i]['similarity']." max='100'></progress>";?>
									</span>
								</div>
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
