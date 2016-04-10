<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		if($_SESSION['type']!="admin")
	 { 
		Redirect('sales.php'); 
	 }
	 else
	 {
		 $sp=$_SESSION['id'];
		 $passer="";
		require_once('inc/header.php');
		require_once('inc/sidebar.php');
	 }
	}
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">All Users</h2></div>
            <table>
							<thead>
							<tr>
							<th scope=col>Name</th>
							<th scope=col>Username</th>
							<th scope=col>Type</th>
							<th scope=col>Phone</th>
							<th scope=col>Status</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>
                          <?php
				$result=mysql_query("SELECT COUNT(id) FROM accounts");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no accounts in the database.";
				}
				else
				{
					if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
				
				$result=mysql_query("SELECT * FROM accounts ORDER BY id DESC LIMIT $from,30");
					while($row=mysql_fetch_assoc($result))
					{
						$spp=$row['id'];
								echo"<tbody>
								<tr>
								<td class=align-center>$row[name]</td>
								<td class=align-center>$row[uname]</td>
								<td class=align-center>$row[type]</td>
								<td class=align-center>0$row[phone]</td>";
								if($row[status]==0){ echo"<td class=align-center><a href=block.php?user=$spp title=\"Block User\"><img src=img/i_block_users.png></a></td>"; }
								else { echo"<td class=align-center><a href=unblock.php?user=$spp title=\"Unblock User\"><img src=img/i_ok.png></a></td>"; }
								echo"<td align=center valign=top><a href=account.php?user=$spp>View Account</a><td>
  							</tr>";
					}
				
							}
							echo "</tbody></table>";
					?>
                    <br><br><br>
                  <?php
  echo"<center>";
         $query="SELECT COUNT(id) FROM accounts";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=all-accounts.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=all-accounts.php?page=$next>Next</a>";}
        echo"</center>";
        echo"<br><br>";
		 }
  ?>
				</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>