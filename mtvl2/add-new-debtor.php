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
            <div style="padding-left:15px;"><h2 class="desc">Add New Debtor</h2></div>
				<form method="post">
                
                <?php
		  if(isset($_POST['submit']))
		  {
			  $name=mysql_real_escape_string(trim($_POST['name']));
			  $balance=mysql_real_escape_string($_POST['balance']);
			  $checker=$_POST['checker'];
			  $rn=mysql_real_escape_string(trim($_POST['rn']));
			  if($name=="")
			  {
				  echo "Debtor Name field cannot be empty.<br><br>";
			  }
			  elseif($balance=="")
			  {
				  echo "Balance field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($balance))
			  {
				  echo "Balance must be a number.<br><br>";
			  }
			  
			  else
			  {
			  	if($checker=="")
			  	{
			  		if($rn=="")
			  		{
						echo "Receipt Number field cannot be empty.<br><br>";
			  		}
			  		elseif(!is_numeric($rn))
			  		{
						echo "Receipt Number must be a number.<br><br>";
					}
			  	}
			  	elseif($checker!="")
			  	{
			  		$rn=$checker;
			  	}
				
				if($checker=="")
				{
					$today=date('Y')."-".date('m')."-".date('d');
					$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
				$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
						if($ac<$balance){ echo "Debtor cannot be added by you due to insufficient funds in your account.<br><br>"; }
						else
						{
				 mysql_query("INSERT INTO debtors(name,balance,sales_point) VALUES('$name',0,'$sp')");
				 $result=mysql_query("SELECT id FROM debtors WHERE sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
				 $row=mysql_fetch_array($result);
				 
				 mysql_query("INSERT INTO debt_history(type,amount,debtor,sales_point,receipt,`date`) VALUES('Debt','$balance','$row[id]','$sp','$rn','$today')");
				 
				 
				 $result2=mysql_query("SELECT id FROM debt_history WHERE sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
				 $row2=mysql_fetch_array($result2);
				 $_SESSION['checker']=$rn;
				 
					 mysql_query("INSERT INTO expenses (date,purpose,amount,sales_point) VALUES('$today','[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account','$balance','$sp')");
                      
                      
                      
$ac=$ac-$balance;                      
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
Redirect('debt_report.php?debtor='.$row[id].'&token='.$row2[id]);
						}
				 }
				 elseif($checker!="")
				 {
					 $today=date('Y')."-".date('m')."-".date('d');
					 mysql_query("INSERT INTO debtors(name,balance,sales_point) VALUES('$name',0,'$sp')");
				 $result=mysql_query("SELECT id FROM debtors WHERE sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
				 $row=mysql_fetch_array($result);
				 
				 mysql_query("INSERT INTO debt_history(type,amount,debtor,sales_point,receipt,`date`) VALUES('Debt','$balance','$row[id]','$sp','$rn','$today')");
				 
				 
				 $result2=mysql_query("SELECT id FROM debt_history WHERE sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
				 $row2=mysql_fetch_array($result2);
				 $_SESSION['checker']=$rn;
				 Redirect('debt_report.php?debtor='.$row[id].'&token='.$row2[id]);  
				 }
			  }
		  }
		  ?>
                	<div class="element">
                    	<label for="category">Debtor Name</label>
						<input type="text" name="name" class="mini-text err" autofocus>
					</div>
                	<div class="element">
                    	<label for="category">Debit Balance</label>
						<input type="number" name="balance" class="mini-text err">
					</div>
                    <div class="element">
						<input type="checkbox" name="checker" value="Transfer From Debtors Book" /> Check, If You're Transfering From Debtors Book 
					</div>
                    <div class="element">
                    	<label for="category">Sales Receipt No</label>
						<input type="number" name="rn" class="mini-text err">
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