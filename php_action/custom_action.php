<?php
require_once '../php_action/db_connect.php';
require_once '../includes/functions.php';
// print_r($_REQUEST);
// exit();
if (isset($_REQUEST['add_manually_user'])) {
	$data = [
		'customer_name' => @$_REQUEST['customer_name'],
		'customer_phone' => @$_REQUEST['customer_phone'],
		'customer_email' => @$_REQUEST['customer_email'],
		'customer_address' => @$_REQUEST['customer_address'],
		'customer_type' => @$_REQUEST['customer_type'],
		'customer_status' => @$_REQUEST['customer_status'],
		'customer_type' => @$_REQUEST['add_manually_user'],
	];
	if ($_REQUEST['customer_id'] == "") {

		if (insert_data($dbc, "customers", $data)) {


			$res = ['msg' => ucfirst($_REQUEST['add_manually_user']) . " Added Successfully", 'sts' => 'success'];
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	} else {
		if (update_data($dbc, "customers", $data, "customer_id", $_REQUEST['customer_id'])) {


			$res = ['msg' => ucfirst($_REQUEST['add_manually_user']) . " Updated Successfully", 'sts' => 'success'];
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	}
	echo json_encode($res);
}

if (isset($_REQUEST['new_voucher_date'])) {

	if ($_REQUEST['voucher_id'] == "") {
		if ($_REQUEST['voucher_group'] == "general_voucher") {
			$data = [
				'customer_id1' => @$_REQUEST['voucher_from_account'],
				'customer_id2' => @$_REQUEST['voucher_to_account'],
				'voucher_date' => @$_REQUEST['new_voucher_date'],
				'voucher_hint' => @$_REQUEST['voucher_hint'],
				'voucher_type' => @$_REQUEST['voucher_type'],
				'voucher_amount' => @$_REQUEST['voucher_debit'],
				'voucher_group' => @$_REQUEST['voucher_group'],
				'td_check_no' => @$_REQUEST['td_check_no'],
				'voucher_bank_name' => @$_REQUEST['voucher_bank_name'],
				'td_check_date' => @$_REQUEST['td_check_date'],
				'check_type' => @$_REQUEST['check_type'],
				'addby_user_id' => @$_SESSION['userId'],
			];
		} else {
			$data = [
				'customer_id1' => @$_REQUEST['voucher_from_account'],
				'customer_id2' => @$_REQUEST['voucher_to_account'],
				'voucher_date' => @$_REQUEST['new_voucher_date'],
				'voucher_hint' => @$_REQUEST['voucher_hint'],
				'voucher_type' => @$_REQUEST['voucher_type'],
				'voucher_amount' => @$_REQUEST['voucher_debit'],
				'voucher_group' => @$_REQUEST['voucher_group'],
				'addby_user_id' => @$_SESSION['userId'],
			];
		}
		if (insert_data($dbc, "vouchers", $data)) {
			$last_id = mysqli_insert_id($dbc);
			if ($_REQUEST['voucher_group'] == "expense_voucher") {
				$voucher_to_account = fetchRecord($dbc, "customers", "customer_id", $_REQUEST['voucher_to_account']);
				$budget = [
					'budget_amount' => @$_REQUEST['voucher_debit'],
					'budget_type' => "expense",
					'budget_date' => $_REQUEST['new_voucher_date'],
					'voucher_id' => $last_id,
					'voucher_type' => @$_REQUEST['voucher_type'],
					'budget_name' => @"expense added to " . @$voucher_to_account['customer_name'],
				];
				insert_data($dbc, "budget", $budget);
			} elseif ($_REQUEST['voucher_group'] == "general_voucher" and !empty($_REQUEST['td_check_no'])) {
				$data_checks = [
					'check_no' => $_REQUEST['td_check_no'],
					'check_bank_name' => $_REQUEST['voucher_bank_name'],
					'check_expiry_date' => $_REQUEST['td_check_date'],
					'check_type' => $_REQUEST['check_type'],
					'voucher_id' => $last_id,
					'check_status' => 0,
				];
				insert_data($dbc, "checks", $data_checks);
			}


			$debit = [
				'debit' => @$_REQUEST['voucher_debit'],
				'credit' => 0,
				'customer_id' => @$_REQUEST['voucher_from_account'],
				'transaction_from' => 'voucher',
				'transaction_type' => @$_REQUEST['voucher_type'],
				'transaction_remarks' => @$_REQUEST['voucher_hint'],
				'transaction_date' => @$_REQUEST['new_voucher_date'],
			];
			insert_data($dbc, "transactions", $debit);
			$transaction_id1 = mysqli_insert_id($dbc);
			$credit = [
				'credit' => @$_REQUEST['voucher_debit'],
				'debit' => 0,
				'customer_id' => @$_REQUEST['voucher_to_account'],
				'transaction_from' => 'voucher',
				'transaction_type' => @$_REQUEST['voucher_type'],
				'transaction_remarks' => @$_REQUEST['voucher_hint'],
				'transaction_date' => @$_REQUEST['new_voucher_date'],
			];

			insert_data($dbc, "transactions", $credit);
			$transaction_id2 = mysqli_insert_id($dbc);
			$newData = ['transaction_id1' => $transaction_id1, 'transaction_id2' => $transaction_id2];
			if (update_data($dbc, "vouchers", $newData, "voucher_id", $last_id)) {
				$res = ['msg' => "Voucher Added Successfully", 'sts' => 'success', 'voucher_id' => base64_encode($last_id)];
			} else {
				$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
			}
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	} else {
		if ($_REQUEST['voucher_group'] == "general_voucher") {
			$data = [
				'customer_id1' => @$_REQUEST['voucher_from_account'],
				'customer_id2' => @$_REQUEST['voucher_to_account'],
				'voucher_date' => @$_REQUEST['new_voucher_date'],
				'voucher_hint' => @$_REQUEST['voucher_hint'],
				'voucher_type' => @$_REQUEST['voucher_type'],
				'voucher_amount' => @$_REQUEST['voucher_debit'],
				'voucher_group' => @$_REQUEST['voucher_group'],
				'editby_user_id' => @$_SESSION['userId'],
				'td_check_no' => @$_REQUEST['td_check_no'],
				'voucher_bank_name' => @$_REQUEST['voucher_bank_name'],
				'check_type' => @$_REQUEST['check_type'],
				'td_check_date' => @$_REQUEST['td_check_date'],
			];
		} else {
			$data = [
				'customer_id1' => @$_REQUEST['voucher_from_account'],
				'customer_id2' => @$_REQUEST['voucher_to_account'],
				'voucher_date' => @$_REQUEST['new_voucher_date'],
				'voucher_hint' => @$_REQUEST['voucher_hint'],
				'voucher_type' => @$_REQUEST['voucher_type'],
				'voucher_amount' => @$_REQUEST['voucher_debit'],
				'voucher_group' => @$_REQUEST['voucher_group'],
				'editby_user_id' => @$_SESSION['userId'],
			];
		}
		if (update_data($dbc, "vouchers", $data, "voucher_id", $_REQUEST['voucher_id'])) {
			$last_id = $_REQUEST['voucher_id'];

			$transactions = fetchRecord($dbc, "vouchers", "voucher_id", $_REQUEST['voucher_id']);


			if ($_REQUEST['voucher_group'] == "expense_voucher") {
				$voucher_to_account = fetchRecord($dbc, "customers", "customer_id", $_REQUEST['voucher_to_account']);
				$budget = [
					'budget_amount' => @$_REQUEST['voucher_debit'],
					'budget_type' => "expense",
					'budget_date' => $_REQUEST['new_voucher_date'],
					'voucher_id' => $last_id,
					'voucher_type' => @$_REQUEST['voucher_type'],
					'budget_name' => @"expense added to " . @$voucher_to_account['customer_name'],
				];

				update_data($dbc, "budget", $budget, "voucher_id", $_REQUEST['voucher_id']);
			} elseif ($_REQUEST['voucher_group'] == "general_voucher") {
				$data_checks = [
					'check_no' => $_REQUEST['td_check_no'],
					'check_bank_name' => $_REQUEST['voucher_bank_name'],
					'check_expiry_date' => $_REQUEST['td_check_date'],
					'check_type' => $_REQUEST['check_type'],
					'voucher_id' => $last_id,
				];
				update_data($dbc, "checks", $data_checks, "voucher_id", $_REQUEST['voucher_id']);
			}

			$debit = [
				'debit' => @$_REQUEST['voucher_debit'],
				'credit' => 0,
				'customer_id' => @$_REQUEST['voucher_from_account'],
				'transaction_from' => 'voucher',
				'transaction_type' => @$_REQUEST['voucher_type'],
				'transaction_remarks' => @$_REQUEST['voucher_hint'],
				'transaction_date' => @$_REQUEST['new_voucher_date'],
			];

			update_data($dbc, "transactions", $debit, "transaction_id", $transactions['transaction_id1']);

			$credit = [
				'credit' => @$_REQUEST['voucher_debit'],
				'debit' => 0,
				'customer_id' => @$_REQUEST['voucher_to_account'],
				'transaction_from' => 'voucher',
				'transaction_type' => @$_REQUEST['voucher_type'],
				'transaction_remarks' => @$_REQUEST['voucher_hint'],
				'transaction_date' => @$_REQUEST['new_voucher_date'],
			];

			update_data($dbc, "transactions", $credit, "transaction_id", $transactions['transaction_id2']);

			$res = ['msg' => "Voucher Updated Successfully", 'sts' => 'success', 'voucher_id' => base64_encode($last_id)];
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	}
	echo json_encode($res);
}
if (isset($_REQUEST['new_sin_voucher_date'])) {
	if (!empty($_REQUEST['voucher_debit'])) {
		$amount = $_REQUEST['voucher_debit'];
	} else {
		$amount = $_REQUEST['voucher_credit'];
	}
	if ($_REQUEST['voucher_id'] == "") {
		$data = [
			'customer_id1' => @$_REQUEST['voucher_from_account'],
			'voucher_date' => @$_REQUEST['new_sin_voucher_date'],
			'voucher_hint' => @$_REQUEST['voucher_hint'],
			'voucher_amount' => $amount,
			'voucher_group' => @$_REQUEST['voucher_group'],
			'addby_user_id' => @$_SESSION['userId'],
		];
		if (insert_data($dbc, "vouchers", $data)) {
			$last_id = mysqli_insert_id($dbc);

			if (!empty($_REQUEST['voucher_debit'])) {
				$debit = [
					'debit' => $amount,
					'credit' => 0,
					'customer_id' => @$_REQUEST['voucher_from_account'],
					'transaction_from' => 'voucher',
					'transaction_type' => "single_voucher",
					'transaction_remarks' => @$_REQUEST['voucher_hint'],
					'transaction_date' => @$_REQUEST['new_sin_voucher_date'],
				];
				insert_data($dbc, "transactions", $debit);
			} else {
				$credit = [
					'credit' => $amount,
					'debit' => 0,
					'customer_id' => @$_REQUEST['voucher_from_account'],
					'transaction_from' => 'voucher',
					'transaction_type' => "single_voucher",
					'transaction_remarks' => @$_REQUEST['voucher_hint'],
					'transaction_date' => @$_REQUEST['new_sin_voucher_date'],
				];
				insert_data($dbc, "transactions", $credit);
			}



			$transaction_id1 = mysqli_insert_id($dbc);

			$newData = ['transaction_id1' => $transaction_id1];
			if (update_data($dbc, "vouchers", $newData, "voucher_id", $last_id)) {
				$res = ['msg' => "Voucher Added Successfully", 'sts' => 'success', 'voucher_id' => base64_encode($last_id)];
			} else {
				$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
			}
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	} else {
		$data = [
			'customer_id1' => @$_REQUEST['voucher_from_account'],
			'voucher_date' => @$_REQUEST['new_sin_voucher_date'],
			'voucher_hint' => @$_REQUEST['voucher_hint'],
			'voucher_amount' => $amount,
			'voucher_group' => @$_REQUEST['voucher_group'],
			'editby_user_id' => @$_SESSION['userId'],
		];

		if (update_data($dbc, "vouchers", $data, "voucher_id", $_REQUEST['voucher_id'])) {
			$last_id = $_REQUEST['voucher_id'];

			$transactions = fetchRecord($dbc, "vouchers", "voucher_id", $_REQUEST['voucher_id']);

			if (!empty($_REQUEST['voucher_debit'])) {
				$debit = [
					'debit' => @$_REQUEST['voucher_debit'],
					'credit' => 0,
					'customer_id' => @$_REQUEST['voucher_from_account'],
					'transaction_from' => 'voucher',
					'transaction_type' => "single_voucher",
					'transaction_remarks' => @$_REQUEST['voucher_hint'],
					'transaction_date' => @$_REQUEST['new_sin_voucher_date'],
				];
				update_data($dbc, "transactions", $debit, "transaction_id", $transactions['transaction_id1']);
			} else {
				$credit = [
					'credit' => @$_REQUEST['voucher_credit'],
					'debit' => 0,
					'customer_id' => @$_REQUEST['voucher_from_account'],
					'transaction_from' => 'voucher',
					'transaction_type' => "single_voucher",
					'transaction_remarks' => @$_REQUEST['voucher_hint'],
					'transaction_date' => @$_REQUEST['new_sin_voucher_date'],
				];
				update_data($dbc, "transactions", $credit, "transaction_id", $transactions['transaction_id1']);;
			}


			$res = ['msg' => "Voucher Updated Successfully", 'sts' => 'success', 'voucher_id' => base64_encode($last_id)];
		} else {

			$res = ['msg' => mysqli_error($dbc), 'sts' => 'error'];
		}
	}
	echo json_encode($res);
}
if (!empty($_REQUEST['action']) and $_REQUEST['action'] == "product_module") {
	$purchase_rate = $total = 0;
	$category_price = fetchRecord($dbc, "categories", "categories_id", $_REQUEST['category_id']);
	$purchase_rate = round($purchase_rate);

	$data_array = [
		'product_name' => $_REQUEST['product_name'],
		'product_code' => @$_REQUEST['product_code'],
		'brand_id' => @$_REQUEST['brand_id'],
		'category_id' => @$_REQUEST['category_id'],
		'current_rate' => 0,
		'product_description' => @$_REQUEST['product_description'],
		'alert_at' => @$_REQUEST['alert_at'],
		'availability' => @$_REQUEST['availability'],
		'purchase_rate' => $purchase_rate,
		'status' => 1,
	];
	if ($_REQUEST['product_id'] == "") {

		if (insert_data($dbc, "product", $data_array)) {
			$last_id = mysqli_insert_id($dbc);

			if ($_FILES['product_image']['tmp_name']) {
				upload_pic($_FILES['product_image'], '../img/uploads/');
				$product_image = $_SESSION['pic_name'];
				$data_image = [
					'product_image' => $product_image,
				];
				update_data($dbc, "product", $data_image, "product_id", $last_id);
			}


			$response = [
				"msg" => "Product Has Been Added",
				"sts" => "success",
				"id" => base64_encode($last_id),
				"link" => base64_encode('add_stock'),
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "error"
			];
		}
	} else {
		if (update_data($dbc, "product", $data_array, "product_id", base64_decode($_REQUEST['product_id']))) {
			$last_id = $_REQUEST['product_id'];

			if ($_FILES['product_image']['tmp_name']) {
				upload_pic($_FILES['product_image'], '../img/uploads/');
				$product_image = $_SESSION['pic_name'];
				$data_image = [
					'product_image' => $product_image,
				];
				update_data($dbc, "product", $data_image, "product_id", $last_id);
			}

			$response = [
				"msg" => "Product Updated",
				"sts" => "success",
				"id" => base64_encode($last_id),
				"link" => base64_encode('add_stock'),
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "error"
			];
		}
	}
	echo json_encode($response);
}

if (!empty($_REQUEST['action']) and $_REQUEST['action'] == "inventory_module") {

	$data_array = [
		'product_name' => $_REQUEST['product_name'],
		'product_code' => rand(),
		'brand_id' => 0,
		'category_id' => 0,
		'current_rate' => @$_REQUEST['current_rate'],
		'alert_at' => 5,
		'availability' => 1,
		'purchase_rate' => $_REQUEST['current_rate'],
		'status' => 1,
		'inventory' => 1,
	];
	if ($_REQUEST['product_id'] == "") {

		if (insert_data($dbc, "product", $data_array)) {
			$last_id = mysqli_insert_id($dbc);

			$response = [
				"msg" => "Inventory Product Has Been Added",
				"sts" => "success",
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "error"
			];
		}
	} else {
		if (update_data($dbc, "product", $data_array, "product_id", base64_decode($_REQUEST['product_id']))) {
			$last_id = $_REQUEST['product_id'];



			$response = [
				"msg" => "Product Updated",
				"sts" => "success",
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "error"
			];
		}
	}
	echo json_encode($response);
}
if (isset($_REQUEST['get_products_list'])) {

	if ($_REQUEST['type'] == "code") {
		// $q = mysqli_query($dbc, "SELECT * FROM product WHERE product_code LIKE '%" . $_REQUEST['get_products_list'] . "%' AND status=1 ");
		$q = mysqli_query($dbc, "SELECT * FROM product WHERE product_id LIKE '%" . $_REQUEST['get_products_list'] . "%' AND status=1 ");
		if (mysqli_num_rows($q) > 0) {
			while ($r = mysqli_fetch_assoc($q)) {
				echo '<option value="' . $r['product_id'] . '">' . $r['product_name'] . '</option>';
			}
		} else {
			echo '<option value="">Not Found</option>';
		}
	}
	if ($_REQUEST['type'] == "product") {
		$q = mysqli_query($dbc, "SELECT * FROM product WHERE product_id='" . $_REQUEST['get_products_list'] . "' AND status=1 ");
		if (mysqli_num_rows($q) > 0) {
			$r = mysqli_fetch_assoc($q);
			echo $r['product_code'];
		}
	}
}
if (isset($_REQUEST['getPrice'])) {
	if ($_REQUEST['type'] == "product") {
		$record = fetchRecord($dbc, "product", "product_id", $_REQUEST['getPrice']);
	} else {
		$record = fetchRecord($dbc, "product", "product_code", $_REQUEST['getPrice']);
	}

	$response = [
		"qty" => @(float)$record['quantity_instock'],
		"sts" => "success",
	];

	echo json_encode($response);
}


/*---------------------- cash sale-order   -------------------------------------------------------------------*/
if (isset($_REQUEST['sale_order_client_name'])) {
	$get_company = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM company ORDER BY id DESC LIMIT 1"));
	if (!empty($_REQUEST['product_ids'])) {
		# code...

		$total_ammount = $total_grand = 0;

		$data = [
			'order_date' => $_REQUEST['order_date'],
			'client_name' => $_REQUEST['sale_order_client_name'],
			'client_contact' => $_REQUEST['client_contact'],
			'paid' => $_REQUEST['paid_ammount'],
			'payment_account' => @$_REQUEST['payment_account'],
			'payment_type' => 'cash_in_hand',
			'vehicle_no' => @$_REQUEST['vehicle_no'],
			'pur_freight' => @$_REQUEST['freight'],
		];

		if ($_REQUEST['product_order_id'] == "") {

			if (insert_data($dbc, 'orders', $data)) {
				$last_id = mysqli_insert_id($dbc);
				$paidAmount = @(float)$_REQUEST['paid_ammount'];
				if ($paidAmount > 0) {
					$debit = [
						'debit' => @$_REQUEST['paid_ammount'],
						'credit' => 0,
						'customer_id' => @$_REQUEST['payment_account'],
						'transaction_from' => 'invoice',
						'transaction_type' => "cash_in_hand",
						'transaction_remarks' => "cash_sale by order id#" . $last_id,
						'transaction_date' => $_REQUEST['order_date'],
					];
					insert_data($dbc, 'transactions', $debit);
					$transaction_paid_id = mysqli_insert_id($dbc);
				}

				$x = 0;
				foreach ($_REQUEST['product_ids'] as $key => $value) {
					$total = $qty = 0;
					$product_quantites = (float)$_REQUEST['product_quantites'][$x];
					$product_rates = (float)$_REQUEST['product_rates'][$x];
					$total = (float)$product_quantites * $product_rates;
					$total_ammount += (float)$total;
					$order_items = [
						'product_id' => $_REQUEST['product_ids'][$x],
						'rate' => $product_rates,
						'total' => $total,
						'order_id' => $last_id,
						'quantity' => $product_quantites,
						'pur_thaan' => $_REQUEST['pur_thaan'][$x],
						'pur_gzanah' => $_REQUEST['pur_gzanah'][$x],
						'pur_unit' => $_REQUEST['pur_unit'][$x],
						'order_item_status' => 1,
					];
					if ($get_company['stock_manage'] == 1) {
						$product_id = $_REQUEST['product_ids'][$x];
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
						@$qty = (float)$quantity_instock['quantity_instock'] - (float)$product_quantites;
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
					}
					insert_data($dbc, 'order_item', $order_items);

					$x++;
				} //end of foreach
				$total_grand = @(float)$_REQUEST['freight'] + $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);

				$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];

				if ($due_amount > 0) {
					$payment_status = 0; //pending

				} else {
					$payment_status = 1; //completed

				}
				$newOrder = [
					'total_amount' => $total_ammount,
					'discount' => $_REQUEST['ordered_discount'],
					'grand_total' => $total_grand,
					'payment_status' => $payment_status,
					'due' => $due_amount,
					'order_status' => 1,
					'transaction_paid_id' => @$transaction_paid_id,
				];
				if (update_data($dbc, 'orders', $newOrder, 'order_id', $last_id)) {
					# code...
					//echo "<script>alert('company Updated....!')</script>";
					$msg = "Order Has been Added";
					$sts = 'success';
				} else {
					$msg = mysqli_error($dbc);
					$sts = "danger";
				}
			} else {
				$msg = mysqli_error($dbc);
				$sts = "danger";
			}
		} else {
			if (update_data($dbc, 'orders', $data, 'order_id', $_REQUEST['product_order_id'])) {
				$last_id = $_REQUEST['product_order_id'];
				if ($get_company['stock_manage'] == 1) {
					$proQ = get($dbc, "order_item WHERE order_id='" . $last_id . "' ");

					while ($proR = mysqli_fetch_assoc($proQ)) {
						$newqty = 0;
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $proR['product_id'] . "' "));
						$newqty = (float)$quantity_instock['quantity_instock'] + (float)$proR['quantity'];
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$newqty' WHERE product_id='" . $proR['product_id'] . "' ");
					}
				}
				deleteFromTable($dbc, "order_item", 'order_id', $_REQUEST['product_order_id']);

				$x = 0;
				foreach ($_REQUEST['product_ids'] as $key => $value) {
					$total = $qty = 0;
					$product_quantites = (float)$_REQUEST['product_quantites'][$x];
					$product_rates = (float)$_REQUEST['product_rates'][$x];
					$total = $product_quantites * $product_rates;
					$total_ammount += (float)$total;
					$order_items = [
						'product_id' => $_REQUEST['product_ids'][$x],
						'rate' => $product_rates,
						'total' => $total,
						'order_id' => $_REQUEST['product_order_id'],
						'pur_thaan' => $_REQUEST['pur_thaan'][$x],
						'pur_gzanah' => $_REQUEST['pur_gzanah'][$x],
						'pur_unit' => $_REQUEST['pur_unit'][$x],
						'quantity' => $product_quantites,
						'order_item_status' => 1,
					];
					if ($get_company['stock_manage'] == 1) {
						$product_id = $_REQUEST['product_ids'][$x];
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
						$qty = (float)$quantity_instock['quantity_instock'] - $product_quantites;
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
					}
					//update_data($dbc,'order_item', $order_items , 'order_id',$_REQUEST['product_order_id']);
					insert_data($dbc, 'order_item', $order_items);

					$x++;
				} //end of foreach
				$total_grand = @(float)$_REQUEST['freight'] + $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);
				$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];
				if ($due_amount > 0) {
					$payment_status = 0; //pending

				} else {
					$payment_status = 1; //completed

				}
				$newOrder = [

					'total_amount' => $total_ammount,
					'discount' => $_REQUEST['ordered_discount'],
					'grand_total' => $total_grand,
					'payment_status' => $payment_status,
					'due' => $due_amount,
				];
				$paidAmount = @(float)$_REQUEST['paid_ammount'];
				if ($paidAmount > 0) {
					$credit1 = [
						'debit' => @$_REQUEST['paid_ammount'],
						'credit' => 0,
						'customer_id' => @$_REQUEST['payment_account'],

					];
					$transactions = fetchRecord($dbc, "orders", "order_id", $_REQUEST['product_order_id']);
					update_data($dbc, "transactions", $credit1, "transaction_id", $transactions['transaction_paid_id']);
				}
				if (update_data($dbc, 'orders', $newOrder, 'order_id', $_REQUEST['product_order_id'])) {
					# code...
					//echo "<script>alert('company Updated....!')</script>";
					$msg = "Data Has been Updated";
					$sts = 'success';
				} else {
					$msg = mysqli_error($dbc);
					$sts = "danger";
				}
			} else {
				$msg = mysqli_error($dbc);
				$sts = "danger";
			}
		}
	} else {
		$msg = "Please Add Any Product";
		$sts = 'error';
	}
	echo json_encode(['msg' => $msg, 'sts' => $sts, 'order_id' => @$last_id, 'type' => "order", 'subtype' => $_REQUEST['payment_type']]);
}
/*---------------------- credit sale-order   -------------------------------------------------------------------*/
if (isset($_REQUEST['credit_order_client_name'])) {
	$get_company = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM company ORDER BY id DESC LIMIT 1"));
	if (!empty($_REQUEST['product_ids'])) {
		# code...
		$total_ammount = $total_grand = 0;

		$data = [
			'order_date' => $_REQUEST['order_date'],
			'client_name' => $_REQUEST['credit_order_client_name'],
			'client_contact' => $_REQUEST['client_contact'],
			'paid' => $_REQUEST['paid_ammount'],
			'order_narration' => @$_REQUEST['order_narration'],
			'payment_account' => @$_REQUEST['payment_account'],
			'customer_account' => @$_REQUEST['customer_account'],
			'payment_type' => 'credit_sale',
			'credit_sale_type' => @$_REQUEST['credit_sale_type'],
			'vehicle_no' => @$_REQUEST['vehicle_no'],
			'pur_freight' => @$_REQUEST['freight'],
			'voucher_no' => @$_REQUEST['voucher_no'],
		];
		//'payment_status'=>1,
		if ($_REQUEST['product_order_id'] == "") {

			if (insert_data($dbc, 'orders', $data)) {
				$last_id = mysqli_insert_id($dbc);
				$x = 0;
				foreach ($_REQUEST['product_ids'] as $key => $value) {
					$total = $qty = 0;
					$product_quantites = (float)$_REQUEST['product_quantites'][$x];
					$product_rates = (float)$_REQUEST['product_rates'][$x];
					$total = $product_quantites * $product_rates;
					$total_ammount += (float)$total;
					$order_items = [
						'product_id' => $_REQUEST['product_ids'][$x],
						'rate' => $product_rates,
						'pur_thaan' => $_REQUEST['pur_thaan'][$x],
						'pur_gzanah' => $_REQUEST['pur_gzanah'][$x],
						'pur_unit' => $_REQUEST['pur_unit'][$x],
						'total' => $total,
						'order_id' => $last_id,
						'quantity' => $product_quantites,
						'order_item_status' => 1,
					];

					if ($get_company['stock_manage'] == 1) {
						$product_id = $_REQUEST['product_ids'][$x];
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
						$qty = (float)$quantity_instock['quantity_instock'] - $product_quantites;
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
					}
					insert_data($dbc, 'order_item', $order_items);

					$x++;
				} //end of foreach

				$total_grand = @(float)$_REQUEST['freight'] + $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);
				$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];

				$credit = [
					'debit' => $due_amount,
					'credit' => 0,
					'customer_id' => @$_REQUEST['customer_account'],
					'transaction_from' => 'invoice',
					'transaction_type' => "credit_sale",
					'transaction_remarks' => "credit_sale by order id#" . $last_id,
					'transaction_date' => $_REQUEST['order_date'],
				];
				if ($due_amount > 0) {
					$payment_status = 0; //pending
					insert_data($dbc, 'transactions', $credit);
					$transaction_id = mysqli_insert_id($dbc);
				} else {
					$payment_status = 1; //completed
					$transaction_id = 0;
				}
				$paidAmount = @(float)$_REQUEST['paid_ammount'];
				if ($paidAmount > 0) {
					$credit1 = [
						'credit' => @$_REQUEST['paid_ammount'],
						'debit' => 0,
						'customer_id' => @$_REQUEST['payment_account'],
						'transaction_from' => 'invoice',
						'transaction_type' => "credit_sale",
						'transaction_remarks' => "credit_sale by order id#" . $last_id,
						'transaction_date' => $_REQUEST['order_date'],
					];
					insert_data($dbc, 'transactions', $credit1);
					$transaction_paid_id = mysqli_insert_id($dbc);
				}


				$newOrder = [
					'payment_status' => $payment_status,
					'total_amount' => $total_ammount,
					'discount' => $_REQUEST['ordered_discount'],
					'grand_total' => $total_grand,
					'due' => $due_amount,
					'order_status' => 1,
					'transaction_id' => @$transaction_id,
					'transaction_paid_id' => @$transaction_paid_id,
				];
				if (update_data($dbc, 'orders', $newOrder, 'order_id', $last_id)) {
					# code...
					//echo "<script>alert('company Updated....!')</script>";
					$msg = "Order Has been Added";
					$sts = 'success';
				} else {
					$msg = mysqli_error($dbc);
					$sts = "danger";
				}
			} else {
				$msg = mysqli_error($dbc);
				$sts = "danger";
			}
		} else {
			if (update_data($dbc, 'orders', $data, 'order_id', $_REQUEST['product_order_id'])) {
				$last_id = $_REQUEST['product_order_id'];
				if ($get_company['stock_manage'] == 1) {
					$proQ = get($dbc, "order_item WHERE order_id='" . $last_id . "' ");

					while ($proR = mysqli_fetch_assoc($proQ)) {
						$newqty = 0;
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $proR['product_id'] . "' "));
						$newqty = (float)$quantity_instock['quantity_instock'] + (float)$proR['quantity'];
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$newqty' WHERE product_id='" . $proR['product_id'] . "' ");
					}
				}
				deleteFromTable($dbc, "order_item", 'order_id', $_REQUEST['product_order_id']);

				$x = 0;
				foreach ($_REQUEST['product_ids'] as $key => $value) {
					$total = $qty = 0;
					$product_quantites = (float)$_REQUEST['product_quantites'][$x];
					$product_rates = (float)$_REQUEST['product_rates'][$x];
					$total = $product_quantites * $product_rates;
					$total_ammount += (float)$total;
					$order_items = [
						'product_id' => $_REQUEST['product_ids'][$x],
						'rate' => $product_rates,
						'total' => $total,
						'order_id' => $_REQUEST['product_order_id'],
						'quantity' => $product_quantites,
						'order_item_status' => 1,
					];
					if ($get_company['stock_manage'] == 1) {
						$product_id = $_REQUEST['product_ids'][$x];
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
						$qty = (float)$quantity_instock['quantity_instock'] - $product_quantites;
						$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
					}
					insert_data($dbc, 'order_item', $order_items);

					$x++;
				} //end of foreach
				$total_grand = @(float)$_REQUEST['freight'] + $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);
				$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];

				$transactions = fetchRecord($dbc, "orders", "order_id", $_REQUEST['product_order_id']);
				@deleteFromTable($dbc, "transactions", 'transaction_id', $transactions['transaction_id']);
				@deleteFromTable($dbc, "transactions", 'transaction_id', $transactions['transaction_paid_id']);

				$credit = [
					'debit' => $due_amount,
					'credit' => 0,
					'customer_id' => @$_REQUEST['customer_account'],
					'transaction_from' => 'invoice',
					'transaction_type' => "credit_sale",
					'transaction_remarks' => "credit_sale by order id#" . $last_id,
					'transaction_date' => $_REQUEST['order_date'],
				];
				if ($due_amount > 0) {
					$payment_status = 0; //pending
					insert_data($dbc, 'transactions', $credit);
					$transaction_id = mysqli_insert_id($dbc);
				} else {
					$payment_status = 1; //completed
					$transaction_id = 0;
				}
				$paidAmount = @(float)$_REQUEST['paid_ammount'];
				if ($paidAmount > 0) {
					$credit1 = [
						'credit' => @$_REQUEST['paid_ammount'],
						'debit' => 0,
						'customer_id' => @$_REQUEST['payment_account'],
						'transaction_from' => 'invoice',
						'transaction_type' => "credit_sale",
						'transaction_remarks' => "credit_sale by order id#" . $last_id,
						'transaction_date' => $_REQUEST['order_date'],
					];
					insert_data($dbc, 'transactions', $credit1);
					$transaction_paid_id = mysqli_insert_id($dbc);
				}

				$newOrder = [
					'payment_status' => $payment_status,
					'total_amount' => $total_ammount,
					'discount' => $_REQUEST['ordered_discount'],
					'grand_total' => $total_grand,
					'due' => $due_amount,
					'transaction_id' => @$transaction_id,
					'transaction_paid_id' => @$transaction_paid_id,
				];


				if (update_data($dbc, 'orders', $newOrder, 'order_id', $_REQUEST['product_order_id'])) {
					# code...
					//echo "<script>alert('company Updated....!')</script>";
					$msg = "Data Has been Updated";
					$sts = 'success';
				} else {
					$msg = mysqli_error($dbc);
					$sts = "danger";
				}
			} else {
				$msg = mysqli_error($dbc);
				$sts = "danger";
			}
		}
	} else {
		$msg = "Please Add Any Product";
		$sts = 'error';
	}
	echo json_encode(['msg' => $msg, 'sts' => $sts, 'order_id' => @$last_id, 'type' => "order", 'subtype' => $_REQUEST['payment_type']]);
}

