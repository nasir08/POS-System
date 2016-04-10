<?php
	require_once('inc/functions.php');
	session_start();
	if($_SESSION['type']!="admin")
	{ 
			Redirect('sales.php');
	 }
	
	
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		if(isset($_GET['e_id']))
		{
			if(isset($_GET['token']))
			{
				require_once('inc/header.php');
				$sp=$_GET['e_id'];
				$date=base64_decode($_GET['token']);
			}
			else
			{
				Redirect('all-accounts.php');
			}
		}
		else
		{
			Redirect('all-accounts.php');
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
            <?php
		$result=mysql_query("SELECT name FROM accounts WHERE id='$sp'");
		$row=mysql_fetch_array($result);
			$name=$row['name'];
			echo "<h2 class=desc>$name's expenses</h2>";
		?>
			<div class="byline">List of daily expenses</div>
		  <div class="entry">
          
								<p>&nbsp;</p>
                <?php
				$result=mysql_query("SELECT COUNT(id) FROM expenses WHERE sales_point='$sp' and date='$date'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no expenses in the database for $name on $date.";
				}
				else
				{
				echo"<table width=100%>
  						<tr class=resultHeader>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Date</th>
    					<th align=center valign=middle scope=col>Purpose</th>
    					<th align=center valign=middle scope=col>Amount</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
				
					$sn=1;
				
					$result=mysql_query("SELECT * FROM expenses WHERE sales_point='$sp' and date='$date' ORDER BY id DESC");
					while($row=mysql_fetch_assoc($result))
					{
						$id=base64_encode($row['id']);	
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$row[date]</td>
                            <td align=center valign=middle>$row[purpose]</td>
   							<td align=center valign=middle>$row[amount]</td>
							<td align=center valign=middle><a href=delete-expense.php?e_id=$id>Delete</a></td>
  							</tr>";
							$sn++;
					}
				}
						
                        echo"</table>";
				?>


                    
                    
                  <br><br><br><br>
                  
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