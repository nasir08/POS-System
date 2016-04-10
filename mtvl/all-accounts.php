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
	require_once('inc/header.php');
	$passer="";
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
            <h2 class="desc">View All Accounts</h2>
            <form action="" method="post" enctype="multipart/form-data">
          <select name="sales-points" class="dropbox2">
          <option value="none">---SELECT SALES POINT---</option>
          <?php
		  $result=mysql_query("SELECT * FROM accounts");
		 while($row=mysql_fetch_assoc($result))
		 {
         	echo"<option value=$row[id]>$row[name]</option>";
		 }
		  ?>
          </select>&nbsp;
          <input name="submit" type="submit" value="Open" class="search_button">
          </form>
				<p>&nbsp;</p>
                <?php
				if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*10)-10);
				
				if(isset($_POST['submit']))
				{
				if($_POST['sales-points']=="none")
				{ echo "Select a sales point to view."; }
				
				else
				{
				$sp_id=$_POST['sales-points'];
				$result=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point='$sp_id'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "This sales point has not made any sales.";
				}
				else
				{
				
				$result=mysql_query("SELECT * FROM accounts WHERE id='$sp_id'");
		 		$row=mysql_fetch_array($result);	
				echo"<h2 class=title>$row[name]'s account book</h2>";
				
				$result=mysql_query("SELECT DISTINCT(date) FROM reciept WHERE sales_point='$sp_id' ORDER BY id DESC,date ASC");
				echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Date</th>
						<th align=center valign=middle scope=col>Sales</th>
    					<th align=center valign=middle scope=col>Expenses</th>
						<th align=center valign=middle scope=col>A/C</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{	
						$date=$row['date'];
						
						$result2=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp_id' and date='$date'");
						$row2=mysql_fetch_row($result2);
						
						
						$result3=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp_id' and date='$date'");
						$row3=mysql_fetch_row($result3);
						$ac=$row2[0]-$row3[0];
						$e_date=base64_encode($date);
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$date</td>
							<td align=center valign=middle>$row2[0]</td>
                            <td align=center valign=middle>$row3[0]</td>
							<td align=center valign=middle>$ac</td>
							<td align=center valign=middle><a href=\"view_expenses.php?e_id=$sp_id&token=$e_date\">Expenses</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"view_receipts.php?e_id=$sp_id&token=$e_date\">Receipts</a></td>
  							</tr>";
							$sn++;
					}
				}
				}
                        echo"</table>";
				}
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