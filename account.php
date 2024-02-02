<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
$userDetail = $user->userDetails();
include('include/header.php');
?>
<title>Test user management system</title>
<?php include('include/container.php');?>
<div class="container contact">	
	<h2>Test user management system</h2>	
	<?php include('menu.php');?>
	<div class="table-responsive">		
		<div><span style="font-size:20px;">User Account Details:</span><div class="pull-right"><a href="edit_account.php">Edit Account</a></div>
		<table class="table table-boredered">		
			<tr>
				<th>User Name</th>
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
		
		</table>
	</div>	
</div>	
<?php include('include/footer.php');?>