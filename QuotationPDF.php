<?php
// print_r(base64_decode($_REQUEST['QuotationID']));
// exit();
require 'php_action/db_connect.php';
require "dompdf/autoload.inc.php";

if (isset($_REQUEST['QuotationID']) && !empty($_REQUEST['QuotationID'])) {
    $quot_id = base64_decode($_REQUEST['QuotationID']);
    $q = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `quotations` WHERE quotation_id = $quot_id"));
    // print_r($q);
    // exit;
    $c = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `company` "));
    $created_date = date("F, d Y", strtotime($q['cust_date']));
    $due_date = date("F, d Y", strtotime($q['cust_due_date']));
}

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
ob_start();

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Quotation PDF</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        @media print {
            * {
                margin: 5px;
            }
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .first {
            border-bottom: 4px solid #97979E;
            padding-left: 10px;
        }

        .inline-float {
            float: left;
        }

        .inline-float td {
            padding: 5px 8px;
        }

        .wrapper {
            max-width: 100%;
            padding: 50px 10px;
        }

        .items_data p {
            font-weight: 700;
            color: #928878;
            text-align: center;
            margin-bottom: 10px;
        }

        thead {
            background-color: #97979e8f;
        }

        thead th {
            padding: 8px 10px;
            border-bottom: 2px solid grey;
        }

        .invoice-body tbody td {
            padding: 8px 10px;
        }

        .table {
            border-collapse: collapse;
        }

        tfoot td {
            font-size: 22px;
            padding: 8px 10px;
            font-weight: 700;
        }

        tfoot th {
            font-size: 17px;
            padding: 8px 10px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <header>
        <table class='first' width='100%'>
            <tr>
                <td style=' width: 50%;'>
                    <b style="font-size: 25px !important;color: #928878;letter-spacing: 1px;">INVOICE #<?= $q['quotation_number'] ?></b>
                    <h6 style="font-size: 18px;margin-bottom: 0px;color:#97979E;">Product Invoice</h6>
                </td>
                <td align='right' style='width: 50%;'>
                    <img src="img/logo/<?= @$c['logo'] ?>" alt='image' width="100vw">
                </td>
            </tr>
        </table>
    </header>

    <div class="wrapper">
        <div style="margin-bottom:50px;height:100px;">
            <div class="inline-float" style="width:60%;">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td style="color: #97979E;"><b>From</b></td>
                            <td style="color: #97979E;"><b>To</b></td>
                        </tr>
                        <tr>
                            <td><b><?= ucwords(@$c['name']) ?></b></td>
                            <td><b><?= ucwords(@$q['cust_name']) ?></b></td>
                        </tr>
                        <tr>
                            <td><?= ucfirst(@$c['address']) ?></td>
                            <td><?= ucfirst(@$q['cust_address']) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="inline-float" style="width:40%;">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td style="color: #97979E;text-align:right;"><b>Invoice No</b></td>
                            <td><b><?= $q['quotation_number'] ?></b></td>
                        </tr>
                        <tr>
                            <td style="color: #97979E;text-align:right;"><b>Invoice Date</b></td>
                            <td><b><?= @$created_date ?></b></td>
                        </tr>
                        <tr>
                            <td style="color: #97979E;text-align:right;"><b>Due Date</b></td>
                            <td><b><?= @$due_date ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        if ($q['note'] != '') {
        ?>
            <div style="clear: both;width:50%;padding:5px 10px;margin-bottom:50px;">
                <b style="margin-bottom: 8px;">
                    Summary
                </b>
                <p>
                    <?= ucfirst($q['note']) ?>.
                </p>
            </div>
        <?php
        }
        ?>
        <div class="items_data">
            <p>
                Invoice Items
            </p>
            <div class="invoice-body">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price per unit</th>
                            <th>weight (kg)</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = mysqli_query($dbc, "SELECT * FROM `quotation_items` WHERE `quotation_id` = '$q[quotation_id]'");
                        if (mysqli_num_rows($items) > 0) {
                            $i = 0;
                            $subtotal = 0;
                            while ($row = mysqli_fetch_assoc($items)) {
                                $subtotal += $row['sub_total'];
                                $i++;
                        ?>
                                <tr>
                                    <td style="text-align: center !important;border-bottom:1px solid #97979e8f;">
                                        <?= ucwords(@$row['product_name']) ?>
                                    </td>
                                    <td style="text-align: center !important;border-bottom:1px solid #97979e8f;">
                                        <?= @$row['product_quantity'] ?>
                                    </td>
                                    <td style="text-align: center !important;border-bottom:1px solid #97979e8f;">
                                        <?= $q['currency'] ?> <?= @$row['product_rate'] ?>
                                    </td>
                                    <td style="text-align: center !important;border-bottom:1px solid #97979e8f;">
                                        <?= @$row['kg_quantity'] ?>
                                    </td>
                                    <td style="text-align: center !important;background-color:#97979e40;border-bottom:1px solid #97979e8f;">
                                        <?= $q['currency'] ?> <?= number_format(@$row['sub_total']) ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="height: 50px;font-weight:700;" colspan="5">
                                Invoice Total
                            </th>
                        </tr>
                        <tr>
                            <th style="border-top:1px solid #97979e8f;border-bottom:1px solid #97979e8f;text-align:right;" colspan="4">
                                Sub Total
                            </th>
                            <th style="border-top:1px solid #97979e8f;background-color:#97979e40;border-bottom:1px solid #97979e8f;text-align:right;">
                            <?= $q['currency'] ?> <?= number_format(@$subtotal) ?>
                            </th>
                        </tr>
                        <tr>
                            <th style="border-top:1px solid #97979e8f;border-bottom:1px solid #97979e8f;text-align:right;" colspan="4">
                                Tax
                            </th>
                            <th style="border-top:1px solid #97979e8f;background-color:#97979e40;border-bottom:1px solid #97979e8f;text-align:right;">
                                <?= @$q['taxrate'] ?> %
                            </th>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid #97979e8f;border-bottom:1px solid #97979e8f;text-align:right;" colspan="4">
                                Total Due
                            </td>
                            <td style="border-top:1px solid #97979e8f;background-color:#97979e40;border-bottom:1px solid #97979e8f;text-align:right;">
                                <?= $q['currency'] ?> <?= number_format(@$q['grandtotal']) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
            if ($q['description'] != '') {
            ?>
                <div style="clear: both;width:50%;padding:5px 10px;margin-bottom:50px;">
                    <b style="margin-bottom: 8px;">
                        Description
                    </b>
                    <div>
                        <?= ucfirst($q['description']) ?>.
                    </div>
                </div>
            <?php
            }
            ?>
            <div style="margin-top: 30px;" class="invoice-body">
                <table border="1px" class="table" width="40%">
                    <thead>
                        <tr>
                            <th colspan="2">Bank Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bank Name</td>
                            <td><?= ucwords(@$c['bank_name']) ?></td>
                        </tr>
                        <tr>
                            <td>Account Name</td>
                            <td><?= ucwords(@$c['account_name']) ?></td>
                        </tr>
                        <tr>
                            <td>Account Number</td>
                            <td><?= @$c['account_number'] ?></td>
                        </tr>
                        <tr>
                            <td>IBAN Number</td>
                            <td><?= @$c['iban_number'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);
$options->set('chroot', realpath(''));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('Quotation.pdf', array('attachment' => 0));
?>