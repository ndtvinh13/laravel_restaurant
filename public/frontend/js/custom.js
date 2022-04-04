// ======================== Ajax search ======================= //
$(function () {
    // src = "{{ route('search.product') }}";
    const src = "/laravel_restaurant/search";
    $("#search_text").autocomplete({
        source: (request, response) => {
            $.ajax({
                url: src,
                data: { term: request.term },
                dataType: "json",
                success: function (data) {
                    response(data);
                    console.log(request);
                },
                async: false,
            });
        },
        minLength: 1,
    });

    $(document).on("click", ".ui-menu-item", function () {
        $("#search-form").submit();
    });
});

// ========================== Search Ajax ver2 ======================= //
$(function () {
    $(document).on("keyup", "#search_text_ajax", function () {
        var query = $(this).val();
        if (query != "") {
            const url = "/laravel_restaurant/search-ajax";
            $.ajax({
                type: "get",
                url: url,
                data: { query: query },
                success: function (response) {
                    productData(response);
                    // console.log(response);
                },
            });
        } else {
            $("#product_list").fadeOut();
            $("#product_list").html("");
        }
    });

    function productData(resp) {
        var item = JSON.parse(resp);
        let val = item.data;
        $("#product_list").fadeIn();
        $("#product_list").html(val);
    }

    $(document).on("click", ".search-item-product", function () {
        var name = $(this).children().next().text();
        $("#search_text_ajax").val(name);
        $("#search-form-ajax").submit();
    });
});

// ====================== Cart Ajax Display ================== //
$(function () {
    $(".cart-display").on("mouseenter", function (e) {
        e.preventDefault;
        let cart_count = $(".cart-display").next().attr("cart_count");
        let cart_content = $(".cart-display").next().attr("cart_content");
        // console.log(cart_content);
        $.ajax({
            type: "get",
            data: { cart_content: cart_content },
            url: "/laravel_restaurant/cart-item-hover-ajax",
            dataType: "json",
            success: function (response) {
                $(".cart-item-hover").slideDown("fast");
                $(".cart-item-hover")
                    .html(response)
                    .addClass("cart-hover-show");
                // console.log(response);
            },
        });
    });
    $(".cart-item-hover").on("mouseleave", function (e) {
        e.preventDefault;
        $(".cart-item-hover").slideUp("fast");
        $(".cart-item-hover").removeClass("cart-hover-show");
    });
});

// ====================== Ajax adding cart =================== //
$(function () {
    $(".addItem").on("click", function (e) {
        let product_id = $(this).attr("product_id");
        let category_id = $(this).attr("category_id");
        console.log(category_id);
        Swal.fire({
            toast: true,
            title: "Item is added",
            icon: "success",
            position: "top",
            timer: 1500,
            padding: "20px",
            showConfirmButton: false,
            timerProgressBar: true,
        });
        $.ajax({
            type: "get",
            // url: cart.save.ajax,
            url: "/laravel_restaurant/save-cart-ajax",
            data: { product_id: product_id, category_id: category_id, qty: 1 },
            success: function (response) {
                displayCart(response);
            },
        });
    });
});

function displayCart(data) {
    let cart = JSON.parse(data);
    let count = cart.count;
    $(".cart-count").html(count);
}

// ====================== Delete an item with - using Ajax ================ //
// $(function () {
//     $(".dec").on("click", function (e) {
//         let row_id = $(this).attr("row_id");
//         let item_qty = $(this).next().val();
//         let item_price = $(this).next().attr("item_price");
//         let current = $(this).parent().parent().parent().next();
//         let sum = item_qty * item_price;
//         // console.log(row_id,item_qty,item_price,current);
//         let pos = $(this).parent().parent().parent().parent();
//         // Delete the item when its quantity = 0 - using ajax
//         if (item_qty == 0) {
//             $.ajax({
//                 type: "get",
//                 //   url: "{{route('cart.item.del.ajax')}}",
//                 url: "/laravel_restaurant/cart-item-del-ajax",
//                 data: { row_id: row_id },
//                 success: function (response) {
//                     delItem(response, pos);
//                 },
//             });
//         } else {
//             $.ajax({
//                 type: "get",
//                 // url: "{{route('cart.item.ajax')}}",
//                 url: "/laravel_restaurant/cart-item-del-ajax",
//                 data: {
//                     row_id: row_id,
//                     item_qty: item_qty,
//                     item_price: item_price,
//                 },
//                 success: function (response) {
//                     displayItem(response);
//                     current.each(function (i) {
//                         current.eq(i).html("$" + sum.toFixed(2));
//                     });
//                 },
//             });
//         }
//     });
// });

