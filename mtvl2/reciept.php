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
			if(isset($_GET['amount_paid']))
			{
				$today=date('Y')."-".date('m')."-".date('d');
				$name=base64_decode($_GET['customer']);
			$amount_paid=base64_decode($_GET['amount_paid']);
			$passer="";
			$rn="";
			$sp=$_SESSION['id'];
			}
			else
			{
			 Redirect('payment_info.php'); 
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
<script src="js/jquery-1.9.0.js" type="text/JavaScript" language="javascript"></script>
<script src="js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
<title>M.T. Ventures LTD</title>
<link type="text/css" href="reciept.css" rel="stylesheet">
</head>

<body>
<?php
$result=mysql_query("SELECT COUNT(id) FROM reciept WHERE name='$name' and amount=0 and sales_point='$sp'");
$row=mysql_fetch_row($result);
if($row[0]>0)
{
	mysql_query("DELETE FROM reciept WHERE name='$name' and amount=0 and sales_point='$sp'");
	$result=mysql_query("SELECT id FROM reciept WHERE name='$name' and amount_paid='$amount_paid' and sales_point='$sp' ORDER BY id DESC LIMIT 0,1");
	$row=mysql_fetch_array($result);
	$_SESSION['rn']=$row['id'];
	
	
	 $result7=mysql_query("SELECT SUM(amount_paid) FROM reciept WHERE sales_point='$sp' AND date='$today' AND rev=0");
				$row7=mysql_fetch_row($result7);
	$result8=mysql_query("SELECT SUM(amount) FROM expenses WHERE sales_point='$sp' AND date='$today'");
						$row8=mysql_fetch_row($result8);
						$ac=$row7[0]-$row8[0];
mysql_query("UPDATE balance_bf SET amount='$ac' WHERE sales_point='$sp'");
}
?>
<table border="0" id="recieptPage">
  <tr>
    <td align="center" valign="top">
    <div class="PrintArea p1">
    <center>
    	<table border="0" id="reciept">
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
                    Receipt Number:  
					<?php
					 $rn=$_SESSION['rn'];
					 if(strlen($rn)==1)
					 echo "000000".$rn;
					 elseif(strlen($rn)==2)
					 echo "00000".$rn;
					 elseif(strlen($rn)==3)
					 echo "0000".$rn;
					 elseif(strlen($rn)==4)
					 echo "000".$rn;
					 elseif(strlen($rn)==5)
					 echo "00".$rn;
					 elseif(strlen($rn)==6)
					 echo "0".$rn;
					 elseif(strlen($rn)>6)
					 echo $rn;
					?><br  />
                    Date: <?php echo $today; ?><br />
                    Customer Name: 
					<?php
					$result=mysql_query("SELECT * FROM reciept WHERE sales_point = '$sp' ORDER BY id DESC LIMIT 0,1");
					$row=mysql_fetch_array($result);
					$change=$row['change'];
					$type=$row['type'];
					$balance=$row['balance'];
					echo $row['name']; 
					?>
                    </div>
                  <br />
        			<div class="recieptHeader" style="font-size:13px">
                   	  <table width="100%" border="0" height="44">
                   	    <tr>
                   	      <th width="10%" align="center" valign="middle" scope="col"><b>SN</b></th>
                   	      <th width="40%" align="center" valign="middle" scope="col"><b>Item</b></th>
                   	      <th width="15%" align="center" valign="middle" scope="col"><b>Qty</b></th>
                   	      <th width="15%" align="center" valign="middle" scope="col"><b>Price</b></th>
                   	      <th width="25%" align="center" valign="middle" scope="col"><b>Amount</b></th>
               	        </tr>
               	      </table>
        			</div>
                    
       			  <div style="font-size:13px">
                  	<table width="100%" border="0">
                    <?php
					$sn=1;
					$total="";
					$vat="";
					$result=mysql_query("SELECT * FROM reciept_goods WHERE sales_point = '$sp' and reciept='$rn'");
					while($row=mysql_fetch_assoc($result))
					{
						$total+=$row['amount'];
						$vat+=$row['vat'];
                  	  echo"<tr>
                  	    <td width=\"10%\" align=\"center\" valign=\"top\">$sn</td>
                  	    <td width=\"40%\" align=\"center\" valign=\"top\">$row[item_name]</td>
                  	    <td width=\"15%\" align=\"center\" valign=\"top\">$row[quantity]</td>
                  	    <td width=\"15%\" align=\"center\" valign=\"top\">$row[unit_price]</td>
                  	    <td width=\"25%\" align=\"center\" valign=\"top\">$row[amount]</td>
               	      </tr>
					  <tr><td>&nbsp;</td></tr>";
					  $sn++;
					}
                     ?> 
               	    </table>
       			  </div><br />
                  
        			<div>
                   	  <table width="100%" border="0">
                       <tr>
                    	    <td align="right" valign="top"><b>Total:</b></td>
                    	    <td width="25%" align="center" valign="top"><div class="cute"><b><?php echo $total ?></b></div></td>
                  	    </tr>
                      
                      <?php
					  if($sp==2)
					  {
						  $g_total=$total+$vat;
                      echo"<tr>
                    	    <td align=right valign=top><b>VAT (5%):</b></td>
                    	    <td width=25% align=center valign=top><div class=cute><b>$vat</b></div></td>
                  	    </tr>";
						
						 echo"<tr>
                    	    <td align=right valign=top><b>Gross Total:</b></td>
                    	    <td width=25% align=center valign=top><div class=cute><b>$g_total</b></div></td>
                  	    </tr>";
					  }
					  ?>
                    	 
                        
                        <?php
					  if($sp!=2)
					  {
                        echo"<tr>
                    	    <td align=right valign=top><b>Amount Paid:</b></td>
                   	      <td width=25% align=center valign=top><div class=cute><b> $amount_paid</b></div></td>
                  	    </tr>";
                       }
                        ?>
                        
                        
                        <?php
						if($change!=0)
                    	  echo"<tr>
                    	    <td width=15% align=right valign=top><b>Change To Balance:</b></td>
                    	    <td width=25% align=center valign=middle><div class=cute><b>$change</b></div></td>
   	                    </tr>";
						?>
                  	  </table>
        			</div><br />
                    
                    <div>
                   	  <table width="100%" border="0">
                      <tr>
                    	    <td colspan="4" align="right" valign="middle"><b>Remark:</b></td>
                    	    <td width="46%" align="center" valign="middle"><div><b><?php echo $_SESSION['remark'] ?></b></div></td>
                  	    </tr>
                    	  <tr>
                    	    <td colspan="4" align="right" valign="middle"><b>Sales Point:</b></td>
                    	    <td width="46%" align="center" valign="middle"><div><b><?php echo $_SESSION['name'] ?></b></div></td>
                  	    </tr>
                    	  <tr>
                    	    <td width="8%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="38%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="6%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="2%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="46%" align="center" valign="middle"><b><?php echo "0".$_SESSION['phone'] ?></b></td>
       	                </tr>
                  	  </table>
        			</div>
                </td>
  			</tr>
	  </table></center></div><br /><br /><br />
<form action="" method="post" enctype="multipart/form-data">
    <input name="print" type="submit" value="Print Reciept" />&nbsp;&nbsp;
    <input name="back" type="submit" value="Back To Search Page" />
</form>
<?php 
if(isset($_POST['print']))
{
	require_once("js/printer.js");
}
elseif(isset($_POST['back']))
{
	Redirect('sales.php');	
}
?>
    </td>
  </tr>
</table>
</body>
</html>