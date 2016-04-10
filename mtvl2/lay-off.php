<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
			$cust=gen_ID();
			$sp=$_SESSION['id'];
			$result=mysql_query("SELECT * FROM cart WHERE sales_point='$sp'");
			while($row=mysql_fetch_assoc($result))
			{
			mysql_query("INSERT INTO waiting(item_name, unit_price, quantity, amount, sales_point,good_id,customer) VALUES ('$row[item_name]','$row[unit_price]','$row[quantity]','$row[amount]','$sp','$row[good_id]','$cust')");
			
			mysql_query("DELETE FROM cart WHERE sales_point='$sp'");
			Redirect('sales.php');
			}
	}
?>