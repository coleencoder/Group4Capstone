<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include 'startsession.php';
    include('dbconnect.php');
    
    
        if(isset($_POST['submit'])){
        //Codes if submit button is clicked
        $name = htmlspecialchars($_POST["first_name"].' '.$_POST["last_name"]);
        $star = $_POST["rate"];
        $review = htmlspecialchars($_POST["comments"]);
        $submit_query = "INSERT INTO `customer_review` (review_name,review_comment,review_star) 
        VALUES ('$name','$review','$star')";
        
        
        //insert address data 
        if ($conn->query($submit_query) === TRUE) {
          echo '<script>alert("Record updated successfully")</script>';
        } else {
            echo "Error updating record: " . $conn->error();
        }
        
    }
    // Query to retrieve rows from the database in descending order by date
    $query = "SELECT * FROM customer_review ORDER BY review_created_at DESC LIMIT 4";
    // Execute the query
    $result = mysqli_query($conn, $query);  
    //REVIEW STATS 
    $starsaverage = 0;
    $starstats = 0;
    $totalreviews = 0;
    $star_count[] = array();
    $star_percent[] = array();
    $ave_star_query = mysqli_query($conn, "SELECT COALESCE(ROUND(AVG(review_star),1),0) AS avg_stars,
                                           COUNT(*) AS total_reviews,
                      SUM(CASE WHEN review_star = 5 THEN 1 ELSE 0 END) AS five_star_count,
                      SUM(CASE WHEN review_star = 4 THEN 1 ELSE 0 END) AS four_star_count,
                      SUM(CASE WHEN review_star = 3 THEN 1 ELSE 0 END) AS three_star_count,
                      SUM(CASE WHEN review_star = 2 THEN 1 ELSE 0 END) AS two_star_count,
                      SUM(CASE WHEN review_star = 1 THEN 1 ELSE 0 END) AS one_star_count,
                      ROUND((SUM(CASE WHEN review_star = 5 THEN 1 ELSE 0 END) / COUNT(*)) * 100) AS five_star_percentage,
                      ROUND((SUM(CASE WHEN review_star = 4 THEN 1 ELSE 0 END) / COUNT(*)) * 100) AS four_star_percentage,
                      ROUND((SUM(CASE WHEN review_star = 3 THEN 1 ELSE 0 END) / COUNT(*)) * 100) AS three_star_percentage,
                      ROUND((SUM(CASE WHEN review_star = 2 THEN 1 ELSE 0 END) / COUNT(*)) * 100) AS two_star_percentage,
                      ROUND((SUM(CASE WHEN review_star = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100) AS one_star_percentage
                      FROM customer_review");
    if($row = mysqli_fetch_assoc($ave_star_query)){
      $starsaverage = $row['avg_stars'];
      $starstats = round($starsaverage);
      $totalreviews= $row['total_reviews'];
      $star_percent[1] = $row['one_star_percentage'];
      $star_percent[2] = $row['two_star_percentage'];
      $star_percent[3] = $row['three_star_percentage'];
      $star_percent[4] = $row['four_star_percentage'];
      $star_percent[5] = $row['five_star_percentage'];
      $star_count[1] = $row['one_star_count'];
      $star_count[2] = $row['two_star_count'];
      $star_count[3] = $row['three_star_count'];
      $star_count[4] = $row['four_star_count'];
      $star_count[5] = $row['five_star_count'];
    }

    $conn->close();    
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Reviews | ALMed Marikina</title>
    <link rel="stylesheet" href="../css/styles_contact.css">
    <link rel="stylesheet" href="../css/styles_loginnavie.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <?php include 'navbar.php'?>
    <section id="product-section">
      <h2>Site Review</h2>
    </section>
    <!--START REVIEW PAGE-->
      <section class="shop-intro">
        <h3>What they say about the website:</h3>
      </section>
      <!--RATING-->
      <div id="stats">
        <div class="values">
            <h3>User Rating</h3>
            <?php 
            $starstats_string = '';
            for($a = 0; $a < 5; $a++){
              if($a < $starstats){
                $starstats_string .= '<span class="fa  checked"></span>';
              }else{
                $starstats_string .= '<span class="fa "></span>';
              }
            }
            echo $starstats_string;
            ?>
            <p class="content"><?php echo $starsaverage;?> average based on <?php echo $totalreviews;?> reviews.</p>
            <div class="row">
                <div class="side">
                  <div>5 star</div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div style="width: <?php echo $star_percent[5]?>%; height: 18px; background-color: #04AA6D;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo "$star_count[5]";?></div>
                </div>
                <div class="side">
                  <div>4 star</div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div style="width: <?php echo $star_percent[4]?>%; height: 18px; background-color: #2196F3;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo "$star_count[4]";?></div>
                </div>
                <div class="side">
                  <div>3 star</div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div style="width:<?php echo $star_percent[3]?>%; height: 18px; background-color: #00bcd4;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo "$star_count[3]";?></div>
                </div>
                <div class="side">
                  <div>2 star</div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div style="width: <?php echo $star_percent[2]?>%; height: 18px; background-color: #ff9800;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo "$star_count[2]";?></div>
                </div>
                <div class="side">
                  <div>1 star</div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div style="width: <?php echo $star_percent[1]?>%; height: 18px; background-color: #f44336;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo "$star_count[1]";?></div>
                </div>
              </div>           
        </div>
      </div>
      <!--SITE REVIEWS-->
      <h2 class="interlude">Site Reviews</h2> 
      <div id="table-border">
        <?php
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
        <a href = "reviews.php" id="go-back-button">See all reviews</a>
      </div>
      <?php if(isset($_SESSION['session_account'])){?>
    <!-- START CONTACT PAGE-->
    <div class="contact-bg" name = "contact" id = "contact"> 
      <div class="container">
        <div class="row header">
        <h1>We would like to hear from you! &nbsp;</h1>
        <h4>Tell us your experience in using the website</h4>
        </div>
        <div class="row body"> 
          <form action = "review_page.php" method = "POST">
            <!--START CLICKABLE STARS-->
            <div class="rate">
              <input type="radio" id="star5" name="rate" value="5" required/>
              <label for="star5" title="text">5 stars</label>
              <input type="radio" id="star4" name="rate" value="4" required/>
              <label for="star4" title="text">4 stars</label>
              <input type="radio" id="star3" name="rate" value="3" required/>
              <label for="star3" title="text">3 stars</label>
              <input type="radio" id="star2" name="rate" value="2" required/>
              <label for="star2" title="text">2 stars</label>
              <input type="radio" id="star1" name="rate" value="1" required/>
              <label for="star1" title="text">1 star</label>
            </div>
            <!--END CLICKABLE STARS-->
            <ul>
              <li>
                <p class="left">
                  <label for="first_name">First name</label>
                  <input type="text" name="first_name" placeholder="First Name" required/>
                </p>
                <p class="left">
                  <label for="last_name">Last name</label>
                  <input type="text" name="last_name" placeholder="Last Name" required/>
                </p>
              </li>
              <li>
                <div class="divider"></div>
              </li>
              <li>
                <label for="comments">Comments</label>
                <textarea cols="46" rows="6" name="comments" required></textarea>
              </li>
              
              <li>
                <input class="btn btn-submit" type="submit" name = "submit" value="Submit" />
              </li>
              
            </ul>
          </form>
        </div>
      </div>
    </div>
    <?php }?>
    <!-- END CONTACT PAGE-->
    <div id="go-back">
      <a href = "../index.php" id="go-back-button">Back to Home</a>
    </div>
  </body>
</html>
