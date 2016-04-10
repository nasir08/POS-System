<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
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
	 }
	}
?>

<body id="page4">
<!-- START PAGE SOURCE -->
<div class="body3"></div>
<div class="body1">
  <div class="main">
    <header>
      <?php
	  	require_once('inc/logo.php');
	  ?>
      <nav>
        <ul id="menu">
          <li><a href="sales.php">Sales</a></li>
          <li><a href="expenses.php">Expenses</a></li>
          <li><a href="receipt-archive.php">Reciept Archive</a></li>
          <?php
            if(($_SESSION['type']=="admin")|| ($_SESSION['type']=="manager"))
			echo"<li><a href=goods-archive.php>Goods Archive</a></li>";
			?>
          <li><a href="my-account.php">My Account</a></li>
          <?php
            if($_SESSION['type']=="admin")
			echo"<li class=bg_none><a href=all-accounts.php>All Accounts</a></li>";
			?>
          
        </ul>
      </nav>
      <div class="wrapper">
        <div class="text1">Sales Point: <?php echo $_SESSION['name'] ?></div>
        <div class="text2">
        <?php
    $result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
	$row=mysql_fetch_row($result);
	$get_t=mysql_query("SELECT SUM(amount) FROM cart WHERE sales_point= '$sp'");
	$geter=mysql_fetch_row($get_t);
	$geter=number_format($geter[0],2);
	if($row[0]==0)
	{
		echo "Cart ($row[0] items - 0.00)";
	    $passer="no link";
	}
	
	echo "<a href=\"cart.php\">";
	if($row[0]==1)
	{echo "Cart ($row[0] item - $geter)";}
	elseif($row[0]>1)
	{echo "Cart ($row[0] items - $geter)";}
	echo "</a>";
	?>  
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
       Customers Waiting(3)</div>
        <br>
        <?php
     if($_SESSION['type']=="admin")
	echo"<a href=add-new-sales-point.php>Add New Sales Point</a> | ";
	?>
	<a href="change-password.php">Change Password</a> | 
	<a href="signout.php">Sign Out</a></div>
      </div>
    </header>
  </div>
</div>
<div class="body2">
  <div class="main">
    <section id="content">
      <div class="marg_top wrapper">
        <div class="box1_out">
          <div class="box1">
            <h2 class="desc">Add New Sales Point</h2><br>
            <form action="" method="post" enctype="multipart/form-data">
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
                <table width="100%" border="0"  class="add-item">
  <tr>
    <td width="25%" align="right" valign="middle">Type:</td>
    <td width="75%" align="left" valign="middle"><select name="type" class="dropbox">
    <option value="sales point">Regular Sales Point</option>
    <option value="manager">Manager</option>
    <option value="admin">Admin</option>
    </select></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Name: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="name" class="input"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Phone Number: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="phone" class="input"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Username: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="uname" class="input"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><input type="submit" name="submit" class="regular_button" value="Submit"></td>
  </tr>
                </table>
            </form>                  <br><br><br><br>
           </div>
        </div>
      </div>
    </section>
  </div>
</div>
<div class="main">
  <?php
  	require_once('inc/footer.php');
  ?>
</div>
<script type="text/javascript"> Cufon.now(); </script>
<!-- END PAGE SOURCE -->
</body>
</html>