if (isset($_REQUEST['getProductPills'])) {
	$q = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id='" . $_REQUEST['getProductPills'] . "' ");
	if (mysqli_num_rows($q) > 0) {
		while ($r = mysqli_fetch_assoc($q)) {
			echo '<li class="nav-item text-capitalize"  ><button type="button" onclick="addProductOrder(' . $r["product_id"] . ',' . $r["quantity_instock"] . ',`plus`)" class="btn btn-primary  m-1 ">' . $r["product_name"] . '</button></li>';
		}
	} else {
		echo '<li class="nav-item text-capitalize ">No Product Has Been Added</li>';
	}
}
if (isset($_REQUEST['getCustomer_name'])) {
	$q = mysqli_query($dbc, "SELECT DISTINCT client_name FROM  orders WHERE client_contact='" . $_REQUEST['getCustomer_name'] . "' ");
	if (mysqli_num_rows($q) > 0) {
		$r = mysqli_fetch_assoc($q);
		echo $r['client_name'];
	} else {
		echo '';
	}
}
if (isset($_REQUEST['getProductDetails'])) {
	$product = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT  product.*,brands.* FROM product INNER JOIN brands ON product.brand_id=brands.brand_id   WHERE product.product_id='" . $_REQUEST['getProductDetails'] . "' AND product.status=1  "));
	echo json_encode($product);
}
if (isset($_REQUEST['getProductDetailsBycode'])) {
	$product = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT  product.*,brands.* FROM product INNER JOIN brands ON product.brand_id=brands.brand_id   WHERE product.product_code='" . $_REQUEST['getProductDetailsBycode'] . "' AND product.status=1  "));
	echo json_encode($product);
}
/*---------------------- cash purchase   -------------------------------------------------------------------*/
if (isset($_REQUEST['cash_purchase_supplier'])) {
	// if (!empty($_REQUEST['product_ids'])) {
	# code...
	$total_ammount = $total_grand = 0;
	$get_company = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM company ORDER BY id DESC LIMIT 1"));

	$data = [
		'purchase_date' => $_REQUEST['purchase_date'],
		'client_name' => @$_REQUEST['cash_purchase_supplier'],
		'client_contact' => @$_REQUEST['client_contact'],
		'purchase_narration' => @$_REQUEST['purchase_narration'],
		'payment_account' => @$_REQUEST['payment_account'],
		'customer_account' => @$_REQUEST['customer_account'],
		'paid' => @$_REQUEST['paid_ammount'],
		'total_amount' => $_REQUEST['product_total_amount'],
		'grand_total' => $_REQUEST['product_grand_amount_input'],
		'payment_status' => 1,
		'payment_type' => $_REQUEST['payment_type'],
		'pur_freight' => @$_REQUEST['freight'],
		'purchase_for' => $_REQUEST['purchase_for'],
		'bill_no' => $_REQUEST['bill_no'],
		'gate_pass' => $_REQUEST['gate_pass'],
		'bilty_no' => $_REQUEST['bilty_no'],
		'pur_location' => $_REQUEST['pur_location'],
		'pur_cargo' => $_REQUEST['pur_cargo'],
		'pur_type' => $_REQUEST['pur_type'],
		'product_id' => $_REQUEST['product_id'],
		'pur_thaan' => $_REQUEST['pur_thaan'],
		'pur_rate' => $_REQUEST['product_price'],
		'pur_gzanah' => $_REQUEST['pur_gzanah'],
		'quantity' => $_REQUEST['quantity'],
		'discount' => $_REQUEST['ordered_discount'],
		'due' => $_REQUEST['remaining_ammount']
	];
	if ($_REQUEST['product_purchase_id'] == "") {

		if (insert_data($dbc, 'purchase', $data)) {

			$p_id = $_POST['next_increment'];
			$all_data = [
				'purchase_id' => $p_id,
				'done_by' => $_REQUEST['pur_location'],
				'status' => 'sent',
				'entry_from' => 'purchase',
				'product_id' => $_REQUEST['product_id'],
				'rate' => $_REQUEST['product_price'],
				'thaan' => $_REQUEST['pur_thaan'],
				'gzanah' => $_REQUEST['pur_gzanah'],
				'quantity' => $_REQUEST['quantity'],
				'quantity_instock' => $_REQUEST['quantity'],
				'unit' => $_REQUEST['pur_unit'],
			];
			// Add Data in 
			if ($_POST['location_type'] == 'dyeing') {
				$insert_data = insert_data($dbc, 'dyeing', $all_data);
			} elseif ($_POST['location_type'] == 'printer') {
				$insert_data = insert_data($dbc, 'printing', $all_data);
			} elseif ($_POST['location_type'] == 'packing') {
				$insert_data = insert_data($dbc, 'packing', $all_data);
			} elseif ($_POST['location_type'] == 'embroidery') {
				$insert_data = insert_data($dbc, 'embroidery', $all_data);
			} elseif ($_POST['location_type'] == 'shop') {
				if ($get_company['stock_manage'] == 1) {
					$product_id = $_REQUEST['product_id'];
					$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
					$qty = (float)$quantity_instock['quantity_instock'] + $_REQUEST['quantity'];
					$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
				}
			}

			// $total_grand = $total_ammount - $total_ammount * ((float)@$_REQUEST['ordered_discount'] / 100) + @$_REQUEST['freight'];

			// $due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];
			// if ($_REQUEST['payment_type'] == "credit_purchase") :
			// 	if ($due_amount > 0) {
			// 		$debit = [
			// 			'debit' => 0,
			// 			'credit' => $due_amount,
			// 			'customer_id' => @$_REQUEST['customer_account'],
			// 			'transaction_from' => 'purchase',
			// 			'transaction_type' => $_REQUEST['payment_type'],
			// 			'transaction_remarks' => "purchased on  purchased id#" . $last_id,
			// 			'transaction_date' => $_REQUEST['purchase_date'],
			// 		];
			// 		insert_data($dbc, 'transactions', $debit);
			// 		$transaction_id = mysqli_insert_id($dbc);
			// 	}
			// endif;
			// $paidAmount = @(float)$_REQUEST['paid_ammount'];
			// if ($paidAmount > 0) {
			// 	$credit = [
			// 		'credit' => 0,
			// 		'debit' => @$_REQUEST['paid_ammount'],
			// 		'customer_id' => @$_REQUEST['payment_account'],
			// 		'transaction_from' => 'purchase',
			// 		'transaction_type' => $_REQUEST['payment_type'],
			// 		'transaction_remarks' => "purchased by purchased id#" . $last_id,
			// 		'transaction_date' => $_REQUEST['purchase_date'],
			// 	];
			// 	insert_data($dbc, 'transactions', $credit);
			// 	$transaction_paid_id = mysqli_insert_id($dbc);
			// }

			// $newOrder = [
			// 	'total_amount' => $total_ammount,
			// 	'discount' => @$_REQUEST['ordered_discount'],
			// 	'grand_total' => @$total_grand,
			// 	'due' => $due_amount,
			// 	'transaction_paid_id' => @$transaction_paid_id,
			// 	'transaction_id' => @$transaction_id,
			// ];
			// if (update_data($dbc, 'purchase', $newOrder, 'purchase_id', $last_id)) {
			// 	# code...
			// 	//echo "<script>alert('company Updated....!')</script>";
			// 	$msg = "Purchase Has been Added";
			// 	$sts = 'success';
			// } else {
			// 	$msg = mysqli_error($dbc);
			// 	$sts = "danger";
			// }
			$msg = "Purchase Has been Added";
			$sts = 'success';
		} else {
			$msg = mysqli_error($dbc);
			$sts = "danger";
		}
	} else {
		if (update_data($dbc, 'purchase', $data, 'purchase_id', $_REQUEST['product_purchase_id'])) {
			$last_id = $_REQUEST['product_purchase_id'];


			if ($get_company['stock_manage'] == 1) {
				$proQ = get($dbc, "purchase_item WHERE purchase_id='" . $last_id . "' ");

				while ($proR = mysqli_fetch_assoc($proQ)) {
					$newqty = 0;
					$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $proR['product_id'] . "' "));
					$newqty = (float)$quantity_instock['quantity_instock'] - (float)$proR['quantity'];
					$quantity_update = mysqli_query($dbc, query: "UPDATE product SET  quantity_instock='$newqty' WHERE product_id='" . $proR['product_id'] . "' ");
				}
			}
			deleteFromTable($dbc, "purchase_item", 'purchase_id', $_REQUEST['product_purchase_id']);
			$x = 0;
			foreach ($_REQUEST['product_ids'] as $key => $value) {


				$total = $qty = 0;
				$product_quantites = (float)$_REQUEST['product_quantites'][$x];
				$product_rates = (float)$_REQUEST['product_rates'][$x];
				$total = $product_quantites * $product_rates;
				$total_ammount += (float)$total;
				$purchase_item = [
					'product_id' => $_REQUEST['product_ids'][$x],
					'rate' => $product_rates,
					'total' => $total,
					'purchase_id' => $_REQUEST['product_purchase_id'],
					'quantity' => $product_quantites,
					'purchase_item_status' => 1,
					'pur_thaan' => $_REQUEST['pur_thaan'][$x],
					'pur_gzanah' => $_REQUEST['pur_gzanah'][$x],
					'pur_unit' => $_REQUEST['pur_unit'][$x],
				];

				//update_data($dbc,'order_item', $order_items , 'purchase_id',$_REQUEST['product_purchase_id']);
				insert_data($dbc, 'purchase_item', $purchase_item);

				if ($get_company['stock_manage'] == 1) {
					$product_id = $_REQUEST['product_ids'][$x];
					$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
					$qty = (float)$quantity_instock['quantity_instock'] + $product_quantites;
					$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
				}

				$x++;
			} //end of foreach
			$total_grand = $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);
			$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];


			$transactions = fetchRecord($dbc, "purchase", "purchase_id", $_REQUEST['product_purchase_id']);
			@deleteFromTable($dbc, "transactions", 'transaction_id', $transactions['transaction_id']);
			@deleteFromTable($dbc, "transactions", 'transaction_id', $transactions['transaction_paid_id']);


			if ($_REQUEST['payment_type'] == "credit_purchase") :
				if ($due_amount > 0) {
					$debit = [
						'debit' => 0,
						'credit' => $due_amount,
						'customer_id' => @$_REQUEST['customer_account'],
						'transaction_from' => 'purchase',
						'transaction_type' => $_REQUEST['payment_type'],
						'transaction_remarks' => "purchased on  purchased id#" . $last_id,
						'transaction_date' => $_REQUEST['purchase_date'],
					];
					insert_data($dbc, 'transactions', $debit);
					$transaction_id = mysqli_insert_id($dbc);
				}
			endif;
			$paidAmount = @(float)$_REQUEST['paid_ammount'];
			if ($paidAmount > 0) {
				$credit = [
					'debit' => @$_REQUEST['paid_ammount'],
					'credit' => 0,
					'customer_id' => @$_REQUEST['payment_account'],
					'transaction_from' => 'purchase',
					'transaction_type' => $_REQUEST['payment_type'],
					'transaction_remarks' => "purchased by purchased id#" . $last_id,
					'transaction_date' => $_REQUEST['purchase_date'],
				];
				insert_data($dbc, 'transactions', $credit);
				$transaction_paid_id = mysqli_insert_id($dbc);
			}

			$newOrder = [

				'total_amount' => $total_ammount,
				'discount' => $_REQUEST['ordered_discount'],
				'grand_total' => $total_grand,
				'due' => $due_amount,
				'transaction_paid_id' => @$transaction_paid_id,
				'transaction_id' => @$transaction_id,
			];

			if (update_data($dbc, 'purchase', $newOrder, 'purchase_id', $_REQUEST['product_purchase_id'])) {
				# code...
				//echo "<script>alert('company Updated....!')</script>";
				$msg = "Purchase Has been Updated";
				$sts = 'success';
			} else {
				$msg = mysqli_error($dbc);
				$sts = "danger";
			}
		} else {
			$msg = mysqli_error($dbc);
			$sts = "danger";
		}
	}

	echo json_encode(['msg' => $msg, 'sts' => $sts, 'order_id' => @$last_id, 'type' => "purchase", 'subtype' => $_REQUEST['payment_type']]);
}
/*---------------------- credit Purchase-order  end -------------------------------------------------------------------*/
if (isset($_REQUEST['get_products_code'])) {
	$q = mysqli_query($dbc, "SELECT *  FROM product WHERE product_code='" . $_REQUEST['get_products_code'] . "' AND status=1 ");
	if (mysqli_num_rows($q) > 0) {
		$r = mysqli_fetch_assoc($q);
		$response = [
			"msg" => "This Product Code Already Assign to " . $r['product_name'],
			"sts" => "error",
		];
	} else {
		$response = [
			"msg" => "",
			"sts" => "success"
		];
	}
	echo json_encode($response);
}
if (isset($_REQUEST['getBalance'])) {
	$from_balance = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT SUM(credit-debit) AS from_balance FROM transactions WHERE customer_id='" . $_REQUEST['getBalance'] . "'"));
	$cust = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM customers WHERE customer_id = '" . $_REQUEST['getBalance'] . "'"));
	if (!empty($from_balance['from_balance'])) {
		$response1 = [
			'blnc' => round($from_balance['from_balance']),
			'custLimit' => round($cust['customer_limit']),
		];
	} else {
		$response1 = [
			'blnc' => '0',
			'custLimit' => round($cust['customer_limit']),
		];
	}
	echo json_encode($response1);
}
if (isset($_REQUEST['pending_bills_detils'])) {
	$pending_bills_detils = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM orders WHERE order_id='" . base64_decode($_REQUEST['pending_bills_detils']) . "'"));
	echo  json_encode($pending_bills_detils);
}
if (isset($_REQUEST['add_expense_name'])) {
	$data_array = [
		'expense_name' => $_REQUEST['add_expense_name'],
		'expense_status' => $_REQUEST['expense_status'],
	];
	if ($_REQUEST['expense_id'] == '') {
		if (insert_data($dbc, "expenses", $data_array)) {
			# code...
			$response = [
				"msg" => "expense Added successfully",
				"sts" => "success"
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "danger"
			];
		}
	} else {
		if (update_data($dbc, "expenses", $data_array, "expense_id", $_REQUEST['expense_id'])) {
			# code...
			$response = [
				"msg" => "expense Updated successfully",
				"sts" => "success"
			];
		} else {
			$response = [
				"msg" => mysqli_error($dbc),
				"sts" => "error"
			];
		}
	}
	echo json_encode($response);
}

