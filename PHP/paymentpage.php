<?php 
include 'startsession.php';
include 'redirect_index_if_not_loggedin.php';
?>
<!DOCTYPE HTML>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment</title>
        <link rel="stylesheet" href="../css/styles_payment.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <h2 id="headerpage">Payment</h2>
        <div id="heading-div">
            <h4 class="portion-title">Shipping Address</h4>
            <div id="address-container">
                <h4 class="address-main-value">Aramie Moroguso</h4>
                <p class="address-sub-value">09099909090</p>
                <p class="address-sub-value">51 Bacolod Street</p>
                <p class="address-sub-value">Baranggay San Roque, Marikina City, Metro Manila, 1801</p>
            </div>
        </div>

        <div id="product-div">
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
                </table>
                <hr>
                <table class="subtotal">
                    <tr class="sub">
                        <td class="mod-mop">Subtotal</td>
                        <td class="option">PhP 420</td>
                    </tr>
                    <tr class="ship">
                        <td class="mod-mop">Shipping</td>
                        <td class="option">PhP 65</td>
                    </tr>
                    <tr class="ship">
                        <td class="mod-mop">Total</td>
                        <td class="total">PhP 485</td>
                    </tr>
                </table>
                <hr>
                <table class="mop-mod-summary">
                    <tr class="mop">
                        <td class="mod-mop">Mode of Payment</td>
                        <td class="option">GCash</td>
                    </tr>
                    <tr class="mod">
                        <td class="mod-mop">Mode of Delivery</td>
                        <td class="option">Lalamove</td>
                    </tr>
                </table>
                <div id="reminder">
                    <p>Note: Clicking Pay Now will redirect you to Paymongo to complete your purchase securely.</p>
                </div>
                <div id="pay-button">
                    <a href="#" id="proceed-payment">Pay Now</a>
                </div>
            </div>
        </div>
    </body>

</html>