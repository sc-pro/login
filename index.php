<?php 
session_start();
require_once('funtions.php');
require_once('dbConnect.php');
if(isset($_SESSION['id'])){
	$id=$_SESSION['id'];
	$userName=getValue($id,'userinfo','name');
	echo "Hi $userName";
?>
<a href="logout.php">LogOut</a>
<?php
}else{
	require('form.php');
}
echo password_hash(" sanjay",PASSWORD_DEFAULT);
?>