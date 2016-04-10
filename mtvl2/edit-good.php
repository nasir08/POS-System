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
			require_once('inc/header.php');
			$id=base64_decode($_GET['e_id']);
            $sp=$_SESSION['id'];
		}
		else
		{
			Redirect('goods-archive.php');
		}
	}
	if($_SESSION['type']!="admin")
	{
		require_once('inc/header.php');
		$passer="";
    	$sp=$_SESSION['id'];
	 }
	 else
	 {
		$sp=$_SESSION['id'];
		require_once('inc/header.php');
		require_once('inc/sidebar.php');
		$passer="";
	 }
?>

<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Edit Item Details</h2></div>
				<form method="post">
                <?php
				$result=mysql_query("SELECT * FROM goods WHERE id='$id'");
				$row=mysql_fetch_array($result);
				
		  if(isset($_POST['submit']))
		  {
			  $name=mysql_real_escape_string(trim($_POST['name']));
			  $family=mysql_real_escape_string(trim($_POST['family']));
			  $price=mysql_real_escape_string(trim($_POST['price']));
			  $inv=mysql_real_escape_string(trim($_POST['inv']));
			  $del=mysql_real_escape_string(trim($_POST['del']));
			  if($name=="")
			  {
				  echo "Item Name field cannot be empty.<br><br>";
			  }
			  elseif($family=="")
			  {
				  echo "Family field cannot be empty.<br><br>";
			  }
			  elseif($price=="")
			  {
				  echo "Price field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($price))
			  {
				  echo "Price must be a number.<br><br>";
			  }
			  elseif($inv=="")
			  {
				  echo "Inventory field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($inv))
			  {
				  echo "Inventory must be a number.<br><br>";
			  }
			  elseif($del=="")
			  {
				  echo "Delimeter field cannot be empty.<br><br>";
			  }
			  elseif(!is_numeric($del))
			  {
				  echo "Delimeter must be a number.<br><br>";
			  }
			  elseif($price<0)
			  {
				  echo "Price cannot be a negative number.<br><br>";
			  }
			  
			  else
			  {
				  mysql_query("UPDATE goods SET item_name='$name',family='$family',amount_rem='$inv',delimeter='$del',unit_price='$price' WHERE id='$id'");
				  if(isset($_GET['continue']))
				  {
					$result=mysql_query("SELECT COUNT(id) FROM goods");
         			$row=mysql_fetch_row($result);
					if($row[0]<=10)
					{
						Redirect('goods-archive.php');
					}
					else
					{
						Redirect('goods-archive.php?page='.$_GET['continue']);
					}
				  }
				  else
				  {
				  	Redirect('goods-archive.php');
				  }
			  }
		  }
		  ?>
                	<div class="element">
                    	<label for="category">Item Name</label>
						<input type="text" name="name" class="mini-text err" autofocus value="<?php echo $row['item_name'] ?>">
					</div>
                	<div class="element">
                    	<label for="category">Family</label>
						<input type="text" name="family" class="mini-text err" value="<?php echo $row['family'] ?>">
					</div>
                    <div class="element">
                    	<label for="category">Price</label>
						<input type="text" name="price" class="mini-text err" value="<?php echo $row['unit_price'] ?>">
					</div>
                    <div class="element">
                    	<label for="category">Inventory</label>
						<input type="number" name="inv" class="mini-text err" value="<?php echo $row['amount_rem'] ?>">
					</div>
                    <div class="element">
                    	<label for="category">Delimeter</label>
						<input type="number" name="del" class="mini-text err" value="<?php echo $row['delimeter'] ?>">
					</div>
                    <div class="element">
						<button type="submit" class="add" name="submit">Submit</button>
					</div>
                </form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php
	require_once('inc/footer.php');
	?>