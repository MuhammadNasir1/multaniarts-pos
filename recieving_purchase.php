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

                    <form action="php_action/custom_action.php" method="POST" id="myForm">
                        <input type="hidden" name="product_purchase_id">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">


                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Purchase ID#</label>
                                <input type="text" name="ec_purchase_id" placeholder="Enter Purchase ID" oninput="findPurchase(this.value)" id="next_increment" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>Purchase Date</label>
                                <input type="date" name="purchase_date" readonly id="purchase_date" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label>Select Supplier</label>
                                <div class="input-group">
                                    <select class="form-control searchableSelect" readonly name="cash_purchase_supplie" id="credit_order_client_name" required onchange="getBalance(this.value,'customer_account_exp')" aria-label="Username" aria-describedby="basic-addon1">
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
                            <!-- <div class="col-sm-1">
                                <br>
                                <a href="customers.php?type=supplier" class="btn btn-admin2 btn-sm mt-2">Add</a>
                            </div> -->
                            <div class="col-md-4">
                                <label>Location</label>
                                <!-- <input type="text" placeholder="Location  Here" value="<?= @$fetchPurchase['pur_location'] ?>" autocomplete="off" class="form-control" name="pur_location"> -->
                                <select class="form-control searchableSelect" readonly name="pur_location" id="pur_location">
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
                                <label class="text-dark" for="purchase_for">Purchase For</label>

                                <select class="form-control searchableSelect" readonly name="purchase_for" id="purchase_for">
                                    <option disabled>Select Type</option>
                                    <option value="shafoon">Shafoon</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Bill No.</label>
                                <input type="number" min="0" placeholder="Bil No." readonly autocomplete="off" class="form-control" name="bill_no" id="bill_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Gate Pass</label>
                                <input type="text" placeholder="Gate Pass" readonly autocomplete="off" class="form-control " name="gate_pass" id="gate_pass">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Bilty No.</label>
                                <input type="number" min="0" placeholder="Bilty No." readonly autocomplete="off" class="form-control" name="bilty_no" id="bilty_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Cargo</label>
                                <input type="text" placeholder="Cargo Here" readonly autocomplete="off" class="form-control" name="pur_cargo" id="pur_cargo">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Type</label>
                                <!-- <input type="text" placeholder="Type Here" value="<?= @$fetchPurchase['pur_type'] ?>" autocomplete="off" class="form-control " name="pur_type"> -->

                                <select class="form-control searchableSelect" readonly name="pur_type" id="pur_type">
                                    <option disabled>Select Type</option>
                                    <option value="meter">Meter</option>
                                    <option value="yard">Yard</option>
                                    <option value="others">Suit</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Remarks</label>
                                <textarea placeholder="Remarks Here" readonly autocomplete="off" class="form-control" name="purchase_narration" id="purchase_narration" cols="30" rows="3"></textarea>
                            </div>
                        </div> <!-- end of form-group -->
                        <table class="table saleTable" id="myDiv">
                            <thead class="table-bordered">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Thaan</th>
                                    <th>Gzanah</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="table table-bordered" id="purchase_product_tb">

                                <tr id="product_idN_<?= $r['product_id'] ?>">
                                    <input type="hidden" data-price="" data-quantity="<?= $r['quantity'] ?>" id="product_ids_" class="product_ids" name="product_ids[]" value="">
                                    <input type="hidden" id="product_quantites_" name="product_quantites[]" value="">
                                    <input type="hidden" id="product_rate_" name="product_rates[]" value="">
                                    <input type="hidden" id="product_totalrate_" name="product_totalrates[]" value="">
                                    <input type="hidden" id="pur_thaan_'" name="pur_thaan[]" value="">
                                    <!-- <input type="hidden" id="pur_thaan_" name="pur_thaan[]" value=""> -->
                                    <input type="hidden" id="pur_gzanah_" name="pur_gzanah[]" value="">
                                    <input type="hidden" id="pur_unit_" name="pur_unit[]" value="">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td> </td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <h2 class="text-center">DYED PRODUCED</h2>
                        <hr>
                        <input type="hidden" name="rec_purchase_id" id="rec_purchase_id">
                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label>Dyed Thaans</label>
                                <input type="number" min="0" placeholder="Dyed Thaans" autocomplete="off" class="form-control" name="dyed_thaans" id="dyed_thaans">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Color</label>
                                <input type="text" placeholder="Color" autocomplete="off" class="form-control " name="color" id="color">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Dyed Qty</label>
                                <input type="number" min="0" placeholder="Dyed Qty" autocomplete="off" class="form-control" name="dyed_qty" id="dyed_qty">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Cut Piece</label>
                                <input type="text" placeholder="Cut Piece" autocomplete="off" class="form-control" name="cut_piece" id="cut_piece">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Un-Setteld</label>
                                <input type="text" placeholder="Un-Setteld" autocomplete="off" class="form-control" name="un_settled" id="un_settled">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>To Location</label>
                                <!-- <input type="text" placeholder="Location  Here" value="<?= @$fetchPurchase['pur_location'] ?>" autocomplete="off" class="form-control" name="pur_location"> -->
                                <select class="form-control searchableSelect" name="to_location" id="to_location">
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
                            <div class="col-12 mt-3">
                                <label>Remarks</label>
                                <textarea placeholder="Remarks Here" autocomplete="off" class="form-control" name="to_remarks" id="to_remarks" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
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
                recieve_purc_id: value
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#purchase_date').val(response.data.purchase_date);
                    $('#rec_purchase_id').val(response.data.purchase_id);
                    $('#credit_order_client_name').val(response.data.client_name);
                    $('#purchase_for').val(response.data.purchase_for);
                    $('#bill_no').val(response.data.bill_no);
                    $('#gate_pass').val(response.data.gate_pass);
                    $('#bilty_no').val(response.data.bilty_no);
                    $('#pur_location').val(response.data.pur_location);
                    $('#pur_type').val(response.data.pur_type);
                    $('#pur_cargo').val(response.data.pur_cargo);
                    $('#purchase_narration').text(response.data.purchase_narration);

                    let itemsHtml = '';

                    if (response.items.length > 0) {
                        response.items.forEach(function(item) {
                            itemsHtml += `
                        <tr>
                            <input type="hidden" data-price="${item.rate}" data-quantity="${item.quantity}" class="product_ids" name="product_ids[]" value="${item.product_id}">
                            <input type="hidden" name="product_quantites[]" value="${item.quantity}">
                            <input type="hidden" name="product_rates[]" value="${item.rate}">
                            <input type="hidden" name="product_totalrates[]" value="${item.rate * item.quantity}">
                            <input type="hidden" name="pur_thaan[]" value="${item.pur_thaan}">
                            <input type="hidden" name="pur_gzanah[]" value="${item.pur_gzanah}">
                            <input type="hidden" name="pur_unit[]" value="${item.pur_unit}">
                            <td>${item.product_name}</td>
                            <td>${item.pur_thaan}</td>
                            <td>${item.pur_gzanah}</td>
                            <td>${item.pur_unit}</td>
                            <td>${item.rate}</td>
                            <td>${item.quantity}</td>
                            <td>${(item.rate * item.quantity).toFixed(2)}</td>
                        </tr>
                    `;
                        });
                    } else {
                        itemsHtml = `
                    <tr>
                        <td colspan="7" class="text-center">Data Not Found</td>
                    </tr>
                    `;
                    }

                    $('#purchase_product_tb').html(itemsHtml);
                } else {
                    $('#purchase_product_tb').html(`
                    <tr>
                        <td colspan="7" class="text-center">Data Not Found</td>
                    </tr>
                `);
                    $("#recieving_form").trigger('reset');
                    $("#purchase_narration").val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }

    $(document).ready(function() {
        if ($("#next_increment").val() == "") {
            $('#purchase_product_tb').html(`
            <tr>
                <td colspan="7" class="text-center">Data Not Found</td>
            </tr>
        `);
        }
    });

    $(document).ready(function() {
        $('#myForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'php_action/custom_action.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.sts === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.msg,
                            showConfirmButton: false,
                            timer: 2000
                        }).then((result) => {
                            location.reload();
                        });

                        $('#myForm')[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.msg,
                            showConfirmButton: true,
                        });
                    }
                },
                error: function() {
                    // Display an error alert if AJAX fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while submitting the form.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    });
</script>