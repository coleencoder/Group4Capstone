<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    // Redirects to homepage if there's no active account
    include 'redirect_index_if_not_loggedin.php'; 
    $session_address = $_SESSION['address_pk'];
    include 'dbconnect.php';
    $address_row_query= mysqli_query($conn,"select * from `customer_address` where address_pk='$session_address' LIMIT 1");
    $address_row = mysqli_fetch_array($address_row_query); 

    //Runs code if save button is clicked
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name        =   $_POST["hold-value"];
        $phoneNumber =   $_POST["phoneNumber"];
        $houseStreet =   $_POST["houseStreet"];
        $baranggay   =   $_POST["baranggay"];
        $townCity    =   $_POST["townCity"];
        $reg         =   $_POST["reg"];
        $zip         =   $_POST["zip"];
        //Update Address
        $update_address = "UPDATE `customer_address`
                            SET `name` = '$name',`number` = '$phoneNumber', 
                            `h_no_st_name` = '$houseStreet', `brgy` = '$baranggay', 
                            `city` = '$townCity', `region` = '$reg', 
                            `zip_code` = '$zip'
                            WHERE `address_pk` = '$session_address'";
        if ($conn->query($update_address) === TRUE) {
            echo '<script>alert("Record updated successfully")</script>';
        } else {
            echo "Error updating record: " . $conn->error();
        }
        unset($_SESSION['address_pk']);
        header('Location: user_myaddressdef.php');
    }
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Address Book | User</title>
        <link rel="stylesheet" href="../css/styles_myaddress.css">
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
                <h3 class="body-title">Edit Address</h3>
                <p class="body-detail">Shipping Address</p>
                <hr>
                <form action="user_myaddress.php" method="POST">
                    <label for="hold-value">Given Name</label>
                    <?php echo '<input type="text" name="hold-value" onfocus=".this.value='.'" value="'.$address_row["name"].'">';?>

                    <label for="phoneNumber">Phone Number</label>
                    <?php echo '<input type="tel" name="phoneNumber" pattern="^(09|\+639)\d{9}$" onfocus="this.value='.'" value='.$address_row["number"].'>';?>

                    <label for="houseStreet">House Number, Street Name</label>
                    <?php echo '<input type="text" name="houseStreet" onfocus="this.value='.'" value='.$address_row["h_no_st_name"].'>';?>

                    <label for="baranggay">Baranggay</label>
                    <?php echo '<input type="text" name="baranggay" onfocus="this.value='.'" value='.$address_row["brgy"].'>';?>

                    <label for="townCity">Town/City</label>
                    <?php echo '<input type="text" name="townCity" onfocus="this.value='.'" value='.$address_row["city"].'>';?>
                    <label for="reg">Region</label>
                    <?php echo '<input type="text" name="reg" onfocus="this.value='.'" value='.$address_row["region"].'>';?>

                    <label for="reg">ZIP Code</label>
                    <?php echo '<input type="text" name="zip" onfocus="this.value='.'" value='.$address_row["zip_code"].'>';?>
                    
                    <button type="submit" id="save">Save</button>
                </form>
            </div>
        </div>
    </body>
</html>
