<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
	
		if(isset($_GET['sales_point']))
		{
			$sp=$_SESSION['id'];
			mysql_query("DELETE FROM cart WHERE sales_point = '$sp'");
			Redirect('sales.php');
		}
		else
		{
			Redirect('sales.php');
		}
	}
?>