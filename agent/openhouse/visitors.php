<?php
require("../../databaseConnection.php");
session_start();
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
if (isset ($_GET['deleteForm'])) {  //checking whether we have clicked on the "Delete" button
    $sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = '" . $_GET['buyerID'] . "'";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
}

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
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | My Visitors</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-oh/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <style>
        thead {
            background-color: white;
        }

        .panel-heading:hover {
            background-color: rgba(192, 192, 192, 0.5);
        }

    </style>


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
        <section class="content-header">
            <h1>
                My Visitors
            </h1>
        </section>


        <!-- Mock add notes Modal -->
        <div class="modal fade" id="addNotesModal" data-backdrop="static" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Name</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="modal-body">

                        <!-- textarea -->
                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <!-- End Modal -->

        <!--        -----Mock text modal            -->

        <div class="modal fade" id="textModal" data-backdrop="static" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Text Visitor</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="modal-body">

                        <!-- textarea -->
                        <div class="form-group">
                            <label>Message to visitor:</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Send</button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <!--        -----END Mock text modal            -->


        <!-- ---------Mock Send Flyer Modal-->


        <div class="modal fade" id="flyerModal" data-backdrop="static" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Forward [Visitor Name] a flyer!</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <input type="checkbox"> <img src="../openhouse/listingImg/flyerPlaceHolder.png"
                                                             style="width:200px; height: 250px;"></input>
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox"> <img src="../openhouse/listingImg/flyerPlaceHolder.png"
                                                             style="width:200px; height: 250px;"></input>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="checkbox"> <img src="../openhouse/listingImg/flyerPlaceHolder.png"
                                                             style="width:200px; height: 250px;"></input>
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox"> <img src="../openhouse/listingImg/flyerPlaceHolder.png"
                                                             style="width:200px; height: 250px;"></input>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Input additional note to visitor</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Send Flyer</button>

                    </div>

                </div>

            </div>
        </div>


        <!--   ------------ END Mock flyer modal-->

        <section class="content">
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
                        <div class="box-body">
                            <table class="table table-bordered table-striped" id="freeze">
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
                                $dbConn = getConnection();
                                $sql = "SELECT * FROM BuyerInfo, HouseInfo 
                    WHERE BuyerInfo.userId = :userId 
                    AND BuyerInfo.houseId = HouseInfo.houseId
                    ORDER BY ";
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
                                    echo "<td>" . htmlspecialchars($result['address'] . ", " . $result['city'] . ", " . $result['state'] . " " . $result['zip']) . "</td>";

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
            <!-- /.row -->
        </section>
    </div>
</div>

<!-- <script type="text/javascript">
 $('#visitorSort').click(function(){
       $.ajax({
         method: "GET",
         url: "http://jjp2017.org/agent/openhouse/visitors.php",
         data: { visitorSort: this.value}
         })
     });

 </script>-->


<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-oh/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-oh/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!--Links from old visitors page-->
<!-- Slimscroll -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Footable -->
<script type="text/javascript" src="../../plugins/footable/js/footable.min.js"></script>
<!--end links from old visitors page-->
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
            $.post("saveNote.php", {
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

</script>

</body>

</html>
