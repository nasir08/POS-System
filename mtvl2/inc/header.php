<?php
	$result=mysql_query("SELECT status FROM accounts WHERE id='$_SESSION[id]'");
	$row=mysql_fetch_array($result);
	if($row['status']==1){ Redirect("signout.php"); }
	else{ }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>M.T. Ventures LTD</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
});
</script>
</head>
<body>
<div class="wrap">
	<div id="header">
		<div id="top">
			<div class="left">
				<p>Welcome, <strong><?php echo $_SESSION['name'] ?>.</strong> [ <a href="signout.php">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p><strong>M.T. Ventures LTD</strong> - Retail Management System</p>
				</div>
			</div>
		</div>
		<div id="nav">
			<ul>
				<li class="upp"><a href="#">Main control</a>
					<ul>
						<li>&#8250; <a href="sales.php">Sales</a></li>
						<li>&#8250; <a href="expenses.php">Expenses</a></li>
						<li>&#8250; <a href="receipt-archive.php">Invoice</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Manage Debtors</a>
					<ul>
						<li>&#8250; <a href="all-debtors.php">View All Debtors</a></li>
						<li>&#8250; <a href="add-new-debtor.php">Add New Debtor</a></li>
						<li>&#8250; <a href="debt-reports.php">Debt Reports</a></li>
					</ul>
				</li>
                <?php
            	if(($_SESSION['type']=="admin")|| ($_SESSION['type']=="manager"))
				echo"<li class=upp><a href=#>Manage Items</a>
					<ul>
						<li>&#8250; <a href=goods-archive.php>Show All Items</a></li>
						<li>&#8250; <a href=add-new-item.php>Add New Item</a></li>
						<li>&#8250; <a href=inventory.php>Inventory</a></li>
					</ul>
				</li>";
                ?>
                <li class="upp"><a href="#">Manage Accounts</a>
					<ul>
						<li>&#8250; <a href="my-account.php">My Account</a></li>
                        <?php
            			if($_SESSION['type']=="admin")
						echo"<li>&#8250; <a href=all-accounts.php>Show All Users</a></li>
						<li>&#8250; <a href=add-new-sales-point.php>Add New User</a></li>";
						?>
					</ul>
				</li>
				<li class="upp"><a href="#">Settings</a>
					<ul>
						<li>&#8250; <a href="change-password.php">Change Password</a></li>
					</ul>
				</li>
			</ul>
            <div id="righter">
            <?php
    		$result2=mysql_query("SELECT COUNT(DISTINCT(customer)) FROM waiting");
			$row2=mysql_fetch_row($result2);
        	echo"<a href=waiting.php>Customers Waiting ($row2[0])</a>";
			?> 
            &nbsp;&nbsp;| &nbsp;&nbsp;
            <?php
    $result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
	$row=mysql_fetch_row($result);
	$get_t=mysql_query("SELECT SUM(amount) FROM cart WHERE sales_point= '$sp'");
	$geter=mysql_fetch_row($get_t);
	$geter=number_format($geter[0],2);
	if($row[0]==0)
	{
		echo "Cart ($row[0] items - &#8358;0.00)";
	    $passer="no link";
	}
	
	echo "<a href=\"cart.php\">";
	if($row[0]==1)
	{echo "Cart ($row[0] item - &#8358;$geter)";}
	elseif($row[0]>1)
	{echo "Cart ($row[0] items - &#8358;$geter)";}
	echo "</a>";
	?>  
            </div>
		</div>
        
	</div>