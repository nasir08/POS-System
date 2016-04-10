<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		if(isset($_SESSION['balance_bf']))
		{
		$sp=$_SESSION['id'];
		$balance=$_SESSION['balance_bf'];
		require_once('inc/header.php');
		}
		else
		{
			Redirect('sales.php'); 
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
            <h2 class="desc">balance brought forward: <?php echo $balance ?></h2>
            <form id="form1" method="post" action="">
                <?php
				if(isset($_POST['submit']))
				{
					$today=date('Y')."-".date('m')."-".date('d');
					$amount=trim($_POST['amount']);
					if($amount=="")
					{ echo "Amount field cannot be empty.<br><br>"; }
					elseif(!is_numeric($amount))
					{ echo "Amount must be a number.<br><br>"; }
					else
					{
						if($amount==$balance)
						{
						
						mysql_query("INSERT INTO reciept (name,amount,amount_paid,sales_point,date) VALUES('Balance Brought Forward','$amount','$amount','$sp','$today')");
						
						
						$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
						
						Redirect('sales.php');
						}
						else
						{
							{ echo "Error! Please Enter the exact amount of balance brought forward.<br><br>"; }
						}
					}
				}
				?>
				  Amount: 
				    <input type="text" name="amount" class="input" value=<?php if(isset($_POST['submit'])){ echo $amount; } ?>>
				  &nbsp;
			      <input type="submit" name="submit" class="regular_button" value="Submit">

			</form>
                    
                  <br><br><br><br>
                  
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