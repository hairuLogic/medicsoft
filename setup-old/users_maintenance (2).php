<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>User Maintenance</title>
        <link rel="stylesheet" href="../css/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>  
        <script>
            var trowid;
            var groupid;
            $(function(){
                $("#tableList").jqGrid({
                    url:'tableList/users.php',
                    datatype: "xml",
                    colModel:[
                        {label:'Username',name:'username',index:'username',width:70},
                        {label:'Name',name:'name',index:'name',width:200},
                        {label:'Group',name:'groupid',index:'groupid',width:90}, 
                        {label:'Department',name:'deptcode',index:'deptcode',width:100}, 
                        {label:'Cashier',name:'cashier',index:'cashier',width:60},   
                        {label:'PriceView',name:'priceview',index:'priceview',width:70},   
                        {label:'programmenu',name:'programmenu',index:'programmenu',width:50,hidden:true}  ,
                        {label:'password',name:'password',index:'password',width:50,hidden:true}  
                    ],
                    rowNum:100,

                    width: "80%",
                    viewrecords: true,
                    height: "450",
                    caption: "Users List",
                    onSelectRow : function(rowid, e){
                        trowid=rowid;
                        var ret=$("#tableList").jqGrid('getRowData',rowid);
                        $("#username").val(ret.username);
                        $("#name").val(ret.name);
                        $("#password").val(ret.password);
                        $("#groupid").val(ret.groupid);
                        $("#programmenu").val(ret.programmenu);
                        $("#deptcode").val(ret.deptcode);
                        $("#cashier").val(ret.cashier);
                        $("#priceview").val(ret.priceview);
                        $("#but_edit").prop("disabled",false);   
                        $("#but_delete").prop("disabled",false);   
                        return(true);            
                    }
                });

                $("#groupList").jqGrid({
                    url:'tableList/group.php',
                    datatype: "xml",
                    colModel:[
                        {label:'Group Id',name:'groupid',index:'groupid', width:100},
                        {label:'Description',name:'description',index:'description', width:270},  
                    ],
                    rowNum:100,
                    viewrecords: true,
                    height: "150",
                    caption: "Group",
                    beforeSelectRow: function(rowid, e){      
                        var ret=$("#tableList").jqGrid('getRowData',rowid);   
                        groupid=rowid;
                        return(true); 
                    }
                });

                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    width: 750,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/users_maintenance_p.php',$('#formUsersMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tableList").jqGrid().trigger("reloadGrid");
                                    $("#dialogForm").dialog("close");
                                    setTimeout(function(){$("#tableList").jqGrid('setSelection',$("#username").val());}, 500); 
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

                $( "#dialogAlert" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $.post('process/users_maintenance_p.php',$('#formUsersMaintain').serialize(),function(data){
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

                $( "#dialogList" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $("#groupid").val(groupid);
                            $( this ).dialog( "close" ); 
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });

                $( "#but_add" ).click(function() {
                    $("#tableList").jqGrid('resetSelection');
                    $("#username").prop("readonly",false);
                    $(".iForm").val("");
                    $("#but_edit").prop("disabled",true);
					$("#but_delete").prop("disabled",true);
                    $("#ui-id-1").text("Create New User");
                    $("#opStatus").val("insert");
                    $("#dialogForm").dialog( "open" );
                });

                $( "#but_edit" ).click(function() {
                    $("#tableList").jqGrid('setSelection',trowid);
                    $("#username").prop("readonly",true);
                    $("#ui-id-1").text("Edit User");
                    $("#opStatus").val("update");
                    $("#dialogForm").dialog( "open" );
                });

                $( "#but_delete" ).click(function() {
                    $("#opStatus").val("delete");
                    $('#dialogText').text("Delete this item?");
                    $( "#dialogAlert" ).dialog( "open" );
                });

                $( "#help" ).click(function() {
                    $( "#dialogList" ).dialog( "open" );
                });
				$( "#but_refresh" ).click(function() {
                    $("#tableList").jqGrid().trigger("reloadGrid");	
                });
            })
            function test(){
                $("#dialogForm").dialog( "open" );
            }
        </script>
    </head>

    <body>
        <?php include("../include/headerf.php")?>   
        <?php include("../include/start.php")?>            
        <div class="content-header">
            <div class="header-inner">
                <h2 id="content-main-heading" class="title">User Maintenance</h2>
                <div class="rfloat specfloat">
                    <i class="topbar-divider"></i>
                    <button id="but_add" class="button" title="Add">
                        <i id="addIcon" class="iconButton"></i>
                        <p>Add</p>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_edit" class="button" title="Edit" disabled="true">
                        <i id="editIcon" class="iconButton"></i>
                        <p>Edit</p>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_delete" class="button" title="Delete" disabled="true">
                        <i id="deleteIcon" class="iconButton"></i>
                        <p>Delete</p>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_refresh" class="button" title="Refresh Data">
                        <i id="refreshIcon" class="iconButton"></i>
                        <p>Refresh</p>
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
        <div id="dialogForm">
            <div class="alongdiv">
                <div class="bodydiv">
                    <form id="formUsersMaintain" method="post" action="">
                        <table>
                            <tr>
                                <td >
                                    <label for="username">Username</label>
                                </td>
                                <td >
                                    <input type="text" class="iForm" name="username" id="username" />
                                </td>
                                <td ><label for="name">Name</label></td>
                                <td colspan="3">
                                    <input name="name" class="iForm" type="text" id="name" size="54" /></td>
                            </tr>
                            <tr>
                                <td><label for="password">Password</label></td>
                                <td><input type="text" class="iForm" name="password" id="password" /></td>
                                <td><label for="groupid">Group</label></td>
                                <td ><input name="groupid" type="text" class="iForm" id="groupid" size="13" /><input name="help" type="button" id="help" value="..."></td>
                                <td ><label for="programmenu">Menu</label></td>
                                <td ><input type="text" class="iForm" name="programmenu" id="programmenu" /></td>
                            </tr>
                            <tr>
                                <td><label for="deptcode">Department</label></td>
                                <td><input type="text" class="iForm" name="deptcode" id="deptcode" /></td>
                                <td><label for="cashier">Cashier</label></td>
                                <td><select name="cashier" id="cashier">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select></td>
                                <td><label for="priceview">Priceview</label></td>
                                <td><select name="priceview" id="priceview">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select></td>
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
        <div id="dialogList" title="List">
            <div >
                <table id="groupList"> </table>    
                <div id="tablePager"></div>
            </div>          
        </div>
    </body>
</html>