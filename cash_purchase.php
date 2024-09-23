<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php';

if (!empty($_REQUEST['edit_purchase_id'])) {
  # code...
  $fetchPurchase = fetchRecord($dbc, "purchase", "purchase_id", base64_decode($_REQUEST['edit_purchase_id']));
}
?>

<style>
  .top-btn {
    background-color: tranparent;
    border: 2px solid black;
    font-weight: bold;
  }

  .top-btn:hover {
    background-color: orangered;
    color: #fff;
  }

  .active {
    background-color: #000;
    color: #fff;
  }
</style>

<body class="horizontal light  ">
  <div class="wrapper">
    <?php include_once 'includes/header.php'; ?>

    <div class="container-fluid">
      <div class="card">
        <div class="card-header card-bg" align="center">

          <div class="row">
            <div class="col-12 mx-auto h4">
              <b class="text-center card-text">Cash Purchase</b>


              <a href="" class="btn btn-admin float-right btn-sm">Add New</a>
            </div>
          </div>

        </div>
        <div class="card-body">

          <form action="php_action/custom_action.php" method="POST" id="sale_order_fm">
            <input type="hidden" name="product_purchase_id" value="<?= @empty($_REQUEST['edit_purchase_id']) ? "" : base64_decode($_REQUEST['edit_purchase_id']) ?>">
            <input type="hidden" name="payment_type" value="cash_puchase" id="payment_type">
            <div class="row form-group">
              <div class="col-md-2">
                <label>Purchase ID#</label>
                <?php $result = mysqli_query($dbc, "SHOW TABLE STATUS LIKE 'purchase' ");
                $data = mysqli_fetch_assoc($result);
                $next_increment = $data['Auto_increment']; ?>
                <input type="text" name="next_increment" id="next_increment" value="<?= @empty($_REQUEST['edit_purchase_id']) ? $next_increment : $fetchPurchase['purchase_id'] ?>" readonly class="form-control">
              </div>
              <div class="col-md-2">
                <label>Purchase Date</label>

                <input type="text" name="purchase_date" id="purchase_date" value="<?= @empty($_REQUEST['edit_purchase_id']) ? date('Y-m-d') : $fetchPurchase['purchase_date'] ?>" readonly class="form-control">
              </div>
              <div class="col-md-4">
                <label>Select Supplier</label>
                <div class="input-group">
                  <select class="form-control searchableSelect" name="cash_purchase_supplier" id="credit_order_client_name" required onchange="getBalance(this.value,'customer_account_exp')" aria-label="Username" aria-describedby="basic-addon1">
                    <option value="">Select Supplier</option>
                    <?php
                    $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type='supplier'");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                      <option <?= @($fetchPurchase['customer_account'] == $r['customer_id']) ? "selected" : "" ?> data-id="<?= $r['customer_id'] ?>" data-contact="<?= $r['customer_phone'] ?>" value="<?= $r['customer_name'] ?>"><?= $r['customer_name'] ?></option>
                    <?php   } ?>
                  </select>
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Balance : <span id="customer_account_exp">0</span> </span>
                  </div>
                </div>
                <input type="hidden" name="customer_account" id="customer_account" value="<?= @$fetchPurchase['customer_account'] ?>">
                <input type="hidden" name="client_contact" id="client_contact" value="<?= @$fetchPurchase['client_contact'] ?>">

              </div>
              <div class="col-md-1">
                <br>
                <a href="customers.php?type=supplier" class="btn btn-admin2 btn-sm mt-2">Add</a>
              </div>

              <div class="col-md-3">
                <label class="text-dark" for="purchase_for">Purchase For</label>

                <select class="form-control" name="purchase_for" id="purchase_for">
                  <option disabled>Select Type</option>
                  <option value="shafoon">Shafoon</option>
                  <option value="others">Others</option>
                </select>
              </div>
              <div class="col-md-2 mt-3">
                <label>Bill No.</label>
                <input type="number" min="0" placeholder="Bil No." value="" autocomplete="off" class="form-control" name="bill_no">
              </div>
              <div class="col-md-2 mt-3">
                <label>Gate Pass</label>
                <input type="text" placeholder="Gate Pass" value="" autocomplete="off" class="form-control " name="gate_pass">
              </div>
              <div class="col-md-2 mt-3">
                <label>Bilty No.</label>
                <input type="number" min="0" placeholder="Bilty No." value="" autocomplete="off" class="form-control" name="bilty_no">
              </div>
              <div class="col-md-2 mt-3">
                <label>Location</label>
                <input type="text" placeholder="Location Here" value="" autocomplete="off" class="form-control" name="pur_location">
              </div>
              <div class="col-md-2 mt-3">
                <label>Cargo</label>
                <input type="text" placeholder="Cargo Here" value="" autocomplete="off" class="form-control" name="pur_cargo">
              </div>
              <div class="col-md-2 mt-3">
                <label>Type</label>
                <input type="text" placeholder="Type Here" value="" autocomplete="off" class="form-control " name="pur_type">
              </div>
              <div class="col-12 mt-3">
                <label>Remarks</label>
                <textarea placeholder="Remarks Here" value="<?= @$fetchPurchase['purchase_narration'] ?>" autocomplete="off" class="form-control" name="purchase_narration" id="" cols="30" rows="3"></textarea>
              </div>
            </div> <!-- end of form-group -->
            <div class="form-group row ">
              <div class="col-md-2 d-flex">
                <div>
                  <label>Products ( <span class="text-center w-100" id="instockQty">instock: 0</span> )</label>
                  <input type="hidden" id="add_pro_type" value="add">
                  <select class="form-control searchableSelect" id="get_product_name" name="product_id">
                    <option value="" id="no">Select Product</option>
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
              <div class="col-md-2">
                <label>Rate</label>
                <input type="number" min="0" <?= ($_SESSION['user_role'] == "admin") ? "" : "readonly" ?> class="form-control" id="get_product_price">
              </div>
              <div class="col-md-2">
                <label>Quantity</label>
                <input type="number" readonly class="form-control" id="get_product_quantity" value="1" min="1" name="quantity">
              </div>
              <div class="col-md-2">
                <label>Thaan</label>
                <input type="number" min="0" placeholder="Thaan Here" value="" autocomplete="off" class="form-control" name="pur_thaan" id="get_pur_thaan">
              </div>
              <div class="col-md-2">
                <label>Gzanah</label>
                <input type="number" min="0" placeholder="Gzanah Here" value="" autocomplete="off" class="form-control" name="pur_gzanah" id="get_pur_gzanah">
              </div>

              <div class="col-md-2  d-flex align-items-center">
                <div>
                  <label>Unit</label>
                  <input type="text" placeholder="Unit Here" value="" autocomplete="off" class="form-control " name="pur_unit" id="get_pur_unit">
                </div>
                <div class="ml-3 mt-3">
                  <button type="button" class="btn btn-success btn-sm mt-2 " id="addProductPurchase"><i class="fa fa-plus"></i> <b>Add</b></button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">

                <table class="table  saleTable" id="myDiv">
                  <thead class="table-bordered">
                    <tr>
                      <th>Product Name</th>
                      <th>Thaan</th>
                      <th>Gzanah</th>
                      <th>Unit</th>
                      <th>Rate</th>
                      <th>Quantity</th>
                      <th>Total Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table table-bordered" id="purchase_product_tb">
                    <?php if (isset($_REQUEST['edit_purchase_id'])) :
                      $q = mysqli_query($dbc, "SELECT  product.*,brands.*,purchase_item.* FROM purchase_item INNER JOIN product ON product.product_id=purchase_item.product_id INNER JOIN brands ON product.brand_id=brands.brand_id   WHERE purchase_item.purchase_id='" . base64_decode($_REQUEST['edit_purchase_id']) . "'");

                      while ($r = mysqli_fetch_assoc($q)) {

                    ?>
                        <tr id="product_idN_<?= $r['product_id'] ?>">
                          <input type="hidden" data-price="<?= $r['rate'] ?>" data-quantity="<?= $r['quantity'] ?>" id="product_ids_<?= $r['product_id'] ?>" class="product_ids" name="product_ids[]" value="<?= $r['product_id'] ?>">
                          <input type="hidden" id="product_quantites_<?= $r['product_id'] ?>" name="product_quantites[]" value="<?= $r['quantity'] ?>">
                          <input type="hidden" id="product_rate_<?= $r['product_id'] ?>" name="product_rates[]" value="<?= $r['rate'] ?>">
                          <input type="hidden" id="product_totalrate_<?= $r['product_id'] ?>" name="product_totalrates[]" value="<?= $r['rate'] ?>">
                          <td><?= $r['product_name'] ?></td>
                          <td><?= $r['pur_thaan'] ?></td>
                          <td><?= $r['rate'] ?></td>
                          <td><?= $r['quantity'] ?></td>
                          <td><?= (float)$r['rate'] * (float)$r['quantity'] ?></?>
                          </td>
                          <td>

                            <button type="button" onclick="removeByid(`#product_idN_<?= $r['product_id'] ?>`)" class="fa fa-trash text-danger" href="#"></button>
                            <button type="button" onclick="editByid(<?= $r['product_id'] ?>,`<?= $r['product_code'] ?>`,<?= $r['rate'] ?>,<?= $r['quantity'] ?>)" class="fa fa-edit text-success ml-2 "></button>

                          </td>
                        </tr>
                    <?php }
                    endif ?>
                  </tbody>

                  <tfoot>
                    <tr>
                      <td colspan="2"></td>

                      <td class="table-bordered"> Sub Total :</td>
                      <td class="table-bordered" id="product_total_amount"><?= @$fetchPurchase['total_amount'] ?></td>
                      <td class="table-bordered"> Discount :</td>
                      <td class="table-bordered row m-0 " id="getDiscount">
                        <div class="col-sm-6 pl-0 m-0 p-0">
                          <input onkeyup="getOrderTotal()" type="number" id="ordered_discount" class="form-control form-control-sm" value="<?= @empty($_REQUEST['edit_order_id']) ? "0" : $fetchPurchase['discount'] ?>" min="0" max="100" name="ordered_discount">
                        </div>
                        <div class="col-sm-6 pl-2 m-0 p-0">
                          <input onkeyup="getOrderTotal()" type="number" id="freight" class="form-control form-control-sm " placeholder="Freight" value="<?= @$fetchOrder['freight'] ?>" min="0" name="freight">

                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="border-none"></td>
                      <td class="table-bordered"> <strong>Grand Total :</strong> </td>
                      <td class="table-bordered" id="product_grand_total_amount"><?= @$fetchPurchase['grand_total'] ?></td>
                      <td class="table-bordered">Paid :</td>
                      <td class="table-bordered"><input type="number" max="" class="form-control form-control-sm" id="paid_ammount" onkeyup="getRemaingAmount()" required name="paid_ammount" value="<?= @$fetchPurchase['paid'] ?>">

                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="border-none"></td>
                      <td class="table-bordered">Remaing Amount :</td>
                      <td class="table-bordered"><input type="number" class="form-control form-control-sm" id="remaining_ammount" readonly name="remaining_ammount" value="<?= @$fetchPurchase['due'] ?>">
                      </td>
                      <td class="table-bordered">Account :</td>
                      <td class="table-bordered">

                        <div class="input-group">
                          <select class="form-control" onchange="getBalance(this.value,'payment_account_bl')" name="payment_account" id="payment_account" aria-label="Username" aria-describedby="basic-addon1">

                            <?php
                            if ($_SESSION['user_role'] == 'admin') {
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
        </div>
      </div> <!-- .row -->
    </div> <!-- .container-fluid -->


  </div> <!-- .wrapper -->

</body>

</html>
<?php include_once 'includes/foot.php'; ?>