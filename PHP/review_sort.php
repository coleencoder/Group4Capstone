<?php
    include('dbconnect.php');
    // Query to retrieve rows from the database in descending order by date
    $query = "SELECT * FROM customer_review ORDER BY review_created_at DESC";
    // Execute the query
    $result = mysqli_query($conn, $query);
    if(isset($_POST['star'])){
        $a = $_POST['star'];
        if($a == 6){
            $query = "SELECT * FROM customer_review ORDER BY review_created_at DESC";
            $result = mysqli_query($conn, $query);
        }else{$query = "SELECT * FROM customer_review WHERE review_star = '$a' ORDER BY review_created_at DESC";
            $result = mysqli_query($conn, $query);
        }
    }
    if ($result) {
        // Loop through the rows and output the data
        while ($row = mysqli_fetch_assoc($result)) {
        $stars = "";
        for($a = 0; $a < 5; $a++){
            if($a < $row['review_star']){
            $stars .= '<span class="fa  checked"></span>';
            }else{
            $stars .= '<span class="fa "></span>';
            }
        }
        echo'<div class="review">
                <h3 class="name">'.$row['review_name'].'</h3>
                <div>
                '.$stars.'
                    <span class="date">'.date("m d Y", strtotime($row['review_created_at'])).'</span>
                    </span>
                </div>
                <p class="content">'.$row['review_comment'].'</p>
                <hr>
            </div>';
        }
        }
?>