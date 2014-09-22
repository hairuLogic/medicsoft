<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Group Maintenance</title>
        <link rel="stylesheet" href="../css/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>  

        <script>
            var trowid,butCall;
            $(function(){
                $("#tableList").jqGrid({
                    url:'tableList/group.php',
                    datatype: "xml",
                    colModel:[
                        {label:'Group Id',name:'groupid',index:'groupid', width:100},
                        {label:'Description',name:'description',index:'description', width:300},  
                    ],
                    rowNum:100,

                    width: "80%",
                    viewrecords: true,
                    height: "450",
                    caption: "Main",
                    beforeSelectRow: function(rowid, e){
                        trowid=rowid;
                        var ret=$("#tableList").jqGrid('getRowData',rowid); 
                        $("#groupid").val(ret.groupid);
                        $("#description").val(ret.description);
                        $("#but_edit").prop("disabled",false);               
                        $("#but_delete").prop("disabled",false);               
                        $("#but_security").prop("disabled",false);    
                        return(true);            
                    }
                });

                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/group_maintenance_p.php',$('#formGroupMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tableList").jqGrid().trigger("reloadGrid");
                                    $( "#dialogForm" ).dialog("close");

                                    reset();
                                    if(butCall=="add"){
                                        setTimeout(function(){$("#tableList").jqGrid('setSelection',trowid);}, 500);
                                    }
                                    else{
                                        setTimeout(function(){$("#tableList").jqGrid('setSelection',$("#groupid").val());}, 500);
                                    }

                                }
                                else{
                                    alert($msg)
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });

                $( "#dialogAlert" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $.post('process/group_maintenance_p.php',$('#formGroupMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tableList").jqGrid().trigger("reloadGrid");
                                    $("#dialogAlert").dialog("close"); 
                                }
                                else{
                                    alert($msg);
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });

                $( "#but_add" ).click(function() {
                    $("#tableList").trigger("reloadGrid");
                    reset();
                    $('.iForm').val('');
                    $('#opStatus').val("insert");
                    $( "#dialogForm" ).dialog( "open" );
                });

                $( "#but_edit" ).click(function() {
                    $("#opStatus").val("update");
                    $("#dialogForm").dialog( "open" );
                });

                $( "#but_delete" ).click(function() {
                    reset();
                    $("#tableList").trigger("reloadGrid");
                    $("#opStatus").val("delete");
                    $('#dialogText').text("Delete this item?");
                    $( "#dialogAlert" ).dialog( "open" );
                });

                $("#but_security").click(function(){
                    myWin=window.open("/medicsoft/setup/groupaccess_maintenance.php?groupid="+$("#groupid").val(),$("#groupid").val());
                })
            })

            function newPopup() {
                myWindow=window.open("/medicsoft/setup/groupaccess_maintenance.php?groupid="+$("#groupid").val(),$("#groupid").val());
            }
            function reset(){
                $("#but_edit").prop("disabled",true);               
                $("#but_delete").prop("disabled",true);               
                $("#but_security").prop("disabled",true); 
            }
        </script>
    </head>

    <body>
        <?php include("../include/headerf.php")?>   
        <?php include("../include/start.php")?>               
        <div class="content-header">
            <div class="header-inner">
                <h2 id="content-main-heading" class="title">Group Maintenance</h2>
                <div class="rfloat specfloat">
                    <i class="topbar-divider"></i>
                    <button id="but_add" class="button" title="Add">
                        <i id="addIcon" class="iconButton"></i>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_edit" class="button" title="Edit" disabled="true">
                        <i id="editIcon" class="iconButton"></i>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_delete" class="button" title="Delete" disabled="true">
                        <i id="deleteIcon" class="iconButton"></i>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_security" class="button" title="Set Security" disabled="true">
                        <i id="securityIcon" class="iconButton"></i>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_refresh" class="button" title="Refresh Data">
                        <i id="refreshIcon" class="iconButton"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="body-inner">
                <div id="tdTree" >
                    <table id="tableList"> </table>    
                    <div id="tablePager"></div>
                </div>
            </div>
        </div>
        <?php include("../include/end.php")?>
        <div id="dialogForm" title="Create new item">
            <div class="sideleft" width='200px'>
                <div class="bodydiv">
                    <form id="formGroupMaintain">
                        <table>
                            <tr>
                                <td><label for="groupid">Group Id</label></td>
                                <td>  <input type="text" name="groupid" class="iForm" id="groupid"></td>
                            </tr>
                            <tr>
                                <td><label for="description">Description</label></td>
                                <td><input type="text" name="description" class="iForm" id="description"></td>
                            </tr>
                            <tr >
                                <td style="display:none">
                                    <input type="text" name="opStatus" id="opStatus">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="dialogAlert" title="Alert">
            <p id="dialogText"></p>
        </div>
    </body>
</html>