<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'startsession.php';
    // Redirects to homepage if there's no active account
    include 'redirect_index_if_not_loggedin.php'; 
    require 'dbconnect.php';
    $session_account = $_SESSION['session_account'];
    $account_query= mysqli_query($conn,"select * from customer_table where customer_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
    $black_circle = '●'; // Unicode character for a black circle
    $masked_string = '';
    if(isset($_SESSION['password'])){
        for ($i = 0; $i < strlen($_SESSION['password']); $i++) {
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
        <title>My Account | User</title>
        <link rel="stylesheet" href="../css/styles_myaccountdef.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
    <?php include 'navbar.php'?>
        <h2 id="headerpage">My Account</h2>
        <div id="main-box">
        <?php include 'user_navbox.php'?>

            <div class="body-box">
                <h3 class="body-title">My Account</h3>
                <p class="body-detail">Personal Information</p>
                <hr>
                <div class="personal-forms">
                    <h4 class="profile-trait">Username</h4>
                    <?php echo'<p class="profile-value">'.$account["username"].'</p>';?>

                    <h4 class="profile-trait">Given Name</h4>
                    <?php echo'<p class="profile-value">'.$account["first_name"].' '.$account["last_name"].'</p>';?>

                    <h4 class="profile-trait">Email address</h4>
                    <?php echo'<p class="profile-value">'.$account["email"].'</p>';?>

                    <h4 class="profile-trait">Phone Number</h4>
                    <?php echo'<p class="profile-value">'.$account["phone_number"].'</p>';?>


                    <h4 class="profile-trait">Gender</h4>
                    <?php echo'<p class="profile-value">'.$account["gender"].'</p>';?>      

                    <h4 class="profile-trait">Birth date</h4>
                    <?php echo'<p class="profile-value">'.$account["birth_date"].'</p>';?>

                    <div id="button-container">
                        <a href="user_myaccount.php" id="edit" target="_self">Edit Profile</a>
                    </div>
                </div>
                <p class="body-detail">Security</p>
                <hr>
                <div class="personal-forms">
                    <h4 class="profile-trait">Password</h4>
                    <p class="profile-value"><?php echo $masked_string?></p>
                    <div id="button-container">
                        <a href="user_changepass.php" id="edit" target="_self">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
