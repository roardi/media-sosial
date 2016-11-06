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
                            <i class="fa fa-clipboard fa-fw"></i> Group Post
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php 
								$grouppostid = $_GET['id'];
								$post = mysqli_query($con,"SELECT * FROM groupposts WHERE grouppost_id = '$grouppostid'")or die(mysqli_error());
								$row = mysqli_fetch_array($post);
								$id = $row['member_id'];
								$group_id = $row['group_id'];
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
							?>
							<ul class="chat">
                                <li class="left clearfix">
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
                                    </div>
                                </li>
                            </ul>
							<div class="panel-heading">
								<i class="fa fa-comments fa-fw"></i> Comments
							</div>
							<?php 
								$grouppost = mysqli_query($con,"SELECT * FROM groupposts WHERE grouppost_id = '$grouppostid'")or die(mysqli_error());
								$rows = mysqli_fetch_array ($grouppost);
								$group_id = $rows['group_id'];
								$grouppostid = $_GET['id'];
								$post = mysqli_query($con,"SELECT * FROM grouppostcomments WHERE grouppost_id = '$grouppostid'")or die(mysqli_error());
								$member_id = $_SESSION['member_id'];
								while($row = mysqli_fetch_array($post)){
									$id = $row['member_id']; 
									$member_id = $_SESSION['member_id']; 
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
							?>
									<ul class="chat">
										<li class="left clearfix">
											<span class="chat-img pull-left">
												<img src="<?php echo $photo;?>" alt="User Avatar" class="img-circle" width="30" height="30"/>
											</span>
											<div class="chat-body clearfix">
												<div class="header">
													<strong class="primary-font"><?php echo $name;?></strong>
													<small class="pull-right text-muted">
														<i class="fa fa-clock-o fa-fw"></i> <?php echo $row['date'];?>
													</small>
												</div>
												<p>
													<?php echo $row['comments'];?>
												</p>
											</div>
										</li>
									</ul>
								<?php
								}
								?>
							<form method="post" action="">
								<input type='hidden' name='ucantseeme' value='<?php echo $grouppostid; ?>'>
								<textarea style='float:right;' name='textarea' cols='70' rows='3'></textarea><br>
								<input style='float:right;' type='submit'  name='comment' value='Comment'>
							</form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
</body>
</html>

