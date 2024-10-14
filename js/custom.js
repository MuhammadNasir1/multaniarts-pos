$(document).ready(function () {
  // Function to calculate and update the quantity
  function calculateQuantity() {
    var thaan = parseFloat($("#get_pur_thaan").val()) || 0;
    var gzanah = parseFloat($("#get_pur_gzanah").val()) || 0;
    var quantity = thaan * gzanah;
    $("#get_product_quantity").val(quantity);
  }

  // Bind the calculate function to input changes
  $("#get_pur_thaan, #get_pur_gzanah").on("input", calculateQuantity);
});

$(document).ready(function () {
  document.onkeyup = function (e) {
    if (e.altKey && e.which == 13) {
      //enter press
      $("#addProductPurchase").trigger("click");
      // subAmount();
    }
    if (e.altKey && e.which == 83) {
      //s press
      $("#sale_order_btn").click();
    }
    if (e.altKey && e.which == 80) {
      //s press
      Swal.clickConfirm();
    }
  };
  $("#formData").on("submit", function (e) {
    //console.log('click');
    e.preventDefault();
    var form = $("#formData");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#formData_btn").prop("disabled", true);
        $("#loader_code").removeClass("d-none");
        $("#text_code").addClass("d-none");
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#formData").each(function () {
            this.reset();
          });
          $("#tableData").load(location.href + " #tableData > *");
          $(".modal").modal("hide");
        }
        $("#formData_btn").prop("disabled", false);
        $("#loader_code").addClass("d-none");
        $("#text_code").removeClass("d-none");
        console.log(response.sts);
        sweeetalert(response.msg, response.sts, 1500);
      },
    }); //ajax call
  }); //main
  $("#formData1").on("submit", function (e) {
    e.stopPropagation();
    e.preventDefault();
    var form = $("#formData1");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#formData1_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#formData1").each(function () {
            this.reset();
          });
          //$("#tableData").load(location.href+" #tableData");
          $(".modal").modal("hide");
        }
        $("#formData1_btn").prop("disabled", false);

        $("#tableData1").load(location.href + " #tableData1 > *");

        sweeetalert(response.msg, response.sts, 1500);
      },
    }); //ajax call
  }); //main
  $("#formData2").on("submit", function (e) {
    e.stopPropagation();
    e.preventDefault();
    var form = $("#formData2");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#formData2_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#formData2").each(function () {
            this.reset();
          });
          //$("#tableData").load(location.href+" #tableData");
          $(".modal").modal("hide");
        }
        $("#formData2_btn").prop("disabled", false);

        $("#tableData2").load(location.href + " #tableData2 > *");

        sweeetalert(response.msg, response.sts, 1500);
      },
    }); //ajax call
  }); //main
  $("#sale_order_fm").on("submit", function (e) {
    e.preventDefault();
    var form = $("#sale_order_fm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#sale_order_print").prop("disabled", true);
        $("#sale_order_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#sale_order_fm").each(function () {
            this.reset();
          });
          $("#purchase_product_tb").html("");
          $("#product_grand_total_amount").html("");
          $("#product_total_amount").html("");
          $("#productionModalButton").click();
          function generateRandomCode(length = 11) {
            var characters = "0123456789";
            var code = "";
            for (var i = 0; i < length; i++) {
              code += characters.charAt(
                Math.floor(Math.random() * characters.length)
              );
            }
            return code;
          }
          var randomCode = generateRandomCode();
          $("#production_lat_no").val(randomCode);
          $("#purchase_id").val(response.order_id);

          // 	window.location.assign('print_order.php?order_id='+response.order_id);

          //$("#tableData").load(location.href+" #tableData");
          // Swal.fire({
          //   title: response.msg,
          //   showDenyButton: true,
          //   showCancelButton: true,
          //   confirmButtonText: `Print`,
          //   denyButtonText: `Add New`,
          // }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          // if (result.isConfirmed) {
          //   location.reload();

          //   window.open(
          //     "print_sale.php?id=" +
          //       response.order_id +
          //       "&type=" +
          //       response.type,
          //     "_blank"
          //   );
          // } else if (result.isDenied) {
          //   location.reload();
          // }
          // });
        }
        if (response.sts == "error") {
          sweeetalert(response.msg, response.sts, 1500);
        }
        $("#sale_order_btn").prop("disabled", false);
        //
      },
    }); //ajax call
  }); //main
  $(document).ready(function () {
    $("#voucherModalButton").hide();
    $("#voucherData").hide();
    $(".formData").show();
    $("#add_production_fm").on("submit", function (e) {
      e.preventDefault();
      // alert("ascas");

      var formdata = new FormData(this);

      $.ajax({
        type: "POST",
        url: "php_action/custom_action.php",
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $("#loader_code").removeClass("d-none");
          $("#text_code").addClass("d-none");
        },
        success: function (response) {
          $("#loader_code").addClass("d-none");
          $("#text_code").removeClass("d-none");
          var responseData = JSON.parse(response).sts;
          var responsemsg = JSON.parse(response).msg;
          var responseID = JSON.parse(response).purchase_id;
          var productionID = JSON.parse(response).production_id;

          if (responseData == "success") {
            $("#add_production_fm").trigger("reset");
            // $("#closeProductionModal").click();
            $(".formData").hide();
            $("#voucherData").show();
            $("#voucherData").html(
              '<div class="voucher-container row">' +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '">' +
                '<button class="voucher-div">Cutting Voucher</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#contact">' +
                '<button class="voucher-div">Print Voucher</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./dyeing.php?ProductionID=' +
                productionID +
                '#sending">' +
                '<button class="voucher-div">Dyeing</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#print_content">' +
                '<button class="voucher-div">Print</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#embroidery_content">' +
                '<button class="voucher-div">Insuance Embroidery</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#collect_emb_content">' +
                '<button class="voucher-div">Recieving Embroidery</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#stitch_pack_content">' +
                '<button class="voucher-div">Stitching & Packing</button>' +
                "</a>" +
                "</div>" +
                '<div class="col-6">' +
                '<a class="dropdown-item" target="_blank" href="./Production.php?ProductionID=' +
                productionID +
                '#calander_satander_content">' +
                '<button class="voucher-div">Calander & Stander</button>' +
                "</a>" +
                "</div>" +
                "</div>"
            );

            // $("#voucherModal").click();
            // $("#exampleModalCenter").click();
          } else {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: responsemsg,
              showConfirmButton: false,
              timer: 3000,
            });
          }
        },
      }); //ajax call
    }); //main
  });
  $("#credit_order_client_name").on("change", function () {
    var value = $("#credit_order_client_name :selected").data("id");
    var contact = $("#credit_order_client_name :selected").data("contact");
    $("#customer_account").val(value);
    $("#client_contact").val(contact);
  });

  $("#add_product_fm").on("submit", function (e) {
    e.preventDefault();
    var form = $(this);
    var fd = new FormData(this);
    var files = $("#product_image")[0].files[0];

    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: fd,
      dataType: "json",
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#add_product_btn").prop("disabled", true);
      },
      success: function (response) {
        console.log("click");
        if (response.sts == "success") {
          $("#add_product_fm").each(function () {
            this.reset();
          });
        }
        $("#add_product_btn").prop("disabled", false);
        var product_add_from = $("#product_add_from").val();
        if (product_add_from == "modal") {
          $("#get_product_name").load(location.href + " #get_product_name > *");
          $("#add_product_modal").modal("hide");
        }

        console.log(response.sts);
        sweeetalert(response.msg, response.sts, 1500);
      },
    }); //ajax call
  }); //main

  $("#voucher_general_fm").on("submit", function (e) {
    e.preventDefault();
    var form = $("#voucher_general_fm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#voucher_general_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#voucher_general_fm").each(function () {
            this.reset();
          });
          $("#tableData").load(location.href + " #tableData");
        }
        $("#voucher_general_btn").prop("disabled", false);

        Swal.fire({
          title: response.msg,
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: `Print`,
          denyButtonText: `Add New`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire({
              title: "Which type of do you Print?",
              showDenyButton: true,
              showCancelButton: true,
              confirmButtonText: `Debit`,
              denyButtonText: `Credit`,
              cancelButtonText: "Both",
            }).then((result) => {
              if (result.isConfirmed) {
                window.open(
                  "print_voucher.php?type=debit&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              } else if (result.isDenied) {
                window.open(
                  "print_voucher.php?type=credit&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              } else {
                window.open(
                  "print_voucher.php?type=both&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              }
            });
            //
          } else if (result.isDenied) {
            location.reload();
          }
        });
      },
    }); //ajax call
  }); //main
  $("#voucher_expense_fm").on("submit", function (e) {
    e.preventDefault();
    var form = $("#voucher_expense_fm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#voucher_expense_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#voucher_expense_fm").each(function () {
            this.reset();
          });
          $("#tableData").load(location.href + " #tableData");
        }
        $("#voucher_expense_btn").prop("disabled", false);
        //    sweeetalert(response.msg,response.sts,1500);
        Swal.fire({
          title: response.msg,
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: `Print`,
          denyButtonText: `Add New`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire({
              title: "Which type of do you Print?",
              showDenyButton: true,
              showCancelButton: true,
              confirmButtonText: `Debit`,
              denyButtonText: `Credit`,
              cancelButtonText: "Both",
            }).then((result) => {
              if (result.isConfirmed) {
                window.open(
                  "print_voucher.php?type=debit&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              } else if (result.isDenied) {
                window.open(
                  "print_voucher.php?type=credit&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              } else {
                window.open(
                  "print_voucher.php?type=both&voucher_id=" +
                    response.voucher_id,
                  "_blank"
                );
              }
            });
          } else if (result.isDenied) {
            location.reload();
          }
        });
      },
    }); //ajax call
  }); //main
  $("#voucher_single_fm").on("submit", function (e) {
    e.preventDefault();
    var form = $("#voucher_single_fm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#voucher_single_btn").prop("disabled", true);
      },
      success: function (response) {
        if (response.sts == "success") {
          $("#voucher_single_fm").each(function () {
            this.reset();
          });
          $("#tableData").load(location.href + " #tableData");
        }
        $("#voucher_single_btn").prop("disabled", false);
        sweeetalert(response.msg, response.sts, 1500);
        Swal.fire({
          title: response.msg,
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: `Print`,
          denyButtonText: `Add New`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            window.open(
              "print_voucher.php?type=debit&voucher_id=" + response.voucher_id,
              "_blank"
            );
          } else if (result.isDenied) {
            location.reload();
          }
        });
      },
    }); //ajax call
  }); //main
  $("#get_product_code").on("keyup", function () {
    var code = $("#get_product_code").val();
    var credit_sale_type = $("#credit_sale_type").val();
    var payment_type = $("#payment_type").val();
    //   var podid=  $('#get_product_name :selected').val();

    $.ajax({
      type: "POST",
      url: "php_action/custom_action.php",
      data: {
        get_products_list: code,
        type: "code",
      },
      dataType: "text",
      success: function (msg) {
        var res = msg.trim();
        $("#get_product_name").empty().html(res);
      },
    }); //ajax call }
    $.ajax({
      type: "POST",
      url: "php_action/custom_action.php",
      data: {
        getPrice: code,
        type: "code",
        credit_sale_type: credit_sale_type,
        payment_type: payment_type,
      },
      dataType: "json",
      success: function (response) {
        $("#get_product_price").val(response.price);
        $("#instockQty").text(response.qty);
        console.log(response.qty);

        // $("#get_product_quantity").attr("max", response.qty);

        // Disable the button if the quantity is 0 or less
        if (response.qty <= 0) {
          $("#addProductPurchase").prop("disabled", true);
        } else {
          $("#addProductPurchase").prop("disabled", false);
        }
      },
    });
    //ajax call }
  });
}); /*--------------end of-------------------------------------------------------*/
function pending_bills(value) {
  $.ajax({
    url: "php_action/custom_action.php",
    type: "post",
    data: {
      pending_bills_detils: value,
    },
    dataType: "json",
    success: function (response) {
      $("#bill_customer_name").empty().val(response.client_name);
      $("#order_id").empty().val(response.order_id);
      $("#bill_grand_total").empty().val(response.grand_total);
      $("#bill_paid_ammount").empty().val(response.paid);
      $("#bill_remaining").empty().val(response.due);
      $("#bill_paid").attr("max", response.due);
      $("#bill_paid").empty().val(0);
    },
  });
}

