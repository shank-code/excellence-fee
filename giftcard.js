$(document).ready(function() {
  var currentURL = document.location.hostname;
  var varient_id;
  var res;
  var i = 0;
  var interval = setInterval(function() {
    //get data from card.js shopify api
    $.ajax({
      type: "GET",
      url: "https://" + currentURL + "/cart.js",
      dataType: "json",
      success: function(data) {
        var cartItems = [];
        Object.keys(data.items).forEach(function(key) {
          cartItems.push(data.items[key].variant_id);
        });

        //get data from database
        $.ajax({
          url: "https://plivo1.demo.xmagestore.com/shopify_giftcard_app/db.php",
          data: { action: "database", store: currentURL },
          type: "post",
          datatype: "json",
          success: function(responsedata) {
            var x;

            $.each(JSON.parse(responsedata), function(i, data1) {
              var res = data1.product_varient.split("_");

              x = cartItems.find(function(params) {
                return params == res[0];
              });

              var gift_varient = data1.gift_varient.split("_");
              var var_id = gift_varient[0];
              var postData = {};
              postData["updates"] = {};
              if (x) {
                postData["updates"][var_id] = 1;
              } else {
                postData["updates"][var_id] = 0;
              }
              $.ajax({
                type: "POST",
                url: "https://" + currentURL + "/cart/update.js",
                dataType: "json",
                data: postData,
                success: function(data) {
                  $("form.cart").load(" form.cart");
                  setTimeout(function() {
                    $(".cart__qty-input").each(function() {
                      // console.log('-----------------');
                      // console.log(this);
                      var gift_varaint_id = $(this).attr("id");
                      var cc = gift_varaint_id;
                      var gift_varaint_id = cc.split("_")[1].split(":")[0];

                      if ($.isNumeric(gift_varaint_id)) {
                      } else {
                        var gift_varaint_id = cc.split("_")[2].split(":")[0];
                      }
                      // console.log(gift_varaint_id);
                      if (gift_varaint_id == var_id) {
                        $(this)
                          .parent(".cart__qty")
                          .append('<a href="#">View all Gifts</a>');
                        $(this).attr("disabled", "disable");
                        $(this).hide();
                      }
                    });
                  }, 2000);
                }
              });
            });
          }
        });
      }
    });

    i++;
    // console.log(i);
    if (i == 2) {
      clearInterval(interval);
    }
  }, 3000);
});
