<?php 
include('../class/User.php');
$user = new User();
$user->adminLoginStatus();
$message  = '';
$userDetail = $user->adminDetails();
include('include/header.php');
?>
<title>Test User Management System</title>
<link rel="stylesheet" href="css/style.css">
<?php include('include/container.php');?>
<div class="container contact">	
	<h2>Test User Management System</h2>	
	<?php include 'menus.php'; ?>
	<div class="table-responsive">		
		<div><span style="font-size:20px;">Admin Details:</span><div class="pull-right"></div>
		<table class="table table-boredered">		
			<tr>
				<th>Name</th>
				<td><?php echo $userDetail['user_name']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $userDetail['email']; ?></td>
			</tr>
			<tr>
				<th>Password</th>
				<td>**********</td>
			</tr>
	</div>
</div>	
<?php include('include/footer.php');?>