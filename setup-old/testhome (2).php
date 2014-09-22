<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/ui-lightness/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>

        <script>
        </script>
    </head>

    <body>
        <div id="header">
            <div id="logo">
                <a href="http://www.medicsoftware.com.my"><img src="../img/icon/logo.png" alt="MedicSoftware Sdn Bhd"></a>
            </div>
        </div>
        <table width="85%" align="center">
            <tr>
                <td width="250" align="left" class="menu"  style=" height: 650px; overflow-y: scroll">
                    <?php
                        include('../nav/nav_menuTab.php')
                    ?>                  
                </td>
                <td >
					<?php
						include('group_maintenance.php')
					?>
                </td>
            </tr>

        </table>
        
</html>