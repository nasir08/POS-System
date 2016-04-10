<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
	$sp=$_SESSION['id'];
	require_once('inc/header.php');
	require_once('inc/sidebar.php');
	$passer="";
	}
?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">All Invoices</h2>
            <a class="button" href="search-receipt.php">Search Receipt</a></div>
            <table>
							<thead>
							<tr>
							<th scope=col>Receipt N0</th>
							<th scope=col>Name</th>
							<th scope=col>Amount</th>
							<th scope=col>Change</th>
							<th scope=col>Date</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>
                          <?php
				$result=mysql_query("SELECT COUNT(id) FROM reciept");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no receipts in the database.";
				}
				else
				{
					if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
				
				$result=mysql_query("SELECT * FROM reciept WHERE rev=0 ORDER BY id DESC LIMIT $from,30");
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
								echo"<tbody>
								<tr>
								<td class=align-center>$rn</td>
								<td class=align-center>$row[name]</td>
								<td class=align-center>$row[amount]</td>
								<td class=align-center>$row[r_change]</td>
								<td class=align-center>$row[date]</td>
								<td align=center valign=top><a href=archived-reciept.php?rn=$e_rn&continue=receipt-archive.php&token=$page>View</a> &nbsp;";
					if($row['change']>0)
					{	
						if($row2['name']==$_SESSION['name'])	
							echo"<a href=delete-change.php?rn=$e_rn&continue=receipt-archive.php&token=$page>Delete change</a>";
					}
					if($_SESSION['type']=="admin")
					{
						echo"<br><br><br><a href=manage_reciept/delete.php?rn=$row[id]>Delete</a><br><br><br>";
					}
							echo"</td>
  							</tr>";
							$sn++;
					}
				
							}
							echo "</tbody></table>";
					?>
                    <br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(id) FROM reciept WHERE rev=0";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=receipt-archive.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=receipt-archive.php?page=$next>Next</a>";}
        echo"</center>";
        echo"<br><br>";
		 }
  ?>
				</div>
			</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>