<?php
    include 'startsession.php';
    require 'db_pharmacy_connect.php';
    include 'redirect_index_if_not_loggedin.php';
    $session_account = $_SESSION['phar_account'];
    $account_query= mysqli_query($conn,"select * from pharmacy_table where pharmacy_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
    $black_circle = '●'; // Unicode character for a black circle
    $masked_string = '';
    if(isset($_SESSION['pharmacy_password'])){
        for ($i = 0; $i < strlen($_SESSION['pharmacy_password']); $i++) {
            $masked_string .= $black_circle;
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | Pharmacy</title>
        <link rel="stylesheet" href="css/stylespharmacysetting.css">
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
                    <div class="personal-forms" style = "width : 50%;">
                        <h3>Pharmacy Information</h3>
                        <div class="hr"></div>

                        <h4 class="profile-trait">Username</h4>
                        <?php echo '<p class="profile-value">'.$account['username'].'</p>';?>
                        

                        <h4 class="profile-trait">Pharmacy Name</h4>
                        <?php echo '<p class="profile-value">'.$account['name'].'</p>';?>

                        <h4 class="profile-trait">Email address</h4>
                        <?php echo '<p class="profile-value">'.$account['email'].'</p>';?>

                        <h4 class="profile-trait">Address</h4>
                        <?php echo '<p class="profile-value">'.$account['address'].'</p>';?>

                        <div id="button-container">
                            <a href="pharmacy_setting_edit.php" id="edit" target="_self">Edit Profile</a>
                        </div>
                        <div id="button-container" style = "position: absolute; bottom: 16vh;">
                            <a href="logout.php" id="edit" target="_self">Log Out</a>
                        </div>
                    </div>
                    <div class="personal-forms">
                        <h3>Security</h3>
                        <div class="hr"></div>

                        <h4 class="profile-trait">Password</h4>
                        <?php echo'<p class="profile-value">'.$masked_string.'</p>';?>

                        <div id="button-container">
                            <a href="pharmacy_change_password.php" id="edit" target="_self">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>