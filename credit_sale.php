 <!DOCTYPE html>
 <html lang="en">
 <?php include_once 'includes/head.php';

  if (!empty($_REQUEST['edit_order_id'])) {
    # code...
    $fetchOrder = fetchRecord($dbc, "orders", "order_id", base64_decode($_REQUEST['edit_order_id']));
  }

  ?>

 <body class="horizontal light  ">
   <div class="wrapper">
     <?php include_once 'includes/header.php'; ?>

     <div class="container-fluid">
       <div class="card">
         <div class="card-header card-bg" align="center">

           <div class="row">
             <div class="col-12 mx-auto h4">
               <b class="text-center card-text pb-3">Sale </b>


               <a href="#" onclick="reload_page()" class="btn btn-admin float-right btn-sm">Add New</a>
             </div>
           </div>

         </div>
         <div class="card-body">
           <form action="php_action/custom_action.php" method="POST" id="sale_order_fm">
             <input type="hidden" name="product_order_id" value="<?= !isset($_REQUEST['edit_order_id']) ? "" : base64_decode($_REQUEST['edit_order_id']) ?>">
             <div class="row form-group">
               <input type="hidden" name="payment_type" id="payment_type" value="credit_purchase">
               <div class="col-md-4 ml-auto">
                 <label class="font-weight-bold text-dark">Order Date</label>
                 <input type="date" name="order_date" id="order_date" value="<?= @empty($_REQUEST['edit_order_id']) ? date('Y-m-d') : $fetchOrder['order_date'] ?>" class="form-control">
               </div>
               <div class="col-sm-4">
                 <label class="font-weight-bold text-dark">Bill No.</label>
                 <input type="text" id="voucher_no" value="<?= @$fetchOrder['voucher_no'] ?>" class="form-control" autocomplete="off" name="voucher_no" required>
               </div>
               <div class="col-md-2">
                 <label for="Sale Type" class="font-weight-bold text-dark">Sale Type</label>
                 <select name="sale_type" class="form-control searchableSelect" id="sale_type">
                   <option value="cash" <?= @$fetchOrder['sale_type'] == "cash" ? "selected" : "" ?>>Cash</option>
                   <option selected value="credit" <?= @$fetchOrder['sale_type'] == "credit" ? "selected" : "" ?>>Credit</option>
                   <option value="advance" <?= @$fetchOrder['sale_type'] == "advance" ? "selected" : "" ?>>Advance</option>
                 </select>
               </div>
               <div class="col-md-2">
                 <label class="font-weight-bold text-dark">Order ID#</label>
                 <?php $result = mysqli_query($dbc, "
    SHOW TABLE STATUS LIKE 'orders'
");
                  $data = mysqli_fetch_assoc($result);
                  $next_increment = $data['Auto_increment']; ?>
                 <input type="text" name="next_increment" id="next_increment" value="<?= @empty($_REQUEST['edit_order_id']) ? $next_increment : $fetchOrder['order_id'] ?>" readonly class="form-control">
               </div>

             </div>
             <div class="row form-group">

               <div class="col-sm-8">
                 <input type="hidden" name="credit_sale_type" value="<?= @$credit_sale_type ?>" id="credit_sale_type">
                 <label class="font-weight-bold text-dark">Customer</label>
                 <div class="input-group ">
                   
                     <select class="form-control searchableSelect" aria-required="true" name="credit_order_client_name" id="credit_order_client_name" required onchange="getBalance(this.value,'customer_account_exp')" aria-label="Username" aria-describedby="basic-addon1">
                       <option value="">Select Customer</option>
                       <?php
                        $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type='customer'");
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
                 <!-- <input type="text" autocomplete="off" placeholder="Customer Name" name="credit_order_client_name" id="credit_order_client_name" value="<?= @$fetchOrder['customer_name'] ?>" class="form-control"> -->

                 <input type="hidden" name="customer_account" id="customer_account" value="<?= @$fetchOrder['customer_account'] ?>">
                 <input type="hidden" name="client_contact" id="client_contact" value="<?= @$fetchOrder['client_contact'] ?>">
                 <input type="hidden" name="R_Limit" id="R_LimitInput" />

               </div>


               <div class="col-sm-4">
                 <label class="font-weight-bold text-dark">Remarks</label>
                 <input type="text" autocomplete="off" name="order_narration" id="order_narration" value="<?= @$fetchOrder['order_narration'] ?>" class="form-control">
               </div>

             </div> <!-- end of form-group -->
             <!-- <div class="form-group row">
               <div class="col-6 col-md-3">
                 <label>Product Code</label>
                 <input type="text" name="product_code" autocomplete="off" id="get_product_code" class="form-control">
               </div>
               <div class="col-6 col-md-3">
                 <label>Products</label>
                 <input type="hidden" id="add_pro_type" value="add">
                 <select class="form-control searchableSelect" id="get_product_name" name="product_id">
                   <option value="">Select Product</option>
                   <?php
                    $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                    while ($row = mysqli_fetch_array($result)) {
                      $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                      $getCat = fetchRecord($dbc, "categories", "categories_id", $row['categories_id']);
                    ?>

                     <option data-price="<?= $row["current_rate"] ?>" <?= empty($r['product_id']) ? "" : "selected" ?> value="<?= $row["product_id"] ?>">
                       <?= $row["product_name"] ?> | <?= @$getBrand["brand_name"] ?>(<?= @$getCat["categories_name"] ?>) </option>

                   <?php   } ?>
                 </select>
                 <span class="text-center w-100" id="instockQty"></span>
               </div>
               <div class="col-6 col-sm-2 col-md-2">
                 <label>Price</label>
                 <input type="number" min="0" class="form-control" id="get_product_price">
               </div>
               <div class="col-6 col-sm-2 col-md-2">
                 <label>Quantity</label>
                 <input type="text" class="form-control" id="get_product_quantity" value="1" min="1" name="quantity">
               </div>
               <div class="col-sm-1">
                 <br>
                 <button type="button" class="btn btn-success btn-sm mt-2 float-right" id="addProductPurchase"><i class="fa fa-plus"></i> <b>Add</b></button>
               </div>

             </div> -->
             <div class="form-group row ">
               <div class="col-sm-4 d-flex ml-auto">
                 <div>
                   <label class="font-weight-bold text-dark">Volume No</label>
                   <input type="hidden" id="add_pro_type" value="add">
                   <select class="form-control- w-100 searchableSelect" id="get_product_name" name="product_id">
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
               <div class="col-sm-4">
                 <div>
                   <label class="font-weight-bold text-dark">Quantity</label>
                   <input type="number" class="form-control" id="get_product_quantity_sale" value="1" min="1" name="quantity">
                 </div>
               </div>
               <div class="col-sm-4 d-flex align-items-center">
                 <div>
                   <label class="font-weight-bold text-dark">Rate</label>
                   <input type="number" min="0" <?= ($_SESSION['user_role'] == "admin") ? "" : "readonly" ?> class="form-control" id="get_product_price_sale">
                 </div>
                 <div class="ml-3 mt-3">
                   <button type="button" class="btn btn-success btn-sm mt-2 " id="addProductSale"><i class="fa fa-plus"></i> <b>Add</b></button>
                 </div>
               </div>


             </div>
             <div class="row">
               <div class="col-12">

                 <table class="table  mt-5 saleTable" id="myDiv">
                   <thead class="table-bordered">
                     <tr>
                       <th class="font-weight-bold text-dark">Product Name</th>
                       <th class="font-weight-bold text-dark">Rate</th>
                       <th class="font-weight-bold text-dark">Quantity</th>
                       <th class="font-weight-bold text-dark">Total Price</th>
                       <th class="font-weight-bold text-dark">Action</th>
                     </tr>
                   </thead>
                   <tbody class="table table-bordered" id="purchase_product_tb">
                     <?php if (isset($_REQUEST['edit_order_id'])):
                        $q = mysqli_query($dbc, "SELECT  product.*,brands.*,order_item.* FROM order_item INNER JOIN product ON product.product_id=order_item.product_id INNER JOIN brands ON product.brand_id=brands.brand_id   WHERE order_item.order_id='" . base64_decode($_REQUEST['edit_order_id']) . "'");

                        while ($r = mysqli_fetch_assoc($q)) {

                      ?>
                         <tr id="product_idN_<?= $r['product_id'] ?>">
                           <input type="hidden" data-price="<?= $r['rate'] ?>" data-quantity="<?= $r['quantity'] ?>" id="product_ids_<?= $r['product_id'] ?>" class="product_ids" name="product_ids[]" value="<?= $r['product_id'] ?>">
                           <input type="hidden" id="product_quantites_<?= $r['product_id'] ?>" name="product_quantites[]" value="<?= $r['quantity'] ?>">
                           <input type="hidden" id="product_rate_<?= $r['product_id'] ?>" name="product_rates[]" value="<?= $r['rate'] ?>">
                           <input type="hidden" id="product_totalrate_<?= $r['product_id'] ?>" name="product_totalrates[]" value="<?= $r['rate'] ?>">
                           <td><?= $r['product_name'] ?></td>
                           <td><?= $r['rate'] ?></td>
                           <td><?= $r['quantity'] ?></td>
                           <td><?= (float)$r['rate'] * (float)$r['quantity'] ?></?>
                           </td>
                           <td>

                             <button type="button" class="delete-btn fa fa-trash text-danger" href="#"></button>
                             <button type="button" onclick="editByid(<?= $r['product_id'] ?>,`<?= $r['pur_thaan'] ?>`,`<?= $r['pur_gzanah'] ?>`,`<?= $r['pur_unit'] ?>`,<?= $r['rate'] ?>,<?= $r['quantity'] ?>)" class=" delete-btn fa fa-edit text-success ml-2 "></button>


                           </td>
                         </tr>
                     <?php }
                      endif ?>
                   </tbody>

                   <tfoot>
                     <tr>
                       <td colspan="1"></td>

                       <td class="table-bordered"> Sub Total :</td>
                       <td class="table-bordered" id="product_total_amount"><?= @$fetchOrder['total_amount'] ?></td>
                       <td class="table-bordered"> Discount :</td>
                       <td class="table-bordered" id="getDiscount">
                         <div class="row">

                           <div class="col-sm-12 pr-0">

                             <input onkeyup="getSaleTotal()" type="number" id="ordered_discount" class="form-control form-control-sm " value="<?= @empty($_REQUEST['edit_order_id']) ? "0" : $fetchOrder['discount'] ?>" min="0" max="100" name="ordered_discount">

                           </div>
                           <!-- <div class="col-sm-6 pl-3">
                             <input onkeyup="countFrieght(this.value)" type="number" id="freight_sale" class="form-control form-control-sm " placeholder="Freight" value="<?= @$fetchOrder['pur_freight'] ?>" min="0" name="freight">


                           </div> -->

                         </div>
                       </td>
                     </tr>
                     <tr>
                       <td colspan="1" class="border-none"></td>
                       <td class="table-bordered"> <strong>Grand Total :</strong> </td>
                       <td class="table-bordered" id="product_grand_total_amount"><?= @$fetchOrder['grand_total'] ?></td>
                       <td class="table-bordered">Paid :</td>
                       <td class="table-bordered">
                         <div class="form-group row">
                           <div class="col-sm-6">
                             <input type="text" min="0" class="form-control form-control-sm" id="paid_ammount" required onkeyup="getRemaingAmount()" name="paid_ammount" value=" <?= @isset($fetchOrder['paid']) ? $fetchOrder['paid'] : "0" ?>">
                           </div>
                           <div class="col-sm-6">
                             <div class="custom-control custom-switch">
                               <input type="checkbox" class="custom-control-input" id="full_payment_check">
                               <label class="custom-control-label" for="full_payment_check">Full Payment</label>
                             </div>
                           </div>
                         </div>
                       </td>
                     </tr>
                     <tr>
                       <td colspan="1" class="border-none"></td>
                       <td class="table-bordered">Remaing Amount :</td>
                       <td class="table-bordered"><input type="number" class="form-control form-control-sm" id="remaining_ammount" required readonly name="remaining_ammount" value="<?= @$fetchOrder['due'] ?>">
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
                              while ($r = mysqli_fetch_assoc($q)): ?>
                               <option <?= @($fetchOrder['payment_account'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>
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


 <?php
  if (!empty($_REQUEST['edit_order_id'])) {
  ?>
   <script type="text/javascript">
     var custid = $("#customer_account").val();

     //alert(custid);
     getBalance(custid, 'customer_account_exp');
   </script>
 <?php
  }
  ?>