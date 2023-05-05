<div class="nav-actual">
           <a href="../index.php" id="header"><h2>ALMED</h2></a>
            <ul class="first-ul">
                <li><a href="../PHP/products.php">SHOP</a></li>
                <li><a href="../PHP/review_page.php">REVIEWS</a></li>
                <li><a href="../PHP/about.php">ABOUT US</a></li>
                <?php 
                if(!isset($_SESSION['session_name'])){
                    echo '
                    <li><a href= "../PHP/login.php">LOGIN </a>
                    </li>';  
                }else { 
                    echo '<li><a>'.strtoupper($_SESSION['session_name']).'</a>
                    <!--DROPDOWN-->
                    <ul class="sub-ul">
                        <li><a href="../PHP/user_myaccountdef.php">PROFILE</a></li>
                        <li><a href="../PHP/logout.php">LOG OUT</a></li>
                    </ul>
                </li>';
                }?>
            </ul>
            <?php 
                if(!isset($_SESSION['session_name'])){
                    echo '<a id="cart" style="color:var(--coolor1); pointer-events:none;">CART</a>';  
                }else { 
                    echo '<a href="../PHP/Cart_Checkout2.php" id="cart">CART</a>';
                }
            ?>
</div>