function getCustomer_name(value) {
  $.ajax({
    url: "php_action/custom_action.php",
    type: "post",
    data: {
      getCustomer_name: value,
    },
    dataType: "text",
    success: function (response) {
      var data = response.trim();
      $("#sale_order_client_name").empty().val(data);
    },
  });
}

function getRemaingAmount() {
  var paid_ammount = $("#paid_ammount").val();
  var product_grand_total_amount = $("#product_grand_total_amount").html();
  var total = parseInt(product_grand_total_amount) - parseInt(paid_ammount);
  $("#remaining_ammount").val(total);
}

function loadProducts(id) {
  $.ajax({
    url: "php_action/custom_action.php",
    type: "post",
    data: {
      getProductPills: id,
    },
    dataType: "text",
    success: function (response) {
      var data = response.trim();
      $("#products_list").empty().html(data);
    },
  });
}

$("#get_product_name").on("change", function () {
  //var code=  $('#get_product_code').val();
  var code = $("#get_product_name :selected").val();
  var payment_type = $("#payment_type").val();
  var credit_sale_type = $("#credit_sale_type").val();

  $.ajax({
    type: "POST",
    url: "php_action/custom_action.php",
    data: {
      get_products_list: code,
      type: "product",
    },
    dataType: "text",
    success: function (msg) {
      var res = msg.trim();
      $("#get_product_code").val(res);
    },
  }); //ajax call }
  $.ajax({
    type: "POST",
    url: "php_action/custom_action.php",
    data: {
      getPrice: code,
      type: "product",
      credit_sale_type: credit_sale_type,
      payment_type: payment_type,
    },
    dataType: "json",
    success: function (response) {
      $("#get_product_price").val(response.price);
      $("#instockQty").html(response.qty);
      console.log(response.qty);
      if (
        payment_type == "cash_in_hand" ||
        payment_type == "credit_sale" ||
        payment_type == "cash_sale"
      ) {
        $("#get_product_quantity").attr("max", response.qty);
        if (response.qty <= 0) {
          $("#addProductPurchase").prop("disabled", true);
        } else {
          $("#addProductPurchase").prop("disabled", false);
        }
      }
    },
  }); //ajax call }
});
$("#product_code").on("change", function () {
  //var code=  $('#get_product_code').val();
  var code = $("#product_code").val();
  if (/^[A-Za-z0-9]+$/.test(code)) {
    $.ajax({
      type: "POST",
      url: "php_action/custom_action.php",
      data: {
        get_products_code: code,
      },
      dataType: "json",
      success: function (response) {
        if (response.sts == "error") {
          $("#add_product_btn").prop("disabled", true);
          $("#product_code").val("");
          Swal.fire({
            position: "center",
            icon: "error",
            title: response.msg,
            showConfirmButton: true,
          });
        } else {
          $("#add_product_btn").prop("disabled", false);
        }
      },
    });
  } else {
    Swal.fire({
      position: "center",
      icon: "error",
      title:
        "Please Enter Only Alphabets and Number Without Space and Characters",
      showConfirmButton: true,
    });
  }
});
$("#full_payment_check").on("click", function () {
  var checked = $("#full_payment_check").is(":checked");
  var grand = $("#product_grand_total_amount").html();

  if (checked) {
    $("#paid_ammount").val(grand);
  } else {
    $("#paid_ammount").val(0);
  }
  $("#paid_ammount").trigger("keyup");
});
//function addProductPurchase() {

