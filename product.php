<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php';
if (isset($_REQUEST['edit_product_id'])) {
  $fetchproduct = fetchRecord($dbc, "product", "product_id", base64_decode($_REQUEST['edit_product_id']));
}
$btn_name = isset($_REQUEST['edit_product_id']) ? "Update" : "Add";

?>
<style type="text/css">
  .badge {
    font-size: 15px;
  }
</style>

<body class="horizontal light  ">
  <div class="wrapper">
    <?php include_once 'includes/header.php'; ?>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header card-bg" align="center">

            <div class="row">
              <div class="col-12 mx-auto h4">
                <b class="text-center card-text">Product Management</b>

                <a href="stockreport.php" class="btn btn-admin float-right btn-sm mx-1">Print Stock (Advance)</a>
                <a href="stock.php?type=simple" class="btn btn-admin float-right btn-sm mx-1">Print Stock</a>
                <a href="stock.php?type=amount" class="btn btn-admin float-right btn-sm mx-1">Print Stock With Amount</a>

                <a href="product.php?act=add" class="btn btn-admin float-right btn-sm mx-1">Add New</a>
              </div>
            </div>

          </div>
          <?php if (@$_REQUEST['act'] == "add"): ?>
            <div class="card-body">
              <form action="php_action/custom_action.php" id="add_product_fm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="product_module">
                <input type="hidden" name="product_id" value="<?= @base64_encode($fetchproduct['product_id']) ?>">
                <input type="hidden" id="product_add_from" value="page">


                <div class="form-group row">
                  <div class="col-lg-2 col-sm-4 mt-3 px-3 mb-3 mb-sm-0">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name" required value="<?= @$fetchproduct['product_name'] ?>">
                  </div>
                  <div class="col-lg-2 col-sm-4 mt-3 px-3 mb-sm-0">
                    <label for="">Product Code</label>
                    <input type="text" class="form-control" id="product_code" placeholder="Product Code" name="product_code" required value="<?= @$fetchproduct['product_code'] ?>">
                  </div>
                  <div class="col-lg-2 col-sm-4 mt-3 w-100 px-3 mb-sm-0 d-flex">
                    <div class="w-100">
                      <label for="">Product Type</label>
                      <select class="form-control w-100 searchableSelect  tableData" required name="brand_id" id="tableData" size="1">
                        <option value="">Select Type</option>
                        <!-- <?php
                              $result = mysqli_query($dbc, "select * from brands");
                              while ($row = mysqli_fetch_array($result)) {
                              ?>

                          <option <?= @($fetchproduct['brand_id'] != $row["brand_id"]) ? "" : "selected" ?> value="<?= $row["brand_id"] ?>"><?= $row["brand_name"] ?></option>

                        <?php   } ?> -->
                        <option value="cora">Cora Kapra</option>
                        <option value="dyed">Dyed Product</option>
                        <option value="printed">Printed Product</option>
                        <option value="cora_cutted">Cora-Cutted Product</option>
                        <option value="dyed_cutted">Dyed-Cutted Product</option>
                        <option value="embroidered">Embroidered Product</option>
                        <option value="suit">Suit Product</option>
                      </select>
                    </div>
                    <!-- <div class="pl-3">
                      <label class="invisible d-block">.</label>
                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_brand_modal"> <i class="fa fa-plus"></i> </button>
                    </div> -->
                  </div>
                  <div class="col-lg-2 col-sm-4 mt-3 px-3 mb-sm-0 d-flex">
                    <div class="w-100">
                      <label for="">Product Category</label>
                      <select class="form-control w-100" required name="category_id" id="tableData1" size="1">
                        <option value="">Select Category</option>
                        <?php
                        $result = mysqli_query($dbc, "select * from categories");
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                          <option <?= @($fetchproduct['category_id'] != $row["categories_id"]) ? "" : "selected" ?> value="<?= $row["categories_id"] ?>"><?= $row["categories_name"] ?></option>
                        <?php   } ?>
                      </select>
                    </div>
                    <div class="pl-3">
                      <label class="invisible d-block">.</label>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add_category_modal"> <i class="fa fa-plus"></i> </button>
                    </div>
                  </div>
                  <div class="col-sm-2 mt-3 px-3 mb-sm-0">
                    <label for="">Product Alert on Quantity</label>
                    <input type="text" required class="form-control" value="<?= (empty($fetchproduct)) ? 5 : $fetchproduct['alert_at'] ?>" id="alert_at" placeholder="Product Stock Alert" name="alert_at">
                  </div>
                  <!-- <div class="col-sm-2 mt-3 px-3 mb-sm-0">
                    <label>Product Image</label>

                    <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                  </div> -->
                  <div class="col-sm-2 mt-3 px-3 mb-sm-0">
                    <label for="">Status</label>
                    <select class="form-control" required name="availability" id="availability">
                      <option value="1">Available</option>
                      <option value="0">Not Available</option>
                    </select>
                  </div>
                  <div class="col-sm-12 mt-3 px-3 mb-sm-0">
                    <label for="">Product Description</label>
                    <textarea class="form-control" name="product_description" placeholder="Product Description"><?= @$fetchproduct['product_description'] ?></textarea>
                  </div>

                </div>
                <div class="row">
                  <div class="col">
                    <button class="btn btn-admin  ml-3" type="submit" id="add_product_btn">Save</button>
                  </div>
                </div>
              </form>
            </div>



            <div class="form-group row">

            </div>
            <div class="form-group row">


            </div>
          <?php else: ?>
            <div class="card-body">


              <table class="table dataTable col-12" style="width: 100%" id="product_tb">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Brand/Category</th>
                    <?php
                    if ($UserData['user_role'] == 'admin'):
                    ?>
                      <th>Purchase</th>
                    <?php
                    endif;
                    ?>
                    <th>Selling Price</th>
                    <td>15 Days Rate
                    </td>
                    <td>30 Days Rate
                    </td>
                    <?php if ($get_company['stock_manage'] == 1): ?>
                      <th>Quanity instock</th>
                    <?php endif; ?>
                    <th class="d-print-none
