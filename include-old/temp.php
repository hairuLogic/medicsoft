<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>    
        <script src="../script/jquery-1.8.3.js"></script>               
    </head>

    <body>
        <?php include("../include/header.php")?>
        <?php include("../include/start.php")?>
            <div class="content-header">
                <div class="header-inner">
                    <h2 id="content-main-heading" class="title">Timeline</h2>
                    <div class="rfloat specfloat">
                    <i class="topbar-divider"></i>
                    	<button id="addButton" class="button" title="Add">
                        	<i id="addIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="editButton" class="button" title="Edit">
                        	<i id="editIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="saveButton" class="button" title="Save">
                        	<i id="saveIcon"></i>
                        </button>
                         <i class="topbar-divider"></i>
                        <button id="deleteButton" class="button" title="Delete">
                        	<i id="deleteIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="cancelButton" class="button" title="Cancel">
                        	<i id="cancelIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="securityButton" class="button" title="Security">
                        	<i id="securityIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="viewButton" class="button" title="View">
                        	<i id="viewIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="refreshButton" class="button" title="Refresh Data">
                        	<i id="refreshIcon"></i>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="closeButton" class="button" title="Close">
                        	<i id="closeIcon"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="body-inner">
                    
                </div>
            </div>
		<?php include("../include/end.php")?>
    </body>
</html>