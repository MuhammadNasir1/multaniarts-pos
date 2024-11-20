<?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing.php') { ?>
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
                                <b class="text-center card-text">Dyeing Issuance</b>

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
                                <select class="form-control searchableSelect" id="form_location" name="form_location" onchange="findPurchaseData(this.value)" aria-label="Username" aria-describedby="basic-addon1">
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
                                <label>Issue To</label>
                                <select class="form-control searchableSelect" id="to_location" name="to_location" onchange="findLocationType(this.value)" aria-label="Username" aria-describedby="basic-addon1">
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
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'dyeing.php') { ?>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
            <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->
            <!-- Button trigger modal -->


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#purchaseModal" id="purchaseModalBtn">
                Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered" id="purchaseDetailsTable">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Content will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>



    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    } ?>


<script>
    function findPurchaseData(value) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_purchase_data: value
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    // Clear previous table content
                    $("#purchaseDetailsTable tbody").empty();

                    // Add rows with key-value pairs
                    const fieldsToShow = [{
                            key: 'purchase_id',
                            label: 'Purchase ID'
                        },
                        {
                            key: 'purchase_date',
                            label: 'Purchase Date'
                        },
                        {
                            key: 'client_name',
                            label: 'Client Name'
                        },
                        {
                            key: 'client_contact',
                            label: 'Client Contact'
                        },
                        {
                            key: 'total_amount',
                            label: 'Total Amount'
                        },
                        {
                            key: 'discount',
                            label: 'Discount'
                        },
                        {
                            key: 'grand_total',
                            label: 'Grand Total'
                        },
                        {
                            key: 'paid',
                            label: 'Paid'
                        },
                        {
                            key: 'due',
                            label: 'Due'
                        }
                    ];

                    fieldsToShow.forEach(field => {
                        const value = data[field.key] || "N/A";
                        const row = `
                <tr>
                    <td>${field.label}</td>
                    <td>${value}</td>
                </tr>
            `;
                        $("#purchaseDetailsTable tbody").append(row);
                    });

                    // Open the modal
                    $("#purchaseModalBtn").click();
                }
            },

            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
</script>