// =============== Add an item with + using Ajax ================= //
$(function () {
    $(".inc").on("click", function (e) {
        let row_id = $(this).attr("row_id");
        let item_qty = $(this).prev().val();
        let item_price = $(this).prev().attr("item_price");
        let current = $(this).parent().parent().parent().next();
        let sum = item_qty * item_price;
        console.log(row_id, item_qty, item_price, current, sum);

        let item_id = $(this).find(".item-display-id").attr("row_id");
        console.log(item_id);

        $.ajax({
            type: "get",
            // url: "{{route('cart.item.ajax')}}",
            url: "/laravel_restaurant/cart-item-ajax",
            data: {
                row_id: row_id,
                item_qty: item_qty,
                item_price: item_price,
            },
            success: function (response) {
                displayItem(response);
                current.each(function (i) {
                    console.log(current.eq(i).html("$" + sum.toFixed(2)));
                });
            },
        });
    });
});

// JSON Parse
function displayItem(data) {
    let coup = parseInt(
        $(".coupon-discount").children().children().first().html()
    );
    let discount_val = $(".coupon-discount")
        .children()
        .children()
        .first()
        .attr("discount_val");
    console.log(discount_val);
    let item = JSON.parse(data);
    let count = item.count;
    let subtotal = item.subtotal;
    let tax = item.tax;
    let itemSub = item.itemSub;
    let itemQty = item.itemQty;
    let itemId = item.itemId;
    // let total = item.total - coup;
    let total_amount = item.total - coup;
    let total_percent = item.total * (1 - coup / 100);

    if (discount_val == "amount")
        if (total_amount < 0) {
            let neg_total = parseInt(0);
            $(".total-ajax").html("$" + neg_total.toFixed(2));
        } else {
            $(".total-ajax").html("$" + total_amount.toFixed(2));
        }
    else $(".total-ajax").html("$" + total_percent.toFixed(2));

    $(".cart-count").html(count);
    $(".subtotal-ajax").html("$" + subtotal);
    $(".tax-ajax").html("$" + tax);
    $(".cart-display-subtotal").html("$" + subtotal);
    // if(){
    //     $(".cart-display-qty").html(itemQty);
    // }
}

$(function () {
    let abc = $(".item-display-id").prop("data-id");
});

// function delItem(data, pos) {
//     let item = JSON.parse(data);
//     let count = item.count;
//     let del_item = item.del_item;
//     let posi = pos;
//     let subtotal = item.subtotal;
//     let total = item.total;
//     let tax = item.tax;
//     $(".cart-count").html(count);
//     $(".subtotal-ajax").html("$" + subtotal);
//     $(".total-ajax").html("$" + total);
//     $(".tax-ajax").html("$" + tax);
//     posi.html(del_item);
// }

// Adding comment
// $(function () {

//   $('.btn-review').click(function (e) {
//     e.preventDefault();
//     // var _token = $('input[name="_token"]').val();
//     var _token = $('.review-token').val();
//     var product_id = $('.productId').val();
//     var review_name = $('input[name="name"]').val();
//     var review_comment = $('.review-comment-text').val();

//     console.log(product_id,review_name, review_comment, _token);

//     // $.ajaxSetup({
//     //   headers: {
//     //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     //   }
//     // });

//     $.ajax({
//       type: "POST",
//       url: "{{route('comment')}}",
//       data: {product_id: product_id, review_name: review_name, review_comment: review_comment, _token: _token},
//       success: function (response) {
//         // commentDisplay(response);
//         // $('.review-wrapper').children().html(response);
//         console.log(response);
//       }
//     });

//   });

//   function commentDisplay(data){
//     let output = JSON.parse(data);

//   }

// });
