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
    	$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
		$row=mysql_fetch_row($result);
		if($row[0]==0)
		{
			Redirect('sales.php');
		}
		else
		{
			require_once('inc/header.php');
			require_once('inc/sidebar.php');
			$passer="";
		}
	}
?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Cart</h2></div>
                	<?php
				if(isset($_POST['btnCont']))
				{
					Redirect('payment_info.php');
				}					
							echo"<table>
							<thead>
							<tr>
							<th scope=col>S/N</th>
							<th scope=col>Item Name</th>
							<th scope=col>Quantity</th>
							<th scope=col>Price</th>
							<th scope=col>Amount</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
  						$sp=$_SESSION['id'];
  						$result=mysql_query("SELECT * FROM cart WHERE sales_point = '$sp'");
  						$sn=1;
  						$total="";
  						while($row=mysql_fetch_assoc($result))
 						 {
							$id=base64_encode($row['id']);
							$total+=$row['amount'];
								echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[item_name]</td>
								<td class=align-center>$row[quantity]</td>
								<td class=align-center>$row[unit_price]</td>
								<td class=align-center>$row[amount]</td>
								<td><a href=\"edit_order.php?item=$id\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"drop-item.php?item=$id\" title=Drop><img src=\"img/trash.png\"></a></td>
								</tr>";	
								$sn++;
							}
							echo "</tbody></table>";
					?>
                    <div style="padding-left:15px;"><h2 class="desc">Total: <?php echo "&#8358;" ?> <?php echo $total=number_format($total,2)?>
                    </h2>
                    <form method="post"><button type="submit" class="add" name="btnCont">Continue</button></form>
                    </div>
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