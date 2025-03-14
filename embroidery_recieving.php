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

                    <form action="" method="POST" id="embroidery_rec_form">
                        <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">
                        <input type="hidden" name="embroideryRecform" id="embroideryRecform" value="embroideryRecform">
                        <input type="hidden" name="purchase_id" id="purchase_id" value="">
                        <input type="hidden" name="received_embroidery" id="received_embroidery" value="">



                        <div class="row form-group">
                            <div class="col-md-2  mt-3">
                                <label>Transaction #</label>
                                <input type="text" name="transaction" id="transaction" value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="" class="form-control">
                            </div>
                            <div class="col-2 mt-3">
                                <label>Lot No #</label>
                                <input type="text" placeholder="Lot No" readonly value="" autocomplete="off" class="form-control " name="lat_no" id="lat_no">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Party GP #</label>
                                <input type="text" placeholder="Party GP" value="" autocomplete="off" class="form-control " name="party_gp" id="party_gp">
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
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('embroidery')";
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
                                    $query = "SELECT * FROM customers WHERE customer_type IN ('shop')";
                                    $result = mysqli_query($dbc, $query);
                                    while ($d = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$d['customer_id']}'>" . ucwords($d['customer_name']) . " (" . ucwords($d['customer_type']) . ")</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Manual GP #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="manual_gp" id="manual_gp">
                            </div>
                            <div class="col-2 mt-3">
                                <label>Color</label>
                                <input type="text" name="main_color" id="main_color" value="" class="form-control">
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
                                    <div class="voucher_row2" id="row_inner<?= $i ?>">
                                        <div class="row mt-3 m-0 p-0">
                                            <div class="col-lg-1 m-0 p-0 row">
                                                <input type="hidden" name="embroidery_item_id[]" id="embroidery_item_id<?= $i ?>" value="">
                                                <div class="col-lg-3 m-0 p-0">
                                                    <label for="sr">Sr</label>
                                                    <input type="text" class="form-control" id="sr<?= $i ?>" readonly value="<?= $i ?>" name="sr[]">
                                                </div>
                                                <div class="col-lg-9 m-0 mt-1 p-0 pl-3">
                                                    <button type="button" class="btn select_dyeing mt-4 btn-primary btn-sm"
                                                        name="select_dyeing"
                                                        id="select_dyeing">Embroidery</button>
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
                                                <label for="from_type">Product</label>
                                                <div class="input-group">
                                                    <select class="form-control searchableSelect" name="from_type[]" id="from_type<?= $i ?>" onchange="getStock(this.value, <?= $i ?>)">
                                                        <option disabled selected>Select Type</option>
                                                        <?php
                                                        $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'cora_cutted' OR brand_id = 'dyed_cutted' OR brand_id = 'printed ' AND status = 1");
                                                        while ($p = mysqli_fetch_assoc($products)) {
                                                        ?>
                                                            <option value="<?= $p['product_id'] ?>"><?= ucwords($p['product_name']) ?> (<?= ucwords($p['brand_id']) ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Stock: <span id="from_product_bl<?= $i ?>">0</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="type">Type</label>
                                                <select class="form-control searchableSelect" name="type[]" id="type<?= $i ?>">
                                                    <option disabled selected>Select Type</option>
                                                    <?php
                                                    $products = mysqli_query($dbc, "SELECT * FROM product WHERE (brand_id = 'embroidered') AND status = 1");
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



                        <div class="row mt-3 mb-5 mr-1">
                            <div class="col-sm-6 offset-6">
                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-2 d-none">
                        <label class="invisible d-block">.</label>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" id="show_dyeing_details_btn" data-target="#show_dyeing_details"> <i class="fa fa-plus"></i> </button>
                    </div>

                    <div class="modal fade" id="show_dyeing_details" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Embroidery Details</h5>
                                    <input type="text" id="tableSearchInput" class="form-control ml-3" placeholder="Search Here" style="width: 50%;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="detailModalClose">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                <div class="modal-body">
                                    <table class="table table-bordered" id="purchaseDetailsTable">
                                        <thead id="table-head-id">
                                            <tr>
                                                <th>Lot No</th>
                                                <th>Issuance Date</th>
                                                <th>Embroidery</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body-id">
                                            <tr>
                                                <td colspan="8" class="text-center">Select Embroidery First</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer"></div>

                            </div>
                        </div>
                    </div>
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

<script>
    $(document).on("click", ".select_dyeing", function() {
        const currentId = $(this).closest(".voucher_row2").attr("id");
        $("#show_dyeing_details").data("currentId", currentId);

        $("#show_dyeing_details").modal("show");
        console.log("Modal opened for row ID:", currentId);
    });

    $(document).on("click", ".select-row", function() {
        const embID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getEmbDetails(embID, currentId);
    });
    $(document).on("click", ".select-row2", function() {
        const embID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getEmbItemDetails(embID, currentId);
    });

    function getTableData(location_id) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_embroidery_data: location_id
            },
            dataType: 'text',
            success: function(response) {
                try {
                    let jsonResponse = JSON.parse(response);

                    if (jsonResponse.success && jsonResponse.embroidery_items) {
                        let tableBody = '';

                        jsonResponse.embroidery.forEach(row => {
                            tableBody += `
                        <tr>
                            <td class="text-capitalize">${row.lot_no}</td>
                            <td class="text-capitalize">${row.issuance_date}</td>
                            <td class="text-capitalize">${row.customer_name}</td>
                            <td>
                                <button type="button" class="btn select-row2 btn-primary btn-sm" value="${row.lot_no}">
                                    Apply
                                </button>
                            </td>
                        </tr>
                    `;
                        });

                        $('#table-body-id').html(tableBody);
                    } else {
                        alert('No data found');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    function getEmbItemDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_embroidery_items: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let data = response.data;

                    // Extract product_name if available
                    let productName = data.product_name || '';

                    // Convert object to an array (excluding non-numeric keys)
                    let dataArray = Object.values(data).filter(item => typeof item === 'object');

                    // Initialize table header and body
                    let tableHead = "";
                    let tableBody = "";

                    $('#table-body-id').html(""); // Clear previous table body
                    $('#table-head-id').html(""); // Clear previous table header

                    // Construct table header
                    tableHead += `
                    <tr>
                        <th>Item Lot No</th>
                        <th>Product</th>
                        <th>Thaan</th>
                        <th>Quantity In Stock</th>
                        <th>Action</th>
                    </tr>
                `;

                    // Construct table body from the response data
                    dataArray.forEach(item => {
                        tableBody += `
                        <tr>
                            <td class="text-capitalize">${item.item_lot_no || '-'}</td>
                            <td class="text-capitalize">${productName || 'Unknown'}</td>
                            <td>${item.thaan || '-'}</td>
                            <td>${item.quantity_instock || item.qty || '-'}</td>
                            <td>
                                <button type="button" class="btn select-row btn-primary btn-sm" value="${item.embroidery_item_id}">
                                    Apply
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    // Insert the constructed table head and body
                    $('#table-head-id').html(tableHead);
                    $('#table-body-id').html(tableBody);
                } else {
                    console.error("Failed to fetch embroidery item details:", response.message);
                    $('#table-body-id').html('<tr><td colspan="5">No data found</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#table-body-id').html('<tr><td colspan="5">Error loading data</td></tr>');
            }
        });
    }


    function getEmbDetails(embID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_embroidery: embID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    const row = $(`#${currentId}`); // Get the current row using currentId

                    // Fill in the fields with the response data
                    row.find('[name="lat_no[]"]').val(data.item_lot_no || '');
                    row.find('[name="d_lot_no[]"]').val(data.d_lat_no || '');
                    row.find('[name="pur_type[]"]').val(data.unit || '').change();
                    row.find('[name="from_type[]"]').val(data.from_product_type || '').change();
                    row.find('[name="type[]"]').val(data.product_id || '').change();
                    row.find('[name="thaan[]"]').val(data.thaan || '');
                    row.find('[name="pur_thaan[]"]').val(data.qty_pur_thaan || '');
                    row.find('[name="qty[]"]').val(data.qty || '');
                    row.find('[name="unsettle[]"]').val(data.unsettle || '');
                    row.find('[name="cp[]"]').val(data.cp || '');
                    row.find('[name="r_khata[]"]').val(data.r_khata || '');
                    row.find('[name="small_cp[]"]').val(data.small_cp || '');
                    row.find('[name="color[]"]').val(data.color || '');
                    row.find('[name="embroidery_item_id[]"]').val(data.embroidery_item_id || '');

                    $("#lat_no").val(data.item_lot_no);
                    $("#dyeing_lot").val(data.d_lat_no);
                    $("#purchase_id").val(data.purchase_id);
                    $("#received_embroidery").val(data.stitching_id);
                    $("#show_dyeing_details").modal("hide");
                } else {
                    console.error("Failed to fetch dyeing details:", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    $(document).ready(function() {
        $('#embroidery_rec_form').on('submit', function(event) {
            event.preventDefault(); // Prevent form default submission

            let formData = $(this).serialize();

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
                            timer: 500
                        }).then((result) => {
                            location.reload();
                        });

                        $('#embroidery_rec_form')[0].reset();
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

    function getStock(product_id, index) {
        $.ajax({
            url: 'php_action/custom_action.php', // Replace with your PHP script's path
            type: 'POST',
            data: {
                get_stock: product_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the stock span with the correct index
                    $('#from_product_bl' + index).text(response.data.quantity_instock);
                } else {
                    alert('Error: ' + (response.error || 'Unknown error occurred'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }
</script>