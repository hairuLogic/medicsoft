<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu Maintenance</title>    
        <link rel="stylesheet" href="../css/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />

        <link href="../style.css" rel="stylesheet" type="text/css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>  

        <script>
            var Lst, id, opStatus, rowid;

            $(function (){
                $("#tableList").jqGrid({
                    url:'tableList/mainmenu.php?programid=main',
                    datatype: "xml",
                    colModel:[
                        {label:'Id',name:'programid',index:'programid', width:80},
                        {label:'Program Name',name:'progName',index:'progName', width:300},
                        {label:'Type',name:'progType',index:'progType', width:80},  
                        {label:'lineno',name:'lineno',index:'lineno', hidden:true},
                        {label:'url',name:'url',index:'url', hidden:true},   
                        {label:'remarks',name:'remarks',index:'remarks', hidden:true},
                        {label:'condition1',name:'condition1',index:'condition1', hidden:true},
                        {label:'condition2',name:'condition2',index:'condition2', hidden:true},
                        {label:'condition3',name:'condition3',index:'condition3', hidden:true},
                        {label:'bmpid',name:'bmpid',index:'bmpid', hidden:true},
                        {label:'programmenu',name:'programmenu',index:'programmenu', hidden:true},
                        {label:'child',name:'child',index:'child', hidden:true}
                    ],
                    rowNum:100,

                    width: "80%",
                    viewrecords: true,
                    height: "400",
                    caption: "Main",
                    beforeSelectRow: function(rowid, e){
                        var ret=$("#tableList").jqGrid('getRowData',rowid);
                        rowid=rowid;
                        id=ret.programid;
                        $("#programname").val(ret.progName);
                        $("#programid").val(id);
                        $("#programtypeA").val(ret.progType);
                        $("#bmpid").val(ret.bmpid);
                        $("#condition1").val(ret.condition1);
                        $("#condition2").val(ret.condition2);
                        $("#condition3").val(ret.condition3);
                        $("#remarks").val(ret.remarks);
                        $("#url").val(ret.url);
                        $("#programmenu").val(ret.programmenu);
                        $("#lineno").val(ret.lineno);       
                        $("#child").val(ret.child);  

                        $("#but_edit").prop("disabled",false);
                        $("#but_delete").prop("disabled",false);   
                        if(ret.progType=='M'){
                            $("#but_view").prop("disabled",false);
                        }      
                        else{
                            $("#but_view").prop("disabled",true);   
                        }

                        return(true);                      
                    }
                });
                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    width: 535,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/menu_maintenance_p.php',$('#formMenuMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    refreshBut();    
                                    $("#dialogForm").dialog("close");
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
                            $.post('process/menu_maintenance_p.php',$('#formMenuMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    refreshBut(); 
                                    $("#dialogAlert").dialog("close"); 
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

                $( "#but_add" ).click(function() {
                    $('#opStatus').val('insert');
                    $("#programmenu").val($("li.breadcrumbs:last").attr('id'));
                    $("#programid").prop("readonly",false);
                    $("#divWhat").prop("hidden",false);
                    $( "#dialogForm" ).dialog( "open" );
					$("#url").prop("disabled",false);
					if($("#programtypeA").val()=="M"){
                        $("#url").prop("disabled",true);
                    }
                    else{                        
                        $("#url").prop("disabled",false);
                    }
                    refreshBut();					
                });

                $( "#but_edit" ).click(function() {
                    $("#divWhat").prop("hidden",true);
                    $("#programid").prop("readonly",true);
                    $("#opStatus").val("update");
                    if($("#programtypeA").val()=="M"){
                        $("#url").prop("disabled",true);
                    }
                    else{                        
                        $("#url").prop("disabled",false);
                    }
                    $( "#dialogForm" ).dialog( "open" );
                });

                $('#but_delete').click(function(){
                    $('#opStatus').val('delete');
                    $('#dialogText').text("Delete this item?");
                    $( "#dialogAlert" ).dialog( "open" );
                })

                $('#at_where').change(function () {
                    getSelect();
                })

                $("#but_view").click(function(){
                    $("#but_edit").prop("disabled",true);  
                    $("#but_view").prop("disabled",true);
                    $("#but_delete").prop("disabled",true);
                    $(".breadcrumb").append("<li id='"+$("#programid").val()+"' onclick='breadcrumbs(this)' class='breadcrumbs'><a>"+$("#programname").val().substring(0, 9)+"</a></li>");
                    $("#tableList").jqGrid().setGridParam({url : 'tableList/mainmenu.php?programid='+$("#programid").val()}).trigger("reloadGrid");
                })
				$('#programtypeA').change(function(){					
					if($("#programtypeA").val()=="M"){
                        $("#url").prop("disabled",true);
                    }
                    else{                        
                        $("#url").prop("disabled",false);
                    }
				});
            });

            function getSelect(){
                if($('#at_where').val()=='after' && $('#programtypeA').val()!=''){
                    $("#idAfter").prop("hidden",false);
                    $('#idAfter')
                    .find('option')
                    .remove()
                    .end()
                    $.post("process/menu_maintenance_p.php",{ id: $("li.breadcrumbs:last").attr('id'), opStatus: 'program'} ,function(data) {
                        $.each( data, function( key, value ) {
                            $('#idAfter')
                            .append($("<option></option>")
                                .attr("value",key)
                                .text(value)); 
                        });
                        }, "json");    

                }
                else{
                    $("#idAfter").prop("hidden",true);
                }
            }

            function refreshBut(){
                //button disable
                $("#but_edit").prop("disabled",true);
                $("#but_delete").prop("disabled",true);   
                $("#but_view").prop("disabled",true);  
                //reload grid
                $("#tableList").jqGrid().trigger("reloadGrid");
                //clear form
                $('.iForm').val('');				
                $("#at_where").val("first");
                $("#idAfter").prop("hidden",true);
            }

            function breadcrumbs(obj){
                $("#programid").val(obj.id);
                $("#but_edit").prop("disabled",true);  
                $("#but_view").prop("disabled",true);  
                $("#"+obj.id).nextAll('li').remove();         
                $("#tableList").jqGrid().setGridParam({url : 'tableList/mainmenu.php?programid='+$("#programid").val()}).trigger("reloadGrid");
            }
        </script>     
    </head>

    <body>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
        <div class="content-header">
            <div class="header-inner">
                <h2 id="content-main-heading" class="title">Menu Maintenance</h2>
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
                    <button id="but_view" class="button"  title="View" disabled="true">
                        <i id="viewIcon" class="iconButton"></i>
                        <p>View</p>
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
                <div class="breadcrumb" >
                    <h3 class="groupaccbread">Menu : </h3>
                    <li id="main" onclick="breadcrumbs(this)" class="breadcrumbs"><a >Main</a></li>
                </div>
                <div id="tdTree" >
                    <table id="tableList"> </table>    
                    <div id="tablePager"></div>
                </div>
            </div>
        </div>
        <?php include("../include/end.php")?>
        <div id="dialogForm" title="Create new item">
            <div id="divWhat" class="alongdiv" width='100%'>
                <div class="bodydiv">
                    <form id="formMenuMaintain" method="post" action="" >
                    <table  border="0">
                        <tr>
                            <td><label for="programtypeA">Item Type</label></td>
                            <td><select name="programtypeA" id="programtypeA" ><option  value="P">P</option><option value="M">M</option>
                                </select></td>

                            <td><label for="at_where"> At </label></td>
                            <td><select name="at_where" id="at_where">
                                    <option value="first">First</option>
                                    <option value="last">Last</option>
                                    <option value="after">After</option>
                                </select></td>
                            <td><select name="idAfter" id="idAfter" hidden="true">
                                </select></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="alongdiv" width='100%'>
                <div class="bodydiv">

                    <table>
                        <tr>
                            <td><label for="programid">Program Id</label></td>
                            <td><input type="text" name="programid" class="iForm" id="programid"></td>
                            <td><label for="remarks">Remarks</label></td>
                            <td ><input type="text" name="remarks" class="iForm" id="remarks"></td>
                        </tr>
                        <tr>
                            <td><label for="programname">Description</label></td>
                            <td colspan="3"><input name="programname" type="text" class="iForm" id="programname" size="56"></td>
                        </tr>
                        <tr>

                            <td><label for="condition1">Condition1</label></td>
                            <td><input type="text" name="condition1" class="iForm" id="condition1"></td>
                            <td><label for="condition2">Condition 2</label></td>
                            <td><input type="text" name="condition2" class="iForm" id="condition2"></td>
                        </tr>
                        <tr style="display:none">
                            <td><label for="condition3">Condition3</label>
                            </td>
                            <td><input type="text" name="condition3" class="iForm" id="condition3"></td>
                            <td><label for="bmpid">Bmpid</label>
                            </td>
                            <td><input type="text" name="bmpid" class="iForm" id="bmpid"></td>
                        </tr>
                        <tr>
                            <td><label for="url">URL</label></td>
                            <td colspan="3"><input name="url" type="text" class="iForm" id="url" size="56"></td>
                        </tr>
                        <tr >
                            <td style="display:none">
                                <input type="text" name="opStatus" id="opStatus">
                                <input type="text" name="programmenu" id="programmenu">
                                <input type="text" name="lineno" id="lineno">
                                <input type="text" name="child" id="child">
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