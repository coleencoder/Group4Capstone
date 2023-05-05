<?php 
    include 'startsession.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Medicine | ALMed</title>
        <link rel="stylesheet" href="../css/reviews.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            //Sort by stars
            $(document).ready(function(){
                $(".sort-category").click(function(){
                    var star_value = $(this).val();
                    $("#table-border").load("review_sort.php",{
                        star : star_value
                    });
                });
            });
        </script>
    </head>
    <body>
    <?php include 'navbar.php'?>
        <div id="title-holder">
            <h2 id="med-category">All Website Reviews</h2>
            <p id="med-interlude">All the reviews about the website lies here.</p>
        </div>

        <div id="categories-holder">
            <p id="sort-by">Sort by</p>
                <button id="star" name = "star-sort-all" class="sort-category" value = "6">All ★</button>
                <button id="star" name = "star-sort" class="sort-category" value="1">1 ★</button>
                <button id="star" name = "star-sort" class="sort-category" value="2">2 ★</button>
                <button id="star" name = "star-sort" class="sort-category" value="3">3 ★</button>
                <button id="star" name = "star-sort" class="sort-category" value="4">4 ★</button>
                <button id="star" name = "star-sort" class="sort-category" value="5">5 ★</button>
        </div>
        <div class="interlude">            
            <h2>Site Reviews</h2> 
            <div id="table-border">
            <?php
            include('dbconnect.php');
            // Query to retrieve rows from the database in descending order by date
            $query = "SELECT * FROM customer_review ORDER BY review_created_at DESC";
            // Execute the query
            $result = mysqli_query($conn, $query);
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
            </div>
            <div id="go-back">
                <a href = "contact.php" id="go-back-button">Go back</a>
            </div>
        </div>
    </body>
</html>