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
			
			$sp=$_SESSION['id'];
    		$result=mysql_query("SELECT COUNT(item_name) FROM cart WHERE sales_point= '$sp'");
			$row=mysql_fetch_row($result);
			if($row[0]==0)
			{
				Redirect('sales.php');
			}
			else
			{
				require_once('inc/header.php');
				$passer="";
			}
		}
		else
		{
			Redirect("cart.php");
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
            <h2 class="desc">Edit Selected Item</h2>
            <h2 class="title">Item: 
          <?php
		  $result=mysql_query("SELECT * FROM cart WHERE id = '$id'");
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
					$qty=mysql_real_escape_string(trim($_POST['txtQty']));
					$amount=$qty*$price;
					$sp=$_SESSION['id'];
				
				
				    if($qty=="")
					{ echo "Quantity field cannot be empty<br><br>"; }
					
					elseif(!is_numeric($qty))
					{ echo "Quantity must be a number<br><br>"; }
					
					elseif(!is_numeric($price))
					{ echo "Price must be a number<br><br>"; }
										
					else
					{
					mysql_query("UPDATE cart SET item_name='$name', unit_price='$price', quantity='$qty', amount='$amount', sales_point='$sp' WHERE id='$id'");
					Redirect('cart.php');
					}
				}
				?>
					<input name="txtQty" class="input" type="text" placeholder="Quantity" value=<?php if(isset($_POST['btnAdd'])){ echo $qty; } ?> >  &nbsp;&nbsp;&nbsp;
                    <input name="txtDisc" class="input" type="text" placeholder="New Unit Price"> &nbsp; &nbsp;
                    <input type="submit" class="regular_button" value="Submit" name="btnAdd"><br><br>
                    
                    
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