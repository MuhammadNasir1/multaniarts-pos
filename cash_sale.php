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
               <b class="text-center card-text">Cash Sale</b>


               <a href="cash_sale.php" class="btn btn-admin float-right btn-sm">Add New</a>
             </div>
           </div>

         </div>
         <div class="card-body">
           <form action="php_action/custom_action.php" method="POST" id="sale_order_fm">
             <input type="hidden" name="product_order_id" value="<?= @empty($_REQUEST['edit_order_id']) ? "" : base64_decode($_REQUEST['edit_order_id']) ?>">
             <input type="hidden" name="payment_type" id="payment_type" value="cash_in_hand">

             <div class="row form-group">
               <div class="col-md-2">
                 <label>Order ID#</label>
                 <?php $result = mysqli_query($dbc, "
    SHOW TABLE STATUS LIKE 'orders'
");
                  $data = mysqli_fetch_assoc($result);
                  $next_increment = $data['Auto_increment']; ?>
                 <input type="text" name="next_increment" id="next_increment" value="<?= @empty($_REQUEST['edit_order_id']) ? $next_increment : $fetchOrder['order_id'] ?>" readonly class="form-control">
               </div>
               <div class="col-md-2">
                 <label>Order Date</label>

                 <input type="text" name="order_date" id="order_date" value="<?= @empty($_REQUEST['edit_order_id']) ? date('Y-m-d') : $fetchOrder['order_date'] ?>" readonly class="form-control">
               </div>

               <div class="col-sm-4">
                 <label>Customer Number</label>
                 <input type="number" onchange="getCustomer_name(this.value)" value="<?= @$fetchOrder['client_contact'] ?>" autocomplete="off" min="0" class="form-control" name="client_contact" list="phone">
                 <datalist id="phone">
                   <?php
                    $q = mysqli_query($dbc, "SELECT DISTINCT client_contact from orders");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                     <option value="<?= $r['client_contact'] ?>"><?= $r['client_contact'] ?></option>
                   <?php   } ?>

                 </datalist>
               </div>
               <div class="col-sm-2">
                 <label>Customer Name</label>
                 <input type="text" id="sale_order_client_name" value="<?= @$fetchOrder['client_name'] ?>" class="form-control" autocomplete="off" name="sale_order_client_name" list="client_name" required>
                 <datalist id="client_name">
                   <?php
                    $q = mysqli_query($dbc, "SELECT DISTINCT client_name FROM orders");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                     <option value="<?= $r['client_name'] ?>"><?= $r['client_name'] ?></option>
                   <?php   } ?>
                 </datalist>
               </div>
               <div class="col-sm-2">
                 <label>Vehicle NO </label>
                 <input type="text" id="vehicle_no" value="<?= @$fetchOrder['vehicle_no'] ?>" class="form-control" autocomplete="off" name="vehicle_no" list="vehicle_no_list" required>
                 <datalist id="vehicle_no_list">
                   <?php
                    $q = mysqli_query($dbc, "SELECT DISTINCT vehicle_no FROM orders");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                     <option value="<?= $r['vehicle_no'] ?>"><?= $r['vehicle_no'] ?></option>
                   <?php   } ?>
                 </datalist>
               </div>
             </div> <!-- end of form-group -->
             <!-- <div class="form-group row">

                      <div class="col-6 col-md-3">
                      <label>Product Code</label>
                      <input type="text"  name="product_code" autocomplete="off" id="get_product_code" class="form-control">
                    </div>
                       <div class="col-6 col-md-3">
                        <label>Products</label>
                        <input type="hidden" id="add_pro_type" value="add">  
                         <select class="form-control searchableSelect" id="get_product_name"  name="product_id"   >
                              <option value=" ">Select Product</option>
                          <?php
                          $result = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                          while ($row = mysqli_fetch_array($result)) {
                            $getBrand = fetchRecord($dbc, "brands", "brand_id", $row['brand_id']);
                            $getCat = fetchRecord($dbc, "categories", "categories_id", $row['category_id']);
                          ?>
                    
                      <option data-price="<?= $row["current_rate"] ?>"  <?= empty($r['product_id']) ? "" : "selected" ?>  value="<?= $row["product_id"] ?>"  >
                        <?= $row["product_name"] ?> |  <?= @$getBrand["brand_name"] ?>(<?= @$getCat["categories_name"] ?>) </option>

                      <?php   } ?>
                  </select>
                  <span  class="text-center w-100" id="instockQty"></span>
                      </div>
                        <div class="col-6 col-sm-2 col-md-2">
                          <label>Price</label>
                         <input type="number" <?= ($_SESSION['user_role'] == "admin") ? "" : "readonly" ?> min="0"  class="form-control" id="get_product_price" >
                      </div>
                      <div class="col-6 col-sm-2 col-md-2">
                        <label>Quantity</label>
                         <input type="number" data-max="" class="form-control" id="get_product_quantity" value="1"  min="1" name="quantity" >

                      </div>
                       <div class="col-sm-1">
                        <br>
                         <button type="button" class="btn btn-success btn-sm mt-2 float-right" id="addProductPurchase"><i class="fa fa-plus"></i> <b>Add</b></button>
                      </div>
                    
              </div> -->


             <div class="form-group row">
               <div class="col-sm-2 d-flex">
                 <div>
                   <label>Products ( <span class="text-center w-100">instock: <span id="instockQty">0</span></span> )</label>
                   <input type="hidden" id="add_pro_type" value="add">
                   <select class="form-control searchableSelect" id="get_product_name" name="product_id">
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
                 <input type="number" min="0" <?= ($_SESSION['user_role'] == "admin") ? "" : "readonly" ?> class="form-control" id="get_product_price">
               </div>
               <div class="col-sm-2">
                 <label>Thaan</label>
                 <input type="number" min="0" placeholder="Thaan Here" value="1" autocomplete="off" class="form-control" name="pur_thaan" id="get_pur_thaan">
               </div>
               <div class="col-sm-2">
                 <label>Gzanah</label>
                 <input type="number" min="0" placeholder="Gzanah Here" value="1" autocomplete="off" class="form-control" name="pur_gzanah" id="get_pur_gzanah">
               </div>
               <div class="col-sm-2">
                 <label>Quantity</label>
                 <input type="number" class="form-control" id="get_product_quantity" value="1" min="1" name="quantity">
               </div>

               <div class="col-sm-2  d-flex align-items-center">
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
                     <?php if (isset($_REQUEST['edit_order_id'])):
                        $q = mysqli_query($dbc, "SELECT  product.*,brands.*,order_item.* FROM order_item INNER JOIN product ON product.product_id=order_item.product_id INNER JOIN brands ON product.brand_id=brands.brand_id   WHERE order_item.order_id='" . base64_decode($_REQUEST['edit_order_id']) . "'");

                        while ($r = mysqli_fetch_assoc($q)) {

                      ?>
                         <tr id="product_idN_<?= $r['product_id'] ?>">
                           <input type="hidden" data-price="<?= $r['rate'] ?>" data-quantity="<?= $r['quantity'] ?>" id="product_ids_<?= $r['product_id'] ?>" class="product_ids" name="product_ids[]" value="<?= $r['product_id'] ?>">
                           <input type="hidden" id="product_quantites_<?= $r['product_id'] ?>" name="product_quantites[]" value="<?= $r['quantity'] ?>">
                           <input type="hidden" id="product_rate_<?= $r['product_id'] ?>" name="product_rates[]" value="<?= $r['rate'] ?>">
                           <input type="hidden" id="product_totalrate_<?= $r['product_id'] ?>" name="product_totalrates[]" value="<?= $r['rate'] ?>">
                           <input type="hidden" id="pur_thaan_<?= $r['product_id'] ?>'" name="pur_thaan[]" value="<?= $r['pur_thaan'] ?>">
                           <!-- <input type="hidden" id="pur_thaan_<?= $r['product_id'] ?>" name="pur_thaan[]" value="<?= $r['pur_thaan'] ?>"> -->
                           <input type="hidden" id="pur_gzanah_<?= $r['product_id'] ?>" name="pur_gzanah[]" value="<?= $r['pur_gzanah'] ?>">
                           <input type="hidden" id="pur_unit_<?= $r['product_id'] ?>" name="pur_unit[]" value="<?= $r['pur_unit'] ?>">
                           <td><?= $r['product_name'] ?></td>
                           <td><?= $r['pur_thaan'] ?></td>
                           <td><?= $r['pur_gzanah'] ?></td>
                           <td><?= $r['pur_unit'] ?></td>
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
                       <td colspan="4"></td>

                       <td class="table-bordered"> Sub Total :</td>
                       <td class="table-bordered" id="product_total_amount"><?= @$fetchOrder['total_amount'] ?></td>
                       <td class="table-bordered"> Discount :</td>
                       <td class="table-bordered" id="getDiscount">
                         <div class="row">

                           <div class="col-sm-6 pr-0">

                             <input onkeyup="getOrderTotal()" type="number" id="ordered_discount" class="form-control form-control-sm " value="<?= @empty($_REQUEST['edit_order_id']) ? "0" : $fetchOrder['discount'] ?>" min="0" max="100" name="ordered_discount">

                           </div>
                           <div class="col-sm-6 pl-3">
                             <input onkeyup="getOrderTotal()" type="number" id="freight" class="form-control  form-control-sm " placeholder="Freight" value="<?= @$fetchOrder['pur_freight'] ?>" min="0" name="freight">


                           </div>

                         </div>
                       </td>
                     </tr>
                     <tr>
                       <td colspan="4" class="border-none"></td>
                       <td class="table-bordered"> <strong>Grand Total :</strong> </td>
                       <td class="table-bordered" id="product_grand_total_amount"><?= @$fetchOrder['grand_total'] ?></td>
                       <td class="table-bordered">Paid :</td>
                       <td class="table-bordered">
                         <!-- <input type="number" readonly class="form-control form-control-sm" id="paid_ammount" required name="paid_ammount" value="<?= @$fetchOrder['paid'] ?>"> -->

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
                       <td colspan="4" class="border-none"></td>
                       <td class="table-bordered">Remaing Amount :</td>
                       <td class="table-bordered"><input type="number" class="form-control form-control-sm" id="remaining_ammount" readonly name="remaining_ammount" value="<?= @$fetchOrder['due'] ?>">
                       </td>

                       <td class="table-bordered">Account :</td>
                       <td class="table-bordered">
                         <select class="form-control" id="payment_account" name="payment_account" required>

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