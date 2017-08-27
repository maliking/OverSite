<?php
    require("../databaseConnection.php");  
    session_start();
    $dbConn = getConnection();
    if (!isset($_SESSION['userId'])) {
        header("Location: http://jjp2017.org/login.php");
    }

    if (isset ($_GET['deleteForm'])){  //checking whether we have clicked on the "Delete" button
        $sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = '".$_GET['buyerID']."'";
        $stmt = $dbConn -> prepare($sql);
        $stmt->execute();

    }
?>




    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | My Visitors</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-oh/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
    </head>

    <body class="hold-transition skin-black sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">
            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-oh/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-oh/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3>My Visitors</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Visitors</th>

                                                <th data-breakpoints="all">Phone Number</th>
                                                <th data-breakpoints="all">Email</th>


                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Approval Date">Address Visited </a></th>

                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Contact </a></th>
                                                <th data-breakpoints="all">Notes</th>

                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Notes</a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Delete</a></th>
                                                <th data-breakpoints="all">Bedroom(s)</a>
                                                </th>
                                                <th data-breakpoints="all">Bathroom(s)</a>
                                                </th>
                                                <th data-breakpoints="all">Price</a>
                                                </th>
                                            </tr>
                                        </thead>

                                        <?php

            function getHouseAddress($houseId){
                $dbConn = getConnection();
                $sql = "SELECT * FROM HouseInfo WHERE houseId = :houseId";
                $namedParameters = array();
                $namedParameters[':houseId'] = $houseId;
                $stmt = $dbConn -> prepare($sql);
                $stmt->execute($namedParameters);
                //$stmt->execute();
                $results = $stmt->fetch();
                return $results['address'] . ", " . $results['city'] . ", " . $results['state'] . " " . $results['zip'];

            }
            $dbConn = getConnection();
            $sql = "SELECT * FROM BuyerInfo WHERE userId = :userId";
            $namedParameters = array();
            $namedParameters[':userId'] = $_SESSION['userId'];
            $stmt = $dbConn -> prepare($sql);
            $stmt->execute($namedParameters);
            //$stmt->execute();
            $results = $stmt->fetchAll();

            foreach($results as $result){
                $dbNote = $result['note'];
                echo "<tbody>";
                echo "<td>" . $result['firstName'] . " " . $result['lastName'] . "</td>";
                echo "<td>" . $result['phone'] . "</td>";
                echo "<td>" . htmlspecialchars($result['email']) . "</td>";
                echo "<td>" . htmlspecialchars(getHouseAddress($result['houseId'])) . "</td>";
                echo "<td>
                        <button>Call</button>
                        <button>Text</button>
                        <button>Forward Listing Flyer</button>
                    </td>
                    <td id='". $result['buyerID'] ."'>" . $dbNote . "</td>
                    <td>";
                echo ' <button onClick=takeNote(' . $result['houseId'] . ',' . $result['buyerID'] . ')>Add</button>';
                echo " <button>Edit</button>

                    </td>
                    <td>";
        ?>
                                            <form onsubmit="return confirmDelete('<?=$result['firstName']?>')">
                                                <input type="hidden" name="buyerID" value="<?=$result['buyerID']?>" />
                                                <button class='fa fa-trash-o' type="submit" name="deleteForm" />
                                            </form>
                                            </td>
                                            <?php
                    echo "<td>Min: " . $result['bedroomsMin'] . " Max: " . $result['bedroomsMax'] . "</td>";
                    echo "<td>Min: " . $result['bathroomsMin'] . " Max: " . $result['bathroomsMax'] . "</td>";
                    echo "<td>Min: " . $result['priceMin'] . " Max: " . $result['priceMax'] . "</td>";
                ?>
                                                </tbody>
                                                <?php    
               } //closes foreach 
             ?>
                                                <tbody>
                                                    <td>Patty Hershang</td>
                                                    <td>831-382-4833</td>
                                                    <td>phershang@gmail.com</td>
                                                    <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->

                                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                                    <td>
                                                        <button>Call</button>
                                                        <button>Text</button>
                                                        <button>Forward Listing Flyer</button>
                                                    </td>
                                                    <td><button>View</button></td>
                                                    <td>
                                                        <button>Add</button>
                                                        <button>Edit</button>

                                                    </td>
                                                    <td>
                                                        <button class="fa fa-trash-o">  </button>



                                                </tbody>
                                                <tbody>


                                                    <td>Peter Harris</td>
                                                    <td>831-239-6289</td>
                                                    <td>pharris23@gmail.com</td>
                                                    <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->



                                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                                    <td>
                                                        <button>Call</button>
                                                        <button>Text</button>
                                                        <button>Forward Listing Flyer</button>
                                                    </td>
                                                    <td> <button>View</button></td>
                                                    <td>
                                                        <button>Add</button>
                                                        <button>Edit</button>

                                                    </td>
                                                    <td>
                                                        <button class="fa fa-trash-o">  </button>



                                                </tbody>
                                                <tbody>



                                                    <td>Tony Craver</td>
                                                    <td>831-588-0444</td>
                                                    <td>tcraver@yahoo.com</td>
                                                    <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->



                                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                                    <td>
                                                        <button>Call</button>
                                                        <button>Text</button>
                                                        <button>Forward Listing Flyer</button>
                                                    </td>
                                                    <td><button>View</button></td>
                                                    <td>
                                                        <button>Add</button>
                                                        <button>Edit</button>

                                                    </td>
                                                    <td>
                                                        <button class="fa fa-trash-o">  </button>



                                                </tbody> -->
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </div>
        </div>
        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-oh/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-oh/default-js.php" ?>
        <!-- END TEMPLATE default-js.php INCLUDE -->

        <script>
            $(document).ready(function() {
                $('[data-toggle="popover"]').popover({
                    html: true
                });
            });

            function takeNote(house, buyer) {
                var prevNote = $("#" + buyer + "-detail").html();
                var noteEntered = prompt("Enter Note:", prevNote);
                if (noteEntered == null || noteEntered == "") {

                } else {
                    $("#" + buyer + "-detail").html(noteEntered);
                    // alert(houseId + " " + buyerID);
                    $.post("saveNote.php", {
                        houseId: house,
                        buyerID: buyer,
                        note: noteEntered
                    });


                }
            }

        </script>

    </body>

    </html>
