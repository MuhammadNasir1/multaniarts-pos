<?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_recieving.php') { ?>
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
                                <b class="text-center card-text">Embroidery Recieving</b>

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
                                <label>Party GP #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="party_gp" id="party_gp">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="emb_type">Emb Type</label>
                                <select class="form-control searchableSelect" name="emb_type" id="emb_type">
                                    <option disabled selected>Select Type</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="program">Program</label>
                                <select class="form-control searchableSelect" name="program" id="program">
                                    <option disabled selected>Select Program</option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM programs WHERE status = 1");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['program_id'] ?>"> <?= ucwords($d['name']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="location">Embroidery Location</label>
                                <select class="form-control searchableSelect" name="location" id="location" onchange="getTableData(this.value)">
                                    <option disabled selected>Select Embroidery</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('shop')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="to_location">Issue To</label>
                                <select class="form-control searchableSelect" name="to_location" id="to_location">
                                    <option disabled selected>Select Location</option>
                                    <?php
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('embroidery')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Manual GP #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="maual_gp" id="maual_gp">
                            </div>
                            <div class="col-2 mt-3">
                                <label>Color</label>
                                <input type="date" name="color" id="color" value="" class="form-control">
                            </div>
                            <div class="col-2 mt-3">
                                <label>Lot No #</label>
                                <input type="text" placeholder="Lot No" value="" autocomplete="off" class="form-control " name="lat_no" id="lat_no">
                            </div>
                            <div class="col-2 mt-3">
                                <label>D Lot No #</label>
                                <input type="text" placeholder="D Lot No" value="" autocomplete="off" class="form-control " name="d_lat_no" id="d_lat_no">
                            </div>
                            <div class="col-2 mt-3">
                                <label>Manual Lot</label>
                                <input type="text" placeholder="Manual Lot" value="" autocomplete="off" class="form-control " name="manual_lot" id="manual_lot">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Remarks #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="remarks" id="remarks">
                            </div>
                        </div>
                        <hr>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                        ?>
                            <div class="row m-0 mt-3 complete px-1" id="row<?= $i ?>">
                                <div id="voucher_rows_container2">
                                    <div class="voucher_row2" id="row<?= $i ?>">
                                        <div class="row mt-3 m-0 p-0">
                                            <div class="col-lg-1 m-0 p-0  row">
                                                <div class="col-lg-3 m-0 p-0 ">
                                                    <label for="sr">Sr</label>
                                                    <input type="text" class="form-control" id="sr<?= $i ?>" readonly value="<?= $i ?>">
                                                </div>
                                                <div class="col-lg-9 m-0 mt-1 p-0 pl-3">
                                                    <button type="button" class="btn select_dyeing  mt-4 btn-primary btn-sm"
                                                        name="select_dyeing"
                                                        id="select_dyeing"> Select Dyeing </button>
                                                </div>

                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="pur_type">Unit</label>
                                                <select class="form-control searchableSelect" name="pur_type[]" id="pur_type<?= $i ?>">
                                                    <option disabled selected>Select Unit</option>
                                                    <option value="meter">Meter</option>
                                                    <option value="yard">Yard</option>
                                                    <option value="others">Suit</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 m-0 p-0 pl-1">
                                                <label for="type">Product</label>
                                                <div class="input-group">
                                                    <select class="form-control searchableSelect" name="from_type[]" id="from_type<?= $i ?>" onchange="getStock(this.value, <?= $i ?>)">
                                                        <option disabled selected>Select Type</option>
                                                        <?php
                                                        $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'cora_cutted' OR brand_id = 'dyed_cutted' AND status = 1");
                                                        while ($p = mysqli_fetch_assoc($products)) {
                                                        ?>
                                                            <option value="<?= $p['product_id'] ?>"><?= ucwords($p['product_name']) ?> (<?= ucwords($p['brand_id']) ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1<?= $i ?>">Stock :<span id="from_product_bl<?= $i ?>">0</span> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="type">Type</label>
                                                <select class="form-control searchableSelect" name="type[]" id="type<?= $i ?>">
                                                    <option disabled selected>Select Type</option>
                                                    <?php
                                                    $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'cora_cutted' OR brand_id = 'dyed_cutted' AND status = 1");
                                                    while ($p = mysqli_fetch_assoc($products)) {
                                                    ?>
                                                        <option value="<?= $p['product_id'] ?>"><?= ucwords($p['product_name']) ?> (<?= ucwords($p['brand_id']) ?>)</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 m-0 p-0 pl-1 row">
                                                <div class="col-lg-4 m-0 p-0 pl-1">
                                                    <label for="thaan">Thaan</label>
                                                    <input type="text" class="form-control" id="thaan<?= $i ?>" name="thaan[]" placeholder="Thaan">
                                                </div>
                                                <div class="col-lg-4 m-0 p-0 pl-1">
                                                    <label for="pur_thaan">Qty/Thaan</label>
                                                    <input type="text" class="form-control" id="pur_thaan<?= $i ?>" name="pur_thaan[]" placeholder="Qty/Thaan">
                                                </div>
                                                <div class="col-lg-4 m-0 p-0 pl-1 row">
                                                    <label for="qty">Qty</label>
                                                    <input type="number" class="form-control" id="qty<?= $i ?>" name="qty[]" placeholder="Qty">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 m-0 p-0 pl-1 row">
                                                <div class="col-lg-4 m-0 p-0 pl-1">
                                                    <label for="design">Design</label>
                                                    <input type="text" class="form-control" id="design<?= $i ?>" name="design[]" placeholder="Design">
                                                </div>
                                                <div class="col-lg-4 m-0 p-0 pl-1">
                                                    <label for="calender">Calender</label>
                                                    <input type="text" class="form-control" id="calender<?= $i ?>" name="calender[]">
                                                </div>
                                                <div class="col-lg-4 m-0 p-0 pl-1 row">
                                                    <label for="rate">Rate</label>
                                                    <input type="number" class="form-control" id="rate<?= $i ?>" name="rate[]" placeholder="Rate">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="calender_unit">Calender Unit</label>
                                                <select class="form-control searchableSelect" name="calender_unit[]" id="calender_unit<?= $i ?>">
                                                    <option disabled selected>Select Unit</option>
                                                    <option value="meter">Meter</option>
                                                    <option value="yard">Yard</option>
                                                    <option value="others">Suit</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 m-0 p-0 pl-1 row">
                                                <div class="col-lg-6 m-0 p-0 pl-1">
                                                    <label for="value">Value</label>
                                                    <input type="text" class="form-control" id="value<?= $i ?>" name="value[]" placeholder="Value">
                                                </div>
                                                <div class="col-lg-6 m-0 p-0 pl-1">
                                                    <label for="recv_suit">Recv Suit</label>
                                                    <input type="text" class="form-control" id="recv_suit<?= $i ?>" name="recv_suit[]">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <hr>


                        <div class="row mt-3">
                            <div class="col-sm-6 offset-6">
                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>
                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_recieving.php') { ?>
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