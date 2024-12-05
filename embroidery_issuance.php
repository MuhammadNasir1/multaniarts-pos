<?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_issuance.php') { ?>
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
                                <b class="text-center card-text">Embroidery Issuance</b>
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
                                <input type="text" name="transaction" id="transaction" placeholder="Write Here..." value="" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Date</label>
                                <input type="date" name="issuance_date" id="issuance_date" value="<?= date('Y-m-d') ?>" class="form-control">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="emb_type">Emb Type</label>
                                <select class="form-control searchableSelect" name="emb_type[]" id="emb_type">
                                    <option disabled selected>Select Type</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="location">Location</label>
                                <select class="form-control searchableSelect" name="location[]" id="location" onchange="getTableData(this.value)">
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
                                <select class="form-control searchableSelect" name="embroidery[]" id="embroidery">
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
                                <select class="form-control searchableSelect" name="program[]" id="program">
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
                                <label>Lot No</label>
                                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="lot_no" id="lot_no">
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
                                            <div class="col-lg-2 m-0 p-0 pl-1">
                                                <label for="sr">Sr</label>
                                                <input type="text" class="form-control" id="sr<?= $i ?>" readonly value="<?= $i ?>">
                                            </div>
                                            <div class="col-lg-5 m-0 mt-1 p-0 pl-3 row">
                                                <button type="button" class="btn select_dyeing  mt-4 btn-primary btn-sm"
                                                    name="select_dyeing"
                                                    id="select_dyeing"> Select Dyeing </button>
                                            </div>
                                            <div class="col-lg-5 m-0 p-0">
                                                <label for="lat_no">Lot No</label>
                                                <input type="text" class="form-control" id="lat_no<?= $i ?>" value="" name="lat_no[]" placeholder="Lot No">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="d_lot_no">D Lot No</label>
                                            <input type="text" class="form-control d_lot_no" readonly id="d_lot_no<?= $i ?>" name="d_lot_no[]" placeholder="D Lot No">
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
                                                    $products = mysqli_query($dbc, "SELECT * FROM product WHERE brand_id = 'dyed' OR brand_id = 'cora' AND status = 1");
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
                                            <div class="col-lg-4 m-0 p-0 pl-1">
                                                <label for="qty">Qty</label>
                                                <input type="number" class="form-control" id="qty<?= $i ?>" name="qty[]" placeholder="Qty">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1">
                                            <label for="unsettle">Unsettle</label>
                                            <input type="text" class="form-control" id="unsettle<?= $i ?>" name="unsettle[]" placeholder="Unsettle">
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="cp">CP</label>
                                                <input type="text" class="form-control" id="cp<?= $i ?>" name="cp[]" placeholder="CP">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="r_khata">R Khata</label>
                                                <input type="text" class="form-control" id="r_khata<?= $i ?>" name="r_khata[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 m-0 p-0 pl-1 row">
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="small_cp">Small CP</label>
                                                <input type="text" class="form-control" id="small_cp<?= $i ?>" name="small_cp[]">
                                            </div>
                                            <div class="col-lg-6 m-0 p-0 pl-1">
                                                <label for="color">Color</label>
                                                <input type="text" class="form-control" id="color<?= $i ?>" name="color[]" placeholder="Color">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-2 d-none">
                        <label class="invisible d-block">.</label>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" id="show_dyeing_details_btn" data-target="#show_dyeing_details"> <i class="fa fa-plus"></i> </button>
                    </div>

                    <div class="modal fade" id="show_dyeing_details" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Dyeing Details</h5>
                                    <input type="text" id="tableSearchInput" class="form-control ml-3" placeholder="Search Here" style="width: 50%;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="detailModalClose">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                <div class="modal-body">
                                    <table class="table table-bordered" id="purchaseDetailsTable">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Thaan</th>
                                                <th>Gzanah</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body-id">
                                            <tr>
                                                <td colspan="8" class="text-center">Select Cutting Man First</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mb-5 mr-1">
                        <div class="col-sm-6 offset-6">
                            <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>
                        </div>
                    </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'embroidery_issuance.php') { ?>
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
        const dyeingId = $(this).val();
        const currentId = $("#show_dyeing_details").data("currentId");

        // getCuttingDetails(dyeingId, currentId);
    });
    // getDyeingDetails(dyeingId, currentId);

    function getTableData(location_id) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_location_data: location_id
            },
            dataType: 'text',
            success: function(response) {
                try {
                    let jsonResponse = JSON.parse(response);

                    if (jsonResponse.success && jsonResponse.cutting_items) {
                        let tableBody = '';

                        jsonResponse.cutting_items.forEach(row => {
                            tableBody += `
                        <tr>
                            <td>${row.purchase_id}</td>
                            <td class="text-capitalize">${row.product_name}</td>
                            <td>${row.thaan}</td>
                            <td>${row.qty}</td>
                            <td>
                                <button type="button" class="btn select-row btn-primary btn-sm" value="${row.cutting_id}">
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



    function getDyeingDetails(dyeingId, currentId) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                get_selected_dyeing: dyeingId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;


                    const row = $(`#${currentId}`);

                    const productDetails = JSON.parse(data.product_details);
                    row.find('[name="from_type[]"]').val(data.product_id || '').change();
                    row.find('[name="d_lot_no[]"]').val(data.lat_no || '');
                    row.find('[name="pur_type[]"]').val(data.unit || '').change();
                    row.find('[name="type[]"]').val(data.type || '');
                    row.find('[name="thaan[]"]').val(data.thaan || '');
                    row.find('[name="pur_thaan[]"]').val(data.qty_thaan || '');
                    row.find('[name="qty[]"]').val(data.quantity_instock || '');
                    row.find('[name="color[]"]').val(productDetails.color_arr[0] || '');
                    row.find('[name="pur_thaan[]"]').val(productDetails.pur_thaan_arr[0] || '');

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
</script>