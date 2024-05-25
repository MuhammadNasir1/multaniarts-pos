<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);

if (@$_REQUEST['print']) {
    $upd_id = $_REQUEST['print'];
    $printProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE production_id =  $upd_id"));

    // Cutting Voucher Data

    $cuttVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `cutting_voucher` WHERE cutt_production_id =  $upd_id"));
    $cuttId = @$cuttVoucherProduction['cutt_voucher_quality'];
    $cuttProduct = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM product WHERE product_id = @$cuttId"));

    // Print Voucher Data
    $printVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `print_voucher` WHERE print_production_id =  $upd_id"));
}
?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;

    }



    .print-production header h2 {
        background-color: #000000;
        color: #fff;
        padding: 15px 0px;

    }

    .print-production h2 {
        font-size: 25px !important;
        color: #928878;
        letter-spacing: 1px;
        text-align: center;
        color: #000000;
        padding: 10px 0px;
    }

    .print-production h1 {
        font-size: 25px !important;
        color: #928878;
        letter-spacing: 1px;
        color: #000000;
    }


    table {
        width: 100%;
        padding: 0px 10px;
        margin: auto;
        text-align: center;
    }

    thead {
        background-color: #000000;
        color: #fff;
        font-weight: bold;
    }

    tbody td {
        text-wrap: wrap;
    }

    .print-detail {
        width: 20%;
        padding: 0px 10px;
    }

    .print-production h3,
    p {
        font-size: 15px;
        padding: 10px 0px;
    }
</style>

<body>

    <div class="print-production">
        <header>
            <h2 class="m-0">Production # <?= @$printProduction['production_id'] ?></h2>
        </header>


        <!-- Production Details -->

        <!-- <div class="mt-5"> -->
        <!-- <h2>Production Details</h2> -->
        <!-- <table class="table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="py-3">Date</th>
                        <th>Lat No</th>
                        <th>Production Name</th>
                        <th>Cost</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2"><?= @$printProduction['production_date'] ?></td>
                        <td><?= @$printProduction['production_lat_no'] ?></td>
                        <td><?= @$printProduction['production_name'] ?></td>
                        <td><?= @$printProduction['production_cost'] ?></td>
                        <td><?= @$printProduction['customer'] ?></td>
                        <td class="print-detail"><?= @$printProduction['customer_address'] ?></td>
                    </tr>
                </tbody>
            </table> -->
        <!-- </div> -->

        <!-- Cutting Voucher Details -->





        <div class="mt-3">
            <h2>Production Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printProduction['production_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Lat No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printProduction['production_lat_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Production Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printProduction['production_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Cost</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printProduction['production_cost'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Customer Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printProduction['customer']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Customer Address</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printProduction['customer_address']) ?></p>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3">
            <h2>Cutting Voucher Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cuttVoucherProduction['cutt_voucher_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quality</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cuttProduct['product_name'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Thaan</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cuttVoucherProduction['cutt_thaan']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Location</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cuttVoucherProduction['cutt_voucher_location']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Dyeing Lat No</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cuttVoucherProduction['cutt_dyeing_lat_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Volume No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cuttVoucherProduction['cutt_volume_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-9  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cuttVoucherProduction['cutt_voucher_remarks']) ?></p>
                    </div>

                </div>

            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>

            <?php
            if (@$cuttVoucherProduction != 0) {
                $lowerdata = json_decode(@$cuttVoucherProduction['cutting_vouc_list']);
                for ($x = 0; $x < count(@$lowerdata->cutt_designe_no); $x++) {

            ?>

                    <div class="container-fluid mt-3">
                        <div class="row m-0 p-0">
                            <div class="col-3 bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Design No</h3>
                            </div>
                            <div class="col-3  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_designe_no[$x] ?></p>
                            </div>
                            <div class="col-3 bg-gray text-black border">
                                <h3 class="m-0">Quantity</h3>

                            </div>
                            <div class="col-3  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_type[$x] ?></p>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-3 bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Gzanah</h3>
                            </div>
                            <div class="col-3  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_gzanah[$x] ?></p>
                            </div>
                            <div class="col-3 bg-gray text-black border">
                                <h3 class="m-0">Type</h3>

                            </div>
                            <div class="col-3  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_gzanah_type[$x] ?></p>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-3 bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col-9  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_status[$x] ?></p>
                            </div>
                        </div>


                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>Print Voucher Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Gate Pass No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_gate_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Party Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printVoucherProduction['print_party_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quality</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printVoucherProduction['print_quality']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Quantity</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_quantity'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Voucher</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_voucher'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Volume No</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printVoucherProduction['print_volume_no']) ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Name Gzanah</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_gzanah'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Qty (M)</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_qty'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Location</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printVoucherProduction['print_location'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Remarks</h3>

                    </div>
                    <div class="col-9  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$printVoucherProduction['print_remarks']) ?></p>
                    </div>
                </div>

            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>


        </div>







</body>

</html>
<?php
include_once 'includes/foot.php';
?>