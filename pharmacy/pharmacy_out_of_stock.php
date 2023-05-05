<?php 
    include 'db_products_connect.php';
    $prod_id=null;
    if(isset($_GET['prod_id'])){
        $prod_id = $_GET['prod_id'];
    }

    $query = "  UPDATE `product_table`
                SET `out_of_stock` = '0', `quantity`='0'
                WHERE `product_id` = '$prod_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        header("location: pharmacy_manage.php");
    }
    $conn->close();
?>