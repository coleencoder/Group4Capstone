<?php 
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include 'startsession.php';
  include 'db_order_connect.php';
  include 'redirect_index_if_not_loggedin.php';
  
  //TOTAL COMPUTE
  $total;
  if(isset($_POST['total'])){
    $total = $_POST['total'];
  }
  //GET CUSTOMER ID 
  $cus_id;
  if(isset($_SESSION['session_account'])){
    $cus_id = $_SESSION['session_account'];
  }
  //PHARMACY QUERY TO CREATE MULTIPLE TABLE IF THERE ARE MULTIPLE QUERY
  $phar_table_query = "SELECT DISTINCT phar_id, prod_phar_name FROM cart_table WHERE  customer_id  = '$cus_id'";
  $table = array();
  $table_query = mysqli_query($conn, $phar_table_query );
  while( $tables = mysqli_fetch_assoc($table_query)){
    $table[$tables['phar_id']] = $tables['prod_phar_name'];
  }
  
  // //FIND IF ANY OF ITEM NEEDS PRESCRIPTION
  $sql = "SELECT * FROM cart_table WHERE `is-prescripted` = '1' ";
  $result = mysqli_query($conn, $sql);
  //GET CHECKED ROW DATA
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $checkedRows;
    if(isset($_POST['checkbox'])){
      $checkedRows = $_POST['checkbox'];
    }
    //echo $checkedRows[0];
    //foreach ($checkedRows as $checkedRow) {
    //    $rowData = $_POST['row'.$checkedRow];
    //    echo $rowData;  
    //    // Do something with the row data
    //}
  }

  // Checking if 
  $cart_inc=0;
  $cart_now = "SELECT * FROM cart_table WHERE  customer_id  = '$cus_id' and is_paid=0";
  $result_now=$conn->query($cart_now);
  while ($row_now=$result_now->fetch_assoc()){
    $cart_inc++;
  }
  ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Cart</title>
        <link rel="stylesheet" href="../css/style_CartCheckout2.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
          $(document).ready(function() {
              // Handle click event of delete button
              $('.remove').click(function(){
                var el = this;
                
                // Delete id
                var deleteid = $(this).data('item');
              
                var confirmalert = confirm("Are you sure?");
                if (confirmalert == true) {
                    // AJAX Request
                    $.ajax({
                      url: 'Cart_delete.php',
                      type: 'POST',
                      data: { id : deleteid },
                      success: function(response){
                        if(response == 1){
                    // Remove row from HTML Table
                      alert(deleteid);
                      $(el).closest("tr").remove();
                        }else{ alert("Item delete from cart failed");}
                      }
                    });
                }
              });

          $('.up-down-numbers .control-number').click(function() {
            var $input = $(this).siblings('.number-field');
            var currentValue = parseInt($input.val());
            var itemId = $(this).closest('tr').data('id');
            var price = parseFloat($(this).closest('tr').find('.product-price').text().replace(/[^0-9\.]+/g,""));
            if ($(this).hasClass('up')) {
              currentValue += 1;
            } else {
              currentValue -= 1;
            }
            if (currentValue <= 0) {
              currentValue = 1;
            }
            $input.val(currentValue);
            var subtotal = (currentValue * price).toFixed(2);
            $(this).closest('tr').find('.product-sub').val(subtotal);
            updateTotal();
            $.ajax({
              type: 'POST',
              url: 'Cart_Checkout2.php',
              data: { item_id: itemId, quantity: currentValue },
              success: function() {},
              error: function() {}
            });
          });
          //TOTAL COMPUTe
          $('input.check-it-out').on('change', function() {
            updateTotal();
          });
          $('input.product-sub').on('change', function() {
            updateTotal();
          });
          function updateTotal() {
            var total = 0;
            $('input.check-it-out:checked').each(function() {
              total += parseFloat($(this).closest('tr').find('.product-sub').val());
            });
            $.ajax({
              type: 'POST',
              url: 'update-total.php',
              data: {total: total.toFixed(2)},
              success: handleResponse,
              error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
              }
            });
          }

          function handleResponse(response) {
            $('#price').val(response);
          }
        });
        </script>
      </head>

    <body>
    <?php include 'navbar.php'?>
        <!-- For Verification -->
        <?php  
          if (isset($_SESSION['payment_success'])){
            if ($_SESSION['payment_success']==1){
              echo"
                <h3 align='center' style='background-color: orange'>
                  Your Order has been placed!
                </h3>
              ";
            }elseif ($_SESSION['payment_success']==2){
              echo"
                <h3 align='center' style='background-color: orange'>
                  Your Order has been placed and payment has been successful!
                </h3>
              ";
            }elseif ($_SESSION['payment_success']==3){
              echo"
                <h3 align='center' style='background-color: orange'>
                  Card Payment Failed! Please check your card details and try again!
                </h3>
              ";
            }
            unset($_SESSION['payment_success']);
          }
        ?>

        <h2 id="headerpage">Your Cart</h2>
            <hr>
        <form action="Payment.php" method="POST">
           <?php 
            if ($cart_inc>=1){
             foreach($table  as $tableid => $tablename ){
              // Retrieve the rows for this table
              echo '<div id="cart-table">';
              echo '  <h3 id="pharmacy-name">'.$tablename.'</h3>';
              echo '  <table class="table-of-products" id = "'.$tableid.'">';
              echo '      <thead>';
              echo '        <tr>';
              echo '          <th class="product-check"></th>';
              echo '          <th class="product-thumbnail">Image</th>';
              echo '          <th class="product-name">Product</th>';
              echo '          <th class="product-price">Price</th>';
              echo '          <th class="product-quantity">Quantity</th>';
              echo '          <th>Subtotal</th>';
              echo '          <th class="product-remove">Action</th>';
              echo '        </tr>';
              echo '      </thead>';
              echo '      <tbody>';
              // Query rows for corresponding table
              $sql2 = "SELECT * FROM cart_table WHERE customer_id  = '$cus_id' AND phar_id  = '$tableid' AND is_paid=0";
              $result2 = $conn->query($sql2);
              
              // Create rows for table
              while ($row2 = $result2->fetch_assoc()) {
                $key = $row2['cus_prod_id'];
                $rowprice= $row2['cart_price'];
                $rowquantity = $row2['cart_quantity'];
                $rowsubtotal = $row2['cart_item_subtotal'];
                $quantity[$key] = $rowquantity;
                $price[$key] = $rowprice;
                $subtotal[$key] = $rowsubtotal; 
                echo '
                <tr id ='.$key.'>
                <td class="checkbox"><input type="checkbox" class="check-it-out" name= "checkbox[]" value = "'.$key.'"></td>
                  <td class="product-thumbnail">
                    <img src="data:image/jpeg;base64,'.base64_encode( $row2['prod_image'] ).'" alt="Image" class="product-pic">
                  </td>
                  <td class="product-name">'.$row2['prod_name'].'</td>  
                  <input type="hidden" name="rowname'.$key.'" value="'.$row2['prod_name'].'">
                  <td class="product-price">P'.$price[$key].'</td>
                  <input type="hidden" name="rowprice'.$key.'" value="'.$price[$key].'">
                  <td class="product-quan">
                    <div class="up-down-numbers">
                        <button class="control-number down" type="button">&minus;</button>
                        <input type="text" inputmode="numeric" value="'.$quantity[$key].'" name ="rowquan'.$quantity[$key].'"class="number-field">
                        <button class="control-number up" type="button">&plus;</button>
                      </div>
                  </td>
                  <td><input type="text" inputmode="numeric" value="'.$subtotal[$key].'" name="rowsubtotal'.$subtotal[$key].'" class="product-sub"></td>
                  <td class="product-remove"><button type="button" data-item = "'.$key.'" class="remove">Delete</button></td>
                </tr>
                ';           
              }
              echo '      </tbody>';
              echo '      </table>';
              echo '  </div>';
             }
           ?>
           <?php 
             if (mysqli_num_rows($result) > 0) {
              echo '<div id="label-input-holder">
                        <label for="product-prescription" id="for-presc">Upload your prescription here: </label>
                        <div id="prescription-function">
                            <input type="file" id="product-prescription" accept=".doc, .pdf, image/jpg, image/jpeg, image/png">
                        </div>
                    </div>';
            }
          }else{
            echo "<h1 align='center'>YOUR CART IS EMPTY!</h1>";
          }
           ?>

            <div id="product-total">
                <div id="total-portion">
                    <label for="price" id="total">Total: </label>
                    <input type="text" id="price" name="price" value = "">
                </div>
                <div id="product-checkout">
                    <button type="submit" id="submit-checkout">Checkout</button>
                </div>
            </div>
        </form>
    </body>
</html>

