<?php
include('classes/DB.php');
include('Login2.php');

if(Login2::isLoggedIn())
{
	die("Not logged in");
}
if (isset($_POST['confirm'])) 
{
	if ($_POST['alldevices']=='alldevices')
	{
		DB::query('DELETE FROM login_token where user_id=:user_id',array(':userid'=>sha1($_COOKIE['PROIECTTW'])));
	}
	else
	{
			 if(isset($_COOKIE['PROIECTTW']))
			 {
			 	DB::query('DELETE FROM login_token where token=:token',array(':token'=>sha1($_COOKIE['PROIECTTW'])));
			 }
			 setcookie('PROIECTTW','1',time()-3600);
			 setcookie('PROIECTTW_','1',time()-3600);
	}
}
?>
<h1>Logout of your Account?</h1>
<p>Are you sure you'd like to logout?</p>
<form action="logout.php" method="post">
	<input type="checkbox" name="alldevices" value="">Logout of all devices?<br />
	<input type="submit" name="confirm" value="Confirm">
</form>
