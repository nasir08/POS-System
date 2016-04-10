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
			$id=base64_decode($_GET['item']);
			require_once('inc/header.php');
			$passer="";
			$msg="";
			$sp=$_SESSION['id'];
		}
		else
		{
			Redirect("sales.php");
		}
		
	}
?>

<body id="page4">
<!-- START PAGE SOURCE -->
<div class="body3"></div>
<div class="body1">
  <div class="main">
    <header>
      <?php
	  	require_once('inc/logo.php');
	  ?>
      <nav>
        <ul id="menu">
          <li><a href="sales.php">Sales</a></li>
          <li><a href="expenses.php">Expenses</a></li>
          <li><a href="receipt-archive.php">Reciept Archive</a></li>
          <?php
            if(($_SESSION['type']=="admin")|| ($_SESSION['type']=="manager"))
			echo"<li><a href=goods-archive.php>Goods Archive</a></li>";
			?>
          <li><a href="my-account.php">My Account</a></li>
          <?php
            if($_SESSION['type']=="admin")
			echo"<li class=bg_none><a href=all-accounts.php>All Accounts</a></li>";
			?>
          
        </ul>
      </nav>
      <div class="wrapper">
        <div class="text1">Sales Point: <?php echo $_SESSION['name'] ?></div>
        <div class="text2">
        <?php
    $result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
	$row=mysql_fetch_row($result);
	$get_t=mysql_query("SELECT SUM(amount) FROM cart WHERE sales_point= '$sp'");
	$geter=mysql_fetch_row($get_t);
	$geter=number_format($geter[0],2);
	if($row[0]==0)
	{
		echo "Cart ($row[0] items - 0.00)";
	    $passer="no link";
	}
	
	echo "<a href=\"cart.php\">";
	if($row[0]==1)
	{echo "Cart ($row[0] item - $geter)";}
	elseif($row[0]>1)
	{echo "Cart ($row[0] items - $geter)";}
	echo "</a>";
	?>   
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
       Customers Waiting(3)</div>
        <br>
      </div>
    </header>
  </div>
</div>
<div class="body2">
  <div class="main">
    <section id="content">
      <div class="marg_top wrapper">
        <div class="box1_out">
          <div class="box1">
            <h2 class="desc">Item Selection</h2>
            <h2 class="title">Item: 
          <?php
		  $result=mysql_query("SELECT * FROM goods WHERE id = '$id'");
		  $row=mysql_fetch_array($result);
		  echo $row['item_name'];
		  ?>
          </h2>
				<form id="form1" method="post" action="">
                <?php
				if(isset($_POST['btnAdd']))
				{
					$price=$row['unit_price'];
				
					
					if(trim($_POST['txtDisc'])!="")
					{
						$price=trim($_POST['txtDisc']);
					}
					
					$name=mysql_real_escape_string($row['item_name']);
					$qty=trim($_POST['txtQty']);
					$amount=$qty*$price;
					$sp=$_SESSION['id'];
					
					
				    if($qty=="")
					{ echo "Quantity field cannot be empty<br><br>"; }
					
					elseif(!is_numeric($qty))
					{ echo "Quantity must be a number<br><br>"; }
					
					elseif(!is_numeric($price))
					{ echo "Price must be a number<br><br>"; }
					
					elseif($qty<0)
					{ echo "Quantity must not be a negative value<br><br>"; }
					
					elseif($price<0)
					{ echo "Price must not be a negative value<br><br>"; }
										
					else
					{
						$result=mysql_query("SELECT delimeter,amount_rem FROM goods WHERE id='$id'");
					$row=mysql_fetch_array($result);
						if($row['amount_rem']<1)
						{ echo "$name is not in stock.<br><br>"; }
						else
						{
							$conv=$qty*$row['delimeter'];
							if($conv>$row['amount_rem'])
							{
								echo "You have only $row[amount_rem] piece(s) of $name in stock.<br><br>";
							}
							else
							{
								mysql_query("INSERT INTO cart(item_name, unit_price, quantity, amount, sales_point,good_id) VALUES ('$name','$price','$qty','$amount','$sp','$id')");
					Redirect('sales.php');
							}
						}
					}
				}
				?>
					<input name="txtQty" class="input" type="text" placeholder="Quantity" value=<?php if(isset($_POST['btnAdd'])){ echo $qty; } ?> >  &nbsp;&nbsp;&nbsp;
                    <input name="txtDisc" class="input" type="text" placeholder="New Unit Price"> &nbsp; &nbsp;
                    <input type="submit" class="regular_button" value="Add to cart" name="btnAdd"><br><br>
                    
                    
                  <br><br><br><br>
                  <a href="#">Lay-off Customer</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php 
  					if($passer=="")
  					echo"<a href=cancel_order.php?sales_point=$_SESSION[id]>Cancel Item Selection</a>"; 
  				?>
                  <br><br><br><br>
              </form>
           </div>
        </div>
      </div>
    </section>
  </div>
</div>
<div class="main">
  <?php
  	require_once('inc/footer.php');
  ?>
</div>
<script type="text/javascript"> Cufon.now(); </script>
<!-- END PAGE SOURCE -->
</body>
</html>