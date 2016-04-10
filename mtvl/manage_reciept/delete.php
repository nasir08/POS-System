<?php
	require_once('../inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		if(isset($_GET['rn']))
		{
			$sp=$_SESSION['id'];
			$today=date('Y')."-".date('m')."-".date('d');
			$rn=$_GET['rn'];
			
			$result=mysql_query("SELECT * FROM reciept WHERE id='$rn'");
			$row=mysql_fetch_array($result);
			$date=$row['date'];
			$o_sp=$row['sales_point'];
			$amount=$row['amount'];
			$amount_paid=$row['amount_paid'];
			
			
			$resulti=mysql_query("SELECT * FROM reciept_goods WHERE reciept='$rn'");
			while($rowi=mysql_fetch_array($resulti))
			{
				$good_id=$rowi['good_id'];
				$quantity=$rowi['quantity'];
				
				$resultx=mysql_query("SELECT family FROM goods WHERE id='$good_id'");
				$rowx=mysql_fetch_array($resultx);
				$fam=mysql_real_escape_string($rowx['family']);
				
				if($fam!="no")
				{
					mysql_query("UPDATE goods SET amount_rem = amount_rem+$quantity WHERE family = '$fam'");
				}
			}
			
			
			
			
			mysql_query("DELETE FROM reciept_goods WHERE reciept='$rn'");
			mysql_query("DELETE FROM reciept WHERE id='$rn'");
			
			if($date==$today)
			{
				
				$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$row[sales_point]' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$row[sales_point]' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$row[sales_point]'");
				
				Redirect("../receipt-archive.php");
			}
			else
			{
				mysql_query("INSERT INTO reciept (name,amount,amount_paid,sales_point,date) VALUES('Refund for reeciept $rn','$amount','$amount_paid','$o_sp','$date')");
				Redirect("../receipt-archive.php");
			}
			
		}
		else
		{
			Redirect("../receipt-archive.php");
		}
	}
