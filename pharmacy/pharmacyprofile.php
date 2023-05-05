<?php
    include 'startsession.php';
    require 'db_pharmacy_connect.php';
    $session_account = $_SESSION['phar_account'];
    $account_query= mysqli_query($conn,"select * from pharmacy_table where pharmacy_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | Pharmacy</title>
        <link rel="stylesheet" href="css/stylespharmacyprof.css">
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
                    <h2>Welcome back!</h2>
                    <p>See your growth in a glance...</p>
                </div>
                <div id="profile-intro">
                    <div id="intro-icon">
                        <img src="images\pharmacist.png">
                    </div>
                    <div id="intro-details">
                        <?php echo '<h4 id="pharmacy-name">'.$account["name"].'</h4>';
                              echo '<p id="pharmacy-address">'.$account["address"].'</p>';
                        ?>
                        <i class="fa fa-star"></i><p id="no-of-rating">4.9 (20)</p>

                        <div id="intro-see">
                            <a href="#" id="view-profile">View Profile</a>
                        </div>
                    </div> 
                </div>
                <h2 class="interlude">Recently Posted</h2>

                <div id="recents">
                    <div class="item">
                        <img src="images\biogesick.jpg" alt="Biogesic">
                        <div class="med-desc">
                            <p class="med-name">Biogesic 2x2 Strip Paracetamol 500mg</p>
                            <h4 class="med-price">16 PhP</h4>
                            <p class="med-name">In Stock</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images\neozep10.jpg" alt="Biogesic">
                        <div class="med-desc">
                            <p class="med-name">Neozep Non-drowsy 10mg/500mg 10 Tablets</p>
                            <h4 class="med-price">55 PhP</h4>
                            <p class="med-name">In Stock</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images\solmux.jpg" alt="Biogesic">
                        <div class="med-desc">
                            <p class="med-name">Solmux Carbocisteine 500mg 5 Capsules</p>
                            <h4 class="med-price">60 PhP</h4>
                            <p class="med-name">In Stock</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images\propan.jpg" alt="Biogesic">
                        <div class="med-desc">
                            <p class="med-name">Propan with Iron 10 Capsules</p>
                            <h4 class="med-price">280 PhP</h4>
                            <p class="med-name">In Stock</p>
                        </div>
                    </div>
                </div>

                <div class="show-all">
                    <a href="pharmacy_manage_items.php" id="show-button">Show All Items</a>
                </div>
            </div>
            <!--<div id="seller-performance"></div>-->
        </div>
    </body>
</html>