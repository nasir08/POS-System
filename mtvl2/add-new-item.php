<?php
	require_once('inc/functions.php');
	session_start();
	  if(!(isset($_SESSION['id'])))
	  {
		 Redirect('signout.php'); 
	  }
	  else
	  {
         if(($_SESSION['type']!="admin") && ($_SESSION['type']!="manager"))
	 	 {
				Redirect('sales.php');
	 	 }
		 else
		{
			$sp=$_SESSION['id'];
			require_once('inc/header.php');
	 		require_once('inc/sidebar.php');
		}
     }
?>
<div id="main">
			
			<div class="clear"></div>
			<div class="full_w">
            <div style="padding-left:15px;"><h2 class="desc">Add New Item</h2></div>
				<form method="post">
                
                <?php
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
				  mysql_query("INSERT INTO goods (item_name,family,amount_rem,delimeter,unit_price) VALUES('$name','$family','$inv','$del','$price')");
				  Redirect('goods-archive.php');
			  }
		  }
		  
		  elseif(isset($_POST['cancel']))
		  {
			  Redirect('goods-archive.php');
		  }
		  ?>
                	<div class="element">
                    	<label for="category">Item Name</label>
						<input type="text" name="name" class="mini-text err" autofocus>
					</div>
                	<div class="element">
                    	<label for="category">Family</label>
						<input type="text" name="family" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Price</label>
						<input type="number" name="price" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Inventory</label>
						<input type="number" name="inv" class="mini-text err">
					</div>
                    <div class="element">
                    	<label for="category">Delimeter</label>
						<input type="number" name="del" class="mini-text err">
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