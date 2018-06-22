<?php
$currAgent = "SELECT * FROM UsersInfo WHERE userId = '" . $_SESSION['userId'] . "'";
$email = $dbConn->prepare($currAgent);
$email->execute();
$agentInfo = $email->fetch();


$activePage = basename($_SERVER['PHP_SELF'], ".php");

?>
<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php
            if ($_SESSION['userId'] == "34" || $_SESSION['userId'] == "100" ) //Jorge
            {
                $_SESSION['userId'] = "100";
                $_SESSION['userType'] = "0";
                echo "<a href=\"agent/index.php\" style=\"margin-top: 8px; margin-left: 10px\" class=\"btn
                btn-admin\">Switch to Agent</a>";
            }
            else if($_SESSION['userId'] == "37" || $_SESSION['userId'] == "101") //Juan
            {
                $_SESSION['userId'] = "101";
                $_SESSION['userType'] = "0";
                echo "<a href=\"agent/index.php\" style=\"margin-top: 8px; margin-left: 10px\" class=\"btn
                btn-admin\">Switch to Agent</a>";
            }
        ?>
        

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo $agentInfo['firstName'] . " " . $agentInfo['lastName'] . " #" . $agentInfo['license'];?></span> </a>
                    <ul class="dropdown-menu">
                        <!-- User image in the menu -->
                        <li class="user-header"><img src=<?php if(isset($agentInfo['picture']))
                                                                    echo "agent/agentPictures/". $agentInfo['picture']; 
                                                                else
                                                                    echo "dist/img/user2-160x160.jpg"; ?> class="img-circle" alt="User Image">
                            <p> <?=$_SESSION['username'];?>
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                      
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left"><a href="#" class="btn btn-default btn-flat">Profile</a></div>
                            <div class="pull-right"><a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
            </ul>
        </div>
    </nav>
</header>
