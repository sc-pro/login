<?php 
function getValue($id,$table,$field)
{
	$result=mysql_query("select $field from $table where id=$id");
	$result=mysql_result($result, 0);
	return $result;
}

function userRegistered($email){
	$count=mysql_query("select count(*) from userinfo where email='$email'");
	$count=mysql_result($count, 0);
	return $count;
}

function userActivate($email){
	$result=mysql_query("select activate from userinfo where email='$email'");
	if (mysql_num_rows($result)==1) {
		$result=mysql_result($result, 0);
		return $result;
	}else{
		return 1;
	}
}
function reActivate(){
	$echoLink="<a href='activationMail.php'>Send activation mail.</a>";
	return $echoLink;
}

?>

