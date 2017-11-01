<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT username FROM  UsersInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Re/Max Salinas | Roster</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-admin/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-admin/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Agent Roster
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-archive"></i> Current Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body no-padding">
                            <table id="roster-table" class="table" data-editing-always-show="true">


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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->
<div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">
    <style scoped>
        /* provides a red astrix to denote required fields - this should be included in common stylesheet */
        .form-group.required .control-label:after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
    <div class="modal-dialog" role="document">
        <form class="modal-content form-horizontal" id="editor" action="agent-roster.php" method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="editor-title">Add A New Agent</h4>
            </div>
            <div class="modal-body">
                <input type="number" id="id" name="id" class="hidden"/>
                <input type="hidden" id="userId" name="id" class="hidden"/>

                <div class="form-group required">
                    <label for="license" class="col-sm-3 control-label">License</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="license" name="license" placeholder=""
                               onchange="getLicense()" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="firstName" class="col-sm-3 control-label">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name"
                               required readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name"
                               required readonly>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="firstName" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                               required>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="firstName" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password"
                               required>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="firstName" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Phone Number</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="XXX-XXX-XXXX">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Issued License Date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="issuedDate" name="issuedDate" placeholder=""
                               readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">License Expiration Date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="expirationDate" name="expirationDate" placeholder=""
                               readonly>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Save changes">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>


<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="./dist/js/vendor/footable.min.js"></script>

<script>

    jQuery(function ($) {

        var $modal = $('#editor-modal'),
            $editor = $('#editor'),
            $editorTitle = $('#editor-title');



        $('.table').footable({
            "columns": $.ajax('columns.json', {dataType: 'json'}),
            "rows": $.ajax('getAgentRosterRows.php', {dataType: 'json'}),
            "filtering": {
                "enabled": true
            },
            "sorting": {
                "enabled": true
            },
            "paging": {
                "enabled": true
            },
            "editing": {
                "enabled": true,
                "addRow": function () {
                    $modal.removeData('row');
                    $editor[0].reset();
                    $editorTitle.text('Add a New Agent');
                    $modal.modal('show');
                },
                "editRow": function (row) {
                    var values = row.val();
                    $editor.find('#firstName').val(values.firstName);
                    $editor.find('#lastName').val(values.lastName);
                    $editor.find('#phone').val(values.phone);
                    $editor.find('#userId').val(values.userId);

                    $editor.find('#license').val(values.license);
                    $editor.find('#username').val(values.username);
                    $editor.find('#email').val(values.email);

                    $modal.data('row', row);
                    $editorTitle.text('Edit ' + values.firstName + " " + values.lastName);
                    $modal.modal('show');
                },
                "deleteRow": function (row) {
                    var values = row.val();
                    if (confirm('Are you sure you want to delete agent ' + values.firstName + " " + values.lastName + '?')) {
                        $.post("AgentRosterFunction.php", {userId: values.userId, function: "delete"});
                        row.delete();
                    }
                }
            }
        }), // table.footable

        uid = 10;
        $editor.on('submit', function (e) {
            if (this.checkValidity && !this.checkValidity()) return;
            e.preventDefault();


            var row = $modal.data('row'),
                values = {
                    license: $editor.find('#license').val(),
                    userId: $editor.find('#userId').val(),
                    firstName: $editor.find('#firstName').val(),
                    lastName: $editor.find('#lastName').val(),
                    username: $editor.find('#username').val(),
                    password: $editor.find('#password').val(),
                    email: $editor.find('#email').val(),
                    phone: $editor.find('#phone').val(),

                };

            var editValues = JSON.stringify(values);
            editValues = JSON.parse(editValues);


            if (row instanceof FooTable.Row) {
                $.post("AgentRosterFunction.php", {
                    userId: editValues.userId,
                    license: editValues.license,
                    firstName: editValues.firstName,
                    lastName: editValues.lastName,
                    username: editValues.username,
                    email: editValues.email,
                    phone: editValues.phone,
                    function: "edit"
                });
                row.val(values);
            } else {
                $.post("AgentRosterFunction.php", {
                    userId: editValues.userId,
                    license: editValues.license,
                    firstName: editValues.firstName,
                    lastName: editValues.lastName,
                    username: editValues.username,
                    password: editValues.password,
                    
                    phone: editValues.phone,
                    function: "add"
                });
                $.post("emailNewAgent.php", {
                    username: editValues.username,
                    email: editValues.email,
                    password: editValues.password
                });
                values.id = uid++;
                ft.rows.add(values);
            }
            $modal.modal('hide');
            $(".modal-content form-horizontal").hide();
        });
    }); // jquery



