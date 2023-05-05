<?php
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    include 'pharmacy_error.php';
    // Connect to the database
    include 'db_pharmacy_connect.php';
    $session_account = $_SESSION['phar_account'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $newPassword = $_POST['fullName'];
        $renewPassword = $_POST['email'];

        // Check for errors
        if ($conn->connect_error()) {
            die("Connection failed: " . $conn->connect_error());
        }
        $checknewpass = strlen($newPassword);
        // Check if passwords match
        if($newPassword == $renewPassword){
            // Check if new passwords string length is equal or more than 8 characters
            if($checknewpass >= 8){
                $new_password_hash = password_hash($newPassword,PASSWORD_DEFAULT); 
                $update_password_hash = "UPDATE pharmacy_table 
                                        SET `password` = '$new_password_hash'
                                        WHERE pharmacy_pk = '$session_account'";
                if ($conn->query($update_password_hash) === TRUE) {
                    $_SESSION['pharmacy_password'] = $newPassword;
                    echo '<script>alert("Record updated successfully")</script>';
                }
            }else{
                echo '<script>alert("Passwords must be 8 characters or more.")</script>';
            }
        }else{
            echo '<script>alert("Passwords must match.")</script>';
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | Pharmacy</title>
        <link rel="stylesheet" href="css/stylespharmacychangepass.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div id="main-box">
        <?php include 'selleroptions.php'?>
            <div id="seller-profile">
                <div class="greet">
                    <h2>Account Settings</h2>
                </div>
                <div class="motivation">
                    <div class="item">
                        <h3>Change Password</h3>
                        <div class="hr"></div>
                        <div class="personal-forms">
                            <form action="pharmacy_change_password.php" method="POST">
                                <label for="firstName">New Password</label>
                                <input type="password" name="fullName" onfocus="this.value=''" value="">
            
                                <label for="email">Re-enter New Password</label>
                                <input type="password" name="email" onfocus="this.value=''" value="">
            
                                <button type="submit" id="save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>