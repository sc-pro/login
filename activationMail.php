<?php  
require_once('dbConnect.php');
if (isset($_GET['activate'])&&isset($_GET['email'])) {
	$password=$_GET['activate'];
	$email=$_GET['email'];
	if (strlen($password)==10) {
		$email=urldecode($email);
		$result=mysql_query("select count(*) from userinfo where activateEmail='$password' and email='$email'");
		$result=mysql_result($result, 0);
		if ($result==1 && mysql_query("update userinfo set activateEmail='', activate=1 where email='$email'")) {
			echo "Your account has been activated. Redirecting you to home page for login.";
			header("Refresh:2;url=index.php");
		 }else{
			echo "Sorry try again.";
		}
	}else{
		echo "Sorry try again.";
	}
}else{?>		
	<form action="activationMail.php" method="post">
		<input type="email" placeholder="Email" name="email" required>
		<input type="submit" name="activeEmail">
	</form>
	<?php 
	if (isset($_POST['activeEmail'])) {
		require_once('dbConnect.php');
		require_once('funtions.php');
		$to = trim($_POST['email']);
		$email=$to;
		$count=mysql_query("select count(*) from userinfo where email='$email'");
		$count=mysql_result($count, 0);
		if ($count<1) {
			echo "No account exist with this email.";
		}else{
			$count=mysql_query("select count(*) from userinfo where email='$email' and activate=1");
			$count=mysql_result($count, 0);
			if ($count==1) {
				echo "Your account is already registered.";
			}else{
				if(userRegistered($to)==1){
					$string=substr(str_shuffle("qwertyuioplakjhgfdszxcvbnm"),10,10);
					$subject = "Activate your account";
					$email=urlencode($to);
					$message = "Click the given link to activate your account.<br>\n http://www.sanjaychouhan.net/log/activationMail.php?activate=$string&email=$email";
					$from="active@sanjaychouhan.net";
					$headers = "From: $from\r\n";
					if (mail($to, $subject, $message, $headers) && mysql_query("update userinfo set activateEmail='$string' where email='$to'")) {
					   echo "Check your email to activate your account. If you don't find it in inbox then check spam folder.";
					} else {
					   echo "Error occured. Try again.";
					}
				}else{
					echo "Please register first.";
				}	
			}
		}
	}
}
?>