<?php include_once 'includes/head.php'; ?>
<?php
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
} else {
    $date = date('Y-m-d');
}

?>
<style>
    .container {
        font-family: Arial, sans-serif;
        padding: 20px;
        width: 100%;
        margin: auto;
    }

    .title {
        text-align: center;
    }

    .date {
        text-align: end;
    }

    .date span {
        text-decoration: underline;
        color: red;
    }

    .tables {
        display: flex;
        gap: 10px;
        width: 100%;
    }

    .single {
        width: 100%;
    }

    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    table th {
        text-wrap: nowrap;
        /* text-align: center; */
    }

    .first td {
        border: 1px solid black;
    }

    table th,
    td {
        padding: 10px;
    }

    .name {
        text-align: end;
    }

    .last td {
        border: 1px solid black;
        border-bottom: none;
    }

    .under {
        text-align: center;
    }

    h4 span {
        border-top: 1px solid black;
    }

    .remain {
        border-top: 1px solid red;
        color: red;
    }

    .second {
        border-top: 1px solid black;
    }

    .add {
        color: red;
    }
</style>

<div class="container">
    <h2 class="title">روکڑ</h2>

    <h3 class="date"><span><?= $date ?></span> : تاریخ</h3>
    <!-- 1 -->
    <div class="tables">
        <div class="single">
            <table>
                <thead>
                    <tr>
                        <th>بنام</th>
                        <th>تفصیل</th>
                        <th>کھاتہ بنام</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="first">
                        <td colspan="3">M</td>
                    </tr>
                    <?php
                    $total_debit = 0;
                    $query = mysqli_query($dbc, "SELECT * FROM vouchers WHERE Date(voucher_date) = '$date' AND payment_type = 'send'");
                    while ($r = mysqli_fetch_assoc($query)) {
                        $voucher_id = $r['voucher_id'];
                        echo $voucher_id;

                        $transaction  = mysqli_query($dbc, "SELECT * FROM transactions WHERE voucher_id = '$voucher_id' AND is_cash_in_hand = 0");
                        while ($r = mysqli_fetch_assoc($transaction)) {
                            $transaction_id = $r['transaction_id'];
                            $customer = fetchRecord($dbc, 'customers', 'customer_id', $r['customer_id']);
                            // echo $transaction_id;
                            $total_debit += $r['credit'];
                    ?>
                            <tr class="last">
                                <td rowspan="2"><?= $r['credit'] ?></td>

                                <td colspan="2" class="name text-capitalize"> <strong><?= $customer['customer_name'] ?></strong></td>
                            </tr>
                            <tr class="under">
                                <td></td>
                                <td class="name"><?= $r['voucher_id'] ?> CPV</td>
                            </tr>
                    <?php
                        }
                    } ?>
                </tbody>
            </table>

            <div class="mt-3">
                <h4><span class="show"><?= $total_debit ?></span> بنام</h4>
            </div>

        </div>

        <!-- 2 -->

        <div class="single">
            <table>
                <thead>
                    <tr>
                        <th>جمع</th>
                        <th>تفصیل</th>
                        <th>کھاتہ بنام</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $opening_balance = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT 
    SUM(debit) - SUM(credit) AS opening_balance
FROM transactions
WHERE is_cash_in_hand = 1 
AND Date(transaction_add_date) < '$date'
"));
                    ?>
                    <tr class="second">
                        <td class="add"><?= $opening_balance['opening_balance'] ?? 0; ?>
                        </td>
                        <td></td>
                        <td class="name">
                            <strong> سابقا روکڑ </strong>
                        </td>
                    </tr>
                    <?php
                    $total_credit = 0;
                    $query = mysqli_query($dbc, "SELECT * FROM vouchers WHERE Date(voucher_date) = '$date' AND payment_type = 'receive'");
                    while ($r = mysqli_fetch_assoc($query)) {
                        $voucher_id = $r['voucher_id'];
                        echo $voucher_id;

                        $transaction  = mysqli_query($dbc, "SELECT * FROM transactions WHERE voucher_id = '$voucher_id' AND is_cash_in_hand = 0");
                        while ($r = mysqli_fetch_assoc($transaction)) {
                            $transaction_id = $r['transaction_id'];
                            $customer = fetchRecord($dbc, 'customers', 'customer_id', $r['customer_id']);
                            // echo $transaction_id;
                            $total_credit += $r['debit'];
                    ?>
                            <tr class="last">
                                <td rowspan="2"><?= $r['debit'] ?></td>

                                <td colspan="2" class="name text-capitalize"> <strong><?= $customer['customer_name'] ?></strong></td>
                            </tr>
                            <tr class="under">
                                <td></td>
                                <td class="name"><?= $r['voucher_id'] ?> CRV</td>
                            </tr>
                    <?php
                        }
                    } ?>
                </tbody>
            </table>
            <div class="mt-3">
                <h4><span> <?= $total_credit ?> </span>جمع</h4>

                <!-- <h4>
            <span class="remain"> 10978 </span>بقایا
         </h4> -->
            </div>
            <div class="mt-3">
                <?php
                $current_balance = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT SUM(credit-debit) AS from_balance FROM transactions WHERE is_cash_in_hand = '1'"));
                ?>
                <h4 class="mt-3"><span class="remain"><?= $current_balance['from_balance'] ?? 0; ?></span> بقایا</h4>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/foot.php'; ?>


<script>
    $(document).ready(function() {
        window.print();
    });
</script>