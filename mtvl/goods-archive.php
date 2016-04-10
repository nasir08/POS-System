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
			$passer="";
    		$sp=$_SESSION['id'];
	 		}
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
      <?php
	require_once('inc/logo.php');
	if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
?>
      
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
            <h2 class="desc">Goods Archive</h2>
            <a href="add-new-item.php">Add new item</a> &nbsp;
                <a href="inventory.php">Inventory</a><br><br><br>
            <form action="#" method="post">
                    <input name="txtSearch" class="search_input" type="text" value="Enter item name here" onBlur="if(this.value=='') this.value='Enter item name here'" onFocus="if(this.value =='Enter item name here' ) this.value=''" />
                    <input type="submit" class="search_button" value="search" name="btnSearch"><br><br>
                    
                    <?php
				if(isset($_POST['btnSearch']))
				{
					$q=mysql_real_escape_string(trim($_POST['txtSearch']));
						
						if($q=="")
						{
							echo "Your search didn't return any result.";
						}
						
						else
						{
						$result=mysql_query("SELECT COUNT(id) FROM goods WHERE item_name LIKE '%$q%'");
						$row=mysql_fetch_row($result);
						if($row[0]==0)
						{
							echo "Your search for \"$q\" didn't return any result.";
						}
						
						elseif($row[0]>0)
						{
							echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Item Name</th>
						<th align=center valign=middle scope=col>Family</th>
						<th align=center valign=middle scope=col>Price</th>
    					<th align=center valign=middle scope=col>Inventory</th>
						<th align=center valign=middle scope=col>Delimeter</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
						$sn=1;
						$result=mysql_query("SELECT * FROM goods WHERE item_name LIKE '%$q%'");
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{	
						$id=base64_encode($row['id']);
						$item=base64_encode($row['item_name']);
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$row[item_name]</td>
							<td align=center valign=middle>$row[family]</td>
							<td align=center valign=middle>$row[unit_price]</td>
                            <td align=center valign=middle>$row[amount_rem]&nbsp; piece(s)</td>
							<td align=center valign=middle>$row[delimeter]</td>
							<td align=center valign=middle><a href=\"edit-good.php?e_id=$id&continue=$page\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"delete-good.php?e_id=$id&continue=$page\" title=Delete><img src=\"img/trash.png\"></a></td>
  							</tr>";
							$sn++;
					}
				}
                        echo"</table>";
						}
						
						
				}
				else
				{
				$result=mysql_query("SELECT COUNT(id) FROM goods");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no goods in the database.";
				}
				else
				{
				$result=mysql_query("SELECT * FROM goods ORDER BY item_name LIMIT $from,30");
				echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Item Name</th>
						<th align=center valign=middle scope=col>Family</th>
						<th align=center valign=middle scope=col>Price</th>
    					<th align=center valign=middle scope=col>Inventory</th>
						<th align=center valign=middle scope=col>Delimeter</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{	
						$id=base64_encode($row['id']);
						$item=base64_encode($row['item_name']);
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$row[item_name]</td>
							<td align=center valign=middle>$row[family]</td>
							<td align=center valign=middle>$row[unit_price]</td>
                            <td align=center valign=middle>$row[amount_rem]&nbsp; piece(s)</td>
							<td align=center valign=middle>$row[delimeter]</td>
							<td align=center valign=middle><a href=\"edit-good.php?e_id=$id&continue=$page\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"delete-good.php?e_id=$id&continue=$page\" title=Delete><img src=\"img/trash.png\"></a></td>
  							</tr>";
							$sn++;
					}
				}
						
                        echo"</table>";
				}
				?>

                 
                    
                    
                  <br><br><br><br>
                  <?php
  if(!isset($_POST['txtSearch']))
  {
  echo"<center>";
         $query="SELECT COUNT(id) FROM goods";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=goods-archive.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=goods-archive.php?page=$next>Next</a>";}
        echo"</center>";
        echo"<br><br>";
		 }
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