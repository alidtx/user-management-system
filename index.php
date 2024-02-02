<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
include('include/header.php');
?>
<title>Test user management system</title>
<?php include('include/container.php');?>
<div class="container contact">	
	<h2>Test user management system</h2>	
	<?php include('menu.php');?>
	<div class="table-responsive">	
	You're welcome!
	</div>
</div>	
<?php include('include/footer.php');?>