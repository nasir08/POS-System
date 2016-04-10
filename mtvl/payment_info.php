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
			$cname="";
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
          <h2 class="desc">Payment Information</h2>
            <h2 class="title">Total: 
          <?php
		  $total="";
		  $result=mysql_query("SELECT amount FROM cart WHERE sales_point = '$sp'");
		  while($row=mysql_fetch_assoc($result))
		  {
		  	$total+=$row['amount'];
		  }
		  echo $total;
		  ?>
          </h2>
                <?php
					if(isset($_POST['btnCalc']))
					{
						$r_cname=$_POST['txtCname'];
						$cname=base64_encode(trim($_POST['txtCname']));
						$change=mysql_real_escape_string(trim($_POST['change']));
						$amount_paid=mysql_real_escape_string(trim($_POST['a_paid']));
						$c_change=$amount_paid-$total;
						
						if($cname=="")
						{
							echo"Customer Name cannot be empty<br><br><br>";
						}
						elseif($amount_paid=="")
						{
							echo"Amount Field cannot be empty<br><br><br>";
						}
						elseif(!is_numeric($amount_paid))
						{
							echo"Amount must be a number<br><br><br>";
						}
						elseif($amount_paid<0)
						{
							echo"Amount cannot be negative<br><br><br>";
						}
						elseif(($change!="") && (!is_numeric($change)))
						{
							echo"Change must be a number<br><br><br>";
						}
						elseif(($change!="") && ($change<0))
						{
							echo"Change cannot be negative<br><br><br>";
						}
						elseif(($change!="") && ($change!=$c_change))
						{
							echo "WARNING!!! The change you entered is incorrect.<br><br><br>";
						}
						elseif(($amount_paid>$total) && ($change==0))
						{ echo "WARNING!!! Amount paid is greater than total, please enter the change<br><br><br>"; 
						}
						elseif(($amount_paid==$total) && ($change!=0))
						{ echo "WARNING!!! Amount paid is equal to total, Please remove change before proceeding<br><br><br>"; 
						}
						
						
						
						else
						{
							if($change=="")
							{ $change=0; }
							$amount_paid=base64_encode($amount_paid);
							$change=base64_encode($change);
							Redirect('p_reciept.php?customer='.$cname.'&change='.$change.'&amount_paid='.$amount_paid);
						}
					}
				?>

         <form id="form1" method="post" action="">
         <input name="tot" id="tot" type="hidden" value="<?php echo $total; ?>">           
       <input name="txtCname" class="input" type="text" placeholder="Customer Name" value=<?php if(isset($_POST['btnCalc'])){ echo $r_cname; } ?> >  &nbsp;&nbsp;&nbsp;
                    <input name="a_paid" id="a_paid" class="input" type="text" placeholder="Amount Paid" onKeyUp="Calc()"> &nbsp; &nbsp;
                    <input name="change" id="change" class="input" type="text" placeholder="Change" readonly> &nbsp; &nbsp;
                    <input type="submit" class="regular_button" value="Continue" name="btnCalc">&nbsp; &nbsp;
                    
            </form>
            <script type="text/javascript">
 			function Calc()
 			{
	  		var tot = Number(document.getElementById('tot').value);
	  		var a_paid = Number(document.getElementById('a_paid').value);
	  		document.getElementById('change').value = a_paid - tot;
 			}
			setInterval(Calc,100);
			</script>        
                                 
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