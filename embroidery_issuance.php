<?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_issuance.php') { ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include_once 'includes/head.php';

    if (!empty($_REQUEST['edit_purchase_id'])) {
        # code...
        $fetchPurchase = fetchRecord($dbc, "purchase", "purchase_id", base64_decode($_REQUEST['edit_purchase_id']));
    }
    ?>

    <body class="horizontal light">
        <div class="wrapper">
            <?php include_once 'includes/header.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Embroidery Issuance</b>
                                <a href="credit_purchase.php" class="btn btn-admin float-right btn-sm">Add New</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php } ?>

                    <form action="php_action/custom_action.php" method="POST" id="sale_order_fm">
                        <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">


                        <div class="row form-group">
                            <div class="col-md-2  mt-3">
                                <label>Transaction #</label>
                                <input type="text" name="transaction" id="transaction" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="emb_type">Emb Type</label>
                                <select class="form-control searchableSelect" name="emb_type[]" id="emb_type">
                                    <option disabled selected>Select Type</option>
                                    <option value="meter">Meter</option>
                                    <option value="yard">Yard</option>
                                    <option value="others">Suit</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="location">Location</label>
                                <select class="form-control searchableSelect" name="location[]" id="location">
                                    <option disabled selected>Select Location</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="embroidery">Embroidery</label>
                                <select class="form-control searchableSelect" name="embroidery[]" id="embroidery">
                                    <option disabled selected>Select Embroidery</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="program">Program</label>
                                <select class="form-control searchableSelect" name="program[]" id="program">
                                    <option disabled selected>Select Program</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Lot No</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="lot_no" id="lot_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Dyeing Lot</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="dyeing_lot" id="dyeing_lot">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="quality">Quality</label>
                                <select class="form-control searchableSelect" name="quality[]" id="quality">
                                    <option disabled selected>Select Quality</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2  mt-3">
                                <label>Manual Gp #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="manual_gp" id="manual_gp">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="cutting_man">Cutting Man</label>
                                <select class="form-control searchableSelect" name="cutting_man[]" id="cutting_man">
                                    <option disabled selected>Select Man</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="sending_person">Sending Person</label>
                                <select class="form-control searchableSelect" name="sending_person[]" id="sending_person">
                                    <option disabled selected>Select Man</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="carrier_person">Carrier Person</label>
                                <select class="form-control searchableSelect" name="carrier_person[]" id="carrier_person">
                                    <option disabled selected>Select Man</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('dyeing', 'printer', 'packing', 'embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2  mt-3">
                                <label>Carrier Contact</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="carrier_contact" id="carrier_contact">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Remarks #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="remarks" id="remarks">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-3 mt-3">
                        <div id="voucher_rows_container2">
                            <div class="voucher_row2">

                                <div class="row mt-3 m-0 p-0">
                                    <div class="col-lg-2 m-0 p-0 pl-1 row">
                                        <label for="sr">Sr</label>
                                        <input type="text" class="form-control" id="sr" readonly value="">
                                    </div>
                                    <div class="col-lg-2 m-0 p-0 pl-1">
                                        <label for="pur_type">Unit</label>
                                        <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                            <option disabled selected>Select Unit</option>
                                            <option value="meter">Meter</option>
                                            <option value="yard">Yard</option>
                                            <option value="others">Suit</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 m-0 p-0 pl-1">
                                        <label for="type">Type</label>
                                        <select class="form-control searchableSelect" name="type[]" id="type">
                                            <option disabled selected>Select Type</option>
                                            <option value="meter">Meter</option>
                                            <option value="yard">Yard</option>
                                            <option value="others">Suit</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 m-0 p-0 pl-1 row">
                                        <label for="thaan">Thaan</label>
                                        <input type="text" class="form-control" id="thaan" name="thaan[]">
                                    </div>
                                    <div class="col-lg-2 m-0 p-0 pl-1">
                                        <label for="pur_thaan">Qty/Thaan</label>
                                        <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]">
                                    </div>
                                    <div class="col-lg-2 m-0 p-0 pl-3 row">
                                        <div class="col-lg-8 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-4 add_remove">
                                            <button type="button" class="outline_none mt-4 border-0 bg-white" onclick="cutt_voucher_remove(this)">
                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="Remove">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0 my-4 justify-content-end">
                        <div class="col-lg-1">
                            <div id="cutt_voucher_btn">
                                <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_duplicateRow()">
                                    <img src="img/add.png" width="30px" alt="add sign">
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3 class="text-center">Total:</h3>
                    <hr>

                    <div class="row">
                        <div class="col-sm-6 offset-6">
                            <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>
                        </div>
                    </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_issuance.php') { ?>
                </div>
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
        <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->
        <!-- Button trigger modal -->




    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    } ?>