<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();
if (isset ($_GET['deleteForm'])) {  //checking whether we have clicked on the "Delete" button
    $sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = '" . $_GET['buyerID'] . "'";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
}
if($_GET['id'][0] == 'M')
    $addedHouses = "SELECT houseId FROM HouseInfo WHERE listingId = :listingId";
else
    $addedHouses = "SELECT houseId FROM HouseInfo WHERE houseId = :listingId";
$addedHouseParam = array();
$addedHouseParam[':listingId'] = $_GET['id'];

$addedHousesStmt = $dbConn->prepare($addedHouses);
$addedHousesStmt->execute($addedHouseParam);
$addedHouseResults = $addedHousesStmt->fetch();


function updateSort($sort)
{
    if ($sort == 1) {
        return 0;
    } else {
        return 1;
    }
}

//sort variables; 1 will be alphabetical; 0 will be reverse alphabetical
$visitorSort = 1;
$emailSort = 1;
$addressSort = 1;
$bedroomSort = 1;
$bathroomSort = 1;

if (isset($_GET['visitorSort'])) {
    $visitorSort = $_GET['visitorSort'];
}
if (isset($_GET['emailSort'])) {
    $emailSort = $_GET['emailSort'];
}
if (isset($_GET['addressSort'])) {
    $addressSort = $_GET['addressSort'];
}
if (isset($_GET['bedroomSort'])) {
    $bedroomSort = $_GET['bedroomSort'];
}
if (isset($_GET['bathroomSort'])) {
    $bathroomSort = $_GET['bathroomSort'];
}
$url = 'https://api.idxbroker.com/clients/featured';

$method = 'GET';

// headers (required and optional)
$headers = array(
    'Content-Type: application/x-www-form-urlencoded', // required
    'accesskey: e1Br0B5DcgaZ3@JXI9qib5', // required - replace with your own
    'outputtype: json' // optional - overrides the preferences in our API control page
);

// set up cURL
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference
$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code >= 200 || $code < 300) {
    $response = json_decode($response, true);
} else {
    $error = $code;
}

// print_r($response);

