<?php
	require_once('inc/functions.php');
	session_start();
    if(!(isset($_SESSION['id'])))
	{
		Redirect('index.php'); 
	}
	else
	{
		$sp=$_SESSION['id'];
    	$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
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
			$cname="";
		}
	}
?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Payment Information</h2>
            <h2 class="title">Total:
            <?php
		  $total="";
		  $result=mysql_query("SELECT amount FROM cart WHERE sales_point = '$sp'");
		  while($row=mysql_fetch_assoc($result))
		  {
		  	$total+=$row['amount'];
		  }
		  echo $totalw=number_format($total,2);
		  ?>
          </h2>
            <?php
		  	$result=mysql_query("SELECT * FROM goods WHERE id = '$id'");
		  	$row=mysql_fetch_array($result);
		  	echo $row['item_name']."</h2>";
		  	?>
            </div>
				<form method="post">
                <input name="tot" id="tot" type="hidden" value="<?php echo $total; ?>"> 
                	<div class="element">
						<label for="name">Customer Name</label>
						<input id="name" name="txtCname" class="mini-text err" autofocus placeholder="Customer Name" />
					</div>
                    <div class="element">
						<label for="name">Amount Paid</label>
						<input id="a_paid" name="a_paid" class="mini-text err" placeholder="Amount Paid" onKeyUp="Calc()" />
					</div>
                    <div class="element">
						<label for="name">Change</label>
						<input id="change" name="change" class="mini-text err" placeholder="Change Paid" readonly />
					</div>
                    <div class="entry">
						<button type="submit" class="add" name="btnCalc">Continue</button>
					</div>
                </form>
                	<?php
					if(isset($_POST['btnCalc']))
					{
						$r_cname=$_POST['txtCname'];
						$cname=base64_encode(trim($_POST['txtCname']));
						$change=mysql_real_escape_string(trim($_POST['change']));
						$amount_paid=mysql_real_escape_string(trim($_POST['a_paid']));
						$c_change=$amount_paid-$total;
						
						if($cname=="")
						{
							echo "<div class=n_error><p>Error notification. Customer Name cannot be empty.</p></div>"; 
						}
						elseif($amount_paid=="")
						{
							echo "<div class=n_error><p>Error notification. Amount Field cannot be empty.</p></div>"; 
						}
						elseif(!is_numeric($amount_paid))
						{
							echo "<div class=n_error><p>Error notification. Amount must be a number.</p></div>"; 
						}
						elseif($amount_paid<0)
						{
							echo "<div class=n_error><p>Error notification. Amount cannot be negative.</p></div>"; 
						}
						elseif(($change!="") && (!is_numeric($change)))
						{
							echo "<div class=n_error><p>Error notification. Change must be a number.</p></div>"; 
						}
						elseif(($change!="") && ($change<0))
						{
							echo "<div class=n_error><p>Error notification. Change cannot be negative.</p></div>"; 
						}
						elseif(($change!="") && ($change!=$c_change))
						{
							echo "<div class=n_error><p>Error notification. WARNING!!! The change you entered is incorrect.</p></div>"; 
						}
						elseif(($amount_paid>$total) && ($change==0))
						{ 
						echo "<div class=n_error><p>Error notification. WARNING!!! Amount paid is greater than total, please enter the change.</p></div>";  
						}
						elseif(($amount_paid==$total) && ($change!=0))
						{ 
						echo "<div class=n_error><p>Error notification. WARNING!!! Amount paid is equal to total, Please remove change before proceedingCustomer Name cannot be empty.</p></div>";  
						}
						
						
						
						else
						{
							if($change=="")
							{ $change=0; }
							$amount_paid=base64_encode($amount_paid);
							$change=base64_encode($change);
							Redirect('p_reciept.php?customer='.$cname.'&change='.$change.'&amount_paid='.$amount_paid);
						}
					}
				?>
                
                <script type="text/javascript">
 			function Calc()
 			{
	  		var tot = Number(document.getElementById('tot').value);
	  		var a_paid = Number(document.getElementById('a_paid').value);
	  		document.getElementById('change').value = a_paid - tot;
 			}
			setInterval(Calc,100);
			</script>
				<div class="entry">
					<div class="sep"></div>		
					<a class="button" href="lay-off.php">Lay-Off Customer</a> 
                    <?php 
  						if($passer=="")
  						echo"<a class=button href=cancel_order.php?sales_point=$_SESSION[id]>Cancel Item Selection</a>"; 
  					?>  
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php
	require_once('inc/footer.php');
	?>