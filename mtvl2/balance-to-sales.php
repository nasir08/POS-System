<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		if(isset($_SESSION['balance_bf']))
		{
		$sp=$_SESSION['id'];
		$balance=$_SESSION['balance_bf'];
		require_once('inc/header.php');
		require_once('inc/sidebar.php');
		}
		else
		{
			Redirect('sales.php'); 
		}
	}
	?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Balance Brought Forward: <?php echo $balance ?></h2></div>
				<form method="post">
                	<div class="element">
						<input id="name" name="amount" class="mini-text err" autofocus placeholder="Amount" />
						<button type="submit" class="add" name="submit">Submit</button>
					</div>
                </form>
                <?php
				if(isset($_POST['submit']))
				{
					$today=date('Y')."-".date('m')."-".date('d');
					$amount=trim($_POST['amount']);
					if($amount=="")
					{ echo "Amount field cannot be empty.<br><br>"; }
					elseif(!is_numeric($amount))
					{ echo "Amount must be a number.<br><br>"; }
					else
					{
						if($amount==$balance)
						{
						
						mysql_query("INSERT INTO reciept (name,amount,amount_paid,sales_point,date) VALUES('Balance Brought Forward','$amount','$amount','$sp','$today')");
						
						
						$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
						
						Redirect('sales.php');
						}
						else
						{
							{ echo "Error! Please Enter the exact amount of balance brought forward.<br><br>"; }
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