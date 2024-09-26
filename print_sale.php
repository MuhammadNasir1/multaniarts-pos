<!DOCTYPE html>
<html>
<?php include_once 'includes/head.php';


?>
<style type="text/css">
    .container {
        height: 100% !important;
        background-color: #fff;
        border-bottom: 1px dashed #000 !important;
    }

    .border {

        border: 1px solid #000 !important;
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

        border: 1px solid #000;
        padding: 0px;
    }

    .tbody_row tr td {
        font-size: 17px;
        font-weight: bolder;
        text-align: center;
        color: #000;

    }

    .tfoot_row tr td {
        font-size: 17px;
        font-weight: bolder;
        color: #000;
        text-align: center;

    }
</style>

<body>
    <?php for ($i = 0; $i < 1; $i++) :
        $totalQTY = 0;
        if ($i > 0) {
            $margin = "margin-top:-270px !important";
            $copy = "Company Copy";
        } else {
            $margin = "";
            $copy = "Customer Copy";
        }

        if ($_REQUEST['type'] == "purchase") {
            $order = fetchRecord($dbc, "purchase", "purchase_id", $_REQUEST['id']);
            $table_row = "390px";
            $getDate = $order['purchase_date'];
            if ($order['payment_type'] == "credit_purchase") {

                $order_type = "credit purchase";
            } else {
                $order_type = "cash purchase";
            }
            $order_item = mysqli_query($dbc, "SELECT purchase_item.*,product.* FROM purchase_item INNER JOIN product ON purchase_item.product_id=product.product_id WHERE purchase_item.purchase_id='" . $_REQUEST['id'] . "'");
        } else {

            $order = fetchRecord($dbc, "orders", "order_id", $_REQUEST['id']);
            $getDate = $order['order_date'];

            $order_item = mysqli_query($dbc, "SELECT order_item.*,product.* FROM order_item INNER JOIN product ON order_item.product_id=product.product_id WHERE order_item.order_id='" . $_REQUEST['id'] . "'");
            if ($order['payment_type'] == "credit_sale") {
                $table_row = "390px";
                if ($order['payment_type'] == "none") {
                    $order_type = "credit sale";
                } else {
                    $order_type = $order['credit_sale_type'] . " (Credit)";
                }
            } else {
                $order_type = "cash sale";
                $table_row = "450px";
            }
        }
    ?>

        <div class="container">
            <?php if ($order['payment_type']) : ?>


                <header>
                    <div class="row">
                        <div class="col-sm-9 mt-3 d-flex justify-content-start">
                            <div align="left">
                                <h1 class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['name']) ?></h1>
                                <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['email']) ?></p>
                                <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['company_phone']) ?></p>
                                <p class="font-weight-bold m-0 p-0 pt-2"><?= ucwords($get_company['address']) ?></p>
                            </div>
                        </div>
                        <!-- <center style="width: 100%;margin-top: -5px;"></center> -->
                        <div class="col-sm-3 d-flex justify-content-end">
                            <img src="img/logo/<?= $get_company['logo'] ?>" width="150" class="img-fluid" style="margin-top: 10px">
                        </div>
                    </div>
                </header>
            <?php endif ?>
            <div class="row">
                <div class="pt-2  col-sm-6  pl-0">
                    <p class="h4 border p-2 font-weight-bold float-left"> Invoice # <b><?= $_REQUEST['id'] ?></b></p>
                </div>
                <div class="pt-2   col-sm-6 pr-0">

                    <p class="h4 border p-2 font-weight-bold float-right"> Date : <b>
                            <?php //getDateFormat("D d-M-Y h:i a",($order['timestamp']))
                            ?>
                            <?php
                            echo $date = date('D d-M-Y h:i A', strtotime($order['timestamp'] . " +10 hours"));
                            ?>


                        </b></p>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-between m-0 p-0 col-12">
                    <div class="m-0 p-0">
                        <table class="table">
                            <tr>
                                <th class="border pr-5 font-weight-bold">Customer Name</th>
                                <th class="border pr-5"><?= ucwords($order['client_name']) ?></th>
                            </tr>
                            <tr>
                                <th class="border pr-5 font-weight-bold">Purchase</th>
                                <th class="border pr-5"><?= ucwords($order['purchase_for']) ?></th>
                            </tr>
                            <tr>
                                <th class="border pr-5 font-weight-bold">Gate Pass</th>
                                <th class="border pr-5"><?= ucwords($order['gate_pass']) ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="m-0 p-0">
                        <table class="table" align="left">
                            <tr>
                                <th class="border pr-5 font-weight-bold">Customer Contact</th>
                                <th class="border pr-5"><?= ucwords($order['client_contact']) ?></th>
                            </tr>
                            <tr>
                                <th class="border pr-5 font-weight-bold">Bill No</th>
                                <th class="border pr-5"><?= ucwords($order['bill_no']) ?></th>
                            </tr>
                            <tr>
                                <th class="border pr-5 font-weight-bold">Bilty No</th>
                                <th class="border pr-5"><?= ucwords($order['bilty_no']) ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="row ">
                <div class="col-6 pl-0">
                    <table class="table">
                        <tr>
                            <th class="border font-weight-bold">Customer Name</th>
                            <td class="border"><?= ucwords($order['client_name']) ?></td>
                        </tr>
                        <tr>
                            <th class="border font-weight-bold">Purchase</th>
                            <td class="border"><?= ucwords($order['purchase_for']) ?></td>
                        </tr>
                        <tr>
                            <th class="border font-weight-bold">Gate Pass</th>
                            <td class="border"><?= ucwords($order['gate_pass']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6 p-0 d-flex justify-content-end">
                    <table class="table">
                        <tr>
                            <th class="border font-weight-bold">Customer Contact</th>
                            <td class="border"><?= ucwords($order['client_contact']) ?></td>
                        </tr>
                        <tr>
                            <th class="border font-weight-bold">Bill No</th>
                            <td class="border"><?= ucwords($order['bill_no']) ?></td>
                        </tr>
                        <tr>
                            <th class="border font-weight-bold">Bilty No</th>
                            <td class="border"><?= ucwords($order['bilty_no']) ?></td>
                        </tr>
                    </table>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="  col-sm-4  ">
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Customer Name </p>
                    <p class="h4 border p-0 m-0 font-weight-bold text-center"><b><?= ucwords($order['client_name']) ?></b></p>
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Purchase : <span><?= ucwords($order['purchase_for']) ?></span></p>
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Gate Pass : <span><?= ucwords($order['gate_pass']) ?></span></p>
                </div>
                <div class="col-sm-4">
                    <h2 class="text-center p-0 m-0">Bill</h2>
                    <h4 class="text-center p-0 m-0"><?= @$order_type ?></h4>
                </div>
                <div class="  col-sm-4 ">
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Customer Contact </p>
                    <p class="h4 border p-0 m-0 font-weight-bold text-center"><b><?= $order['client_contact'] ?></b></p>
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Bill No : <span><?= ucwords($order['bill_no']) ?></span></p>
                    <p class="h4 border border-bottom-0 text-center p-0 m-0 font-weight-bold"> Billty No : <span><?= ucwords($order['bilty_no']) ?></span></p>
                </div>

            </div> -->
            <div class="row table_row mt-4" style="min-height: <?= $table_row ?>;">
                <div class="col-sm-12 p-0">
                    <table class="w-100">
                        <thead class="thead_row">
                            <th>Sr</th>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>Thaan</th>
                            <th>Gzanah</th>
                            <th>Unit</th>
                            <th>TOTAL</th>
                        </thead>
                        <tbody class="tbody_row">
                            <?php $c = 0;
                            while ($r = mysqli_fetch_assoc($order_item)) {
                                $c++;
                                //print_r($order);
                            ?>
                                <tr>
                                    <td><?= $c ?></td>
                                    <td><?= strtoupper($r['product_name']) ?></td>
                                    <td><?= $r['rate'] ?></td>
                                    <td><?= $r['quantity'] ?></td>
                                    <td><?= $r['pur_thaan'] ?></td>
                                    <td><?= $r['pur_gzanah'] ?></td>
                                    <td><?= ucwords($r['pur_unit']) ?></td>
                                    <td><?= $r['rate'] * $r['quantity'] ?></td>
                                </tr>

                            <?php
                                $totalQTY += $r['quantity'];
                            } ?>
                        </tbody>
                        <tfoot class="tfoot_row">

                            <tr>
                                <td colspan="6"></td>
                                <td class="border"><b>Sub Total</b></td>
                                <td class="border"><?= $order['total_amount'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td class="border"><b>Total Quantity</b></td>
                                <td class="border"><?= $totalQTY ?></td>
                            </tr>
                            <?php
                            if ($order['discount'] > 0) {


                            ?>
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="border">DISCOUNT%</td>
                                    <td class="border"><?= $order['discount'] ?>%</td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6"></td>
                                <td class="border">FREIGHT</td>

                                <td class="border"><b><?= empty($order['pur_freight']) ? "0" : $order['pur_freight'] ?></b></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td class="border">GRAND TOTAL</td>

                                <td class="border"><b><?= number_format($order['grand_total'], 2) ?></b></td>
                            </tr>
                            <?php if ($order['payment_type'] == "credit_purchase") : ?>

                                <tr>
                                    <td colspan="6"></td>
                                    <td class="border">Previous Balance</td>

                                    <td class="border"><b><?= getcustomerBlance($dbc, $order['customer_account']) + $order['due'] ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="border">Current Balance</td>

                                    <td class="border"><b><?= number_format(getcustomerBlance($dbc, $order['customer_account']), 2) ?></b></td>
                                </tr>

                            <?php endif; ?>


                        </tfoot>
                    </table>
                </div>
            </div>


            <div class="row" style="font-size: 18px">
                <div class="col-sm-12" style="border-bottom: 1px solid black">
                    <p class="" style="color: black ; ">
                        <b>Details</b> : <?= $order['purchase_narration'] ?>
                    </p>

                </div>

                <div class="col-sm-3 h4">
                    Prepared By : __________________
                </div>
                <div class="col-sm-6 ">
                    <?php
                    if (isset($order['vehicle_no'])) {
                        // code...

                    ?>
                        <p class="4 mt-1 text-center"> Vehicle No : <b><u><?= strtoupper($order['vehicle_no']) ?></u></b></p>

                    <?php
                    }
                    ?>

                    <p class="text-dark text-center p-0 m-0"><?= $copy ?></p>
                </div>
                <div class="col-sm-3 h4">
                    Recevied By : _________________
                </div>

                <div class="">
                    <div class="notices">
                        <h4><strong>Thank you so much for choosing
                                <b class="name">
                                    <?= $get_company['name'] ?>
                                </b></strong></h4>
                        <p class="notice"> Software Developed By : <b class="name">Samz Creation (0345-7573667)</b></p>

                    </div>
                </div>
            </div>
        </div> <!-- end of container -->
    <?php endfor; ?>


</body>

</html>
<script type="text/javascript">
    window.print();
</script>