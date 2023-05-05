<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Email Verification | Pop Up</title>
        <link rel="stylesheet" href="../css/styles_popupemail.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body onload="pop_up()">
        <!--Modal Portion/Pop up after customer signs up their account.-->
        <!--Same modal will appear when customer logs in without verifying their email-->
        <div id="popup-email" class="modal">
            <div class="pop-up">
                <div id="one-more-stop">
                    <h2>One more stop before you shop!</h2>
                    <span class="close" href="#">&times;</span>
                </div>
                
                <div class="content">
                    You have successfully created your account! But to be able to log in,
                    you must first verify your account through the link we sent in your email address.
                    This is to assure we are providing medicine to real Marikeños in need.
                </div>

                <div id="center-gotit">
                    <a href ="login.php" style="text-decoration:none;">
                        <button id="got-it">Got it!</button>
                    </a>
                </div>
            </div>
        </div>

        <script>

        </script>

        <script type="text/javascript">
            // Get the modal
            var modal = document.getElementById("popup-email");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // Get the other Got It button
            var got = document.getElementById("got-it");



            // Clicking the btn variable will open the modal
            function pop_up() {
                modal.style.display = "block";
            }

            // Clicking the <span> (x) will close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Clicking the Got It button will close the modal
            got.onclick = function() {
                modal.style.display = "none";
            }

            // Clicking anywhere outside the modal will close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <!--End of Modal Portion-->
    </body>
</html>