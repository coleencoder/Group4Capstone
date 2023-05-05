<?php 
    include 'startsession.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Checkout</title>
        <link rel="stylesheet" href="../css/styles_checkoutpage.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <h2 id="headerpage">Checkout</h2>
        <div id="product-div">
            <h4 class="portion-title">Cart</h4>
            <div id="cart-review">
                <h4 class="cart-category">Pharmacy Name</h5>
                <table class="product-box">
                    <tr class="table-head">
                        <th id="head-product">Product</th>
                        <th id="head-quantity">Quantity</th>
                        <th id="head-subtotal">Subtotal</th>
                    </tr>
                    <tr class="item-portion">
                        <td class="product-data">Product Name</td>
                        <td class="quantity-data">1</td>
                        <td class="price-data">PhP 110</td>
                    </tr>
                    <tr class="item-portion">
                        <td class="product-data">Product Name</td>
                        <td class="quantity-data">3</td>
                        <td class="price-data">PhP 150</td>
                    </tr>
                    <tr class="item-portion">
                        <td class="product-data">Product Name</td>
                        <td class="quantity-data">5</td>
                        <td class="price-data">PhP 160</td>
                    </tr>
                    <tr class="item-portion">
                        <td id="subtotal" colspan="2">Subtotal</td>
                        <td id="subtotal-value">PhP 420</td>
                    </tr>
                </table>
                <hr>
            </div>
            <div id="mop-mod">
                <h4 class="portion-title">Select Mode of Delivery</h4>
                
                <form action="/action_page.php">
                    <input type="radio" class="choose-mod-mop" name="shipping" value="In House">
                    <label for="shipping" class="label-mod-mop">In House Delivery</label><br>

                    <input type="radio" class="choose-mod-mop" name="shipping" value="Grab">
                    <label for="shipping" class="label-mod-mop">Grab Express</label><br>

                    <input type="radio" class="choose-mod-mop" name="shipping" value="Lalamove">
                    <label for="shipping" class="label-mod-mop">Lalamove</label><br>

                    <input type="radio" class="choose-mod-mop" name="shipping" value="Store Pickup">
                    <label for="shipping" class="label-mod-mop">Store Pickup</label><br>
                </form>
                <p class="blurb-after-mopmod">Note: Shipping is calculated upon checkout</p>
                <h4 class="portion-title">Select Mode of Payment</h4>
                <form action="/action_page.php">
                    <input type="radio" class="choose-mod-mop" name="payment" value="GCash">
                    <label for="payment" class="label-mod-mop">GCash</label><br>

                    <input type="radio" class="choose-mod-mop" name="payment" value="GrabPay">
                    <label for="payment" class="label-mod-mop">GrabPay</label><br>

                    <input type="radio" class="choose-mod-mop" name="payment" value="Paymaya">
                    <label for="payment" class="label-mod-mop">Paymaya</label><br>
                </form>
                <p class="blurb-after-mopmod">Note: Pay with your desired mode of payment via Paymongo</p>
            </div>
            <div id="checkout-button">
                <a href="#" id="proceed-checkout">Proceed Checkout</a>
            </div>
        </div>
    </body>
</html>