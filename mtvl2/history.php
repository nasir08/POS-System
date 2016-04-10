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
		$debtor=$_GET['debtor'];
	require_once('inc/header.php');
	require_once('inc/sidebar.php');
	}
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Debt History</h2></div>
            $row['balance']=number_format($row['balance'],2);	
                          <?php
				if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
				
				$result=mysql_query("SELECT COUNT(id) FROM debt_history WHERE debtor='$debtor'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no debts for this customer.";
				}
				else
				{
				
				$result=mysql_query("SELECT * FROM debt_history WHERE debtor='$debtor' ORDER BY id DESC LIMIT $from,30");
				echo"<table>
							<thead>
							<tr>
							<th scope=col>Date</th>
                            <th scope=col>Type</th>
							<th scope=col>Amount</th>
							<th scope=col>Sales Point</th>
							<th scope=col>Receipt Number</th>
							</tr>
							</thead>";
							
					while($row=mysql_fetch_assoc($result))
					{	
                        echo"<tbody>
								<tr>
								<td class=align-center>$row[date]</td>
								<td class=align-center>$row[type]</td>
								<td class=align-center>$row[amount]</td>
								<td class=align-center>$row[sales_point]</td>
								<td class=align-center>$row[receipt]</td>
  							</tr>";
							$sn++;
						}
				}
						
                        echo"</tbody></table>";
				?>
                    <br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(id) FROM debtors ORDER BY id DESC";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=all-debtors.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=all-debtors.php?page=$next>Next</a>";}
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