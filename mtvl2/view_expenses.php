<?php
	require_once('inc/functions.php');
	session_start();
	if($_SESSION['type']!="admin")
	{ 
			Redirect('sales.php');
	 }
	
	
	  if(!(isset($_SESSION['id'])))
	  {
	  	Redirect('signout.php'); 
	  }
	  else
	  {
	  	if(isset($_GET['e_id']))
		{
			if(isset($_GET['token']))
			{
				$spp=$_GET['e_id'];
				$sp=$_SESSION['id'];
				require_once('inc/header.php');
				require_once('inc/sidebar.php');
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

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc"><?php echo $_SESSION['user'] ?>'s Expenses</h2></div>
				
                <?php
				$result=mysql_query("SELECT COUNT(id) FROM expenses WHERE sales_point='$spp' AND date='$date'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no expenses in the database for $_SESSION[user] on $date.";
				}
				else
				{
					echo"<table>
							<thead>
							<tr>
							<th scope=col>S/N</th>
							<th scope=col>Date</th>
							<th scope=col>Purpose</th>
							<th scope=col>Amount</th>
							</tr>
							</thead>";
				
					$sn=1;
				
					$result=mysql_query("SELECT * FROM expenses WHERE sales_point='$spp' AND date='$date' ORDER BY id DESC");
					while($row=mysql_fetch_assoc($result))
					{
						$id=base64_encode($row['id']);
						echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[date]</td>
								<td class=align-center>$row[purpose]</td>
								<td class=align-center>$row[amount]</td>
								</tr>";	
							$sn++;	
					}
				}
						
                        echo"</tbody></table>";
				?>   
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>