<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
// print_r($_REQUEST);

function generateRandomCode($length = 11)
{
    $characters = '0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

$randomCode = generateRandomCode();
// echo "Random 11-digit code: " . $randomCode;
// exit;

if (@$_REQUEST['update-production']) {
    $upd_id = $_REQUEST['update-production'];
    $updateProduction = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM `production` WHERE production_id =  $upd_id"));
}
?>

<body class="horizontal light  ">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="card my-5">
                    <div class="card-header card-bg" align="center">
                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Create Production</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="add_production_fm">
                            <input type="hidden" name="prod_upd_id" value="<?= @$updateProduction['production_id'] ?>">
                            <div class="form-group row">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Date</label>
                                    <input type="date" class="form-control" id="production_add_date" name="production_add_date" <?php if (@$_REQUEST['update-production']) { ?> value="<?= @$updateProduction['production_date'] ?>" <?php } else { ?> value="<?= date('Y-m-d') ?>" <?php } ?>>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Lat No</label>
                                    <input type="text" readonly class="form-control" id="production_lat_no" name="production_lat_no" required <?php if (@$_REQUEST['update-production']) { ?> value="<?= @$updateProduction['production_lat_no'] ?>" <?php } else { ?> value="<?= @$randomCode ?>" <?php } ?>>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Production Name</label>
                                    <input type="text" class="form-control" id="production_name" placeholder="Production Name" name="production_name" value="<?= ucwords(@$updateProduction['production_name']) ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Production Cost</label>
                                    <input type="number" min="0" class="form-control" id="production_cost" placeholder="Enter Production Cost " oninput="onlyNumberInput(event)" name="production_cost" value="<?= @$updateProduction['production_cost'] ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Customer Name</label>
                                    <input type="text" class="form-control" id="production_customer" placeholder="Customer Name" name="production_customer" required value="<?= ucwords(@$updateProduction['customer']) ?>">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-2 mb-3 mb-sm-0">
                                    <label for="" class="font-weight-bold text-dark">Customer Address</label>
                                    <input type="text" class="form-control" id="cust_address" placeholder="Enter Address" name="cust_address" required value="<?= @$updateProduction['customer_address'] ?>">
                                </div>
                            </div>
                            <button type="submit" id="inv_btn" class="btn btn-admin float-right">
                                <span id="loader_code" class="spinner-border d-none" style="width: 1.5rem !important;height: 1.5rem !important;"></span>
                                <span id="text_code" class="">Save</span>
                            </button>
                        </form>
                    </div>
                </div> <!-- .row -->
                <!-- List -->
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Production List</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table credit_order" id="view_orders_tb">
                            <thead>
                                <tr>
                                    <th width="1%">Sr.</th>
                                    <th width="3%">Lat No.</th>
                                    <th width="2%">
                                        Created Date
                                    </th>
                                    <th width="5%">
                                        Production
                                    </th>
                                    <th width="5%">
                                        Customer
                                    </th>
                                    <th width="5%">
                                        Address
                                    </th>
                                    <th width="4%">Total Amount</th>
                                    <!-- <th width="5%">By</th> -->
                                    <th width="6%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableData">
                                <?php
                                $sql = mysqli_query($dbc, "SELECT * FROM `production`");
                                if (mysqli_num_rows($sql) > 0) :
                                    $i = 0;
                                    while ($a = mysqli_fetch_assoc($sql)) :
                                        $created_date = date("F, d Y", strtotime($a['production_date']));
                                        $i++;
                                ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $a['production_lat_no'] ?></td>
                                            <td><?= @$created_date ?></td>
                                            <td><?= ucwords($a['production_name']) ?></td>
                                            <td><?= ucwords($a['customer']) ?></td>
                                            <td><?= ucwords($a['customer_address']) ?></td>
                                            <td><?= number_format($a['production_cost']) ?></td>
                                            <!-- <td></td> -->
                                            <td>
                                                <a class="btn btn-secondary py-1 px-2 m-1" href="addproduction.php?update-production=<?= $a['production_id'] ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a class="btn btn-secondary py-1 px-2 m-1" href="Production.php?ProductionID=<?= base64_encode($a['production_id']) ?>">
                                                    <i class="fa fa-edit"></i> Edit Voucher
                                                </a>
                                                <a target="_blank" class="btn btn-primary py-1 px-2 m-1" href="print_production.php?print=<?= $a['production_id'] ?>">
                                                    <i class="fa fa-print"></i> Print
                                                </a>

                                                <!-- <button class="btn btn-danger py-1 px-2 m-1" onclick="deleteProductionData(<?= $a['quotation_id'] ?>)">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button> -->
                                                <!-- <a target="_blank" class="btn btn-primary py-1 px-2 m-1" href="#">
                                                    <i class="fa fa-print"></i> Print
                                                </a> -->
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
            </div> <!-- .container-fluid -->

        </main> <!-- main -->
    </div> <!-- .wrapper -->

</body>

</html>
<?php include_once 'includes/foot.php'; ?>
<script>
    $(document).ready(function() {

        $("#add_production_fm").on('submit', function(e) {

            e.preventDefault();
            // alert("ascas");

            var formdata = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'php_action/custom_action.php',
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#loader_code').removeClass('d-none');
                    $('#text_code').addClass('d-none');
                },
                success: function(response) {

                    $('#loader_code').addClass('d-none');
                    $('#text_code').removeClass('d-none');
                    var responseData = JSON.parse(response).sts;
                    var responsemsg = JSON.parse(response).msg;

                    if (responseData == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: responsemsg,
                            showConfirmButton: false,
                            timer: 3000
                        }).then((result) => {
                            if (responseData == 'success') {
                                $('#add_production_fm').trigger('reset');
                                $("#tableData").load(location.href + " #tableData > *");
                            }
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: responsemsg,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            }); //ajax call
        }); //main
    });
</script>