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
			<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-messages">
			<li>
				<a href="#">
					<div>
						<strong>John Smith</strong>
						<span class="pull-right text-muted">
							<em>Yesterday</em>
						</span>
					</div>
					<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
				</a>
			</li>
			<li class="divider"></li>
			<li class="divider"></li>
			<li>
				<a class="text-center" href="#">
					<strong>Read All Messages</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</li>
		</ul>
		<!-- /.dropdown-messages -->
	</li>
	<!-- /.dropdown -->
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-alerts">
			<li>
				<a href="#">
					<div>
						<i class="fa fa-users fa-fw"></i>Join Request
						<span class="pull-right text-muted small">
						<?php
							$group_id=$_SESSION['member_id'];
							$seeall=mysqli_query($con,"SELECT * FROM groupmembers WHERE group_id='$group_id' AND status='0'") or die(mysqli_error());
							$pila=mysqli_num_rows($seeall);
							echo $pila." Request"; 
						?>
						</span>
					</div>
				</a>
			</li>
			<li class="divider"></li>
		</ul>
		<!-- /.dropdown-alerts -->
	</li>
	<!-- /.dropdown -->
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
			</li>
			<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
			</li>
			<li class="divider"></li>
			<li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
			</li>
		</ul>
		<!-- /.dropdown-user -->
	</li>
	<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->