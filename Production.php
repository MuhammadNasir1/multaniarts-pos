<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);

if (!empty($_REQUEST['ProductionID']) && isset($_REQUEST['ProductionID'])) {

    $ProductionID = $_REQUEST['ProductionID'];

    $dataproduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE `production_id` = '$ProductionID'"));
    $request_id = $dataproduction['purchase_id'];
    $purchase_data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `purchase` WHERE `purchase_id` = '$request_id'"));
    $user_id = $_SESSION['userId'];
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
        $cuttingDataInsert = "INSERT INTO `cutting_voucher`(`user_id`, `updated_user_id`, `cutt_production_id`, `cutt_voucher_date`, `cutt_party_name`, `cutt_voucher_location`, `cutt_dyeing_lat_no`, `cutt_volume_no`, `cutting_delivery_date`, `cutt_voucher_remarks`,  `cutting_from_list`, `cutting_to_list`) VALUES ('$user_id','$user_id','$ProductionID','$cutting_date','$cutt_party_name','$cutt_location','$cutt_dyeing_lat_no','$cutt_volume_no','$cutting_delivery_date','$cutt_remarks','$jsonData1','$jsonData2')";
        $cuttingQuery = mysqli_query($dbc, $cuttingDataInsert);

        if ($cuttingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $updateCuttVoucher = mysqli_query($dbc, "UPDATE `cutting_voucher` SET 
        `updated_user_id` = '$user_id', 
        `cutt_production_id` = '$ProductionID', 
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
    $dyeing_color_name = $_POST['dyeing_color_name'];
    $dyeing_location = $_POST['dyeing_location'];
    $dyeing_remarks = $_POST['dyeing_remarks'];
    $dey_bill_no = $_POST['dey_bill_no'];
    $dey_bilty_no = $_POST['dey_bilty_no'];
    $dyeing_delivery_date = $_POST['dyeing_delivery_date'];

    $deyData1 = [
        'deying_product' => $_POST['deying_product'],
        'dey_sending_thaan' => $_POST['dey_sending_thaan'],
        'dey_sending_gzanah' => $_POST['dey_sending_gzanah'],
        'dey_sending_quantity' => $_POST['dey_sending_quantity'],
    ];
    $deyData2 = [
        'dey_recieving_product' => $_POST['dey_recieving_product'],
        'dey_recieving_thaan' => $_POST['dey_recieving_thaan'],
        'dey_recieving_gzanah' => $_POST['dey_recieving_gzanah'],
        'dey_recieving_quantity' => $_POST['dey_recieving_quantity'],
        'dyeing_cp' => $_POST['dyeing_cp'],
        'deying_Shortage' => $_POST['deying_Shortage'],
    ];
    $deyJson1 = json_encode($deyData1);
    $deyJson2 = json_encode($deyData2);



    if (empty($deyeing_id)) {
        $deyeingDataInsert = "INSERT INTO `deyeing`(`user_id`,`updated_user_id`,`dey_production_id`, `dey_date`, `dey_gate_no`, `dey_lat_no`, `dey_party_name`, `dey_voucher_no`, `dey_color_name`, `dey_location`, `dey_bill_no`, `dey_bilty_no`, `dey_delivery_date`, `dey_remarks`, `dey_sending_list`,`dey_recieving_list`) VALUES ('$user_id','$user_id','$ProductionID','$dyeing_date','$dyeing_gate_no','$dyeing_lat_name','$dyeing_party_name','$dyeing_party_voucher','$dyeing_color_name','$dyeing_location','$dey_bill_no','$dey_bilty_no','$dyeing_delivery_date','$dyeing_remarks','$deyJson1','$deyJson2')";
        $deyeingQuery = mysqli_query($dbc, $deyeingDataInsert);

        if ($deyeingQuery) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        $deyeingUpdate = mysqli_query($dbc, "UPDATE `deyeing` SET 
        `updated_user_id`='$user_id',
        `dey_date` = '$dyeing_date', 
        `dey_gate_no` = '$dyeing_gate_no', 
        `dey_lat_no` = '$dyeing_lat_name', 
        `dey_party_name` = '$dyeing_party_name', 
        `dey_voucher_no` = '$dyeing_party_voucher', 
        `dey_color_name` = '$dyeing_color_name', 
        `dey_location` = '$dyeing_location', 
        `dey_bill_no` = '$dey_bill_no', 
        `dey_bilty_no` = '$dey_bilty_no', 
        `dey_delivery_date` = '$dyeing_delivery_date', 
        `dey_remarks` = '$dyeing_remarks', 
        `dey_sending_list` = '$deyJson1',
        `dey_recieving_list` = '$deyJson2'
        WHERE id = $deyeing_id");

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

    .list-container {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .list-1 {
        width: 100%;
        min-height: 200px;
        background-color: #fff;
        box-shadow: 10px 10px 0px 0px black;
        box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.1);
    }

    .list-2 {
        width: 100%;
        min-height: 200px;
        box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.1);
        border-radius: 3px;
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
                                        <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true" class="nav-link border-0 font-weight-bold active ">Cutting Voucher</a>
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

                                    <div id="profile" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5 show active">
                                        <form action="" id="cutt_voucher_form" method="post">
                                            <input type="hidden" id="hiddenInput1" value="<?= @$cuttingDatafetch['id'] ?>" name="cutt_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="cutting_date">Date</label>
                                                    <input type="date" class="form-control" name="cutting_date" id="cutting_date" value="<?= date('Y-m-d') ?>">
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
                                                    <input type="text" class="form-control" name="cutt_dyeing_lat_no" id="cutt_dyeing_lat_no" value="<?= @$cuttingDatafetch['cutt_dyeing_lat_no'] ?>" placeholder="Dyeing Lat No">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Volume No">Volume No</label>
                                                    <input type="text" class="form-control" name="cutt_volume_no" id="cutt_volume_no" value="<?= @$cuttingDatafetch['cutt_volume_no'] ?>" placeholder="Volume No">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="cutt_location" id="cutt_location" value="<?= isset($cuttingDatafetch['cutt_voucher_location']) ? @$cuttingDatafetch['cutt_voucher_location'] : $purchase_data['pur_location'] ?>" placeholder="Location">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                                    <input type="Date" class="form-control" name="cutting_delivery_date" id="cutting_delivery_date" value="<?= @$cuttingDatafetch['cutting_delivery_date'] ?>" placeholder="Location">
                                                </div>

                                                <div class="col-lg-12 mt-3">
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
                                                <div class="list-container">

                                                    <div class="list-1 card">
                                                        <div class="card-header card-bg" align="center">
                                                            <div class="row">
                                                                <div class="col-12 mx-auto h4">
                                                                    <b class="text-center card-text">From</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // print_r($cuttingDatafetch['cutting_from_list']);
                                                        if (@$cuttingDatafetch != 0) {
                                                            $lowerdata = json_decode(@$cuttingDatafetch['cutting_from_list']);
                                                            for ($x = 0; $x < count(@$lowerdata->cutting_from_product); $x++) {

                                                        ?>


                                                                <div class="row m-0 px-3">
                                                                    <div id="voucher_rows_container2">
                                                                        <div class="voucher_row2">

                                                                            <div class="row mt-3 m-0 p-0">

                                                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                    <div class="col-12 m-0 p-0 pr-2">
                                                                                        <label class=" font-weight-bold text-dark" for="cutting_from_product">Quality</label>

                                                                                        <select class="form-control searchableSelect" name="cutting_from_product[]">
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
                                                                                    <input type="text" class="form-control thaan" value="<?= @$lowerdata->cutt_from_thaan[$x] ?>" name="cutt_from_thaan[]" placeholder="Thaan">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Gzanah</label>
                                                                                    <input type="text" class="form-control gzanah" value="<?= @$lowerdata->cutt_form_gzanah[$x] ?>" name="cutt_form_gzanah[]" placeholder="Gzanah">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Quantity</label>
                                                                                    <input type="text" class="form-control quantity" value="<?= @$lowerdata->cutt_from_quantity[$x] ?>" name="cutt_from_quantity[]" value="0" placeholder="Quanitity">
                                                                                </div>

                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <div class="form-group mb-0">
                                                                                        <label class="font-weight-bold text-dark">Type</label>
                                                                                        <input type="text" class="form-control" id="cutt_gzanah_type" name="cutt_from_gzanah_type[]" placeholder="Type" required value="<?= @$lowerdata->cutt_from_gzanah_type[$x] ?>">
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



                                                            <?php
                                                            }
                                                            // }

                                                        } else {
                                                            ?>

                                                            <div class="row m-0 p-0 px-3">
                                                                <div id="voucher_rows_container2">
                                                                    <div class="voucher_row2">

                                                                        <div class="row mt-3 m-0 p-3">

                                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                <div class="col-12 m-0 p-0 pr-2">
                                                                                    <label class=" font-weight-bold text-dark" for="cutting_from_product">Quality</label>

                                                                                    <select class="form-control searchableSelect" name="cutting_from_product[]">
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
                                                            </div>


                                                        <?php
                                                        }
                                                        ?>
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
                                                    <div class="list-2 card">
                                                        <div class="card-header card-bg" align="center">
                                                            <div class="row">
                                                                <div class="col-12 mx-auto h4">
                                                                    <b class="text-center card-text">To</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // print_r($cuttingDatafetch['cutting_to_list']);
                                                        if (@$cuttingDatafetch != 0) {
                                                            $lowerdata11 = json_decode(@$cuttingDatafetch['cutting_to_list']);
                                                            for ($z = 0; $z < count(@$lowerdata11->cutting_to_product); $z++) {

                                                        ?>


                                                                <!-- Container for dynamic rows -->
                                                                <div class="row m-0 px-3">
                                                                    <div id="voucher_rows_container">
                                                                        <div class="voucher_row">
                                                                            <div class="row mt-3 m-0 p-0">
                                                                                <!-- Your existing row structure -->
                                                                                <!-- This is your template for each row -->

                                                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                    <div class="col-11 m-0 p-0 pr-2">
                                                                                        <label class=" font-weight-bold text-dark" for="cutting_to_product">Quality</label>

                                                                                        <select class="form-control searchableSelect" name="cutting_to_product[]">
                                                                                            <option value="">Select Product</option>
                                                                                            <?php
                                                                                            $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                                                                            while ($row = mysqli_fetch_array($result)) {
                                                                                                $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                                                                $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                                                            ?>
                                                                                                <option <?= (@$lowerdata11->cutting_to_product[$z] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                                                                    <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                                                </option>

                                                                                            <?php   } ?>
                                                                                        </select>

                                                                                    </div>
                                                                                    <div class="col-1 m-0 p-0 mt-1 ">
                                                                                        <label class="invisible d-block">.</label>
                                                                                        <button type="button" class="btn btn-danger btn-sm pt-1 pb-1" data-toggle="modal" data-target="#add_product_modal"> <i class="fa fa-plus"></i> </button>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Thaan</label>
                                                                                    <input type="text" class="form-control thaan" name="cutt_to_thaan[]" value="<?= @$lowerdata11->cutt_to_thaan[$z] ?>" placeholder="Thaan">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Gzanah</label>
                                                                                    <input type="text" class="form-control gzanah" name="cutt_to_gzanah[]" value="<?= @$lowerdata11->cutt_to_gzanah[$z] ?>" placeholder="Gzanah">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Quantity</label>
                                                                                    <input type="text" class="form-control quantity" name="cutt_to_quantity[]" value="<?= @$lowerdata11->cutt_to_quantity[$z] ?>" placeholder="Quantity">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Type</label>
                                                                                    <input type="text" class="form-control" name="cutt_to_gzanah_type[]" value="<?= @$lowerdata11->cutt_to_gzanah_type[$z] ?>" placeholder="Type" required>
                                                                                </div>

                                                                                <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                                    <button type="button" class="outline_none mt-4 border-0 bg-white" onclick="cutt_voucher_remove2(this)">
                                                                                        <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <!-- Container for dynamic rows -->
                                                            <?php
                                                            }
                                                            // }

                                                        } else {
                                                            ?>

                                                            <!-- Container for dynamic rows -->
                                                            <div class="row m-0 p-3">
                                                                <div id="voucher_rows_container">
                                                                    <div class="voucher_row">
                                                                        <div class="row mt-3 m-0 p-0">
                                                                            <!-- Your existing row structure -->
                                                                            <!-- This is your template for each row -->

                                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                <div class="col-11 m-0 p-0 pr-2">
                                                                                    <label class="font-weight-bold text-dark" for="cutting_to_product">Quality</label>
                                                                                    <select class="form-control searchableSelect" name="cutting_to_product[]">
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
                                                            </div>


                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="row m-0 p-0 my-4 justify-content-end">
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

                                            </div>



                                            <div class="row  justify-content-end">
                                                <div class="col-lg-1 d-inline text-left p-0">

                                                    <a target="_blank" href="print_production.php?print=<?= $ProductionID ?>&type=cutting&part=production" id="showData1">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>

                                                    <input class="btn btn-success" type="submit" value="Save" name="cutting_btn">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div id="contact" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" id="print_voucher_form" method="post">
                                            <input type="hidden" id="hiddenInput2" value="<?= @$printfetch['id'] ?>" name="print_id">
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
                                                        <option value="">Party Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$printfetch['print_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?php echo  ucwords($row["customer_name"]) ?>
                                                                (<?= ucwords($row['customer_type']) ?>)
                                                            </option>

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
                                                            <option <?= (@$printfetch['print_quality'] == $row["product_id"]) ? 'selected' : ''; ?> data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
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
                                                    <a target="_blank" href="print_production.php?print=<?= $ProductionID ?>&part=print_voucher" id="showData2">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="print_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="Dyeing_content" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput3" value="<?= @$deyeingfetch['id'] ?>" name="deyeing_id">
                                            <div class="row pb-2">
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="dyeing_date">Date</label>
                                                    <input type="date" class="form-control" name="dyeing_date" id="dyeing_date" value="<?= date('Y-m-d') ?>" placeholder="Select Date">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Party Name">Party Name</label>


                                                    <select class="form-control searchableSelect" name="dyeing_party_name" id="dyeing_party_name">
                                                        <option value="">Part Name</option>
                                                        <?php

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE  customer_type = 'dyeing' and customer_status = 1");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$deyeingfetch['dey_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?php echo  ucwords($row["customer_name"]) ?>
                                                                (<?= ucwords($row['customer_type']) ?>) </option>

                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="gate_no">Gate Pass No.</label>
                                                    <input type="text" class="form-control" name="dyeing_gate_no" id="dyeing_gate_no" value="<?= isset($deyeingfetch['dey_gate_no']) ? @$deyeingfetch['dey_gate_no'] : @$purchase_data['gate_pass'] ?>" placeholder="Gate pass no.">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="dyeing_lat_name">Lat no.</label>
                                                    <input type="text" class="form-control" name="dyeing_lat_name" id="dyeing_lat_name" value="<?= @$deyeingfetch['dey_lat_no'] ?>" placeholder="Lat Number">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Party Voucher No.">Party Voucher No.</label>
                                                    <input type="text" class="form-control" name="dyeing_party_voucher" id="dyeing_party_voucher" value="<?= @$deyeingfetch['dey_voucher_no'] ?>" placeholder="Party Voucher No.">
                                                </div>
                                                <div class="col-lg-2 mt-3 pr-1">
                                                    <label class="font-weight-bold text-dark" for="color">Color Name</label>
                                                    <input type="text" class="form-control" name="dyeing_color_name" id="dyeing_color_name" value="<?= @$deyeingfetch['dey_color_name'] ?>" placeholder="Name">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Location">Location</label>
                                                    <input type="text" class="form-control" name="dyeing_location" id="dyeing_location" value="<?= isset($deyeingfetch['dey_location']) ? @$deyeingfetch['dey_location'] : @$purchase_data['pur_location'] ?>" placeholder="Location">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark">Bill No.</label>
                                                    <input type="number" min="0" placeholder="Bil No." value="<?= isset($deyeingfetch['dey_bill_no']) ? @$deyeingfetch['dey_bill_no'] : @$purchase_data['bill_no'] ?>" autocomplete="off" class="form-control" name="dey_bill_no">
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark">Bilty No.</label>
                                                    <input type="number" min="0" placeholder="Bilty No." value="<?= isset($deyeingfetch['dey_bilty_no']) ? @$deyeingfetch['dey_bilty_no'] : @$purchase_data['bilty_no'] ?>" autocomplete="off" class="form-control" name="dey_bilty_no">
                                                </div>
                                                <div class="col-lg-4 mt-3">
                                                    <label class="font-weight-bold text-dark" for="remarks">Remarks</label>
                                                    <textarea name="dyeing_remarks" id="dyeing_remarks" placeholder="Remarks" class="form-control"><?= @$deyeingfetch['dey_remarks'] ?></textarea>
                                                </div>
                                                <div class="col-lg-2 mt-3">
                                                    <label class="font-weight-bold text-dark" for="Location">Delivery Date</label>
                                                    <input type="Date" class="form-control" name="dyeing_delivery_date" id="dyeing_delivery_date" value="<?= @$deyeingfetch['dey_delivery_date'] ?>" placeholder="Location">
                                                </div>


                                            </div>


                                            <div class="row mt-5">
                                                <div class="col">
                                                    <h4>
                                                        List
                                                    </h4>
                                                </div>
                                            </div>
                                            <div id="deyingContainer">
                                                <div class="list-container">
                                                    <div class="list-1 card">
                                                        <div class="card-header card-bg" align="center">
                                                            <div class="row">
                                                                <div class="col-12 mx-auto h4">
                                                                    <b class="text-center card-text">Sending</b>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row m-0 p-3">
                                                            <div id="voucher_rows_container3">
                                                                <div class="voucher_row3">



                                                                    <?php
                                                                    // print_r($deyeingfetch['dey_vouc_list']);
                                                                    if (@$deyeingfetch != 0) {
                                                                        $lowerdata10 = json_decode(@$deyeingfetch['dey_sending_list']);
                                                                        for ($x = 0; $x < count(@$lowerdata10->deying_product); $x++) {

                                                                    ?>

                                                                            <div id="dey3">
                                                                                <div class="row mt-3 m-0 p-0">

                                                                                    <div class="ccol-lg-4 col-md-4 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                        <div class="col-12 m-0 p-0 pr-2">
                                                                                            <label class=" font-weight-bold text-dark" for="deying_product">Quality</label>

                                                                                            <select class="form-control searchableSelect" name="deying_product[]">
                                                                                                <option value="">Select Product</option>
                                                                                                <?php
                                                                                                $purchase_data = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                                                $product_ids = array();

                                                                                                while ($rowdata = mysqli_fetch_array($purchase_data)) {
                                                                                                    $product_id = $rowdata['product_id'];
                                                                                                    $product_ids[] = $product_id;

                                                                                                    $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id");

                                                                                                    while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                                                        $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata2['brand_id']);
                                                                                                        $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata2['category_id']);
                                                                                                ?>


                                                                                                        <option <?= (@$lowerdata10->deying_product[$x] == $rowdata2["product_id"]) ? 'selected' : ''; ?> data-price="<?= $rowdata2["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata2["product_id"] ?>">
                                                                                                            <?= ucwords($rowdata2["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                                                        </option>

                                                                                                <?php   }
                                                                                                } ?>
                                                                                            </select>

                                                                                        </div>

                                                                                    </div>



                                                                                    <div class="col-lg-2 ml-2 col-md-2 col-sm-4 col-xs-4 row">
                                                                                        <label>Thaan</label>
                                                                                        <input type="text" class="form-control thaan3" value="<?= @$lowerdata10->dey_sending_thaan[$x] ?>" name="dey_sending_thaan[]" placeholder="Thaan">
                                                                                    </div>
                                                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                                                        <label>Gzanah</label>
                                                                                        <input type="text" class="form-control gzanah3" value="<?= @$lowerdata10->dey_sending_gzanah[$x] ?>" name="dey_sending_gzanah[]" placeholder="Gzanah">
                                                                                    </div>
                                                                                    <div class="col-lg-2 mr-auto col-md-2 col-sm-4 col-xs-4">
                                                                                        <label>Quantity</label>
                                                                                        <input type="text" class="form-control quantity3" value="<?= @$lowerdata10->dey_sending_quantity[$x] ?>" name="dey_sending_quantity[]" value="0" placeholder="Quanitity">
                                                                                    </div>

                                                                                    <div class=" align-items-end jus d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                                        <button type="button" class=" outline_none border-0 bg-white" onclick="deying_voucher_remove3(this)">
                                                                                            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        <?php
                                                                        }
                                                                        // }

                                                                    } else {
                                                                        ?>

                                                                        <div id="dey3">
                                                                            <div class="row mt-3 m-0 p-0">

                                                                                <div class="ccol-lg-4 col-md-4 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                    <div class="col-12 m-0 p-0 pr-2">
                                                                                        <label class=" font-weight-bold text-dark" for="deying_product">Quality</label>

                                                                                        <select class="form-control searchableSelect" name="deying_product[]">
                                                                                            <option value="">Select Product</option>
                                                                                            <?php
                                                                                            $purchase_data = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                                            $product_ids = array();

                                                                                            while ($rowdata = mysqli_fetch_array($purchase_data)) {
                                                                                                $product_id = $rowdata['product_id'];
                                                                                                $product_ids[] = $product_id;

                                                                                                $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id");

                                                                                                while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                                                    $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata2['brand_id']);
                                                                                                    $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata2['category_id']);
                                                                                            ?>


                                                                                                    <option <?= (@$lowerdata10->deying_product[$x] == $rowdata2["product_id"]) ? 'selected' : ''; ?> data-price="<?= $rowdata2["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata2["product_id"] ?>">
                                                                                                        <?= ucwords($rowdata2["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                                                    </option>

                                                                                            <?php   }
                                                                                            } ?>
                                                                                        </select>

                                                                                    </div>

                                                                                </div>



                                                                                <div class="col-lg-2 ml-2 col-md-2 col-sm-4 col-xs-4 row">
                                                                                    <label>Thaan</label>
                                                                                    <input type="text" class="form-control thaan3" value="<?= @$lowerdata10->dey_sending_thaan[$x] ?>" name="dey_sending_thaan[]" placeholder="Thaan">
                                                                                </div>
                                                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                                                    <label>Gzanah</label>
                                                                                    <input type="text" class="form-control gzanah3" value="<?= @$lowerdata10->dey_sending_gzanah[$x] ?>" name="dey_sending_gzanah[]" placeholder="Gzanah">
                                                                                </div>
                                                                                <div class="col-lg-2 mr-auto col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Quantity</label>
                                                                                    <input type="text" class="form-control quantity3" value="<?= @$lowerdata10->dey_sending_quantity[$x] ?>" name="dey_sending_quantity[]" value="0" placeholder="Quanitity">
                                                                                </div>

                                                                                <div class=" align-items-end jus d-flex col-lg-1 col-md-2 col-sm-4 col-xs-4 add_remove">
                                                                                    <button type="button" class=" outline_none border-0 bg-white" onclick="deying_voucher_remove3(this)">
                                                                                        <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row m-0 p-0 my-4 justify-content-end">
                                                            <div class="col-lg-1">
                                                                <div id="cutt_voucher_btn">
                                                                    <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_duplicateRow5()">
                                                                        <img src="img/add.png" width="30px" alt="add sign">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-2 card">
                                                        <div class="card-header card-bg" align="center">
                                                            <div class="row">
                                                                <div class="col-12 mx-auto h4">
                                                                    <b class="text-center card-text">Recieving</b>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row m-0 p-3">
                                                            <div id="voucher_rows_container4">
                                                                <div class="voucher_row4">



                                                                    <?php
                                                                    // print_r($deyeingfetch['dey_vouc_list']);
                                                                    if (@$deyeingfetch != 0) {
                                                                        $lowerdata12 = json_decode(@$deyeingfetch['dey_recieving_list']);
                                                                        for ($x = 0; $x < count(@$lowerdata12->dey_recieving_product); $x++) {

                                                                    ?>

                                                                            <div id="dey4">
                                                                                <div class="row mt-3 m-0 p-0">
                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                        <div class="col-12 m-0 p-0 pr-2">
                                                                                            <label class=" font-weight-bold text-dark" for="dey_recieving_product">Quality</label>

                                                                                            <select class="form-control searchableSelect" name="dey_recieving_product[]">
                                                                                                <option value="">Select Product</option>
                                                                                                <?php
                                                                                                $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                                                $product_ids2 = array();

                                                                                                while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                                                    $product_id2 = $rowdata2['product_id'];
                                                                                                    $product_ids2[] = $product_id;

                                                                                                    $purchase_data3 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id2");

                                                                                                    while ($rowdata3 = mysqli_fetch_array($purchase_data3)) {
                                                                                                        $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata3['brand_id']);
                                                                                                        $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata3['category_id']);
                                                                                                ?>


                                                                                                        <option <?= (@$lowerdata12->dey_recieving_product[$x] == $rowdata3["product_id"]) ? 'selected' : ''; ?> data-price="<?= $rowdata3["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata3["product_id"] ?>">
                                                                                                            <?= ucwords($rowdata3["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                                                        </option>

                                                                                                <?php   }
                                                                                                } ?>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                        <label>Thaan</label>
                                                                                        <input type="text" class="form-control thaan2" value="<?= @$lowerdata12->dey_recieving_thaan[$x] ?>" name="dey_recieving_thaan[]" placeholder="Thaan">
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                        <label>Gzanah</label>
                                                                                        <input type="text" class="form-control gzanah2" value="<?= @$lowerdata12->dey_recieving_gzanah[$x] ?>" name="dey_recieving_gzanah[]" placeholder="Gzanah">
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                        <label>Quantity</label>
                                                                                        <input type="text" class="form-control quantity2" value="<?= @$lowerdata12->dey_recieving_quantity[$x] ?>" name="dey_recieving_quantity[]" value="0" placeholder="Quanitity">
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                        <label class="font-weight-bold text-dark" for="C-P">C-P</label>
                                                                                        <input type="text" class="form-control" name="dyeing_cp[]" id="dyeing_cp" value="<?= @$lowerdata12->dyeing_cp[$x] ?>" placeholder="C-P">
                                                                                    </div>


                                                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 d-flex align-items-end">
                                                                                        <div class="form-group mb-0">
                                                                                            <label class="font-weight-bold text-dark">Shortage</label>
                                                                                            <input type="text" class="form-control" id="deying_Shortage" name="deying_Shortage[]" placeholder="Shortage" required value="<?= @$lowerdata12->deying_Shortage[$x] ?>">
                                                                                        </div>
                                                                                        <div class="add_remove">
                                                                                            <button type="button" class=" outline_none border-0 bg-white" onclick="deying_voucher_remove4(this)">
                                                                                                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>



                                                                        <?php
                                                                        }
                                                                        // }

                                                                    } else {
                                                                        ?>

                                                                        <div id="dey4">
                                                                            <div class="row mt-3 m-0 p-0">
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 row m-0 p-0">
                                                                                    <div class="col-12 m-0 p-0 pr-2">
                                                                                        <label class=" font-weight-bold text-dark" for="dey_recieving_product">Quality</label>

                                                                                        <select class="form-control searchableSelect" name="dey_recieving_product[]">
                                                                                            <option value="">Select Product</option>
                                                                                            <?php
                                                                                            $purchase_data2 = mysqli_query($dbc, "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$request_id'");
                                                                                            $product_ids2 = array();

                                                                                            while ($rowdata2 = mysqli_fetch_array($purchase_data2)) {
                                                                                                $product_id2 = $rowdata2['product_id'];
                                                                                                $product_ids2[] = $product_id;

                                                                                                $purchase_data3 = mysqli_query($dbc, "SELECT * FROM `product` WHERE `product_id` = $product_id2");

                                                                                                while ($rowdata3 = mysqli_fetch_array($purchase_data3)) {
                                                                                                    $getBrand = fetchRecord($dbc, "brands", "brand_id", $rowdata3['brand_id']);
                                                                                                    $getCat = fetchRecord($dbc, "categories", "categories_id", $rowdata3['category_id']);
                                                                                            ?>


                                                                                                    <option <?= (@$lowerdata12->dey_recieving_product[$x] == $rowdata3["product_id"]) ? 'selected' : ''; ?> data-price="<?= $rowdata3["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $rowdata3["product_id"] ?>">
                                                                                                        <?= ucwords($rowdata3["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                                                                    </option>

                                                                                            <?php   }
                                                                                            } ?>
                                                                                        </select>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Thaan</label>
                                                                                    <input type="text" class="form-control thaan2" value="<?= @$lowerdata12->dey_recieving_thaan[$x] ?>" name="dey_recieving_thaan[]" placeholder="Thaan">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Gzanah</label>
                                                                                    <input type="text" class="form-control gzanah2" value="<?= @$lowerdata12->dey_recieving_gzanah[$x] ?>" name="dey_recieving_gzanah[]" placeholder="Gzanah">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label>Quantity</label>
                                                                                    <input type="text" class="form-control quantity2" value="<?= @$lowerdata12->dey_recieving_quantity[$x] ?>" name="dey_recieving_quantity[]" value="0" placeholder="Quanitity">
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                                                    <label class="font-weight-bold text-dark" for="C-P">C-P</label>
                                                                                    <input type="text" class="form-control" name="dyeing_cp[]" id="dyeing_cp" value="<?= @$lowerdata12->dyeing_cp[$x] ?>" placeholder="C-P">
                                                                                </div>


                                                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 d-flex align-items-end">
                                                                                    <div class="form-group mb-0">
                                                                                        <label class="font-weight-bold text-dark">Shortage</label>
                                                                                        <input type="text" class="form-control" id="deying_Shortage" name="deying_Shortage[]" placeholder="Shortage" required value="<?= @$lowerdata12->deying_Shortage[$x] ?>">
                                                                                    </div>
                                                                                    <div class="add_remove">
                                                                                        <button type="button" class=" outline_none border-0 bg-white" onclick="deying_voucher_remove4(this)">
                                                                                            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row m-0 p-0 my-4 justify-content-end">
                                                            <div cs="col-lg-1">
                                                                <div id="cutt_voucher_btn">
                                                                    <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_duplicateRow4()">
                                                                        <img src="img/add.png" width="30px" alt="add sign">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                            </div>


                                            <div class="row justify-content-end">
                                                <div class="col-lg-2  text-right">
                                                    <a target="_blank" href="print_production.php?print=<?= $ProductionID ?>&type=deyeing&part=production" id="showData3">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="dyeing_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="print_content" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput4" value="<?= @$singlePrintfetch['id'] ?>" name="single_print_id">
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

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$singlePrintfetch['single_party_name'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?php echo  ucwords($row["customer_name"]) ?>
                                                                (<?= ucwords($row['customer_type']) ?>) </option>

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
                                                    <a target="_blank" href="print_production.php?print=<?= $ProductionID ?>&part=single_print" id="showData4">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="singleprint_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="embroidery_content" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput5" value="<?= @$embroideryVoucherfetch['id'] ?>" name="embroidery_voucher_id">
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
                                                    <a target="_blank" id="showData5" href="print_production.php?print=<?= $ProductionID ?>&part=embroidery">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="embroidery_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="collect_emb_content" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput6" value="<?= @$collectEmbroideryfetch['id'] ?>" name="col_embroidery_id">
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
                                                    <a target="_blank" id="showData6" href="print_production.php?print=<?= $ProductionID ?>&part=collect_embroidery">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="collect_embroidery_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="stitch_pack_content" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput7" value="<?= @$stichingfetch['id'] ?>" name="stiching_id">
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

                                                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1");
                                                        while ($row = mysqli_fetch_array($result)) {

                                                        ?>
                                                            <option <?= (@$stichingfetch['stiching_party_no'] == $row["customer_id"]) ? 'selected' : ''; ?> value="<?= $row["customer_id"] ?>">
                                                                <?php echo  ucwords($row["customer_name"]) ?>
                                                                (<?= ucwords($row['customer_type']) ?>) </option>

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
                                                    <a target="_blank" id="showData7" href="print_production.php?print=<?= $ProductionID ?>&part=stiching_packing">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
                                                    <input class="btn btn-success" type="submit" value="Save" name="stitching_btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="calander_satander_content" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                                        <form action="" method="post">
                                            <input type="hidden" id="hiddenInput8" value="<?= @$cal_salFetch['id'] ?>" name="cal_sal_id">
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
                                                    <a target="_blank" id="showData8" href="print_production.php?print=<?= $ProductionID ?>&part=calender_salender">
                                                        <div class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </div>
                                                    </a>
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



    for (let i = 1; i <= 8; i++) {
        if (document.getElementById('hiddenInput' + i).value == '') {
            document.getElementById('showData' + i).style.display = 'none';
        } else {
            document.getElementById('showData' + i).style.display = 'inline';
        }
    }
    $(document).ready(function() {
        // Function to calculate and update the quantity
        function calculateQuantity() {
            // Get the values from the thaan and gzanah inputs
            var thaan = parseFloat($('#thaan').val()) || 0;
            var gzanah = parseFloat($('#gzanah').val()) || 0;

            // Calculate the quantity (thaan * gzanah)
            var quantity = thaan * gzanah;

            // Update the quantity input field with the result
            $('#quantity').val(quantity);
        }

        // Attach event listeners to thaan and gzanah inputs
        $('#thaan, #gzanah').on('input', function() {
            calculateQuantity();
        });
    });

    $(document).ready(function() {
        // Function to calculate and update the quantity for a specific row
        function calculateQuantity(row) {
            var thaan = parseFloat($(row).find('.thaan').val()) || 0; // Get thaan value, default to 0 if invalid
            var gzanah = parseFloat($(row).find('.gzanah').val()) || 0; // Get gzanah value, default to 0 if invalid

            var quantity = thaan * gzanah; // Calculate quantity

            $(row).find('.quantity').val(quantity); // Update the quantity field in the row
        }

        // Attach event listeners to thaan and gzanah inputs for each row
        $('#container').on('input', '.thaan, .gzanah', function() {
            var row = $(this).closest('.row'); // Find the closest row to the input that triggered the event
            calculateQuantity(row); // Calculate quantity for the current row
        });
    });
    $(document).ready(function() {
        // Function to calculate and update the quantity for a specific row
        function calculateQuantity2(row) {
            var thaan2 = parseFloat($(row).find('.thaan2').val()) || 0; // Get thaan2 value, default to 0 if invalid
            var gzanah2 = parseFloat($(row).find('.gzanah2').val()) || 0; // Get gzanah2 value, default to 0 if invalid

            var quantity2 = thaan2 * gzanah2; // Calculate quantity2

            $(row).find('.quantity2').val(quantity2); // Update the quantity2 field in the row
        }

        // Attach event listeners to thaan2 and gzanah2 inputs for each row
        $('#deyingContainer').on('input', '.thaan2, .gzanah2', function() {
            var row = $(this).closest('.row'); // Find the closest row to the input that triggered the event
            calculateQuantity2(row); // Calculate quantity for the current row
        });
    });
    $(document).ready(function() {
        // Function to calculate and update the quantity for a specific row
        function calculateQuantity3(row) {
            var thaan3 = parseFloat($(row).find('.thaan3').val()) || 0; // Get thaan3 value, default to 0 if invalid
            var gzanah3 = parseFloat($(row).find('.gzanah3').val()) || 0; // Get gzanah3 value, default to 0 if invalid

            var quantity3 = thaan3 * gzanah3; // Calculate quantity3

            $(row).find('.quantity3').val(quantity3); // Update the quantity3 field in the row
        }

        // Attach event listeners to thaan3 and gzanah3 inputs for each row
        $('#deyingContainer').on('input', '.thaan3, .gzanah3', function() {
            var row = $(this).closest('.row'); // Find the closest row to the input that triggered the event
            calculateQuantity3(row); // Calculate quantity for the current row
        });
    });
</script>