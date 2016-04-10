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
		if($_SESSION['type']!="manager")
		{
		Redirect('sales.php'); 
		}
		else
	{
	require_once('inc/header.php');
    $sp=$_SESSION['id'];
	}
	 }
	else
	{
	require_once('inc/header.php');
    $sp=$_SESSION['id'];
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
            <h2 class="desc">Add New Item</h2><br>
            <form action="" method="post" enctype="multipart/form-data">
                <?php
		  if(isset($_POST['submit']))
		  {
			  $name=mysql_real_escape_string(trim($_POST['name']));
			  $family=mysql_real_escape_string(trim($_POST['family']));
			  $price=mysql_real_escape_string(trim($_POST['price']));
			  $inv=mysql_real_escape_string(trim($_POST['inv']));
			  $del=mysql_real_escape_string(trim($_POST['del']));
			  if($name=="")
			  {
				  echo "Item Name field cannot be empty.<br><br>";
			  }
			  elseif($family=="")
			  {
				  echo "Family field cannot be empty.<br><br>";
			  }
			  elseif($price=="")
			  {
				  echo "Price field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($price))
			  {
				  echo "Price must be a number.<br><br>";
			  }
			  elseif($inv=="")
			  {
				  echo "Inventory field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($inv))
			  {
				  echo "Inventory must be a number.<br><br>";
			  }
			  elseif($del=="")
			  {
				  echo "Delimeter field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($del))
			  {
				  echo "Delimeter must be a number.<br><br>";
			  }
              elseif($price<0)
			  {
				  echo "Price cannot be a negative number.<br><br>";
			  }
			  
			  
			  else
			  {
				  mysql_query("INSERT INTO goods (item_name,family,amount_rem,delimeter,unit_price) VALUES('$name','$family','$inv','$del','$price')");
				  Redirect('goods-archive.php');
			  }
		  }
		  
		  elseif(isset($_POST['cancel']))
		  {
			  Redirect('goods-archive.php');
		  }
		  ?>
                <table width="100%" border="0"  class="add-item">
  <tr>
    <td width="14%" align="right" valign="middle">Item Name: &nbsp;&nbsp;</td>
    <td width="86%" align="left" valign="middle"><input type="text" name="name" class="input" style="width:300px;" value=<?php if(isset($_POST['submit'])){ echo $name; } ?> ></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Family: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="family" class="input" style="width:300px;" value=<?php if(isset($_POST['submit'])){ echo $family; } ?> ></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Price: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="price" class="input" style="width:300px;" value=<?php if(isset($_POST['submit'])){ echo $price; } ?> ></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Inventory: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="inv" class="input" style="width:300px;" value=<?php if(isset($_POST['submit'])){ echo $inv; } ?> ></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Delimeter: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="text" name="del" class="input" style="width:300px;" value=<?php if(isset($_POST['submit'])){ echo $del; } ?> ></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><input type="submit" name="submit" class="regular_button" value="Submit"> <input type="submit" name="cancel" class="regular_button" value="Cancel"></td>
  </tr>
                </table>
            </form>
                  <br><br><br><br>
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