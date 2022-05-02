// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function() {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];
    
    // Constructor
    function Item(name, price, count) {
      this.name = name;
      this.price = price;
      this.count = count;
    }
    
    // Save cart
    function saveCart() {
      sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }
    
      // Load cart
    function loadCart() {
      cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }
    if (sessionStorage.getItem("shoppingCart") != null) {
      loadCart();
    }
    
  
    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};
    
    // Add to cart
    obj.addItemToCart = function(name, price, count) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count ++;
          saveCart();
          return;
        }
      }
      var item = new Item(name, price, count);
      cart.push(item);
      saveCart();
    }
    // Set count from item
    obj.setCountForItem = function(name, count) {
      for(var i in cart) {
        if (cart[i].name === name) {
          cart[i].count = count;
          break;
        }
      }
    };
    // Remove item from cart
    obj.removeItemFromCart = function(name) {
        for(var item in cart) {
          if(cart[item].name === name) {
            cart[item].count --;
            if(cart[item].count === 0) {
              cart.splice(item, 1);
            }
            break;
          }
      }
      saveCart();
    }
  
    // Remove all items from cart
    obj.removeItemFromCartAll = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart.splice(item, 1);
          break;
        }
      }
      saveCart();
    }
  
    // Clear cart
    obj.clearCart = function() {
      cart = [];
      saveCart();
    }
  
    // Count cart 
    obj.totalCount = function() {
      var totalCount = 0;
      for(var item in cart) {
        totalCount += cart[item].count;
      }
      return totalCount;
    }
  
    // Total cart
    obj.totalCart = function() {
      var totalCart = 0;
      for(var item in cart) {
        totalCart += cart[item].price * cart[item].count;
      }
      return Number(totalCart.toFixed(2));
    }
  
    // List cart
    obj.listCart = function() {
      var cartCopy = [];
      for(i in cart) {
        item = cart[i];
        itemCopy = {};
        for(p in item) {
          itemCopy[p] = item[p];
  
        }
        itemCopy.total = Number(item.price * item.count).toFixed(2);
        cartCopy.push(itemCopy)
      }
      return cartCopy;
    }
  
    // cart : Array
    // Item : Object/Class
    // addItemToCart : Function
    // removeItemFromCart : Function
    // removeItemFromCartAll : Function
    // clearCart : Function
    // countCart : Function
    // totalCart : Function
    // listCart : Function
    // saveCart : Function
    // loadCart : Function
    return obj;
  })();
  
  
  // *****************************************
  // Triggers / Events
  // ***************************************** 
  // Add item
  
  // $('.add-to-cart').click(function(event) {
  //   event.preventDefault();
  //   var name = $(this).data('name');
  //   var price = Number($(this).data('price'));
  //   shoppingCart.addItemToCart(name, price, 1);
  //   displayCart();
  // });
  
  // // Clear items
  // $('.clear-cart').click(function() {
  //   shoppingCart.clearCart();
  //   displayCart();
  // });
  
  // function displayCart() {
    // var cartArray = shoppingCart.listCart();
    // var input = 0;
    // var output = "";
    // for(var i in cartArray) {
    //   input++;
    //   output += "<tr>"
    //         + "<td>\""+cartArray[i].name+"\"</td>" 
    //         + "<input type='hidden' class='item-name' name='name' value='"+cartArray[i].name+"'>"
    //         + "<td>(\""+cartArray[i].price+"\")</td>"
    //         + "<input type='hidden' class='item-price' name='price' value='"+cartArray[i].price+"'>"
    //         + "<td><div class='input-group'><button class='minus-item"+input+" btn btn-warning btn-inline shadow' rowId='"+input+"' data-name=\""+cartArray[i].name+"\" onclick='minusA("+input+")'>-</button>"
    //         + "<input type='number' class='item-count"+input+" form-control' min='1' max='9' value='" + cartArray[i].count + "' disabled>"
    //         + "<input type='hidden' name='quantity' value='"+cartArray[i].count+"'>"
    //         + "<button class='plus-item"+input+" plus btn btn-warning btn-inline shadow' data-name=\""+cartArray[i].name+"\" onclick='plusA("+input+")'>+</button></div></td>"
    //         + "<td><button class='delete-item btn btn-danger' rowId='"+input+"' data-name=\""+cartArray[i].name+"\">X</button></td>"
    //         + "<td>" + cartArray[i].total + "</td>" 
    //         + "<input type='hidden' name='subtotal' value='"+ cartArray[i].total +"'>"
    //     +  "</tr>";
    // }
    // $('.show-cart').html(output);
    // $('.total-cart').html(shoppingCart.totalCart());
    
  // }

  // Delete item button
  
  $('.show-cart').on("click", ".delete-item", function(event) {
    var id = $(this).attr('rowId');
    $.ajax({
      url: '/cart/delete',
      type: 'POST',
      data: {
        id: id,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response){
        console.log(response);
        if(response.success){
          Swal.fire({
            title: 'Success!',
            text: 'Item has been deleted.',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.value) {
              location.reload();
            }
          });
      }
    }
    });
 });
  
  // -1
  function minusA(id) {
    var value = document.querySelector('.item-count'+id).value;
    var min = document.querySelector('.item-count'+id).getAttribute('min'); 
    var name = document.querySelector('.plus-item'+id).getAttribute('data-name');
        if(value > min) {
            shoppingCart.removeItemFromCart(name);
            displayCart();
        } else {
            Swal.fire({
                title: 'Oops...',
                text: 'You can\'t have less than 1 item',
                icon: 'error',
                footer: '<a href>Why do I have this issue?</a>'
            });
        }
  }

// +1
function plusA(id) {
    var value = document.querySelector('.item-count'+id).value;
    var max = document.querySelector('.item-count'+id).getAttribute('max');
    var name = document.querySelector('.plus-item'+id).getAttribute('data-name');
    if(value < max) {
        shoppingCart.addItemToCart(name);
        displayCart();
    } else {
        Swal.fire({
            title: 'Oops...',
            text: 'You can\'t have more than 9 items',
            icon: 'error',
            footer: '<a href>Why do I have this issue?</a>'
        });
    }
 }

  
  // Item count input
  // $('.show-cart').on("change", ".item-count", function(event) {
  //    var name = $(this).data('name');
  //    var count = Number($(this).val());
  //   shoppingCart.setCountForItem(name, count);
  //   displayCart();
  // });
  
  // displayCart();
  
$('.add-to-cart').on('click', function() {
  var form = $(this).closest('form');
  var price = $(this).data('price');
  var quantity = $('#quantity').val();
  var subtotal = price * quantity;

  form.append('<input type="hidden" name="subtotal" value="' + subtotal + '">');
});

$("#quantity").on('change', function() {
  var quantity = $(this).val();
  console.log(quantity);
  $('.cart-basket').html(quantity);
});