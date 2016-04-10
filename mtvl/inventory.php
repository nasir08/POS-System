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
            <h2 class="desc">Inventory</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <?php
		  if(isset($_POST['submit']))
		  {
			  $item=$_POST['item'];
			  $sdate=trim($_POST['sdate']);
			  $edate=trim($_POST['edate']);
			  $type=$_POST['type'];
			  
			  if($sdate=="")
			  {
				  echo"Start date cannot be empty.<br><br>";
			  }
			  elseif($edate=="")
			  {
				  echo"End date cannot be empty.<br><br>";
			  }
			  
			  
			  else
			  {
				  if($type=="number")
				  {
				  $result=mysql_query("SELECT * FROM goods WHERE id='$item'");
				  $row=mysql_fetch_array($result);
				  $item_name=$row['item_name'];
				  $del=$row['delimeter'];
				  
				  $result=mysql_query("SELECT * FROM reciept_goods WHERE date BETWEEN '$sdate' AND '$edate' and good_id ='$item'");
				  $qty="";
				  while($row=mysql_fetch_assoc($result))
				  {
				  	$qty+=$row['quantity'];
				  }
				  $conv=$del*$qty;
				  echo"<b>You have sold $conv piece(s) of $item_name between $sdate and $edate.</b><br><br>";
			  }
			  
			  
			  elseif($type=="amount")
			  {
				  $result=mysql_query("SELECT * FROM goods WHERE id='$item'");
				  $row=mysql_fetch_array($result);
				  $item_name=$row['item_name'];
				  
				  $result=mysql_query("SELECT SUM(amount) FROM reciept_goods WHERE good_id='$item' and date BETWEEN '$sdate' AND '$edate'");
				  $row=mysql_fetch_row($result);
                  if($row[0]==0)
				  echo"<b>You have made 0.00 from $item_name between $sdate and $edate.</b><br><br>";
                  else
                  echo"<b>You have made $row[0] from $item_name between $sdate and $edate.</b><br><br>";
			  }
			  }
		  }
		  
		  elseif(isset($_POST['cancel']))
		  {
			  Redirect('goods-archive.php');
		  }
		  ?>
                <table width="100%" border="0"  class="add-item">
  <tr>
    <td colspan="2" align="left" valign="middle"><p>
      <label>
        <input type="radio" name="type" value="number" id="type_0" checked>
        Number of Good Sold</label> &nbsp; &nbsp;
      <label>
        <input type="radio" name="type" value="amount" id="type_1">
        Amount of Goods Sold</label>
      <br>
    </p></td>
    </tr>
  <tr>
    <td width="14%" align="right" valign="middle">Item Name: &nbsp;&nbsp;</td>
    <td width="86%" align="left" valign="middle"><select name="item" class="dropbox">
      <?php
	$result=mysql_query("SELECT * FROM Goods");
	while($row=mysql_fetch_assoc($result))
    echo"<option value=$row[id]>$row[item_name]</option>";
	?>
    </select></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Start Date: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="date" name="sdate" class="input"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">End Date: &nbsp;&nbsp;</td>
    <td align="left" valign="middle"><input type="date" name="edate" class="input"></td>
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