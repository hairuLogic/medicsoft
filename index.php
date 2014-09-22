<?php 
    include_once('sschecker.php');
?>
<!doctype html>
<html>
    <head>
    	
        <meta charset="utf-8">
        <title>Home</title>
        
        <script src="script/jquery-1.8.3.js"></script>
        <script src="script/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link href="style_main.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="/medicsoft/script/date_time.js"></script>
    </head>

    <body>
        <div id="barHolder" class="slim">
            <div id="bar" class="fixed">
                <div id="pageHeader" class="clearfix" role="banner">
                    <h1 id="compLogo">
                        <a <?php echo "style='background-image: url(".$_SESSION['logo1'].");background-repeat: no-repeat;width:".$_SESSION['logo1width']."'"?>><?php echo $_SESSION['company'] ?></a>
                    </h1>
                    <div id="headNav" class="clearfix">
                        <div class="rfloat">
                            <div id="userNav" class="clearfix">
                                <h4 class="navItem"><?php echo ucfirst($_SESSION['username'])?></h4>
                            </div>
                            <i class="topbar-divider"></i>
                            <div id="logoutNav" class="clearfix">
                                <button id="logoutButton" title="Logout" onclick="parent.location='logout.php'">
                                    <i id="logoutIcon"></i>
                                </button>

                            </div>
                            <i class="topbar-divider"></i>
                            <span id="date_time"></span>
                            <script type="text/javascript">window.onload = date_time('date_time');</script>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <div id="page-outer">
            <div id="page-container" class="wrapper wrapper-home white">

                <div class="panelIndex">
                    <?php
                        include($_SERVER['DOCUMENT_ROOT'] . '/medicsoft/nav/nav_menuNorm.php')
                    ?> 
                </div>
            </div>
            <div role="main" class="content-main-home" id="timeline" >
                <!--<div class="content-header">
                <div class="header-inner">
                <h2 id="content-main-heading" class="title">Timeline</h2>
                </div>
                </div>-->
                <div class="stream-container" <?php echo "style='background: url(".$_SESSION['bgpic'].");background-repeat: no-repeat;'"?>>
                    <div class="stream">

                    </div>
                </div>
                <div class="footer">
                    <h3>
                        © Medicsoft Sdn. Bhd.
                    </h3>
                </div>

            </div>

        </div>

    </body>
</html>