if (isset($_REQUEST['setAmountPaid'])) {
	$newOrder = [
		'payment_status' => 1,
		'paid' => $_REQUEST['paid'],
		'due' => 0,
	];
	if (update_data($dbc, 'orders', $newOrder, 'order_id', $_REQUEST['setAmountPaid'])) {

		$response = [
			'msg' => "Amount Has been Paid",
			'sts' => 'success'
		];
	} else {
		$response = [
			'msg' => mysqli_error($dbc),
			'sts' => 'error'
		];
	}
	echo json_encode($response);
}
if (isset($_REQUEST['setCheckStatus'])) {
	$newStat = [
		'check_status' => $_REQUEST['status'],
	];
	if (update_data($dbc, 'checks', $newStat, 'check_id', $_REQUEST['setCheckStatus'])) {

		$response = [
			'msg' => "Action Has been Perform Successfully",
			'sts' => 'success'
		];
	} else {
		$response = [
			'msg' => mysqli_error($dbc),
			'sts' => 'error'
		];
	}
	echo json_encode($response);
}
if (isset($_REQUEST['bill_customer_name'])) {
	$paidAmount = (float)$_REQUEST['bill_paid_ammount'] + (float)$_REQUEST['bill_paid'];


	if ($paidAmount > 0) {
		$transactions = fetchRecord($dbc, "orders", "order_id", $_REQUEST['order_id']);
		$order_date = date('Y-m-d');
		if ($transactions['transaction_paid_id'] > 0) {
			$credit1 = [
				'credit' => @$paidAmount,
				'debit' => 0,
				'customer_id' => @$_REQUEST['bill_payment_account'],
			];

			update_data($dbc, "transactions", $credit1, "transaction_id", $transactions['transaction_paid_id']);
			$transaction_paid_id = $transactions['transaction_paid_id'];
		} else {
			$credit1 = [
				'credit' => @$paidAmount,
				'debit' => 0,
				'customer_id' => @$_REQUEST['bill_payment_account'],
				'transaction_from' => 'invoice',
				'transaction_type' => "cash_in_hand",
				'transaction_remarks' => "cash_sale by order id#" . $_REQUEST['order_id'],
				'transaction_date' => $order_date,
			];
			insert_data($dbc, 'transactions', $credit1);
			$transaction_paid_id = mysqli_insert_id($dbc);
		}
	}
	$due_amount = (float)$_REQUEST['bill_grand_total'] - $paidAmount;
	if ($due_amount > 0) {
		$payment_status = 0; //pending
	} else {
		$payment_status = 1; //completed
	}
	$newOrder = [
		'payment_status' => $payment_status,
		'paid' => $paidAmount,
		'due' => $due_amount,
		'transaction_paid_id' => $transaction_paid_id,
	];
	if (update_data($dbc, 'orders', $newOrder, 'order_id', $_REQUEST['order_id'])) {

		$response = [
			'msg' => "Amount Has been Paid",
			'sts' => 'success'
		];
	} else {
		$response = [
			'msg' => mysqli_error($dbc),
			'sts' => 'error'
		];
	}
	echo json_encode($response);
}
if (isset($_REQUEST['LimitCustomer'])) {
	$data = [
		'check_no' => $_REQUEST['td_check_no'],
		'check_bank_name' => $_REQUEST['voucher_bank_name'],
		'check_expiry_date' => $_REQUEST['td_check_date'],
		'voucher_id' => 0,
		'customer_id' => $_REQUEST['LimitCustomer'],
		'check_amount' => $_REQUEST['check_amount'],
		'check_location' => $_REQUEST['location_info'],
		'check_type' => $_REQUEST['check_type'],
	];
	$cust = $_REQUEST['LimitCustomer'];
	$limitNow =  $_REQUEST['check_amount'];

	$check = mysqli_query($dbc, "SELECT * FROM checks WHERE customer_id = '$cust' AND voucher_id = 0 AND check_amount != 0");
	//echo "SELECT * FROM checks WHERE customer_id = '$cust' AND voucher_id = 0 AND check_amount != 0";

	if (mysqli_num_rows($check) > 0) {
		$qq = mysqli_fetch_assoc($check);
		//echo $qq['check_id'];
		if (update_data($dbc, 'checks', $data, 'check_id', $qq['check_id'])) {
			mysqli_query($dbc, "UPDATE customers SET customer_limit = '$limitNow' WHERE customer_id = '$cust'");

			$response = [
				'msg' => "Data Updated successfully",
				'sts' => 'success'
			];
		}
	} else {
		if (insert_data($dbc, 'checks', $data)) {
			mysqli_query($dbc, "UPDATE customers SET customer_limit = '$limitNow' WHERE customer_id = '$cust'");
			$response = [
				'msg' => "Amount Has been Paid",
				'sts' => 'success'
			];
		} else {
			$response = [
				'msg' => mysqli_error($dbc),
				'sts' => 'error'
			];
		}
	}

	echo json_encode($response);
}


