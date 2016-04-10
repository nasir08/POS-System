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
    	$result=mysql_query("SELECT COUNT(id) FROM waiting");
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
            <div style="padding-left:15px;"><h2 class="desc">Waiting Customers</h2></div>
            <table>
							<thead>
							<tr>
                            <th scope=col>S/N</th>
							<th scope=col>Customer ID</th>
							<th scope=col>Amount</th>
                            <th scope=col>Items</th>
							<th scope=col>Layed-off By</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>
                          <?php
					if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
				
				$sn=1;
				$result=mysql_query("SELECT DISTINCT(customer) FROM waiting ORDER BY id DESC");
					while($row=mysql_fetch_assoc($result))
					{
						$result2=mysql_query("SELECT SUM(amount) As amount,COUNT(id) As num,(sales_point) FROM waiting WHERE customer=$row[customer]");
						while($row2=mysql_fetch_assoc($result2))
						{
							$result3=mysql_query("SELECT name FROM accounts WHERE id='$row2[sales_point]'");
							$row3=mysql_fetch_assoc($result3);
								echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[customer]</td>
								<td class=align-center>$row2[amount]</td>
								<td class=align-center>$row2[num]</td>
								<td class=align-center>$row3[name]</td>
								<td class=align-center><a href=accept.php?customer=$row[customer]>Accept</a>&nbsp;&nbsp;&nbsp;
								<a href=delete-waiting.php?customer=$row[customer]>Delete</a>
								</td>
  							</tr>";
							$sn++;
						}
					}
							echo "</tbody></table>";
					?>
				</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>