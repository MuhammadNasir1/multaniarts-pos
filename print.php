<!DOCTYPE html>
<html>
<?php include_once 'includes/head.php';

$get_company = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM company"));
$type = $_REQUEST['type'];

if ($type == 'dyeing') {
    $production_id = $_REQUEST['production'];
    $all_data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM deyeing WHERE dey_production_id = $production_id"));
}


?>
<style type="text/css">
    .container {
        height: 100% !important;
        background-color: #fff;
    }

    .border {
        border: 1px solid #000 !important;
    }

    .dots {
        border-bottom: 1px dashed #000 !important;
    }

    .thead_row th {
        color: #000 !important;
        font-size: 18px !important;
        border: 1px solid #000;
        text-align: center;
    }

    tbody td {

        border: 1px solid #000;
        text-align: center;
    }

    table {
        width: 100%;


    }

    .table_row {
        padding: 0px;
    }

    .tbody_row tr td {
        font-size: 17px;
        text-align: center;
        color: #000;

    }

    .capitalize {
        text-transform: capitalize;
    }
</style>

<body>


    <div class="container">
        <header class="dots">
            <div class="row">
                <div class="col-sm-9 mt-3 d-flex justify-content-start">
                    <div align="left">
                        <h1 class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['name']) ?></h1>
                        <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['email']) ?></p>
                        <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['company_phone']) ?></p>
                        <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['address']) ?></p>
                    </div>
                </div>
                <div class="col-sm-3 d-flex justify-content-end">
                    <img src="img/logo/<?= $get_company['logo'] ?>" width="150" class="img-fluid" style="margin-top: 10px">
                </div>
            </div>
        </header>


        <div class="row px-3">
            <div class="pt-2  col-sm-6  pl-0">
                <p class="h4 border p-2 font-weight-bold float-left"> Invoice # <b class="capitalize"><?= $type ?></b></p>
            </div>
            <div class="pt-2   col-sm-6 pr-0">
                <p class="h4 border p-2 font-weight-bold float-right"> Date :
                    <b>
                        <?php if ($type == 'dyeing') {
                            echo $all_data['dey_date'];
                        } ?>
                    </b>
                </p>
            </div>
        </div>

        <?php if ($type == 'dyeing') { ?>
            <table class="table">
                <tr>
                    <th class="border font-weight-bold">Party Name</th>
                    <th class="border">
                        <?php
                        $id = $all_data['dey_party_name'];
                        $result = mysqli_query($dbc, "SELECT * FROM customers WHERE  customer_id = $id");
                        while ($row = mysqli_fetch_array($result)) {

                        ?>
                            <?php echo  ucwords($row["customer_name"]) ?>
                            (<?= ucwords($row['customer_type']) ?>)
                        <?php   } ?>
                    </th>
                    <th class="border font-weight-bold">Gate Pass No</th>
                    <th class="border"><?= $all_data['dey_gate_no'] ?></th>
                    <th class="border font-weight-bold">Lat No</th>
                    <th class="border"><?= $all_data['dey_lat_no'] ?></th>
                </tr>
                <tr>
                    <th class="border font-weight-bold">Part Voucher No</th>
                    <th class="border"><?= $all_data['dey_voucher_no'] ?></th>
                    <th class="border font-weight-bold">Color Name</th>
                    <th class="border"><?= $all_data['dey_color_name'] ?></th>
                    <th class="border font-weight-bold">Location</th>
                    <th class="border"><?= $all_data['dey_location'] ?></th>
                </tr>
                <tr>
                    <th class="border font-weight-bold">Bill No</th>
                    <th class="border"><?= $all_data['dey_bill_no'] ?></th>
                    <th class="border font-weight-bold">Bilty No</th>
                    <th class="border"><?= $all_data['dey_bilty_no'] ?></th>
                    <th class="border font-weight-bold">Delivery Date</th>
                    <th class="border"><?= $all_data['dey_delivery_date'] ?></th>
                </tr>
            </table>
            <div class="d-flex">
                <?php if (isset($all_data['dey_sending_list'])) { ?>
                    <div class="px-3 w-100">
                        <h3 class="text-center">Sending</h3>
                        <div class="row table_row mt-4">
                            <div class="col-sm-12 p-0">
                                <table class="w-100">
                                    <thead class="thead_row">
                                        <th>Sr</th>
                                        <th>Quality</th>
                                        <th>Thaan</th>
                                        <th>Gzanah</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody class="tbody_row">
                                        <?php
                                        if (@$all_data != 0) {
                                            $lowerdata = json_decode(@$all_data['dey_sending_list']);
                                            for ($x = 0; $x < count(@$lowerdata->deying_product); $x++) {
                                        ?>
                                                <tr>
                                                    <td><?= $x + 1 ?></td>
                                                    <td>
                                                        <?php
                                                        $id = $lowerdata->deying_product[$x];
                                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE product_id = $id ");
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                        ?>
                                                            <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                        <?php   } ?>
                                                    </td>
                                                    <td> <?= @$lowerdata->dey_sending_thaan[$x] ?> </td>
                                                    <td> <?= @$lowerdata->dey_sending_gzanah[$x] ?> </td>
                                                    <td> <?= @$lowerdata->dey_sending_quantity[$x] ?> </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                if (isset($all_data['dey_recieving_list'])) {
                    $lowerdata = json_decode($all_data['dey_recieving_list'], true);
                    $hasData = false;
                    if (!empty($lowerdata['dey_recieving_product'])) {
                        foreach ($lowerdata['dey_recieving_product'] as $value) {
                            if (!empty(trim($value))) {
                                $hasData = true;
                                break;
                            }
                        }
                    }

                    if ($hasData) { ?>
                        <div class="px-3 recieving ml-3 w-100">
                            <h3 class="text-center ">Receiving</h3>
                            <div class="row table_row mt-4">
                                <div class="col-sm-12 p-0">
                                    <table class="w-100">
                                        <thead class="thead_row">
                                            <th>Sr</th>
                                            <th>Quality</th>
                                            <th>Thaan</th>
                                            <th>Gzanah</th>
                                            <th>Quantity</th>
                                            <th>C-P</th>
                                            <th>Shortage</th>
                                        </thead>
                                        <tbody class="tbody_row">
                                            <?php
                                            for ($x = 0; $x < count($lowerdata['dey_recieving_product']); $x++) {
                                                if (!empty($lowerdata['dey_recieving_product'][$x])) { ?>
                                                    <tr>
                                                        <td><?= $x + 1 ?></td>
                                                        <td>
                                                            <?php
                                                            $id = $lowerdata['dey_recieving_product'][$x];
                                                            $result = mysqli_query($dbc, "SELECT * FROM product WHERE product_id = '$id' ");
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                                                $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                                            ?>
                                                                <?= ucwords($row["product_name"]) ?> | <?= ucwords(@$getBrand["brand_name"]) ?>(<?= ucwords(@$getCat["categories_name"]) ?>)
                                                            <?php   } ?>
                                                        </td>
                                                        <td> <?= @$lowerdata['dey_recieving_thaan'][$x] ?> </td>
                                                        <td> <?= @$lowerdata['dey_recieving_gzanah'][$x] ?> </td>
                                                        <td> <?= @$lowerdata['dey_recieving_quantity'][$x] ?> </td>
                                                        <td> <?= @$lowerdata['dyeing_cp'][$x] ?> </td>
                                                        <td> <?= @$lowerdata['deying_Shortage'][$x] ?> </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                <?php }
                }
                ?>
            </div>

        <?php } ?>

        <div class="row" style="font-size: 18px">
            <div class="col-sm-12 pt-3" style="border-bottom: 1px solid black">
                <p class="" style="color: black ; ">
                    <?php
                    if ($_REQUEST['type'] == "dyeing") {
                    ?>
                        <b>Details</b> : <?= $all_data['dey_remarks'] ?>
                    <?php } else { ?>
                        <b>Details</b> : <?= @$order['order_narration'] ?>
                    <?php } ?>
                </p>

            </div>

            <div class="col-sm-3 pt-3 h4">
                Prepared By : __________________
            </div>
            <div class="col-sm-6 ">

            </div>
            <div class="col-sm-3 h4">
                Recevied By : _________________
            </div>

            <div class="px-3">
                <div class="notices">
                    <h4><strong>Thank you so much for choosing
                            <b class="name">
                                <?= $get_company['name'] ?>
                            </b></strong></h4>
                    <p class="notice"> Software Developed By : <b class="name">The Web Concept (0345-7573667)</b></p>

                </div>
            </div>
        </div>
    </div>


</body>

</html>