<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('index.php'); 
	}
	else
	{
		if(isset($_GET['item']))
		{
			$sp=$_SESSION['id'];
			$item=base64_decode($_GET['item']);
			mysql_query("DELETE FROM cart WHERE id='$item' and sales_point='$sp'");
			
			
			$result=mysql_query("SELECT COUNT(id) FROM cart WHERE sales_point='$sp'");
			$row=mysql_fetch_row($result);
			if($row[0]>0)
			{
				Redirect("cart.php");
			}
			else
			{
				Redirect("sales.php");
			}
		}
		else
		{
			Redirect("cart.php");
		}
	}
?>