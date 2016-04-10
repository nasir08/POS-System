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
		$today=date('Y')."-".date('m')."-".date('d');
		$result=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
					$row=mysql_fetch_row($result);
				  if($row[0]==0)
				  {
					  $result=mysql_query("SELECT amount FROM balance_bf WHERE sales_point='$sp'");
					$row=mysql_fetch_row($result);
					if($row[0]==0)
					{}
					else
					{
						$_SESSION['balance_bf']=$row[0];
						Redirect("balance-to-sales.php");
					}
				  }
			  	  else
				  {
					  
				  }
		
		
	require_once('inc/header.php');
	require_once('inc/sidebar.php');
	$passer="";
	}
?>

		<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
				<form method="post">
                	<div class="element">
						<label for="name">Search Item</label>
						<input id="name" name="txtSearch" class="text err" autofocus placeholder="Enter Item Name Here..." />
						<button type="submit" class="add" name="btnSearch">Search</button>
					</div>
                </form>
                	<?php
					if(isset($_POST['btnSearch']))
					{
						$q=mysql_real_escape_string(trim($_POST['txtSearch']));
						
						if($q=="")
						{
							echo "<div class=n_error><p>Error notification. Your search didn't return any result.</p></div>";
						}
					else
					{
						$result=mysql_query("SELECT COUNT(id) FROM goods WHERE item_name LIKE '%$q%'");
						$row=mysql_fetch_row($result);
						if($row[0]==0)
						{
							echo "<div class=n_error><p>Error notification. Your search for \"$q\" didn't return any result.</p></div>";
						}
						elseif($row[0]>0)
						{
							echo"<table>
							<thead>
							<tr>
							<th scope=col>S/N</th>
							<th scope=col>Item Name</th>
							<th scope=col>Price</th>
							<th scope=col>Inventory</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
							$sn=1;
							$result=mysql_query("SELECT * FROM goods WHERE item_name LIKE '%$q%'");
							while($row=mysql_fetch_assoc($result))
							{
								$id=base64_encode($row['id']);
								echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[item_name]</td>
								<td class=align-center>$row[unit_price]</td>
								<td class=align-center>$row[amount_rem] &nbsp; piece(s)</td>";
								if($row['amount_rem']>0){ echo"<td><a href=order.php?item=$id>Select Item</a></td>"; }
								echo"</tr>";	
								$sn++;
							}
							echo "</tbody></table>";
						}
					  }
					}
					?>
				<div class="entry">
					<div class="sep"></div>		
					<a class="button" href="lay-off.php">Lay-Off Customer</a> 
                    <?php 
  						if($passer=="")
  						echo"<a class=button href=cancel_order.php?sales_point=$_SESSION[id]>Cancel Item Selection</a>"; 
  					?>  
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>