
<form action="forgotPassword.php" method="get">
	<input type="email" placeholder="Email" name="email" required>
	<input type="submit" name="forgot">
</form>
<?php 
if (isset($_GET['forgot'])) {
	require_once('dbConnect.php');
	require_once('funtions.php');
	$to = $_GET['email'];
	if(userRegistered($to)==1){
		$string=substr(str_shuffle("qwertyuioplakjhgfdszxcvbnm"),10,10);
		$subject = "Regarding forgot password";
		$email=urlencode($to);
		$message = "Click the given link to change password.<br>\n http://www.sanjaychouhan.net/log/changePassword.php?password=$string&email=$email";
		$from="manage@sanjaychouhan.net";
		$headers = "From: $from\r\n";
		if (mail($to, $subject, $message, $headers) && mysql_query("update userinfo set changePassword='$string' where email='$to'")) {
		   echo "Check your email to change your password. If you don't find it in inbox then check spam folder.";
		} else {
		   echo "Error occured. Try again.";
		}
	}else{
		echo "Please register first.";
	}
}
?>