function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

$("#addProductPurchase").on("click", function () {
  var total_price = 0;
  var payment_type = $("#payment_type").val();

  var name = $("#get_product_name :selected").text();
  var price = $("#get_product_price").val();
  var thaan = $("#get_pur_thaan").val();
  var gzanah = $("#get_pur_gzanah").val();
  var unit = $("#get_pur_unit").val();
  var id = $("#get_product_name :selected").val();
  var product_quantity = $("#get_product_quantity").val();
  product_quantity = parseInt(product_quantity);
  var pro_type = $("#add_pro_type").val();
  var max_qty = $("#get_product_quantity").attr("max");
  max_qty = parseInt(max_qty);

  if (!id) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please select a product first!",
    });
    return;
  }

  if (!price || !thaan || !gzanah || !unit || !product_quantity) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please fill out all fields!",
    });
    return;
  }

  if (payment_type == "cash_purchase" || payment_type == "credit_purchase") {
    max_qty = getRandomInt(99999999999);
  }

  var GrandTotalAva = $("#remaining_ammount").val();
  var ThisTotal = price * product_quantity + Number(GrandTotalAva);
  var RThisPersonLIMIT = $("#R_LimitInput").val();

  if (id != "") {
    // Reset the input fields
    $("#get_product_name").val(null).trigger("change");
    $("#add_pro_type").val("add");
    $("#get_product_price").val("");
    $("#get_pur_thaan").val("");
    $("#get_pur_gzanah").val("");
    $("#get_pur_unit").val("");
    $("#get_product_quantity").val("1");
    $("#get_product_code").focus();
    $("#instockQty").text("0");

    total_price = parseFloat(price) * parseFloat(product_quantity);

    // Append the product details to the table
    $("#purchase_product_tb").append(
      '<tr id="product_idN_' +
        id +
        '">\
      <input type="hidden" data-price="' +
        price +
        '" data-quantity="' +
        product_quantity +
        '" id="product_ids_' +
        id +
        '" class="product_ids" name="product_ids[]" value="' +
        id +
        '">\
      <input type="hidden" id="product_quantites_' +
        id +
        '" name="product_quantites[]" value="' +
        product_quantity +
        '">\
      <input type="hidden" id="product_rate_' +
        id +
        '" name="product_rates[]" value="' +
        price +
        '">\
      <input type="hidden" id="pur_thaan_' +
        id +
        '" name="pur_thaan[]" value="' +
        thaan +
        '">\
      <input type="hidden" id="pur_gzanah_' +
        id +
        '" name="pur_gzanah[]" value="' +
        gzanah +
        '">\
      <input type="hidden" id="pur_unit_' +
        id +
        '" name="pur_unit[]" value="' +
        unit +
        '">\
      <input type="hidden" id="product_totalrate_' +
        id +
        '" name="product_totalrates[]" value="' +
        total_price +
        '">\
      <td>' +
        name +
        "</td>\
      <td>" +
        thaan +
        " </td>\
      <td>" +
        gzanah +
        " </td>\
      <td>" +
        unit +
        " </td>\
      <td>" +
        price +
        "</td>\
      <td>" +
        product_quantity +
        "</td>\
      <td>" +
        total_price +
        '</td>\
      <td>\
        <button type="button" class="delete-btn fa fa-trash text-danger"></button>\
        <button type="button" onclick="editByid(' +
        id +
        ",'" +
        thaan +
        "','" +
        gzanah +
        "','" +
        unit +
        "','" +
        price +
        "','" +
        product_quantity +
        '\')" class="delete-btn fa fa-edit text-success"></button>\
      </td>\
    </tr>'
    );

    getOrderTotal();
  } else {
    if (max_qty < product_quantity) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Cannot add quantity more than stock",
        timer: 1500,
      });
    }
  }
});

// Event delegation for delete buttons
$(document).on("click", ".delete-btn", function () {
  $(this).closest("tr").remove(); // Remove the row
  getOrderTotal(); // Recalculate total
});