">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $q = mysqli_query($dbc, "SELECT * FROM product WHERE status=1 ");
                  $c = 0;
                  while ($r = mysqli_fetch_assoc($q)) {
                    @$brandFetched = fetchRecord($dbc, "brands", "brand_id", $r['brand_id']);
                    @$categoryFetched = fetchRecord($dbc, "categories", "categories_id", $r['category_id']);
                    $c++;
                  ?>
                    <tr>
                      <td><?= $c ?></td>
                      <td><?= $r['product_code'] ?></td>
                      <td><?= $r['product_name'] ?></td>
                      <td><?= $brandFetched['brand_name'] ?>/<?= $categoryFetched['categories_name'] ?></td>
                      <?php
                      if ($UserData['user_role'] == 'admin'):
                      ?>
                        <td><?= $r['purchase_rate'] ?></td>
                      <?php
                      endif;
                      ?>
                      <td><?= $r['current_rate'] ?>
                      </td>
                      <td><?= $r['f_days'] ?>
                      </td>
                      <td><?= $r['t_days'] ?>
                      </td>
                      <?php if ($get_company['stock_manage'] == 1): ?>
                        <?php if ($r['quantity_instock'] > $r['alert_at']): ?>
                          <td>

                            <span class="badge p-1 badge-success d-print-none
"><?= $r['quantity_instock'] ?></span>
                          </td>
                        <?php else: ?>
                          <td><span class="badge p-1  badge-danger"><?= $r['quantity_instock'] ?></span> </td>

                        <?php endif; ?>
                      <?php endif; ?>
                      <td class="d-print-none">

                        <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                          <form action="product.php?act=add" method="POST">
                            <input type="hidden" name="edit_product_id" value="<?= base64_encode($r['product_id']) ?>">
                            <button type="submit" class="btn btn-admin btn-sm m-1 d-inline-block">Edit</button>
                          </form>
                        <?php endif ?>
                        <?php if (@$userPrivileges['nav_delete'] == 1 || $fetchedUserRole == "admin"): ?>
                          <button type="button" onclick="deleteAlert('<?= $r['product_id'] ?>','product','product_id','product_tb')" class="btn btn-admin2 btn-sm  d-inline-block">Delete</button>

                        <?php endif ?>
                        <a href="print_barcode.php?id=<?= base64_encode($r['product_id']) ?>" class="btn btn-primary btn-sm">Barcode</a>
                      </td>

                    </tr>
                  <?php } ?>
                </tbody>
              </table>


            <?php endif ?>
            </div>
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

    </main> <!-- main -->
  </div> <!-- .wrapper -->

</body>

</html>
<?php include_once 'includes/foot.php'; ?>