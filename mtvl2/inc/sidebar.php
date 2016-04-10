<div id="content">
		<div id="sidebar">
			<div class="box">
				<div class="h_title">&#8250; Main control</div>
				<ul id="home">
					<li class="b1"><a class="icon view_page" href="sales.php">Sales</a></li>
					<li class="b2"><a class="icon add_page" href="expenses.php">Expenses</a></li>
					<li class="b1"><a class="icon report" href="receipt-archive.php">Invoice</a></li>
				</ul>
			</div>
            <div class="box">
				<div class="h_title">&#8250; Manage Debtors</div>
				<ul>
					<li class="b1"><a class="icon report" href="all-debtors.php">View All Debtors</a></li>
					<li class="b2"><a class="icon add_page" href="add-new-debtor.php">Add New Debtor</a></li>
				</ul>
			</div>
            <div class="box">
				<div class="h_title">&#8250; Manage Creditors</div>
				<ul>
					<li class="b1"><a class="icon report" href="all-creditors.php">View All Creditors</a></li>
					<li class="b2"><a class="icon add_page" href="add-new-creditor.php">Add New Creditors</a></li>
				</ul>
			</div>
			<?php
            	if(($_SESSION['type']=="admin")|| ($_SESSION['type']=="manager"))
				echo"<div class=box>
				<div class=h_title>&#8250; Manage Items</div>
				<ul>
					<li class=b1><a class=\"icon report\" href=goods-archive.php>Show All Items</a></li>
					<li class=b2><a class=\"icon add_page\" href=add-new-item.php>Add New Item</a></li>
					<li class=b1><a class=\"icon report\" href=inventory.php>Inventory</a></li>
				</ul>
			</div>";
			?>
			<div class="box">
				<div class="h_title">&#8250; Manage Accounts</div>
				<ul>
                	<li class="b1"><a class="icon users" href="my-account.php">My Account</a></li>
					<?php
            		if($_SESSION['type']=="admin")
					echo"<li class=b1><a class=\"icon users\" href=all-accounts.php>Show All Users</a></li>
					<li class=b2><a class=\"icon add_user\" href=add-new-sales-point.php>Add New User</a></li>";
					?>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Settings</div>
				<ul>
					<li class="b1"><a class="icon config" href="change-password.php">Change Password</a></li>
				</ul>
			</div>
		</div>