if (isset($_REQUEST['LimitCustomerajax'])) {
	$cust = $_REQUEST['LimitCustomerajax'];
	$check = mysqli_query($dbc, "SELECT * FROM checks WHERE customer_id = '$cust' AND voucher_id = 0 AND check_amount != 0");
	//echo "SELECT * FROM checks WHERE customer_id = '$cust' AND voucher_id = 0 AND check_amount != 0";
	if (mysqli_num_rows($check) > 0) {
		$qq = mysqli_fetch_assoc($check);
		//print_r($qq);
		$response = [
			'check_no' => $qq['check_no'],
			'bank_name' => $qq['check_bank_name'],
			'check_date' => $qq['check_expiry_date'],
			'check_type' => $qq['check_type'],
			'check_amount' => $qq['check_amount'],
			'check_location' => $qq['check_location'],
			'sts' 			=> 'success',

		];
	} else {
		$response = '';
	}


	echo json_encode($response);
}

if (isset($_REQUEST['getCustomerLimit'])) {
	$cust = $_REQUEST['getCustomerLimit'];
	$q = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT customer_limit as customer_limit FROM customers WHERE customer_id = '$cust'"));
	echo $q['customer_limit'];
}
// ====================================================
if (!empty($_REQUEST['cust_name']) && isset($_REQUEST['cust_email'])) {


	$data = [
		'cust_name' => $_REQUEST['cust_name'],
		'cust_email' => $_REQUEST['cust_email'],
		'cust_phone' => $_REQUEST['Customer_no'],
		'cust_address' => $_REQUEST['cust_address'],
		'cust_date' => $_REQUEST['quotation_date'],
		'cust_due_date' => $_REQUEST['quotation_due_date'],
		'user_id' => $_SESSION['user_id'],
		'quotation_status' => "1",
		'currency' => $_REQUEST['currency'],
		'taxrate' => $_REQUEST['tax'],
		'sb_total' => $_REQUEST['sub_total'],
		'grandtotal' => $_REQUEST['gr_total'],
		'note' => $_REQUEST['cust_note'],
		'description' => $_REQUEST['cust_description']
	];

	if (!empty($_REQUEST['quotation_edit_id'])) {

		if (update_data($dbc, "quotations", $data, "quotation_id ", $_REQUEST['quotation_edit_id'])) {
			$quotation_id = $_REQUEST['quotation_edit_id'];
			$product_name = $_REQUEST['product'];
			$product_quantity = $_REQUEST['quantity'];
			$product_rate = $_REQUEST['rate'];
			$kg_quantity = $_REQUEST['kg'];
			$sub_total = $_REQUEST['total_rate'];

			deleteFromTable($dbc, 'quotation_items', 'quotation_id', $quotation_id);

			if (
				is_array($product_name) &&
				is_array($product_quantity) &&
				is_array($product_rate)
			) {

				for ($i = 0; $i < count(@$product_name); $i++) {
					$additional_data = [
						'quotation_id' => @$quotation_id,
						'product_name' => @$product_name[$i],
						'product_quantity' => @$product_quantity[$i],
						'kg_quantity' => @$kg_quantity[$i],
						'sub_total' => @$sub_total[$i],
						'product_rate' => @$product_rate[$i]
					];

					insert_data($dbc, "quotation_items", $additional_data);
				}
			}
			$response = [
				'sts' => 'success',
				'msg' => 'Quotation Update Successfully'
			];
		} else {
			$response = [
				'sts' => 'warning',
				'msg' => 'Something went wrong'
			];
		}
	} else {
		if (insert_data($dbc, "quotations", $data)) {
			$quotation_id = mysqli_insert_id($dbc);
			$product_name = $_REQUEST['product'];
			$product_quantity = $_REQUEST['quantity'];
			$product_rate = $_REQUEST['rate'];
			$kg_quantity = $_REQUEST['kg'];
			$sub_total = $_REQUEST['total_rate'];

			$quotation_number = [
				'quotation_number' => $quotation_id . time()
			];

			update_data($dbc, "quotations", $quotation_number, "quotation_id", $quotation_id);

			if (
				is_array($product_name) &&
				is_array($product_quantity) &&
				is_array($product_rate)
			) {
				for ($i = 0; $i < count(@$product_name); $i++) {
					$additional_data = [
						'quotation_id' => @$quotation_id,
						'product_name' => @$product_name[$i],
						'product_quantity' => @$product_quantity[$i],
						'kg_quantity' => @$kg_quantity[$i],
						'sub_total' => @$sub_total[$i],
						'product_rate' => @$product_rate[$i]
					];

					// Insert data into the order_items table
					insert_data($dbc, "quotation_items", $additional_data);
				}
			}
			$response = [
				'sts' => 'success',
				'msg' => 'Quotation Created Successfully'
			];
		} else {
			$response = [
				'sts' => 'warning',
				'msg' => 'Something went wrong'
			];
		}
	}

	echo json_encode($response);
}

