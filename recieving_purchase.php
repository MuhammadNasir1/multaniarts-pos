<?php if (basename($_SERVER['REQUEST_URI']) == 'recieving_purchase.php') { ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include_once 'includes/head.php';
    ?>

    <body class="horizontal light">
        <div class="wrapper">
            <?php include_once 'includes/header.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Recieving Purchase</b>

                                <a href="credit_purchase.php" class="btn btn-admin float-right btn-sm">Add New</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php } ?>

                    <form action="php_action/custom_action.php" method="POST" id="recieving_form">
                        <input type="hidden" name="product_purchase_id" >
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">


                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Purchase ID#</label>
                                <?php $result = mysqli_query($dbc, "
    SHOW TABLE STATUS LIKE 'purchase'
");
                                $data = mysqli_fetch_assoc($result);
                                $next_increment = $data['Auto_increment']; ?>
                                <input type="text" name="next_increment" oninput="findPurchase(this.value)" id="next_increment" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label>Select Supplier</label>
                                <div class="input-group">
                                    <select class="form-control searchableSelect" name="cash_purchase_supplier" id="credit_order_client_name" required onchange="getBalance(this.value,'customer_account_exp')" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Select Supplier</option>
                                        <?php
                                        $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type='supplier'");
                                        while ($r = mysqli_fetch_assoc($q)) {
                                        ?>
                                            <option data-id="<?= $r['customer_id'] ?>" data-contact="<?= $r['customer_phone'] ?>" value="<?= $r['customer_name'] ?>"><?= $r['customer_name'] ?></option>
                                        <?php   } ?>
                                    </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Balance : <span id="customer_account_exp">0</span> </span>
                                    </div>
                                </div>
                                <input type="hidden" name="customer_account" id="customer_account" value="<?= @$fetchPurchase['customer_account'] ?>">
                                <input type="hidden" name="client_contact" id="client_contact" value="<?= @$fetchPurchase['client_contact'] ?>">

                            </div>
                            <div class="col-sm-1">
                                <br>
                                <a href="customers.php?type=supplier" class="btn btn-admin2 btn-sm mt-2">Add</a>
                            </div>
                            <div class="col-md-3">
                                <label class="text-dark" for="purchase_for">Purchase For</label>

                                <select class="form-control searchableSelect" name="purchase_for" id="purchase_for">
                                    <option disabled>Select Type</option>
                                    <option value="shafoon">Shafoon</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Bill No.</label>
                                <input type="number" min="0" placeholder="Bil No." autocomplete="off" class="form-control" name="bill_no" id="bill_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Gate Pass</label>
                                <input type="text" placeholder="Gate Pass" autocomplete="off" class="form-control " name="gate_pass" id="gate_pass">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Bilty No.</label>
                                <input type="number" min="0" placeholder="Bilty No." autocomplete="off" class="form-control" name="bilty_no" id="bilty_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Location</label>
                                <!-- <input type="text" placeholder="Location Here" value="<?= @$fetchPurchase['pur_location'] ?>" autocomplete="off" class="form-control" name="pur_location"> -->
                                <select class="form-control searchableSelect" name="pur_location" id="pur_location">
                                    <option disabled selected>
                                        <h3>Deyeing</h3>
                                    </option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'dyeing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"> <?= ucwords($d['customer_name']) ?></option>
                                    <?php } ?>
                                    <option disabled>
                                        <h3>Printing</h3>
                                    </option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'printer'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?></option>
                                    <?php } ?>
                                    <option disabled>
                                        <h3>Stiching & Packing</h3>
                                    </option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'packing'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?></option>
                                    <?php } ?>
                                    <option disabled>
                                        <h3>Embroidery</h3>
                                    </option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'embroidery'");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['customer_id'] ?>"><?= ucwords($d['customer_name']) ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Cargo</label>
                                <input type="text" placeholder="Cargo Here" autocomplete="off" class="form-control" name="pur_cargo" id="pur_cargo">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Type</label>
                                <!-- <input type="text" placeholder="Type Here" value="<?= @$fetchPurchase['pur_type'] ?>" autocomplete="off" class="form-control " name="pur_type"> -->

                                <select class="form-control searchableSelect" name="pur_type" id="pur_type">
                                    <option disabled>Select Type</option>
                                    <option value="meter">Meter</option>
                                    <option value="yard">Yard</option>
                                    <option value="others">Suit</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Remarks</label>
                                <textarea placeholder="Remarks Here" autocomplete="off" class="form-control" name="purchase_narration" id="purchase_narration" cols="30" rows="3"></textarea>
                            </div>
                        </div> <!-- end of form-group -->


                        <div class="row">
                            <div class="col-sm-6 offset-6">

                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Recieve and Print</button>

                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'recieving_purchase.php') { ?>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function findPurchase(value) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                purc_id: value
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log(response.data);
                    $('#purchase_date').val(response.data.purchase_date);
                    $('#credit_order_client_name').val(response.data.client_name);
                    $('#purchase_for').val(response.data.purchase_for);
                    $('#bill_no').val(response.data.bill_no);
                    $('#gate_pass').val(response.data.gate_pass);
                    $('#bilty_no').val(response.data.bilty_no);
                    $('#pur_location').val(response.data.pur_location);
                    $('#pur_type').val(response.data.pur_type);
                    $('#pur_cargo').val(response.data.pur_cargo);
                    $('#purchase_narration').text(response.data.purchase_narration);
                } else {
                    console.log("No data found for this ID.");
                    $("#recieving_form").trigger('reset');
                    $("#purchase_narration").val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
</script>