<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	}
	else
	{
		$sp=$_SESSION['id'];
		if(isset($_GET['rn']))
		{
			$rn=base64_decode($_GET['rn']);
		}
		else
		{
			 Redirect('receipt-archive.php'); 
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="js/jquery-1.9.0.js" type="text/JavaScript" language="javascript"></script>
<script src="js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M.T. Ventures LTD</title>
<link type="text/css" href="reciept.css" rel="stylesheet">
</head>

<body>
<table border="0" id="recieptPage">
  <tr>
    <td align="center" valign="top">
    <div class="PrintArea p1">
    <center>
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
                     Receipt Number:  
					<?php
					$result=mysql_query("SELECT * FROM reciept WHERE id = '$rn'");
					$row=mysql_fetch_array($result);
					$type=$row['type'];
					$balance=$row['balance'];
					$change=$row['change'];
					$amount_paid=$row['amount_paid'];
					$vat=$row['vat'];
					$db_rn=$row['id'];
					 if(strlen($db_rn)==1)
					 echo "000000".$db_rn;
					 elseif(strlen($db_rn)==2)
					 echo "00000".$db_rn;
					 elseif(strlen($db_rn)==3)
					 echo "0000".$db_rn;
					 elseif(strlen($db_rn)==4)
					 echo "000".$db_rn;
					  elseif(strlen($db_rn)==5)
					 echo "00".$db_rn;
					  elseif(strlen($db_rn)==6)
					 echo "0".$db_rn;
					 elseif(strlen($db_rn)>6)
					 echo $db_rn;
					?><br  />
                   Date: <?php echo $row['date']; ?><br />
                    Customer Name: <?php echo $row['name']; ?>
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
					
					$result2=mysql_query("SELECT * FROM reciept_goods WHERE reciept='$rn'");
					while($row2=mysql_fetch_assoc($result2))
					{
                  	  echo"<tr>
                  	    <td width=\"10%\" align=\"center\" valign=\"top\">$sn</td>
                  	    <td width=\"40%\" align=\"center\" valign=\"top\">$row2[item_name]</td>
                  	    <td width=\"15%\" align=\"center\" valign=\"top\">$row2[quantity]</td>
                  	    <td width=\"15%\" align=\"center\" valign=\"top\">$row2[unit_price]</td>
                  	    <td width=\"25%\" align=\"center\" valign=\"top\">$row2[amount]</td>
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
                    	    <td width="27%" align="center" valign="top"><div class="cute"><b><?php echo $row['amount']; ?></b></div></td>
                  	    </tr>
                      
                      	  <?php
					  if($row['sales_point']==2)
					  {
						  $g_total=$row['amount']+$vat;
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
					  if($row['sales_point']!=2)
					  { 
                        echo"<tr>
                   	      <td align=right valign=top><b>Amount Paid:</b></td>
                    	    <td width=27% align=center valign=top><div class=cute><b>$amount_paid</b></div></td>
                  	    </tr>";
                       }
                       ?>
                        
                        
                        <?php
						if(($type=="debt-payment") || ($type=="debt") || ($type=="Debt sales"))
						{
                        echo"<tr>
                   	      <td align=right valign=top><b>Debit Balance:</b></td>
                    	    <td width=27% align=center valign=top><div class=cute><b>$balance</b></div></td>
                  	    </tr>";
                        }
						elseif($type=="Credit sales")
						{
                        echo"<tr>
                   	      <td align=right valign=top><b>Credit Balance:</b></td>
                    	    <td width=27% align=center valign=top><div class=cute><b>$balance</b></div></td>
                  	    </tr>";
                        }
                        ?>
                        <?php
                        if($change!=0)
                    	  echo"<tr>
                    	    <td width=73% align=right valign=top><b>Change To Balance:</b></td>
                    	    <td width=27% align=center valign=top><div class=cute><b>$change</b></div></td>
   	                    </tr>";
						?>
                  	  </table>
        			</div><br />
                    
                    <div>
                   	  <table width="100%" border="0">
                      <?php
					  $sp=$row['sales_point']; 
							$result=mysql_query("SELECT remark FROM reciept WHERE id='$rn'");
							$row=mysql_fetch_array($result);
							$remark=$row['remark'];
                      if(($type!="debt-payment") && ($type!="debt"))
					  {
                      	  echo"<tr>
                    	    <td colspan=4 align=right valign=middle><b>Remark:</b></td>
                    	    <td width=54% align=center valign=middle><div><b>";
							
							echo $remark;
                            echo"</b></div></td>
                  	    </tr>";
                        }
                        ?>
                    	  <tr>
                    	    <td colspan="4" align="right" valign="middle"><b>Sales Point:</b></td>
                    	    <td width="54%" align="center" valign="middle"><div><b>
							<?php
							$result=mysql_query("SELECT * FROM accounts WHERE id='$sp'");
							$row=mysql_fetch_array($result);
							echo $row['name']; 
							?>
                            </b></div></td>
                  	    </tr>
                        <tr>
                    	    <td width="8%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="16%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="12%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="10%" align="center" valign="middle">&nbsp;</td>
                    	    <td width="54%" align="center" valign="middle"><b><?php echo "0".$row['phone']?></b></td>
       	                </tr>
                  	  </table>
        			</div>
                </td>
  			</tr>
		</table></center></div><br /><br /><br />
        <form action="" method="post" enctype="multipart/form-data">
        <?php
		if($remark=="Not Yet Collected")
		{
        echo"<input name=supply type=submit value=Supply All />&nbsp;&nbsp;";
		}
        ?>
    <input name="print" type="submit" value="Print Reciept" />&nbsp;&nbsp;
    <input name="back" type="submit" value="Back" />
</form>
<?php 
if(isset($_POST['print']))
{
	require_once("js/printer.js");	
}
elseif(isset($_POST['back']))
{
	if(isset($_GET['continue']))
	{
		$continue=$_GET['continue'];
		if(isset($_GET['token']))
		{
		$token=$_GET['token'];
		Redirect($continue.'?page='.$token);
		}
		else
		{
			Redirect($continue);
		}
	}
	else
	{
		Redirect('receipt-archive.php');
	}
}
elseif(isset($_POST['supply']))
{
	$n_rn=base64_encode($rn);
	$continue="receipt-archive.php";
	Redirect('archived-reciept.php?rn='.$n_rn.'&continue='.$continue.'&token='.$_GET['token']);
	mysql_query("UPDATE reciept SET remark = 'Paid & Supplied' WHERE id='$rn'");
}
?>
    </td>
  </tr>
</table>
</body>
</html>