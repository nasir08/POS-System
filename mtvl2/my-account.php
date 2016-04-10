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
            <div style="padding-left:15px;"><h2 class="desc">Book Of Account</h2></div>
                          <?php
				if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*10)-10);
				
				$result=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point='$sp' AND rev=0");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no sales by $_SESSION[name] in the database.";
				}
				else
				{
				
				$result=mysql_query("SELECT DISTINCT(date) FROM reciept WHERE sales_point='$sp' AND rev=0 ORDER BY id DESC,date ASC LIMIT $from,10");
				echo"<table>
							<thead>
							<tr>
                            <th scope=col>S/N</th>
							<th scope=col>Date</th>
							<th scope=col>Sales</th>
							<th scope=col>Expenses</th>
							<th scope=col>A/C</th>
							</tr>
							</thead>";
				
					$sn=1;
					while($row=mysql_fetch_assoc($result))
					{	
						$date=$row['date'];
						
						$result2=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$date' AND rev=0");
						$row2=mysql_fetch_row($result2);
						
						
						$result3=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$date'");
						$row3=mysql_fetch_row($result3);
						$ac=$row2[0]-$row3[0];
                        echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$date</td>
								<td class=align-center>$row2[0]</td>";
								if($row3[0]==0){ echo"<td class=align-center>-</td>"; }
								else{ echo"<td class=align-center>$row3[0]</td>"; }
								echo"<td class=align-center>$ac</td>
  							</tr>";
							$sn++;
						}
				}
						
                        echo"</tbody></table>";
				?>
                    <br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(DISTINCT(date)) FROM reciept WHERE sales_point='$sp' AND rev=0 ORDER BY id DESC,date ASC";
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
				</div>
			</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>