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
  }
  ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment</title>
        <link rel="stylesheet" href="../css/style_CartCheckout2.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <body>

    <!-- Identify if Checkout was clicked -->
    <?php 
      if (isset($_POST['submit-checkout'])){
        if ($_POST['payment_method']=='cod'){
          // Considering as Paid
          $sql="UPDATE cart_table SET is_paid=1 WHERE customer_id  = '$cus_id'";
          $result=$conn->query($sql); 

          // Proceed to Check Out Again
          $_SESSION['payment_success']=1;
          echo "<script>window.location.href='Cart_Checkout2.php'</script>";
          exit();
        }else{
          // Checking Card
          $card_number=$_POST['card_number'];
          $name=$_POST['name'];
          $exp_date=$_POST['exp_date'];
          $cvv=$_POST['cvv'];
          $qry_card="SELECT * FROM card_payment WHERE card_number='$card_number' AND Names='$name' AND expdate='$exp_date' AND cvv='$cvv'";
          $result = $conn->query($qry_card);

          while ($row = $result->fetch_assoc()) {
            // Considering as Paid
            $sql="UPDATE cart_table SET is_paid=1 WHERE customer_id  = '$cus_id'";
            $result=$conn->query($sql); 

            // Proceed to Check Out Again
            $_SESSION['payment_success']=2;
            echo "<script>window.location.href='Cart_Checkout2.php'</script>";
            exit();
          }
          
          $_SESSION['payment_success']=3;
          echo "<script>window.location.href='Cart_Checkout2.php'</script>";
          exit();
        }
      }
    ?>

    <?php include 'navbar.php'?>
        <h2 id="headerpage">Select Payment Method</h2>
          <hr>
          <form action="Payment.php" method="POST">
          <div id="cart-table">
            <table class="table-of-products" id = "'.$tableid.'">';
              <thead>
                <th>
                  <input type="radio" id="COD" name="payment_method" value="cod">
                 <label for="COD">Cash on Delivery</label>
                </th>
                <!-- <th>
                  <input type="radio" id="GCASH" name="payment_method" value="gcash">
                  <label for="GCASH">GCASH</label>
                </th> -->
                <th>
                  <input type="radio" id="card" name="payment_method" value="card">
                  <label for="card">Debit/Credit Card <i class="fa fa-check" aria-hidden="true"></i></label>
                </th>
              </thead>
              <tbody> 
                  <tr>
                    <td> 
                        Customer will pay after the delivery of orders.
                    </td>
                    <td>
                      <form> 
                          <label for="card_number">Card Number: </label>
                          <input type="number" name="card_number" maxlength="16" class="form-control">
                          <label for="name">Name of Account Number: </label>
                          <input type="text" name="name" class="form-control">
                          <div class="row">
                            <div class="col-sm-6">
                              <label for="Exp_date">Exp. Date (mm/yy): </label>
                              <input type="number" name="exp_date" maxlength="4" class="form-control">
                            </div>
                            <div class="col-sm-6">
                              <label for="CVV">CVV: </label>
                              <input type="number" name="cvv" maxlength="4" class="form-control">
                            </div>
                          </div>
                      </form>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
          <div id="product-total">
            <div id="total-portion">
              <label for="price" id="total">Total: </label>
              <input type="text" id="price" name="price" value = "<?php echo $_POST['price']; ?>" checked="true">
            </div>
            <div id="product-checkout">
              <button type="submit" id="submit-checkout" Name="submit-checkout">Checkout</button>
            </div>
          </div>
        </form>
    </body>
</html>

