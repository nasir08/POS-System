<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	  }
	  else
	  {
		  $debtor=$_GET['debtor'];
		  $debt=$_GET['token'];
		  mysql_query("UPDATE debt_history SET load_count=load_count+1 WHERE id='$debt'");
		  $sp=$_SESSION['id'];  
     }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>M.T. Ventures LTD</title>
</head>

<body style="padding:0; margin:0; font-family:"Merchant Copy"">
<table width="320" border="1">
  <tr>
    <td valign="top">
    
    <center>
    <b><font size="+1">M.T. Ventures Limited</font></b><br>
<i>Building Materials Merchant</i><br>
08095536440, 08037158678<br><br>
-------------------------------------------<br><br>
<u><b>Debt Report</b></u><br><br></center>
<b>Ref No:&nbsp;  
<?php
$today=date('Y')."-".date('m')."-".date('d');

$result=mysql_query("SELECT * FROM debt_history WHERE debtor='$debtor' AND id='$debt'");
$row=mysql_fetch_assoc($result);
if($row['load_count']>1) { Redirect('all-debtors.php'); }
else
{

$result3=mysql_query("SELECT * FROM debtors WHERE id='$debtor'");
$row3=mysql_fetch_assoc($result3);

$ref=$_GET['token'];
if(strlen($ref)==1)
echo "000000".$ref;
elseif(strlen($ref)==2)
echo "00000".$ref;
elseif(strlen($ref)==3)
echo "0000".$ref;
elseif(strlen($ref)==4)
echo "000".$ref;
elseif(strlen($ref)==5)
echo "00".$ref;
elseif(strlen($ref)==6)
echo "0".$ref;
elseif(strlen($ref)>6)
echo $ref;
echo "<br>
Date: $row[date]<br>
Name: $row3[name]<br>";
?>
<?php

$result2=mysql_query("SELECT name FROM accounts WHERE id='$row[sales_point]'");
$row2=mysql_fetch_assoc($result2);
echo"Sales Point: $row2[name]<br>";
?>
Receipt:&nbsp;
<?php
if(is_numeric($_SESSION['checker'])){ echo $_SESSION['checker']; }
elseif($_SESSION['checker']=="N/A - Debt Payment"){ echo $_SESSION['checker']; } 
elseif($_SESSION['checker']=="Transfer From Debtors Book"){ echo "N/A - TFDB"; } 
echo"</b><br><br>";
?>
<center>============================<br><br></center>
<?php
if((is_numeric($_SESSION['checker'])) || ($row3['balance']!=0)) { $pb=$row3['balance']; }
else{ $pb=0; }
if($row['type']=="Debt")
{
$ad=$row['amount'];
$bal=$pb+$ad;
mysql_query("UPDATE debtors SET balance='$bal' WHERE id='$debtor'");
$pb=number_format($pb,2);
$ad=number_format($ad,2);
$bal=number_format($bal,2);
echo"<font size=-1>Previous Balance: &#8358;$pb<br>
Additional Debt: &#8358;$ad<br>
Debit Balalnce: &#8358;$bal</font><br><br>";
}
elseif($row['type']=="Payment")
{
	$payment=$row['amount'];
	$bal=$pb-$payment;
	mysql_query("UPDATE debtors SET balance='$bal' WHERE id='$debtor'");
	$pb=number_format($pb,2);
$payment=number_format($payment,2);
$bal=number_format($bal,2);
echo"<font size=-1>Previous Balance: &#8358;$pb<br>
Payment: &#8358;$payment<br>
Debit Balalnce: &#8358;$bal</font><br><br>";
}
}
?>
    </td>
  </tr>
</table>
</body>
</html>
