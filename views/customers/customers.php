<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DCIMStack</title>
	<?php 
	include 'libraries/css.php';
	include 'libraries/general.php'; 
	?>
</head>

<body>

	<?php include 'libraries/header.php'; ?>

	<div class="container">
		<h1 class="page-header">Customers 
			<div class='pull-right'>
				<button type="button" class='btn btn-primary' data-toggle="modal" data-target="#add_customer">
					<img src='assets/img/add.png'> Add</a>
				</button>	
			</div>
		</h1>
		<?php include 'libraries/alerts.php'; ?>
		<?php
		include 'config/db.php';
		$sql = "SELECT * FROM `customers`";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
                // output data of each row
			echo "<table class='table' id='search_table'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>#</th>";
			echo "<th>Customer Name</th>";
			echo "<th>Device Count</th>";
			echo "<th>Delivery ETA</th>";
			echo "<th>Status</th>";
			echo "<th>Mark</th>";
			echo "<th>Archive</th>";
			echo "<th><center>Manage</center></th>";
			echo "</tr>";
			echo "</thead>";
			while ($row = $result->fetch_assoc()) {
				$customer_id = $row['id'];
				echo "<tr>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".htmlspecialchars($row["customer_name"])."</td>";
				echo "<td>".$customer_id."</td>";
				echo "<td>".$row["shipment_delivery_eta"]."</td>";
				echo "<td>".$row["shipment_status"]."</td>";
				echo "<td><center><a href='shipment_status.php?shipment_id=$shipment_id&status=undelivered'>Mark as undelivered</a></center></td>";
				echo "<td><center><a href='shipment_status.php?shipment_id=$shipment_id&archive=1'>Archive</a></center></td>";
				echo "<td><center><a href='shipment_manage.php?shipment_id=$shipment_id' data-remote='false' data-toggle='ajaxModal' data-target='#myModal'>Manage</a></center></td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "0 results";
		}
		$conn->close();
		?>
	</div>

	<!-- Add Shipment Modal -->
	<div id="add_customer" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><img src='assets/img/user_suit.png'> Add Customer</h4>
				</div>
				<div class="modal-body">
					<form action="add_shipment_db.php" id="add_hdds" method="post">
						<label>Customer name</label>
						<input type="text" class="form-control" name="customer_name" placeholder="Customer Name" required>
						<label>Tracking ID</label>
						<input type="text" class="form-control" name="tracking_id" placeholder="Tracking ID" required>
						<label>Shipping Courier</label>
						<select class="form-control" name="shipping_courier">
							<option value="USPS">USPS</option>
							<option value="FedEX">FedEX</option>
							<option value="UPS">UPS</option>
							<option value="DHL">DHL</option>
						</select>
						<label>Shipping Courier (Other)</label>
						<input type="text" class="form-control" name="shipping_courier_custom" placeholder="Eg, Pickup?">
						<label>Delivery ETA</label>
						<input type="date" class="form-control" name="delivery_eta" placeholder="Eg: 02/10/2016" required>
						<label>Delivery Status</label>
						<select class="form-control" name="delivery_status">
							<option value="Waiting For Dispatch">Waiting For Dispatch</option>
							<option value="Dispatched">Dispatched</option>
							<option value="In-Transit">In-Transit</option>
							<option value="Out For Delivery">Out For Delivery</option>
							<option value="Delivered">Delivered</option>
						</select>
					</form>
				</div>
				<div class="modal-footer">
					<input type="submit" form="add_hdds" class="btn btn-primary">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include 'libraries/js.php'; ?>
</body>
</html>