<?php  
require_once('dbConnect.php');
if (isset($_GET['password'])&&isset($_GET['email'])) {
	$password=$_GET['password'];
	$email=$_GET['email'];
	if (strlen($password)==10) {
		$email=urldecode($email);
		$result=mysql_query("select count(*) from userinfo where changePassword='$password' and email='$email'");
		$result=mysql_result($result, 0);
		if ($result==1) {?>
		<form action="changePassword.php" method="post">
			<input type="password" name="passwordAgain" placehoder="Password" required>
			<input type="hidden" name="email" value="<?php echo"$email"?>">
			<input type="submit" name="submit">
		</form>
		<?php }else{
			echo "Sorry try again.";
		}
	}else{
		echo "Sorry try again.";
	}
}
if (isset($_POST['submit'])) {

	$password=md5($_POST['passwordAgain']);
	$email=$_POST['email'];
	if (mysql_query("update userinfo set password='$password', changePassword='' where email='$email'") ) {
		echo "Password changed";
		echo "<br> Redirecting you to Home page.";
		header("Refresh:2;url=index.php");
	}
}
?>