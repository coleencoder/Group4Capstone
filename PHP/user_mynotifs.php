<?php 
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
      include('startsession.php');
include 'redirect_index_if_not_loggedin.php';?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications | User</title>
        <link rel="stylesheet" href="../css/styles_mynotifs.css">
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
                <h3 class="body-title">Notifications</h3>
                <hr>
                <div id="notifs">
                    <div class="notif-row">
                        <i class="fa fa-user-md icono"  style="font-size:1.5em;"></i>
                        <h5 class="notif-type">Your order has been accepted!</h5>
                        <p class="notif-desc">Your order has been accepted by the pharmacy! It will
                            be processed shortly.</p>
                    </div>

                    <div class="notif-row">
                        <i class="fa fa-truck icono"  style="font-size:1.4em;"></i>
                        <h5 class="notif-type">Your order has been shipped!</h5>
                        <p class="notif-desc">Your order has been shipped by the pharmacy through
                            [insert name of courier]! You will receive a notification once it
                            arrives at your destination.</p>
                    </div>

                    <div class="notif-row">
                        <i class="fa fa-home icono"  style="font-size:1.5em;"></i>
                        <h5 class="notif-type">Your order has arrived!</h5>
                        <p class="notif-desc">Your order has arrived at your destination.</p>
                    </div>

                    <div class="notif-row">
                        <i class="fa fa-check-circle icono"  style="font-size:1.5em;"></i>
                        <h5 class="notif-type">Your order has been delivered!</h5>
                        <p class="notif-desc">Delivery of the order is successful.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>