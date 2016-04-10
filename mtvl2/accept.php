<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		if(isset($_GET['customer']))
		{
			$sp=$_SESSION['id'];
			$customer=$_GET['customer'];
			$result=mysql_query("SELECT * FROM waiting WHERE customer='$customer'");
			while($row=mysql_fetch_assoc($result))
			{
			mysql_query("INSERT INTO cart(item_name, unit_price, quantity, amount, sales_point,good_id) VALUES ('$row[item_name]','$row[unit_price]','$row[quantity]','$row[amount]','$sp','$row[good_id]')");
			
			mysql_query("DELETE FROM waiting WHERE customer='$customer'");
			Redirect('cart.php');
			}
		}
		else
		{
			Redirect("waiting.php");
		}
	}
?>