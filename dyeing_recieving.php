<?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing_recieving.php') { ?>
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
                                <b class="text-center card-text">Dyeing Recieving</b>

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
                            <div class="col-md-1 mt-3">
                                <label>Transaction #</label>
                                <input type="text" name="transaction" id="transaction" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Gate Pass #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="gate_pass">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>From Location</label>
                                <select class="form-control searchableSelect" name="from_location" id="from_location">
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'dyeing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"> <?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'printer'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'packing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'embroidery'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Issue To</label>
                                <select class="form-control searchableSelect" name="to_location" id="to_location">
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'dyeing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"> <?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'printer'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'packing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'embroidery'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Pandi</label>
                                <input type="text" placeholder="Pandi Here" value="" autocomplete="off" class="form-control" name="pandi" id="pandi">
                            </div>
                            <div class="col-md-1 mt-3">
                                <label>Bilty No.</label>
                                <input type="number" min="0" placeholder="Bilty No." value="" autocomplete="off" class="form-control" name="bilty_no" id="bilty_no">
                            </div>
                            <div class="col-12 mt-3">
                                <label>Remarks</label>
                                <textarea placeholder="Remarks Here" autocomplete="off" class="form-control" name="purchase_narration" id="" cols="30" rows="3"><?= @$fetchPurchase['purchase_narration'] ?></textarea>
                            </div>
                        </div> <!-- end of form-group -->

                        <div class="row m-0 ">
                            <div id="voucher_rows_container2">
                                <div class="voucher_row2">

                                    <div class="row mt-3 m-0 p-0">

                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-3 m-0 p-0 pl-1">
                                                <label>Sr</label>
                                                <input type="text" class="form-control thaan" readonly value="">
                                            </div>
                                            <div class="col-9 m-0 p-0 pl-1">
                                                <label for="cutting_from_product">Quality</label>
                                                <select class="form-control searchableSelect" name="cutting_from_product[]">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Type</label>
                                            <select class="form-control searchableSelect" name="pur_type" id="pur_type">
                                                <option disabled>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Unit</label>
                                            <input type="text" class="form-control thaan" name="unit[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Color</label>
                                            <input type="text" class="form-control thaan" name="color[]" placeholder="Color">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Thaan</label>
                                            <input type="text" class="form-control thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Pur Thaan</label>
                                            <input type="text" class="form-control thaan" name="pur_thaan[]" placeholder="Pur Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Qty</label>
                                            <input type="text" class="form-control quantity" name="qty[]" value="0" placeholder="qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Suit</label>
                                            <input type="text" class="form-control thaan" name="suit[]" placeholder="Suit">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Gzanah</label>
                                            <input type="text" class="form-control gzanah" name="gzanah[]" placeholder="Gzanah">
                                        </div>

                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <div class="form-group mb-0">
                                                <label>Lot No</label>
                                                <input type="text" class="form-control" id="lot_no" name="lot_no[]" placeholder="Lot No" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                            <button type="button" class="outline_none mt-4 border-0 bg-white" onclick="cutt_voucher_remove(this)">
                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                            </button>
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
                        <h3 class="text-center">Total: </h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 offset-6">

                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>

                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing_recieving.php') { ?>
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