function getOrderTotal() {
  var payment_type = $("#payment_type").val();
  var total_bill = (grand_total = 0);
  $(".product_ids").each(function () {
    var quantity = $(this).data("quantity");
    var rates = $(this).data("price");
    //console.log(rates);
    total_bill += parseFloat(rates) * parseFloat(quantity);
  });
  var discount = $("#ordered_discount").val();
  var freight = $("#freight").val();
  discount = discount == "" ? (discount = 0) : parseFloat(discount);
  if (
    payment_type == "cash_in_hand" ||
    payment_type == "credit_sale" ||
    payment_type == "cash_puchase" ||
    payment_type == "credit_purchase"
  ) {
    freight = freight == "" ? (freight = 0) : parseFloat(freight);
  } else {
    freight = 0;
  }
  //console.log(discount);
  grand_total = freight + total_bill - total_bill * (discount / 100);
  $("#product_total_amount").html(total_bill);
  $("#product_grand_total_amount").html(grand_total);

  if (payment_type == "cash_in_hand" || payment_type == "cash_purchase") {
    $("#paid_ammount").val(grand_total);
    $("#paid_ammount").attr("max", grand_total);
    $("#paid_ammount").prop("required", true);
    if (payment_type == "cash_in_hand") {
      $("#full_payment_check").prop("checked", true);
    }
  } else {
    $("#paid_ammount").val("0");
    $("#paid_ammount").prop("required", false);
  }
  if (grand_total > 0) {
    $("input[name='payment_account'] ").prop("required", true);
  } else {
    $("input[name='payment_account'] ").prop("required", false);
  }

  getRemaingAmount();
}

function editByid(id, thaan, gzanah, unit, price, product_quantity) {
  $(".searchableSelect").val(id);

  $("#get_pur_thaan").val(thaan);
  $("#get_pur_gzanah").val(gzanah);
  $("#get_pur_unit").val(unit);
  $("#get_product_quantity").val(product_quantity);
  $("#add_pro_type").val("update");

  var effect = function () {
    return $(".searchableSelect").select2().trigger("change");
  };

  $.when(effect()).done(function () {
    setTimeout(function () {
      $("#get_product_price").val(price);
    }, 500);
  });
}

function getBalance(val, id) {
  setTimeout(function () {
    if (id == "customer_account_exp") {
      var value = $("#customer_account").val();
    } else {
      var value = val;
    }
    $.ajax({
      type: "POST",
      url: "php_action/custom_action.php",
      data: {
        getBalance: value,
      },
      dataType: "json",
      success: function (response) {
        //alert(response.blnc);
        //var res=msg.trim();

        $("#" + id).html(response.blnc);
        $("#customer_Limit").html(response.custLimit);
        var RLIMIT = Math.abs(response.custLimit - response.blnc);
        //alert(RLIMIT);
        $("#R_Limit").html(RLIMIT);
        $("#R_LimitInput").val(RLIMIT);
      },
    }); //ajax call }
  }, 1000);
}
// ---------------------------order gui---------------------------------------

// var input = document.getElementById("barcode_product");
$("#barcode_product").on("keyup", function (event) {
  // input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    var value = input.value;
    event.preventDefault();
    addbarcode_product(value, "plus");
    //   console.log(value);
    input.value = "";
  }
});

function addbarcode_product(code, action_value) {
  //$("#ordered_products").append(dbarcode_productata);

  $.ajax({
    url: "php_action/custom_action.php",
    type: "post",
    data: {
      getProductDetailsBycode: code,
    },
    dataType: "json",
    success: function (res) {
      console.log(action_value);

      if ($("#product_idN_" + res.product_id).length) {
        var jsonObj = [];
        $(".product_ids").each(function (index) {
          var quantity = $(this).data("quantity");
          var val = $(this).val();

          if (val == res.product_id) {
            //$("#product_idN_"+id).remove();

            if (action_value == "plus") {
              var Currentquantity = 1 + parseInt(quantity);
            }
            if (action_value == "minus") {
              var Currentquantity = parseInt(quantity) - 1;
            }

            $("#product_idN_" + res.product_id).replaceWith(
              '<tr id="product_idN_' +
                res.product_id +
                '">\
					<input type="hidden" data-price="' +
                res.current_rate +
                '" data-quantity="' +
                Currentquantity +
                '" id="product_ids_' +
                res.product_id +
                '" class="product_ids" name="product_ids[]" value="' +
                res.product_id +
                '">\
					<input type="hidden" id="product_quantites_' +
                res.product_id +
                '" name="product_quantites[]" value="' +
                Currentquantity +
                '">\
					<input type="hidden" id="product_rates_' +
                res.product_id +
                '" name="product_rates[]" value="' +
                res.current_rate +
                '">\
					<td>' +
                res.product_code +
                "  </td>\
          <td>" +
                res.product_name +
                ' (<span class="text-success">' +
                res.brand_name +
                "</span>) </td>\
					<td>" +
                res.current_rate +
                " </td>\
					<td>" +
                Currentquantity +
                " </td>\
					<td>" +
                res.current_rate * Currentquantity +
                ' </td>\
					<td> <button type="button" onclick="addbarcode_product(`' +
                res.product_code +
                '`,`plus`)" class="fa fa-plus text-success" href="#" ></button>\
						<button type="button" onclick="addbarcode_product(`' +
                res.product_code +
                '`,`minus`)" class="fa fa-minus text-warning" href="#" ></button>\
						<button type="button" onclick="removeByid(`#product_idN_' +
                res.product_id +
                '`)" class="fa fa-trash text-danger" href="#" ></button>\
						</td>\
					</tr>'
            );
          }
          getOrderTotal();
        });
      } else {
        $("#purchase_product_tb").append(
          '<tr id="product_idN_' +
            res.product_id +
            '">\
			          <input type="hidden" data-price="' +
            res.current_rate +
            '"  data-quantity="1" id="product_ids_' +
            res.product_id +
            '" class="product_ids" name="product_ids[]" value="' +
            res.product_id +
            '">\
			          <input type="hidden" id="product_quantites_' +
            res.product_id +
            '" name="product_quantites[]" value="1">\
			          <input type="hidden" id="product_rate_' +
            res.product_id +
            '" name="product_rates[]" value="' +
            res.current_rate +
            '">\
			          <input type="hidden" id="product_totalrate_' +
            res.product_id +
            '" name="product_totalrates[]" value="' +
            res.current_rate +
            '">\
			          <td>' +
            res.product_code +
            "  </td>\
                <td>" +
            res.product_name +
            ' (<span class="text-success">' +
            res.brand_name +
            "</span>)</td>\
			           <td>" +
            res.current_rate +
            "</td>\
			           <td>1</td>\
			          <td>" +
            res.current_rate +
            '</td>\
			          <td>\
			            <button type="button" onclick="addbarcode_product(`' +
            res.product_code +
            '`,`plus`)" class="fa fa-plus text-success" href="#" ></button>\
						<button type="button" onclick="addbarcode_product(`' +
            res.product_code +
            '`,`minus`)" class="fa fa-minus text-warning" href="#" ></button>\
						<button type="button" onclick="removeByid(`#product_idN_' +
            res.product_id +
            '`)" class="fa fa-trash text-danger" href="#" ></button>\
						</td>\
			          </tr>'
        );

        getOrderTotal();
      }
      //console.log(jsonObj);
    },
  });
}