// ======================================================================================

if (!empty($_REQUEST['Quotation_delete_id']) && isset($_REQUEST['Quotation_delete_id'])) {

	$Quotation_id = $_REQUEST['Quotation_delete_id'];

	$quotations = mysqli_query($dbc, "DELETE FROM `quotations` WHERE `Quotation_id` = '$Quotation_id'");

	if ($quotations) {

		$quotation_items = mysqli_query($dbc, "DELETE FROM `quotation_items` WHERE `Quotation_id` = '$Quotation_id'");

		if ($quotation_items) {

			$response = [
				'sts' => 'success',
				'msg' => 'Data deleted successfully from both tables.'
			];
		} else {

			$response = [
				'sts' => 'error',
				'msg' => 'Error: Unable to delete data from quotation_items table.'
			];
		}
	} else {

		$response = [
			'sts' => 'error',
			'msg' => 'Error: Unable to delete data from quotations table.'
		];
	}
	echo json_encode($response);
}
if (@$_REQUEST['production_add_date'] && @$_REQUEST['production_lat_no']) {
	$data = [
		'purchase_id' => $_REQUEST['purchase_id'],
		'production_date' => $_REQUEST['production_add_date'],
		'production_name' => $_REQUEST['production_name'],
		'production_lat_no' => $_REQUEST['production_lat_no'],
	];

	if (!empty($_REQUEST['prod_upd_id'])) {
		if (update_data($dbc, "production", $data, "production_id ", $_REQUEST['prod_upd_id'])) {
			$response = [
				'sts' => 'success',
				'msg' => 'Production Update Successfully'
			];
		} else {
			$response = [
				'sts' => 'warning',
				'msg' => "Something went wrong" . mysqli_error($dbc)
			];
		}
	} else {
		if (insert_data($dbc, "production", $data)) {
			// Fetch the production_id of the newly inserted record
			$p_id = $_REQUEST['purchase_id'];
			$production_id_result = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT production_id FROM `production` WHERE purchase_id ='$p_id' ORDER BY production_id DESC LIMIT 1"));

			$response = [
				'sts' => 'success',
				'msg' => 'Data saved successfully',
				'purchase_id' => $_REQUEST['purchase_id'], // Include purchase_id
				'production_id' => $production_id_result['production_id'] // Include production_id
			];
		} else {
			$response = [
				'sts' => 'warning',
				'msg' => "Something went wrong" . mysqli_error($dbc)
			];
		}
	}

	echo json_encode($response);
}


