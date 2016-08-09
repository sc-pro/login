<h3>Login</h3>
<form  method="post" action="form.php">
	<input type="email" name='email' placeholder="Email" required>
	<input type="password" name="password" placeholder="Password" required>
	<input type="submit" name='login' value="login" required>
</form>
<a href="forgotPassword.php">Forgot password</a>
<br><br>
<h3>Register</h3>
<form method="post" action="form.php">
	<input type="text" name="name" placeholder="Name" required>
	<input type="email" autocomplete="off" name='email' placeholder="email" required>
	<input type="password" autocomplete="off" name="password" placeholder="Password" required>
	<input type="submit" value="register" name='register'>
</form>
<?php 
require_once('dbConnect.php');
require_once('funtions.php');
if (isset($_POST['register'])) {
	$name=trim($_POST['name']);
	$email=trim($_POST['email']);
	$password=trim($_POST['password']);
	$password=md5($password);
	$string=substr(str_shuffle("qwertyuioplakjhgfdszxcvbnm"),10,10);
	if (userActivate($email)==0) {
		$reActivate=reActivate();
		echo "You are already registered. Please activate your account.<br>$reActivate";
	}
	else if (userRegistered($email)>=1) {
		echo "You are already registered";
	}else{
		if(mysql_query("insert into userinfo (name,email,password,activateEmail) values ('$name','$email','$password','$string')")){
			$run=mysql_query("select id from userinfo where email='$email' and password='$password'");
			$id=mysql_result($run, 0);
			$subject = "Activate your account";
			$emailEncode=urlencode($email);
			$message = "Click the given link to activate your account.<br>\n http://www.sanjaychouhan.net/log/activationMail.php?activate=$string&email=$emailEncode";
			$from="activate@sanjaychouhan.net";
			$headers = "From: $from\r\n";
			if (mail($email, $subject, $message, $headers)) {
			   echo "Check your email to activate your account. If you don't find it in inbox then check spam folder.";
			} else {
			   echo "Error occured. Try resending the activation mail.";
			}
			
		}else{
			echo "Try again later";
		}
	}
}

if (isset($_POST['login'])) {
	session_start();
	$email=trim($_POST['email']);
	$password=trim($_POST['password']);
	$password=md5($password);
	$u=userActivate($email);
	if ($u==0) {
		$reActivate=reActivate();
		echo "Please activate your account.<br>$reActivate";
	}else{
		$run=mysql_query("select id from userinfo where email='$email' and password='$password'");
		if(mysql_num_rows($run)>1){
		    echo"Could not process your request";
		}else if(mysql_num_rows($run)<1){
		    echo"Wrong combination of email and password";
		}
		else if(mysql_num_rows($run)==1){
		    $id=mysql_result($run, 0);
	        $_SESSION['id']=$id;
	        header("Location:index.php");
		}
	}
}
 ?>