// ---------------------------order gui---------------------------------------
function addProductOrder(id, max = 100, action_value) {
  //$("#ordered_products").append(data);

  $.ajax({
    url: "php_action/custom_action.php",
    type: "post",
    data: {
      getProductDetails: id,
    },
    dataType: "json",
    success: function (res) {
      console.log(action_value);

      if ($("#product_idN_" + id).length) {
        var jsonObj = [];
        $(".product_ids").each(function (index) {
          var quantity = $(this).data("quantity");
          var val = $(this).val();

          if (val == id) {
            //$("#product_idN_"+id).remove();

            if (action_value == "plus") {
              var Currentquantity = 1 + parseInt(quantity);
            }
            if (action_value == "minus") {
              var Currentquantity = parseInt(quantity) - 1;
            }

            $("#product_idN_" + id).replaceWith(
              '<tr id="product_idN_' +
                id +
                '">\
          <input type="hidden" data-price="' +
                res.current_rate +
                '" data-quantity="' +
                Currentquantity +
                '" id="product_ids_' +
                id +
                '" class="product_ids" name="product_ids[]" value="' +
                res.product_id +
                '">\
          <input type="hidden" id="product_quantites_' +
                id +
                '" name="product_quantites[]" value="' +
                Currentquantity +
                '">\
          <input type="hidden" id="product_rates_' +
                id +
                '" name="product_rates[]" value="' +
                res.current_rate +
                '">\
          <td>' +
                res.product_name +
                ' (<span class="text-success">' +
                res.brand_name +
                "</span>) </td>\
          <td>" +
                res.current_rate +
                " </td>\
          <td>" +
                Currentquantity +
                " </td>\
          <td>" +
                res.current_rate * Currentquantity +
                ' </td>\
          <td> <button type="button" onclick="addProductOrder(' +
                id +
                "," +
                res.quantity +
                ',`plus`)" class="fa fa-plus text-success" href="#" ></button>\
            <button type="button" onclick="addProductOrder(' +
                id +
                "," +
                res.quantity +
                ',`minus`)" class="fa fa-minus text-warning" href="#" ></button>\
            <button type="button" onclick="removeByid(`#product_idN_' +
                id +
                '`)" class="fa fa-trash text-danger" href="#" ></button>\
            </td>\
          </tr>'
            );
          }
          getOrderTotal();
        });
      } else {
        $("#purchase_product_tb").append(
          '<tr id="product_idN_' +
            id +
            '">\
                <input type="hidden" data-price="' +
            res.current_rate +
            '"  data-quantity="1" id="product_ids_' +
            id +
            '" class="product_ids" name="product_ids[]" value="' +
            id +
            '">\
                <input type="hidden" id="product_quantites_' +
            id +
            '" name="product_quantites[]" value="1">\
                <input type="hidden" id="product_rate_' +
            id +
            '" name="product_rates[]" value="' +
            res.current_rate +
            '">\
                <input type="hidden" id="product_totalrate_' +
            id +
            '" name="product_totalrates[]" value="' +
            res.current_rate +
            '">\
                <td>' +
            res.product_name +
            ' (<span class="text-success">' +
            res.brand_name +
            "</span>)</td>\
                 <td>" +
            res.current_rate +
            "</td>\
                 <td>1</td>\
                <td>" +
            res.current_rate +
            '</td>\
                <td>\
                  <button type="button" onclick="addProductOrder(' +
            id +
            "," +
            res.quantity +
            ',`plus`)" class="fa fa-plus text-success" href="#" ></button>\
            <button type="button" onclick="addProductOrder(' +
            id +
            "," +
            res.quantity +
            ',`minus`)" class="fa fa-minus text-warning" href="#" ></button>\
            <button type="button" onclick="removeByid(`#product_idN_' +
            id +
            '`)" class="fa fa-trash text-danger" href="#" ></button>\
            </td>\
                </tr>'
        );

        getOrderTotal();
      }
      //console.log(jsonObj);
    },
  });
}

function readonlyIt(value, read_it_id) {
  if (value == "") {
    $("#" + read_it_id).prop("readonly", false);
  } else {
    $("#" + read_it_id).prop("readonly", true);
  }
}

// $("#product_mm,#product_inch,#product_meter").on("keyup", function () {
//   getTotal_price();
// });

// $("#tableData1").on("change", function () {
//   getTotal_price();
// });

// function getTotal_price() {
//   var total = (total1 = total2 = fif_rate = current_cat = thir_rate = 0);
//   var cat = $("#tableData1 :selected").data("price");
//   var product_mm = $("#product_mm").val();
//   var product_inch = $("#product_inch").val();
//   var product_meter = $("#product_meter").val();
//   var product_mm = product_mm == "" ? (product_mm = 0) : parseFloat(product_mm);
//   var product_inch =
//     product_inch == "" ? (product_inch = 0) : parseFloat(product_inch);
//   var product_meter =
//     product_meter == "" ? (product_meter = 0) : parseFloat(product_meter);
//   total = product_mm * product_inch * product_meter;
//   total1 = (total * parseFloat(cat)) / 54;
//   total2 = Math.round(total1);
//   $("#current_rate").val(total2);

//   current_cat = parseFloat(cat) + 0.05;
//   fif_rate = (total * current_cat) / 54;
//   fif_rate = Math.round(fif_rate);
//   $("#f_days").val(fif_rate);

//   current_cat = parseFloat(cat) + 0.1;
//   thir_rate = (total * current_cat) / 54;
//   thir_rate = Math.round(thir_rate);
//   $("#t_days").val(thir_rate);

//   console.log(total);
// }

function getVoucherPrint(voucher_id) {
  Swal.fire({
    title: "Which type of do you Print?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: `Debit`,
    denyButtonText: `Credit`,
    cancelButtonText: "Both",
  }).then((result) => {
    if (result.isConfirmed) {
      window.open(
        "print_voucher.php?type=debit&voucher_id=" + voucher_id,
        "_blank"
      );
    } else if (result.isDenied) {
      window.open(
        "print_voucher.php?type=credit&voucher_id=" + voucher_id,
        "_blank"
      );
    } else {
      window.open(
        "print_voucher.php?type=both&voucher_id=" + voucher_id,
        "_blank"
      );
    }
  });
}