// Vouchers

if (isset($_POST['action'])) {
	$action = $_POST['action'];

	if (
		$action === 'fetch_balance' && isset($_POST['dyer_id'])
	) {
		$dyer_id = $_POST['dyer_id'];

		$query = "SELECT stock FROM customers WHERE customer_id = '$dyer_id' AND customer_type = 'dyeing' AND customer_status = 1";
		$result = mysqli_query($dbc, $query);

		if (
			$result && mysqli_num_rows($result) > 0
		) {
			$row = mysqli_fetch_assoc($result);
			echo $row['stock'];
		} else {
			echo "0";
		}
	}

	if (
		$action === 'fetch_dyer_data' && isset($_POST['dyer_id'])
	) {
		$dyer_id = $_POST['dyer_id'];
		$deyeing_fetch = mysqli_query($dbc, "SELECT * FROM deyeing WHERE dey_party_name = '$dyer_id' AND deyeing_status = 'sent'");
		$ProductionID = $_POST['ProductionID'];
		$output = '';
		$a = 0;

		if (mysqli_num_rows($deyeing_fetch) > 0) {
			while ($row = mysqli_fetch_assoc($deyeing_fetch)) {
				$a++;
				$customer_result = mysqli_query($dbc, "SELECT customer_name FROM customers WHERE customer_id = '$dyer_id' AND customer_status = 1");
				$customer = mysqli_fetch_assoc($customer_result);
				$customer_name = ucwords($customer['customer_name']);

				$output .= '
                <tr>
                  <th>' . $a . '</th>
                  <td>' . $customer_name . '</td>
                  <td>' . $row['stock'] . '</td>
                  <td>' . $row['dey_location'] . '</td>
                 <td class="d-flex">
                <a target="_blank" href="print.php?production=' . $ProductionID . '&id=' . $row['id'] . '&type=dyeing" id="showData3">
                    <div class="btn btn-primary">
                        <i class="fa fa-print"></i> Print
                    </div>
                </a>
                <button class="btn btn-danger ml-2 btn-sm" onclick="deleteRow(' . $row['id'] . ')">Delete</button>
              </td>
                </tr>';
			}
		} else {
			$output = '<tr><td colspan="5" class="text-center">No Data Found For This Dyer</td></tr>';
		}

		echo $output;
	}
}