$keys = array_keys($response);
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | My Visitors</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <style>
            .modal-title {
                font-size: 150%;
                font-weight: bold;
            }
            
            #modal-table {
                color: black;
            }

             thead {
                  background-color: #dd4b39;
                }

        </style>
        <!-- NOTIFICATION Links-->
        <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">
        <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
        <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    </head>

    <body class="hold-transition skin-red-light sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">

            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-agent/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-agent/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->

            <!-- PAGE-SPECIFIC CSS -->
            
            <!-- Modal -->
  <div class="modal fade" id="addLeadModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Lead</h4>
        </div>
        <div class="modal-body">

          <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2"
                       placeholder="First Name">
                <span class="form-control-feedback left" aria-hidden="true"></span>

                </br>
                <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name">
                </br>
                <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4"
                       placeholder="Email">
                </br>
                <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                </br>
                 <label>How soon are you looking to purchase a home?</label>
                <select id="" name="howSoon" class="form-control" required>
                    <option value="0">--Select One--</option>
                    <option value="1-3">1-3 months</option>
                    <option value="4-6">4-6 months</option>
                    <option value="7-12">7-12 months</option>
                    <option value="Visit">Just visiting</option>
                </select>

                </br>
                <label>Price</label>
                <select id="" name="price" class="form-control" required>
                    <option value="0">--Select One--</option>
                    <option value="100000">$100,000</option>
                    <option value="200000">$200,000</option>
                    <option value="300000">$300,000</option>
                    <option value="400000">$400,000</option>
                    <option value="500000">$500,000</option>
                    <option value="600000">$600,000</option>
                    <option value="700000">$700,000</option>
                    <option value="800000">$800,000</option>
                    <option value="900000">$900,000</option>
                    <option value="1000000">$1,000,000+</option>
                </select>

                </br>

                 <label>Min Bedrooms</label>
                <select id="" name="bedroomsMin" class="form-control" required>
                    <option value="0">--Select One--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                </select>
                </br>
                <label>Min Bathrooms</label>
                <select id="" name="bathroomsMin" class="form-control" required>
                    <option value="0">--Select One--</option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                </select>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="addLead()">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->

                <section class="content" style="min-height:initial;">
                   
                    <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3>My Visitors</h3>
                            <!-- search form -->
                            <form action="#" method="get" class="sidebar-form">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search..."
                                           style="background-color:white;">
                                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                                </div>
                            </form>
                            <!-- /.search form -->
                        </div>
                        <!-------------Mock Visitor Dropdown-------->
                        <div class="container">

                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading row">
                                        <h4>
                                            <a data-toggle="collapse" href="#collapse1" class="col-md-1"><i
                                                        class="more-less fa fa-plus"></i> </a>
                                            <div class="col-md-11">Listing Address 1</div>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <div class="panel-heading row">
                                                <h4>
                                                    <a data-toggle="collapse" href="#collapse2" class="col-md-1"><i
                                                                class="more-less fa fa-plus"></i> </a>
                                                    <div class="col-md-3">John Doe</div>
                                                </h4>

                                                <div class="col-md-2">
                                                    <button type="button" data-toggle="modal" data-target="#textModal"
                                                            class="btn-xs btn-primary">Text
                                                    </button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn-xs btn-primary" type="button" data-toggle="modal"
                                                            data-target="#flyerModal">Forward Flyer
                                                    </button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn-xs btn-danger"> Remove</button>
                                                </div>
                                            </div>


                                            <div id="collapse2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Phone Number:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Email:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Date Visited:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn-xs btn-primary">Edit
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Bed Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Bath Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Price Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Price Max:
                                                        </div>

                                                    </div>


                                                    <div class="panel-body">
                                                        <div class="panel-heading row">
                                                            <h4>
                                                                <a data-toggle="collapse" href="#collapse3"
                                                                   class="col-md-1"><i class="more-less fa fa-plus"></i>
                                                                </a>
                                                                <div class="col-md-3">Notes</div>
                                                            </h4>
                                                            <div class="col-md-3">

                                                                <button class="btn-xs btn-primary" type="button"
                                                                        data-toggle="modal" data-toggle="modal"
                                                                        data-target="#addNotesModal">
                                                                    Add Note
                                                                </button>
                                                            </div>

                                                        </div>

                                                        <div id="collapse3" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        Lorem ipsum dolor sit amet, consectetur
                                                                        adipiscing elit. Donec quis sapien at erat
                                                                        ornare cursus vitae eu ligula. Aenean vitae
                                                                        risus nibh. Sed viverra rhoncus fringilla.
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        -September 18, 2017 1:07pm
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button"
                                                                                class="btn-xs btn-primary">Edit
                                                                        </button>
                                                                        <button type="button" class="btn-xs btn-danger">
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        Lorem ipsum dolor sit amet, consectetur
                                                                        adipiscing elit. Donec quis sapien at erat
                                                                        ornare cursus vitae eu ligula. Aenean vitae
                                                                        risus nibh. Sed viverra rhoncus fringilla.
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        -September 18, 2017 1:07pm
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button"
                                                                                class="btn-xs btn-primary">Edit
                                                                        </button>
                                                                        <button type="button" class="btn-xs btn-danger">
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>


                                            <div class="panel-heading row">
                                                <h4>
                                                    <a data-toggle="collapse" href="#collapse5" class="col-md-1"><i
                                                                class="more-less fa fa-plus"></i> </a>
                                                    <div class="col-md-3">Bob Smith</div>
                                                </h4>

                                                <div class="col-md-2">
                                                    <button type="button" data-target="#textModal"
                                                            class="btn-xs btn-primary">Text
                                                    </button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn-xs btn-primary" type="button" data-toggle="modal"
                                                            data-target="#flyerModal">Forward Flyer
                                                    </button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn-xs btn-danger"> Remove</button>
                                                </div>
                                            </div>


                                            <div id="collapse5" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Phone Number:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Email:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Date Visited:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn-xs btn-primary">Edit
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Bed Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Bath Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Price Min:
                                                        </div>
                                                        <div class="col-md-3">
                                                            Price Max:
                                                        </div>

                                                    </div>


                                                    <div class="panel-body">
                                                        <div class="panel-heading row">
                                                            <h4>
                                                                <a data-toggle="collapse" href="#collapse6"
                                                                   class="col-md-1"><i class="more-less fa fa-plus"></i>
                                                                </a>
                                                                <div class="col-md-3">Notes</div>
                                                            </h4>
                                                            <div class="col-md-3">

                                                                <button class="btn-xs btn-primary" type="button"
                                                                        data-toggle="modal"
                                                                        data-target="#addNotesModal">
                                                                    Add Note
                                                                </button>
                                                            </div>

                                                        </div>

                                                        <div id="collapse6" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        Lorem ipsum dolor sit amet, consectetur
                                                                        adipiscing elit. Donec quis sapien at erat
                                                                        ornare cursus vitae eu ligula. Aenean vitae
                                                                        risus nibh. Sed viverra rhoncus fringilla.
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        -September 18, 2017 1:07pm
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button"
                                                                                class="btn-xs btn-primary">Edit
                                                                        </button>
                                                                        <button type="button" class="btn-xs btn-danger">
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        Lorem ipsum dolor sit amet, consectetur
                                                                        adipiscing elit. Donec quis sapien at erat
                                                                        ornare cursus vitae eu ligula. Aenean vitae
                                                                        risus nibh. Sed viverra rhoncus fringilla.
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        -September 18, 2017 1:07pm
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button"
                                                                                class="btn-xs btn-primary">Edit
                                                                        </button>
                                                                        <button type="button" class="btn-xs btn-danger">
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <!-------------End Mock Visitor Dropdown-------->
                        <div id="table-scroll" style="overflow: auto;">
                        <button type="button" class="btn btn-success" style="float: right;" onClick="leadModal()">Add Lead</button>
                            <table class="table table-bordered table-striped" id="freeze" >
                                <thead>
                                <tr>
                                    <th data-breakpoints="all">TimeStamp</th>
                                    <th id="visitorSort"><a class="dotted"
                                                            href=<?php echo "http://jjp2017.org/agent/openhouse/visitors.php?visitorSort=" . updateSort($visitorSort) ?> data-toggle="tooltip"
                                                            data-placement="top" title="Approval Date">Visitors</a></th>

                                    <th data-breakpoints="all">Phone Number</th>
                                    <th id="emailSort" data-breakpoints="all"><a class="dotted"
                                                                                 href=<?php echo "http://jjp2017.org/agent/openhouse/visitors.php?emailSort=" . updateSort($emailSort) ?> data-toggle="tooltip"
                                                                                 data-placement="top"
                                                                                 title="Approval Date">Email</a></th>


                                    <th id="addressSort" data-breakpoints="xs sm"><a class="dotted"
                                                                                     href=<?php echo "http://jjp2017.org/agent/openhouse/visitors.php?addressSort=" . updateSort($addressSort) ?> data-toggle="tooltip"
                                                                                     data-placement="top"
                                                                                     title="Approval Date">Address
                                            Visited </a></th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Appraisal">Contact </a>
                                    </th>
                                    <th data-breakpoints="all">Notes</th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Appraisal">Notes</a>
                                    </th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Appraisal">Delete</a>
                                    </th>
                                    <th id="bedroomSort" data-breakpoints="all"><a class="dotted"
                                                                                   href=<?php echo "http://jjp2017.org/agent/openhouse/visitors.php?bedroomSort=" . updateSort($bedroomSort) ?> data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title="Approval Date">Bedroom(s)</a>
                                    </th>
                                    <th id="bathroomSort" data-breakpoints="all"><a class="dotted"
                                                                                    href=<?php echo "http://jjp2017.org/agent/openhouse/visitors.php?bathroomSort=" . updateSort($bathroomSort) ?> data-toggle="tooltip"
                                                                                    data-placement="top"
                                                                                    title="Approval Date">Bathroom(s)</a>
                                    <th data-breakpoints="all">Price</a>
                                    </th>
                                </tr>
                                </thead>

                                <?php
                                if($_GET['id'][0] == 'M')
                                    $addedHouses = "SELECT houseId FROM HouseInfo WHERE listingId = :listingId";
                                else
                                    $addedHouses = "SELECT houseId FROM HouseInfo WHERE houseId = :listingId";
                                $addedHouseParam = array();
                                $addedHouseParam[':listingId'] = $_GET['id'];

                                $addedHousesStmt = $dbConn->prepare($addedHouses);
                                $addedHousesStmt->execute($addedHouseParam);
                                $addedHouseResults = $addedHousesStmt->fetch();
                                /*function getHouseAddress($houseId){
                                    $dbConn = getConnection();
                                    $sql = "SELECT * FROM HouseInfo WHERE houseId = :houseId";
                                    $namedParameters = array();
                                    $namedParameters[':houseId'] = $houseId;
                                    $stmt = $dbConn -> prepare($sql);
                                    $stmt->execute($namedParameters);
                                    //$stmt->execute();
                                    $results = $stmt->fetch();
                                    return $results['address'] . ", " . $results['city'] . ", " . $results['state'] . " " . $results['zip'];
                                }*/
                                
                    //             $sql = "SELECT * FROM BuyerInfo, HouseInfo 
                    // WHERE BuyerInfo.userId = :userId 
                    // AND BuyerInfo.houseId = HouseInfo.houseId OR BuyerInfo.userId = :userId AND BuyerInfo.houseId = '0'
                    // ORDER BY ";
                                $sql = "SELECT BuyerInfo.*, HouseInfo.address as address, HouseInfo.city as city, HouseInfo.state as state, HouseInfo.zip as zip
                                FROM BuyerInfo LEFT JOIN HouseInfo ON BuyerInfo.houseId = HouseInfo.houseId 
                                where BuyerInfo.userId = :userId AND BuyerInfo.houseId = :houseId ORDER BY ";
                                if (isset($_GET['visitorSort'])) {
                                    if ($visitorSort == 1) {
                                        $sql .= "lastName ASC";
                                    } else {
                                        $sql .= "lastName DESC";
                                    }
                                } elseif (isset($_GET['emailSort'])) {
                                    if ($emailSort == 1) {
                                        $sql .= "email ASC";
                                    } else {
                                        $sql .= "email DESC";
                                    }
                                } elseif (isset($_GET['addressSort'])) {
                                    if ($addressSort == 1) {
                                        $sql .= "SUBSTR(LTRIM(address), LOCATE(' ', LTRIM(address))) ASC";
                                    } else {
                                        $sql .= "SUBSTR(LTRIM(address), LOCATE(' ', LTRIM(address))) DESC";
                                    }
                                } elseif (isset($_GET['bedroomSort'])) {
                                    if ($bedroomSort == 1) {
                                        $sql .= "bedroomsMin ASC";
                                    } else {
                                        $sql .= "bedroomsMin DESC";
                                    }
                                } elseif (isset($_GET['bathroomSort'])) {
                                    if ($bathroomSort == 1) {
                                        $sql .= "bathroomsMin ASC";
                                    } else {
                                        $sql .= "bathroomsMin DESC";
                                    }
                                } else {
                                    $sql .= "lastName ASC";
                                }

                                $namedParameters = array();
                                $namedParameters[':userId'] = $_SESSION['userId'];
                                $namedParameters[':houseId'] = $addedHouseResults['houseId'];
                                $stmt = $dbConn->prepare($sql);
                                $stmt->execute($namedParameters);
                                //$stmt->execute();
                                $results = $stmt->fetchAll();

                                foreach ($results as $result) {
                                    $dbNote = $result['note'];
                                    echo "<tbody>";
                                    if ($result['registeredDate'] == NULL)
                                        echo "<td>" . "</td>";
                                    else
                                        echo "<td>" . date("m-d-Y", strtotime($result['registeredDate'])) . "</td>";
                                    echo "<td>" . $result['firstName'] . " " . $result['lastName'] . "</td>";
                                    echo "<td>" . $result['phone'] . "</td>";
                                    echo "<td>" . htmlspecialchars($result['email']) . "</td>";
                                    if($result['address'] == "Lead")
                                    {
                                        echo "<td>" . htmlspecialchars($result['address']) . "</td>";

                                    }
                                    else
                                    {
                                        echo "<td>" . htmlspecialchars($result['address'] . ", " . $result['city'] . ", " . $result['state'] . " " . $result['zip']) . "</td>";
                                    }
                                    // <button>Call</button>
                                    echo "<td>" .

                                        // <button>Text</button>
                                        "<button onClick='openFlyerModal()'>Forward Flyer</button>
                    </td>
                    <td id='" . $result['buyerID'] . "'>" . $dbNote . "</td>
                    <td>";
                                    echo ' <button onClick=takeNote(' . $result['houseId'] . ',' . $result['buyerID'] . ')>Add/Edit</button>';
                                    // <button>Edit</button>
                                    echo "</td>
                    <td>";
                                    ?>
                                    <form onsubmit="return confirmDelete('<?= $result['firstName'] ?>')">
                                        <input type="hidden" name="buyerID" value="<?= $result['buyerID'] ?>"/>
                                        <button class='fa fa-trash-o' type="submit" name="deleteForm"/>
                                    </form>
                                    </td>
                                    <?php
                                    echo "<td>Min: " . $result['bedroomsMin'] . "</td>";//. " Max: " . $result['bedroomsMax'] . "</td>";
                                    echo "<td>Min: " . $result['bathroomsMin'] . "</td>";//. " Max: " . $result['bathroomsMax'] . "</td>";
                                    echo "<td>Min: " . $result['priceMin'] . " Max: " . $result['priceMax'] . "</td>";
                                    ?>
                                    </tbody>
                                    <?php
                                } //closes foreach
                                ?>


                            </table>
                       </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
                   
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Export Dates</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <span>Start Date:  </span><input id="startDate" type="date" data-date-inline-picker="false"
                                                     data-date-open-on-focus="true"/>
                </div>
                <div class="form-group">
                    <span>End Date:  </span><input id="endDate" type="date" data-date-inline-picker="false"
                                                   data-date-open-on-focus="true"/>
                </div>

                <!--  -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="downloadAllLeads">All Leads</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="downloadVisitors">Download</button>
                </button>
            </div>
        </div>

    </div>