function setAmountPaid(id, paid) {
  Swal.fire({
    title: "Did the Customer Paid All Amount?",
    showCancelButton: true,
    confirmButtonText: `Yes`,
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "php_action/custom_action.php",
        type: "post",
        data: {
          setAmountPaid: id,
          paid: paid,
        },
        dataType: "json",
        success: function (res) {
          sweeetalert(res.msg, res.sts, 1500);
          if (res.sts == "success") {
            //$("#view_orders_tb").load(location.href+" #view_orders_tb > *");
            location.reload();
          }
        },
      });
    } else {
    }
  });
}

// delete function

function deleteQuotationData(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Deleted!", "Quotation has been deleted.", "success");
      $.ajax({
        url: "php_action/custom_action.php",
        type: "post",
        data: {
          Quotation_delete_id: id,
        },
        dataType: "json",
        success: function (response) {
          $("#tableData").load(location.href + " #tableData > *");
        },
      });
    }
  });
}
// ============ Cutting Voucher script
// function cutt_voucher_duplicateRow() {
//   var container = $("#containerFirstRow");
//   var lastRow = container.children(".row:last").clone(true);
//   // Remove the remove button from the first row
//   container.find(".row:first .add_remove button").remove();
//   var newRowId = "row" + (container.children(".row").length + 1);
//   lastRow.attr("id", newRowId);
//   // Generate unique ids for the inputs in the cloned row
//   var cutt_type = "cutt_type" + (container.children(".row").length + 1);
//   var cutt_type_name =
//     "cutt_type_name" + (container.children(".row").length + 1);
//   var cutt_gzanah = "cutt_gzanah" + (container.children(".row").length + 1);
//   var cutt_gzanah_type =
//     "cutt_gzanah_type" + (container.children(".row").length + 1);
//   var cutt_status = "cutt_status" + (container.children(".row").length + 1);

//   // Update the ids in the cloned row
//   lastRow.find('[name="cutt_type[]"]').attr("id", cutt_type);
//   lastRow.find('[name="cutt_type_name[]"]').attr("id", cutt_type_name);
//   lastRow.find('[name="cutt_gzanah[]"]').attr("id", cutt_gzanah);
//   lastRow.find('[name="cutt_gzanah_type[]"]').attr("id", cutt_gzanah_type);
//   lastRow.find('[name="cutt_status[]"]').attr("id", cutt_status);

//   // Clear the input values in the cloned row
//   lastRow.find("input, select").val("");

//   // Remove existing "Plus" button from the last row
//   lastRow.find(".add_remove button").remove();

//   // Add "Plus" button to the new row
//   lastRow.find(".add_remove").append(`
//             <button type="button" class="outline_none border-0 bg-white" onclick="cutt_voucher_remove(this)">
//                 <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
//             </button>`);

//   container.append(lastRow);
// }
// function cutt_voucher_remove(button) {
//   var container = $("#containerFirstRow");
//   var rowToRemove = $(button).closest(".row");
//   rowToRemove.remove();
//   if (container.children(".row").length === 0) {
//     $("#cutt_voucher_btn").show();
//     location.reload();
//   }
// }

function cutt_voucher_duplicateRow() {
  // Clone the first row
  let newRow = $(".voucher_row2:first").clone();

  // Clear input values in the cloned row
  newRow.find("input").val("");
  newRow.find("select").prop("selectedIndex", 0);

  // Append the new row to the container
  $("#voucher_rows_container2").append(newRow);
}

function cutt_voucher_duplicateRow2() {
  // Clone the last row instead of the first row to keep any changes to the last row intact
  let newRow = $(".voucher_row:last").clone();

  // Clear input values in the cloned row
  newRow.find("input").val("");
  newRow.find("select").prop("selectedIndex", 0);

  // Append the new row at the end of the container
  $("#voucher_rows_container").append(newRow);

  // After appending, update the visibility of delete buttons
  updateDeleteButtonVisibility();
}

function cutt_voucher_remove2(el) {
  // Remove the row that the user clicked on
  $(el).closest(".voucher_row").remove();
}

function deying_voucher_remove3(el) {
  // Remove the row that the user clicked on
  $(el).closest(".row").remove();
}

function deying_voucher_remove4(el) {
  // Remove the row that the user clicked on
  $(el).closest(".row").remove();
}
function cutt_voucher_remove(el) {
  // Remove the row that the user clicked on
  $(el).closest(".voucher_row2").remove();
}

function deying_voucher_duplicateRow5() {
  var container = $("#dey3");

  // Clone the last row without copying event handlers
  var lastRow = container.children(".row:last").clone();

  // Generate new row ID based on the number of rows
  var rowCount = container.children(".row").length + 1;
  var newRowId = "row" + rowCount;
  lastRow.attr("id", newRowId);

  // Update the IDs and names for the input elements in the cloned row
  lastRow.find('[name="deying_product[]"]').attr({
    id: "deying_product" + rowCount,
    name: "deying_product[]",
  });
  lastRow.find('[name="dey_sending_thaan[]"]').attr({
    id: "deying_thaan" + rowCount,
    name: "dey_sending_thaan[]",
  });
  lastRow.find('[name="dey_sending_gzanah[]"]').attr({
    id: "deying_gzanah" + rowCount,
    name: "dey_sending_gzanah[]",
  });
  lastRow.find('[name="dey_sending_quantity[]"]').attr({
    id: "deying_quantity" + rowCount,
    name: "dey_sending_quantity[]",
  });

  // Clear the values of the input fields in the cloned row
  lastRow.find("input, select").val("");

  // Remove the "Plus" button from the cloned row and add a "Remove" button
  lastRow.find(".add_remove button").remove();
  lastRow.find(".add_remove").append(`
        <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_remove3(this)">
            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
        </button>`);

  // Append the cloned row to the container
  container.append(lastRow);

  // Attach any additional calculation or event handlers (if needed)
  attachCalculation(lastRow);
}
function deying_voucher_duplicateRow4() {
  var container = $("#dey4");

  // Clone the last row without copying event handlers
  var lastRow = container.children(".row:last").clone();

  // Get the new row index for unique IDs
  var newRowIndex = container.children(".row").length + 1;

  // Assign unique IDs for the new row inputs
  var thaanId = "dey_recieving_thaan" + newRowIndex;
  var gzanahId = "dey_recieving_gzanah" + newRowIndex;
  var quantityId = "dey_recieving_quantity" + newRowIndex;
  var dyeingCpId = "dyeing_cp" + newRowIndex;
  var typeId = "deying_gzanah_type" + newRowIndex;

  // Update the IDs in the cloned row
  lastRow.find('[name="dey_recieving_thaan[]"]').attr("id", thaanId);
  lastRow.find('[name="dey_recieving_gzanah[]"]').attr("id", gzanahId);
  lastRow.find('[name="dey_recieving_quantity[]"]').attr("id", quantityId);
  lastRow.find('[name="dyeing_cp[]"]').attr("id", dyeingCpId);
  lastRow.find('[name="deying_gzanah_type[]"]').attr("id", typeId);

  // Clear the input values in the cloned row
  lastRow.find("input").val("");

  // Remove the "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add the "Remove" button for the new row
  lastRow.find(".add_remove").append(`
        <button type="button" class="outline_none border-0 bg-white" onclick="deying_voucher_remove4(this)">
            <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
        </button>
    `);

  // Append the new row to the container
  container.append(lastRow);

  // Attach calculation logic to the new row if needed
  attachCalculation(lastRow);
}

