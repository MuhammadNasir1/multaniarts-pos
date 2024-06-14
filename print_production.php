<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);
// exit;


$d = $_REQUEST['print'];


if (@$_REQUEST['print']) {
    $upd_id = $_REQUEST['print'];
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'production') {
        $printProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE production_id =  $upd_id"));
    }

    // Cutting Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'cutting') {
        $cuttVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `cutting_voucher` WHERE cutt_production_id =  $upd_id"));
        $cuttId = @$cuttVoucherProduction['cutt_voucher_quality'];
        $cuttProduct = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM product WHERE product_id = @$cuttId"));
    }

    // Print Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'print_voucher') {
        $printVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `print_voucher` WHERE print_production_id =  $upd_id"));
        $printProductNameId = @$printVoucherProduction['print_quality'];
        $printCustNameId = @$printVoucherProduction['print_party_name'];
        $printProduct = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$printProductNameId'"));
        $printCustName = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `customers` WHERE customer_id = '$printCustNameId'"));
    }

    // Dyeing Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'deyeing') {
        $dyeingVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $upd_id"));
        $dyeingCustNameId = @$dyeingVoucherProduction['dey_party_name'];
        $dyeingCustName = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `customers` WHERE customer_id = '$dyeingCustNameId'"));
    }

    // Single Print Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'single_print') {
        $singlePrintVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `single_print` WHERE single_production_id =  $upd_id"));
        $singlePrintCustNameId = @$singlePrintVoucherProduction['single_party_name'];
        $singlePrintCustName = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `customers` WHERE customer_id = '$singlePrintCustNameId'"));
    }

    // embroidery_voucher  Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'embroidery') {
        $embroideryVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `embroidery_voucher` WHERE emb_production_id =  $upd_id"));
    }

    // Collect Embroidery  Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'collect_embroidery') {
        $collectEmbProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM  `collect_embroid_voucher` WHERE coll_production_id =  $upd_id"));
    }

    // Stiching & Packing Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'stiching_packing') {
        $sti_pakVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `stiching_voucher` WHERE stiching_production_id =  $upd_id"));
        $sti_pakProductNameId = @$sti_pakVoucherProduction['stiching_qlty'];
        $sti_pakCustNameId = @$sti_pakVoucherProduction['stiching_party_no'];
        $sti_pakProduct = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$sti_pakProductNameId'"));
        $sti_pakCustName = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `customers` WHERE customer_id = '$sti_pakCustNameId'"));
    }

    // Calender Salender Voucher Data
    if (@$_GET['type'] == 'all' || @$_GET['part'] == 'calender_salender') {
        $cal_calVoucherProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `calander_satander` WHERE cal_sat_production_id =  $upd_id"));
        $cal_calId = @$cal_calVoucherProduction['cal_sat_qlty'];
        $cal_calProduct = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$cal_calId'"));
    }
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
            <h2 class="m-0">Production # <?= @$d ?></h2>
        </header>

        <!-- Production Details -->

        <input type="hidden" id="hiddenInput1" value="<?= @$printProduction['production_id'] ?>">
        <div class="mt-3" id="showData1">
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
        <input type="hidden" id="hiddenInput2" value="<?= @$cuttVoucherProduction['id'] ?>">
        <div class="mt-3" id="showData2">

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


                        <p class="m-0"><?= @$printProduct['product_name'] ?></p>

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
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Design No</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_designe_no[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Quantity</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_type[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Gzanah</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_gzanah[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Type</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata->cutt_gzanah_type[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col text-white <?php if (@$lowerdata->cutt_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?>  border">
                                <p class="m-0"><?= @$lowerdata->cutt_status[$x] ?></p>
                            </div>
                        </div>


                    </div>
            <?php
                }
            }
            ?>

        </div>

        <!-- Print Voucher Details -->
        <input type="hidden" id="hiddenInput3" value="<?= @$printVoucherProduction['id'] ?>">

        <div class="mt-3" id="showData3">
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
                        <p class="m-0"><?= ucwords(@$printCustName['customer_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quality</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$printProduct['product_name'] ?></p>
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

            <?php
            if (@$printVoucherProduction != 0) {
                $lowerdata2 = json_decode(@$printVoucherProduction['print_list']);
                for ($x = 0; $x < count(@$lowerdata2->print_quantity); $x++) {

            ?>

                    <div class="container-fluid mt-3">

                        <div class="row m-0 p-0">
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Quantity</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata2->print_quantity[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Name</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata2->print_quantity_name[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col  text-white <?php if (@$lowerdata2->print_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?> text-black border">
                                <p class="m-0"><?= @$lowerdata2->print_status[$x] ?></p>
                            </div>

                        </div>



                    </div>
            <?php
                }
            }
            ?>

        </div>

        <!-- Dyeing Voucher Details -->

        <input type="hidden" id="hiddenInput4" value="<?= @$dyeingVoucherProduction['id'] ?>">

        <div class="mt-3" id="showData4">
            <h2>Dyeing Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Gate Pass No.</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_gate_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Lat no.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_lat_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Party Name</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingCustName['customer_name']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Party Voucher No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_voucher_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Qty</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_qty'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Ready Qty.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_ready_qty'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">C-P</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$dyeingVoucherProduction['dey_c_p'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Color Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingVoucherProduction['dey_color_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Color</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingVoucherProduction['dey_color']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Thaan</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingVoucherProduction['dey_thaan']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Location</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingVoucherProduction['dey_location']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-9  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$dyeingVoucherProduction['dey_remarks']) ?></p>
                    </div>

                </div>

            </div>
        </div>

        <!-- Single Print Voucher Details -->
        <input type="hidden" id="hiddenInput5" value="<?= @$singlePrintVoucherProduction['id'] ?>">
        <div class="mt-3" id="showData5">
            <h2>Print Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Party Name</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintCustName['customer_name'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Lat No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_lat_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quantity</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_quantity'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Gate Pass No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_gate_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Design No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_design_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Design Qty</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_design_qty'] ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$singlePrintVoucherProduction['single_remarks']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Location</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$singlePrintVoucherProduction['single_location']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Cut Pieces</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$singlePrintVoucherProduction['single_cut_pieces'] ?></p>
                    </div>
                </div>


            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>

            <?php
            if (@$singlePrintVoucherProduction != 0) {
                $lowerdata3 = json_decode(@$singlePrintVoucherProduction['single_list']);
                for ($x = 0; $x < count(@$lowerdata3->singleprint_dp_no); $x++) {

            ?>

                    <div class="container-fluid mt-3">
                        <div class="row m-0 p-0">
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">DP No</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata3->singleprint_dp_no[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Type</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata3->singleprint_type[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Type Name</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata3->singleprint_type_name[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col  text-white <?php if (@$lowerdata3->print2_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?> text-black border">
                                <p class="m-0"><?= @$lowerdata3->print2_status[$x] ?></p>
                            </div>

                        </div>



                    </div>
            <?php
                }
            }
            ?>

        </div>
        <!-- embroidery_voucher Voucher Details -->
        <input type="hidden" id="hiddenInput6" value="<?= @$embroideryVoucherProduction['id'] ?>">
        <div class="mt-3" id="showData6">
            <h2>Insuance Embroidery Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Out Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$embroideryVoucherProduction['emb_out_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Gate Pass No.</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$embroideryVoucherProduction['emb_gate_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Volume No</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$embroideryVoucherProduction['emb_volume_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Design No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$embroideryVoucherProduction['emb_design_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Embroider Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$embroideryVoucherProduction['emb_embroider_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Total Dress</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$embroideryVoucherProduction['emb_total_dress']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Details Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$embroideryVoucherProduction['emb_details_name']) ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$embroideryVoucherProduction['emb_remarks']) ?></p>
                    </div>
                </div>

            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>

            <?php
            if (@$embroideryVoucherProduction != 0) {
                $lowerdata4 = json_decode(@$embroideryVoucherProduction['emb_list']);
                for ($x = 0; $x < count(@$lowerdata4->embroid_type); $x++) {

            ?>

                    <div class="container-fluid mt-3">
                        <div class="row m-0 p-0">
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Quantity</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata4->embroid_type[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Name</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata4->embroid_type_name[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Print</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata4->embroid_gzanah[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Type</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata4->embroid_gzanah_type[$x] ?></p>
                            </div>


                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col  text-white <?php if (@$lowerdata4->emb_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?> text-black border">
                                <p class="m-0"><?= @$lowerdata4->emb_status[$x] ?></p>
                            </div>


                        </div>



                    </div>
            <?php
                }
            }
            ?>

        </div>



        <!-- embroidery_voucher Voucher Details -->
        <input type="hidden" id="hiddenInput7" value="<?= @$collectEmbProduction['id'] ?>">
        <div class="mt-3" id="showData7">
            <h2>Recieving Embroidery Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Gate Pass No.</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_gate_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Party Pass No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_party_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Design No</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_design_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Embroider Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$collectEmbProduction['coll_emb_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Design Qty</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_design_qty'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Volume No</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$collectEmbProduction['coll_volume_no'] ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Details Yards</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$collectEmbProduction['coll_details_yards']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Location</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$collectEmbProduction['coll_location']) ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$collectEmbProduction['coll_remarks']) ?></p>
                    </div>
                </div>

            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>

            <?php
            if (@$collectEmbProduction != 0) {
                $lowerdata5 = json_decode(@$collectEmbProduction['coll_list']);
                for ($x = 0; $x < count(@$lowerdata5->collect_embroid_type); $x++) {

            ?>

                    <div class="container-fluid mt-3">
                        <div class="row m-0 p-0">
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Quantity</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata5->collect_embroid_type[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Name</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata5->collect_embroid_type_name[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Print</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata5->collect_embroid_gzanah[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Type</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata5->collect_embroid_gzanah_type[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col  text-white <?php if (@$lowerdata5->collect_embroid_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?> text-black border">
                                <p class="m-0"><?= @$lowerdata5->collect_embroid_status[$x] ?></p>
                            </div>


                        </div>



                    </div>
            <?php
                }
            }
            ?>

        </div>
        <!-- Stiching & Packing Voucher Details -->
        <input type="hidden" id="hiddenInput8" value="<?= @$sti_pakVoucherProduction['id'] ?>">
        <div class="mt-3" id="showData8">
            <h2>Stiching & Packing Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakVoucherProduction['stiching_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quality</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakProduct['product_name'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Gate Pass No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakVoucherProduction['stiching_gate_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Party Name</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakCustName['customer_name'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Details Name</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$sti_pakVoucherProduction['stiching_details_name']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Stock</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$sti_pakVoucherProduction['stiching_stock']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Status</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakVoucherProduction['stiching_status'] ?></p>
                    </div>

                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Volume No</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$sti_pakVoucherProduction['stiching_volume_no'] ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-9  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$sti_pakVoucherProduction['stiching_remarks']) ?></p>
                    </div>
                </div>

            </div>

            <h1 class="pt-4 pb-2 pl-3">List:-</h1>

            <?php
            if (@$sti_pakVoucherProduction != 0) {
                $lowerdata6 = json_decode(@$sti_pakVoucherProduction['stiching_list']);
                for ($x = 0; $x < count(@$lowerdata6->stiching_type); $x++) {

            ?>

                    <div class="container-fluid mt-3">
                        <div class="row m-0 p-0">
                            <div class="col  bg-secondary text-white border">
                                <p class="m-0"><?= $x + 1 ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Quantity</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata6->stiching_type[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0">Name</h3>

                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata6->stiching_type_name[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Print</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata6->stiching_gzanah[$x] ?></p>
                            </div>
                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Type</h3>
                            </div>
                            <div class="col  bg-white text-black border">
                                <p class="m-0"><?= @$lowerdata6->stiching_gzanah_type[$x] ?></p>
                            </div>

                            <div class="col bg-gray text-black border">
                                <h3 class="m-0 fw-bold">Status</h3>
                            </div>
                            <div class="col  text-white <?php if (@$lowerdata6->stiching_status[$x] == 'Sent') { ?> bg-danger <?php } else { ?> bg-success <?php } ?> text-black border">
                                <p class="m-0"><?= @$lowerdata6->stiching_status[$x] ?></p>
                            </div>


                        </div>



                    </div>
            <?php
                }
            }
            ?>

        </div>

        <!-- Calander Stander Voucher Details -->

        <input type="hidden" id="hiddenInput9" value="<?= @$cal_calVoucherProduction['id'] ?>">
        <div class="mt-3" id="showData9">
            <h2>Calander & Stander Details</h2>

            <div class="container-fluid ">
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Date</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cal_calVoucherProduction['cal_sat_date'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Calander Name</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cal_calVoucherProduction['cal_sat_cal_name']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Gate Pass No.</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= @$cal_calVoucherProduction['cal_sat_gate_no'] ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Quality</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cal_calProduct['product_name']) ?></p>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Gazana</h3>
                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cal_calVoucherProduction['cal_sat_gazana']) ?></p>
                    </div>
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0">Thaan</h3>

                    </div>
                    <div class="col-3  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cal_calVoucherProduction['cal_sat_thaan']) ?></p>
                    </div>
                </div>

                <div class="row m-0 p-0">
                    <div class="col-3 bg-gray text-black border">
                        <h3 class="m-0 fw-bold">Remarks</h3>
                    </div>
                    <div class="col-9  bg-white text-black border">
                        <p class="m-0"><?= ucwords(@$cal_calVoucherProduction['cal_sat_remarks']) ?></p>
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
    for (let i = 1; i <= 9; i++) {
        if (document.getElementById('hiddenInput' + i).value == '') {
            document.getElementById('showData' + i).style.display = 'none';
        } else {
            document.getElementById('showData' + i).style.display = 'block';
        }
    }

    window.print();
</script>