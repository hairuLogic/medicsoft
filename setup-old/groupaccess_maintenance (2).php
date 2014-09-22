<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
    	<meta charset="utf-8">
        <title>Group Access Maintenance</title>
        <link rel="stylesheet" href="../css/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link href="../style_main.css" rel="stylesheet" type="text/css">
        <link href="../style.css" rel="stylesheet" type="text/css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>        
        
        <script>
            var rowid,type;
            $(function(){
                $("#tableList").jqGrid({
                    url:'tableList/groupaccess.php?groupid='+$("#groupid").val()+'&programmenu='+$("#programmenu").val(),
                    datatype: "xml",
                    colModel:[
                        {label:'Line No',name:'lineno',index:'lineno',width:50},
                        {label:'Name',name:'programname',index:'programname',width:200},
                        {label:'Type',name:'programtype',index:'programtype',width:50}, 
                        {label:'Id',name:'programid',index:'programid',width:100}, 
                        {label:'Can Run',name:'canrun',index:'canrun',width:50}, 
                        {label:'yesall',name:'yesall',index:'yesall',width:50},     
                    ],
                    rowNum:100,

                    width: "80%",
                    viewrecords: true,
                    height: "450",
                    caption: "Group Access Maintenance",
                    onSelectRow : function(rowid, e){
                        rowid=rowid;

                        var ret=$("#tableList").jqGrid('getRowData',rowid);
                        type= ret.programtype;
                        $("#programid").val(ret.programid);
                        $("#programname").val(ret.programname);
                        $("#canrun").val(ret.canrun);
                        $("#yesall").val(ret.yesall);
                        $("#canrunold").val(ret.canrun);
                        $("#yesallold").val(ret.yesall);
                        $("#lineno").val(ret.lineno);
                        $("#but_edit").prop("disabled",false);   
                        if(ret.programtype=='M' & ret.canrun=='Yes'){
                            $("#but_view").prop("disabled",false);
                        }      
                        else{
                            $("#but_view").prop("disabled",true);   
                        }   

                        return(true);            
                    }
                }).jqGrid('bindKeys', {
                    "onEnter" : function( rowid ) {

                        if($("#canrun").val()=='Yes' & type=='M'){
                            $("#but_view").click();
                        }   

                    },
                    "onRightKey": function( rowid ) {
                            $("#but_edit").click();
                    }
                });
                
                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/groupacc_maintenance_p.php',$('#formGroupAccMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tableList").jqGrid().trigger("reloadGrid");
                                    $( "#dialogForm" ).dialog("close");
                                    setTimeout(function(){$("#tableList").jqGrid('setSelection',$("#lineno").val());}, 500);
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

                $( "#but_edit" ).click(function() {
                    $("#opStatus").val("update");
                    $("#dialogForm").dialog( "open" );
                });

                $("#but_view").click(function(){
                    $("#programmenu").val($("#programid").val());
                    $("#but_edit").prop("disabled",true);  
                    $("#but_view").prop("disabled",true);
                    $(".breadcrumb").append("<li id='"+$("#programid").val()+"' onclick='breadcrumbs(this)'><a>"+$("#programname").val().substring(0, 9)+"</a></li>");
                    $("#tableList").jqGrid().setGridParam({url : 'tableList/groupaccess.php?groupid='+$("#groupid").val()+'&programmenu='+$("#programid").val()}).trigger("reloadGrid");
                })
				
				$("#but_refresh").click(function(){
					 $("#main").click();
                })
            })

            function breadcrumbs(obj){
                $("#programmenu").val(obj.id);
                $("#but_edit").prop("disabled",true);  
                $("#but_view").prop("disabled",true);  
                $("#"+obj.id).nextAll('li').remove();         
                $("#tableList").jqGrid().setGridParam({url : 'tableList/groupaccess.php?groupid='+$("#groupid").val()+'&programmenu='+obj.id}).trigger("reloadGrid");
            }
        </script>          
    </head>

    <body>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
            <div class="content-header">
                <div class="header-inner">
                    <h2 id="content-main-heading" class="title">Group Access for <?php echo ucfirst ($_GET['groupid'] ); ?></h2>
                    <div class="rfloat specfloat">
                    	
                        <i class="topbar-divider"></i>
                        <button id="but_edit" class="button" title="Edit">
                        	<i id="editIcon" class="iconButton"></i>
                            <p>Edit</p>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="but_view" class="button" title="View">
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
                                    <li id="main" onclick="breadcrumbs(this)"><a >Main</a></li>
                     </div>
                    <div id="tdTree" >
                        <table id="tableList"> </table>    
                        <div id="tablePager"></div>
                    </div>
                </div>
            </div>
		<?php include("../include/end.php")?>
        <div id="dialogForm" title="Create new item">
            <div class="alongdiv" width='200px'>
                <div class="bodydiv">
                    <form id="formGroupAccMaintain">
                        <table>
                            <tr>
                                <td><label for="canrun">CanRun: </label></td>
                                <td>
                                    <select name="canrun" id="canrun">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="yesall">Yes all: </label></td>
                                <td>
                                    <select name="yesall" id="yesall">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr >
                                <td style="display:none">
                                    <input type="text" name="opStatus" id="opStatus">
                                    <input type="text" name="groupid" id="groupid" value="<?php echo $_GET['groupid']  ?>">
                                    <input type="text" name="programmenu" id="programmenu" value="main">
                                    <input type="text" name="programid" id="programid" >
                                    <input type="text" name="lineno" id="lineno" >
                                    <input type="text" name="programname" id="programname">
                                    <select name="yesallold" id="yesallold">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <select name="canrunold" id="canrunold">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>