<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);

if (!empty($_REQUEST['ProductionID']) && isset($_REQUEST['ProductionID'])) {

    $ProductionID = base64_decode($_REQUEST['ProductionID']);

    $dataproduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE `production_id` = '$ProductionID'"));

    // print_r($dataproduction);
}

//Cutting Data
$cuttingDatafetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `cutting_voucher` WHERE cutt_production_id =  $ProductionID"));

//Print Voucher Data
$printfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `print_voucher` WHERE print_production_id =  $ProductionID"));

//Print Voucher Data
$printfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `print_voucher` WHERE print_production_id =  $ProductionID"));

//deyeing Voucher Data
$deyeingfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `deyeing` WHERE dey_production_id =  $ProductionID"));

//Single Print Voucher Data
$singlePrintfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `single_print` WHERE single_production_id =  $ProductionID"));

//embroidery_voucher Voucher Data
$embroideryVoucherfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `embroidery_voucher` WHERE emb_production_id =  $ProductionID"));

// Collect embroidery_voucher Voucher Data
$collectEmbroideryfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `collect_embroid_voucher` WHERE coll_production_id =  $ProductionID"));

// stiching Voucher Data
$stichingfetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `stiching_voucher` WHERE stiching_production_id =  $ProductionID"));

// stiching Voucher Data
$cal_salFetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `calander_satander` WHERE cal_sat_production_id =  $ProductionID"));


// Cutting Data Insert

