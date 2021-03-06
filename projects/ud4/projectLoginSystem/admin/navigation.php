<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $applicationUrl; ?>admin/index.php">Admin</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php echo $page_title == "Admin Index" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $applicationUrl; ?>admin/index.php">Home</a>
                </li>
                <li <?php
                echo $page_title == "Users" ? "class='active'" : ""; ?> >
                    <a href="<?php echo $applicationUrl; ?>admin/read_users.php">Users</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        <?php echo $_SESSION['name']; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo $applicationUrl; ?>logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /navbar -->