$(document).ready(function () {
  // Function to calculate quantity
  function calculateQuantity() {
    var thaanCount = parseFloat($(".thaanCount").val()) || 0;
    var gzanahCount = parseFloat($(".gzanahCount").val()) || 0;
    var quantityCount = thaanCount * gzanahCount;

    // Set the calculated quantityCount
    $(".quantityCount").val(quantityCount);
  }

  // Attach event listeners to inputs for real-time calculation
  $(".thaanCount, .gzanahCount").on("input", function () {
    calculateQuantity();
  });
});

// ============ Print Voucher script
function print_duplicateRow() {
  var print_container = $("#print_container");

  var lastRow = print_container.children(".row:last").clone(true);

  var newRowId = "row" + (print_container.children(".row").length + 1);
  lastRow.attr("id", newRowId);
  // Generate unique ids for the inputs in the cloned row
  var print_quantity =
    "print_quantity" + (print_container.children(".row").length + 1);
  var print_quantity_name =
    "print_quantity_name" + (print_container.children(".row").length + 1);
  var print_status =
    "print_status" + (print_container.children(".row").length + 1);

  // Update the ids in the cloned row
  lastRow.find('[name="print_quantity[]"]').attr("id", print_quantity);
  lastRow
    .find('[name="print_quantity_name[]"]')
    .attr("id", print_quantity_name);
  lastRow.find('[name="print_status[]"]').attr("id", print_status);

  // Clear the input values in the cloned row
  lastRow.find("input, select").val("");

  // Remove existing "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add "Plus" button to the new row
  lastRow.find(".add_remove").append(`
            <button type="button" class="outline_none border-0 bg-white" onclick="print_remove(this)">
                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
            </button>`);

  print_container.append(lastRow);
}

function print_remove(button) {
  var print_container = $("#print_container");
  var rowToRemove = $(button).closest(".row");
  rowToRemove.remove();
  if (print_container.children(".row").length === 0) {
    $("#print_plus_button").show();
    location.reload();
  }
}

// ============ Embroidery Voucher script
function embroidery_duplicateRow() {
  var embroidery_container = $("#embroidery_container");
  var lastRow = embroidery_container.children(".row:last").clone(true);

  var newRowId = "row" + (embroidery_container.children(".row").length + 1);
  lastRow.attr("id", newRowId);
  // Generate unique ids for the inputs in the cloned row
  var embroid_type =
    "embroid_type" + (embroidery_container.children(".row").length + 1);
  var embroid_type_name =
    "embroid_type_name" + (embroidery_container.children(".row").length + 1);
  var embroid_gzanah =
    "embroid_gzanah" + (embroidery_container.children(".row").length + 1);
  var embroid_gzanah_type =
    "embroid_gzanah_type" + (embroidery_container.children(".row").length + 1);
  var emb_status =
    "emb_status" + (embroidery_container.children(".row").length + 1);

  // Update the ids in the cloned row
  lastRow.find('[name="embroid_type[]"]').attr("id", embroid_type);
  lastRow.find('[name="embroid_type_name[]"]').attr("id", embroid_type_name);
  lastRow.find('[name="embroid_gzanah[]"]').attr("id", embroid_gzanah);
  lastRow
    .find('[name="embroid_gzanah_type[]"]')
    .attr("id", embroid_gzanah_type);
  lastRow.find('[name="emb_status[]"]').attr("id", emb_status);

  // Clear the input values in the cloned row
  lastRow.find("input, select").val("");

  // Remove existing "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add "Plus" button to the new row
  lastRow.find(".add_remove").append(`
            <button type="button" class="outline_none border-0 bg-white" onclick="embroidery_remove(this)">
                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
            </button>`);

  embroidery_container.append(lastRow);
}

function embroidery_remove(button) {
  var embroidery_container = $("#embroidery_container");
  var rowToRemove = $(button).closest(".row");
  rowToRemove.remove();
  if (embroidery_container.children(".row").length === 0) {
    $("#embroidery_plus_btn").show();
    location.reload();
  }
}

// ============Collect Embroidery Voucher script
function collect_embroidery_duplicateRow() {
  var collect_embroidery_container = $("#collect_embroidery_container");
  var lastRow = collect_embroidery_container.children(".row:last").clone(true);

  var newRowId =
    "row" + (collect_embroidery_container.children(".row").length + 1);
  lastRow.attr("id", newRowId);

  var collect_embroid_type =
    "collect_embroid_type" +
    (collect_embroidery_container.children(".row").length + 1);
  var collect_embroid_type_name =
    "collect_embroid_type_name" +
    (collect_embroidery_container.children(".row").length + 1);
  var collect_embroid_gzanah =
    "collect_embroid_gzanah" +
    (collect_embroidery_container.children(".row").length + 1);
  var collect_embroid_gzanah_type =
    "collect_embroid_gzanah_type" +
    (collect_embroidery_container.children(".row").length + 1);
  var collect_embroid_status =
    "collect_embroid_status" +
    (collect_embroidery_container.children(".row").length + 1);

  // Update the ids in the cloned row
  lastRow
    .find('[name="collect_embroid_type[]"]')
    .attr("id", collect_embroid_type);
  lastRow
    .find('[name="collect_embroid_type_name[]"]')
    .attr("id", collect_embroid_type_name);
  lastRow
    .find('[name="collect_embroid_gzanah[]"]')
    .attr("id", collect_embroid_gzanah);
  lastRow
    .find('[name="collect_embroid_gzanah_type[]"]')
    .attr("id", collect_embroid_gzanah_type);
  lastRow
    .find('[name="collect_embroid_status[]"]')
    .attr("id", collect_embroid_status);

  // Clear the input values in the cloned row
  lastRow.find("input, select").val("");

  // Remove existing "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add "Plus" button to the new row
  lastRow.find(".add_remove").append(`
            <button type="button" class="outline_none border-0 bg-white" onclick="collect_embroidery_remove(this)">
                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
            </button>`);

  collect_embroidery_container.append(lastRow);
}

function collect_embroidery_remove(button) {
  var collect_embroidery_container = $("#collect_embroidery_container");
  var rowToRemove = $(button).closest(".row");
  rowToRemove.remove();
  if (collect_embroidery_container.children(".row").length === 0) {
    $("#collect_embroidery_plus_btn").show();
    location.reload();
  }
}

