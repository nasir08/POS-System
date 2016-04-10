<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		$sp=$_SESSION['id'];
	require_once('inc/header.php');
	require_once('inc/sidebar.php');
	}
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Change Password</h2></div>
				<form method="post">
                
                <?php
				$result=mysql_query("SELECT pword FROM accounts WHERE id='$sp'");
				$row=mysql_fetch_array($result);
		  if(isset($_POST['submit']))
		  {
			  $cpass=$_POST['cpass'];
			  $npass=$_POST['npass'];
			  $cnpass=$_POST['cnpass'];
			  
			  
			  if($cpass=="")
			  {
				  echo "Current password field cannot be empty.<br><br>";
			  }
			  elseif($npass=="")
			  {
				  echo "New Password field cannot be empty.<br><br>";
			  }
			  
			  
			  else
			  {
				  $e_pass=base64_encode($npass);
				  
				  if(SHA1($cpass)!=$row['pword'])
				  {
					echo "Current password is invalid.<br><br>";  
				  }
				  elseif($npass!=$cnpass)
				  {
					  echo "New passwords do not match.<br><br>";
				  }
				  else
				  {
				  $npass=SHA1($npass);
				  mysql_query("UPDATE accounts SET pword='$npass',r_code='$e_pass' WHERE id='$sp'");
				  echo "Password changed successfully.<br><br>";
				  }
			  }
		  }
		  ?>
                	<div class="element">
                    	<label for="category">Current Password</label>
						<input type="password" name="cpass" class="mini-text err" autofocus>
					</div>
                	<div class="element">
                    	<label for="category">New Password</label>
						<input type="password" name="npass" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Re-Type New Password</label>
						<input type="password" name="cnpass" class="mini-text err">
					</div>
                    <div class="element">
						<button type="submit" class="add" name="submit">Submit</button>
					</div>
                </form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>