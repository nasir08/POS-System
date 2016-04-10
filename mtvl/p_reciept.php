<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		unset($_COOKIE['FormSubmitted']);
		}
		
		if(isset($_GET['customer']))
		{
			if(isset($_GET['change']))
		    {
				if(isset($_GET['amount_paid']))
		    	{
				$amount_paid=base64_decode($_GET['amount_paid']);	
			$change=base64_decode($_GET['change']);
			$sp=$_SESSION['id'];
    		$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
			$row=mysql_fetch_row($result);
			if($row[0]==0)
			{
				Redirect('sales.php');
			}
				}
			else
			{
				require_once('inc/header.php');
				$passer="";
				$rn="";
			}
		}
		else
		{
			Redirect('payment_info.php');
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M.T. Ventures LTD</title>
<link type="text/css" href="reciept.css" rel="stylesheet">
</head>

<body>
<table border="0" id="recieptPage">
  <tr>
    <td align="center" valign="top">
    	<table width="100%" border="0" id="reciept">
  			<tr>
    			<td align="center" valign="top">
                	<div class="logo"><b>M.T. VENTURES LIMITED<br />
        			<span>Building Materials Merchant</span></b><br />
                    <span>Eleha Bus Stop, Iyana Church, Iwo Road, Ibadan</span><br />
                    <span>08095536440, 08037158678</span><br />
                    <span>mtventuresltdonline@gmail.com</span>
        			</div><br /><br />
                    <span class="purp">Sales Receipt</span><br /><br />
                    
                    <div>
                    Date: <?php echo $today=date('Y')."-".date('m')."-".date('d'); ?><br />
                    Customer Name: <?php echo base64_decode($_GET['customer']) ?>
                    </div>
                  <br />
        			<div class="recieptHeader">
                   	  <table width="100%" border="0" height="44">
                   	    <tr>
                   	      <th align="center" valign="middle" scope="col">SN</th>
                   	      <th width="40%" align="center" valign="middle" scope="col">Item</th>
                   	      <th width="10%" align="center" valign="middle" scope="col">Quantity</th>
                   	      <th width="15%" align="center" valign="middle" scope="col">Price</th>
                   	      <th width="25%" align="center" valign="middle" scope="col">Amount</th>
               	        </tr>
               	      </table>
        			</div>
                    
       			  <div>
                  	<table width="100%" border="0">
                    <?php
					$sn=1;
					$total="";
					$vat="";
					$sp=$_SESSION['id'];
					$result=mysql_query("SELECT * FROM cart WHERE sales_point = '$sp'");
					while($row=mysql_fetch_assoc($result))
					{
						$total+=$row['amount'];
						$vat+=$row['amount']*0.05;
                  	  echo"<tr>
                  	    <td width=\"10%\" align=\"center\" valign=\"middle\">$sn</td>
                  	    <td width=\"40%\" align=\"center\" valign=\"middle\">$row[item_name]</td>
                  	    <td width=\"10%\" align=\"center\" valign=\"middle\">$row[quantity]</td>
                  	    <td width=\"15%\" align=\"center\" valign=\"middle\">$row[unit_price]</td>
                  	    <td width=\"25%\" align=\"center\" valign=\"middle\">$row[amount]</td>
               	      </tr>";
					  $sn++;
					}
                     ?> 
               	    </table>
       			  </div><br />
                  
        			<div>
                   	  <table width="100%" border="0">
                      
                    	  <tr>
                    	    <td width="10%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="35%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="6%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="24%" align="center" valign="middle"><b>Total:</b></td>
                    	    <td width="25%" align="center" valign="middle"><div class="cute"><b><?php echo $total ?></b></div></td>
                  	    </tr>
                        <?php
					  if($sp==2)
					  {
						  $g_total=$total+$vat;
                      	  echo"<tr>
                    	    <td width=10% align=center valign=middle>&nbsp;</td>
                    	    <td width=35% align=center valign=middle>&nbsp;</td>
                    	    <td width=6% align=center valign=middle>&nbsp;</td>
                    	    <td width=24% align=center valign=middle><b>VAT (5%):</b></td>
                    	    <td width=25% align=center valign=middle><div class=cute><b>$vat</b></div></td>
                  	    </tr>";
						
						echo"<tr>
                    	    <td width=10% align=center valign=middle>&nbsp;</td>
                    	    <td width=35% align=center valign=middle>&nbsp;</td>
                    	    <td width=6% align=center valign=middle>&nbsp;</td>
                    	    <td width=24% align=center valign=middle><b>Gross Total:</b></td>
                    	    <td width=25% align=center valign=middle><div class=cute><b>$g_total</b></div></td>
                  	    </tr>";
					  }
					  ?>
                      
                      <?php
					  if($sp!=2)
					  {
                        echo"<tr>
                    	    <td width=10% align=center valign=middle>&nbsp;</td>
                    	    <td width=35% align=center valign=middle>&nbsp;</td>
                    	    <td width=6% align=center valign=middle>&nbsp;</td>
                    	    <td width=24% align=center valign=middle><b>Amount Paid:</b></td>
                    	    <td width=25% align=center valign=middle><div class=cute><b>$amount_paid</b></div></td>
                  	    </tr>";
                        }
                        ?>
                        
                        
						
                        <?php
						if($change!=0)
                    	  echo"<tr>
                    	    <td align=center valign=middle>&nbsp;</td>
                    	    <td width=40% align=center valign=middle>&nbsp;</td>
                    	    <td width=10% align=center valign=middle>&nbsp;</td>
                    	    <td width=15% align=center valign=middle><b>Chage To Balance:</b></td>
                    	    <td width=25% align=center valign=middle><div class=cute><b>$change</b></div></td>
   	                    </tr>";
						?>
                  	  </table>
        			</div><br />
                    
                    <div>
                   	  <table width="100%" border="0">
                    	  <tr>
                    	    <td width="10%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="40%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="8%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="17%" align="center" valign="middle"><b>Sales Point:</b></td>
                    	    <td width="25%" align="center" valign="middle"><div><b><?php echo $_SESSION['name'] ?></b></div></td>
                  	    </tr>
                    	  <tr>
                    	    <td width="10%" align="center" valign="middle">&nbsp;</td>
                    	    <td align="center" valign="middle">&nbsp;</td>
                    	    <td width="8%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="17%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="25%" align="center" valign="middle"><b><?php echo "0".$_SESSION['phone'] ?></b></td>
       	                </tr>
                  	  </table>
        			</div>
                </td>
  			</tr>
		</table><br /><br /><br />
<form action="" method="post" enctype="multipart/form-data">
Remark: <input name="remark" type="radio" value="Paid & Supplied" checked />Paid & Supplied  &nbsp; 
<input name="remark" type="radio" value="Not Yet Collected" />Not Yet Collected<br />
	<input name="layoff" type="submit" value="Layoff Customer" />&nbsp;&nbsp;
	<input name="add_items" type="submit" value="Add Items" />&nbsp;&nbsp;
    <input name="cust_info" type="submit" value="Back To Customer Info" />&nbsp;&nbsp;
    <input name="cart" type="submit" value="Back To Cart" />&nbsp;&nbsp;
    <input name="cancel" type="submit" value="Cancel Item Selection" />&nbsp;&nbsp;
    <input name="save" type="submit" value="Save Reciept">
</form>
<?php
if(isset($_POST['add_items']))
{
	Redirect('sales.php');
}
elseif(isset($_POST['cust_info']))
{
	Redirect('payment_info.php');
}
elseif(isset($_POST['cart']))
{
	Redirect('cart.php');
}
elseif(isset($_POST['cancel']))
{
	mysql_query("DELETE FROM cart WHERE sales_point = '$sp'");
	Redirect('sales.php');
}
elseif(isset($_POST['save']))
{
	$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
			$row=mysql_fetch_row($result);
			if($row[0]!=0)
			{
	$name=mysql_real_escape_string(base64_decode($_GET['customer']));
	
	
	$result2=mysql_query("SELECT COUNT(id) FROM cart WHERE sales_point = '$sp'");
	$row2=mysql_fetch_row($result2);
	$count=$row2[0];
	$result=mysql_query("SELECT * FROM cart WHERE sales_point = '$sp'");
	$error="no";
while($row=mysql_fetch_assoc($result))
{	
	$qty=$row['quantity'];
    $good_id=$row['good_id'];
	$result3=mysql_query("SELECT * FROM goods WHERE id = '$good_id'");
	$row3=mysql_fetch_assoc($result3);
	
	$item_name=$row3['item_name'];
	$del=$row3['delimeter'];
	$family=mysql_real_escape_string($row3['family']);
	$inv=$row3['amount_rem'];
	
	if($inv<1)
	{
		echo "<br>$item_name is not in stock.<br>"; $error="yes";
	}
	elseif($inv>0)
	{
		$conv=$qty*$del;
		if($conv>$inv)
		{
			echo "<br>You have only $inv piece(s) of $item_name in stock.<br>";
			$error="yes";
		}
		else
		{
			if($family!="no")
			{
			if($error=="no")
			{
			mysql_query("UPDATE goods SET amount_rem = amount_rem-$conv WHERE family = '$family'");
			}
			}
		}
	}
}
if($error=="no")
	{
		$remark=$_POST['remark'];
	
	if($remark=="Supplied")
	{ $type="Debt sales"; }	
	elseif($_GET['type']=="debtor")
	{ $type="Debt sales"; }
	elseif($_GET['type']=="creditor")
	{ $type="Credit sales"; }
		
	mysql_query("INSERT INTO reciept (name,amount,amount_paid,vat,`change`,r_change,sales_point,date,remark,type,balance) VALUES ('$name','$total','$amount_paid','$vat','$change','$change','$sp','$today','$remark','$type','$balance')");
	
	
  $result=mysql_query("SELECT id FROM reciept WHERE name='$name' and date='$today' and sales_point='$sp' and amount='$total' ORDER BY id DESC LIMIT 0,1");
  $row=mysql_fetch_array($result);
  $reciept_id=$row['id'];


$result=mysql_query("SELECT * FROM cart WHERE sales_point = '$sp'");
while($row=mysql_fetch_assoc($result))
{	
    $item=mysql_real_escape_string($row['item_name']);  $price=$row['unit_price'];  $quantity=$row['quantity'];  $amount=$row['amount']; $n_good_id=$row['good_id'];
	
	$iVat=0.05*$amount;
	
    mysql_query("INSERT INTO reciept_goods (item_name,unit_price,quantity,amount,vat,date,good_id,sales_point,reciept) VALUES ('$item','$price','$quantity','$amount',$iVat,'$today','$n_good_id','$sp','$reciept_id')");	
	
	
}
	
	
	
	mysql_query("DELETE FROM cart WHERE sales_point='$sp'");
	
	
	$name=base64_encode($name);
	session_start();
	$_SESSION['total']=$total;
	$_SESSION['rn']=$reciept_id;
	$_SESSION['remark']=$remark;
	$e_amount_paid=base64_encode($amount_paid);
	
	
	
	$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
	
	
	Redirect('reciept.php?customer='.$name.'&amount_paid='.$e_amount_paid);
}
			}
            else
            {}
}
?>
    </td>
  </tr>
</table>
</body>
</html>