// ============Collect Embroidery Voucher script
function stiching_duplicateRow() {
  var stiching_container = $("#stiching_container");
  var lastRow = stiching_container.children(".row:last").clone(true);

  var newRowId = "row" + (stiching_container.children(".row").length + 1);
  lastRow.attr("id", newRowId);

  var stiching_type =
    "stiching_type" + (stiching_container.children(".row").length + 1);
  var stiching_type_name =
    "stiching_type_name" + (stiching_container.children(".row").length + 1);
  var stiching_gzanah =
    "stiching_gzanah" + (stiching_container.children(".row").length + 1);
  var stiching_gzanah_type =
    "stiching_gzanah_type" + (stiching_container.children(".row").length + 1);
  var stiching_status =
    "stiching_status" + (stiching_container.children(".row").length + 1);

  // Update the ids in the cloned row
  lastRow.find('[name="stiching_type[]"]').attr("id", stiching_type);
  lastRow.find('[name="stiching_type_name[]"]').attr("id", stiching_type_name);
  lastRow.find('[name="stiching_gzanah[]"]').attr("id", stiching_gzanah);
  lastRow
    .find('[name="stiching_gzanah_type[]"]')
    .attr("id", stiching_gzanah_type);
  lastRow.find('[name="stiching_status[]"]').attr("id", stiching_status);

  // Clear the input values in the cloned row
  lastRow.find("input, select").val("");

  // Remove existing "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add "Plus" button to the new row
  lastRow.find(".add_remove").append(`
            <button type="button" class="outline_none border-0 bg-white" onclick="stiching_remove(this)">
                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
            </button>`);

  stiching_container.append(lastRow);
}

function stiching_remove(button) {
  var stiching_container = $("#stiching_container");
  var rowToRemove = $(button).closest(".row");
  rowToRemove.remove();
  if (stiching_container.children(".row").length === 0) {
    $("#stiching_plus_btn").show();
    location.reload();
  }
}

// ============ Print Voucher script
function singleprint_duplicateRow() {
  var singleprint_container = $("#singleprint_container");

  var lastRow = singleprint_container.children(".row:last").clone(true);

  var newRowId = "row" + (singleprint_container.children(".row").length + 1);
  lastRow.attr("id", newRowId);
  // Generate unique ids for the inputs in the cloned row
  var singleprint_dp_no =
    "singleprint_dp_no" + (singleprint_container.children(".row").length + 1);
  var singleprint_type =
    "singleprint_type" + (singleprint_container.children(".row").length + 1);
  var singleprint_type_name =
    "singleprint_type_name" +
    (singleprint_container.children(".row").length + 1);
  var print2_status =
    "print2_status" + (singleprint_container.children(".row").length + 1);

  // Update the ids in the cloned row
  lastRow.find('[name="singleprint_dp_no[]"]').attr("id", singleprint_dp_no);
  lastRow.find('[name="singleprint_type[]"]').attr("id", singleprint_type);
  lastRow
    .find('[name="singleprint_type_name[]"]')
    .attr("id", singleprint_type_name);
  lastRow.find('[name="print2_status[]"]').attr("id", print2_status);

  // Clear the input values in the cloned row
  lastRow.find("input, select").val("");

  // Remove existing "Plus" button from the last row
  lastRow.find(".add_remove button").remove();

  // Add "Plus" button to the new row
  lastRow.find(".add_remove").append(`
            <button type="button" class="outline_none border-0 bg-white" onclick="singleprint_remove(this)">
                <img title="Remove Row" src="img/remove.png" width="30px" alt="remove sign">
            </button>`);

  singleprint_container.append(lastRow);
}

function singleprint_remove(button) {
  var singleprint_container = $("#singleprint_container");
  var rowToRemove = $(button).closest(".row");
  rowToRemove.remove();
  if (singleprint_container.children(".row").length === 0) {
    $("#singleprint_plus_button").show();
    location.reload();
  }
}

// Vouchers

function fetchDyerBalance(dyerId) {
  if (dyerId !== "") {
    $("#dyer_id").val(dyerId);

    $.ajax({
      url: "php_action/custom_action.php",
      method: "POST",
      data: { action: "fetch_balance", dyer_id: dyerId },
      success: function (response) {
        $("#from_account_bl").text(response === "" ? "0" : response);
      },
      error: function (xhr, status, error) {
        console.error("Balance AJAX Error:", status, error);
      },
    });
  } else {
    $("#from_account_bl").text("0");
    $("#dyer_id").val("");
    $(".tbody").html('<tr><td colspan="5">No data found</td></tr>');
  }
}

function fetchDyerData(dyerId) {
  const productionId = document.getElementById("production_id_input").value;

  if (dyerId !== "") {
    $.ajax({
      url: "php_action/custom_action.php",
      method: "POST",
      data: {
        action: "fetch_dyer_data",
        dyer_id: dyerId,
        ProductionID: productionId,
      },
      success: function (response) {
        $(".tbody").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Table Data AJAX Error:", status, error);
      },
    });
  } else {
    $(".tbody").html('<tr><td colspan="5">No data found</td></tr>');
  }
}

function getBalance(partyId) {
  if (partyId !== "") {
    $("#hidden_party_id").val(partyId);
    $.ajax({
      url: "php_action/custom_action.php",
      method: "POST",
      data: { action: "get_balance", party_id: partyId },
      success: function (response) {
        $("#balance_amount").text(response === "" ? "0" : response);
      },
      error: function (xhr, status, error) {
        console.error("Balance AJAX Error:", status, error);
      },
    });
  } else {
    $("#balance_amount").text("0");
    $("#hidden_party_id").val("");
  }
}

function getDyerData(partyId) {
  const productionId = document.getElementById("production_id_input").value;

  if (partyId !== "") {
    $.ajax({
      url: "php_action/custom_action.php",
      method: "POST",
      data: {
        action: "get_dyer_data",
        party_id: partyId,
        ProductionID: productionId,
      },
      success: function (response) {
        $("#dyer_data_table_body").html(response);
      },
      error: function (xhr, status, error) {
        console.error("Data AJAX Error:", status, error);
      },
    });
  } else {
    $("#dyer_data_table_body").html(
      '<tr><td colspan="5">No data found</td></tr>'
    );
  }
}

// function deleteRow(deyId) {
//   if (confirm("Are you sure you want to delete this row?")) {
//     $.ajax({
//       url: "php_action/delete_dyeing_entry.php",
//       method: "POST",
//       data: { dey_id: deyId },
//       success: function (response) {
//         alert(response); // Show success message
//         location.reload(); // Reload the page or fetch the data again to update the table
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX Error:", status, error);
//       },
//     });
//   }
// }
