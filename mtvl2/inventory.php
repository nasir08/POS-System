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
            <div style="padding-left:15px;"><h2 class="desc">Inventory</h2></div>
				<form method="post">
                
                <?php
		  if(isset($_POST['submit']))
		  {
			  $item=$_POST['item'];
			  $sdate=trim($_POST['sdate']);
			  $edate=trim($_POST['edate']);
			  $type=$_POST['type'];
			  
			  if($sdate=="")
			  {
				  echo"Start date cannot be empty.<br><br>";
			  }
			  elseif($edate=="")
			  {
				  echo"End date cannot be empty.<br><br>";
			  }
			  
			  
			  else
			  {
				  if($type=="number")
				  {
				  $result=mysql_query("SELECT * FROM goods WHERE id='$item'");
				  $row=mysql_fetch_array($result);
				  $item_name=$row['item_name'];
				  $del=$row['delimeter'];
				  
				  $result=mysql_query("SELECT * FROM reciept_goods WHERE date BETWEEN '$sdate' AND '$edate' and good_id ='$item'");
				  $qty="";
				  while($row=mysql_fetch_assoc($result))
				  {
				  	$qty+=$row['quantity'];
				  }
				  $conv=$del*$qty;
				  echo"<b>You have sold $conv piece(s) of $item_name between $sdate and $edate.</b><br><br>";
			  }
			  
			  
			  elseif($type=="amount")
			  {
				  $result=mysql_query("SELECT * FROM goods WHERE id='$item'");
				  $row=mysql_fetch_array($result);
				  $item_name=$row['item_name'];
				  
				  $result=mysql_query("SELECT SUM(amount) FROM reciept_goods WHERE good_id='$item' and date BETWEEN '$sdate' AND '$edate'");
				  $row=mysql_fetch_row($result);
                  if($row[0]==0)
				  echo"<b>You have made 0.00 from $item_name between $sdate and $edate.</b><br><br>";
                  else
                  echo"<b>You have made $row[0] from $item_name between $sdate and $edate.</b><br><br>";
			  }
			  }
		  }
		  
		  elseif(isset($_POST['cancel']))
		  {
			  Redirect('goods-archive.php');
		  }
		  ?>
                
                <div class="element">
						<input type="radio" name="type" value="number" checked="checked" /> Number of Goods Sold &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="amount" /> Amount of Goods Sold
				</div>
                    
                	<div class="element">
                	<label for="category">Item Name</label>
                	<select name="item" class="err">
                            <?php
	$result=mysql_query("SELECT * FROM Goods");
	while($row=mysql_fetch_assoc($result))
    echo"<option value=$row[id]>$row[item_name]</option>";
	?>
						</select>
                     </div>
                	<div class="element">
                    	<label for="category">Start Date</label>
						<input type="date" name="sdate" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">End Date</label>
						<input type="date" name="edate" class="mini-text err">
					</div>
                    <div class="element">
						<button type="submit" class="add" name="submit">Submit</button>
					</div>
                </form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>