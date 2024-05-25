<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);

if (!empty($_REQUEST['QuotationID']) && isset($_REQUEST['QuotationID'])) {

    $quotationId = base64_decode($_REQUEST['QuotationID']);

    $dataQuot = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `quotations`"));

    // print_r($dataQuot);
}

$currentDate = new DateTime();
$currentDate->modify('+10 days');
$formattedDate = $currentDate->format('Y-m-d');
?>
<style type="text/css">
    .badge {
        font-size: 15px;
    }

    .add_remove {
        margin-top: 30px;
    }

    .outline_none:focus {
        outline: none !important;
    }

    #inv_btn:hover {
        color: #fff;
        background-color: #12678b;
    }
</style>

<body class="horizontal light  ">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">
                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Create Quotation</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="add_Quotation_fm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="quotation_edit_id" value="<?= @$quotationId ?>">
                            <div class="form-group row">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Quotation Date</label>
                                    <input type="date" class="form-control" id="quotation_date" placeholder="Enter Phone Number" name="quotation_date" value="<?= !empty(@$dataQuot['cust_date']) ? @$dataQuot['cust_date'] : date('Y-m-d') ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Quotation Due Date</label>
                                    <input type="date" class="form-control" id="quotation_due_date" placeholder="Enter Phone Number" name="quotation_due_date" value="<?= !empty(@$dataQuot['cust_due_date']) ? @$dataQuot['cust_due_date'] : @$formattedDate ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Customer Name</label>
                                    <input type="text" class="form-control" id="cust_name" placeholder="Enter Name" name="cust_name" required value="<?= @$dataQuot['cust_name'] ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Customer Phone</label>
                                    <input type="text" oninput="onlyNumberInput(event)" class="form-control" id="Customer_no" placeholder="Enter Phone Number" name="Customer_no" required value="<?= @$dataQuot['cust_phone'] ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Customer Email</label>
                                    <input type="email" class="form-control" id="cust_email" placeholder="Enter Email" name="cust_email" value="<?= @$dataQuot['cust_email'] ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="">Customer Address</label>
                                    <input type="text" class="form-control" id="cust_address" placeholder="Enter Address" name="cust_address" required value="<?= @$dataQuot['cust_address'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12 mb-3 mb-sm-0">
                                    <label for="">Note</label>
                                    <textarea name="cust_note" id="cust_note" class="form-control" rows="2" placeholder="Enter Note"><?= @$dataQuot['note'] ?></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3 mb-sm-0">
                                    <label for="">Description</label>
                                    <textarea name="cust_description" id="cust_description" class="form-control" rows="2" placeholder="Enter Description"><?= @$dataQuot['description'] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12 mb-3 mb-sm-0">
                                    <h3>
                                        Quotation Items
                                    </h3>
                                </div>
                            </div>

                            <div id="container">
                                <?php
                                if (!empty($_REQUEST['QuotationID']) && isset($_REQUEST['QuotationID'])) {
                                    $query = mysqli_query($dbc, "SELECT * FROM `quotation_items` WHERE `quotation_id` = $quotationId ");
                                    if (mysqli_num_rows($query) == 0) {
                                ?>
                                        <div class="row mt-2">
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Select Product</label>
                                                    <input type="hidden" name="quotation_prod_id[]" value="<?= @$items['quotation_prod_id'] ?>">
                                                    <input value="" list="product_list" placeholder="Select Product" required class="form-control product_select" id="product" name="product[]" autocomplete="off">
                                                    <datalist id="product_list">
                                                        <option value="">Select</option>
                                                        <?php
                                                        $q = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($r = mysqli_fetch_assoc($q)) {
                                                        ?>
                                                            <option value="<?= ucwords($r['product_name']) ?>"><?= ucwords($r['product_name']) ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Rate</label>
                                                    <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Product Rate" value="" id="rate" name="rate[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Quantity</label>
                                                    <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Add Quantity" value="" id="quantity" name="quantity[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Kg</label>
                                                    <input type="text" required oninput="onlyNumberInput(event)" class="form-control" placeholder="Kg" value="" id="kg" name="kg[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Sub Total</label>
                                                    <input type="text" readonly oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Total Rate" value="" id="total_rate" name="total_rate[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 add_remove">
                                                <button type="button" class="outline_none border-0 bg-white" onclick="removeRow(this)">
                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                </button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    while ($items = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <div class="row mt-2">
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Select Product</label>
                                                    <input type="hidden" name="quotation_prod_id[]" value="<?= @$items['quotation_prod_id'] ?>">
                                                    <input value="<?= @$items['product_name'] ?>" list="product_list" placeholder="Select Product" required class="form-control product_select" id="product" name="product[]" autocomplete="off">
                                                    <datalist id="product_list">
                                                        <option value="">Select</option>
                                                        <?php
                                                        $q = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($r = mysqli_fetch_assoc($q)) {
                                                        ?>
                                                            <option value="<?= ucwords($r['product_name']) ?>"><?= ucwords($r['product_name']) ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Rate</label>
                                                    <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Product Rate" value="<?= @$items['product_rate'] ?>" id="rate" name="rate[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Quantity</label>
                                                    <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Add Quantity" value="<?= @$items['product_quantity'] ?>" id="quantity" name="quantity[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Kg</label>
                                                    <input type="text" required oninput="onlyNumberInput(event)" class="form-control" placeholder="Kg" value="<?= @$items['kg_quantity'] ?>" id="kg" name="kg[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group mb-0">
                                                    <label>Sub Total</label>
                                                    <input type="text" readonly oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Total Rate" value="<?= @$items['sub_total'] ?>" id="total_rate" name="total_rate[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 add_remove">
                                                <button type="button" class="outline_none border-0 bg-white" onclick="removeRow(this)">
                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                </button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row mt-2">
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group mb-0">
                                                <label>Select Product</label>
                                                <input list="product_list" placeholder="Select Product" required class="form-control product_select" id="product" name="product[]" autocomplete="off">
                                                <datalist id="product_list">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $q = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                    while ($r = mysqli_fetch_assoc($q)) {
                                                    ?>
                                                        <option value="<?= ucwords($r['product_name']) ?>"><?= ucwords($r['product_name']) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group mb-0">
                                                <label>Rate</label>
                                                <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Product Rate" value="" id="rate" name="rate[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group mb-0">
                                                <label>Quantity</label>
                                                <input type="text" required oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Add Quantity" id="quantity" name="quantity[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group mb-0">
                                                <label>Kg</label>
                                                <input type="text" required oninput="onlyNumberInput(event)" class="form-control" placeholder="Kg" value="" id="kg" name="kg[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group mb-0">
                                                <label>Sub Total</label>
                                                <input type="text" readonly oninput="onlyNumberInput(event);calculateSubtotal();" class="form-control" placeholder="Total Rate" value="" id="total_rate" name="total_rate[]">
                                            </div>
                                        </div>
                                        <div class="d-flex col-lg-2 col-md-4 col-sm-4 col-xs-4 add_remove">
                                            <button type="button" style="padding-left: 6px !important;" class="outline_none pb-0 text-left form-control border-0 d-none bg-white pt-0" onclick="duplicateRow()">
                                                <img src="img/add.png" width="30px" alt="add sign">
                                            </button>
                                            <button type="button" class="outline_none border-0 bg-white" onclick="removeRow(this)">
                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                            </button>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="row my-4 justify-content-end">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <div id="plus_button">
                                        <button type="button" class="outline_none border-0 bg-white" onclick="duplicateRow()">
                                            <img src="img/add.png" width="30px" alt="add sign">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ======================================================================================== -->
                            <div class="row">
                                <div class="col-lg-6 offset-lg-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td width="10%" class="table-bordered">Sub Total :</td>
                                                <td width="8%" class="table-bordered">
                                                    <span class="show_currency">
                                                        <?= !empty($dataQuot['currency']) ? $dataQuot['currency'] : 'PKR' ?>
                                                    </span>
                                                    <input type="hidden" name="sb_total" id="sb_total">
                                                    <span id="subtotal">
                                                        <?= !empty($dataQuot['sub_total']) ? $dataQuot['sub_total'] : '0.00' ?>
                                                    </span>
                                                </td>
                                                <td width="20%" class="table-bordered">
                                                    <select class="form-control" name="currency" id="currency">
                                                        <option value="PKR" <?= (@$dataQuot['currency'] == 'PKR') ? 'selected' : '' ?>>PKR - Pakistani Rupee (₨)</option>
                                                        <option value="USD" <?= (@$dataQuot['currency'] == 'USD') ? 'selected' : '' ?>>USD - US Dollar ($)</option>
                                                        <option value="EUR" <?= (@$dataQuot['currency'] == 'EUR') ? 'selected' : '' ?>>EUR - Euro (€)</option>
                                                    </select>
                                                </td>
                                                <td width="20%" class="table-bordered">
                                                    <input type="number" required min="1" value="<?= !empty($dataQuot['taxrate']) ? $dataQuot['taxrate'] : '0' ?>" step="any" class="form-control" placeholder="Add Tax" id="tax" name="tax">
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="20%" colspan="3" class="table-bordered text-right font-weight-bold text-dark" style="font-size: 18px;">
                                                    Grand Total :
                                                </td>
                                                <td width="20%" class="table-bordered text-right font-weight-bold text-dark" style="font-size: 18px;">
                                                    <span class="show_currency">
                                                        <?= !empty($dataQuot['currency']) ? $dataQuot['currency'] : 'PKR' ?>
                                                    </span>
                                                    <input type="hidden" name="gr_total" id="gr_total">
                                                    <span id="grandtotal">
                                                        <?= !empty($dataQuot['grandtotal']) ? $dataQuot['grandtotal'] : '0.00' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" id="inv_btn" class="btn btn-admin float-right">
                                <span id="loader_code" class="spinner-border d-none" style="width: 1.5rem !important;height: 1.5rem !important;"></span>
                                <span id="text_code" class=""><?= !empty($_REQUEST['QuotationID']) ? 'Update' : 'Save' ?> Quotation</span>
                            </button>
                        </form>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->

        </main> <!-- main -->
    </div> <!-- .wrapper -->

</body>

</html>
<?php include_once 'includes/foot.php'; ?>

<script>
    $(document).ready(function() {
        $('#currency').on('change', function() {
            var selectedCurrency = $(this).val();
            var currencyText = $('#currency option:selected').val();
            $('.show_currency').text(currencyText);
        });
    });


    function duplicateRow() {
        var container = $('#container');
        var lastRow = container.children('.row:last').clone(true);

        var newRowId = 'row' + (container.children('.row').length + 1);
        lastRow.attr('id', newRowId);
        // Generate unique ids for the inputs in the cloned row
        var product = 'product' + (container.children('.row').length + 1);
        var rate = 'rate' + (container.children('.row').length + 1);
        var quantity = 'quantity' + (container.children('.row').length + 1);
        var kg = 'kg' + (container.children('.row').length + 1);
        var total_rate = 'total_rate' + (container.children('.row').length + 1);

        // Update the ids in the cloned row
        lastRow.find('[name="product[]"]').attr('id', product);
        lastRow.find('[name="rate[]"]').attr('id', rate);
        lastRow.find('[name="quantity[]"]').attr('id', quantity);
        lastRow.find('[name="kg[]"]').attr('id', kg);
        lastRow.find('[name="total_rate[]"]').attr('id', total_rate);

        // Clear the input values in the cloned row
        lastRow.find('input, select').val('');

        // Remove existing "Plus" button from the last row
        lastRow.find('.add_remove button').remove();

        // Add "Plus" button to the new row
        lastRow.find('.add_remove').append(`
<button type="button" class="outline_none border-0 bg-white" onclick="removeRow(this)">
    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
</button>
`);

        container.append(lastRow);
    }

    function removeRow(button) {
        var container = $('#container');
        var rowToRemove = $(button).closest('.row');

        // Get the subtotal value of the row being removed
        var subtotalToRemove = parseFloat(rowToRemove.find('.form-control[name="total_rate[]"]').val()) || 0;

        rowToRemove.remove();

        // Subtract the subtotal of the removed row from downsubtotal
        var downsubtotal = parseFloat($('#subtotal').text()) || 0;
        downsubtotal -= subtotalToRemove;

        // Update subtotal and grandtotal
        $('#subtotal').text(downsubtotal.toFixed(2));

        // Recalculate grand total
        var taxRateInput = document.getElementById('tax');
        var taxRate = parseFloat(taxRateInput.value) || 0;
        var taxAmount = downsubtotal * (taxRate / 100);
        var grandTotal = downsubtotal + taxAmount;
        $('#grandtotal').text(grandTotal.toFixed(2));
        $('#gr_total').val(grandTotal.toFixed(2));

        // Show the "Plus" button when there are no child rows
        if (container.children('.row').length === 0) {
            $('#plus_button').show();
            // Refresh the page
            location.reload();
        }
    }


    function calculateSubtotal() {
        // Iterate through each row and calculate the subtotal for each row
        var downsubtotal = 0;
        document.querySelectorAll('.row').forEach(function(row) {
            var quantityInput = row.querySelector('.form-control[name="quantity[]"]');
            var rateInput = row.querySelector('.form-control[name="rate[]"]');
            var subtotalInput = row.querySelector('.form-control[name="total_rate[]"]');

            // Check if the inputs are present and subtotal input exists
            if (quantityInput && rateInput && subtotalInput) {
                var quantity = parseFloat(quantityInput.value) || 0;
                var rate = parseFloat(rateInput.value) || 0;

                var subtotal = quantity * rate;
                downsubtotal += subtotal;

                // Update the subtotal input with the calculated subtotal
                subtotalInput.value = isNaN(subtotal) ? '' : subtotal.toFixed(2);
            }
        });

        // Get the tax rate from the input field
        var taxRateInput = document.getElementById('tax');
        var taxRate = parseFloat(taxRateInput.value) || 0;

        // Calculate tax and grand total
        var taxAmount = downsubtotal * (taxRate / 100); // Convert taxRate to percentage
        var grandTotal = downsubtotal + taxAmount;

        // Update the grand total display
        $('#tax').text(taxAmount.toFixed(2));
        $('#subtotal').text(downsubtotal.toFixed(2));
        $('#grandtotal').text(grandTotal.toFixed(2));
        $('#gr_total').val(grandTotal.toFixed(2));
    }

    // Add an input event listener to the tax input field
    document.getElementById('tax').addEventListener('input', calculateSubtotal);
</script>
<script>
    $(document).ready(function() {

        $("#add_Quotation_fm").on('submit', function(e) {

            e.preventDefault();
            // alert("ascas");

            var formdata = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'php_action/custom_action.php',
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#loader_code').removeClass('d-none');
                    $('#text_code').addClass('d-none');
                },
                success: function(response) {

                    $('#loader_code').addClass('d-none');
                    $('#text_code').removeClass('d-none');
                    var responseData = JSON.parse(response).sts;
                    var responsemsg = JSON.parse(response).msg;

                    if (responseData == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: responsemsg,
                            showConfirmButton: false,
                            timer: 3000
                        }).then((result) => {
                            if (responseData == 'success') {
                                $('#add_Quotation_fm').trigger('reset');
                                window.location.href = 'Quotation_list.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: responsemsg,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            }); //ajax call
        }); //main
    });
</script>