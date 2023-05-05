<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
        // Redirects to homepage if there's no active account
        if (!isset($_SESSION['session_account'])) {
            header('Location: ../index.php');
            exit;
        }
    $session_account = $_SESSION['session_account'];
    require 'dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['edit_default'])){
            $address_pk =  $_POST['edit_default'];
            $_SESSION['address_pk'] =  $address_pk;
            header('Location: user_myaddress.php');
        }else if (isset($_POST['edit'])) {
            $address_pk =  $_POST['edit'];
            $_SESSION['address_pk'] = $address_pk;
            header('Location: user_myaddress.php');
        } else if (isset($_POST['set_default'])) {
            $address_pk =  $_POST['set_default'];
            $set_default = "UPDATE `customer_address` 
            SET `is_default` = '1' WHERE address_pk = '$address_pk'";
            $undo_default = "UPDATE `customer_address` 
            SET `is_default` = '0' WHERE `is_default` = '1'";
            $conn->query($undo_default);
            if ($conn->query($set_default) === TRUE) {
                echo '<script>alert("Record updated successfully")</script>';
            } else {
                echo "Error updating record: " . $conn->error();
            }
        }
    }
    $default_address= mysqli_query($conn,"SELECT * from `customer_address` where customer_pk='$session_account'AND is_default = '1'");
    $secondary_address = mysqli_query($conn,"SELECT * from `customer_address` where customer_pk='$session_account'AND is_default = '0'");

    //close database connection
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Address Book | User</title>
        <link rel="stylesheet" href="../css/styles_myaddressdef.css">
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
                <h3 class="body-title">My Address Book</h3>
                <?php
                    //Default Address
                    echo '<p class="body-detail">Default Address</p>';
                    echo '<hr>';
                    while ($address = mysqli_fetch_assoc($default_address)){
                            $name = $address["name"];
                            $number = $address["number"];
                            $h_no_st_name = $address["h_no_st_name"];
                            $brgy = $address["brgy"];
                            $city = $address["city"];
                            $region = $address["region"];
                            $zip = $address["zip_code"];
                            echo'
                    <div class="personal-forms">
                        <form action = "user_myaddressdef.php" method = "POST">
                            <div id="address-box">
                                <h4 class="address-main-value">'.$name.'</h4>
                                <p class="address-sub-value">'.$number.'</p>
                                <p class="address-sub-value">'.$h_no_st_name.'</p>
                                <p class="address-sub-value">'.$brgy.', '.$city.', '.$region.', '.$zip.'</p>
                            </div>
                            <div id="button-container">
                            <button type="submit" id="edit" name="edit_default" target="_self" value = "'.$address['address_pk'].'">Edit address</button>                    
                            </div>
                        </form>
                    </div>
                    ';
                    }
                    //Secondary Addresses
                    echo '<p class="body-detail">Secondary Addresses</p>';
                    echo '<hr>';
                    while ($address2 = mysqli_fetch_assoc($secondary_address)){
                        $name2= $address2["name"];
                        $number2 = $address2["number"];
                        $h_no_st_name2 = $address2["h_no_st_name"];
                        $brgy2 = $address2["brgy"];
                        $city2 = $address2["city"];
                        $region2 = $address2["region"];
                        $zip2 = $address2["zip_code"];
                        echo '
                <div class="personal-forms">
                    <form action = "user_myaddressdef.php" method = "POST">
                        <div id="address-box">
                            <h4 class="address-main-value">'.$name2.'</h4>
                            <p class="address-sub-value">'.$number2.'</p>
                            <p class="address-sub-value">'.$h_no_st_name2.'</p>
                            <p class="address-sub-value">'.$brgy2.', '.$city2.', '.$region2.', '.$zip2.'</p>
                        </div>
                        <div id="button-container">
                        <button type="submit" id="edit"name="edit" target="_self" value = "'.$address2['address_pk'].'">Edit address</button>
                        <button type="submit" id="add" name="set_default" target="_self" value = "'.$address2['address_pk'].'">Set as default address</button>
                        </div>
                    </form>
                </div>
                ';
                }
                ?>
                <div id="button-container">
                    <a href="user_newaddress.php" id="edit" target="_self">Add address</a>                    
                </div>
            </div>
        </div>
    </body>
</html>