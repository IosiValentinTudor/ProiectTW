<?php
public static function isLoggedIn()
{
	if(isset($_COOKIE['PROIECTTW']))
	{
		if(DB::query('SELECT user_id FROM login_tokens WHERE token=:token',array(':token'=>sha1($_COOKIE['PROIECTTW']))))
		{
			return true;
		}
	}
	return false;
} 
?>