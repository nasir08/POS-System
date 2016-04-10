<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		if(isset($_GET['e_id']))
		{
			$today=date('Y')."-".date('m')."-".date('d');
			$id=base64_decode($_GET['e_id']);
			$sp=$_SESSION['id'];
			mysql_query("DELETE FROM expenses WHERE id='$id' and sales_point='$sp'");
			
			
			$result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
			if(isset($_GET['continue']))
			{
				$result=mysql_query("SELECT COUNT(id) FROM expenses WHERE sales_point='$sp'");
         		$row=mysql_fetch_row($result);
				if($row[0]<=10)
				{
					Redirect('expenses.php');
				}
				else
				{
					Redirect('expenses.php?page='.$_GET['continue']);
				}
			}
			else
			{
				Redirect('expenses.php'); 
		    }
		}
		else
		{
			Redirect('expenses.php'); 
		}
	}
?>