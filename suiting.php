<?php if (basename($_SERVER['REQUEST_URI']) == 'suiting.php') { ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include_once 'includes/head.php';

    if (!empty($_REQUEST['edit_purchase_id'])) {
        # code...
        $fetchPurchase = fetchRecord($dbc, "purchase", "purchase_id", base64_decode($_REQUEST['edit_purchase_id']));
    }
    ?>

    <body class="horizontal light">
        <div class="wrapper">
            <?php include_once 'includes/header.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-bg" align="center">

                        <div class="row">
                            <div class="col-12 mx-auto h4">
                                <b class="text-center card-text">Suting Purchase</b>

                                <a href="credit_purchase.php" class="btn btn-admin float-right btn-sm">Add New</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php } ?>

                    <form action="php_action/custom_action.php" method="POST" id="sale_order_fm">
                        <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
                        <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">


                        <div class="row form-group">
                            <div class="col-md-1">
                                <label>Purchase ID#</label>
                                <?php $result = mysqli_query($dbc, "
    SHOW TABLE STATUS LIKE 'purchase'
");
                                $data = mysqli_fetch_assoc($result);
                                $next_increment = $data['Auto_increment']; ?>
                                <input type="text" name="next_increment" id="next_increment" value="<?= @empty($_REQUEST['edit_purchase_id']) ? $next_increment : $fetchPurchase['purchase_id'] ?>" readonly class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>Purchase Date</label>
                                <input type="date" name="purchase_date" required id="purchase_date" value="<?= @empty($_REQUEST['edit_order_id']) ? date('Y-m-d') : $fetchPurchase['purchase_date'] ?>" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label>Select Supplier</label>
                                <div class="input-group">
                                    <select class="form-control searchableSelect" aria-required="true" name="cash_purchase_supplier" id="credit_order_client_name" required onchange="getBalance(this.value,'customer_account_exp')" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Select Supplier</option>
                                        <?php
                                        $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type='supplier'");
                                        while ($r = mysqli_fetch_assoc($q)) {
                                            $customer_name = ucwords(strtolower($r['customer_name']));
                                        ?>
                                            <option <?= @($fetchPurchase['customer_account'] == $r['customer_id']) ? "selected" : "" ?>
                                                data-id="<?= $r['customer_id'] ?>"
                                                data-contact="<?= $r['customer_phone'] ?>"
                                                value="<?= $customer_name ?>">
                                                <?= $customer_name ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Balance : <span id="customer_account_exp">0</span></span>
                                    </div>
                                </div>
                                <input type="hidden" name="customer_account" id="customer_account" value="<?= @$fetchPurchase['customer_account'] ?>">
                                <input type="hidden" name="client_contact" id="client_contact" value="<?= @$fetchPurchase['client_contact'] ?>">
                            </div>

                            <div class="col-sm-1">
                                <br>
                                <a href="customers.php?type=supplier" class="btn btn-admin2 btn-sm mt-2">Add</a>
                            </div>
                            <div class="col-md-2">
                                <label for="lat_no">Lot No</label>
                                <input type="text" class="form-control" id="lat_no" required value="" name="lat_no" placeholder="Lot No">
                            </div>
                            <div class="col-md-2">
                                <label class="text-dark" for="purchase_for">Purchase For</label>

                                <select class="form-control searchableSelect" name="purchase_for" id="purchase_for">
                                    <option disabled>Select Type</option>
                                    <option value="shafoon" <?= @($fetchPurchase['purchase_for'] == 'shafoon') ? "selected" : "" ?>>Shafoon</option>
                                    <option value="others" <?= @($fetchPurchase['purchase_for'] == 'others') ? "selected" : "" ?>>Others</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Program</label>
                                <select class="form-control searchableSelect" name="program" id="program">
                                    <option disabled selected>Select Program</option>
                                    <?php
                                    $location = mysqli_query($dbc, "SELECT * FROM programs WHERE status = 1");
                                    while ($d = mysqli_fetch_assoc($location)) {
                                    ?>
                                        <option value="<?= $d['program_id'] ?>"> <?= ucwords($d['name']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label>Location</label>

                                <select class="form-control searchableSelect" required id="pur_location" name="pur_location" onchange="findLocationType(this.value)" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Select Account</option>


                                    <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status = 1 AND (customer_type = 'dyeing' OR customer_type = 'shop' OR customer_type = 'shop' OR customer_type = 'packing' OR customer_type = 'printer') ORDER BY customer_type ASC;");
                                    $type2 = '';
                                    while ($r = mysqli_fetch_assoc($q)):
                                        $type = $r['customer_type'];
                                    ?>
                                        <?php if ($type != $type2): ?>
                                            <optgroup label="<?= $r['customer_type'] ?>">
                                            <?php endif ?>

                                            <option <?= @($voucher['customer_id2'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                            <?php if ($type != $type2): ?>
                                            </optgroup>
                                        <?php endif ?>
                                    <?php $type2 = $r['customer_type'];
                                    endwhile; ?>


                                </select>
                                <input type="hidden" name="location_type" id="location_type">
                            </div>
                            <div class="col-md-8 mt-3">
                                <label>Remarks</label>
                                <textarea placeholder="Remarks Here" autocomplete="off" class="form-control" name="purchase_narration" id="" cols="30" rows="3"><?= @$fetchPurchase['purchase_narration'] ?></textarea>
                            </div>
                        </div> <!-- end of form-group -->
                        <div class="form-group row">
                            <div class="col-sm-2 d-flex">
                                <div>
                                    <label>Products ( <span class="text-center w-100">instock: <span id="instockQty">0</span></span> )</label>
                                    <input type="hidden" id="add_pro_type" value="add">
                                    <select class="form-control searchableSelect" required id="get_product_name" name="product_id">
                                        <option value="">Select Product</option>
                                        <?php
                                        $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                                        while ($row = mysqli_fetch_array($result)) {
                                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                                        ?>

                                            <option data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                                                <?= $row["product_name"] ?> | <?= @$getBrand["brand_name"] ?>(<?= @$getCat["categories_name"] ?>) </option>

                                        <?php   } ?>
                                    </select>
                                </div>
                                <div class="ml-3">
                                    <label class="invisible d-block">.</label>
                                    <button type="button" class="btn btn-danger btn-sm pt-1 pb-1" data-toggle="modal" data-target="#add_product_modal"> <i class="fa fa-plus"></i> </button>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label>Rate</label>
                                <input type="number" required min="0" <?= ($_SESSION['user_role'] == "admin") ? "" : "readonly" ?> class="form-control" id="get_product_price" name="product_price">
                            </div>
                            <div class="col-sm-2">
                                <label>Thaan</label>
                                <input type="number" min="0" placeholder="Thaan Here" value="" autocomplete="off" class="form-control" name="pur_thaan" id="get_pur_thaan">
                            </div>
                            <div class="col-sm-2">
                                <label>Gzanah</label>
                                <input type="number" min="0" placeholder="Gzanah Here" value="" autocomplete="off" class="form-control" name="pur_gzanah" id="get_pur_gzanah">
                            </div>
                            <div class="col-sm-2">
                                <label>Quantity</label>
                                <input type="number" class="form-control" required id="get_product_quantity" value="1" min="1" name="quantity">
                            </div>

                            <div class="col-sm-2  d-flex align-items-center">
                                <div>
                                    <label>Unit</label>
                                    <!-- <input type="text" placeholder="Unit Here" value="" autocomplete="off" class="form-control " name="pur_unit" id="get_pur_unit"> -->
                                    <select class="form-control searchableSelect" required name="pur_unit" id="get_pur_unit">
                                        <option disabled>Select Type</option>
                                        <option value="meter" <?= @($fetchPurchase['pur_unit'] == 'meter') ? "selected" : "" ?>>Meter</option>
                                        <option value="yard" <?= @($fetchPurchase['pur_unit'] == 'yard') ? "selected" : "" ?>>Yard</option>
                                        <option value="others" <?= @($fetchPurchase['pur_unit'] == 'suit') ? "selected" : "" ?>>Suit</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">

                                <table class="table  saleTable" id="myDiv">
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>

                                            <td class="table-bordered"> Sub Total :</td>
                                            <td class="table-bordered" id="product_total_amount"></td>
                                            <input type="hidden" name="product_total_amount" class="form-control form-control-sm" id="product_total_amount_input">
                                            <td class=" table-bordered"> Discount :</td>
                                            <td class="table-bordered row m-0 " id="getDiscount">
                                                <div class="col-sm-6 pl-0 m-0 p-0">
                                                    <input onkeyup="getOrderTotal()" type="number" id="ordered_discount" class="form-control form-control-sm" value="<?= isset($fetchPurchase['discount']) ? @$fetchPurchase['discount'] : 0 ?>" min="0" max="100" name="ordered_discount">
                                                </div>
                                                <div class="col-sm-6 pl-2">
                                                    <input onkeyup="getOrderTotal()" type="number" id="freight" class="form-control form-control-sm " placeholder="Freight" value="<?= isset($fetchPurchase['freight']) ? @$fetchPurchase['freight'] : 0 ?>" min="0" name="freight">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="border-none"></td>
                                            <td class="table-bordered"> <strong>Grand Total :</strong> </td>
                                            <td class="table-bordered" id="product_grand_total_amount"><?= @$fetchPurchase['grand_total'] ?></td>
                                            <input type="hidden" class="form-control form-control-sm" id="product_grand_amount_input" name="product_grand_amount_input">
                                            <td class="table-bordered">Paid :</td>
                                            <td class="table-bordered">
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <input type="number" min="0" class="form-control form-control-sm" id="paid_ammount" required onkeyup="getRemaingAmount()" name="paid_ammount">
                                                    </div>
                                                    <div class=" col-sm-6">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="full_payment_check">
                                                            <label class="custom-control-label" for="full_payment_check">Full Payment</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="border-none"></td>
                                            <td class="table-bordered">Remaing Amount :</td>
                                            <td class="table-bordered"><input type="number" class="form-control form-control-sm" id="remaining_ammount" required readonly name="remaining_ammount" value="<?= @$fetchPurchase['due'] ?>">
                                            </td>
                                            <td class="table-bordered">Account :</td>
                                            <td class="table-bordered">

                                                <div class="input-group">
                                                    <select class="form-control" onchange="getBalance(this.value,'payment_account_bl')" name="payment_account" id="payment_account" aria-label="Username" aria-describedby="basic-addon1">

                                                        <?php if ($_SESSION['user_role'] == 'admin') {
                                                            $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type='bank'");
                                                        } else {
                                                            $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_id = 
                        '$UserData[cash_account]'");
                                                        }
                                                        while ($r = mysqli_fetch_assoc($q)) : ?>
                                                            <option <?= @($fetchPurchase['payment_account'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Balance : <span id="payment_account_bl">0</span> </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 offset-6">

                                <button class="btn btn-admin float-right " name="sale_order_btn" value="print" type="submit" id="sale_order_btn">Save and Print</button>

                            </div>
                        </div>
                    </form>
                    <?php if (basename($_SERVER['REQUEST_URI']) == 'suiting.php') { ?>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
            <!-- <button type="button" class="btn btn-danger d-none btn-sm m-1" id="productionModalButton" data-toggle="modal" data-target="#addProductionModal" onclick="getPurId(<?= $r['purchase_id'] ?>) , getRandomCode()">Production</button> -->
            <!-- Button trigger modal -->




    </body>

    </html>

<?php
                        include_once 'includes/foot.php';
                    } ?>


<script>
    function findLocationType(value) {
        $.ajax({
            url: 'php_action/custom_action.php',
            type: 'POST',
            data: {
                location_type_get: value
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $("#location_type").val(response.data.customer_type);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
</script>