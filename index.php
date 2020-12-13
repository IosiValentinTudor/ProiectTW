<?php
include('classes/DB.php');
include('Login2.php');

if(Login2::isLoggedIn())
{
	echo "Logged In";
	
} 
else
{
	echo "Not logged in";
}

?>