<link href="../../styleH.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../script/date_time.js"></script>

<script>
    $(document).ready(function(){
        $(".trigger").click(function(){
            $(".panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
        });
        $( "#dialogLogout" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            parent.location='../../logout.php';
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                $("#logoutButton").click(function(){
                    $( "#dialogLogout" ).dialog( "open" );
                });
    });
</script> 

<div id="barHolder" class="slim">
    <div id="bar" class="fixed">
        <div id="pageHeader" class="clearfix" role="banner">
            <h1 id="compLogo">
                <a title="Home" <?php echo "style='background-image: url(\"".$_SESSION['logo1']."\");background-repeat: no-repeat;width:".$_SESSION['logo1width']."'"?> href="../../index.php"><?php echo $_SESSION['company'] ?></a>
            </h1>
            <div id="headNav" class="clearfix">
                <div class="rfloat">
                    <div id="userNav" class="clearfix">
                        <h4 class="navItem"><?php echo ucfirst($_SESSION['username'])?></h4>
                    </div>
                    <i class="topbar-divider"></i>
                    <div id="logoutNav" class="clearfix">
                        <button id="logoutButton" title="Logout" >
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

 
<div class="panel">
    <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/medicsoft/nav/nav_menuNorm.php')
    ?> 
</div>
<div style="clear:both;"></div>

</div>
<a class="trigger" href="#">Menu</a>
<div id="dialogLogout" title="Alert">
            <p>Are you sure to Logout?</p>
        </div>