<?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing.php') { ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include_once 'includes/head.php';

    if (!empty($_REQUEST['edit_purchase_id'])) {
        # code...
        $fetchPurchase = fetchRecord($dbc, "purchase", "purchase_id", base64_decode($_REQUEST['edit_purchase_id']));
    }
    ?>
    <style>
        #purchaseModal .modal-dialog {
            max-width: fit-content;
            width: auto;
            margin: auto;
        }
    </style>

    <body class="horizontal light">
        <div class="wrapper">
            <?php include_once 'includes/header.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Dyeing Issuance</b>

                                <a href="credit_purchase.php" class="btn btn-admin float-right btn-sm">Add New</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php } ?>

                    <form action="php_action/custom_action.php" method="POST" id="dyeing_issuance">
                        <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">
                        <input type="hidden" name="dyeing_issuance_form" value="dyeing_issuance_from">
                        <input type="hidden" name="dyeing_issuance_purchase" id="dyeing_issuance_purchase">


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
                                <select class="form-control searchableSelect" id="form_location" name="from_location" onchange="findPurchaseData(this.value)" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Select Account</option>


                                    <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1 AND (customer_type = 'dyeing' OR customer_type = 'shop' OR customer_type = 'shop' OR customer_type = 'packing' OR customer_type = 'printer') ORDER BY customer_type ASC;");
                                    $type2 = '';
                                    while ($r = mysqli_fetch_assoc($q)):
                                        $type = $r['customer_type'];
                                    ?>
                                        <?php if ($type != $type2): ?>
                                            <optgroup label="<?= $r['customer_type'] ?>">
                                            <?php endif ?>

                                            <option <?= @($voucher['customer_id2'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                            <?php if ($type != $type2): ?>
                                            </optgroup>
                                        <?php endif ?>
                                    <?php $type2 = $r['customer_type'];
                                    endwhile; ?>
                                </select>
                                <input type="hidden" name="location_type" id="get_location_type">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Issue To</label>
                                <select class="form-control searchableSelect" id="to_location" name="to_location">
                                    <option value="">Select Account</option>


                                    <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1 AND customer_type = 'dyeing' ORDER BY customer_type ASC;");
                                    $type2 = '';
                                    while ($r = mysqli_fetch_assoc($q)):
                                        $type = $r['customer_type'];
                                    ?>
                                        <?php if ($type != $type2): ?>
                                            <optgroup label="<?= $r['customer_type'] ?>">
                                            <?php endif ?>

                                            <option <?= @($voucher['customer_id2'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                            <?php if ($type != $type2): ?>
                                            </optgroup>
                                        <?php endif ?>
                                    <?php $type2 = $r['customer_type'];
                                    endwhile; ?>


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
                                            <div class="col-2 m-0 p-0 pl-1">
                                                <label>Sr</label>
                                                <input type="text" class="form-control thaan" readonly value="">
                                            </div>
                                            <div class="col-10  m-0 p-0 pl-1">
                                                <label for="showProduct">Quality</label>
                                                <div class="input-group">
                                                    <select class="form-control searchableSelect" disabled name="from_product[]" id="showProduct" onchange="getStock(this.value)">
                                                        <option value="">Select Product</option>

                                                        <?php
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>

                                                            <option data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                                <?= $row["product_name"] ?> (<?= @$getCat["categories_name"] ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Stock :<span id="from_account_bl">0</span> </span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="product_id" id="product_id">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Type</label>
                                            <select class="form-control searchableSelect" name="pur_type_arr[]" id="pur_type_arr">
                                                <option disabled>Select Type</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                            <input type="hidden" name="pur_type" id="pur_type">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Unit</label>
                                            <input type="text" class="form-control thaan" name="unit_arr[]" placeholder="Thaan" id="unit_arr">
                                            <input type="hidden" name="unit" id="unit">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Color</label>
                                            <input type="text" class="form-control thaan" name="color_arr[]" placeholder="Color">
                                            <input type="hidden" name="color" id="product_id">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Thaan</label>
                                            <input type="text" class="form-control thaan" name="thaan_arr[]" placeholder="Thaan" id="thaan_arr">
                                            <input type="hidden" name="thaan" id="thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Pur Thaan</label>
                                            <input type="text" class="form-control thaan" name="pur_thaan_arr[]" placeholder="Pur Thaan">
                                            <input type="hidden" name="pur_thaan" id="pur_thaan">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Qty</label>
                                            <input type="number" class="form-control quantity" name="qty_arr[]" value="0" placeholder="qty" id="qty_arr">
                                            <input type="hidden" name="qty" id="qty">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Suit</label>
                                            <input type="text" class="form-control thaan" name="suit_arr[]" placeholder="Suit">
                                            <input type="hidden" name="suit" id="suit">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label>Gzanah</label>
                                            <input type="text" class="form-control gzanah" name="gzanah_arr[]" placeholder="Gzanah" id="gzanah_arr">
                                            <input type="hidden" name="gzanah" id="gzanah">
                                        </div>

                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <div class="form-group mb-0">
                                                <label>Lot No</label>
                                                <input type="text" class="form-control" id="lot_no" name="lot_no_arr[]" placeholder="Lot No" required>
                                                <input type="hidden" name="lot_no" id="lot_no">
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
                        <div class="row">
                            <div class="col-6 text-center">
                                <h3 class="text-center">Rate: <span id="rate"></span></h3>
                                <input type="hidden" name="rate" id="rateInput">
                            </div>
                            <div class="col-6 text-center">
                                <h3 class="text-center">Total: <span id="total_amount"></span></h3>
                                <input type="hidden" name="total_amount" id="totalAmountInput">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 offset-6">

                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>

                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing.php') { ?>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
            <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->


            <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#purchaseModal" id="purchaseModalBtn">
                Launch demo modal
            </button>

            <div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <script src="./js/custom.js"></script>
    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    } ?>


<script>
    function findPurchaseData(value) {
        findLocationType(value);
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_purchase_data: value
            },
            dataType: 'json',

            success: function(response) {
                const tbody = $("#purchaseDetailsTable tbody");
                tbody.empty();

                if (response.success) {
                    const data = response.data;

                    if (data.length > 0) {
                        let rowsHTML = "";

                        data.forEach(row => {
                            rowsHTML += `
                        <tr>
                            <td>${row.purchase_id || ""}</td>
                            <td>${row.purchase_date || ""}</td>
                            <td>${row.product_name || ""}</td>
                            <td>${row.pur_thaan || ""}</td>
                            <td>${row.pur_gzanah || ""}</td>
                            <td>${row.quantity || ""}</td>
                            <td>${row.grand_total || ""}</td>
                            <td>${row.paid || ""}</td>
                            <td>${row.due || ""}</td>
                            <td> 
                                <button type="button" class="btn btn-primary btn-sm" 
                                    name="selected_purchase_id" 
                                    id="selected_purchase_id" 
                                    value="${row.purchase_id || ""}" 
                                    onclick="getPurchase(this.value)">Apply</button>
                            </td>
                        </tr>
                        `;
                        });

                        tbody.append(rowsHTML);
                    } else {
                        tbody.html(`
                        <tr>
                            <td class="text-center" colspan="10">No Data Found</td>
                        </tr>
                    `);
                    }

                    $("#purchaseModalBtn").click();
                } else {
                    tbody.html(`
                    <tr>
                    <td class="text-center" colspan="10">Data Not Found</td>
                    </tr>
                    `);
                    $("#purchaseModalBtn").click();
                }
            },

            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " " + error);
                $("#purchaseDetailsTable tbody").html(`
                <tr>
                    <td class="text-center text-danger" colspan="10">Error fetching data</td>
                </tr>
            `);
            }
        });
    }

    $(document).ready(function() {
        $('#tableSearchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#purchaseDetailsTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
    $(document).ready(function() {
        // Listen for input events on all main inputs inside the row
        $('.row').on('input change', 'input, select', function() {
            // Get the value of the main input
            let mainValue = $(this).val();

            // Find the hidden input field associated with the current main input
            let hiddenInput = $(this).siblings('input[type="hidden"]');

            // Set the value of the hidden input
            hiddenInput.val(mainValue);
        });
    });

    $(document).ready(function() {
        function calculateTotal() {
            let rate = parseFloat($('#rateInput').val());

            let quantity = parseFloat($('#qty_arr').val());

            let total = rate * (quantity || 0);

            $('#total_amount').text(total.toFixed(2));
            $('#totalAmountInput').val(total.toFixed(2));
        }

        $('#total_amount').text(0);
        $('#totalAmountInput').val(0);
        $('#qty_arr').on('input', calculateTotal);
    });

    function getPurchase(purchaseId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_purchase: purchaseId
            },
            dataType: 'json',

            success: function(response) {
                if (response.success) {
                    $("#dyeing_issuance_purchase").val(purchaseId);

                    const product = response.product;
                    $('#showProduct').val(''); // Clear any pre-selected value

                    const productId = response.product.product_id;

                    $('#showProduct').removeAttr("disabled");
                    $('#showProduct').val(productId).change();
                    $("#unit_arr").val(response.data.pur_type)
                    $("#unit").val(response.data.pur_type)
                    $("#thaan_arr").val(response.data.pur_thaan)
                    $("#thaan").val(response.data.pur_thaan)
                    $("#qty_arr").val(response.data.quantity)
                    $("#qty").val(response.data.quantity)
                    $("#pur_type_arr").val(response.data.pur_type)
                    $("#pur_type").val(response.data.pur_type)
                    $("#gzanah_arr").val(response.data.pur_gzanah)
                    $("#gzanah").val(response.data.pur_gzanah)
                    $("#rate").text(response.data.pur_rate)
                    $("#rateInput").val(response.data.pur_rate)
                    $("#total_amount").text(response.data.pur_rate * response.data.quantity);
                    $("#totalAmountInput").val(response.data.pur_rate * response.data.quantity);

                    $("#detailModalClose").click();
                }
            },

            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
    $(document).ready(function() {
        $('#dyeing_issuance').on('submit', function(event) {
            event.preventDefault();
            let get_location = $("get_location_type").val();

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
                            timer: 12000
                        }).then((result) => {
                            location.reload();
                        });

                        $('#dyeing_issuance')[0].reset();
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

    function findLocationType(value) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                location_type_get: value
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $("#get_location_type").val(response.data.customer_type);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
</script>