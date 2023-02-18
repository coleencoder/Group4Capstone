<?php
    include 'startsession.php';
    require 'dbconnect.php';
    $session_account = $_SESSION['session_account'];
    $account_query= mysqli_query($conn,"select * from user_account where primarykey='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | User</title>
        <link rel="stylesheet" href="css/stylesuser.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php include 'navbar.php';?>
        <h2 id="headerpage">My Account</h2>
        <div id="main-box">

            <div class="nav-box">
                <nav id="navbar-user">
                    <div><i class="fa fa-user-circle"></i> <a href="#" class="nav-link">My Account</a></div>
                    <div><i class="fa fa-address-book"></i> <a href="#" class="nav-link">My Address Book</a></div>
                    <div><i class="fa fa-suitcase"></i> <a href="#" class="nav-link">My Orders</a></div>
                    <div><i class="fa fa-bell"></i> <a href="#" class="nav-link">Notifications</a></div>
                    <div><i class="fa fa-gear"></i> <a href="#" class="nav-link">Account Settings</a></div>
                </nav>
            </div>

            <div class="body-box">
                <h3 class="body-title">My Account</h3>
                <p class="body-detail">Personal Information</p>
                <hr>
                <div class="personal-forms">
                    <label for="hold-value">Username</label>  
        <?php if(isset($_SESSION['session_account'])){ echo '<input type="text" name="hold-value"  value='.$account["username"].'>';}?>
                    
                    <div id="float-left">
                        <label for="firstName">Given Name</label>
                          <?php if(isset($_SESSION['session_account'])){ echo '<input type="text" name="fullName"  value='.$account["firstname"].'>';}?>
                    </div>
                    <div id="clear-right">
                        <label for="surName">Surname</label>
                        <?php if(isset($_SESSION['session_account'])){ echo '<input type="text" name="surName"  value='.$account["lastname"].'>';}?>
                    </div>

                    <label for="email">Email address</label>
                      <?php if(isset($_SESSION['session_account'])){ echo '<input type="email" name="email"  value='.$account["email"].'>';}?>

                    <button type="submit" id="save">Save</button>
                </div>

            </div>

        </div>
    </body>
</html>
