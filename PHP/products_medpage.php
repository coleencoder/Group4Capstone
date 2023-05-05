<?php
    include('startsession.php');
    $a;
    if(isset($_GET['category_id'])){
        $a = $_GET['category_id'];
    }
    include 'db_product_connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Medicine | ALMed</title>
        <link rel="stylesheet" href="../css/styles_medpage.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $(".sort-category").click(function(){
                    var sort_value = $(this).val();
                    $("#product-holder").load(<?php global $a; echo'"products_medpage_sort.php?category_id='.$a.'"';?>,{
                        prod_sort : sort_value
                    });
                });
            });
        </script>
    </head>
    <body>
    <?php include 'navbar.php'?>
        <div id="title-holder">
            <?php 
            global $a;
            $query = "SELECT `category-name`,`interlude` FROM product_category WHERE `category` = '$a'";
            // Execute the query
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            echo '            
            <h2 id="med-category">'.$row['category-name'].'</h2>
            <p id="med-interlude">'.$row['interlude'].'</p>';
            ?>
        </div>

        <div id="categories-holder">
            <p id="sort-by">Sort by</p>
                <button type="submit" class="sort-category" value = "generic">Generic</button>
                <button type="submit" class="sort-category" value = "branded">Branded</button>
                <button type="submit" class="sort-category" value = "low_to_high">Lowest to highest price</button>
                <button type="submit" class="sort-category" value = "high_to_low">Highest to lowest price</button>
                <button type="submit" class="sort-category" value = "asc">A to Z</button>
                <button type="submit" class="sort-category" value = "desc">Z to A</button>

                <div id="search-function">
                    <input type="text" placeholder="Search medicine..." id="search">
                    <button type="submit" id="search-button"><i class="fa fa-search"></i></button>
                </div>
        </div>

        <div id="product-holder">
        <?php
            global $a;
            $query = "SELECT * FROM product_table WHERE `category` = '$a' ORDER BY prod_name ASC";
            // Execute the query
            $result = mysqli_query($conn, $query);
            if ($result) {
            // Loop through the rows and output the data
            while ($row = mysqli_fetch_assoc($result)) {
            $is_stock = ($row['out_of_stock'] == 0)? "Out of Stock":" In Stock" ;
            echo'
            <div class="item">
                <div class="seller-tab">
                    <p class="seller-name">'.$row['phar_name'].'</p>
                </div>
                <a href="Productcard.php?prod_id='.$row['product_id'].'" class="link-image">
                    <img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" alt="Medicine Sample">
                </a>
                <div class="med-desc">
                    <p class="med-name">'.$row['prod_name'].'</p>
                    <h4 class="med-price">'.$row['price'].'</h4>
                    <p class="med-name">'.$is_stock.'</p>
                </div>
            </div>
                ';
            }
            }
            $conn->close();
            ?>
        </div>
        <hr>
        <div id="nav-buttons">
            <a href="#" class="before round">&laquo; Previous</a>
            <a href="#" class="after round">Next &raquo;</a>
        </div>
        <style>
#go-back {
    text-align: center;
    margin: 30px 0;
}
#go-back-button {
    text-decoration: none;
    background-color: var(--coolor2);
    color: var(--coolor3);
    font-family: 'Rubik', sans-serif;
    font-size: 1.5em;
    padding: 20px;
}
</style>
 <div id="go-back">
            <a href="https://almedmarikina.online/PHP/products.php" id="go-back-button">Go Back</a>
            </div>
    </body>
</html>