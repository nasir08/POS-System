<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		
	 if($_SESSION['type']!="admin")
	 {
		Redirect('sales.php'); 
	 }
	 else
	 {
		$sp=$_SESSION['id'];
		require_once('inc/header.php');
		require_once('inc/sidebar.php');
	 }
	}
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Add New User</h2></div>
				<form method="post">
                
                <?php
		  if(isset($_POST['submit']))
		  {
			  $name=mysql_real_escape_string(trim($_POST['name']));
			  $phone=mysql_real_escape_string(trim($_POST['phone']));
			  $type=$_POST['type'];
			  $uname=mysql_real_escape_string(trim($_POST['uname']));
			  
			  
			  if($name=="")
			  {
				  echo "Name field cannot be empty.<br><br>";
			  }
			  elseif($phone=="")
			  {
				  echo "Phone Number field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($phone))
			  {
				  echo "Phone Number must be a number.<br><br>";
			  }
			  elseif($uname=="")
			  {
				  echo "Username field cannot be empty.<br><br>";
			  }
			  
			  
			  else
			  {
				  $result=mysql_query("SELECT COUNT(id) FROM accounts WHERE uname='$uname'");
				  $row=mysql_fetch_row($result);
				  if($row[0]>0)
				  {
					  echo "The username \"$uname\" belongs to another user.<br><br>";
				  }
				  else
				  {
					  $pass=gen_Password();
					  $e_pass=base64_encode($pass);
					  $s_pass=SHA1($pass);
				  mysql_query("INSERT INTO accounts (name,uname,pword,type,phone,r_code) VALUES('$name','$uname','$s_pass','$type','$phone','$e_pass')");
				  
				  
				  $result=mysql_query("SELECT id FROM accounts ORDER BY ID DESC LIMIT 0,1");
				  $row=mysql_fetch_array($result);
				  $id=$row['id'];
				  
				  
				  mysql_query("INSERT INTO balance_bf (amount,sales_point) VALUES(0,'$id')");
				  
				  
				 	 echo "Sales point added successfully, with $pass as password.<br><br>";
				  }
			  }
		  }
		  ?>
                	<div class="element">
                	<label for="category">Type</label>
                	<select name="type" class="err">
                            <option value="sales point">Regular Sales Point</option>
    						<option value="manager">Manager</option>
    						<option value="admin">Admin</option>
						</select>
                     </div>
                	<div class="element">
                    	<label for="category">Name</label>
						<input type="text" name="name" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Phone Number</label>
						<input type="number" name="phone" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Username</label>
						<input type="text" name="uname" class="mini-text err">
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