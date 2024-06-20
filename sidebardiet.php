<?php
// Start the session
session_start();
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <?php if ($_SESSION['level'] == 'Admin') { ?>
                            <img alt="image" class="img-circle" src="img/admin.png" width="100" height="100" />
                        <?php } ?>

                        <?php if ($_SESSION['level'] == 'User') { ?>
                            <img alt="image" class="img-circle" src="img/user.png" width="100" height="100" />
                        <?php } ?>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold"><?php echo $_SESSION['username'] ?></strong>
                            </span>
                            <span class="text-muted text-xs block" style="margin-top: 5px;"><?php echo $_SESSION['level'] ?><b class="caret"></b></span>
                        </span>

                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="logininspinia.php">Logout</a></li>
                    </ul>
                </div>

                <div class="logo-element">

                </div>
            </li>
            <?php if ($_SESSION['level'] == 'Admin') { ?>
                <li>
                    <a href="dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li>
                    <a href="listfood.php"><i class="fa fa-list"></i> <span class="nav-label">Food List</span></a>
                </li>
                <li>
                    <a href="listexercises.php"><i class="fa fa-list"></i> <span class="nav-label">Exercises List</span></a>
                </li>
            <?php } ?>

            <?php if ($_SESSION['level'] == 'User') { ?>
                <li>
                    <a href="dashboard.php"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li>
                    <a href="calculator.php"><i class="fa fa-calculator"></i> <span class="nav-label">Kalkulator</span></a>
                </li>
                <li>
                    <a href="konsultasi.php"><i class="fa fa-comments"></i> <span class="nav-label">Diskusi</span></a>
                </li>
                <li>
                    <a href="profil.php"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>