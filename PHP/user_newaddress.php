<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'startsession.php';
    // Redirects to homepage if there's no active account
    include 'redirect_index_if_not_loggedin.php';
    $session_account = $_SESSION['session_account'];
    include 'dbconnect.php';
    $account_query= mysqli_query($conn,"select * from customer_table where customer_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query); 
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['hold-value'];
        $phoneNumber = $_POST['phoneNumber'];
        $houseStreet = $_POST['houseStreet'];
        $baranggay = $_POST['baranggay'];
        $townCity = $_POST['townCity'];
        $reg = $_POST['reg'];
        $zip = $_POST['zip'];
        $is_default = 0;
        // count rows from address table  
        $query = "SELECT COUNT(*) as total_rows FROM `customer_address`";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $total_rows = $row['total_rows'];

        if($total_rows == 0){
            $is_default = 1;
        }
        $insert_address = "INSERT INTO `customer_address` ( `customer_pk`, 
        `name`,`number`,`h_no_st_name`,`brgy`,`city`,`region`,`zip_code`,`is_default`) 
        VALUES ('$session_account','$name', 
        '$phoneNumber', '$houseStreet','$baranggay','$townCity','$reg','$zip','$is_default')";
        //insert address data 
        if ($conn->query($insert_address) === TRUE) {
            echo '<script>alert("Record updated successfully")</script>';
        } else {
            echo "Error updating record: " . $conn->error();
        }
    }

    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Address Book | User</title>
        <link rel="stylesheet" href="../css/styles_newaddress.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <?php include 'navbar.php'?>
        <h2 id="headerpage">My Account</h2>
        <div id="main-box">
            <?php include 'user_navbox.php'?>
            <div class="body-box">
                <h3 class="body-title">New Address</h3>
                <p class="body-detail">Shipping Address</p>
                <hr>
                <form action="user_newaddress.php" method="POST">
                    <label for="hold-value">Given Name</label>
                    <?php echo '<input type="text" name="hold-value" onfocus=".this.value='.'" value="'.$account["first_name"].' '. $account["last_name"].'">';?>

                    <label for="phoneNumber">Phone Number</label>
                    <?php echo '<input type="tel" name="phoneNumber" pattern="^(09|\+639)\d{9}$" onfocus="this.value='.'" value='.$account["phone_number"].'>';?>

                    <label for="houseStreet">House Number, Street Name</label>
                    <input type="text" name="houseStreet" onfocus="this.value=''" value="">

                    <label for="baranggay">Baranggay</label>
                    <input type="text" name="baranggay" onfocus="this.value=''" value="">

                    <label for="townCity">Town/City</label>
                    <input type="text" name="townCity" onfocus="this.value=''" value="">

                    <label for="reg">Region</label>
                    <input type="text" name="reg" onfocus="this.value=''" value="">

                    <label for="reg">ZIP Code</label>
                    <input type="text" name="zip" onfocus="this.value=''" value="">

                    <button type="submit" id="save">Save</button>
                </form>
            </div>
        </div>
    </body>
</html>