</div>
        </div>
        <!-- /.wrapper -->
        </div>
        <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->


        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-agent/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-agent/default-js.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type='text/javascript'
        src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.0.3/jquery.floatThead.js"></script>

       
        <script>
            $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });

    });

    function takeNote(house, buyer) {
        var prevNote = $("#" + buyer).html();
        var noteEntered = prompt("Enter Note:", prevNote);
        if (noteEntered == null || noteEntered == "") {
        } else {
            $("#" + buyer).html(noteEntered);
            // alert(houseId + " " + buyerID);
            $.post("openhouse/saveNote.php", {
                houseId: house,
                buyerID: buyer,
                note: noteEntered
            });
        }
    }

    $('table').floatThead({
        position: 'absolute'
       
    });


    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('fa-plus fa-minus');

    }

    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

    function openFlyerModal() {
        $('#flyerModal').modal('toggle');
    }
    
       
       function leadModal()
       {
        $('#addLeadModal').modal('toggle');
       }


       function addLead()
       {
            var firstName = $('input[name=firstName]').val();
            var lastName = $('input[name=lastName]').val();
            var email = $('input[name=email]').val();
            var phone = $('input[name=phone]').val();
            var howSoon = $('select[name=howSoon]').val();
            var price = $('select[name=price]').val();
            var minBed = $('select[name=bedroomsMin]').val();
            var minBath = $('select[name=bathroomsMin]').val();
            // alert(firstName);
            // alert(lastName);
            // alert(email);
            // alert(phone);
            // alert(howSoon);
            // alert(price);
            // alert(minBed);
            // alert(minBath);
            // $('input[name=firstName]').val("");

            $.post( "addLead.php", { firstName: firstName, lastName: lastName, email: email, phone: phone, howSoon: howSoon, price: price, bedroomsMin: minBed, bathroomsMin: minBath})
            .done(function( data ) {
            alert("lead Added");
            $('input[name=firstName]').val("");
            $('input[name=lastName]').val("");
            $('input[name=email]').val("");
            $('input[name=phone]').val("");
            $('input[name=howSoon]').val("");
            $('input[name=price]').val("");
            $('input[name=bedroomsMin]').val("");
            $('input[name=bathroomsMin]').val("");
            $('#addLeadModal').modal('toggle');
            location.reload(true);
            });
            
       }

        </script>

<!-- Modal -->

    </body>

    </html>
