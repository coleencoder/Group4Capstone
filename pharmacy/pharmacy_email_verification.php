<?php
    include 'startsession.php';
    require 'db_pharmacy_connect.php';
    
    if(isset($_GET['token'])){
        $verification_token = $_GET['token'];
        $verify_query = "SELECT verification_token FROM pharmacy_table WHERE verification_token='$verification_token' LIMIT 1";
        $verify_query_run = mysqli_query($conn, $verify_query);

        if(mysqli_num_rows($verify_query_run) > 0){
            $row = mysqli_fetch_array($verify_query_run);
            if($row['verification_level'] == 0){
                $clicked_token = $_GET['token'];
                $update_query = "UPDATE pharmacy_table SET verification_level=1 WHERE verification_token='$clicked_token' LIMIT 1";
                $update_query_run = mysqli_query($conn, $update_query);
                if($update_query_run){
                    echo '<script>alert("Account has been verified successfully!")</script>';
                    exit();
                }else{
                    echo '<script>alert("Verification failed.")</script>';
                    exit();
                }
            }else{
                echo '<script>alert("This account has already been verified. Please log in.")</script>';
                exit();
            }
        }else{
            echo '<script>alert("This token does not exists. Please sign up again.")</script>';
            exit();
        }
    }else{
        echo '<script>alert("Cant get verified.")</script>';
        exit();
    }
?>
