<link rel="stylesheet" type="text/css" href="design.css">
<?php
include('classes/DB.php');
$pdo = new PDO('mysql:host=127.0.0.1;dbname=proiecttw;charset=utf8','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

if (isset($_POST['createaccount'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	if (!DB::query('SELECT username FROM users WHERE username=:username', array('username'=>$username)))
	{
		if (strlen($username)>=3 && strlen($username)<=32) 
		{

			if(preg_match('/[a-zA-Z-0-9_]/',$username))
			{

				if(strlen($password)>=6&& strlen($password)<=60)
				{
					if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
						echo "Success!";
						header("Location: login.php");
                        die();
					}
					else
					{
						echo "Invalid email";
					}
				}
				else
				{
					echo "Invalid password!";
				}
			}
		 	else 
		 	{
			echo "Invalid username!";
		 	}
		}
		else
		{
			echo "Invalid username!";
		}

    } 
    else
    {
    	echo "User already exists";
    }
}
?>



<h1>Register</h1>
<div class="login-form">
<form action="create-account.php" method="post">
<input type="text" name="username" value="" placeholder="Username.."><p />
<input type="password" name="password" value="" placeholder="Password.."><p />
<input type="email" name="email" value="" placeholder="someone@somesite.com"><p />
<input type="submit" name="createaccount" value="Create Account">
</form>
</div>