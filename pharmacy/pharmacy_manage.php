<?php
    include 'startsession.php';
    include 'pharmacy_error.php';
    include 'db_products_connect.php';
    include 'redirect_index_if_not_loggedin.php';  
    //DELETE ITEM
    $prod_id;
    if(isset($_POST['product_id'])){
        $prod_id = $_POST['product_id']; 
        $prod_id =  mysqli_real_escape_string($conn, $prod_id);
        $delete_query = "DELETE FROM product_table WHERE product_id = '$prod_id'";
        $delete  = mysqli_query($conn, $delete_query);
    }
    
    //LOAD ITEMS
    $records_per_page = 4;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $records_per_page;
    if(isset($_SESSION['phar_account'])){
        $phar_pk = $_SESSION['phar_account'];
    }
    $query = "SELECT * FROM product_table WHERE phar_id = '$phar_pk' LIMIT $offset, $records_per_page";
    $products = mysqli_query($conn,$query);
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage Items | Pharmacy</title>
        <link rel="stylesheet" href="css/styles_manageitem.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            //Load Items by default
            function goToPage(product_id) {
                var link = 'pharmacy_edititem.php?prod_id=' + encodeURIComponent(product_id);
                window.location.href = link;
            }
            function out_of_stock(product_id){
                var link = 'pharmacy_out_of_stock.php?prod_id=' + encodeURIComponent(product_id);
                window.location.href = link;
            }
            //DELETEITEM FUNCTION
            function deleteProduct(productId) {
            $.ajax({
                url: "pharmacy_manage.php",
                type: "POST",
                data: { product_id: productId },
                success: function(response) {
                document.getElementById(productId).style.display = "none";
                console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
            }
        </script>
    </head>
    <body>
        <div id="main-box">
        <?php include 'selleroptions.php'?>
            <div id="manage-prods">
                <div class="greet">
                    <h2>Manage products</h2>
                </div>

                <div id="add-new-product">
                    <a href="pharmacy_additem.php" id="new-product">+ Add New Product</a>
                </div>

                <div id="manage-header">
                    <div id="search-function">
                        <h4 id="browse-posts">Browse from your posts</h4>
                        <form action="/action_page.php">
                            <input type="text" placeholder="Search item..." id="search">
                            <button type="submit" id="search-button"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <div class="edit-product">
                    <?php 
                     while($row = mysqli_fetch_assoc($products)){
                        $is_stock = ($row['out_of_stock'] == 0)? "Out of Stock":" In Stock" ;
                        $is_stock_btn = ($row['out_of_stock'] == 0)? '<button onclick="out_of_stock('.$row['product_id'].')" class="out-of-stock" disabled style="background-color: gray; color: white; cursor: not-allowed;">Mark as Out of Stock</button>'
                        :'<button onclick="out_of_stock('.$row['product_id'].')" class="out-of-stock">Mark as Out of Stock</button>' ;
                        echo '
                        <div class="details" id = "'.$row['product_id'].'">
                            <div class="product-pic">
                                <img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" class="pic-sizing">
                            </div>
                            <div class="product-links">
                                <div class="product-basics"> 
                                    <h4 class="product-name">'.$row['prod_name'].'</h4>
                                    <p class="product-price">'.$row['price'].'</p>
                                    <p class="product-stock">'.$is_stock.'</p>
                                </div>
                                <div class="product-actions">
                                '.$is_stock_btn.'
                                <button onclick="goToPage('.$row['product_id'].')" class="edit">Edit Item</button>
                                <button  onclick="deleteProduct('.$row['product_id'].')" class="delete">Delete Item</button>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
                <div id="nav-buttons">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1 ?>" class="before round">&laquo; Previous</a>
                <?php endif; ?>
                <?php if (mysqli_num_rows($products) == $records_per_page): ?>
                    <a href="?page=<?php echo $current_page + 1 ?>" class="after round">Next &raquo;</a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
