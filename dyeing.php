<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';

if (!empty($_REQUEST['ProductionID']) && isset($_REQUEST['ProductionID'])) {

    $ProductionID = $_REQUEST['ProductionID'];

    $dataproduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE `production_id` = '$ProductionID'"));
    $request_id = $dataproduction['purchase_id'];
    $purchase_data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `purchase` WHERE `purchase_id` = '$request_id'"));
    $user_id = $_SESSION['userId'];
    $deyeingfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $ProductionID and deyeing_status = 'sent'"));
    $deyeingfetchRecieve = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $ProductionID and deyeing_status = 'recieved'"));
}

//deyeing Voucher Data

if (isset($_POST['dyeing_btn'])) {
    $deyeing_id = $_POST['deyeing_id'];
    $deyeing_in_out = $_POST['deyeing_in_out'];
    $deyeing_status = $_POST['deyeing_status'];
    $dyeing_date = $_POST['dyeing_date'];
    $dyeing_gate_no = $_POST['dyeing_gate_no'];
    $dyeing_lat_name = $_POST['dyeing_lat_name'];
    $dyeing_party_name = $_POST['dyeing_party_name'];
    $dyeing_party_voucher = $_POST['dyeing_party_voucher'];
    $dyeing_color_name = $_POST['dyeing_color_name'];
    $dyeing_location = $_POST['dyeing_location'];
    $dyeing_remarks = $_POST['dyeing_remarks'];
    $dey_bill_no = $_POST['dey_bill_no'];
    $dey_bilty_no = $_POST['dey_bilty_no'];
    $dyeing_delivery_date = $_POST['dyeing_delivery_date'];

    $dey_sending_quantity = @$_POST['dey_sending_quantity'];
    $dey_recieving_quantity = @$_POST['dey_recieving_quantity'];

    $total_sending_quantity = 0;
    if (is_array($dey_sending_quantity)) {
        foreach ($dey_sending_quantity as $quantity) {
            $total_sending_quantity += (float)$quantity;
        }
    }

    $total_recieving_quantity = 0;
    if (is_array($dey_recieving_quantity)) {
        foreach ($dey_recieving_quantity as $quantity) {
            $total_recieving_quantity += (float)$quantity;
        }
    }

    $deyData1 = [
        'deying_product' => @$_POST['deying_product'],
        'dey_sending_thaan' => @$_POST['dey_sending_thaan'],
        'dey_sending_gzanah' => @$_POST['dey_sending_gzanah'],
        'dey_sending_quantity' => $dey_sending_quantity,
        'total_sending_quantity' => $total_sending_quantity
    ];

    $deyData2 = [
        'dey_recieving_product' => @$_POST['dey_recieving_product'],
        'dey_recieving_thaan' => @$_POST['dey_recieving_thaan'],
        'dey_recieving_gzanah' => @$_POST['dey_recieving_gzanah'],
        'dey_recieving_quantity' => $dey_recieving_quantity,
        'total_recieving_quantity' => $total_recieving_quantity
    ];

    $deyJson1 = json_encode($deyData1);
    $deyJson2 = json_encode($deyData2);

    if (empty($deyeing_id)) {
        // echo $total_sending_quantity;
        $deyeingDataInsert = "INSERT INTO `deyeing`(`user_id`, `updated_user_id`, `deyeing_in_out`, `deyeing_status`, `dey_production_id`, `dey_date`, `dey_gate_no`, `dey_lat_no`, `dey_party_name`, `dey_voucher_no`, `dey_color_name`, `dey_location`, `dey_bill_no`, `dey_bilty_no`, `dey_delivery_date`, `dey_remarks`, `dey_sending_list`, `dey_recieving_list`, `stock`) 
            VALUES ('$user_id','$user_id','$deyeing_in_out','$deyeing_status','$ProductionID','$dyeing_date','$dyeing_gate_no','$dyeing_lat_name','$dyeing_party_name','$dyeing_party_voucher','$dyeing_color_name','$dyeing_location','$dey_bill_no','$dey_bilty_no','$dyeing_delivery_date','$dyeing_remarks','$deyJson1','$deyJson2','$total_sending_quantity')";
        $deyeingQuery = mysqli_query($dbc, $deyeingDataInsert);

        if (@$deyeingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $deyeingUpdate = mysqli_query($dbc, "UPDATE `deyeing` SET 
            `updated_user_id`='$user_id',
            `deyeing_in_out`='$deyeing_in_out',
            `deyeing_status`='$deyeing_status',
            `dey_date` = '$dyeing_date', 
            `dey_gate_no` = '$dyeing_gate_no', 
            `dey_lat_no` = '$dyeing_lat_name', 
            `dey_party_name` = '$dyeing_party_name', 
            `dey_voucher_no` = '$dyeing_party_voucher', 
            `dey_color_name` = '$dyeing_color_name', 
            `dey_location` = '$dyeing_location', 
            `dey_bill_no` = '$dey_bill_no', 
            `dey_bilty_no` = '$dey_bilty_no', 
            `dey_delivery_date` = '$dyeing_delivery_date', 
            `dey_remarks` = '$dyeing_remarks', 
            `dey_sending_list` = '$deyJson1',
            `dey_recieving_list` = '$deyJson2'
            WHERE id = $deyeing_id");

        if ($deyeingUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

?>
<style>
    .nav-list {
        font-size: 25px;
    }

    .bg-custom {
        background-color: #E1E1E1;
    }
</style>

<body class="horizontal light">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>

        <div class="container-fluid m-0 p-0">
            <div class="card m-0">
                <div class="card-header card-bg" align="center">
                    <div class="row">
                        <div class="col-12 mx-auto h4">
                            <b class="text-center card-text">Dyeing</b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="bg-white rounded shadow mb-5">
                        <ul id="myTab" role="tablist" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-custom border-0 rounded-nav">
                            <li class="nav-item flex-sm-fill">
                                <a id="profile-tab" data-toggle="tab" href="#sending" role="tab" aria-controls="sending" aria-selected="true" class="nav-link border-0 font-weight-bold nav-list">Sending</a>
                            </li>
                            <li class="nav-item flex-sm-fill">
                                <a id="contact-tab" data-toggle="tab" href="#receiving" role="tab" aria-controls="receiving" aria-selected="true" class="nav-link border-0 font-weight-bold nav-list">Receiving</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div id="sending" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 mb-3">
                                <form action="" method="post">
                                    <input type="hidden" id="hiddenInput3" name="deyeing_id">
                                    <input type="hidden" value="sent" name="deyeing_status">
                                    <input type="hidden" value="in" name="deyeing_in_out">
                                    <div class="row pb-2">
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="dyeing_date">Date</label>
                                            <input type="date" class="form-control" name="dyeing_date" id="dyeing_date" placeholder="Select Date">
                                        </div>
                                        <div class="col-lg-2 mt-3 d-flex">
                                            <div class="w-100">
                                                <label class="font-weight-bold text-dark" for="Party Name">Dyer Name</label>
                                                <select class="form-control searchableSelect" name="dyeing_party_name" id="dyeing_party_name" onchange="fetchDyerBalance(this.value); fetchDyerData(this.value);">
                                                    <option value="">Select Dyer</option>
                                                    <?php
                                                    $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'dyeing' AND customer_status = 1");
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <option value="<?= $row['customer_id'] ?>">
                                                            <?= ucwords($row['customer_name']) ?> (<?= ucwords($row['customer_type']) ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group-prepend mt-4 ml-2">
                                                <span class="input-group-text mt-1" id="basic-addon1">Balance: <span id="from_account_bl">0</span></span>
                                            </div>
                                            <input type="hidden" id="dyer_id">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                            <input type="text" class="form-control" name="dyeing_gate_no" id="dyeing_gate_no" placeholder="Gate pass no.">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="dyeing_lat_name">Lat no.</label>
                                            <input type="text" class="form-control" name="dyeing_lat_name" id="dyeing_lat_name" placeholder="Lat Number">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Party Voucher No.">Party Voucher No.</label>
                                            <input type="text" class="form-control" name="dyeing_party_voucher" id="dyeing_party_voucher" placeholder="Party Voucher No.">
                                        </div>
                                        <div class="col-lg-2 mt-3 pr-1">
                                            <label class="font-weight-bold text-dark" for="color">Color Name</label>
                                            <input type="text" class="form-control" name="dyeing_color_name" id="dyeing_color_name" placeholder="Name">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Location">Location</label>
                                            <input type="text" class="form-control" name="dyeing_location" id="dyeing_location" placeholder="Location">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark">Bill No.</label>
                                            <input type="number" min="0" placeholder="Bil No." autocomplete="off" class="form-control" name="dey_bill_no">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark">Bilty No.</label>
                                            <input type="number" min="0" placeholder="Bilty No." autocomplete="off" class="form-control" name="dey_bilty_no">
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                            <textarea name="dyeing_remarks" id="dyeing_remarks" placeholder="Remarks" class="form-control"></textarea>
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                            <input type="Date" class="form-control" name="dyeing_delivery_date" id="dyeing_delivery_date" placeholder="Location">
                                        </div>


                                    </div>


                                    <div class="row mt-5">
                                        <div class="col">
                                            <h4>
                                                List
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="deyingContainer">
                                        <div class="card px-5 py-3">



                                            <div id="dey3" class="w-100">
                                                <div class="row mt-3 m-0 p-0 w-100 col-12 dey-row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 row m-0 p-0">
                                                        <div class="col-12 m-0 p-0 pr-2">
                                                            <label class="font-weight-bold text-dark" for="deying_product">Quality</label>
                                                            <select class="form-control" name="deying_product[]">
                                                                <option value="">Select Product</option>
                                                                <?php
                                                                $purchase_data = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                $product_ids = array();
                                                                while ($rowdata = mysqli_fetch_array($purchase_data)) {
                                                                    $product_id = $rowdata['product_id'];
                                                                    $product_ids[] = $product_id;
                                                                    $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id");
                                                                    while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                        $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata2['brand_id']);
                                                                        $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata2['category_id']);
                                                                ?>
                                                                        <option data-price="<?= $rowdata2["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata2["product_id"] ?>">
                                                                            <?= ucwords($rowdata2["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                        </option>
                                                                <?php   }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 ml-2 col-md-2 col-sm-2 col-xs-2 row">
                                                        <label class="font-weight-bold text-dark">Thaan</label>
                                                        <input type="text" class="form-control thaan" name="dey_sending_thaan[]" placeholder="Thaan">
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label class="font-weight-bold text-dark">Gzanah</label>
                                                        <input type="text" class="form-control gzanah" name="dey_sending_gzanah[]" placeholder="Gzanah">
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                        <label class="font-weight-bold text-dark">Quantity</label>
                                                        <input type="text" class="form-control quantity" name="dey_sending_quantity[]" value="0" placeholder="Quantity">
                                                    </div>

                                                    <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_remove3(this)">
                                                            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row m-0 p-0 my-4 justify-content-end">
                                                <div class="col-lg-1">
                                                    <div id="cutt_voucher_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_duplicateRow5()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-lg-2  text-right">
                                            <!-- <a target="_blank" href="print.php?production=<?= $ProductionID ?>&type=dyeing" id="showData3">
                                                <div class="btn btn-primary">
                                                    <i class="fa fa-print"></i> Print
                                                </div>
                                            </a> -->
                                            <input class="btn btn-success" type="submit" value="Save" name="dyeing_btn">
                                        </div>
                                    </div>
                                </form>

                                <table class="table mt-3">
                                    <thead class="thead">
                                        <tr>
                                            <th class="font-weight-bold text-dark">Sr.</th>
                                            <th class="font-weight-bold text-dark">Dyer Name</th>
                                            <th class="font-weight-bold text-dark">Total Quantity (Sent)</th>
                                            <th class="font-weight-bold text-dark">Location</th>
                                            <th class="font-weight-bold text-dark">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <tr>
                                            <td colspan="5" class="text-center">No Data Found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="receiving" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                <form action="" method="post">
                                    <input type="hidden" id="hiddenInput3" name="deyeing_id">
                                    <input type="hidden" value="recieved" name="deyeing_status">
                                    <input type="hidden" value="out" name="deyeing_in_out">
                                    <div class="row pb-2">
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="dyeing_date">Date</label>
                                            <input type="date" class="form-control" name="dyeing_date" id="dyeing_date" placeholder="Select Date">
                                        </div>
                                        <div class="col-lg-2 mt-3 d-flex">
                                            <div class="w-100">
                                                <label class="font-weight-bold text-dark" for="Party Name">Dyer Name</label>
                                                <select class="form-control searchableSelect" name="party_name_selector" id="party_name_selector" onchange="getBalance(this.value); getDyerData(this.value);">
                                                    <option value="">Select Dyer</option>
                                                    <?php
                                                    $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'dyeing' AND customer_status = 1");
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <option value="<?= $row['customer_id'] ?>">
                                                            <?= ucwords($row['customer_name']) ?> (<?= ucwords($row['customer_type']) ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group-prepend mt-4 ml-2">
                                                <span class="input-group-text mt-1" id="balance_text">Balance: <span id="balance_amount">0</span></span>
                                            </div>
                                            <input type="hidden" id="hidden_party_id">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                            <input type="text" class="form-control" name="dyeing_gate_no" id="dyeing_gate_no" placeholder="Gate pass no.">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="dyeing_lat_name">Lat no.</label>
                                            <input type="text" class="form-control" name="dyeing_lat_name" id="dyeing_lat_name" placeholder="Lat Number">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Party Voucher No.">Party Voucher No.</label>
                                            <input type="text" class="form-control" name="dyeing_party_voucher" id="dyeing_party_voucher" placeholder="Party Voucher No.">
                                        </div>
                                        <div class="col-lg-2 mt-3 pr-1">
                                            <label class="font-weight-bold text-dark" for="color">Color Name</label>
                                            <input type="text" class="form-control" name="dyeing_color_name" id="dyeing_color_name" placeholder="Name">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Location">Location</label>
                                            <input type="text" class="form-control" name="dyeing_location" id="dyeing_location" placeholder="Location">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark">Bill No.</label>
                                            <input type="number" min="0" placeholder="Bil No." autocomplete="off" class="form-control" name="dey_bill_no">
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark">Bilty No.</label>
                                            <input type="number" min="0" placeholder="Bilty No." autocomplete="off" class="form-control" name="dey_bilty_no">
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                            <textarea name="dyeing_remarks" id="dyeing_remarks" placeholder="Remarks" class="form-control"></textarea>
                                        </div>
                                        <div class="col-lg-2 mt-3">
                                            <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                            <input type="Date" class="form-control" name="dyeing_delivery_date" id="dyeing_delivery_date" placeholder="Location">
                                        </div>


                                    </div>


                                    <div class="row mt-5">
                                        <div class="col">
                                            <h4>
                                                List
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="deyingContainer">
                                        <div class="card px-5 py-3">


                                            <div id="dey4">
                                                <div class="row mt-3 m-0 p-0">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 row m-0 p-0">
                                                        <div class="col-12 m-0 p-0 pr-2">
                                                            <label class=" font-weight-bold text-dark" for="dey_recieving_product">Quality</label>

                                                            <select class="form-control" name="dey_recieving_product[]">
                                                                <option value="">Select Product</option>
                                                                <?php
                                                                $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                $product_ids2 = array();

                                                                while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                    $product_id2 = $rowdata2['product_id'];
                                                                    $product_ids2[] = $product_id;

                                                                    $purchase_data3 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id2");

                                                                    while ($rowdata3 = mysqli_fetch_array($purchase_data3)) {
                                                                        $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata3['brand_id']);
                                                                        $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata3['category_id']);
                                                                ?>


                                                                        <option data-price="<?= $rowdata3["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata3["product_id"] ?>">
                                                                            <?= ucwords($rowdata3["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                        </option>

                                                                <?php   }
                                                                } ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Thaan</label>
                                                        <input type="text" class="form-control thaan" name="dey_recieving_thaan[]" placeholder="Thaan">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Gzanah</label>
                                                        <input type="text" class="form-control gzanah" name="dey_recieving_gzanah[]" placeholder="Gzanah">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Quantity</label>
                                                        <input type="text" class="form-control quantity" name="dey_recieving_quantity[]" value="0" placeholder="Quanitity">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label class="font-weight-bold text-dark" for="C-P">C-P</label>
                                                        <input type="text" class="form-control" name="dyeing_cp[]" id="dyeing_cp" placeholder="C-P">
                                                    </div>


                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 d-flex align-items-end">
                                                        <div class="form-group mb-0">
                                                            <label class="font-weight-bold text-dark">Shortage</label>
                                                            <input type="text" class="form-control" id="deying_Shortage" name="deying_Shortage[]" placeholder="Shortage">
                                                        </div>
                                                        <div class="add_remove">
                                                            <button type="button" class=" outline_none border-0 bg-white" onclick="deying_voucher_remove4(this)">
                                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row m-0 p-0 my-4  justify-content-end">
                                                <div cs="col-lg-1">
                                                    <div id="cutt_voucher_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_duplicateRow4()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-lg-2  text-right">
                                            <!-- <a target="_blank" href="print.php?production=<?= $ProductionID ?>&type=dyeing" id="showData3">
                                                <div class="btn btn-primary">
                                                    <i class="fa fa-print"></i> Print
                                                </div>
                                            </a> -->
                                            <input class="btn btn-success" type="submit" value="Save" name="dyeing_btn">
                                        </div>
                                    </div>
                                </form>
                                <table class="table mt-3">
                                    <thead class="thead">
                                        <tr>
                                            <th class="font-weight-bold text-dark">Sr.</th>
                                            <th class="font-weight-bold text-dark">Dyer Name</th>
                                            <th class="font-weight-bold text-dark">Total Quantity (Received)</th>
                                            <th class="font-weight-bold text-dark">Location</th>
                                            <th class="font-weight-bold text-dark">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dyer_data_table_body">
                                        <td colspan="5" class="text-center">No Data Found</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include_once 'includes/foot.php';
?>

<script>
    $(document).ready(function() {

        function calculateQuantity($row) {
            var thaan = parseFloat($row.find('.thaan').val()) || 0;
            var gzanah = parseFloat($row.find('.gzanah').val()) || 0;
            var quantity = thaan * gzanah;
            $row.find('.quantity').val(quantity);
        }

        $(document).on('input', '.thaan, .gzanah', function() {
            var $row = $(this).closest('.row');
            calculateQuantity($row);
        });
    });
</script>
<script>
    $(document).ready(function() {
        function updateHash(tabId) {
            if (history.pushState) {
                history.pushState(null, null, tabId);
            } else {
                location.hash = tabId;
            }
        }

        var hash = window.location.hash;
        if (hash) {
            $('a[href="' + hash + '"]').tab('show');
        } else {
            $('a[href=" #sending"]').tab('show');
        }

        $('a[data-toggle="tab" ]').on('click', function(e) {
            var newHash = $(this).attr('href');
            updateHash(newHash);
        });

        $(window).on('hashchange', function() {
            var newHash = window.location.hash;
            if (newHash) {
                $('a[href="' + newHash + '" ]').tab('show');
            }
        });
    });
</script>