<?php
    include 'db_product_connect.php';
    $a;
    $b;
    $query;
    $result;
    if(isset($_POST['prod_sort']) ){
       $a =  $_POST['prod_sort'];
       
    }
    if(isset($_GET['category_id'])){
        $b = $_GET['category_id'];
    }

    switch($a){
        case 'asc': $query = "SELECT * FROM product_table WHERE `category` = '$b' ORDER BY prod_name ASC";
        // Execute the query
        $result = mysqli_query($conn, $query);
        break;
        case 'desc': $query = "SELECT * FROM product_table WHERE `category` = '$b' ORDER BY prod_name DESC";
        $result = mysqli_query($conn, $query);
        break;
        case 'low_to_high': $query = "SELECT * FROM product_table WHERE `category` = '$b' ORDER BY price ASC";
        $result = mysqli_query($conn, $query);
        break;
        case 'high_to_low':$query = "SELECT * FROM product_table WHERE `category` = '$b' ORDER BY price DESC";
        $result = mysqli_query($conn, $query);
        break;
        case 'branded':$query = "SELECT * FROM product_table WHERE `category` = '$b' AND `gen_or_brand` = '1' ";
        $result = mysqli_query($conn, $query);
        break;
        case 'generic':$query = "SELECT * FROM product_table WHERE `category` = '$b' AND `gen_or_brand` = '0' ";
        $result = mysqli_query($conn, $query);
        break;
    }

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