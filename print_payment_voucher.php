<?php
include_once 'includes/head.php';

if (isset($_REQUEST['voucher_id'])) {
    $id = $_REQUEST['voucher_id'];
    $voucher = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM vouchers WHERE voucher_id = '$id'"));
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    .container {
        width: 100%;
        margin: auto;
    }

    .title {
        text-align: center;
    }

    .date span {
        text-decoration: underline;
        color: red;
    }

    table,
    th,
    td {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        table-layout: fixed;
        padding: 10px 0px 10px 10px;
        color: black;
    }

    .remain {
        border-top: 1px solid red;
        color: red;
    }

    .detail {
        display: flex;
        justify-content: space-between;
        font-size: 16 !important;
    }

    .detail h3 {
        text-align: start;
    }
</style>

<body>
    <div class="container">
        <h2 class="title">Payment Voucher</h2>
        <div class="detail">
            <div>
                <h5 class="date">Voucher_ID :<span><?= $voucher['voucher_id'] ?></span></h5>
                <h5 class="date">Voucher Type: <span class="text-capitalize"><?= $voucher['payment_type'] ?></span></h5>
            </div>
            <div>
                <h5 class="date">Date: <span><?= $voucher['voucher_date'] ?> </span></h5>
                <h5 class="date">Amount: <span><?= $voucher['voucher_amount'] ?></span></h5>

            </div>
        </div>
        <!-- 1 -->
        <div class="mt-3">

            <table>
                <thead>
                    <tr>
                        <th>Party</th>
                        <th>Remarks</th>
                        <th>
                            <?php if ($_REQUEST['voucher_type'] == 'receive') {
                                echo 'Debit';
                            } else {
                                echo 'Credit';
                            } ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $voucher_id = $voucher['voucher_id'];
                    $query = mysqli_query($dbc, "SELECT * FROM transactions WHERE voucher_id = '$voucher_id' AND is_cash_in_hand = 0");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $customer = fetchRecord($dbc, 'customers', 'customer_id', $row['customer_id']);
                    ?>
                        <tr>
                            <td class="w-100 text-capitalize"><?= $customer['customer_name'] ?></td>
                            <td class="w-100"><?= $row['transaction_remarks'] ?></td>
                            <td class="w-100">
                            <?php if ($_REQUEST['voucher_type'] == 'receive') {
                                echo $row['debit'];
                            } else {
                                echo $row['credit'];
                            } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>



        </div>
    </div>
</body>
<?php include_once 'includes/foot.php'; ?>

<script>
    $(document).ready(function() {
        window.print();
    });
</script>