//
//
//    var $modal = $('#editor-modal'),
//        $editor = $('#editor'),
//        $editorTitle = $('#editor-title'),
//        ft = FooTable.init('#roster-table', {
//            "columns": $.ajax('columns.json', {dataType: 'json'}),
//            "rows": $.ajax('getAgentRosterRows.php', {dataType: 'json'}),
//            "filtering": {
//                "enabled": true
//            },
//            "sorting": {
//                "enabled": true
//            },
//            editing: {
//                enabled: true,
//                addRow: function () {
//                    $modal.removeData('row');
//                    $editor[0].reset();
//                    $editorTitle.text('Add a New Agent');
//                    $modal.modal('show');
//                },
//                editRow: function (row) {
//                    var values = row.val();
//                    $editor.find('#firstName').val(values.firstName);
//                    $editor.find('#lastName').val(values.lastName);
//                    $editor.find('#phone').val(values.phone);
//                    $editor.find('#userId').val(values.userId);
//
//                    $editor.find('#license').val(values.license);
//                    $editor.find('#username').val(values.username);
//                    $editor.find('#email').val(values.email);
//
//                    $modal.data('row', row);
//                    $editorTitle.text('Edit ' + values.firstName + " " + values.lastName);
//                    $modal.modal('show');
//                },
//                deleteRow: function (row) {
//                    var values = row.val();
//                    if (confirm('Are you sure you want to delete agent ' + values.firstName + " " + values.lastName + '?')) {
//                        $.post("AgentRosterFunction.php", {userId: values.userId, function: "delete"});
//                        row.delete();
//                    }
//
//                }
//            }
//        }),
//        uid = 10;
//
//    $editor.on('submit', function (e) {
//        if (this.checkValidity && !this.checkValidity()) return;
//        e.preventDefault();
//        var row = $modal.data('row'),
//            values = {
//                license: $editor.find('#license').val(),
//                userId: $editor.find('#userId').val(),
//                firstName: $editor.find('#firstName').val(),
//                lastName: $editor.find('#lastName').val(),
//                username: $editor.find('#username').val(),
//                password: $editor.find('#password').val(),
//                email: $editor.find('#email').val(),
//                phone: $editor.find('#phone').val(),
//
//            };
//        var editValues = JSON.stringify(values);
//        editValues = JSON.parse(editValues);
//        if (row instanceof FooTable.Row) {
//            $.post("AgentRosterFunction.php", {
//                userId: editValues.userId,
//                license: editValues.license,
//                firstName: editValues.firstName,
//                lastName: editValues.lastName,
//                username: editValues.username,
//                email: editValues.email,
//                phone: editValues.phone,
//                function: "edit"
//            });
//            row.val(values);
//        } else {
//            $.post("AgentRosterFunction.php", {
//                userId: editValues.userId,
//                license: editValues.license,
//                firstName: editValues.firstName,
//                lastName: editValues.lastName,
//                username: editValues.username,
//                password: editValues.password,
//                email: editValues.email,
//                phone: editValues.phone,
//                function: "add"
//            });
//            values.id = uid++;
//            ft.rows.add(values);
//        }
//        $modal.modal('hide');
//    });

    //generate random password
    function generatePassword() {
        var length = 6,
            characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",
            password = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            password += charset.charAt(Math.floor(Math.random() * n));
        }
        return password;
    }

    function getLicense() {
        lic = document.getElementById("license").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(xhr.responseText);
                xhr.abort();
                //console.log(response.name);
                // var firstN = response.name.split(" ");
                // var cleanlastN = firstN[0].split(",");

                // document.getElementById("firstName").value = firstN[1];
                // document.getElementById("lastName").value = cleanlastN[0];
                var dateIssued = response.lic;
                var dateExpire = response.expirationDate;
                var dateExpireSplit = dateExpire.split("/");
                var dateExpireFormat = "20" + dateExpireSplit[2] + "-" + dateExpireSplit[0] + "-" + dateExpireSplit[1];
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                if (Date.parse(dateExpireFormat) <= today) {
                    alert("Invalid license");
                }
                else {
                    alert("Valid license");
                }
                var firstName = response.name.split(",");
                document.getElementById("firstName").value = firstName[1];
                document.getElementById("lastName").value = firstName[0];
                document.getElementById("issuedDate").value = dateIssued;
                document.getElementById("expirationDate").value = dateExpire;

                //check if username is already taken
                document.getElementById("username").value =  firstName[0].substring(0, 1) + firstName[0].substring(0, 4);
                document.getElementById("password").value = generatePassword();
            }

        }
        xhr.open("GET", "scriptToGetAgentInfo.php?license=" + lic, true);
        xhr.send();
    }
</script>
</body>

</html>
