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
            <div style="padding-left:15px;"><h2 class="desc"><?php echo $_SESSION['user'] ?>'s Receipt</h2></div>
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
				$result=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point='$spp' AND date='$date' AND rev=0");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no receipts in the database for $name on $date.";
				}
				else
				{
				$result=mysql_query("SELECT * FROM reciept WHERE sales_point='$spp' AND date='$date' AND rev=0 ORDER BY id DESC");
				while($row=mysql_fetch_assoc($result))
					{
						
							
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
                            <td align=center valign=middle>$rn</td>
                            <td align=center valign=middle>$row[name]</td>
   							<td align=center valign=middle>$row[amount]</td>
							<td align=center valign=middle>$row[r_change]</td>
    						<td align=center valign=middle>$row[date]</td>
							<td align=center valign=middle><a href=archived-reciept.php?rn=$e_rn>View</a></td>
  							</tr>";
					}
				}
						
                        echo"</table>";
				?>
				</div>
			</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>