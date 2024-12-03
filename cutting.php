<?php if (basename($_SERVER['REQUEST_URI']) == 'cutting.php') { ?>
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
                                <b class="text-center card-text">Main Cutting</b>

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
                            <div class="col-md-2 mt-3">
                                <label>Transaction #</label>
                                <input type="text" name="transaction" id="transaction" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3 row">
                                <div class="col-10">
                                    <label>Program</label>
                                    <select class="form-control searchableSelect" name="program" id="program">
                                        <option value="" disabled selected>Select Program</option>
                                        <?php
                                        $location = mysqli_query($dbc, "SELECT * FROM programs WHERE status = 1");
                                        while ($d = mysqli_fetch_assoc($location)) {
                                        ?>
                                            <option value="<?= $d['program_id'] ?>"> <?= ucwords($d['name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label class="invisible d-block">.</label>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_program_modal"> <i class="fa fa-plus"></i> </button>
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Suit #</label>
                                <input type="text" placeholder="Suit Here.." value="" autocomplete="off" class="form-control " name="suit" id="suit">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Cutting Man</label>
                                <select class="form-control searchableSelect" name="cutting_man" id="cutting_man">
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'shop'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?> ( <?= ucwords($d['customer_type']) ?> )</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Remarks #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="remarks" id="remarks">
                            </div>
                        </div> <!-- end of form-group -->
                        <hr>
                        <h3 class="text-center">Available Qty: </h3>
                        <hr>
                        <div class="row m-0 ">
                            <div id="voucher_rows_container2">
                                <div class="voucher_row2">

                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr" readonly value="">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control lat_no" id="lat_no" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no" name="d_lot_no[]" placeholder="D Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type">
                                                <option disabled selected>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="thaan">Thaan</label>
                                            <input type="text" class="form-control" id="thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_thaan">Qty/Thaan</label>
                                            <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]" placeholder="Qty/Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
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

                                    </div>
                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr" readonly value="">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control lat_no" id="lat_no" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no" name="d_lot_no[]" placeholder="D Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type">
                                                <option disabled selected>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="thaan">Thaan</label>
                                            <input type="text" class="form-control" id="thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_thaan">Qty/Thaan</label>
                                            <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]" placeholder="Qty/Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
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

                                    </div>
                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr" readonly value="">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control lat_no" id="lat_no" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no" name="d_lot_no[]" placeholder="D Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type">
                                                <option disabled selected>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="thaan">Thaan</label>
                                            <input type="text" class="form-control" id="thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_thaan">Qty/Thaan</label>
                                            <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]" placeholder="Qty/Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
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

                                    </div>
                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr" readonly value="">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control lat_no" id="lat_no" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no" name="d_lot_no[]" placeholder="D Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type">
                                                <option disabled selected>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="thaan">Thaan</label>
                                            <input type="text" class="form-control" id="thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_thaan">Qty/Thaan</label>
                                            <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]" placeholder="Qty/Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
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

                                    </div>
                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0 pl-1 row">
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr" readonly value="">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control lat_no" id="lat_no" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no" name="d_lot_no[]" placeholder="D Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type">
                                                <option disabled selected>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="thaan">Thaan</label>
                                            <input type="text" class="form-control" id="thaan" name="thaan[]" placeholder="Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="pur_thaan">Qty/Thaan</label>
                                            <input type="text" class="form-control" id="pur_thaan" name="pur_thaan[]" placeholder="Qty/Thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="qty">Qty</label>
                                            <input type="text" class="form-control" id="qty" name="qty[]" value="0" placeholder="Qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
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

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="row m-0 p-0 my-4 justify-content-end">
                            <div class="col-lg-1">
                                <div id="cutt_voucher_btn">
                                    <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_duplicateRow()">
                                        <img src="img/add.png" width="30px" alt="add sign">
                                    </button>
                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm-6 offset-6">

                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>

                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'cutting.php') { ?>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
            <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->
            <!-- Button trigger modal -->

            <div class="col-2">
                <label class="invisible d-block">.</label>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" id="show_dyeing_details_btn" data-target="#show_dyeing_details"> <i class="fa fa-plus"></i> </button>
            </div>

            <div class="modal fade" id="show_dyeing_details" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Purchase Details</h5>
                            <input type="text" id="tableSearchInput" class="form-control ml-3" placeholder="Search Here" style="width: 50%;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="detailModalClose">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="modal-body">
                            <table class="table table-bordered" id="purchaseDetailsTable">
                                <thead>
                                    <tr>
                                        <th>Purchase ID</th>
                                        <th>Purchase Date</th>
                                        <th>Product</th>
                                        <th>Thaan</th>
                                        <th>Gzanah</th>
                                        <th>Quantity</th>
                                        <th>Grand Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $query = mysqli_query($dbc, "SELECT * FROM dyeing WHERE status = 'received' AND and ")
                                    ?>
                                    <h1>Hello World!</h1>
                                    <?php

                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer"></div>

                    </div>
                </div>
            </div>
    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    } ?>

<script>
    $(document).ready(function() {
        // Attach an input event listener to all elements with class 'lat_no'
        $(document).on('focus', '.lat_no', function() {
            // Logic to open the modal
            $('#show_dyeing_details_btn').click(); // Replace 'yourModalId' with the actual ID of your modal

            // Optional: Store which field triggered the modal
            let triggeredField = $(this);

            // Example: You can perform operations using 'triggeredField'
            console.log(triggeredField.val());
        });
    });
    $(document).ready(function() {
        $('#tableSearchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#purchaseDetailsTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>