<?php
	if(isset($_POST['key'])) {
		
		$conn = new mysqli('localhost', 'root', '', 'phx');
		
		//edit data row
		if ($_POST['key'] == 'getRowData'){
			$rowID = $conn->real_escape_string($_POST['rowID']);
			$sql = $conn->query("SELECT order_num, customer, carrier, city, status, 
			ship_time, truckloads, plt_qty FROM shipping WHERE id='$rowID'");
			$data = $sql->fetch_array();
			$jsonArray = array(
				'order_num' => $data['order_num'],
				'customer' => $data['customer'],
				'carrier' => $data['carrier'],
				'city' => $data['city'],
				'status' => $data['status'],
				'ship_time' => $data['ship_time'],
				'truckloads' => $data['truckloads'],
				'plt_qty' => $data['plt_qty'],
			);
			exit(json_encode($jsonArray));
		}
		
		//gets existing data from database
		if ($_POST['key'] == 'getExistingData'){
			$start = $conn->real_escape_string($_POST['start']);
			$limit = $conn->real_escape_string($_POST['limit']);
			
			//$sql = $conn->query("SELECT * FROM shipping LIMIT $start, $limit");
			$sql = $conn->query("SELECT * FROM shipping WHERE IsDeleted = 0 LIMIT $start, $limit");
			if ($sql->num_rows > 0){
				$response ="";
				while($data = $sql->fetch_array()){
					$response .='
						<tr>
							<td>'.$data["id"].'</td>
				<td id="shipping_order_num_'.$data["id"].'">'.$data["order_num"].'</td>
				<td id="shipping_customer_'.$data["id"].'">'.$data["customer"].'</td>
				<td id="shipping_carrier_' .$data["id"].'">'.$data["carrier"].'</td>
				<td id="shipping_city_' .$data["id"].'">'.$data["city"].'</td>
				<td id="shipping_status_' .$data["id"].'">'.$data["status"].'</td>
				<td id="shipping_ship_time_' .$data["id"].'">'.$data["ship_time"].'</td>
				<td id="shipping_truckloads_' .$data["id"].'">'.$data["truckloads"].'</td>
				<td id="shipping_plt_qty_' .$data["id"].'">'.$data["plt_qty"].'</td>
							<td>
								<input type="button" onclick="viewORedit('.$data["id"].', \'view\')" value="More Info" class="btn btn-info">
								<input type="button" onclick="viewORedit('.$data["id"].', \'edit\')" value="Edit" class="btn btn-primary">
								<input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-danger">
							</td>
						</tr>
					';
				}
				exit($response);
			}else
				exit('reachedMax');
		}
		
		$rowID = $conn->real_escape_string($_POST['rowID']);
		
		if($_POST['key'] == 'deleteRow'){
			//$conn->query("DELETE from shipping WHERE id='$rowID'");
			$conn->query("UPDATE shipping SET isDeleted = 1 WHERE id='$rowID'");
			exit('The Row Has Been Deleted');
		}
		
		$order_num = $conn->real_escape_string($_POST['order_num']);
		$customer = $conn->real_escape_string($_POST['customer']);
		$carrier = $conn->real_escape_string($_POST['carrier']);
		$city = $conn->real_escape_string($_POST['city']);
		$status = $conn->real_escape_string($_POST['status']);
		$ship_time = $conn->real_escape_string($_POST['ship_time']);
		$truckloads = $conn->real_escape_string($_POST['truckloads']);
		$plt_qty = $conn->real_escape_string($_POST['plt_qty']);
		
		//update rows
		if ($_POST['key'] == 'updateRow'){
			$conn->query("UPDATE shipping SET order_num='$order_num', customer='$customer', carrier='$carrier', city='$city',
						status='$status', ship_time='$ship_time', truckloads='$truckloads', plt_qty='$plt_qty' WHERE id='$rowID'");
			exit('Success');
		}
		
		//add new order
		if ($_POST['key'] == 'addNew'){
			$conn->query("INSERT INTO shipping (id, order_num, customer, carrier, city, status, ship_time, truckloads, plt_qty) 
			VALUES (DEFAULT, '$order_num', '$customer', '$carrier', '$city', '$status', '$ship_time', '$truckloads', '$plt_qty')");
			exit('Success');
		}
	}
?>