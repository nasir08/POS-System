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
	}
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">All Debtors</h2></div>
                          <?php
				if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
				
				$result=mysql_query("SELECT COUNT(id) FROM debtors");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no debtors in the database.";
				}
				else
				{
				
				$result=mysql_query("SELECT * FROM debtors ORDER BY id DESC LIMIT $from,30");
				echo"<table>
							<thead>
							<tr>
                            <th scope=col>S/N</th>
							<th scope=col>Name</th>
							<th scope=col>Balance</th>
							<th scope=col>Action</th>
							</tr>
							</thead>";
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{
						$row['balance']=number_format($row['balance'],2);	
                        echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[name]</td>
								<td class=align-center>$row[balance]</td>
								<td class=align-center><a href=history.php?debtor=$row[id]>View History</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href=payment.php?debtor=$row[id]>Make Payment</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href=add-debt.php?debtor=$row[id]>Add Debt</a></td>
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