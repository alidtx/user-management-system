<?php 
include('../class/User.php');
$user = new User();
$user->adminLoginStatus();
include('include/header.php');
?>
<title>Test Project</title>
<link rel="stylesheet" href="css/style.css">
<?php include('include/container.php');?>
<div class="container contact">	
	<h2>Test User Management system </h2>	
	<?php include 'menus.php'; ?>
      <H3>This is dashboard</H3>
</div>	
<?php include('include/footer.php');?>