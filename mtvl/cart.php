<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		$sp=$_SESSION['id'];
    	$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
		$row=mysql_fetch_row($result);
		if($row[0]==0)
		{
			Redirect('sales.php');
		}
		else
		{
			require_once('inc/header.php');
			$passer="";
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
          <h2 class="desc">Cart</h2>
            <form action="" method="post" enctype="multipart/form-data">
               	  <table width="100%">
  <tr class="resultHeader" height="33px">
    <th align="center" valign="middle" scope="col">S/N</th>
    <th align="center" valign="middle" scope="col">Item</th>
    <th align="center" valign="middle" scope="col">Quantity</th>
    <th align="center" valign="middle" scope="col">Price</th>
    <th align="center" valign="middle" scope="col">Amount</th>
    <th align="center" valign="middle" scope="col">Actions</th>
  </tr>
  <?php
  $sp=$_SESSION['id'];
  $result=mysql_query("SELECT * FROM cart WHERE sales_point = '$sp'");
  $sn=1;
  $total="";
  while($row=mysql_fetch_assoc($result))
  {
	$id=base64_encode($row['id']);
	$total+=$row['amount'];
  echo"<tr class=\"result\">
    <td align=\"center\" valign=\"middle\">$sn</td>
    <td align=\"center\" valign=\"middle\">$row[item_name]</td>
    <td align=\"center\" valign=\"middle\">$row[quantity]</td>
    <td align=\"center\" valign=\"middle\">$row[unit_price]</td>
    <td align=\"center\" valign=\"middle\">$row[amount]</td>
    <td align=\"center\" valign=\"middle\"><a href=\"edit_order.php?item=$id\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"drop-item.php?item=$id\" title=Drop><img src=\"img/trash.png\"></a></td>
  </tr>";
  $sn++;
  }
  echo"<tr><td>&nbsp;</td></tr>
  <tr class=\"total\">
    <td align=\"center\" valign=\"middle\">&nbsp;</td>
    <td align=\"center\" valign=\"middle\">Total</td>
    <td align=\"center\" valign=\"middle\">&nbsp;</td>
    <td align=\"center\" valign=\"middle\">&nbsp;</td>
    <td align=\"center\" valign=\"middle\">$total</td>
    <td align=\"center\" valign=\"middle\">&nbsp;</td>
  </tr>";
  ?>
</table>
<br>
<input type="submit" class="regular_button2" value="Continue" name="btnCont">
</form>
                  <?php
				if(isset($_POST['btnCont']))
				{
					Redirect('payment_info.php');
				}
				?>  
                    
                  <br><br><br><br>
                  <a href="#">Lay-off Customer</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                  <?php 
  					if($passer=="")
  					echo"<a href=cancel_order.php?sales_point=$_SESSION[id]>Cancel Item Selection</a>"; 
  				?>
                  <br><br><br><br>
              </form>
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