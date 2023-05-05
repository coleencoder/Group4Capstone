<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('startsession.php');
    include('db_products_connect.php');
    include 'redirect_index_if_not_loggedin.php';
    $phar_id;
    if(isset($_SESSION['phar_account'])){
        $phar_id = $_SESSION['phar_account'];
    }
    //PHARMACY QUERY
    $pharmacy_db_conn =  mysqli_connect("","almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Pharmacy");
    $phar_query = " SELECT *
                    FROM pharmacy_table
                    WHERE pharmacy_pk = '$phar_id'";
    $phar_row = mysqli_query($pharmacy_db_conn, $phar_query);
    $phar = mysqli_fetch_assoc($phar_row);
    //CATEGORY QUERY
    $category_name_find = "SELECT *
    FROM product_category 
    ORDER BY CASE WHEN `category-name` = 'Others' THEN 1 ELSE 0 END, `category-name` ASC";
    $category_name_query = mysqli_query($conn,$category_name_find);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | Pharmacy</title>
        <link rel="stylesheet" href="../css/styles_viewprofile.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                var cat;
                var search;
            $("#grid-of-products").load("pharmacy_viewprofile_sort.php?phar_id=<?php echo $phar_id ?>");
            $(".sort-category").click(function() {
                var sort_value = $(this).val();
                $.get("pharmacy_viewprofile_sort.php", {phar_id : <?php echo $phar_id ?>, 
                                                        prod_sort : sort_value
                }, function(data) {
                $("#grid-of-products").html(data);
                });
            });
            $(".type-of-med").click(function() {
                cat = $(this).val();
                $.get("pharmacy_viewprofile_sort.php", {phar_id : <?php echo $phar_id ?>,
                    cat_sort : cat
                }, function(data) {
                $("#grid-of-products").html(data);
                });
            });
            $("#search-button").click(function() {
                search = $('#search').val();
                $.get("pharmacy_viewprofile_sort.php", {phar_id : <?php echo $phar_id ?>,
                    search : search
                }, function(data) {
                $("#grid-of-products").html(data);
                });
            });
            });
        </script>
    </head>
    <body>
        <div id="head">
            <h2 id="pharma-name"><?php echo $phar['name'];?></h2>
            <p id="address"><?php echo $phar['address'];?></p>
            <img id="pharma-icon" src="<?php 
            if($phar['pharmacy_image'] === null){
                echo '..\images\avatar-f.jpg';
            }else {
                echo 'data:image/jpeg;base64,'.base64_encode( $phar['pharmacy_image'] );
            }
            ?>">
        </div>
        <div id="a-holder">
            <a href="pharmacy_editprofile.php" id="editprofile">Edit Profile</a>
        </div>
        <br>
        <div id="pharma-bio">
            <p class="pharma-text"><?php $bio = $phar['bio'];echo "$bio";?></p>
            <p class="special-text">This pharmacy is legally permitted by the DTI.</p>
        </div>
       
        <div id="master-tab">
            <div id="pharma-nav">
                <button class="pharma-bot" onclick="openTab('products')">Products</button>
                <button class="pharma-bot" onclick="openTab('reviews')">Reviews</button>
            </div>
            <div id="products" class="tab">
                <div id="categories">
                    <h4>Categories</h4>
                    <?php 
                        while($row = mysqli_fetch_assoc($category_name_query)){
                            echo '<button type="submit" value = "'.$row['category'].'"class="type-of-med">'.$row['category-name'].'</button>';
                        }
                    ?>
                </div>
                <div id="pharma-products">
                    <div id="navigator">
                        <p id="sort-by">Sort by</p>
                            <button type="submit" class="sort-category" value = "gen">Generic</button>
                            <button type="submit" class="sort-category" value = "brand">Branded</button>
                            <button type="submit" class="sort-category" value = "l_h">Lowest to highest price</button>
                            <button type="submit" class="sort-category" value = "h_l">Highest to lowest price</button>
                            <button type="submit" class="sort-category" value = "a_z">A to Z</button>
                            <button type="submit" class="sort-category" value = "z_a">Z to A</button>
                        <div id="search-function">
                            <input type="text" placeholder="Search medicine..." id="search">
                            <button type="submit" id="search-button"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div id="grid-of-products">
 
                    </div>
                    <div id="page-number">
                        <a href="#" class="page">&laquo;</a>
                        <a href="#" class="page">1</a>
                        <a href="#" class="page">2</a>
                        <a href="#" class="page">3</a>
                        <a href="#" class="page">&raquo;</a>
                    </div>
                </div>  
            </div>
            <div id="reviews"  class="tab">
            </div>
        </div>

        <script type="text/javascript">
            function openTab(tabName) {
            var i;
            var bot = document.getElementsByClassName("tab");
            for (i = 0; i < bot.length; i++) {
                bot[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "flex";
            }
        </script>
    </body>
</html>
