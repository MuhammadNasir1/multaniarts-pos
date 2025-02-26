<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php';
if (isset($_REQUEST['id'])) {
  $voucher = fetchRecord($dbc, "vouchers", "voucher_id", base64_decode($_REQUEST['id']));
}
?>

<body class="horizontal light  ">
  <div class="wrapper">
    <?php include_once 'includes/header.php'; ?>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header card-bg">
            <div class="col-12 mx-auto h4">
              <b class="text-center card-text text-center"><?= ucwords(str_replace('_', ' ', @$_REQUEST['type'])) ?> Payment Voucher</b>

              <?php if (@$userPrivileges['nav_add'] == 1 || $fetchedUserRole == "admin"): ?>
                <a href="<?= $getpage ?>" class="btn btn-admin float-right btn-sm hide"> Add New</a>
              <?php endif ?>
            </div>
          </div>

          <div class="card-body">
            <div class="row">

              <?php if ($_REQUEST['act'] == "general_voucher") { ?>



                <div class="col-sm-12">
                  <form action="php_action/custom_action.php" method="POST" id="voucher_general_form">
                    <div class="form-group row">

                      <div class="col-sm-1 text-right">
                        Voucher No
                      </div>
                      <div class="col-sm-3">
                        <?php
                        $last_id = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT voucher_id FROM vouchers ORDER BY voucher_id DESC LIMIT 1"));
                        $new_voucher_id = isset($last_id['voucher_id']) ? $last_id['voucher_id'] + 1 : 1;
                        ?>
                        <input type="text" name="voucher_no" readonly value="<?= $new_voucher_id ?>" class="form-control" placeholder="Voucher No">
                      </div>

                      <div class="col-sm-1 text-right">
                        Date
                      </div>
                      <div class="col-sm-3">
                        <?php if (isset($_REQUEST['id'])): ?>
                          <input type="date" class="form-control" name="new_voucher_date" value="<?= @$voucher['voucher_date'] ?>">

                        <?php else: ?>
                          <input type="date" class="form-control" name="new_voucher_date" value="<?= date('Y-m-d') ?>">

                        <?php endif ?>
                        <input type="hidden" class="form-control" name="voucher_id" value="<?= @$voucher['voucher_id'] ?>">
                        <input type="hidden" class="form-control" name="voucher_group" value="general_voucher">
                      </div>
                      <div class="col-sm-1 text-right">
                        Last Voucher
                      </div>
                      <div class="col-sm-3 ">
                        <input type="text" name="previous_voucher_no" readonly value="<?= @$last_id['voucher_id'] ?>" class="form-control " placeholder="Voucher No">
                      </div>
                      <input type="hidden" class="form-control" name="voucher_payment_type" value="<?= $_REQUEST['type'] ?>">
                      <div class="col-sm-1 text-right d-none">
                        Type
                      </div>
                      <div class="col-sm-3 d-none">
                        <select class="form-control" name="voucher_type">
                          <option <?= @($voucher['voucher_type'] == "general_voucher") ? "checked" : "" ?> value="general_voucher">General Voucher</option>
                          <option <?= @($voucher['voucher_type'] == "payment_clearance") ? "checked" : "" ?> value="payment_clearance ">Payment Clearance </option>
                          <option <?= @($voucher['voucher_type'] == "transferring") ? "checked" : "" ?> value="transferring">Transferring</option>
                        </select>

                      </div>
                    </div>

                    <div class="row text-center">
                      <div class="col-4 border py-2 bg-dark text-white">Account</div>
                      <div class="col-4 border py-2 bg-dark text-white">Narration</div>
                      <div class="col-4 border py-2 bg-dark text-white">Amount</div>
                    </div>

                    <div id="voucherRows" class="mt-3">
                      <div class="form-group row voucherRow">
                        <div class="col-sm-4 border">
                          <div class="input-group  py-2">
                            <select class="form-control voucher_from_account " onchange="getBalance(this.value,'from_account_bl')" name="voucher_from_account[]" aria-label="Username">
                              <option value="">Select Account</option>
                              <?php
                              $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 AND customer_type != 'bank' ORDER BY customer_type ASC");
                              $type2 = '';
                              while ($r = mysqli_fetch_assoc($q)):
                                $type = $r['customer_type'];
                              ?>
                                <?php if ($type != $type2): ?>
                                  <optgroup label="<?= $r['customer_type'] ?>">
                                  <?php endif ?>
                                  <option value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>
                                  <?php if ($type != $type2): ?>
                                  </optgroup>
                                <?php endif ?>
                              <?php
                                $type2 = $r['customer_type'];
                              endwhile; ?>
                            </select>
                            <div class="input-group-prepend d-none">
                              <span class="input-group-text">Balance :<span class="from_account_bl">0</span> </span>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-4 border py-2">
                          <input type="text" name="voucher_hint[]" placeholder="Narration" class="form-control">
                        </div>

                        <div class="col-sm-3 border py-2">
                          <input type="number" min="1" onkeyup="sameValue(this.value,'.voucher_debit')" name="voucher_credit[]" class="form-control voucher_credit" placeholder="Amount">
                        </div>

                        <div class="col-sm-1 text-right d-none">Debit</div>
                        <div class="col-sm-2 d-none">
                          <input type="number" onkeyup="sameValue(this.value,'.voucher_credit')" min="0" name="voucher_debit[]" class="form-control voucher_debit">
                        </div>

                        <div class="col-sm-1 border py-2">
                          <button type="button" class="btn btn-success addRow">+</button>
                          <button type="button" class="btn btn-danger removeRow">-</button>
                        </div>
                      </div>
                    </div>

                    <div class="d-none">
                      <select name="cash_in_hand" id="cash_in_hand">
                        <?php $bank = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_type = 'bank'");
                        while ($b = mysqli_fetch_assoc($bank)) {
                        ?>
                          <option value="<?= $b['customer_id'] ?>" selected><?= $b['customer_name'] ?></option>
                        <?php } ?>

                      </select>
                    </div>
                    <hr class="pb-3">
                    <div class="row">
                      <div class="col-sm-4 border py-2">
                        <div for="" class="font-weight-bold" style="font-size: 20px;">Previous Balance: <span id="previous_balance">0</span></div>
                      </div>
                      <div class="col-sm-4 border py-2 ml-auto">
                        <div for="" class="font-weight-bolder" style="font-size: 20px;">Grand Total: <span id="grand_total">0</span></div>
                        <input type="hidden" name="grant_total" id="grant_total_feild">
                      </div>
                    </div>
                    <!-- end of formgr0up -->

                    <!-- <div class="form-group row">

                      <div class="col-sm-2 text-right d-none">From Account</div>
                      <div class="col-sm-4 d-none">
                        <div class="input-group mb-3">
                          <select class="form-control" id="voucher_to_account" name="voucher_to_account" onchange="getBalance(this.value,'to_account_bl')" aria-label="Username" aria-describedby="basic-addon1">
                            <option value="">Select Account</option>


                            <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 and customer_type = 'bank' ");
                            $type2 = '';
                            while ($r = mysqli_fetch_assoc($q)):
                              $type = $r['customer_type'];
                            ?>
                              <?php if ($type != $type2): ?>
                                <optgroup label="<?= $r['customer_type'] ?>">
                                <?php endif ?>

                                <option selected value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                <?php if ($type != $type2): ?>
                                </optgroup>
                              <?php endif ?>
                            <?php $type2 = $r['customer_type'];
                            endwhile; ?>


                          </select>
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Balance :<span id="to_account_bl">0</span> </span>
                          </div>
                        </div>
                      </div>


                    </div> -->
                    <div class="form-group ">
                      <div class="row">


                      </div>
                    </div>
                    <!-- <div class="form-group row">
                      <div class="col-sm-2 text-right">DD/ Check No.</div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="td_check_no" value="<?= @$voucher['td_check_no'] ?>">
                      </div>
                      <div class="col-sm-2 text-right">Bank Name</div>

                      <div class="col-sm-4">
                        <input type="text" autocomplete="off" value="<?= @$voucher['voucher_bank_name'] ?>" id="voucher_bank_name" name="voucher_bank_name" class="form-control" list="bank_list">
                        <datalist id="bank_list">

                          <?php
                          $q = mysqli_query($dbc, "SELECT DISTINCT voucher_bank_name from vouchers WHERE voucher_type='general_voucher' ");
                          while ($r = mysqli_fetch_assoc($q)) {
                          ?>
                            <option value="<?= $r['voucher_bank_name'] ?>"><?= $r['voucher_bank_name'] ?></option>
                          <?php   } ?>

                        </datalist>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-2 text-right">DD/ Check Date</div>
                      <div class="col-sm-4">
                        <input type="date" class="form-control" name="td_check_date" >
                      </div>

                      <div class="col-sm-2 text-right">Type</div>
                      <div class="col-sm-4">
                        <input autocomplete="off" type="text" class="form-control" name="check_type" value="<?= @$voucher['check_type'] ?>" list="check_type_list">
                        <datalist id="check_type_list">

                          <?php
                          $q = mysqli_query($dbc, "SELECT DISTINCT check_type from vouchers WHERE voucher_type='general_voucher' ");
                          while ($r = mysqli_fetch_assoc($q)) {
                          ?>
                            <option value="<?= $r['check_type'] ?>"><?= $r['check_type'] ?></option>
                          <?php   } ?>

                        </datalist>

                      </div>

                    </div> -->
                    <hr>
                    <div class="row  ml-auto">
                      <button class="btn btn-admin ml-auto mr-3" type="submit" id="voucher_general_btn">Save </button>
                      <?php if (@$userPrivileges['nav_add'] == 1 || $fetchedUserRole == "admin" and !isset($_REQUEST['id'])): ?>
                      <?php endif ?>
                      <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin" and isset($_REQUEST['id'])): ?>
                        <button class="btn btn-admin ml-auto mr-3" type="submit" id="voucher_general_btn">Update </button>
                      <?php endif ?>
                    </div>
                  </form>

                </div>
              <?php } elseif ($_REQUEST['act'] == "expense_voucher") {
              ?>
                <div class="col-sm-12">

                  <form action="php_action/custom_action.php" method="POST" id="voucher_expense_fm">
                    <div class="form-group row">
                      <div class="col-sm-2 text-right">
                        Date
                      </div>
                      <div class="col-sm-4">
                        <?php if (isset($_REQUEST['id'])): ?>
                          <input type="date" class="form-control" name="new_voucher_date" value="<?= @$voucher['voucher_date'] ?>">

                        <?php else: ?>
                          <input type="date" class="form-control" name="new_voucher_date" value="<?= date('Y-m-d') ?>">

                        <?php endif ?>
                        <input type="hidden" class="form-control" name="voucher_id" value="<?= @$voucher['voucher_id'] ?>">
                        <input type="hidden" class="form-control" name="voucher_group" value="expense_voucher">

                      </div>
                      <div class="col-sm-2 text-right">
                        Type
                      </div>
                      <div class="col-sm-4">
                        <select class="form-control" name="voucher_type">
                          <?php $q = get($dbc, "expenses WHERE expense_status=1 ");
                          while ($r = mysqli_fetch_assoc($q)) {
                            # code...

                          ?>
                            <option <?= @($voucher['voucher_type'] == $r['expense_id']) ? "checked" : "" ?> value="<?= $r['expense_id'] ?>"><?= strtoupper($r['expense_name']) ?></option>
                          <?php } ?>

                        </select>

                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-2 text-right"> Account</div>
                      <div class="col-sm-4">
                        <div class="input-group mb-3">
                          <select class="form-control" onchange="getBalance(this.value,'from_account_exp')" id="voucher_from_account" name="voucher_from_account" aria-label="Username" aria-describedby="basic-addon1">
                            <option value="">Select Account</option>


                            <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 ORDER BY customer_type ASC ");
                            $type2 = '';
                            while ($r = mysqli_fetch_assoc($q)):
                              $type = $r['customer_type'];
                            ?>
                              <?php if ($type != $type2): ?>
                                <optgroup label="<?= $r['customer_type'] ?>">
                                <?php endif ?>

                                <option <?= @($voucher['customer_id1'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                <?php if ($type != $type2): ?>
                                </optgroup>
                              <?php endif ?>
                            <?php $type2 = $r['customer_type'];
                            endwhile; ?>
                          </select>
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Balance : <span id="from_account_exp">0</span> </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 text-right">
                        Debit
                      </div>

                      <div class="col-sm-4">
                        <input type="number" onkeyup="sameValue(this.value,'#voucher_credit')" min="0" name="voucher_debit" class="form-control" value="<?= @$voucher['voucher_amount'] ?>" required>
                      </div>
                    </div> <!-- end of formgr0up -->
                    <div class="form-group row">


                      <div class="col-sm-2 text-right"> Account</div>
                      <div class="col-sm-4">
                        <div class="input-group mb-3">
                          <select class="form-control" onchange="getBalance(this.value,'to_account_exp')" id="voucher_to_account" name="voucher_to_account" aria-label="Username" aria-describedby="basic-addon1">
                            <option value="">Select Account</option>


                            <?php $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 ");
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
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Balance : <span id="to_account_exp">0</span> </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 text-right"> Credit
                      </div>

                      <div class="col-sm-4">
                        <input type="text" readonly value="<?= @$voucher['voucher_amount'] ?>" id="voucher_credit" name="voucher_credit" class="form-control">
                      </div>


                    </div>
                    <div class="form-group row">
                      <div class="col-sm-2 text-right">Hint
                      </div>
                      <div class="col-sm-10">
                        <input type="text" name="voucher_hint" class="form-control" value="<?= @$voucher['voucher_hint'] ?>">
                      </div>
                    </div>

                    <hr>
                    <div class="row">
                      <div class="col-sm-2 offset-10">
                        <button class="btn btn-admin " type="submit" id="voucher_expense_btn">Save </button>
                      </div>
                    </div>
                  </form>


                </div>
              <?php } elseif ($_REQUEST['act'] == "single_voucher") {
              ?>
                <div class="col-sm-12">


                  <form action="php_action/custom_action.php" method="POST" id="voucher_single_fm">
                    <div class="form-group row">
                      <div class="col-sm-2 text-right">
                        Date
                      </div>
                      <div class="col-sm-4">
                        <?php if (isset($_REQUEST['id'])): ?>
                          <input type="date" class="form-control" name="new_sin_voucher_date" value="<?= @$voucher['voucher_date'] ?>">

                        <?php else: ?>
                          <input type="date" class="form-control" name="new_sin_voucher_date" value="<?= date('Y-m-d') ?>">

                        <?php endif ?>
                        <input type="hidden" class="form-control" name="voucher_id" value="<?= @$voucher['voucher_id'] ?>">
                        <input type="hidden" class="form-control" name="voucher_group" value="single_voucher">

                      </div>
                      <div class="col-sm-2 text-right">Account</div>
                      <div class="col-sm-4">
                        <div class="input-group mb-3">
                          <select class="form-control" required onchange="getBalance(this.value,'account_sing')" name="voucher_from_account" aria-label="Username" aria-describedby="basic-addon1">
                            <option value="">Select Account</option>


                            <?php
                            $transactions = fetchRecord($dbc, "transactions", "transaction_id", $voucher['transaction_id1']);

                            $q = mysqli_query($dbc, "SELECT * FROM customers WHERE customer_status =1 ORDER BY customer_type ASC ");
                            $type2 = '';
                            while ($r = mysqli_fetch_assoc($q)):
                              $type = $r['customer_type'];
                            ?>
                              <?php if ($type != $type2): ?>
                                <optgroup label="<?= $r['customer_type'] ?>">
                                <?php endif ?>

                                <option <?= @($voucher['customer_id1'] == $r['customer_id']) ? "selected" : "" ?> value="<?= $r['customer_id'] ?>"><?= $r['customer_name'] ?></option>

                                <?php if ($type != $type2): ?>
                                </optgroup>
                              <?php endif ?>
                            <?php $type2 = $r['customer_type'];
                            endwhile; ?>
                          </select>
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Balance : <span id="account_sing">0</span> </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-2 text-right"> Credit
                      </div>

                      <div class="col-sm-4">
                        <input type="number" onkeyup="readonlyIt(this.value,'voucher_sin_debit')" value="<?= @$transactions['credit'] ?>" id="voucher_sin_credit" name="voucher_credit" class="form-control" required>
                      </div>
                      <div class="col-sm-2 text-right">
                        Debit
                      </div>

                      <div class="col-sm-4">
                        <input type="number" onkeyup="readonlyIt(this.value,'voucher_sin_credit')" min="0" name="voucher_debit" id="voucher_sin_debit" class="form-control" value="<?= @$transactions['debit'] ?>">
                      </div>
                    </div> <!-- end of formgr0up -->

                    <div class="form-group row">
                      <div class="col-sm-2 text-right">Hint
                      </div>
                      <div class="col-sm-10">
                        <input type="text" name="voucher_hint" class="form-control" value="<?= @$voucher['voucher_hint'] ?>">
                      </div>
                    </div>

                    <hr>
                    <div class="row">
                      <div class="col-sm-2 offset-10">
                        <button class="btn btn-admin " type="submit" id="voucher_single_btn">Save </button>
                      </div>
                    </div>
                  </form>



                </div>


              <?php } elseif ($_REQUEST['act'] == "list") { ?> <!-- add --------------- -->
                <div class="col-sm-12">
                  <table class="table  dataTable" id="voucher_expense_tb">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>From Account</th>
                        <th>To Account</th>
                        <th>Amount</th>
                        <th>Hint</th>
                        <th>Voucher Type</th>
                        <th>Date</th>
                        <th>By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $q = mysqli_query($dbc, "SELECT * FROM vouchers WHERE payment_type != 'send' AND payment_type != 'receive' ORDER BY voucher_id  DESC LIMIT 200");
                      $c = 0;
                      while ($r = mysqli_fetch_assoc($q)) {
                        $c++;
                        @$customer_id1 = fetchRecord($dbc, "customers", "customer_id", $r['customer_id1'])['customer_name'];
                        @$customer_id2 = fetchRecord($dbc, "customers", "customer_id", $r['customer_id2'])['customer_name'];
                        $username = fetchRecord($dbc, "users", "user_id", $r['addby_user_id'])['username'];



                      ?>
                        <tr>
                          <td><?= $r['voucher_id'] ?></td>
                          <td><?= $customer_id1 ?></td>
                          <td><?= @$customer_id2 ?></td>
                          <td><?= $r['voucher_amount'] ?></td>
                          <td><?= $r['voucher_hint'] ?></td>
                          <td><?= $r['voucher_group'] ?></td>
                          <td><?= $r['voucher_date'] ?></td>
                          <td><?= $username ?></td>
                          <td>
                            <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                              <form action="voucher.php" method="POST">
                                <input type="hidden" name="id" value="<?= base64_encode($r['voucher_id']) ?>">
                                <input type="hidden" name="act" value="<?= $r['voucher_group'] ?>">
                                <button type="submit" class="btn m-1 btn-admin btn-sm">Edit</button>
                              </form>


                            <?php endif ?>
                            <a onclick="getVoucherPrint(`<?= base64_encode($r['voucher_id']) ?>`)" href="#" class="btn btn-primary btn-sm m-1">Print</a>
                            <?php if (@$userPrivileges['nav_delete'] == 1 || $fetchedUserRole == "admin"): ?>

                              <a href="#" onclick="deleteAlert('<?= $r['voucher_id'] ?>','vouchers','voucher_id','voucher_expense_tb')" class="btn btn-admin2 btn-sm m-1">Delete</a>
                            <?php endif ?>
                          </td>
                        </tr>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>

              <?php   } else {
              ?>
                <div class="col-sm-12">
                  <table class="table  dataTable" id="voucher_expense_tb">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                        <th>By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $q = mysqli_query($dbc, "SELECT * FROM vouchers WHERE payment_type = 'send' OR payment_type = 'receive' ORDER BY voucher_id  DESC LIMIT 200");
                      $c = 0;
                      while ($r = mysqli_fetch_assoc($q)) {
                        $c++;
                        @$customer_id1 = fetchRecord($dbc, "customers", "customer_id", $r['customer_id1'])['customer_name'];
                        @$customer_id2 = fetchRecord($dbc, "customers", "customer_id", $r['customer_id2'])['customer_name'];
                        $username = fetchRecord($dbc, "users", "user_id", $r['addby_user_id'])['username'];



                      ?>
                        <tr class="text-capitalize">
                          <td><?= $r['voucher_id'] ?></td>
                          <td><?= $r['voucher_date'] ?></td>
                          <td><?= $r['voucher_amount'] ?></td>
                          <td><?= $r['payment_type'] ?></td>
                          <td><?= $username ?></td>
                          <td>
                            <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                              <form action="voucher.php?act=general_voucher&type=<?= $r['payment_type'] ?>" method="POST">
                                <input type="hidden" name="id" value="<?= base64_encode($r['voucher_id']) ?>">
                                <input type="hidden" name="act" value="<?= $r['voucher_group'] ?>">
                                <button type="submit" class="btn m-1 btn-admin btn-sm">Edit</button>
                              </form>


                            <?php endif ?>
                            <a onclick="getVoucherPrint(`<?= base64_encode($r['voucher_id']) ?>`)" href="#" class="btn btn-primary btn-sm m-1">Print</a>
                            <?php if (@$userPrivileges['nav_delete'] == 1 || $fetchedUserRole == "admin"): ?>

                              <a href="#" onclick="deleteAlert('<?= $r['voucher_id'] ?>','vouchers','voucher_id','voucher_expense_tb')" class="btn btn-admin2 btn-sm m-1">Delete</a>
                            <?php endif ?>
                          </td>
                        </tr>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              <?php
              } ?>

            </div>
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
    function calculateGrandTotal() {
      let total = 0;
      $(".voucher_credit").each(function() {
        let value = parseFloat($(this).val()) || 0;
        total += value;
      });
      $("#grand_total").text(total.toFixed(2)); // Update Grand Total
      $("#grant_total_feild").val(total.toFixed(2)); // Update Grand Total
    }

    // Add new row
    $(document).on("click", ".addRow", function() {
      let newRow = $(".voucherRow").first().clone(); // Clone the first row
      newRow.find("select, input").val(""); // Reset values

      let randID = Math.floor(Math.random() * 100000);
      newRow.find(".voucher_from_account").attr("id", "voucher_from_account_" + randID);
      newRow.find(".from_account_bl").attr("id", "from_account_bl_" + randID);
      newRow.find(".voucher_credit").attr("id", "voucher_credit_" + randID);
      newRow.find(".voucher_debit").attr("id", "voucher_debit_" + randID);

      $("#voucherRows").append(newRow); // Append new row
      calculateGrandTotal(); // Recalculate total
    });

    // Remove row
    $(document).on("click", ".removeRow", function() {
      if ($(".voucherRow").length > 1) {
        $(this).closest(".voucherRow").remove(); // Remove the closest row
        calculateGrandTotal(); // Recalculate total after deletion
      } else {
        alert("At least one row is required.");
      }
    });
    $(document).on("keyup change", ".voucher_credit", function() {
      sameValue(this, ".voucher_debit"); // Update debit field in the same row
      calculateGrandTotal(); // Recalculate total
    });

    $(document).on("keyup change", ".voucher_debit", function() {
      sameValue(this, ".voucher_credit"); // Update credit field in the same row
      calculateGrandTotal(); // Recalculate total
    });
    // Recalculate Grand Total when credit values change
    $(document).on("keyup change", ".voucher_credit", function() {
      calculateGrandTotal();
    });
  });
</script>