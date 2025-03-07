   <style>
     .voucher-div {
       background-color: #343a40;
       color: white;
       border: none;
       outline: none;
       font-weight: bold;
       padding: 10px 0px 10px;
       width: 100%;
       border-radius: 4px;
     }
   </style>
   <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-sm" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="list-group list-group-flush my-n3">
             <div class="list-group-item bg-transparent">
               <div class="row align-items-center">
                 <div class="col-auto">

                   <span class="fe fe-download fe-24"></span>
                 </div>
                 <div class="col">
                   <small><strong>Sale And Purchases (Add Product row)</strong></small>
                   <div class="my-0 small">alt+enter</div>

                 </div>
               </div>
             </div>
             <div class="list-group-item bg-transparent">
               <div class="row align-items-center">
                 <div class="col-auto">
                   <span class="fe fe-box fe-24"></span>
                 </div>
                 <div class="col">
                   <small><strong>Print Sale or Purchase </strong></small>
                   <div class="my-0 small">alt+p</div>

                 </div>
               </div>
             </div>
             <div class="list-group-item bg-transparent">
               <div class="row align-items-center">
                 <div class="col-auto">
                   <span class="fe fe-inbox fe-24"></span>
                 </div>
                 <div class="col">
                   <small><strong>Save Sale And Purchase</strong></small>
                   <div class="my-0 small">alt+s</div>
                 </div>
               </div> <!-- / .row -->
             </div>
           </div> <!-- / .list-group -->
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
         </div>
       </div>
     </div>
   </div>
   <!-- Modal add----------------product              -->
   <div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="defaultModalLabel">Add Product</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <form action="php_action/custom_action.php" id="add_product_fm" method="POST" enctype="multipart/form-data">

           <div class="modal-body">
             <input type="hidden" name="action" value="product_module">
             <input type="hidden" name="product_id" value="<?= @$fetchproduct['product_name'] ?>">
             <input type="hidden" id="product_add_from" value="modal">

             <div class="form-group row">
               <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="">Product Name</label>
                 <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name" required value="<?= @$fetchproduct['product_name'] ?>">
               </div>
               <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="">Sale Rate</label>
                 <input type="number" class="form-control" id="current_rate" placeholder=" Rate" name="current_rate" required value="<?= @$fetchproduct['current_rate'] ?>">
               </div>
             </div>

             <div class="form-group row d-none">
               <div class="col-sm-6">
                 <label for="">Product Brand</label>
                 <select class="form-control searchableSelect" required name="brand_id" id="brand_id" size="1">
                   <option value="">Select Brand</option>
                   <?php
                    $result = mysqli_query($dbc, "select * from brands");
                    while ($row = mysqli_fetch_array($result)) {
                    ?>

                     <option selected  value="<?= $row["brand_id"] ?>"><?= $row["brand_name"] ?></option>

                   <?php   } ?>
                 </select>
               </div>
               <div class="col-sm-6">
                 <label for="">Product Category</label>
                 <input type="text" name="add_category_name" id="volumeNo">
                 <!-- <select class="form-control searchableSelect" required name="category_id" id="tableData1" size="1">
                   <option value="">Select Category</option>
                   <?php
                    $result = mysqli_query($dbc, "select * from categories");
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                     <option <?= @($fetchproduct['category_id'] != $row["categories_id"]) ? "" : "selected" ?> value="<?= $row["categories_id"] ?>"><?= $row["categories_name"] ?></option>
                   <?php   } ?>
                 </select> -->
               </div>
             </div>
             <div class="form-group row">
              
               <!-- <div class="col-sm-6 mb-3 mb-sm-0">

                 <label for="">Status</label>
                 <select class="form-control" required name="availability" id="availability">
                   <option value="1">Available</option>
                   <option value="0">Not Available</option>
                 </select>

               </div> -->

             </div>
             <!-- <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="">15 Days Sale Rate</label>
                <input type="number" class="form-control" id="f_days" placeholder="15 Days Sale Rate" name="f_days" value="<?= @$fetchproduct['f_days'] ?>">
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="">30 Days Sale Rate</label>
                <input type="number" class="form-control" id="t_days" placeholder="30 Days Sale Rate" name="t_days" value="<?= @$fetchproduct['t_days'] ?>">
              </div> -->
             <!-- <div class="form-group row">
               <div class="col-sm-6">
                 <label for="">Product Alert on Quantity</label>
                 <input type="text" required class="form-control" value="<?= (empty($fetchproduct)) ? 5 : $fetchproduct['alert_at'] ?>" id="alert_at" placeholder="Product Stock Alert" name="alert_at">
               </div>
               <div class="col-sm-6">
                 <label>Product Image</label>

                 <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
               </div>
             </div> -->
             <div class="form-group row">
               <!-- <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="">Product Description</label>

                 <textarea class="form-control" name="product_description" placeholder="Product Description"><?= @$fetchproduct['product_description'] ?></textarea>
               </div> -->

             </div>


           </div>
           <div class="modal-footer">
             <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
             <button class="btn btn-admin float-right" type="submit" id="add_product_btn">Save</button>
           </div>
         </form>
       </div>
     </div>
   </div>

   <!-- Modal add----------------product              -->
   <div class="modal fade" id="add_brand_modal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="defaultModalLabel">Add Brand</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>


         <div class="modal-body">

           <form action="php_action/panel.php" method="POST" role="form" id="formData">
             <div class="msg"></div>
             <div class="form-group row">
               <div class="col-sm-6">
                 <label for="">Brand</label>
                 <input type="text" class="form-control" value="<?= @$brands['brand_name'] ?>" id="add_brand_name" name="add_brand_name">
                 <input type="hidden" class="form-control " value="<?= @$brands['brand_id'] ?>" id="brand_id" name="brand_id">

               </div>
               <div class="col-sm-6">
                 <label for="">Brand Status</label>
                 <select class="form-control" id="brand_status" name="brand_status">
                   <option <?= @($brands['brand_status'] == 0) ? "selected" : "" ?> value="0">Inactive</option>
                   <option <?= @($brands['brand_status'] == 1) ? "selected" : "selected" ?> value="1">Active</option>

                 </select>
               </div>
             </div>
             <hr>
             <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>

             <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin" and isset($_REQUEST['edit_brand_id'])) : ?>
               <button type="submit" class="btn btn-admin2 float-right" id="formData_btn">Update</button>
             <?php endif ?>
             <?php if (@$userPrivileges['nav_add'] == 1 || $fetchedUserRole == "admin" and !isset($_REQUEST['edit_brand_id'])) : ?>
               <button type="submit" class="btn btn-admin float-right" id="formData_btn">Add</button>
             <?php endif ?>
           </form>

         </div>
         <div class="modal-footer"></div>

       </div>
     </div>
   </div>

   <!-- Add program -->
   <div class="modal fade" id="add_program_modal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="defaultModalLabel">Add Program</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>


         <div class="modal-body">

           <form action="php_action/custom_action.php" method="POST" role="form" id="program_data">
             <div class="msg"></div>
             <div class="form-group row">
               <div class="col-sm-6">
                 <label for="">Name</label>
                 <input type="text" class="form-control" id="add_program_name" name="add_program_name">
               </div>
               <div class="col-sm-6">
                 <label for="">Status</label>
                 <select class="form-control" id="program_status" name="program_status">
                   <option value="1">Active</option>
                   <option value="0">Inactive</option>
                 </select>
               </div>
             </div>
             <hr>
             <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-admin float-right">Submit</button>
           </form>


         </div>
         <div class="modal-footer"></div>

       </div>
     </div>
   </div>

   <!-- Modal add----------------product              -->
   <div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="defaultModalLabel">Add Category</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>

         <div class="modal-body">

           <form action="php_action/panel.php" method="POST" role="form" id="formData1">
             <div class="msg"></div>
             <div class="form-group row">
               <div class="col-sm-6">
                 <label for="">Name</label>
                 <input type="text" class="form-control" value="<?= @$categories['categories_name'] ?>" id="categories_name" name="add_category_name">
                 <input type="hidden" class="form-control " value="<?= @$categories['categories_id'] ?>" id="categories_id" name="categories_id">

               </div>
               <div class="col-sm-6">
                 <label for=""> Status</label>
                 <select class="form-control" id="categories_status" name="categories_status">

                   <option <?= @($categories['categories_status'] == 1) ? "selected" : "selected" ?> value="1">Active</option>
                   <option <?= @($categories['categories_status'] == 0) ? "selected" : "" ?> value="0">Inactive</option>
                 </select>
               </div>
             </div>
             <hr>
             <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
             <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin" and isset($_REQUEST['edit_categories_id'])) : ?>
               <button type="submit" class="btn btn-admin2 float-right" id="formData_btn">Update</button>
             <?php endif ?>
             <?php if (@$userPrivileges['nav_add'] == 1 || $fetchedUserRole == "admin" and !isset($_REQUEST['edit_categories_id'])) : ?>
               <button type="submit" class="btn btn-admin float-right" id="formData1_btn">Add</button>
             <?php endif ?>
           </form>

         </div>

       </div>
     </div>
   </div>


   <!-- Add Production Modal -->

   <!-- Modal -->
   <div class="modal fade" id="addProductionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-dark">
           <h5 class="modal-title  text-white" id="exampleModalLongTitle">Add Production</h5>
           <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>

         <div class="modal-body">
           <form id="add_production_fm" class="formData">
             <input type="hidden" name="prod_upd_id" value="<?= @$updateProduction['production_id'] ?>">
             <input type="hidden" name="purchase_id" id="purchase_id" value="">
             <div class="form-group row ">
               <div class="col-lg-12  col-md-12 col-sm-12 col-xs-2 mb-3 mb-sm-0">
                 <label for="" class="font-weight-bold text-dark">Date</label>
                 <input type="date" class="form-control" id="production_add_date" name="production_add_date" <?php if (@$_REQUEST['update-production']) { ?> value="<?= @$updateProduction['production_date'] ?>" <?php } else { ?> value="<?= date('Y-m-d') ?>" <?php } ?>>
               </div>
               <div class="col-lg-12 mt-3 col-md-12 col-sm-12 col-xs-2 mb-3 mb-sm-0">
                 <label for="" class="font-weight-bold text-dark">Lat No</label>
                 <input type="text" readonly class="form-control" id="production_lat_no" name="production_lat_no" required value="">
               </div>
               <div class="col-lg-12 mt-3 col-md-12 col-sm-12 col-xs-2 mb-3 mb-sm-0">
                 <label for="" class="font-weight-bold text-dark">Production Name</label>
                 <input type="text" class="form-control" id="production_name" placeholder="Production Name" name="production_name" value="<?= ucwords(@$updateProduction['production_name']) ?>">
               </div>
             </div>

         </div>
         <div class="modal-footer formData">
           <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeProductionModal">Close</button>
           <button type="submit" id="inv_btn" class="btn btn-admin float-right">
             <span id="loader_code" class="spinner-border d-none" style="width: 1.5rem !important;height: 1.5rem !important;"></span>
             <span id="text_code" class="">Save</span>
           </button>
         </div>
         </form>
         <div id="voucherData" class="pb-5">

         </div>
       </div>
     </div>
   </div>

   <div class="modal fade" id="newVoucherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-dark">
           <h5 class="modal-title  text-white" id="exampleModalLongTitle">View Vouchers</h5>
           <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>

         <div class="modal-body">

         </div>
       </div>
     </div>
   </div>






   <script src="js/jquery.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/moment.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/simplebar.min.js"></script>
   <script src='js/daterangepicker.js'></script>
   <script src='js/jquery.stickOnScroll.js'></script>
   <script src="js/tinycolor-min.js"></script>
   <script src="js/config.js"></script>
   <script src="js/d3.min.js"></script>
   <script src="js/topojson.min.js"></script>
   <script src="js/datamaps.all.min.js"></script>
   <script src="js/datamaps-zoomto.js"></script>
   <script src="js/datamaps.custom.js"></script>
   <script src="js/Chart.min.js"></script>
   <script src="js/jquery-ui.min.js"></script>

   <script>
     /* defind global options */
     Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
     Chart.defaults.global.defaultFontColor = colors.mutedColor;
   </script>
   <script src="js/gauge.min.js"></script>
   <script src="js/jquery.sparkline.min.js"></script>
   <script src="js/apexcharts.min.js"></script>
   <script src="js/apexcharts.custom.js"></script>
   <script src='js/jquery.mask.min.js'></script>
   <script src='js/select2.min.js'></script>
   <script src='js/jquery.steps.min.js'></script>
   <script src='js/jquery.validate.min.js'></script>
   <script src='js/jquery.timepicker.js'></script>
   <script src='js/dropzone.min.js'></script>
   <script src='js/uppy.min.js'></script>
   <script src='js/quill.min.js'></script>
   <script src='js/jquery.dataTables.min.js'></script>
   <script src='js/dataTables.bootstrap4.min.js'></script>
   <script src="js/apps.js"></script>
   <script src="js/custom.js"></script>
   <script src="js/panel.js"></script>
   <script>
     $(document).ready(function() {
       // When the rate field value changes
       $('#current_rate').on('input', function() {
         var rateValue = $(this).val();

         // Set the same value for f_days and t_days
         $('#f_days').val(rateValue);
         $('#t_days').val(rateValue);
       });
     });

     function onlyNumberInput(event) {
       // Get the value of the input field
       let input = event.target.value;

       // Remove any non-numeric characters using a regular expression
       let cleanInput = input.replace(/[^0-9]/g, '');

       // Update the input field value with only numeric characters
       event.target.value = cleanInput;
     }


     function getPurId(id) {
       document.getElementById('purchase_id').value = id;

       function generateRandomCode(length = 11) {
         var characters = '0123456789';
         var code = '';
         for (var i = 0; i < length; i++) {
           code += characters.charAt(Math.floor(Math.random() * characters.length));
         }
         return code;
       }
       var randomCode = generateRandomCode();
       $('#production_lat_no').val(randomCode);
     }

     $(document).ready(function() {
       $("#program_data").on("submit", function(event) {
         event.preventDefault();

         var formData = $(this).serialize();

         $.ajax({
           type: "POST",
           url: "php_action/custom_action.php",
           data: formData,
           dataType: "json",
           success: function(response) {
             if (response.sts === "success") {
               // Add new option to the select field
               var newOption = $("<option>")
                 .val(response.data.program_id)
                 .text(response.data.name);

               $("#program").append(newOption);

               // Select the newly added option
               $("#program").val(response.data.program_id).trigger("change");

               // Close the modal and reset the form
               $("#add_program_modal").modal("hide");
               $("#program_data")[0].reset(); // Resetting form fields

               // Show SweetAlert success message
               Swal.fire({
                 icon: "success",
                 title: "Program Added",
                 text: response.msg,
                 showConfirmButton: false,
                 timer: 1500,
               });
             } else {
               // Show SweetAlert warning message
               Swal.fire({
                 icon: "warning",
                 title: "Warning",
                 text: response.msg,
                 showConfirmButton: true,
               });
             }
           },
           error: function() {
             // Show SweetAlert error message
             Swal.fire({
               icon: "error",
               title: "Error",
               text: "An error occurred while adding the program.",
               showConfirmButton: true,
             });
           },
         });
       });
     });
   </script>