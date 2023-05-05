<?php error_reporting(E_ALL);
ini_set('display_errors', 1);
    include 'startsession.php';
    include('db_product_connect.php');
    $cat_sort;
    $phar_id;
    $prod_sort = null;
    $query;
    $search;
    if(isset($_GET['cat_sort'])){
        $cat = $_GET['cat_sort'];
        $cat_sort = " AND `category`= '$cat' ";
    }else{
        $cat_sort = ' ';
    }
    if(isset($_GET['phar_id'])){
        $phar_id = $_GET['phar_id'];
    }
    if(isset($_GET['prod_sort'])){
        $prod_sort = $_GET['prod_sort'];
    }
    if(isset($_GET['search'])){
        $srch = strtolower($_GET['search']);
        $search = " AND LOWER(prod_name) LIKE '%{$srch}%' ";
    }else{
        $search = ' ';
    }
    switch($prod_sort){
        case 'gen':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search AND `gen_or_brand` = '0' ORDER BY prod_name ASC";
        break;
        case 'brand':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search AND `gen_or_brand` = '1' ORDER BY prod_name ASC";
        break;
        case 'l_h':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search ORDER BY price ASC";
        break;
        case 'h_l':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search ORDER BY price DESC";
        break;
        case 'a_z':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search ORDER BY prod_name ASC";
        break;
        case 'z_a':  $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search ORDER BY prod_name DESC";
        break;
        default : $query = "SELECT * FROM product_table WHERE `phar_id` = '$phar_id' $cat_sort $search ORDER BY prod_name ASC";
        break;
    }
    $result = mysqli_query($conn, $query);
    if ($result) {
        // Loop through the rows and output the data
        while ($row = mysqli_fetch_assoc($result)) {
        $is_stock = ($row['out_of_stock'] == 0)? "Out of Stock":" In Stock" ;
        echo'
        <div class="item">
            <a href="Productcard.php?prod_id='.$row['product_id'].'" class="link-image">
                <img id="med-img" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"
                alt="Medicine Sample">
            </a>
            <div class="med-desc">
                <p class="med-name">'.$row['prod_name'].'</p>
                <h4 class="med-price">PHP'.$row['price'].'</h4>
                <p class="med-name">'.$is_stock.'</p>
            </div>
        </div>
            ';
        }
    }
    $conn->close();
?>