if (isset($_POST['action'])) {
	$action = $_POST['action'];

	if ($action === 'get_balance' && isset($_POST['party_id'])) {
		$party_id = $_POST['party_id'];

		$query = "SELECT stock FROM customers WHERE customer_id = '$party_id' AND customer_type = 'dyeing' AND customer_status = 1";
		$result = mysqli_query($dbc, $query);

		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo $row['stock'];
		} else {
			echo "0";
		}
	}

	if ($action === 'get_dyer_data' && isset($_POST['party_id'])) {
		$party_id = $_POST['party_id'];
		$ProductionID = $_POST['ProductionID'];

		$deyeing_fetch = mysqli_query($dbc, "SELECT * FROM deyeing WHERE dey_party_name = '$party_id' AND deyeing_status = 'recieved'");

		$output = '';
		$a = 0;

		if (mysqli_num_rows($deyeing_fetch) > 0) {
			while ($row = mysqli_fetch_assoc($deyeing_fetch)) {
				$a++;
				$customer_result = mysqli_query($dbc, "SELECT customer_name FROM customers WHERE customer_id = '$party_id' AND customer_status = 1");
				$customer = mysqli_fetch_assoc($customer_result);
				$customer_name = ucwords($customer['customer_name']);

				$output .= '
            <tr>
              <th>' . $a . '</th>
              <td>' . $customer_name . '</td>
              <td>' . $row['stock'] . '</td>
              <td>' . $row['dey_location'] . '</td>
              <td class="d-flex">
                <a target="_blank" href="print.php?production=' . $ProductionID . '&id=' . $row['id'] . '&type=dyeing" id="showData3">
                    <div class="btn btn-primary">
                        <i class="fa fa-print"></i> Print
                    </div>
                </a>
                <button class="btn btn-danger ml-2 btn-sm" onclick="deleteRow(' . $row['id'] . ')">Delete</button>
              </td>
            </tr>';
			}
		} else {
			$output = '<tr><td colspan="5" class="text-center">No Data Found For This Dyer</td></tr>';
		}

		echo $output;
	}
}


// Recieving Purchase Data Fetch
if (isset($_POST['recieve_purc_id'])) {
	$id = $dbc->real_escape_string($_POST['recieve_purc_id']);

	$purchaseResult = mysqli_query($dbc, "SELECT * FROM purchase WHERE purchase_id = '$id'");
	$purchaseData = $purchaseResult->fetch_assoc();

	$itemsResult = mysqli_query($dbc, "SELECT * FROM purchase_item WHERE purchase_id = '$id'");
	$itemsData = [];
	while ($row = $itemsResult->fetch_assoc()) {
		$product_id = $row['product_id'];

		$productResult = mysqli_query($dbc, "SELECT product_name FROM product WHERE product_id = '$product_id'");
		$productData = $productResult->fetch_assoc();

		$row['product_name'] = $productData['product_name'];
		$itemsData[] = $row;
	}

	if ($purchaseData) {
		echo json_encode(['success' => true, 'data' => $purchaseData, 'items' => $itemsData]);
	} else {
		echo json_encode(['success' => false, 'data' => null, 'items' => []]);
	}
}

