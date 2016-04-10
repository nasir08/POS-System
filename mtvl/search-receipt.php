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
          <li><a href=".php"></a></li>
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
            <h2 class="desc">Search Receipt</h2>
				<form id="form1" method="post" action="">
                <b>Search By</b> &nbsp;<select name="option" class="dropbox">
                <option value="rn">Receipt Number [Default]</option>
                <option value="cn">Customer Name</option>
                <option value="date">Date</option>
                <option value="am">Amount</option>
                <option value="sp">Sales Point</option>
                </select><br><br>
                    <input name="txtSearch" class="search_input" type="text" value="Enter Search Criteria here" onBlur="if(this.value=='') this.value='Enter Search Criteria here'" onFocus="if(this.value =='Enter Search Criteria here' ) this.value=''" />
                    <input type="submit" class="search_button" value="search" name="btnSearch">
		    </form>
				<p>&nbsp;</p>
                <?php
				if(isset($_POST['btnSearch']))
				{
					$check="check";
					$q=mysql_real_escape_string(trim($_POST['txtSearch']));
					if($q=="")
					{
						echo"Please enter a search string.";
					}
					
					else
					{
						$criteria=$_POST['option'];
						if($criteria=="rn")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE id = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE id = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="cn")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE name LIKE '%$q%'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE name LIKE '%$q%' ORDER BY id DESC");
						}
						elseif($criteria=="date")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE date = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE date = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="am")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE amount = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE amount = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="sp")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE sales_point = '$q' ORDER BY id DESC");
						}
						
						
						
						if($row2[0]==0)
						{
							echo "Your search for \"$q\" did not return any result";
						}
						
						else
						{
				echo"<table width=100%>
  						<tr class=resultHeader height=33px>
    					<th align=center valign=middle scope=col>S/N</th>
    					<th align=center valign=middle scope=col>Receipt Number</th>
    					<th align=center valign=middle scope=col>Customer Name</th>
    					<th align=center valign=middle scope=col>Amount</th>
						<th align=center valign=middle scope=col>Change</th>
                        <th align=center valign=middle scope=col>Date</th>
                        <th align=center valign=middle scope=col>Sold By</th>
						<th align=center valign=middle scope=col>Action</th>
  						</tr>";
				
				    $sn=1;
					while($row=mysql_fetch_assoc($result))
					{
						$sp=$row['sales_point'];
						$result2=mysql_query("SELECT name FROM accounts WHERE id='$sp'");
						$row2=mysql_fetch_array($result2);
							
						$rn=$row['id'];
						$e_rn=base64_encode($row['id']);
					 	if(strlen($rn)==1)
					 	$rn="000000".$rn;
					 	elseif(strlen($rn)==2)
					 	$rn="00000".$rn;
					 	elseif(strlen($rn)==3)
					 	$rn="0000".$rn;
					 	elseif(strlen($rn)==4)
					 	$rn="000".$rn;
						elseif(strlen($rn)==5)
					 	$rn="00".$rn;
						elseif(strlen($rn)==6)
					 	$rn="0".$rn;
					 	elseif(strlen($rn)>6)
					 	$rn=$rn;
							
                        echo"<tr class=result>
    						<td align=center valign=middle>$sn</td>
                            <td align=center valign=middle>$rn</td>
                            <td align=center valign=middle>$row[name]</td>
   							<td align=center valign=middle>$row[amount]</td>
							<td align=center valign=middle>$row[r_change]</td>
    						<td align=center valign=middle>$row[date]</td>
    						<td align=center valign=middle>$row2[name]</td>
							<td align=center valign=middle><a href=archived-reciept.php?rn=$e_rn&continue=search-receipt.php>View</a> &nbsp;";
							if($row['change']>0)
							{
								if($row2['name']==$_SESSION['name'])		
							echo"<a href=delete-change.php?rn=$e_rn&continue=receipt-archive.php>Delete change</a>";
							}
							if($_SESSION['type']=="admin")
					{
						echo"<br><br><br><a href=manage_reciept/delete.php?rn=$row[id]>Delete</a><br><br><br>";
					}
							echo"</td>
  							</tr>";
							$sn++;
					}
						
                        echo"</table>";
					}
					}
				}
			?>



                    
                    
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