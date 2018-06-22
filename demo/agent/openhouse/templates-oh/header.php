<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style is in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i> <span
                                class="label label-success">4</span> </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- Inner message menu -->
                            <ul class="menu">
                                <li>
                                    <!-- Start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <!-- User Image --><img src=<?php echo "\"" . $agentInfo['picture'] . "\""; ?> 
                                                                    class="img-circle" alt="User Image" style=""></div>
                                        <!-- Message title and timestamp -->
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- Message content -->
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- End message -->
                            </ul>
                            <!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- /.messages-menu -->
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> <span
                                class="label label-warning">10</span> </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- Inner nofications menu -->
                            <ul class="menu">
                                <li>
                                    <!-- Start notification -->
                                    <a href="#"> <i class="fa fa-users text-aqua"></i> 5 new members joined today </a>
                                </li>
                                <!-- End notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-flag-o"></i> <span
                                class="label label-danger">9</span> </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- Inner tasks menu -->
                            <ul class="menu">
                                <li>
                                    <!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- Progress bar -->
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100"><span class="sr-only">20% Complete</span></div>
                                        </div>
                                    </a>
                                </li>
                                <!-- End task item -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all tasks</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- User image in navbar--><img src="../../dist/img/user2-160x160.jpg" class="user-image"
                                                         alt="User Image"> <span class="hidden-xs">Agent</span> </a>
                    <ul class="dropdown-menu">
                        <!-- User image in the menu -->
                        <li class="user-header"><img src=<?php if(!isset($agentInfo['picture']))
                                                                    echo "\"". $agentInfo['picture'] . "\""; 
                                                                else
                                                                    echo "../../dist/img/user2-160x160.jpg"; ?>  class="img-circle"
                                                     alt="User Image">
                            <p> Agent
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center"><a href="#">Followers</a></div>
                                <div class="col-xs-4 text-center"><a href="#">Sales</a></div>
                                <div class="col-xs-4 text-center"><a href="#">Friends</a></div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left"><a href="#" class="btn btn-default btn-flat">Profile</a></div>
                            <div class="pull-right"><a href="../logout.php" class="btn btn-default btn-flat">Sign
                                    out</a></div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
            </ul>
        </div>
    </nav>
</header>
