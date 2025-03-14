<?php if (basename($_SERVER['REQUEST_URI']) == 'stitching_issuance.php') { ?>
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
                                <b class="text-center card-text">Stitching Issuance</b>
                                <a href="credit_purchase.php" class="btn btn-admin float-right btn-sm">Add New</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php } ?>

                    <form action="php_action/custom_action.php" method="POST" id="embroidery_form">
                        <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">
                        <input type="hidden" name="stitchingform" id="embroideryform" value="stitchingform">
                        <input type="hidden" name="purchase_id" id="purchase_id" value="">


                        <div class="row form-group">
                            <div class="col-md-2  mt-3">
                                <label>Transaction #</label>
                                <input type="text" name="transaction" id="transaction" placeholder="Write Here..." value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="<?= date('Y-m-d') ?>" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Lot No</label>
                                <input type="text" placeholder="Lot No" readonly value="" autocomplete="off" class="form-control " name="lot_no" id="lot_no">
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
                                <label for="location">Location</label>
                                <select class="form-control searchableSelect" name="location" id="location" onchange="getTableData(this.value)">
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
                                <label for="embroidery">Embroidery</label>
                                <select class="form-control searchableSelect" name="embroidery" id="embroidery">
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
                                <label>Dyeing Lot</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="dyeing_lot" id="dyeing_lot">
                            </div>
                            <div class="col-md-2  mt-3">
                                <label>Manual Gp #</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="manual_gp" id="manual_gp">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="cutting_man">Cutting Man</label>
                                <input type="text" placeholder="Cutting Man" value="" autocomplete="off" class="form-control " name="cutting_man" id="cutting_man">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="sending_person">Sending Person</label>
                                <input type="text" placeholder="Sending Person" value="" autocomplete="off" class="form-control " name="sending_person" id="sending_person">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="carrier_person">Carrier Person</label>
                                <input type="text" placeholder="Carrier Person" value="" autocomplete="off" class="form-control " name="carrier_person" id="carrier_person">
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
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                    ?>
                        <div class="row m-0 mt-3 complete px-3" id="row<?= $i ?>">
                            <div id="voucher_rows_container2">
                                <div class="voucher_row2" id="row<?= $i ?>">
                                    <div class="row mt-3 m-0 p-0">
                                        <div class="col-lg-2 m-0 p-0  row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr<?= $i ?>" readonly value="<?= $i ?>">
                                            </div>
                                            <div class="col-lg-5 m-0 mt-1 p-0 pl-3">
                                                <button type="button" class="btn select_dyeing  mt-4 btn-primary btn-sm"
                                                    name="select_dyeing"
                                                    id="select_dyeing"> Select </button>
                                            </div>

                                        </div>
                                        <div class="col-lg-2 m-0 p-0 pl-1">
                                            <label for="pur_type">Unit</label>
                                            <select class="form-control searchableSelect" name="pur_type[]" id="pur_type<?= $i ?>">
                                                <option disabled selected>Select Unit</option>
                                                <option value="meter">Meter</option>
                                                <option value="yard">Yard</option>
                                                <option value="others">Suit</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 m-0 p-0 pl-1">
                                            <label for="type">Product</label>
                                            <div class="input-group">
                                                <select class="form-control searchableSelect" name="from_type[]" id="from_type<?= $i ?>" onchange="getStock(this.value, <?= $i ?>)">
                                                    <option disabled selected>Select Type</option>
                                                    <?php
                                                    $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'cora_cutted' OR brand_id = 'dyed_cutted' OR brand_id = 'printed' OR brand_id = 'embroidered' AND status = 1");
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
                                        <div class="col-lg-2 m-0 p-0 pl-1">
                                            <label for="type">Type</label>
                                            <select class="form-control searchableSelect" name="type[]" id="type<?= $i ?>">
                                                <option disabled selected>Select Type</option>
                                                <?php
                                                $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'stitched' AND status = 1");
                                                while ($p = mysqli_fetch_assoc($products)) {
                                                ?>
                                                    <option value="<?= $p['product_id'] ?>"><?= ucwords($p['product_name']) ?> (<?= ucwords($p['brand_id']) ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 m-0 p-0 pl-1 row">
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

                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>


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
                                    <h5 class="modal-title" id="exampleModalLongTitle">Cutting & Printing Details</h5>
                                    <input type="text" id="tableSearchInput" class="form-control ml-3" placeholder="Search Here" style="width: 50%;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="detailModalClose">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                <div class="modal-body">
                                    <table class="table table-bordered" id="purchaseDetailsTable">
                                        <thead id="table-head-id">
                                            <tr>
                                                <th>Issuance Date</th>
                                                <th>Lot No</th>
                                                <th>Cutting Man</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body-id">
                                            <tr>
                                                <td colspan="8" class="text-center">Select Location First</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered" id="printingDetailsTable">
                                        <thead id="printTable-head-id">
                                            <tr>
                                                <th>Issuance Date</th>
                                                <th>Lot No</th>
                                                <th>Cutting Man</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="printTable-body-id">
                                            <tr>
                                                <td colspan="8" class="text-center">Select Location First</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered" id="embDetailsTable">
                                        <thead id="embTable-head-id">
                                            <tr>
                                                <th>Issuance Date</th>
                                                <th>Lot No</th>
                                                <th>Cutting Man</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="embTable-body-id">
                                            <tr>
                                                <td colspan="8" class="text-center">Select Location First</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer"></div>

                            </div>
                        </div>
                    </div>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'stitching_issuance.php') { ?>
                </div>
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
        <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->
        <!-- Button trigger modal -->




    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    }
?>
<script>
    $(document).on("click", ".select_dyeing", function() {
        const currentId = $(this).closest(".voucher_row2").attr("id");
        $("#show_dyeing_details").data("currentId", currentId);

        $("#show_dyeing_details").modal("show");
        console.log("Modal opened for row ID:", currentId);
    });

    $(document).on("click", ".select-row", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getCuttingDetails(cuttingID, currentId);
    });
    $(document).on("click", ".select-row2", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getCuttingItemDetails(cuttingID, currentId);
    });
    $(document).on("click", ".select-row3", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getPrintingItemDetails(cuttingID, currentId);
    });
    $(document).on("click", ".select-row5", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getPrintingDetails(cuttingID, currentId);
    });
    $(document).on("click", ".select-row4", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getEmbItemDetails(cuttingID, currentId);
    });
    $(document).on("click", ".select-row6", function() {
        const cuttingID = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        getEmbDetails(cuttingID, currentId);
    });
    // getDyeingDetails(dyeingId, currentId);

    function getTableData(location_id) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_location_data: location_id
            },
            dataType: 'json',
            success: function(response) {
                try {
                    if (response.success) {
                        let cuttingTableBody = ''; // Separate variables for each table
                        let printingTableBody = '';
                        let embTableBody = '';

                        if (response.cutting_items) {
                            response.cutting_items.forEach(row => {
                                cuttingTableBody += `
                                <tr>
                                    <td>${row.issuance_date}</td>
                                    <td class="text-capitalize">${row.lot_no}</td>
                                    <td class="text-capitalize">${row.customer_name}</td>
                                    <td>
                                        <button type="button" class="btn select-row2 btn-primary btn-sm" value="${row.lot_no}">Apply</button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#table-body-id').html(cuttingTableBody);
                        }

                        if (response.printing_data) {
                            response.printing_data.forEach(row => { // Iterate through the printing data array
                                printingTableBody += `
                                <tr>
                                    <td>${row.issuance_date}</td>
                                    <td>${row.lot_no}</td>
                                    <td>${row.to_location}</td>
                                    <td>
                                        <button type="button" class="btn select-row3 btn-primary btn-sm" value="${row.lot_no}">Apply</button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#printTable-body-id').html(printingTableBody);
                        }

                        if (response.embroidery_data) {
                            response.embroidery_data.forEach(row => { // Iterate through the printing data array
                                embTableBody += `
                                <tr>
                                    <td>${row.issuance_date}</td>
                                    <td>${row.lot_no}</td>
                                    <td>${row.to_location}</td>
                                    <td>
                                        <button type="button" class="btn select-row4 btn-primary btn-sm" value="${row.lot_no}">Apply</button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#embTable-body-id').html(embTableBody);
                        }

                    } else {
                        alert('No data found');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }
    $(document).ready(function() {
        $('#embroidery_form').on('submit', function(event) {
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

                        $('#embroidery_form')[0].reset();
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


    function getCuttingDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_cutting: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    const row = $(`#${currentId}`); // Get the current row using currentId

                    // Fill in the fields with the response data
                    $('#lot_no').val(data.lot_no || '');
                    row.find('[name="d_lot_no[]"]').val(data.d_lat_no || '');
                    row.find('[name="pur_type[]"]').val(data.unit || '').change();
                    row.find('[name="from_type[]"]').val(data.product_id || '').change();
                    row.find('[name="thaan[]"]').val(data.thaan || '');
                    row.find('[name="pur_thaan[]"]').val(data.qty_pur_thaan || '');
                    row.find('[name="qty[]"]').val(data.qty || '');
                    row.find('[name="unsettle[]"]').val(data.unsettle || '');
                    row.find('[name="cp[]"]').val(data.cp || '');
                    row.find('[name="r_khata[]"]').val(data.r_khata || '');
                    row.find('[name="small_cp[]"]').val(data.small_cp || '');
                    row.find('[name="color[]"]').val(data.color || '');


                    $("#lot_no").val(data.item_lot_no);
                    $("#purchase_id").val(data.purchase_id);
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

    function getPrintingDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_printing: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    const row = $(`#${currentId}`); // Get the current row using currentId

                    // Fill in the fields with the response data
                    $('#lot_no').val(data.lot_no || '');
                    row.find('[name="d_lot_no[]"]').val(data.d_lat_no || '');
                    row.find('[name="pur_type[]"]').val(data.unit || '').change();
                    row.find('[name="from_type[]"]').val(data.product_id || '').change();
                    row.find('[name="thaan[]"]').val(data.thaan || '');
                    row.find('[name="pur_thaan[]"]').val(data.qty_pur_thaan || '');
                    row.find('[name="qty[]"]').val(data.qty || '');
                    row.find('[name="unsettle[]"]').val(data.unsettle || '');
                    row.find('[name="cp[]"]').val(data.cp || '');
                    row.find('[name="r_khata[]"]').val(data.r_khata || '');
                    row.find('[name="small_cp[]"]').val(data.small_cp || '');
                    row.find('[name="color[]"]').val(data.color || '');

                    $("#lot_no").val(data.item_lot_no);
                    $("#purchase_id").val(data.purchase_id);
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
    function getEmbDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_emb: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    const row = $(`#${currentId}`); // Get the current row using currentId

                    // Fill in the fields with the response data
                    $('#lot_no').val(data.lot_no || '');
                    row.find('[name="d_lot_no[]"]').val(data.d_lat_no || '');
                    row.find('[name="pur_type[]"]').val(data.unit || '').change();
                    row.find('[name="from_type[]"]').val(data.product_id || '').change();
                    row.find('[name="thaan[]"]').val(data.thaan || '');
                    row.find('[name="pur_thaan[]"]').val(data.qty_pur_thaan || '');
                    row.find('[name="qty[]"]').val(data.qty || '');
                    row.find('[name="unsettle[]"]').val(data.unsettle || '');
                    row.find('[name="cp[]"]').val(data.cp || '');
                    row.find('[name="r_khata[]"]').val(data.r_khata || '');
                    row.find('[name="small_cp[]"]').val(data.small_cp || '');
                    row.find('[name="color[]"]').val(data.color || '');

                    $("#lot_no").val(data.item_lot_no);
                    $("#purchase_id").val(data.purchase_id);
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
    


    function getCuttingItemDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_cutting_items: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Correct reference to cutting_items
                    const data = response.cutting_items;

                    // Initialize variables for table header and body
                    let tableHead = "";
                    let tableBody = "";

                    const row = $(`#${currentId}`);
                    $('#table-body-id').html(""); // Clear previous table body
                    $('#table-head-id').html(""); // Clear previous table header

                    // Construct table header
                    tableHead += `
                    <tr>
                        <th>Lot No</th>
                        <th>Product</th>
                        <th>Thaan</th>
                        <th>Quantity</th>
                        <th>Cutting Man</th>
                        <th>Action</th>
                    </tr>
                `;

                    // Construct table body from the response data
                    data.forEach(item => {
                        tableBody += `
                        <tr>
                            <td class="text-capitalize">${item.lot_no}</td>
                            <td class="text-capitalize">${item.product_name}</td>
                            <td>${item.thaan}</td>
                            <td>${item.quantity_instock || item.qty}</td>
                            <td>${item.customer_name}</td>
                            <td>
                                <button type="button" class="btn select-row btn-primary btn-sm" value="${item.cutting_item_id}">
                                    Apply
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    // Insert the constructed table head and body
                    $('#table-head-id').html(tableHead);
                    $('#table-body-id').html(tableBody);
                    $('#printTable-body-id').html("<tr><td colspan='8' class='text-center'>No Data Found</td></tr>");

                } else {
                    console.error("Failed to fetch cutting item details:", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    function getPrintingItemDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_printing_items: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Correct reference to printing_items
                    const data = response.printing_items;

                    // Initialize variables for table header and body
                    let tableHead = "";
                    let tableBody = "";

                    const row = $(`#${currentId}`);
                    $('#printTable-head-id').html(""); // Clear previous table body
                    $('#printTable-body-id').html(""); // Clear previous table header

                    // Construct table header
                    tableHead += `
                    <tr>
                        <th>Item Lot No</th>
                        <th>Product</th>
                        <th>Thaan</th>
                        <th>Quantity In Stock</th>
                        <th>Customer Name</th>
                        <th>Action</th>
                    </tr>
                `;

                    // Construct table body from the response data
                    data.forEach(item => {
                        tableBody += `
                        <tr>
                            <td class="text-capitalize">${item.item_lot_no}</td>
                            <td class="text-capitalize">${item.product_name}</td>
                            <td>${item.thaan}</td>
                            <td>${item.quantity_instock || item.qty}</td>
                            <td>${item.customer_name}</td>
                            <td>
                                <button type="button" class="btn select-row5 btn-primary btn-sm" value="${item.printing_item_id}">
                                    Apply
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    // Insert the constructed table head and body
                    $('#printTable-head-id').html(tableHead); // Insert the table header
                    $('#printTable-body-id').html(tableBody); // Insert the table body
                    $('#table-body-id').html('<tr><td colspan="6">No data found</td></tr>'); // Insert the table body
                    $('#embTable-body-id').html('<tr><td colspan="6">No data found</td></tr>'); // Insert the table body
                } else {
                    console.error("Failed to fetch printing item details:", response.message);
                    $('#table-body-id').html("<tr><td colspan='8' class='text-center'>No Data Found</td></tr>"); // Show message if no data
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#table-body-id').html('<tr><td colspan="6">Error loading data</td></tr>'); // Show error message
            }
        });
    }
    function getEmbItemDetails(cuttingID, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_emb_items: cuttingID
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Correct reference to printing_items
                    const data = response.embroidery_items;

                    // Initialize variables for table header and body
                    let tableHead = "";
                    let tableBody = "";

                    const row = $(`#${currentId}`);
                    $('#embTable-body-id').html(""); // Clear previous table body
                    $('#embTable-head-id').html(""); // Clear previous table header

                    // Construct table header
                    tableHead += `
                    <tr>
                        <th>Item Lot No</th>
                        <th>Product</th>
                        <th>Thaan</th>
                        <th>Quantity In Stock</th>
                        <th>Customer Name</th>
                        <th>Action</th>
                    </tr>
                `;

                    // Construct table body from the response data
                    data.forEach(item => {
                        tableBody += `
                        <tr>
                            <td class="text-capitalize">${item.item_lot_no}</td>
                            <td class="text-capitalize">${item.product_name}</td>
                            <td>${item.thaan}</td>
                            <td>${item.quantity_instock || item.qty}</td>
                            <td>${item.customer_name}</td>
                            <td>
                                <button type="button" class="btn select-row6 btn-primary btn-sm" value="${item.embroidery_item_id}">
                                    Apply
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    // Insert the constructed table head and body
                    $('#embTable-head-id').html(tableHead); // Insert the table header
                    $('#embTable-body-id').html(tableBody); // Insert the table body
                    $('#table-body-id').html('<tr><td colspan="6" class="text-center">No data found</td></tr>'); // Insert the table body
                    $('#printTable-body-id').html('<tr><td colspan="6" class="text-center">No data found</td></tr>'); // Insert the table body
                } else {
                    console.error("Failed to fetch embroidery item details:", response.message);
                    $('#table-body-id').html("<tr><td colspan='8' class='text-center'>No Data Found</td></tr>"); // Show message if no data
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#table-body-id').html('<tr><td colspan="6">Error loading data</td></tr>'); // Show error message
            }
        });
    }



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