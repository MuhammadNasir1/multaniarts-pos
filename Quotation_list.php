<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'; ?>

<body class="horizontal light">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Quotation List</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table credit_order" id="view_orders_tb">
                            <thead>
                                <tr>
                                    <th width="1%">Sr.</th>
                                    <th width="2%">
                                        Created Date
                                        <hr class="my-1">
                                        Due Date
                                    </th>
                                    <th width="5%">
                                        Customer Name
                                        <hr class="my-1">
                                        Customer Phone
                                    </th>
                                    <th width="5%">
                                        Email
                                        <hr class="my-1">
                                        Address
                                    </th>
                                    <th width="5%">Total Amount</th>
                                    <th width="5%">By</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableData">
                                <?php
                                $q = mysqli_query($dbc, "SELECT 
                                q.`quotation_id`, 
                                q.`cust_name`, 
                                q.`cust_email`, 
                                q.`cust_phone`, 
                                q.`cust_address`, 
                                q.`cust_date`, 
                                q.`cust_due_date`, 
                                q.`user_id`, 
                                q.`quotation_status`,
                                q.`grandtotal` AS total_amount,
                                u.`user_id`,
                                u.`username`,
                                u.`email` AS user_email
                            FROM 
                                `quotations` AS q
                            LEFT JOIN
                                `quotation_items` AS i
                            ON
                                q.`quotation_id` = i.`quotation_id`
                            LEFT JOIN
                                `users` AS u
                            ON
                                q.`user_id` = u.`user_id` GROUP BY q.`quotation_id` ");
                                if (mysqli_num_rows($q)) :
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($q)) :
                                        // print_r($row);
                                        $created_date = date("F, d Y", strtotime($row['cust_date']));
                                        $due_date = date("F, d Y", strtotime($row['cust_due_date']));
                                        $total_amount = 'Rs ' . number_format($row['total_amount']);

                                        $i++;
                                ?>
                                        <tr>
                                            <td>
                                                <?= $i ?>
                                            </td>
                                            <td>
                                                <?= $created_date ?>
                                                <hr class="my-1">
                                                <?= $due_date ?>
                                            </td>
                                            <td>
                                                <?= ucwords($row['cust_name']) ?>
                                                <hr class="my-1">
                                                <?= $row['cust_phone'] ?>
                                            </td>
                                            <td>
                                                <?= $row['cust_email'] ?>
                                                <hr class="my-1">
                                                <?= $row['cust_address'] ?>
                                            </td>
                                            <td>
                                                <?= $total_amount ?>
                                            </td>
                                            <td>
                                                <?= ucwords($row['username']) ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-secondary py-1 px-2 m-1" href="Quotation.php?QuotationID=<?= base64_encode($row['quotation_id']) ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <button class="btn btn-danger py-1 px-2 m-1" onclick="deleteQuotationData(<?= $row['quotation_id'] ?>)">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>

                                                <a target="_blank" class="btn btn-primary py-1 px-2 m-1" href="QuotationPDF.php?QuotationID=<?= base64_encode($row['quotation_id']) ?>">
                                                    <i class="fa fa-print"></i> Print
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    endwhile;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
<?php include_once 'includes/foot.php'; ?>