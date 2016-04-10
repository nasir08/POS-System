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
<?php
	$resulta=mysql_query("SELECT * FROM debtors WHERE id='$_GET[debtor]'");
	$rowa=mysql_fetch_assoc($resulta);
	$bal=number_format($rowa['balance'],2);
?>
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Make Payment</h2></div>
            <div style="padding-left:15px;"><h2 class="desc"><?php echo $rowa['name']. " - Balance: ".$bal ?></h2></div>
				<form method="post">
                
                <?php
		  if(isset($_POST['submit']))
		  {
			  $amount=mysql_real_escape_string($_POST['amount']);
			  if($amount=="")
			  {
				  echo "Amount field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($amount))
			  {
				  echo "Amount must be a number.<br><br>";
			  }
			  else
			  {
			  $today=date('Y')."-".date('m')."-".date('d');
					$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
				$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
				 
				 mysql_query("INSERT INTO debt_history(type,amount,debtor,sales_point,`date`) VALUES('Payment','$amount','$_GET[debtor]','$sp','$today')");
				 
				 
				 
				 $result2=mysql_query("SELECT id FROM debt_history WHERE sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
				 $row2=mysql_fetch_array($result2);
				 $_SESSION['checker']="N/A - Debt Payment";
				 $vat=$amount*0.05;
				 
					 mysql_query("INSERT INTO reciept (name,amount,amount_paid,vat,`change`,r_change,sales_point,date,remark,type,balance,rev) VALUES ('$rowa[name]','$amount','$amount','$vat','0','0','$sp','$today','','','','0')");
	
	
  $resultb=mysql_query("SELECT id FROM reciept WHERE date='$today' AND sales_point='$sp' AND amount='$amount' ORDER BY id DESC LIMIT 0,1");
  $rowb=mysql_fetch_array($resultb);
  
  mysql_query("INSERT INTO reciept_goods (item_name,unit_price,quantity,amount,vat,date,good_id,sales_point,reciept) VALUES ('Debt Payment','$amount','1','$amount',$vat,'$today','','$sp','$rowb[id]')");
                      
                      
                      
$ac=$ac+$amount;                      
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
Redirect('debt_report.php?debtor='.$_GET[debtor].'&token='.$row2[id]);
			  }
		  }
		  ?>
                	<div class="element">
                    	<label for="category">Amount</label>
						<input type="number" name="amount" class="mini-text err" autofocus>
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