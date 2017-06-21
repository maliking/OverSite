<?php
    require("databaseConnection.php");  
    session_start();
    $dbConn = getConnection();
    if(!isset($_SESSION['userId'])) {
        header("Location: userLogin.php?error=wrong username or password");
    } 
 ?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New House Information</title>
    <meta charset = "utf-8"/>
    <link type="text/css" rel="stylesheet" href="addOrEditInfo.css">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script>
        /*function sendAddressCounty() {  
          
         $.ajax({
                type: "get",
                url: "../PQLogin/runScript.php",
                dataType: "json",
                data: {"county": $("#county").val(),
                        "address": $("#address").val() },
                success: function(data,status) {
                    //alert(status);
                    document.getElementById('bedrooms').value = data['bedrooms']; //added for testing purposes on how the items will be added to form later on
                    document.getElementById('bathrooms').value = data['bathrooms'];
                    document.getElementById('price').value = data['price'];
                },
                complete: function(data,status) { //optional, used for debugging purposes
                     //alert(JSON.stringify(data));
                }
             });
         }*/
    </script><!-- importing jQuery library-->
    <style type="text/css">
        .form select {
          font-family: "Roboto", sans-serif;
          outline: 0;
          background: #f2f2f2;
          width: 100%;
          border: 0;
          margin: 0 0 15px;
          padding: 15px;
          box-sizing: border-box;
          font-size: 14px;
          text-align: center;
        }
    </style>

</head>
    <body>
                <!-- Navigation Bar -->
            <?php
                // require("agentNav.php");
            ?>  
            
                <div type="text" class="form" style="float:left; width:50%;">
                    <h1>Enter House Information</h1>
                    Status:
                    <select id="status">
                      <option value="active" selected>active</option>
                      <option value="pending">pending</option>
                      <option value="sold">sold</option>
                    </select>
                    County:
                    <select id="county">
                      <option value="Alameda, CA">Alameda, CA</option>
                      <option value="Alpine, CA">Alpine, CA</option>
                      <option value="Amador, CA">Amador, CA</option>
                      <option value="Butte, CA">Butte, CA</option>
                      <option value="Calaveras, CA">Calaveras, CA</option>
                      <option value="Colusa, CA">Colusa, CA</option>
                      <option value="Contra Costa, CA">Contra Costa, CA</option>
                      <option value="Del Norte, CA">Del Norte, CA</option>
                      <option value="El Dorado, CA">El Dorado, CA</option>
                      <option value="Fresno, CA">Fresno, CA</option>
                      <option value="Glenn, CA">Glenn, CA</option>
                      <option value="Humboldt, CA">Humboldt, CA</option>
                      <option value="Imperial, CA">Imperial, CA</option>
                      <option value="Inyo, CA">Inyo, CA</option>
                      <option value="Kern, CA">Kern, CA</option>
                      <option value="Kings, CA">Kings, CA</option>
                      <option value="Lake, CA">Lake, CA</option>
                      <option value="Lassen, CA">Lassen, CA</option>
                      <option value="Los Angeles, CA">Los Angeles, CA</option>
                      <option value="Madera, CA">Madera, CA</option>
                      <option value="Marin, CA">Marin, CA</option>
                      <option value="Mariposa, CA">Mariposa, CA</option>
                      <option value="Mendocino, CA">Mendocino, CA</option>
                      <option value="Merced, CA">Merced, CA</option>
                      <option value="Modoc, CA">Modoc, CA</option>
                      <option value="Monterey, CA" selected>Monterey, CA</option>
                      <option value="Napa, CA">Napa, CA</option>
                      <option value="Nevada, CA">Nevada, CA</option>
                      <option value="Orange, CA">Orange, CA</option>
                      <option value="Placer, CA">Placer, CA</option>
                      <option value="Plumas, CA">Plumas, CA</option>
                      <option value="Riverside, CA">Riverside, CA</option>
                      <option value="Sacramento, CA">Sacramento, CA</option>
                      <option value="San Benito, CA">San Benito, CA</option>
                      <option value="San Bernardino, CA">San Bernardino, CA</option>
                      <option value="San Diego, CA">San Diego, CA</option>
                      <option value="San Francisco, CA">San Francisco, CA</option>
                      <option value="San Joaquin, CA">San Joaquin, CA</option>
                      <option value="San Luis Obispo, CA">San Luis Obispo, CA</option>
                      <option value="San Mateo, CA">San Mateo, CA</option>
                      <option value="Santa Barbara, CA">Santa Barbara, CA</option>
                      <option value="San Clara, CA">San Clara, CA</option>
                      <option value="Santa Cruz, CA">Santa Cruz, CA</option>
                      <option value="Shasta, CA">Shasta, CA</option>
                      <option value="Sierra, CA">Sierra, CA</option>
                      <option value="Siskiyou, CA">Siskiyou, CA</option>
                      <option value="Solano, CA">Solano, CA</option>
                      <option value="Sonoma, CA">Sonoma, CA</option>
                      <option value="Stanislaus, CA">Stanislaus, CA</option>
                      <option value="Tehama, CA">Tehama, CA</option>
                      <option value="Trinity, CA">Trinity, CA</option>
                      <option value="Tulare, CA">Tulare, CA</option>
                      <option value="Tuolumne, CA">Tuolumne, CA</option>
                      <option value="Ventura, CA">Ventura, CA</option>
                      <option value="Yolo, CA">Yolo, CA</option>
                      <option value="Yuba, CA">Yuba, CA</option>
                    </select>
                    <input type="text" id="address" placeholder="address"> <br />
                    <input type="text" id="city" placeholder="city"><br />
                    <!-- City: <span id="cities"></span> <br /> -->
                    <input type="text" id="state" value="California" readonly=""><br />
                    <input type="text" id="zip" placeholder="zip"><br />
                    <input type="text" id="bedrooms" placeholder="bedrooms"><br />
                    <input type="text" id="bathrooms" placeholder="bathrooms"><br />
                    <input type="text" id="price" placeholder="price"><br />
                    <input type="hidden" id="userId" value="<?=$_SESSION['userId']?>"> 
                    <input id="button" type="button" value="Enter" onclick="enterInfo()"> 
                    <?php include('../footer.php'); ?>
                    
            
            
                    <script> 
                        $("#address").change(sendAddressCounty());
                        function enterInfo(){
                          alert("test");
                            var status = $("#status :selected").text();
                            var address = $("#address").val();
                            var city = $("#city").val();
                            var state = $("#state").val();
                            var zip = $("#zip").val();
                            var bedrooms = $("#bedrooms").val();
                            var bathrooms = $("#bathrooms").val();
                            var price = $("#price").val();
                            var userId = $("#userId").val();  
                            $.ajax({
                                type: "POST",
                                url: "http://52.11.24.75/Agent/submitHouseInfo.php",
                                data: {status: status,
                                      address: address,
                                      city: city,
                                      state: state,
                                      zip: zip,
                                      bedrooms: bedrooms,
                                    bathrooms: bathrooms,
                                    price: price,
                                    userId: userId}
                            }); 
                            window.location.href = "AgentHome.php";
                        };    
                    </script>
            </div>
                <div style="float:right;">
                    <div style="text-align: center;">
                        <object data=http://remax.idxhome.com/homesearch/59157 width="800" height="900"> <embed src=http://remax.idxhome.com/homesearch/59157 width="800" height="900"> </embed> Error: Embedded data could not be displayed. </object>
                    </div>
                </div>
    </body>
    
</html>