<?php
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shipment | Pharmacy</title>
        <link rel="stylesheet" href="css/stylespharmacyshipment.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            /*table js*/
            function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var tr = document.getElementById("myRow");
            if (checkBox.checked == true){
                tr.style.backgroundColor = "yellow";
            } else {
                tr.style.backgroundColor = "white";
            }
            }
            /*tab js*/
            function opentab(evt, tab) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("table");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tab).style.display = "block";
            evt.currentTarget.className += " active";
            }
        </script>
    </head>
    <body>
        <div id="main-box">
        <?php include 'selleroptions.php'?>
            <div id="seller-profile">
                <div class="tab">
                    <button class="tablinks" onclick="opentab(event, 'Shipment')"><h2>Shipment</h2></button>
                    <button class="tablinks" onclick="opentab(event, 'Prescription')"><h2>Prescription</h2></button>
                </div>
                <!--SHIPMENT TABLE-->
                <div  id="Shipment" class="table">
                    <div id="buttons-flex">
                        <div class="show-all">
                            <a href="#" id="show-button">Update Table</a>
                        </div>
                        <div class="show-all">
                            <a href="#"  id="show-button">Search</a>
                        </div>
                        <div class="show-all">
                            <a href="#" id="show-button">Change Status</a>
                        </div>
                        <div class="show-all">
                            <a href="#" id="show-button">Save</a> 
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th style="background-color: white;"></th>
                                <th>ORDER ID</th>
                                <th>CUSTOMER ID</th>
                                <th>CUSTOMER NAME</th>
                                <th>CUSTOMER ADDRESS</th>   
                                <th>NAME</th>
                                <th>QUANTITY</th>
                                <th>PRICE</th>
                                <th>TOTAL PRICE</th>
                                <th>STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="myRow">
                                <th><input type="checkbox" name="name1"  id="myCheck" onclick="myFunction()">&nbsp;</th>
                                <td>000000001</td>
                                <td>000000001</td>
                                <td>FRANK ANTHONY NAPOLES</td>
                                <td>58 EURO ST, SAN MIGUEL PHASE 4, FORTUNE, MARIKINA, NCR, PHILIPPINES</td>
                                <td>BEIGESIC</td>
                                <td>5</td>
                                <td>5P</td>
                                <td>P25</td>
                                <td>FOR APPROVAL</td> 
                            </tr>
                            <tbody>
                        </table>
                    </div>
                    <!--END SHIPMENT TABLE-->
                </div>
                <!--END SHIPMENT TABLE-->
                <!--PRESCRIPTION TABLE-->
                <div id="Prescription" class="table">
                    <div id="buttons-flex">
                        <div class="show-all">
                            <a href="#" id="show-button">Update Table</a>
                        </div>
                        <div class="show-all">
                            <a href="#" id="show-button">Search</a>
                        </div>
                        <div class="show-all">
                            <a href="#" id="show-button">Change Status</a>
                        </div>
                        <div class="show-all">
                            <a href="#" id="show-button">Save</a> 
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th style="background-color: white;"></th>
                                <th>VALIDATION ID</th>
                                <th>ORDER ID</th>
                                <th>IMAGE</th>
                                <th>STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="myRow">
                                <th><input type="checkbox" name="name1"  id="myCheck" onclick="myFunction()">&nbsp;</th>
                                <td>000000001</td>
                                <td>000000001</td>
                                <td><a href>image.jpg</a></td>
                                <td>FOR APPROVAL</td>
                            </tr>
                            <tbody>
                        </table>
                    </div>
                </div>
                <!--END PRESCRIPTION TABLE-->
            </div>
        </div>
    </body>
</html>