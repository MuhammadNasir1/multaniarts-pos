if (update_data($dbc, 'purchase', $data, 'purchase_id', $_REQUEST['product_purchase_id'])) {
			$last_id = $_REQUEST['product_purchase_id'];

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
				'total_amount' => $_REQUEST['product_grand_amount_input'],
				'issuance_date' => $_REQUEST['purchase_date'],
				'to_location' => $_REQUEST['pur_location'],
			];
			// Add Data in 
			if ($_POST['location_type'] == 'dyeing') {
				$deleteDyeing = mysqli_query($dbc, "DELETE FROM dyeing WHERE purchase_id='" . $_REQUEST['product_purchase_id'] . "' ");
				$insert_data = insert_data($dbc, 'dyeing', $all_data);
			} elseif ($_POST['location_type'] == 'printer') {
				deleteFromTable($dbc, "printing", 'purchase_id', $_REQUEST['product_purchase_id']);
				$insert_data = insert_data($dbc, 'printing', $all_data);
			} elseif ($_POST['location_type'] == 'packing') {
				deleteFromTable($dbc, "packing", 'purchase_id', $_REQUEST['product_purchase_id']);
				$insert_data = insert_data($dbc, 'packing', $all_data);
			} elseif ($_POST['location_type'] == 'embroidery') {
				deleteFromTable($dbc, "embroidery", 'purchase_id', $_REQUEST['product_purchase_id']);
				$insert_data = insert_data($dbc, 'embroidery', $all_data);
			} elseif ($_POST['location_type'] == 'shop') {
				if ($get_company['stock_manage'] == 1) {
					$proQ = get($dbc, "purchase WHERE purchase_id='" . $last_id . "' ");

					while ($proR = mysqli_fetch_assoc($proQ)) {
						$newqty = 0;
						$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $proR['product_id'] . "' "));
						$newqty = (float)$quantity_instock['quantity_instock'] - (float)$proR['quantity'];
						$quantity_update = mysqli_query($dbc, query: "UPDATE product SET  quantity_instock='$newqty' WHERE product_id='" . $proR['product_id'] . "' ");
					}
				}
				if ($get_company['stock_manage'] == 1) {
					$product_id = $_REQUEST['product_id'];
					$quantity_instock = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT quantity_instock FROM  product WHERE product_id='" . $product_id . "' "));
					$qty = (float)$quantity_instock['quantity_instock'] + $_REQUEST['quantity'];
					$quantity_update = mysqli_query($dbc, "UPDATE product SET  quantity_instock='$qty' WHERE product_id='" . $product_id . "' ");
				}
			}


			$total_grand = $total_ammount - $total_ammount * ((float)$_REQUEST['ordered_discount'] / 100);
			$due_amount = (float)$total_grand - @(float)$_REQUEST['paid_ammount'];


			$transactions = fetchRecord($dbc, "purchase", "purchase_id", $_REQUEST['product_purchase_id']);
			$n = deleteFromTable($dbc, "transactions", 'transaction_id', $_REQUEST['transaction_id']);
			if(!$n) {
				echo "Error: " . "Transaction Not Deleted" . "transaction_id" . $_REQUEST['transaction_id'];
			}
			// @deleteFromTable($dbc, "transactions", 'transaction_id', $transactions['transaction_paid_id']);


			if ($_REQUEST['payment_type'] == "credit_purchase") :
				if ($due_amount > 0) {
					$debit = [
						'debit' => $due_amount,
						'credit' => 0,
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
					'credit' => @$_REQUEST['paid_ammount'],
					'debit' => 0,
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