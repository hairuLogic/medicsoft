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
            var trowid;
            var groupid;
            $(function(){
                $("#tableList").jqGrid({
                    url:'tableList/users.php',
                    datatype: "xml",
                    colModel:[
                        {label:'username',name:'username',index:'username',width:50},
                        {label:'Name',name:'name',index:'name',width:200},
                        {label:'Group',name:'groupid',index:'groupid',width:50}, 
                        {label:'Department',name:'deptcode',index:'deptcode',width:100}, 
                        {label:'Cashier',name:'cashier',index:'cashier',width:50},   
                        {label:'PriceView',name:'priceview',index:'priceview',width:50},   
                        {label:'programmenu',name:'programmenu',index:'programmenu',width:50,hidden:true}  ,
                        {label:'password',name:'password',index:'password',width:50,hidden:true}  
                    ],
                    rowNum:100,

                    width: "80%",
                    viewrecords: true,
                    height: "450",
                    caption: "Main",
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
            })
        </script>
    </head>

    <body>
        <table width="85%" border="1" align="center">
            <tr>
                <td class="menu" align="right">
                    <button type="button" class="but_add" id="but_add">
                        <img src="../img/icon/but_add.png"/>
                    </button>
                    <button type="button" class="but_edit" id="but_edit" disabled="true">
                        <img src="../img/icon/but_edit.png"/>
                    </button>
                    <button type="button" class="but_delete" id="but_delete" disabled="true">
                        <img src="../img/icon/but_delete.png"/>
                    </button>
                    <button type="button" class="but_refresh" id="but_refresh">
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
        <div id="dialogForm">
            <div class="sideleft">
                <div class="smalltitle"></div>
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