if (isset($_POST['cutting_btn'])) {
    $cutt_id = $_POST['cutt_id'];
    $cutting_date = $_POST['cutting_date'];
    $cutt_qty = $_POST['cutt_qty'];
    $cutt_thaan = $_POST['cutt_thaan'];
    $cutt_location = $_POST['cutt_location'];
    $cutt_dyeing_lat_no = $_POST['cutt_dyeing_lat_no'];
    $cutt_volume_no = $_POST['cutt_volume_no'];
    $cutt_remarks = $_POST['cutt_remarks'];


    $formData = [
        'cutt_designe_no' => $_POST['cutt_designe_no'],
        'cutt_type' => $_POST['cutt_type'],
        'cutt_gzanah' => $_POST['cutt_gzanah'],
        'cutt_gzanah_type' => $_POST['cutt_gzanah_type'],
        'cutt_status' => $_POST['cutt_status']
    ];


    // Convert the array to JSON
    $jsonData = json_encode($formData);





    if (empty($cutt_id)) {
        $cuttingDataInsert = "INSERT INTO `cutting_voucher`(`cutt_production_id`, `cutt_voucher_date`, `cutt_voucher_quality`, `cutt_thaan`, `cutt_voucher_location`, `cutt_dyeing_lat_no`, `cutt_volume_no`, `cutt_voucher_remarks`, `cutting_vouc_list`) VALUES ('$ProductionID','$cutting_date','$cutt_qty','$cutt_thaan','$cutt_location','$cutt_dyeing_lat_no','$cutt_volume_no','$cutt_remarks','$jsonData')";
        $cuttingQuery = mysqli_query($dbc, $cuttingDataInsert);
        if ($cuttingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $updateCuttVoucher = mysqli_query($dbc, "UPDATE `cutting_voucher` SET `cutt_voucher_quality`='$cutt_qty',`cutt_thaan`='$cutt_thaan',`cutt_voucher_location`='$cutt_location',`cutt_dyeing_lat_no`='$cutt_dyeing_lat_no',`cutt_volume_no`='$cutt_volume_no',`cutt_voucher_remarks`='$cutt_remarks',`cutting_vouc_list`='$jsonData' WHERE id = $cutt_id");
        if ($updateCuttVoucher) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}



// Print Data Insert

if (isset($_POST['print_btn'])) {
    $print_id = $_POST['print_id'];
    $print_date = $_POST['print_date'];
    $print_gate_no = $_POST['print_gate_no'];
    $print_party_name = $_POST['print_party_name'];
    $print_quality = $_POST['print_quality'];
    $print_v_quantity = $_POST['print_v_quantity'];
    $print_voucher = $_POST['print_voucher'];
    $print_volume_no = $_POST['print_volume_no'];
    $print_name_gzanah = $_POST['print_name_gzanah'];
    $print_qty_m = $_POST['print_qty_m'];
    $print_location = $_POST['print_location'];
    $print_remarks = $_POST['print_remarks'];

    // Print Data List
    $printData = [
        'print_quantity' => $_POST['print_quantity'],
        'print_quantity_name' => $_POST['print_quantity_name'],
        'print_status' => $_POST['print_status']
    ];
    $printJson = json_encode($printData);


    if (empty($print_id)) {
        $printDataInsert = "INSERT INTO `print_voucher`(`print_production_id`, `print_date`, `print_gate_no`, `print_party_name`, `print_quality`, `print_quantity`, `print_voucher`, `print_volume_no`, `print_gzanah`, `print_qty`, `print_location`, `print_remarks`, `print_list`) VALUES ('$ProductionID','$print_date','$print_gate_no','$print_party_name','$print_quality','$print_v_quantity','$print_voucher','$print_volume_no','$print_name_gzanah','$print_qty_m','$print_location','$print_remarks','$printJson')";
        $printQuery = mysqli_query($dbc, $printDataInsert);

        if ($printQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $printUpdate = mysqli_query($dbc, "UPDATE `print_voucher` SET `print_gate_no`='$print_gate_no',`print_party_name`='$print_party_name',`print_quality`='$print_quality',`print_quantity`='$print_v_quantity',`print_voucher`='$print_voucher',`print_volume_no`='$print_volume_no',`print_gzanah`='$print_name_gzanah',`print_qty`='$print_qty_m',`print_location`='$print_location',`print_remarks`='$print_remarks',`print_list`='$printJson' WHERE id = $print_id");
        if ($printUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

// Deyeing Data Insert

if (isset($_POST['dyeing_btn'])) {
    $deyeing_id = $_POST['deyeing_id'];
    $dyeing_date = $_POST['dyeing_date'];
    $dyeing_gate_no = $_POST['dyeing_gate_no'];
    $dyeing_lat_name = $_POST['dyeing_lat_name'];
    $dyeing_party_name = $_POST['dyeing_party_name'];
    $dyeing_party_voucher = $_POST['dyeing_party_voucher'];
    $dyeing_qty = $_POST['dyeing_qty'];
    $dyeing_readyqty = $_POST['dyeing_readyqty'];
    $dyeing_cp = $_POST['dyeing_cp'];
    $dyeing_color_name = $_POST['dyeing_color_name'];
    $dyeing_color = $_POST['dyeing_color'];
    $dyeing_thaan = $_POST['dyeing_thaan'];
    $dyeing_location = $_POST['dyeing_location'];
    $dyeing_remarks = $_POST['dyeing_remarks'];




    if (empty($deyeing_id)) {
        $deyeingDataInsert = "INSERT INTO `deyeing`(`dey_production_id`, `dey_date`, `dey_gate_no`, `dey_lat_no`, `dey_party_name`, `dey_voucher_no`, `dey_qty`, `dey_ready_qty`, `dey_c_p`, `dey_color_name`, `dey_color`, `dey_thaan`, `dey_location`, `dey_remarks`) VALUES ('$ProductionID','$dyeing_date','$dyeing_gate_no','$dyeing_lat_name','$dyeing_party_name',' $dyeing_party_voucher','$dyeing_qty','$dyeing_readyqty','$dyeing_cp','$dyeing_color_name','$dyeing_color','$dyeing_thaan','$dyeing_location','$dyeing_remarks')";
        $deyeingQuery = mysqli_query($dbc, $deyeingDataInsert);

        if ($deyeingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $deyeingUpdate = mysqli_query($dbc, "UPDATE `deyeing` SET `dey_gate_no`='$dyeing_gate_no',`dey_lat_no`='$dyeing_lat_name',`dey_party_name`='$dyeing_party_name',`dey_voucher_no`='$dyeing_party_voucher',`dey_qty`='$dyeing_qty',`dey_ready_qty`='$dyeing_readyqty',`dey_c_p`='$dyeing_cp',`dey_color_name`='$dyeing_color_name',`dey_color`='$dyeing_color',`dey_thaan`='$dyeing_thaan',`dey_location`='$dyeing_location',`dey_remarks`='$dyeing_remarks' WHERE id = $deyeing_id");
        if ($deyeingUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

// Single Print Data Insert

if (isset($_POST['singleprint_btn'])) {
    $single_print_id = $_POST['single_print_id'];
    $singleprint_date = $_POST['singleprint_date'];
    $singleprint_party_name = $_POST['singleprint_party_name'];
    $singleprint_lat_no = $_POST['singleprint_lat_no'];
    $singleprint_quantity = $_POST['singleprint_quantity'];
    $singleprint_gate_no = $_POST['singleprint_gate_no'];
    $singleprint_design_no = $_POST['singleprint_design_no'];
    $singleprint_design_qty = $_POST['singleprint_design_qty'];
    $singleprint_remarks = $_POST['singleprint_remarks'];
    $singleprint_location = $_POST['singleprint_location'];
    $singleprint_cutpieces = $_POST['singleprint_cutpieces'];

    // Print Data List
    $singlePrintData = [
        'singleprint_dp_no' => $_POST['singleprint_dp_no'],
        'singleprint_type' => $_POST['singleprint_type'],
        'singleprint_type_name' => $_POST['singleprint_type_name'],
        'print2_status' => $_POST['print2_status']
    ];
    $singlePrintJson = json_encode($singlePrintData);




    if (empty($single_print_id)) {
        $singlePrintDataInsert = "INSERT INTO `single_print`(`single_production_id`, `single_date`, `single_party_name`, `single_lat_no`, `single_quantity`, `single_gate_no`, `single_design_no`, `single_design_qty`, `single_remarks`, `single_location`, `single_cut_pieces`, `single_list`) VALUES ('$ProductionID','$singleprint_date','$singleprint_party_name','$singleprint_lat_no','$singleprint_quantity','$singleprint_gate_no','$singleprint_design_no','$singleprint_design_qty','$singleprint_remarks','$singleprint_location','$singleprint_cutpieces','$singlePrintJson')";
        $singlePrintQuery = mysqli_query($dbc, $singlePrintDataInsert);

        if ($singlePrintQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $singlePrintDataUpdate = mysqli_query($dbc, "UPDATE `single_print` SET `single_party_name`='$singleprint_party_name',`single_lat_no`='$singleprint_lat_no',`single_quantity`='$singleprint_quantity',`single_gate_no`='$singleprint_gate_no',`single_design_no`='$singleprint_design_no',`single_design_qty`='$singleprint_design_qty',`single_remarks`='$singleprint_remarks',`single_location`='$singleprint_location',`single_cut_pieces`='$singleprint_cutpieces',`single_list`='$singlePrintJson' WHERE id = $single_print_id");
        if ($singlePrintDataUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}


// Embroidery Data Insrt

if (isset($_POST['embroidery_btn'])) {
    $embroidery_voucher_id = $_POST['embroidery_voucher_id'];
    $emb_out_date = $_POST['emb_out_date'];
    $emb_gate_no = $_POST['emb_gate_no'];
    $emb_volume_no = $_POST['emb_volume_no'];
    $emb_design_no = $_POST['emb_design_no'];
    $emb_embroider_name = $_POST['emb_embroider_name'];
    $emb_ttl_dress = $_POST['emb_ttl_dress'];
    $emb_detail_name = $_POST['emb_detail_name'];
    $emb_remarks = $_POST['emb_remarks'];


    $embData = [
        'embroid_type' => $_POST['embroid_type'],
        'embroid_type_name' => $_POST['embroid_type_name'],
        'embroid_gzanah' => $_POST['embroid_gzanah'],
        'embroid_gzanah_type' => $_POST['embroid_gzanah_type'],
        'emb_status' => $_POST['emb_status']
    ];

    // Convert the array to JSON
    $embDataJson = json_encode($embData);



    if (empty($embroidery_voucher_id)) {
        $embDataInsert = "INSERT INTO `embroidery_voucher`( `emb_production_id`, `emb_out_date`, `emb_gate_no`, `emb_volume_no`, `emb_design_no`, `emb_embroider_name`, `emb_total_dress`, `emb_details_name`, `emb_remarks`, `emb_list`) VALUES ('$ProductionID','$emb_out_date','$emb_gate_no','$emb_volume_no','$emb_design_no','$emb_embroider_name','$emb_ttl_dress','$emb_detail_name','$emb_remarks','$embDataJson')";
        $embQuery = mysqli_query($dbc, $embDataInsert);
        if ($embQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $embDataUpdate = mysqli_query($dbc, "UPDATE `embroidery_voucher` SET `emb_gate_no`='$emb_gate_no',`emb_volume_no`='$emb_volume_no',`emb_design_no`='$emb_design_no',`emb_embroider_name`='$emb_embroider_name',`emb_total_dress`='$emb_ttl_dress',`emb_details_name`='$emb_detail_name',`emb_remarks`='$emb_remarks',`emb_list`='$embDataJson' WHERE id = $embroidery_voucher_id");
        if ($embDataUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

//  Collect Embroidery Data Insrt

if (isset($_POST['collect_embroidery_btn'])) {
    $col_embroidery_id = $_POST['col_embroidery_id'];
    $coll_emb_date = $_POST['coll_emb_date'];
    $coll_gate_no = $_POST['coll_gate_no'];
    $coll_party_no = $_POST['coll_party_no'];
    $coll_design_no = $_POST['coll_design_no'];
    $coll_embroider_name = $_POST['coll_embroider_name'];
    $coll_des_qty = $_POST['coll_des_qty'];
    $coll_volume_no = $_POST['coll_volume_no'];
    $coll_detail_yard = $_POST['coll_detail_yard'];
    $coll_location = $_POST['coll_location'];
    $coll_remarks = $_POST['coll_remarks'];


    $colEmbData = [
        'collect_embroid_type' => $_POST['collect_embroid_type'],
        'collect_embroid_type_name' => $_POST['collect_embroid_type_name'],
        'collect_embroid_gzanah' => $_POST['collect_embroid_gzanah'],
        'collect_embroid_gzanah_type' => $_POST['collect_embroid_gzanah_type'],
        'collect_embroid_status' => $_POST['collect_embroid_status']
    ];

    // Convert the array to JSON
    $colEmbDataJson = json_encode($colEmbData);



    if (empty($col_embroidery_id)) {
        $colEmbDataInsert = "INSERT INTO `collect_embroid_voucher`( `coll_production_id`, `coll_date`, `coll_gate_no`, `coll_party_no`, `coll_design_no`, `coll_emb_name`, `coll_design_qty`, `coll_volume_no`, `coll_details_yards`, `coll_location`, `coll_remarks`, `coll_list`) VALUES ('$ProductionID','$coll_emb_date','$coll_gate_no','$coll_party_no','$coll_design_no','$coll_embroider_name','$coll_des_qty','$coll_volume_no','$coll_detail_yard','$coll_location','$coll_remarks','$colEmbDataJson')";
        $colEmbQuery = mysqli_query($dbc, $colEmbDataInsert);
        if ($colEmbQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $colEmbDataUpdate = mysqli_query($dbc, "UPDATE `collect_embroid_voucher` SET `coll_gate_no`='$coll_gate_no',`coll_party_no`='$coll_party_no',`coll_design_no`='$coll_design_no',`coll_emb_name`='$coll_embroider_name',`coll_design_qty`='$coll_des_qty',`coll_volume_no`='$coll_volume_no',`coll_details_yards`='$coll_detail_yard',`coll_location`='$coll_location',`coll_remarks`='$coll_remarks',`coll_list`='$colEmbDataJson' WHERE id = $col_embroidery_id");
        if ($colEmbDataUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

//  Stiching Data Insrt

if (isset($_POST['stitching_btn'])) {
    $stiching_id = $_POST['stiching_id'];
    $stiching_date = $_POST['stiching_date'];
    $stiching_qlty = $_POST['stiching_qlty'];
    $stiching_gate_no = $_POST['stiching_gate_no'];
    $stiching_party_name = $_POST['stiching_party_name'];
    $stiching_details_name = $_POST['stiching_details_name'];
    $stiching_stock = $_POST['stiching_stock'];
    $stiching_status_form = $_POST['stiching_status_form'];
    $stiching_vol_no = $_POST['stiching_vol_no'];
    $stiching_remarks = $_POST['stiching_remarks'];


    $stichingData = [
        'stiching_type' => $_POST['stiching_type'],
        'stiching_type_name' => $_POST['stiching_type_name'],
        'stiching_gzanah' => $_POST['stiching_gzanah'],
        'stiching_gzanah_type' => $_POST['stiching_gzanah_type'],
        'stiching_status' => $_POST['stiching_status']
    ];

    // Convert the array to JSON
    $stichingDataJson = json_encode($stichingData);



    if (empty($stiching_id)) {
        $stichingDataInsert = "INSERT INTO `stiching_voucher`( `stiching_production_id`, `stiching_date`, `stiching_qlty`, `stiching_gate_no`, `stiching_party_no`, `stiching_details_name`, `stiching_stock`, `stiching_status`, `stiching_volume_no`, `stiching_remarks`, `stiching_list`) VALUES ('$ProductionID','$stiching_date','$stiching_qlty','$stiching_gate_no','$stiching_party_name','$stiching_details_name','$stiching_stock','$stiching_status_form','$stiching_vol_no','$stiching_remarks','$stichingDataJson')";
        $stichingQuery = mysqli_query($dbc, $stichingDataInsert);
        if ($stichingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $stichingDataUpdate = mysqli_query($dbc, "UPDATE `stiching_voucher` SET `stiching_qlty`='$stiching_qlty',`stiching_gate_no`='$stiching_gate_no',`stiching_party_no`='$stiching_party_name',`stiching_details_name`='$stiching_details_name',`stiching_stock`='$stiching_stock',`stiching_status`='$stiching_status_form',`stiching_volume_no`='$stiching_vol_no',`stiching_remarks`='$stiching_remarks',`stiching_list`='$stichingDataJson' WHERE id  = $stiching_id");
        if ($stichingDataUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

//  calander_satander Data Insrt

if (isset($_POST['calander_satander_btn'])) {
    $cal_sal_id = $_POST['cal_sal_id'];
    $calander_satander_date = $_POST['calander_satander_date'];
    $calander_satander_Calander_name = $_POST['calander_satander_Calander_name'];
    $calander_satander_gate_no = $_POST['calander_satander_gate_no'];
    $calander_satander_quality = $_POST['calander_satander_quality'];
    $calander_satander_gazana = $_POST['calander_satander_gazana'];
    $calander_satander_embroider_thaan = $_POST['calander_satander_embroider_thaan'];
    $calander_satander_remarks = $_POST['calander_satander_remarks'];


    if (empty($cal_sal_id)) {
        $calanderSatanderDataInsert = "INSERT INTO `calander_satander`( `cal_sat_production_id`, `cal_sat_date`, `cal_sat_cal_name`, `cal_sat_gate_no`, `cal_sat_qlty`, `cal_sat_gazana`, `cal_sat_thaan`, `cal_sat_remarks`) VALUES ('$ProductionID','$calander_satander_date','$calander_satander_Calander_name','$calander_satander_gate_no','$calander_satander_quality','$calander_satander_gazana','$calander_satander_embroider_thaan','$calander_satander_remarks')";
        $calanderSatanderQuery = mysqli_query($dbc, $calanderSatanderDataInsert);
        if ($calanderSatanderQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $calanderSatanderDataUpdate = mysqli_query($dbc, "UPDATE `calander_satander` SET `cal_sat_cal_name`='$calander_satander_Calander_name',`cal_sat_gate_no`='$calander_satander_gate_no',`cal_sat_qlty`='$calander_satander_quality',`cal_sat_gazana`='$calander_satander_gazana',`cal_sat_thaan`='$calander_satander_embroider_thaan',`cal_sat_remarks`='$calander_satander_remarks' WHERE id = $cal_sal_id");
        if ($calanderSatanderDataUpdate) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}




$currentDate = new DateTime();
$currentDate->modify('+10 days');
$formattedDate = $currentDate->format('Y-m-d');
?>
<style type="text/css">
    .with-arrow .nav-link.active {
        position: relative;
        color: #fff !important;
    }

    .with-arrow .nav-link.active::after {
        content: '';
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #2b90d9;
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        display: block;
    }

    .lined .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
    }

    .lined .nav-link:hover {
        border: none;
        border-bottom: 3px solid transparent;
    }

    .lined .nav-link.active {
        background: none;
        color: #fff !important;
        border-color: #2b90d9;
    }

    .nav-pills .nav-link {
        color: #555;
    }

    .nav-pills {
        background-color: #e1e1e1 !important;
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
                                <b class="text-center card-text">Production</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="container-fluid px-2 py-2">
                            <div class="row my-2">
                                <div class="offset-lg-6 col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold text-dark" for="">Production Name</label>
                                            <input type="text" disabled class="disabled form-control" value="<?= ucwords(@$dataproduction['production_name']) ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold text-dark" for="">Lat No.</label>
                                            <input type="text" disabled class="disabled form-control" value="<?= ucwords(@$dataproduction['production_lat_no']) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" bg-white rounded shadow mb-5">
                                <!-- Rounded tabs -->
                                <ul id="myTab" role="tablist" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                                    <li class="nav-item flex-sm-fill">
                                        <a id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" class="nav-link border-0 font-weight-bold active">Purchase Voucher</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" class="nav-link border-0 font-weight-bold ">Cutting Voucher</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" class="nav-link border-0 font-weight-bold">Print Voucher</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="Dyeing" data-toggle="tab" href="#Dyeing_content" role="tab" aria-controls="Dyeing_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Dyeing</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="print" data-toggle="tab" href="#print_content" role="tab" aria-controls="print_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Print</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="embroidery" data-toggle="tab" href="#embroidery_content" role="tab" aria-controls="embroidery_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Insuance Embroidery</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="collect_emb" data-toggle="tab" href="#collect_emb_content" role="tab" aria-controls="collect_emb_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Recieving Embroidery</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="stitch_pack" data-toggle="tab" href="#stitch_pack_content" role="tab" aria-controls="stitch_pack_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Stiching & Packing</a>
                                    </li>
                                    <li class="nav-item flex-sm-fill">
                                        <a id="calander_satander" data-toggle="tab" href="#calander_satander_content" role="tab" aria-controls="calander_satander_content" aria-selected="false" class="nav-link border-0 font-weight-bold">Calander & Stander</a>
                                    </li>

                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div id="home" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5 show active">
                                        <?php include_once './credit_purchase.php'; ?>
                                        <!-- <form action="">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="purchase_date">Date</label>
                                                    <input type="date" class="form-control" name="purchase_date" id="purchase_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="bill_num">Bill No.</label>
                                                    <input type="text" class="form-control" name="bill_num" id="bill_num" value="" placeholder="Bill Number">
                                                </div>

                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="party_name">Party Name</label>
                                                    <input type="text" class="form-control" name="party_name" id="party_name" value="" placeholder="Party Name">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="gzanah">Gzanah</label>
                                                    <input type="text" class="form-control" name="gzanah" id="gzanah" value="" placeholder="Gzanah">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="unit">Unit</label>
                                                    <input type="text" class="form-control" name="unit" id="unit" value="" placeholder="Unit">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="quality">Quality</label>
                                                    <input type="text" class="form-control" name="quality" id="quality" value="" placeholder="Quality">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="thaan">Thaan</label>
                                                    <input type="text" class="form-control" name="thaan" id="thaan" value="" placeholder="Thaan">
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label class="font-weight-bold text-dark" for="rate">Rate</label>
                                                            <input type="text" class="form-control" name="rate" id="rate" value="" placeholder="Rate">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="font-weight-bold text-dark" for="price">Price</label>
                                                            <input type="text" class="form-control" name="price" id="price" value="" placeholder="Price">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="location">Location</label>
                                                    <input type="text" class="form-control" name="location" id="location" value="" placeholder="Location">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="builty">Builty</label>
                                                    <input type="text" class="form-control" name="builty" id="builty" value="" placeholder="Builty">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="cargo">Cargo</label>
                                                    <input type="text" class="form-control" name="cargo" id="cargo" value="" placeholder="Cargo">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="Remarks" id="Remarks" placeholder="Remarks" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="purchase_btn">
                                                </div>
                                            </div>
                                        </form> -->
                                    </div>
                                    <div id="profile" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                                        <form action="#" id="cutt_voucher_form" method="post">
                                            <input type="hidden" value="<?= @$cuttingDatafetch['id'] ?>" name="cutt_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="cutting_date">Date</label>
                                                    <input type="date" class="form-control" name="cutting_date" id="cutting_date" value="<?= date('Y-m-d') ?>">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="cutt_qty">Quality</label>
                                                    <select class="form-control searchableSelect" name="cutt_qty" id="cutt_qty" value="<?= @$cuttingDatafetch['id'] ?>">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>
                                                            <option <?= (@$cuttingDatafetch['cutt_voucher_quality'] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?> ">
                                                                <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="cutt_thaan">Thaan</label>
                                                    <input type="text" class="form-control" name="cutt_thaan" id="cutt_thaan" value="<?= @$cuttingDatafetch['cutt_thaan'] ?>" placeholder="Thaan">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="cutt_location" id="cutt_location" value="<?= @$cuttingDatafetch['cutt_voucher_location'] ?>" placeholder="Location">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Dyeing Lat No">Dyeing Lat No</label>
                                                    <input type="text" class="form-control" name="cutt_dyeing_lat_no" id="cutt_dyeing_lat_no" value="<?= @$cuttingDatafetch['cutt_dyeing_lat_no'] ?>" placeholder="Dyeing Lat No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="cutt_volume_no" id="cutt_volume_no" value="<?= @$cuttingDatafetch['cutt_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="cutt_remarks" id="cutt_remarks" placeholder="Remarks" class="form-control"><?= @$cuttingDatafetch['cutt_voucher_remarks'] ?></textarea>
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
                                                <?php
                                                // print_r($cuttingDatafetch['cutting_vouc_list']);
                                                if (@$cuttingDatafetch != 0) {
                                                    $lowerdata = json_decode(@$cuttingDatafetch['cutting_vouc_list']);
                                                    for ($x = 0; $x < count(@$lowerdata->cutt_designe_no); $x++) {

                                                ?>

                                                        <div class="row">

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Design No</label>
                                                                    <input type="text" class="form-control" placeholder="Design No" required id="cutt_designe_no" name="cutt_designe_no[]" value="<?= @$lowerdata->cutt_designe_no[$x] ?> ">
                                                                </div>
                                                            </div>



                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Quantity</label>
                                                                    <input type="text" class="form-control" placeholder="Qty" required id="cutt_type" name="cutt_type[]" value="<?= @$lowerdata->cutt_type[$x] ?>">
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Gzanah</label>
                                                                    <input type="text" class="form-control" placeholder="Gzanah" id="cutt_gzanah" name="cutt_gzanah[]" required value="<?= @$lowerdata->cutt_gzanah[$x] ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type</label>
                                                                    <input type="text" class="form-control" id="cutt_gzanah_type" name="cutt_gzanah_type[]" placeholder="Type" required value="<?= @$lowerdata->cutt_gzanah_type[$x] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="cutt_status[]" id="cutt_status" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata->cutt_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata->cutt_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class=" align-items-end jus d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class=" outline_none border-0 bg-white" onclick="cutt_voucher_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                    // }

                                                } else {
                                                    ?>
                                                    <div class="row">

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Design No</label>
                                                                <input type="text" class="form-control" placeholder="Design No" required id="cutt_designe_no" name="cutt_designe_no[]" value="<?= @$lowerdata->cutt_designe_no[$x] ?> ">
                                                            </div>
                                                        </div>



                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Quantity</label>
                                                                <input type="text" class="form-control" placeholder="Qty" required id="cutt_type" name="cutt_type[]" value="<?= @$lowerdata->cutt_type[$x] ?>">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Gzanah</label>
                                                                <input type="text" class="form-control" placeholder="Gzanah" id="cutt_gzanah" name="cutt_gzanah[]" required value="<?= @$lowerdata->cutt_gzanah[$x] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type</label>
                                                                <input type="text" class="form-control" id="cutt_gzanah_type" name="cutt_gzanah_type[]" placeholder="Type" required value="<?= @$lowerdata->cutt_gzanah_type[$x] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="cutt_status[]" id="cutt_status" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option <?= (@$lowerdata->cutt_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                    <option <?= (@$lowerdata->cutt_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class=" align-items-end jus d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="cutt_voucher_remove(this)">
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
                                                    <div id="cutt_voucher_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="cutting_btn">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div id="contact" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" id="print_voucher_form" method="post">
                                            <input type="hidden" value="<?= @$printfetch['id'] ?>" name="print_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="print_date">Date</label>
                                                    <input type="date" class="form-control" name="print_date" id="print_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="print_gate_no" id="print_gate_no" value="<?= @$printfetch['print_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="print_party_name">Party Name</label>

                                                    <select class="form-control searchableSelect" name="print_party_name" id="print_party_name">
                                                        <option value="">Part Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'customer'");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$printfetch['print_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?= ucwords($row["customer_name"]) ?> </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="quality">Quality</label>
                                                    <select class="form-control searchableSelect" name="print_quality" id="print_quality">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>
                                                            <option <?= (@$printfetch['print_production_id'] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                                <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Quantity">Quantity</label>
                                                    <input type="text" class="form-control" name="print_v_quantity" id="print_v_quantity" value="<?= @$printfetch['print_quality'] ?>" placeholder="Quantity">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Voucher">Voucher</label>
                                                    <input type="text" class="form-control" name="print_voucher" id="print_voucher" value="<?= @$printfetch['print_voucher'] ?>" placeholder="Voucher">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="print_volume_no" id="print_volume_no" value="<?= @$printfetch['print_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Name Gzanah">Name Gzanah</label>
                                                    <input type="text" class="form-control" name="print_name_gzanah" id="print_name_gzanah" value="<?= @$printfetch['print_gzanah'] ?>" placeholder="Name Gzanah">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="qty_m">Qty (M)</label>
                                                    <input type="text" class="form-control" name="print_qty_m" id="print_qty_m" value="<?= @$printfetch['print_qty'] ?>" placeholder="Qty (M)">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="print_location" id="print_location" value="<?= @$printfetch['print_location'] ?>" placeholder="Location">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="print_remarks" id="print_remarks" placeholder="Remarks" class="form-control"><?= @$printfetch['print_remarks'] ?></textarea>
                                                </div>
                                            </div>


                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="print_container">


                                                <?php
                                                // print_r($cuttingDatafetch['print_list']);
                                                if (@$printfetch != 0) {
                                                    $lowerdata2 = json_decode(@$printfetch['print_list']);
                                                    for ($x = 0; $x < count(@$lowerdata2->print_quantity); $x++) {

                                                ?>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Quantity</label>
                                                                    <input type="text" class="form-control" placeholder="Qty" required id="print_quantity" name="print_quantity[]" value="<?= @$lowerdata2->print_quantity[$x] ?> ">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Name</label>
                                                                    <input type="text" class="form-control" placeholder="Name" required id="print_quantity_name" name="print_quantity_name[]" value="<?= @$lowerdata2->print_quantity_name[$x] ?> ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="print_status[]" id="print_status" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata2->print_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata2->print_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class=" outline_none border-0 bg-white" onclick="print_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                    // }

                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Quantity</label>
                                                                <input type="text" class="form-control" placeholder="Qty" required id="print_quantity" name="print_quantity[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Name</label>
                                                                <input type="text" class="form-control" placeholder="Name" required id="print_quantity_name" name="print_quantity_name[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="print_status[]" id="print_status" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="Sent">Sent</option>
                                                                    <option value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="print_remove(this)">
                                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                            </button>
                                                        </div>
                                                    </div>

                                                <?php
                                                }
                                                ?>




                                            </div>
                                            <div class="row my-4 justify-content-end">
                                                <div class="col-lg-6  col-md-3 col-sm-4 col-xs-6">
                                                    <div id="print_plus_button">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="print_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="print_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="Dyeing_content" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$deyeingfetch['id'] ?>" name="deyeing_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="dyeing_date">Date</label>
                                                    <input type="date" class="form-control" name="dyeing_date" id="dyeing_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="dyeing_gate_no" id="dyeing_gate_no" value="<?= @$deyeingfetch['dey_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="dyeing_lat_name">Lat no.</label>
                                                    <input type="text" class="form-control" name="dyeing_lat_name" id="dyeing_lat_name" value="<?= @$deyeingfetch['dey_lat_no'] ?>" placeholder="Lat Number">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Party Name">Party Name</label>


                                                    <select class="form-control searchableSelect" name="dyeing_party_name" id="dyeing_party_name">
                                                        <option value="">Part Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'customer'");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$deyeingfetch['dey_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?= ucwords($row["customer_name"]) ?> </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Party Voucher No.">Party Voucher No.</label>
                                                    <input type="text" class="form-control" name="dyeing_party_voucher" id="dyeing_party_voucher" value="<?= @$deyeingfetch['dey_voucher_no'] ?>" placeholder="Party Voucher No.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Qty">Qty</label>
                                                    <input type="text" class="form-control" name="dyeing_qty" id="dyeing_qty" value="<?= @$deyeingfetch['dey_qty'] ?>" placeholder="Qty">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Ready Qty">Ready Qty</label>
                                                    <input type="text" class="form-control" name="dyeing_readyqty" id="dyeing_readyqty" value="<?= @$deyeingfetch['dey_ready_qty'] ?>" placeholder="Ready Qty">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="C-P">C-P</label>
                                                    <input type="text" class="form-control" name="dyeing_cp" id="dyeing_cp" value="<?= @$deyeingfetch['dey_c_p'] ?>" placeholder="C-P">
                                                </div>
                                                <div class="col-lg-1 pr-1">
                                                    <label class="font-weight-bold text-dark" for="color">Color Name</label>
                                                    <input type="text" class="form-control" name="dyeing_color_name" id="dyeing_color_name" value="<?= @$deyeingfetch['dey_color_name'] ?>" placeholder="Name">
                                                </div>
                                                <div class="col-lg-1 pl-1">
                                                    <label class="font-weight-bold text-dark" for="color">Color</label>
                                                    <input type="color" class="form-control" name="dyeing_color" id="dyeing_color" value="<?= @$deyeingfetch['dey_color'] ?>" placeholder="Color">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Thaan">Thaan</label>
                                                    <input type="text" class="form-control" name="dyeing_thaan" id="dyeing_thaan" value="<?= @$deyeingfetch['dey_thaan'] ?>" placeholder="Thaan">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="dyeing_location" id="dyeing_location" value="<?= @$deyeingfetch['dey_location'] ?>" placeholder="Location">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="dyeing_remarks" id="dyeing_remarks" placeholder="Remarks" class="form-control"><?= @$deyeingfetch['dey_remarks'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="dyeing_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="print_content" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$singlePrintfetch['id'] ?>" name="single_print_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="print_date">Date</label>
                                                    <input type="date" class="form-control" name="singleprint_date" id="singleprint_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="singleprint_party_name">Party Name</label>



                                                    <select class="form-control searchableSelect" name="singleprint_party_name" id="singleprint_party_name">
                                                        <option value="">Part Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'customer'");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$singlePrintfetch['single_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?= ucwords($row["customer_name"]) ?> </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="gat_nol">Lat No.</label>
                                                    <input type="text" class="form-control" name="singleprint_lat_no" id="singleprint_lat_no" value="<?= @$singlePrintfetch['single_lat_no'] ?>" placeholder="Lat no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Quantity">Quantity</label>
                                                    <input type="text" class="form-control" name="singleprint_quantity" id="singleprint_quantity" value="<?= @$singlePrintfetch['single_quantity'] ?>" placeholder="Quantity">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="singleprint_gate_no" id="singleprint_gate_no" value="<?= @$singlePrintfetch['single_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Design No">Design No</label>
                                                    <input type="text" class="form-control" name="singleprint_design_no" id="singleprint_design_no" value="<?= @$singlePrintfetch['single_design_no'] ?>" placeholder="Design No">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Design Qty">Design Qty</label>
                                                    <input type="text" class="form-control" name="singleprint_design_qty" id="singleprint_design_qty" value="<?= @$singlePrintfetch['single_design_qty'] ?>" placeholder="Design Qty">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Remarks">Remarks</label>
                                                    <input type="text" class="form-control" name="singleprint_remarks" id="singleprint_remarks" value="<?= @$singlePrintfetch['single_remarks'] ?>" placeholder="Remarks">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="singleprint_location" id="singleprint_location" value="<?= @$singlePrintfetch['single_location'] ?>" placeholder="Location">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="cutpieces">Cut Pieces</label>
                                                    <input type="text" class="form-control" name="singleprint_cutpieces" id="singleprint_cutpieces" value="<?= @$singlePrintfetch['single_cut_pieces'] ?>" placeholder="Cut Pieces">
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>


                                            <div id="singleprint_container">
                                                <?php
                                                // print_r($cuttingDatafetch['print_list']);
                                                if (@$singlePrintfetch != 0) {
                                                    $lowerdata3 = json_decode(@$singlePrintfetch['single_list']);
                                                    for ($x = 0; $x < count(@$lowerdata3->singleprint_dp_no); $x++) {

                                                ?>

                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">DP No</label>
                                                                    <input type="text" class="form-control" placeholder="DP no" required id="singleprint_dp_no" name="singleprint_dp_no[]" value="<?= @$lowerdata3->singleprint_dp_no[$x] ?> ">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type</label>
                                                                    <input type="text" class="form-control" placeholder="" required id="singleprint_type" name="singleprint_type[]" value="<?= @$lowerdata3->singleprint_type[$x] ?> ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type Name</label>
                                                                    <input type="text" class="form-control" placeholder="" required id="singleprint_type_name" name="singleprint_type_name[]" value="<?= @$lowerdata3->singleprint_type_name[$x] ?> ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="print2_status[]" id="print2_status" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata3->print2_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata3->print2_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class=" outline_none border-0 bg-white" onclick="singleprint_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    // }

                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">DP No</label>
                                                                <input type="text" class="form-control" placeholder="DP no" required id="singleprint_dp_no" name="singleprint_dp_no[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type</label>
                                                                <input type="text" class="form-control" placeholder="" required id="singleprint_type" name="singleprint_type[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type Name</label>
                                                                <input type="text" class="form-control" placeholder="" required id="singleprint_type_name" name="singleprint_type_name[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="print2_status[]" id="print2_status" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="Sent">Sent</option>
                                                                    <option value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="singleprint_remove(this)">
                                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="row my-4 justify-content-end">
                                                <div class="col-lg-4  col-md-3 col-sm-4 col-xs-6">
                                                    <div id="singleprint_plus_button">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="singleprint_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="singleprint_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="embroidery_content" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$embroideryVoucherfetch['id'] ?>" name="embroidery_voucher_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="emb_out_date">Out Date</label>
                                                    <input type="date" class="form-control" name="emb_out_date" id="emb_out_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="emb_gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="emb_gate_no" id="emb_gate_no" value="<?= @$embroideryVoucherfetch['emb_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="emb_volume_no" id="emb_volume_no" value="<?= @$embroideryVoucherfetch['emb_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Design No">Design No</label>
                                                    <input type="text" class="form-control" name="emb_design_no" id="emb_design_no" value="<?= @$embroideryVoucherfetch['emb_design_no'] ?>" placeholder="Design No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="embroider_name">Embroider Name</label>
                                                    <input type="text" class="form-control" name="emb_embroider_name" id="emb_embroider_name" value="<?= @$embroideryVoucherfetch['emb_embroider_name'] ?>" placeholder="Embroider Name">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Total Dress">Total Dress</label>
                                                    <input type="text" class="form-control" name="emb_ttl_dress" id="emb_ttl_dress" value="<?= @$embroideryVoucherfetch['emb_total_dress'] ?>" placeholder="Total Dress">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Details Name">Details Name</label>
                                                    <input type="text" class="form-control" name="emb_detail_name" id="emb_detail_name" value="<?= @$embroideryVoucherfetch['emb_details_name'] ?>" placeholder="Details Name">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="emb_remarks" id="emb_remarks" placeholder="Remarks" class="form-control"><?= @$embroideryVoucherfetch['emb_remarks'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="embroidery_container">

                                                <?php
                                                // print_r($cuttingDatafetch['print_list']);
                                                if (@$embroideryVoucherfetch != 0) {
                                                    $lowerdata4 = json_decode(@$embroideryVoucherfetch['emb_list']);
                                                    for ($x = 0; $x < count(@$lowerdata4->embroid_type); $x++) {

                                                ?>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Quantity</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata4->embroid_type[$x] ?> " placeholder="Qty" required id="embroid_type" name="embroid_type[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Name</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata4->embroid_type_name[$x] ?> " placeholder="Name" required id="embroid_type_name" name="embroid_type_name[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Print</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata4->embroid_gzanah[$x] ?> " placeholder="Gzanah" id="embroid_gzanah" name="embroid_gzanah[]" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata4->embroid_gzanah_type[$x] ?> " id="embroid_gzanah_type" name="embroid_gzanah_type[]" placeholder="Type" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="emb_status[]" id="emb_status" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata4->emb_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata4->emb_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class="outline_none border-0 bg-white" onclick="embroidery_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    // }

                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Quantity</label>
                                                                <input type="text" class="form-control" placeholder="Qty" required id="embroid_type" name="embroid_type[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Name</label>
                                                                <input type="text" class="form-control" placeholder="Name" required id="embroid_type_name" name="embroid_type_name[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Print</label>
                                                                <input type="text" class="form-control" placeholder="Gzanah" id="embroid_gzanah" name="embroid_gzanah[]" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type</label>
                                                                <input type="text" class="form-control" id="embroid_gzanah_type" name="embroid_gzanah_type[]" placeholder="Type" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="emb_status[]" id="emb_status" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="Sent">Sent</option>
                                                                    <option value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="embroidery_remove(this)">
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
                                                    <div id="embroidery_plus_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="embroidery_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="embroidery_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="collect_emb_content" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$collectEmbroideryfetch['id'] ?>" name="col_embroidery_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="coll_emb_date">Date</label>
                                                    <input type="date" class="form-control" name="coll_emb_date" id="coll_emb_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="coll_gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="coll_gate_no" id="coll_gate_no" value="<?= @$collectEmbroideryfetch['coll_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="coll_party_no">Party Pass No.</label>
                                                    <input type="text" class="form-control" name="coll_party_no" id="coll_party_no" value="<?= @$collectEmbroideryfetch['coll_party_no'] ?>" placeholder="Party pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Design No">Design No</label>
                                                    <input type="text" class="form-control" name="coll_design_no" id="coll_design_no" value="<?= @$collectEmbroideryfetch['coll_design_no'] ?>" placeholder="Design No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="embroider_name">Embroider Name</label>
                                                    <input type="text" class="form-control" name="coll_embroider_name" id="coll_embroider_name" value="<?= @$collectEmbroideryfetch['coll_emb_name'] ?>" placeholder="Embroider Name">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Design Qty">Design Qty</label>
                                                    <input type="text" class="form-control" name="coll_des_qty" id="coll_des_qty" value="<?= @$collectEmbroideryfetch['coll_design_qty'] ?>" placeholder="Design Qty">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="coll_volume_no" id="coll_volume_no" value="<?= @$collectEmbroideryfetch['coll_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Details Yards">Details Yards</label>
                                                    <input type="text" class="form-control" name="coll_detail_yard" id="coll_detail_yard" value="<?= @$collectEmbroideryfetch['coll_details_yards'] ?>" placeholder="Details Yards">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="coll_location" id="coll_location" value="<?= @$collectEmbroideryfetch['coll_location'] ?>" placeholder="Location">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="coll_remarks" id="coll_remarks" placeholder="Remarks" class="form-control"><?= @$collectEmbroideryfetch['coll_remarks'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="collect_embroidery_container">

                                                <?php
                                                // print_r($cuttingDatafetch['print_list']);
                                                if (@$collectEmbroideryfetch != 0) {
                                                    $lowerdata5 = json_decode(@$collectEmbroideryfetch['coll_list']);
                                                    for ($x = 0; $x < count(@$lowerdata5->collect_embroid_type); $x++) {

                                                ?>
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Quantity</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata5->collect_embroid_type[$x] ?> " placeholder="Qty" required id="collect_embroid_type" name="collect_embroid_type[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Name</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata5->collect_embroid_type_name[$x] ?> " placeholder="Name" required id="collect_embroid_type_name" name="collect_embroid_type_name[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Print</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata5->collect_embroid_gzanah[$x] ?> " placeholder="Gzanah" id="collect_embroid_gzanah" name="collect_embroid_gzanah[]" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata5->collect_embroid_gzanah_type[$x] ?> " id="collect_embroid_gzanah_type" name="collect_embroid_gzanah_type[]" placeholder="Type" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="collect_embroid_status[]" id="collect_embroid_status" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata5->collect_embroid_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata5->collect_embroid_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class=" outline_none border-0 bg-white" onclick="collect_embroidery_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    // }

                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Quantity</label>
                                                                <input type="text" class="form-control" placeholder="Qty" required id="collect_embroid_type" name="collect_embroid_type[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Name</label>
                                                                <input type="text" class="form-control" placeholder="Name" required id="collect_embroid_type_name" name="collect_embroid_type_name[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Print</label>
                                                                <input type="text" class="form-control" placeholder="Gzanah" id="collect_embroid_gzanah" name="collect_embroid_gzanah[]" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type</label>
                                                                <input type="text" class="form-control" id="collect_embroid_gzanah_type" name="collect_embroid_gzanah_type[]" placeholder="Type" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="collect_embroid_status[]" id="collect_embroid_status" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="Sent">Sent</option>
                                                                    <option value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="collect_embroidery_remove(this)">
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
                                                    <div id="collect_embroidery_plus_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="collect_embroidery_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="collect_embroidery_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="stitch_pack_content" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$stichingfetch['id'] ?>" name="stiching_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="stiching_date">Date</label>
                                                    <input type="date" class="form-control" name="stiching_date" id="stiching_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Quality">Quality</label>
                                                    <!-- <input type="text" class="form-control" name="stiching_qlty" id="stiching_qlty" value="" placeholder="Quality"> -->
                                                    <select class="form-control searchableSelect" name="stiching_qlty" id="stiching_qlty">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>
                                                            <option <?= (@$stichingfetch['stiching_qlty'] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                                <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="stiching_gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="stiching_gate_no" id="stiching_gate_no" value="<?= @$stichingfetch['stiching_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Party Name">Party Name</label>
                                                    <!-- <input type="text" class="form-control" name="stiching_party_name" id="stiching_party_name" value="<?= @$stichingfetch['stiching_party_no'] ?>" placeholder="Party Name"> -->

                                                    <select class="form-control searchableSelect" name="stiching_party_name" id="stiching_party_name">
                                                        <option value="">Part Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'customer'");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$stichingfetch['stiching_party_no'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?= ucwords($row["customer_name"]) ?> </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="details_name">Details Name</label>
                                                    <input type="text" class="form-control" name="stiching_details_name" id="stiching_details_name" value="<?= @$stichingfetch['stiching_details_name'] ?>" placeholder="Details Name">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Stock">Stock</label>
                                                    <input type="text" class="form-control" name="stiching_stock" id="stiching_stock" value="<?= @$stichingfetch['stiching_stock'] ?>" placeholder="Stock">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Status">Status</label>
                                                    <input type="text" class="form-control" name="stiching_status_form" id="stiching_status_form" value="<?= @$stichingfetch['stiching_status'] ?>" placeholder="Status">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="stiching_vol_no" id="stiching_vol_no" value="<?= @$stichingfetch['stiching_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="stiching_remarks" id="stiching_remarks" placeholder="Remarks" class="form-control"><?= @$stichingfetch['stiching_remarks'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="stiching_container">

                                                <?php
                                                // print_r($cuttingDatafetch['print_list']);
                                                if (@$stichingfetch != 0) {
                                                    $lowerdata6 = json_decode(@$stichingfetch['stiching_list']);
                                                    for ($x = 0; $x < count(@$lowerdata6->stiching_type); $x++) {

                                                ?>

                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Quantity</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata6->stiching_type[$x] ?> " placeholder="Qty" required id="stiching_type" name="stiching_type[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Name</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata6->stiching_type_name[$x] ?> " placeholder="Name" required id="stiching_type_name" name="stiching_type_name[]">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Print</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata6->stiching_gzanah[$x] ?> " placeholder="Gzanah" id="stiching_gzanah" name="stiching_gzanah[]" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Type</label>
                                                                    <input type="text" class="form-control" value="<?= @$lowerdata6->stiching_gzanah_type[$x] ?> " id="stiching_gzanah_type" name="stiching_gzanah_type[]" placeholder="Type" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-bold text-dark">Status</label>
                                                                    <select name="stiching_status[]" id="stiching_status" class="form-control ">
                                                                        <option value="">Select</option>
                                                                        <option <?= (@$lowerdata6->stiching_status[$x] == 'Sent') ? 'selected' : ''; ?> value="Sent">Sent</option>
                                                                        <option <?= (@$lowerdata6->stiching_status[$x] == 'Recieved') ? 'selected' : ''; ?> value="Recieved">Recieved</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                <button type="button" class=" outline_none border-0 bg-white" onclick="stiching_remove(this)">
                                                                    <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                </button>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                } else {
                                                    ?>

                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Quantity</label>
                                                                <input type="text" class="form-control" placeholder="Qty" required id="stiching_type" name="stiching_type[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Name</label>
                                                                <input type="text" class="form-control" placeholder="Name" required id="stiching_type_name" name="stiching_type_name[]">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Print</label>
                                                                <input type="text" class="form-control" placeholder="Gzanah" id="stiching_gzanah" name="stiching_gzanah[]" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Type</label>
                                                                <input type="text" class="form-control" id="stiching_gzanah_type" name="stiching_gzanah_type[]" placeholder="Type" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold text-dark">Status</label>
                                                                <select name="stiching_status[]" id="stiching_status" class="form-control ">
                                                                    <option value="">Select</option>
                                                                    <option value="Sent">Sent</option>
                                                                    <option value="Recieved">Recieved</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="align-items-end d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                            <button type="button" class="d-none outline_none border-0 bg-white" onclick="stiching_remove(this)">
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
                                                    <div id="stiching_plus_btn">
                                                        <button type="button" class="outline_none border-0 bg-white" onclick="stiching_duplicateRow()">
                                                            <img src="img/add.png" width="30px" alt="add sign">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="stitching_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="calander_satander_content" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= @$cal_salFetch['id'] ?>" name="cal_sal_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="calander_satander_date">Date</label>
                                                    <input type="date" class="form-control" name="calander_satander_date" id="calander_satander_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Calander Name">Calander Name</label>
                                                    <input type="text" class="form-control" name="calander_satander_Calander_name" id="calander_satander_Calander_name" value="<?= @$cal_salFetch['cal_sat_cal_name'] ?>" placeholder="Calander Name">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="calander_satander_gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="calander_satander_gate_no" id="calander_satander_gate_no" value="<?= @$cal_salFetch['cal_sat_gate_no'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Quality">Quality</label>
                                                    <select class="form-control searchableSelect" name="calander_satander_quality" id="calander_satander_quality">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>
                                                            <option <?= (@$cal_salFetch['cal_sat_qlty'] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                                <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="Gazana">Gazana</label>
                                                    <input type="text" class="form-control" name="calander_satander_gazana" id="calander_satander_gazana" value="<?= @$cal_salFetch['cal_sat_gazana'] ?>" placeholder="Gazana">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="font-weight-bold text-dark" for="embroider_thaan">Thaan</label>
                                                    <input type="text" class="form-control" name="calander_satander_embroider_thaan" id="calander_satander_embroider_thaan" value="<?= @$cal_salFetch['cal_sat_thaan'] ?>" placeholder="Thaan">
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col-lg-12">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="calander_satander_remarks" id="calander_satander_remarks" placeholder="Remarks" class="form-control"><?= @$cal_salFetch['cal_sat_remarks'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-2 text-right">
                                                    <input class="btn btn-success" type="submit" value="Save" name="calander_satander_btn">
                                                </div>
                                            </div>
                                        </form>
                                        <?php include_once("./credit_purchase.php") ?>
                                    </div>
                                </div>
                                <!-- End rounded tabs -->
                            </div>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->

        </main> <!-- main -->
    </div> <!-- .wrapper -->

</body>

</html>
<?php include_once 'includes/foot.php'; ?>

<script>
    function activateTabAndAccordion() {
        // Check for a hash in the URL
        var hash = window.location.hash;

        if (hash) {
            var hashParts = hash.split('#');
            var tabId = hashParts[1];
            var accordionId = hashParts[2];

            // Activate the tab corresponding to the hash in the URL
            $('#myTab a[href="#' + tabId + '"]').tab('show');

            // Optionally, show the accordion
            if (accordionId) {
                $('#' + accordionId).collapse('show');
            }
        }
    }
    // Handle tab clicks
    $('#myTab a').on('click', function(e) {
        e.preventDefault();
        var tabId = $(this).attr('href');
        window.history.pushState({}, '', '' + tabId); // Update the URL hash with tabId
        // Optionally show the clicked tab
        // $(this).tab('show');
    });
    // Check for a hash in the URL on initial page load
    activateTabAndAccordion();

    // Handle the popstate event to activate tab and accordion on back/forward
    window.addEventListener('popstate', function() {
        activateTabAndAccordion();
    });


    // Submit Data

    // $("#cutt_voucher_form").on('submit', function(e) {
    //     //console.log('click');
    //     e.preventDefault();
    //     var form = $('#cutt_voucher_form');
    //     $.ajax({
    //         type: 'POST',
    //         url: form.attr('action'),
    //         data: form.serialize(),
    //         dataType: 'json',
    //         beforeSend: function() {

    //         },
    //         success: function(response) {

    //         }
    //     }); //ajax call
    // });
</script>