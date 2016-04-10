<?php
	require_once('inc/functions.php');
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
			$rn=base64_decode($_GET['rn']);
			$result=mysql_query("SELECT `change`,date FROM reciept WHERE id='$rn'");
			$row=mysql_fetch_array($result);
			$change=$row['change'];
            $date=$row['date'];
			
			
			$result=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
			$row=mysql_fetch_row($result);
			$result2=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
			$row2=mysql_fetch_row($result2);
			$ac=$row[0]-$row2[0];
			if($change>$ac)
			{ echo "<h3>Insuffucient funds, you have only $ac.</h3><br><a href=receipt-archive.php>Back</a>"; }
			
			
			elseif($change<=$ac)
			{
			 if($date==$today)
             {
			mysql_query("UPDATE reciept SET `change` = '0',amount_paid = amount WHERE id='$rn'");
	
    
    $result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
	
    	
		
		if(isset($_GET['continue']))
		{	
			if(isset($_GET['token']))
			{
				Redirect(''.$_GET['continue'].'?page='.$_GET['token']);
			}
			else
			{
				Redirect(''.$_GET['continue']);	
			}
		}
		else
		{
				Redirect('receipt-archive.php');
		}
        }
        else
        {
            mysql_query("UPDATE reciept SET `change` = '0' WHERE id='$rn'");
			mysql_query("INSERT INTO expenses (date,purpose,amount,sales_point) VALUES('$today','Change for receipt $rn','$change','$sp')");
	
    
    $result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' and date='$today'");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' and date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
	
    	
		
		if(isset($_GET['continue']))
		{	
			if(isset($_GET['token']))
			{
				Redirect(''.$_GET['continue'].'?page='.$_GET['token']);
			}
			else
			{
				Redirect(''.$_GET['continue']);	
			}
		}
		else
		{
				Redirect('receipt-archive.php');
		}
        }
			}
            }
            else{ Redirect('receipt-archive.php'); }
	}
?>