<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include 'dbconnect.php';
    $token;
    $token_from_db;
    if(isset($_GET['token'])){
        $token = $_GET['token'];
    }

    $verify_query = "SELECT verification_token FROM customer_table WHERE verification_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);
    if($verify_query_run){
        $verif_token = mysqli_fetch_assoc($verify_query_run);
        $token_from_db = $verif_token['verification_token'];
    }else{
        echo '<script>alert("Query to get matching token failed.")</script>';
        exit();
    }

    if($token != $token_from_db){
        echo '<script>alert("Tokens doesnt match.")</script>';
    }
    $change_verif_level_query = "UPDATE customer_table
                                SET verification_level = '1'
                                WHERE verification_token = '$token'";
    $change_verif_level = mysqli_query($conn, $change_verif_level_query);

    if($change_verif_level){
        echo '<script>alert("Account Verified!")</script>';
    }

?>
