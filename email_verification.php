<?php
    include 'startsession.php';
    require 'dbconnect.php';

    if(isset($_GET['token'])){
        $verification_token = $_GET['token'];
        $verify_query = "SELECT verification_token FROM user_account WHERE verification_token='$token' LIMIT 1";
        $verify_query_run = mysqli_query($conn, $verify_query);

        if(mysqli_num_rows($verify_query_run) > 0){
            $row = mysqli_fetch_array($verify_query_run);
            if($row['verification_level'] == 0){
                $clicked_token = $_GET['token'];
                $update_query = "UPDATE user_account SET verification_level=1 WHERE verification_token='$clicked_token' LIMIT 1";
                $update_query_run = mysqli_query($conn, $update_query);
                if($update_query_run){
                    echo "Account has been verified successfully!";
                    exit();
                }else{
                    echo "Verification failed.";
                    exit();
                }
            }else{
                echo "This account has already been verified. Please log in.";
                exit();
            }
        }else{
            echo "This token does not exists. Please sign up again.";
            exit();
        }
    }else{
        echo "Cant get verified.";
        exit();
    }
?>