// Find Location Type
if (isset($_POST['location_type_get'])) {
	$id = $dbc->real_escape_string($_POST['location_type_get']);

	$customer_data = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_id = '$id'");
	$customer = $customer_data->fetch_assoc();


	if ($customer) {
		echo json_encode(['success' => true, 'data' => $customer]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}


// Find Purchase Detail For customer

if (isset($_POST['get_purchase_data'])) {
	$id = $dbc->real_escape_string($_POST['get_purchase_data']);



	$customer_data = mysqli_query($dbc, "
        SELECT purchase.*, product.product_name 
        FROM purchase 
        LEFT JOIN product 
        ON purchase.product_id = product.product_id 
        WHERE purchase.pur_location = '$id'
    ");

	$customers = [];
	while ($row = $customer_data->fetch_assoc()) {
		$customers[] = $row;
	}

	if (!empty($customers)) {
		echo json_encode(['success' => true, 'data' => $customers]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}


if (isset($_POST['get_dyeing_data'])) {
	$id = $dbc->real_escape_string($_POST['get_dyeing_data']);

	// Optimized query to join tables and eliminate duplicates
	$query = "
        SELECT 
            product.*, 
            dyeing.*
        FROM dyeing
        INNER JOIN product 
        ON product.product_id = dyeing.product_id
        WHERE dyeing.to_location = '$id' 
        AND dyeing.status = 'sent'
    ";

	$result = mysqli_query($dbc, $query);

	$customers = [];
	while ($row = $result->fetch_assoc()) {
		$customers[] = $row;
	}

	if (!empty($customers)) {
		echo json_encode(['success' => true, 'data' => $customers]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}




// Get Selected Purchase Data 

if (isset($_POST['get_selected_purchase'])) {
	$id = $dbc->real_escape_string($_POST['get_selected_purchase']);

	$purchase_data = mysqli_query($dbc, "SELECT * FROM purchase WHERE purchase_id = '$id'");
	$purchase = $purchase_data->fetch_assoc();

	$p_id = $purchase['product_id'];
	$product_data = mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$p_id'");
	$product = $product_data->fetch_assoc();

	if ($purchase && $product) {
		echo json_encode(['success' => true, 'data' => $purchase, 'product' => $product]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}

if (isset($_POST['get_selected_dyeing'])) {
	$id = $dbc->real_escape_string($_POST['get_selected_dyeing']);

	$purchase_data = mysqli_query($dbc, "SELECT * FROM dyeing WHERE dyeing_id = '$id'");
	$purchase = $purchase_data->fetch_assoc();

	$p_id = $purchase['product_id'];
	$product_data = mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$p_id'");
	$product = $product_data->fetch_assoc();

	if ($purchase && $product) {
		echo json_encode(['success' => true, 'data' => $purchase, 'product' => $product]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}

if (isset($_POST['dyeing_issuance_form'])) {
	$json_data = [
		"from_product" => $_POST['from_product'],
		"pur_type_arr" => $_POST['pur_type_arr'],
		"unit_arr" => $_POST['unit_arr'],
		"color_arr" => $_POST['color_arr'],
		"thaan_arr" => $_POST['thaan_arr'],
		"pur_thaan_arr" => $_POST['pur_thaan_arr'],
		"qty_arr" => $_POST['qty_arr'],
		"suit_arr" => $_POST['suit_arr'],
		"gzanah_arr" => $_POST['gzanah_arr'],
		"lot_no_arr" => $_POST['lot_no_arr'],
	];

	$data = [
		'purchase_id' => $_POST['dyeing_issuance_purchase'],
		'done_by' => $_POST['to_location'],
		'status' => 'sent',
		'entry_from' => 'dyeing_issuance',
		'product_id' => $_POST['product_id'],
		'rate' => $_POST['rate'],
		'total_amount' => $_POST['total_amount'],
		'thaan' => $_POST['thaan'],
		'gzanah' => $_POST['gzanah'],
		'quantity' => $_POST['qty'],
		'unit' => $_POST['unit'],
		'transaction_id' => $_POST['transaction'],
		'issuance_date' => $_POST['issuance_date'],
		'gate_pass' => $_POST['gate_pass'],
		'from_location' => $_POST['from_location'],
		'to_location' => $_POST['to_location'],
		'pandi' => $_POST['pandi'],
		'bilty_no' => $_POST['bilty_no'],
		'remarks' => $_POST['purchase_narration'],
		'product_details' => json_encode($json_data),
	];

	if ($_POST['location_type'] == 'dyeing') {
		$t = 'dyeing';
	} elseif ($_POST['location_type'] == 'printer') {
		$t = 'printer';
	} elseif ($_POST['location_type'] == 'packing') {
		$t = 'packing';
	} elseif ($_POST['location_type'] == 'embroidery') {
		$t = 'embroidery';
	} elseif ($_POST['location_type'] == 'shop') {
		$product_id = $_POST['product_id'];
		$requested_quantity = (float) $_POST['qty'];

		$query = "SELECT * FROM product WHERE product_id='$product_id'";
		$result = mysqli_query($dbc, $query);
		$quantity_instock = $result->fetch_assoc();

		$new_qty = (float) $quantity_instock['quantity_instock'] - $requested_quantity;
		$quantity_update = mysqli_query($dbc, "UPDATE product SET quantity_instock='$new_qty' WHERE product_id='$product_id'");
		$t = $_POST['location_type'];
	}


	if (insert_data($dbc, "dyeing", $data)) {
		$response = [
			'sts' => 'success',
			'msg' => 'Dyeing Issued successfully',
			'purchase_id' => $_POST['dyeing_issuance_purchase'],
			'tab' => $t,
		];
	} else {
		$response = [
			'sts' => 'warning',
			'msg' => "Something went wrong: " . mysqli_error($dbc),
		];
	}

	echo json_encode($response);
}

if (isset($_POST['dyeing_recieving'])) {
	$json_data = [
		"from_product" => $_POST['from_product'],
		"pur_type_arr" => $_POST['pur_type_arr'],
		"unit_arr" => $_POST['unit_arr'],
		"color_arr" => $_POST['color_arr'],
		"thaan_arr" => $_POST['thaan_arr'],
		"pur_thaan_arr" => $_POST['pur_thaan_arr'],
		"qty_arr" => $_POST['qty_arr'],
		"suit_arr" => $_POST['suit_arr'],
		"gzanah_arr" => $_POST['gzanah_arr'],
		"lot_no_arr" => $_POST['lot_no_arr'],
	];

	$data = [
		'purchase_id' => $_POST['dyeing_issuance_purchase'],
		'done_by' => $_POST['to_location'],
		'status' => 'received',
		'entry_from' => 'dyeing_receiving',
		'recievied_dyeing' => $_POST['recievied_dyeing'],
		'product_id' => $_POST['product_id'],
		'rate' => $_POST['rate'],
		'total_amount' => $_POST['total_amount'],
		'thaan' => $_POST['thaan'],
		'gzanah' => $_POST['gzanah'],
		'quantity' => $_POST['qty'],
		'unit' => $_POST['unit'],
		'transaction_id' => $_POST['transaction'],
		'issuance_date' => $_POST['issuance_date'],
		'gate_pass' => $_POST['gate_pass'],
		'from_location' => $_POST['from_location'],
		'to_location' => $_POST['to_location'],
		'pandi' => $_POST['pandi'],
		'bilty_no' => $_POST['bilty_no'],
		'remarks' => $_POST['purchase_narration'],
		'product_details' => json_encode($json_data),
	];




	if (insert_data($dbc, "dyeing", $data)) {
		$response = [
			'sts' => 'success',
			'msg' => 'Dyeing Received successfully',
			'dyeing_id' => $_POST['dyeing_issuance_purchase'],
		];
	} else {
		$response = [
			'sts' => 'warning',
			'msg' => "Something went wrong: " . mysqli_error($dbc),
		];
	}

	echo json_encode($response);
}
// Dyeing Recieving Form

if (
	isset($_POST['rec_purchase_id'])
) {
	$data = [
		'purchase_id' => $_POST['rec_purchase_id'],
		'dyed_thaans' => $_POST['dyed_thaans'],
		'color' => $_POST['color'],
		'dyed_qty' => $_POST['dyed_qty'],
		'cut_piece' => $_POST['cut_piece'],
		'un_settled' => $_POST['un_settled'],
		'to_location' => $_POST['to_location'],
	];

	if (insert_data($dbc, "dyeing", $data)) {
		$response = [
			'sts' => 'success',
			'msg' => 'Data saved successfully',
			'purchase_id' => $_POST['rec_purchase_id'],
		];
	} else {
		$response = [
			'sts' => 'warning',
			'msg' => "Something went wrong: " . mysqli_error($dbc)
		];
	}

	echo json_encode($response);
}

// Get Stock Function

if (isset($_POST['get_stock'])) {
	$id = $dbc->real_escape_string($_POST['get_stock']);

	$productData = mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$id'");
	$product = $productData->fetch_assoc();



	if ($product) {
		echo json_encode(['success' => true, 'data' => $product]);
	} else {
		echo json_encode(['success' => false, 'data' => null]);
	}
}
