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
            <h2 class="desc">Expenses Catalog</h2>
            <?php
		  if(isset($_POST['submit']))
		  {
			  $purpose=mysql_real_escape_string(trim($_POST['purpose']));
			  $amount=trim($_POST['amount']);
			  
			  
			  if($purpose=="")
			  {
			  	echo "Purpose field cannot be empty.<br><br>";
			  }
			  elseif($amount=="")
			  {
			  	echo "Amount field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($amount))
			  {
			  	echo "Amount must be a number.<br><br>";
			  }
              elseif($amount<0)
			  {
			  	echo "Amount cannot be a negative number.<br><br>";
			  }
			  else
			  {
				  $today=date('Y')."-".date('m')."-".date('d');
				  $result=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
					$row=mysql_fetch_row($result);
				  $result2=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
				 $row2=mysql_fetch_row($result2);
				 $ac=$row[0]-$row2[0];
				  if($ac==0)
				  {
					  echo "You don't have money in your account at the moment.<br><br>";
				  }
			  	  elseif($amount>$ac)
				  {
					 echo "Insuffucient funds, you have only $ac.<br><br>"; 
				  }
				  else
				  {
					  mysql_query("INSERT INTO expenses (date,purpose,amount,sales_point) VALUES('$today','$purpose','$amount','$sp')");
                      
                      
                      
                      $result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
	
				  }
			  }
		  }
		  ?>
          <form action="" method="post" enctype="multipart/form-data">
                <input name="purpose" class="input" type="text" style="width:420px" placeholder="Purpose" value=<?php if(isset($_POST['submit'])){ echo $purpose; } ?> >  &nbsp;&nbsp;&nbsp;
                    <input name="amount" class="input" type="text" placeholder="Amount" value=<?php if(isset($_POST['submit'])){ echo $amount; } ?> > &nbsp; &nbsp;
                    <input type="submit" class="regular_button" value="Submit" name="submit">
                </form>
				<p>&nbsp;</p>
                 <?php
				$result=mysql_query("SELECT COUNT(id) FROM expenses WHERE sales_point='$sp'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no expenses in the database for $_SESSION[name].";
				}
				else
				{
				echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Date</th>
    					<th align=center valign=middle scope=col>Purpose</th>
    					<th align=center valign=middle scope=col>Amount</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
				
					$sn=1;
					if(isset($_GET['page']))
					{$page=$_GET['page'];}
					else{$page=1;}
					$from=(($page*30)-30);
				
					$result=mysql_query("SELECT * FROM expenses WHERE sales_point='$sp' ORDER BY id DESC LIMIT $from,30");
					while($row=mysql_fetch_assoc($result))
					{
						$id=base64_encode($row['id']);	
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$row[date]</td>
                            <td align=center valign=middle>$row[purpose]</td>
   							<td align=center valign=middle>$row[amount]</td>
							<td align=center valign=middle><a href=delete-expense.php?e_id=$id&continue=$page>Delete</a></td>
  							</tr>";
							$sn++;
					}
				}
						
                        echo"</table>";
				?>   
                    
                  <br><br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(id) FROM expenses WHERE sales_point='$sp'";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=expenses.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=expenses.php?page=$next>Next</a>";}
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