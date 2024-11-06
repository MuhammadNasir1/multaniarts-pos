<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
if (!empty($_REQUEST['ProductionID']) && isset($_REQUEST['ProductionID'])) {

    $ProductionID = $_REQUEST['ProductionID'];

    $dataproduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE `production_id` = '$ProductionID'"));
    $request_id = $dataproduction['purchase_id'];
    $purchase_data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `purchase` WHERE `purchase_id` = '$request_id'"));
    $user_id = $_SESSION['userId'];
    // $deyeingfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $ProductionID and deyeing_status = 'sent'"));
    // $deyeingfetchRecieve = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $ProductionID and deyeing_status = 'recieved'"));
}





if (isset($_POST['cutting_btn'])) {
    $cutt_id = $_POST['cutt_id'];
    $cutt_status = $_POST['cutt_status'];
    $cutting_date = $_POST['cutting_date'];
    $cutt_party_name = $_POST['cutt_party_name'];
    $cutt_dyeing_lat_no = $_POST['cutt_dyeing_lat_no'];
    $cutt_volume_no = $_POST['cutt_volume_no'];
    $cutt_location = $_POST['cutt_location'];
    $cutting_delivery_date = $_POST['cutting_delivery_date'];
    $cutt_remarks = $_POST['cutt_remarks'];


    $formData1 = [
        'cutting_from_product' => $_POST['cutting_from_product'],
        'cutt_from_thaan' => $_POST['cutt_from_thaan'],
        'cutt_form_gzanah' => $_POST['cutt_form_gzanah'],
        'cutt_from_quantity' => $_POST['cutt_from_quantity'],
        'cutt_from_gzanah_type' => $_POST['cutt_from_gzanah_type'],
    ];
    $formData2 = [
        'cutting_to_product' => $_POST['cutting_to_product'],
        'cutt_to_thaan' => $_POST['cutt_to_thaan'],
        'cutt_to_gzanah' => $_POST['cutt_to_gzanah'],
        'cutt_to_quantity' => $_POST['cutt_to_quantity'],
        'cutt_to_gzanah_type' => $_POST['cutt_to_gzanah_type'],
    ];


    // Convert the array to JSON
    $jsonData1 = json_encode($formData1);
    $jsonData2 = json_encode($formData2);



    if (empty($cutt_id)) {
        $cuttingDataInsert = "INSERT INTO `cutting_voucher`(`user_id`, `updated_user_id`, `cutt_production_id`,`status`, `cutt_voucher_date`, `cutt_party_name`, `cutt_voucher_location`, `cutt_dyeing_lat_no`, `cutt_volume_no`, `cutting_delivery_date`, `cutt_voucher_remarks`,  `cutting_from_list`, `cutting_to_list`) VALUES ('$user_id','$user_id','$ProductionID','$cutt_status','$cutting_date','$cutt_party_name','$cutt_location','$cutt_dyeing_lat_no','$cutt_volume_no','$cutting_delivery_date','$cutt_remarks','$jsonData1','$jsonData2')";
        $cuttingQuery = mysqli_query($dbc, $cuttingDataInsert);

        if ($cuttingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $updateCuttVoucher = mysqli_query($dbc, "UPDATE `cutting_voucher` SET 
        `updated_user_id` = '$user_id', 
        `cutt_production_id` = '$ProductionID', 
        `status` = '$cutt_status', 
        `cutt_voucher_date` = '$cutting_date', 
        `cutt_party_name` = '$cutt_party_name', 
        `cutt_voucher_location` = '$cutt_location', 
        `cutt_dyeing_lat_no` = '$cutt_dyeing_lat_no', 
        `cutt_volume_no` = '$cutt_volume_no', 
        `cutting_delivery_date` = '$cutting_delivery_date', 
        `cutt_voucher_remarks` = '$cutt_remarks', 
        `cutting_from_list`='$jsonData1',
        `cutting_to_list`='$jsonData2' 
        WHERE id = $cutt_id");

        if ($updateCuttVoucher) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}
?>
<style>
    .nav-list {
        font-size: 25px;
    }

    .bg-custom {
        background-color: #E1E1E1;
    }
</style>

<body class="horizontal light  ">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>

        <div class="container-fluid m-0 p-0">
            <div class="card m-0">
                <div class="card-header card-bg" align="center">
                    <div class="row">
                        <div class="col-12 mx-auto h4">
                            <b class="text-center card-text">Cutting</b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class=" bg-white rounded shadow mb-5">
                        <ul id="myTab" role="tablist" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-custom border-0 rounded-nav">
                            <li class="nav-item flex-sm-fill">
                                <a id="profile-tab" data-toggle="tab" href="#from" role="tab" aria-controls="from" aria-selected="true" class="nav-link border-0 font-weight-bold active nav-list">From</a>
                            </li>
                            <li class="nav-item flex-sm-fill">
                                <a id="contact-tab" data-toggle="tab" href="#to" role="tab" aria-controls="to" aria-selected="false" class="nav-link border-0 font-weight-bold nav-list">To</a>
                            </li>
                        </ul>
                    </div>
                    <div id="myTabContent" class="tab-content">
                        <div id="from" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 pb-5 show active">
                            <form action="" id="cutt_voucher_form" method="post">
                                <input type="hidden" id="hiddenInput1" value="<?= @$cuttingDatafetch['id'] ?>" name="cutt_id">
                                <input type="hidden" id="hiddenInput1" value="from" name="cutt_status">
                                <div class="row pb-2">
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="cutting_date">Date</label>
                                        <input type="date" class="form-control" name="cutting_date" id="cutting_date">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="cutt_party_name">Party Name</label>

                                        <select class="form-control searchableSelect" name="cutt_party_name" id="cutt_party_name">
                                            <option value="">Party Name</option>
                                            <?php

                                            $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1 ");
                                            while ($row = mysqli_fetch_array($result)) {

                                            ?>
                                                <option <?= (@$cuttingDatafetch['cutt_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                    <?php echo  ucwords($row["customer_name"]) ?>
                                                    (<?= ucwords($row['customer_type']) ?>)
                                                </option>

                                            <?php   } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Dyeing Lat No">Dyeing Lat No</label>
                                        <input type="text" class="form-control" name="cutt_dyeing_lat_no" id="cutt_dyeing_lat_no" placeholder="Dyeing Lat No">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                        <input type="text" class="form-control" name="cutt_volume_no" id="cutt_volume_no" placeholder="Volume No">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Location">Location</label>
                                        <input type="text" class="form-control" name="cutt_location" id="cutt_location" placeholder="Location">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                        <input type="Date" class="form-control" name="cutting_delivery_date" id="cutting_delivery_date" placeholder="Location">
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                        <textarea name="cutt_remarks" id="cutt_remarks" placeholder="Remarks" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col">
                                        <h4>
                                            List
                                        </h4>
                                    </div>
                                </div>
                                <div id="container">
                                    <div class="card py-3">
                                        <div id="voucher_rows_container2">
                                            <div class="voucher_row2">

                                                <div class="row mt-3 m-0 p-3">

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                        <div class="col-12 m-0 p-0 pr-2">
                                                            <label class=" font-weight-bold text-dark" for="cutting_from_product">Quality</label>

                                                            <select class="form-control" name="cutting_from_product[]">
                                                                <option value="">Select Product</option>
                                                                <?php
                                                                $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                $product_ids2 = array();

                                                                while ($rowdata = mysqli_fetch_array($purchase_data2)) {
                                                                    $product_id2 = $rowdata['product_id'];
                                                                    $product_ids2[] = $product_id2;

                                                                    $purchase_data3 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id2");

                                                                    while ($rowdata3 = mysqli_fetch_array($purchase_data3)) {
                                                                        $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata3['brand_id']);
                                                                        $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata3['category_id']);
                                                                ?>


                                                                        <option <?= (@$lowerdata->cutting_from_product[$x] == $rowdata3["product_id"]) ? 'selected' : ''; ?> data-price="<?= $rowdata3["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata3["product_id"] ?>">
                                                                            <?= ucwords($rowdata3["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                        </option>

                                                                <?php   }
                                                                } ?>
                                                            </select>

                                                        </div>

                                                    </div>




                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Thaan</label>
                                                        <input type="text" class="form-control thaan" value="<?= @$lowerdata->cutt_thaan[$x] ?>" name="cutt_from_thaan[]" placeholder="Thaan">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Gzanah</label>
                                                        <input type="text" class="form-control gzanah" value="<?= @$lowerdata->cutt_gzanah[$x] ?>" name="cutt_form_gzanah[]" placeholder="Gzanah">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Quantity</label>
                                                        <input type="text" class="form-control quantity" value="<?= @$lowerdata->cutt_quantity[$x] ?>" name="cutt_from_quantity[]" value="0" placeholder="Quanitity">
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <div class="form-group mb-0">
                                                            <label class="font-weight-bold text-dark">Type</label>
                                                            <input type="text" class="form-control" id="cutt_gzanah_type" name="cutt_from_gzanah_type[]" placeholder="Type" required value="<?= @$lowerdata->cutt_gzanah_type[$x] ?>">
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
                                        <div class="row m-0 p-0 my-4 justify-content-end">
                                            <div class="col-lg-1">
                                                <div id="cutt_voucher_btn">
                                                    <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_duplicateRow()">
                                                        <img src="img/add.png" width="30px" alt="add sign">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  justify-content-end mt-3">
                                    <div class="col-lg-1 d-inline text-left p-0">

                                        <!-- <a target="_blank" href="print.php?production=<?= $ProductionID ?>&type=cutting" id="showData1">
                                            <div class="btn btn-primary">
                                                <i class="fa fa-print"></i> Print
                                            </div>
                                        </a> -->

                                        <input class="btn btn-success" type="submit" value="Save" name="cutting_btn">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div id="to" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 pb-5">
                            <form action="" id="cutt_voucher_form" method="post">
                                <input type="hidden" id="hiddenInput1" value="<?= @$cuttingDatafetch['id'] ?>" name="cutt_id">
                                <input type="hidden" id="hiddenInput1" value="to" name="cutt_status">
                                <div class="row pb-2">
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="cutting_date">Date</label>
                                        <input type="date" class="form-control" name="cutting_date" id="cutting_date">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="cutt_party_name">Party Name</label>

                                        <select class="form-control searchableSelect" name="cutt_party_name" id="cutt_party_name">
                                            <option value="">Party Name</option>
                                            <?php

                                            $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1 ");
                                            while ($row = mysqli_fetch_array($result)) {

                                            ?>
                                                <option <?= (@$cuttingDatafetch['cutt_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                    <?php echo  ucwords($row["customer_name"]) ?>
                                                    (<?= ucwords($row['customer_type']) ?>)
                                                </option>

                                            <?php   } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Dyeing Lat No">Dyeing Lat No</label>
                                        <input type="text" class="form-control" name="cutt_dyeing_lat_no" id="cutt_dyeing_lat_no" placeholder="Dyeing Lat No">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                        <input type="text" class="form-control" name="cutt_volume_no" id="cutt_volume_no" placeholder="Volume No">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Location">Location</label>
                                        <input type="text" class="form-control" name="cutt_location" id="cutt_location" placeholder="Location">
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                        <input type="Date" class="form-control" name="cutting_delivery_date" id="cutting_delivery_date" placeholder="Location">
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                        <textarea name="cutt_remarks" id="cutt_remarks" placeholder="Remarks" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col">
                                        <h4>
                                            List
                                        </h4>
                                    </div>
                                </div>
                                <div id="container">
                                    <div class="card py-3">
                                        <div id="voucher_rows_container">
                                            <div class="voucher_row">
                                                <div class="row mt-3 m-0 p-0">

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                        <div class="col-11 m-0 p-0 pr-2">
                                                            <label class="font-weight-bold text-dark" for="cutting_to_product">Quality</label>
                                                            <select class="form-control " name="cutting_to_product[]">
                                                                <option value="">Select Product</option>
                                                                <?php
                                                                $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                                    $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                                ?>
                                                                    <option value="<?= $row["product_id"] ?>">
                                                                        <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-1 m-0 p-0 mt-1">
                                                            <label class="invisible d-block">.</label>
                                                            <button type="button" class="btn btn-danger btn-sm pt-1 pb-1" data-toggle="modal" data-target="#add_product_modal">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Thaan</label>
                                                        <input type="text" class="form-control thaan" name="cutt_to_thaan[]" placeholder="Thaan">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Gzanah</label>
                                                        <input type="text" class="form-control gzanah" name="cutt_to_gzanah[]" placeholder="Gzanah">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Quantity</label>
                                                        <input type="text" class="form-control quantity" name="cutt_to_quantity[]" value="0" placeholder="Quantity">
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                        <label>Type</label>
                                                        <input type="text" class="form-control" name="cutt_to_gzanah_type[]" placeholder="Type" required>
                                                    </div>

                                                    <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                        <button type="button" class="outline_none mt-4 border-0 bg-white" onclick="cutt_voucher_remove2(this)">
                                                            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0 p-0 my-4 pr-5 justify-content-end">
                                            <div cs="col-lg-1">
                                                <div id="cutt_voucher_btn">
                                                    <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_duplicateRow2()">
                                                        <img src="img/add.png" width="30px" alt="add sign">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  justify-content-end mt-3">
                                    <div class="col-lg-1 d-inline text-left p-0 ml-auto">

                                        <!-- <a target="_blank" href="print.php?production=<?= $ProductionID ?>&type=cutting" id="showData1">
                                            <div class="btn btn-primary">
                                                <i class="fa fa-print"></i> Print
                                            </div>
                                        </a> -->

                                        <input class="btn btn-success" type="submit" value="Save" name="cutting_btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
<?php
include_once 'includes/foot.php';
?>
<script>
    $(document).ready(function() {

        function calculateQuantity($row) {
            var thaan = parseFloat($row.find('.thaan').val()) || 0;
            var gzanah = parseFloat($row.find('.gzanah').val()) || 0;
            var quantity = thaan * gzanah;
            $row.find('.quantity').val(quantity);
        }

        $(document).on('input', '.thaan, .gzanah', function() {
            var $row = $(this).closest('.row');
            calculateQuantity($row);
        });
    });
</script>
<script>
    $(document).ready(function() {
        function updateHash(tabId) {
            if (history.pushState) {
                history.pushState(null, null, tabId);
            } else {
                location.hash = tabId;
            }
        }

        var hash = window.location.hash;
        if (hash) {
            $('a[href="' + hash + '"]').tab('show');
        } else {
            $('a[href=" #sending"]').tab('show');
        }

        $('a[data-toggle="tab" ]').on('click', function(e) {
            var newHash = $(this).attr('href');
            updateHash(newHash);
        });

        $(window).on('hashchange', function() {
            var newHash = window.location.hash;
            if (newHash) {
                $('a[href="' + newHash + '" ]').tab('show');
            }
        });
    });
</script>