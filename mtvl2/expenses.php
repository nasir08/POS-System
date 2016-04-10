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
            <div style="padding-left:15px;"><h2 class="desc">Expenses</h2></div>
				<form method="post">
                	<div class="element">
						<input id="name" name="purpose" class="mini-text err" autofocus placeholder="Purpose" />
                        <input id="name" name="amount" class="mini-text err" placeholder="Amount" />
						<button type="submit" class="add" name="submit">Submit</button>
					</div>
                </form>
                <?php
                	if(isset($_POST['submit']))
		  {
			  $purpose=mysql_real_escape_string(trim($_POST['purpose']));
			  $amount=trim($_POST['amount']);
			  
			  
			  if($purpose=="")
			  {
			  	echo "Purpose field cannot be empty.<br><br>";
			  }
			  elseif($amount=="")
			  {
			  	echo "Amount field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($amount))
			  {
			  	echo "Amount must be a number.<br><br>";
			  }
              elseif($amount<0)
			  {
			  	echo "Amount cannot be a negative number.<br><br>";
			  }
			  else
			  {
				  $today=date('Y')."-".date('m')."-".date('d');
				  $result=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
					$row=mysql_fetch_row($result);
				  $result2=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
				 $row2=mysql_fetch_row($result2);
				 $ac=$row[0]-$row2[0];
				  if($ac==0)
				  {
					  echo "You don't have money in your account at the moment.<br><br>";
				  }
			  	  elseif($amount>$ac)
				  {
					 echo "Insuffucient funds, you have only $ac.<br><br>"; 
				  }
				  else
				  {
					  mysql_query("INSERT INTO expenses (date,purpose,amount,sales_point) VALUES('$today','$purpose','$amount','$sp')");
                      
                      
                      
                      $result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
	
				  }
			  }
		  }
		  ?>
          
          		<?php
				$result=mysql_query("SELECT COUNT(id) FROM expenses WHERE sales_point='$sp'");
				$row=mysql_fetch_row($result);
				if($row[0]==0)
				{
					echo "There are currently no expenses in the database for $_SESSION[name].";
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
							<th scope=col style=\"width: 65px;\">Action</th>
							</tr>
							</thead>";
				
					$sn=1;
					if(isset($_GET['page']))
					{$page=$_GET['page'];}
					else{$page=1;}
					$from=(($page*30)-30);
				
					$result=mysql_query("SELECT * FROM expenses WHERE sales_point='$sp' ORDER BY id DESC LIMIT $from,30");
					while($row=mysql_fetch_assoc($result))
					{
						$id=base64_encode($row['id']);
						echo"<tbody>
								<tr>
								<td class=align-center>$sn</td>
								<td class=align-center>$row[date]</td>
								<td class=align-center>$row[purpose]</td>
								<td class=align-center>$row[amount]</td>
								<td><a href=delete-expense.php?e_id=$id&continue=$page>Delete</a></td>
								</tr>";	
							$sn++;	
					}
				}
						
                        echo"</tbody></table>";
				?>   
                    
                  <br><br><br>	
				<?php
  echo"<center>";
         $query="SELECT COUNT(id) FROM expenses WHERE sales_point='$sp'";
         $rs=mysql_query($query);
         $row=mysql_fetch_row($rs);
         $totalRecords=$row[0];
         $total_pages=ceil($totalRecords/30);
         
		 
		 if($total_pages>1)
         {
		 $next=$page+1;
		 $prev=$page-1;
		 if($page>1){echo "<a href=expenses.php?page=$prev>Prev</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
         echo "Page ".$page." of ".$total_pages;
		 if($total_pages>$page){echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=expenses.php?page=$next>Next</a>";}
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