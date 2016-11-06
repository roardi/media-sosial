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
                            <i class="fa fa-clipboard fa-fw"></i> Post
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php 
								$postid = $_GET['id'];
								$post = mysqli_query($con,"SELECT * FROM posts WHERE post_id = '$postid'")or die(mysqli_error());
								$row = mysqli_fetch_array($post);
								$id = $row['member_id'];
								$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
								$rows = mysqli_fetch_array($hu_u);
							?>
							<ul class="chat">
                                <li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="../image/members/<?php echo $rows['photo'];?>" alt="User Avatar" class="img-circle" width="40" height="40"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"><?php echo $rows['firstname']." ".$rows['lastname'];?></strong>
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
								$postid = $_GET['id'];
								$post = mysqli_query($con,"SELECT * FROM postcomments WHERE post_id = '$postid'")or die(mysqli_error());
								$member_id = $_SESSION['member_id'];
								while($row = mysqli_fetch_array($post)){
									$id = $row['member_id'];
									$member_id = $_SESSION['member_id']; 
									$hu_u = mysqli_query($con,"SELECT * FROM members WHERE member_id = '$id'")or die(mysqli_error());
									$rows = mysqli_fetch_array($hu_u);
							?>
									<ul class="chat">
										<li class="left clearfix">
											<span class="chat-img pull-left">
												<img src="../image/members/<?php echo $rows['photo'];?>" alt="User Avatar" class="img-circle" width="30" height="30"/>
											</span>
											<div class="chat-body clearfix">
												<div class="header">
													<strong class="primary-font"><?php echo $rows['firstname']." ".$rows['lastname'];?></strong>
													<small class="pull-right text-muted">
														<i class="fa fa-clock-o fa-fw"></i> <?php echo $row['date'];?>
													</small>
												</div>
												<p>
													<?php echo $row['comment'];?>
												</p>
											</div>
										</li>
									</ul>
								<?php
								}
								?>
							<form method="post" action="">
								<input type='hidden' name='ucantseeme' value='<?php echo $postid; ?>'>
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

