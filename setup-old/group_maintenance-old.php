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
                    newPopup();
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
        <table width="100%" border="1px solid" align="center">
            <tr>
                <td class="menu" align="right">
                    <button type="button" class="but_add" id="but_add" >
                        <img src="../img/icon/but_add.png"/>
                    </button>
                    <button type="button" class="but_edit" id="but_edit" disabled="true">
                        <img src="../img/icon/but_edit.png"/>
                    </button>
                    <button type="button" class="but_delete" id="but_delete" disabled="true">
                        <img src="../img/icon/but_delete.png"/>
                    </button>
                    <button type="button" class="but_save" id="but_save" disabled="true">
                        <img src="../img/icon/but_save.png"/>
                    </button>
                    <button type="button" class="but_security" id="but_security" disabled="true">
                        <img src="../img/icon/but_security.png"/>
                    </button>
                    <button type="button" class="but_refresh" id="but_refresh" >
                        <img src="../img/icon/but_refresh.png"/>
                    </button>  

                </td>
            </tr>
            <tr >
                <td id="tdTree" align="center" height="550px">
                    <div >
                        <table id="tableList"> </table>    
                        <div id="tablePager"></div>
                    </div>

                </td>
            </tr>
        </table>
        <div id="dialogForm" title="Create new item">
            <div class="sideleft" width='200px'>
                <div class="smalltitle"></div>
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