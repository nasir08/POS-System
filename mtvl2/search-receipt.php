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
            <div style="padding-left:15px;"><h2 class="desc">Search Invoice</h2></div>
				<form method="post">
                	<div class="element">
                	<label for="category">Search By</label>
                	<select name="option" class="err">
                            <option value="rn">Receipt Number [Default]</option>
                			<option value="cn">Customer Name</option>
                			<option value="date">Date</option>
                			<option value="am">Amount</option>
                			<option value="sp">Sales Point</option>
						</select>
                     </div>
                	<div class="element">
						<input id="name" name="txtSearch" class="text err" autofocus placeholder="Enter Search Criteria Here..." />
						<button type="submit" class="add" name="btnSearch">Search</button>
					</div>
                </form>
                	<?php
				if(isset($_POST['btnSearch']))
				{
					$check="check";
					$q=mysql_real_escape_string(trim($_POST['txtSearch']));
					if($q=="")
					{
						echo"Please enter a search string.";
					}
					
					else
					{
						$criteria=$_POST['option'];
						if($criteria=="rn")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE id = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE id = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="cn")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE name LIKE '%$q%'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE name LIKE '%$q%' ORDER BY id DESC");
						}
						elseif($criteria=="date")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE date = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE date = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="am")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE amount = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE amount = '$q' ORDER BY id DESC");
						}
						elseif($criteria=="sp")
						{
							$result2=mysql_query("SELECT COUNT(id) FROM reciept WHERE sales_point = '$q'");
							$row2=mysql_fetch_row($result2);
							
							$result=mysql_query("SELECT * FROM reciept WHERE sales_point = '$q' ORDER BY id DESC");
						}
						
						
						
						if($row2[0]==0)
						{
							echo "Your search for \"$q\" did not return any result";
						}
						
						else
						{
							echo"<table>
							<thead>
							<tr>
							<th scope=col>Receipt No</th>
							<th scope=col>Name</th>
							<th scope=col>Amount</th>
							<th scope=col>Change</th>
							<th scope=col>Date</th>
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
							while($row=mysql_fetch_assoc($result))
					{
						$sp=$row['sales_point'];
						$result2=mysql_query("SELECT name FROM accounts WHERE id='$sp'");
						$row2=mysql_fetch_array($result2);
							
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
							
								echo"<tbody>
								<tr>
								<td class=align-center>$rn</td>
								<td class=align-center>$row[name]</td>
								<td class=align-center>$row[amount]</td>
								<td class=align-center>$row[r_change]</td>
								<td class=align-center>$row[date]</td>
								<td class=align-center><a href=archived-reciept.php?rn=$e_rn&continue=search-receipt.php>View</a> &nbsp;";
								if($row['change']>0)
							{
								if($row2['name']==$_SESSION['name'])		
							echo"<a href=delete-change.php?rn=$e_rn&continue=receipt-archive.php>Delete change</a>";
							}
							if($_SESSION['type']=="admin")
					{
						echo"<br><br><br><a href=manage_reciept/delete.php?rn=$row[id]>Delete</a><br><br><br>";
					}
							echo"</td>";
								echo"</tr>";
							}
							echo "</tbody></table>";
						}
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