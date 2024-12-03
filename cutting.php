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
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                        ?>
                            <div class="row m-0 mt-3">
                                <div id="voucher_rows_container2">
                                    <div class="voucher_row2">
                                        <div class="row mt-3 m-0 p-0">
                                            <div class="col-lg-2 m-0 p-0 pl-1 row">
                                                <div class="col-lg-6 m-0 p-0 pl-1">
                                                    <label for="sr">Sr</label>
                                                    <input type="text" class="form-control" id="sr<?= $i ?>" readonly value="<?= $i ?>">
                                                </div>
                                                <div class="col-lg-6 m-0 p-0 pl-1">
                                                    <label for="lat_no">Lot No</label>
                                                    <input type="text" class="form-control lat_no" id="lat_no<?= $i ?>" name="lat_no[]" placeholder="Lot No">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="d_lot_no">D Lot No</label>
                                                <input type="text" class="form-control" id="d_lot_no<?= $i ?>" name="d_lot_no[]" placeholder="D Lot No">
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
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="type">Type</label>
                                                <select class="form-control searchableSelect" name="type[]" id="type<?= $i ?>">
                                                    <option disabled selected>Select Type</option>
                                                    <option value="meter">Meter</option>
                                                    <option value="yard">Yard</option>
                                                    <option value="others">Suit</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="thaan">Thaan</label>
                                                <input type="text" class="form-control" id="thaan<?= $i ?>" name="thaan[]" placeholder="Thaan">
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="pur_thaan">Qty/Thaan</label>
                                                <input type="text" class="form-control" id="pur_thaan<?= $i ?>" name="pur_thaan[]" placeholder="Qty/Thaan">
                                            </div>
                                            <div class="col-lg-1 m-0 p-0 pl-1">
                                                <label for="qty">Qty</label>
                                                <input type="text" class="form-control" id="qty<?= $i ?>" name="qty[]" value="0" placeholder="Qty">
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
                                        <th>Purchase ID</th>
                                        <th>Purchase Date</th>
                                        <th>Product</th>
                                        <th>Thaan</th>
                                        <th>Gzanah</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($dbc, "SELECT * FROM dyeing WHERE status = 'received'");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?= $row['purchase_id'] ?></td>
                                            <td><?= $row['issuance_date'] ?></td>
                                            <td>
                                                <?php
                                                $pr_id = $row['product_id'];
                                                $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 AND product_id = '$pr_id'");
                                                while ($r = mysqli_fetch_array($result)) {
                                                    // $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                    // $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                    echo $r['product_name'];
                                                } ?>
                                            </td>
                                            <td><?= $row['thaan'] ?></td>
                                            <td><?= $row['gzanah'] ?></td>
                                            <td><?= $row['quantity_instock'] ?></td>
                                            <td><?= $row['total_amount'] ?></td>
                                            <td>
                                                <button type="button" class="btn select-row btn-primary btn-sm"
                                                    name="selected_purchase_id"
                                                    id="selected_purchase_id"
                                                    value="<?= $row['dyeing_id'] ?>" onclick="getDyeingDetails(this.value)">Apply</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
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
    function getDyeingDetails(dyeingId) {
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
                    const currentId = $("#show_dyeing_details").data("currentId"); // Retrieve the stored currentId

                    // Update fields dynamically
                    const rowIndex = currentId.replace("lat_no", ""); // Extract row index from id

                    $(`#thaan${rowIndex}`).val(data.thaan); // Set Thaan value
                    $(`#qty${rowIndex}`).val(data.quantity_instock); // Set Gzanah value
                    $(`#d_lot_no${rowIndex}`).val(data.lat_no); // Set Gzanah value

                    // Close Modal
                    $("#detailModalClose").click();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }

    function getDyeingDetails(dyeingId) {
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
                    const currentId = $("#show_dyeing_details").data("currentId");

                    const rowIndex = currentId.replace("lat_no", "");

                    $(`#thaan${rowIndex}`).val(data.thaan);
                    $(`#qty${rowIndex}`).val(data.quantity_instock);
                    $(`#d_lot_no${rowIndex}`).val(data.lat_no);
                    $(`#pur_type${rowIndex}`).val(data.unit);

                    const productDetails = JSON.parse(data.product_details);
                    const purThaanValue = productDetails.pur_thaan_arr[0];

                    $(`#pur_thaan${rowIndex}`).val(purThaanValue);
                    $(`#color${rowIndex}`).val(productDetails.color_arr[0]);

                    $("#detailModalClose").click();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }


    $(document).on("focus", ".lat_no", function() {
        const currentId = $(this).attr("id"); // Get the id of the focused field
        const dyeingId = $(this).val(); // Assume value or fetch as needed

        // Open Modal
        $("#show_dyeing_details").modal("show");

        // Store currentId for later use
        $("#show_dyeing_details").data("currentId", currentId);
    });

    // When a row in the modal is selected
    $(document).on("click", ".select-row", function() {
        const dyeingId = $(this).data("dyeing-id"); // Assume dyeingId is stored in a button attribute
        getDyeingDetails(dyeingId);
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