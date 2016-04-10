<?php
	require_once('inc/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>M.T. Ventures LTD</title>
<link rel="stylesheet" type="text/css" href="login_css/login.css" media="screen" />
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
				<form action="" method="post">
                <?php
            		if(isset($_POST['login']))
    				{
        				$username=mysql_real_escape_string($_POST['username']);
        				$passw=SHA1($_POST['password']);
						if(trim($_POST['username'])=="")
						{ 
		    				echo"<center><b class=loginError>Username field cannot be empty.</b></center><br />";
	    				}
						elseif(trim($_POST['password'])=="")
						{ 
							echo"<center><b class=loginError>Password field cannot be empty.</b></center><br />";
						}
						else
						{
        					$result=mysql_query("SELECT * FROM accounts WHERE uname='$username' and pword='$passw'");
        					$row=mysql_num_rows($result);
        					if($row>0)
        					{
            					$row=mysql_fetch_assoc($result);
								session_start();
								$_SESSION['id']=$row['id'];
								$_SESSION['name']=$row['name'];
								$_SESSION['type']=$row['type'];
								$_SESSION['phone']=$row['phone'];
   	        					Redirect('sales.php');
        					}
        					else
        					{
           						 echo"<center><b class=loginError>Invalid Username/Password.</b></center><br />";
       					 	}
						}
    				}
				?>
					<label for="login">Username:</label>
					<input id="login" name="username" class="text" value=<?php if(isset($_POST['login'])){ echo $username; } ?> >
                    <!-- that little piece of php code above keeps th value of the username field in it after processing -->
					<label for="pass">Password:</label>
					<input id="pass" name="password" type="password" class="text" />
					<div class="sep"></div>
					<button type="submit" class="ok" name="login">Login</button> 
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>
