<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
	require_once('inc/header.php');
	$passer="";
	$sp=$_SESSION['id'];
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
            <h2 class="desc">Book Of Accounts</h2><br>
            <?php
				if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*10)-10);
				
				$result=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point='$sp'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no sales by $_SESSION[name] in the database.";
				}
				else
				{
				
				$result=mysql_query("SELECT DISTINCT(date) FROM reciept WHERE sales_point='$sp' ORDER BY id DESC,date ASC LIMIT $from,10");
				echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Date</th>
						<th align=center valign=middle scope=col>Sales</th>
    					<th align=center valign=middle scope=col>Expenses</th>
						<th align=center valign=middle scope=col>A/C</th>
  						</tr>";
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{	
						$date=$row['date'];
						
						$result2=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$date'");
						$row2=mysql_fetch_row($result2);
						
						
						$result3=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$date'");
						$row3=mysql_fetch_row($result3);
						$ac=$row2[0]-$row3[0];
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$date</td>
							<td align=center valign=middle>$row2[0]</td>
                            <td align=center valign=middle>$row3[0]</td>
							<td align=center valign=middle>$ac</td>
  							</tr>";
							$sn++;
						}
				}
						
                        echo"</table>";
				?>
                    
                  <br><br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(DISTINCT(date)) FROM reciept WHERE sales_point='$sp' ORDER BY id DESC,date ASC";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/10);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=my-account.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=my-account.php?page=$next>Next</a>";}
        echo"</center>";
        echo"<br><br>";
		 }
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