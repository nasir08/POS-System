<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	  }
	  else
	  {
         if(($_SESSION['type']!="admin") && ($_SESSION['type']!="manager"))
	 	 {
				Redirect('sales.php');
	 	 }
		 else
		{
			$sp=$_SESSION['id'];
			require_once('inc/header.php');
	 		require_once('inc/sidebar.php');
		}
     }
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">All Items</h2></div>
				<form method="post">
                	<div class="element">
						<input id="name" name="txtSearch" class="text err" autofocus placeholder="Enter Item Name Here..." />
						<button type="submit" class="add" name="btnSearch">Search</button>
					</div>
                </form>
                
                <?php
	if(isset($_GET['page']))
				{$page=$_GET['page'];}
				else{$page=1;}
				$from=(($page*30)-30);
?>
                
                	<?php
				if(isset($_POST['btnSearch']))
				{
					$q=mysql_real_escape_string(trim($_POST['txtSearch']));
						
						if($q=="")
						{
							echo "Your search didn't return any result.";
						}
						
						else
						{
						$result=mysql_query("SELECT COUNT(id) FROM goods WHERE item_name LIKE '%$q%'");
						$row=mysql_fetch_row($result);
						if($row[0]==0)
						{
							echo "Your search for \"$q\" didn't return any result.";
						}
						
						elseif($row[0]>0)
						{
							echo"<table>
							<thead>
							<tr>
							<th scope=col>Name</th>
							<th scope=col>Family</th>
							<th scope=col>Price</th>
							<th scope=col>Inventory</th>
							<th scope=col>Delimeter</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
						$result=mysql_query("SELECT * FROM goods WHERE item_name LIKE '%$q%' ORDER BY item_name");
				
					while($row=mysql_fetch_assoc($result))
					{	
						$id=base64_encode($row['id']);
						$item=base64_encode($row['item_name']);
                        echo"<tbody>
								<tr>
								<td class=align-center>$row[item_name]</td>
								<td class=align-center>$row[family]</td>
								<td class=align-center>$row[unit_price]</td>
								<td class=align-center>$row[amount_rem]&nbsp; piece(s)nge]</td>
								<td class=align-center>$row[delimeter]</td>
								<td><a href=\"edit-good.php?e_id=$id&continue=$page\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"delete-good.php?e_id=$id&continue=$page\" title=Delete><img src=\"img/trash.png\"></a></td>
								</tr>";
					}
				}
                        echo"</tbody></table>";
						}
						
						
				}
				else
				{
				$result=mysql_query("SELECT COUNT(id) FROM goods");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no goods in the database.";
				}
				else
				{
				$result=mysql_query("SELECT * FROM goods ORDER BY id DESC LIMIT $from,30");
				echo"<table>
							<thead>
							<tr>
							<th scope=col>Name</th>
							<th scope=col>Family</th>
							<th scope=col>Price</th>
							<th scope=col>Inventory</th>
							<th scope=col>Delimeter</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
						
					while($row=mysql_fetch_assoc($result))
					{	
						$id=base64_encode($row['id']);
						$item=base64_encode($row['item_name']);
                        echo"<tbody>
								<tr>
								<td class=align-center>$row[item_name]</td>
								<td class=align-center>$row[family]</td>
								<td class=align-center>$row[unit_price]</td>
								<td class=align-center>$row[amount_rem]&nbsp; piece(s)</td>
								<td class=align-center>$row[delimeter]</td>
								<td><a href=\"edit-good.php?e_id=$id&continue=$page\" title=Edit><img src=\"img/user_edit.png\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"delete-good.php?e_id=$id&continue=$page\" title=Delete><img src=\"img/trash.png\"></a></td>
								</tr>";
					}
				}
						
                        echo"</tbody></table>";
				}
				?>
                
                <br><br><br>
                  <?php
  if(!isset($_POST['txtSearch']))
  {
  echo"<center>";
         $query="SELECT COUNT(id) FROM goods";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=goods-archive.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=goods-archive.php?page=$next>Next</a>";}
        echo"</center>";
        echo"<br><br>";
		 }
  }
  ?>
                
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>