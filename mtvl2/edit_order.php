<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
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
				require_once('inc/sidebar.php');
				$passer="";
			}
		}
		else
		{
			Redirect("cart.php");
		}
		
	}
?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Edit Selected Item</h2>
            <h2 class="title">Item:
            <?php
			$result=mysql_query("SELECT * FROM cart WHERE id= '$id'");
			$row=mysql_fetch_assoc($result);
			
		  	echo $row['item_name']."</h2>";
		  	?>
            </div>
				<form method="post">
                	<div class="element">
						<label for="name">Quantity</label>
						<input id="name" name="txtQty" class="mini-text err" value="<?php echo $row['quantity'] ?>"/>
					</div>
                    <div class="element">
						<label for="name">New Unit Price</label>
						<input id="name" name="txtDisc" class="mini-text err" autofocus placeholder="New Unit Price" />
					</div>
                    <div class="entry">
						<button type="submit" class="add" name="btnAdd">Update</button>
					</div>
                </form>
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
					{ echo "<div class=n_error><p>Error notification. Quantity field cannot be empty.</p></div>"; }
					
					elseif(!is_numeric($qty))
					{ echo "<div class=n_error><p>Error notification. Quantity must be a number.</p></div>"; }
					
					elseif(!is_numeric($price))
					{ echo "<div class=n_error><p>Error notification. Price must be a number.</p></div>"; }
					
					elseif($qty<0)
					{ echo "<div class=n_error><p>Error notification. Quantity must not be a negative value.</p></div>"; }
					
					
					elseif($price<0)
					{ echo "<div class=n_error><p>Error notification. Price must not be a negative value.</p></div>"; }
										
					else
					{
						mysql_query("UPDATE cart SET item_name='$name', unit_price='$price', quantity='$qty', amount='$amount', sales_point='$sp' WHERE id='$id'");
					Redirect('cart.php');
					}
				}
				?>
				<div class="entry">
					<div class="sep"></div>		
					<a class="button" href="">Lay-Off Customer</a> 
                    <?php 
  						if($passer=="")
  						echo"<a class=button href=cancel_order.php?sales_point=$_SESSION[id]>Cancel Item Selection</a>"; 
  					?>  
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php
	require_once('inc/footer.php');
	?>