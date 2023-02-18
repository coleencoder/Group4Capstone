<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/design.css">
    <title>Contact</title>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="container">
        <div class="row header">
          <h1>CONTACT US &nbsp;</h1>
          <h3>Fill out the form below to learn more!</h3>
        </div>
        <div class="row body">
          <form action="#">
            <ul>
              
              <li>
                <p class="left">
                  <label for="first_name">first name</label>
                  <input type="text" name="first_name" placeholder="Dylan" />
                </p>
                <p class="pull-right">
                  <label for="last_name">last name</label>
                  <input type="text" name="last_name" placeholder="Cipriano" />      
                </p>
              </li>
              
              <li>
                <p>
                  <label for="email">email <span class="req">*</span></label>
                  <input type="email" name="email" placeholder="dylanbluecipriano20@gmail.com" />
                </p>
              </li>        
              <li><div class="divider"></div></li>
              <li>
                <label for="comments">comments</label>
                <textarea cols="46" rows="3" name="comments"></textarea>
              </li>
              
              <li>
                <input class="btn btn-submit" type="submit" value="Submit" />
                <small>or press <strong>enter</strong></small>
              </li>
              
            </ul>
          </form>  
        </div>
      </div>
      
</body>
</html>