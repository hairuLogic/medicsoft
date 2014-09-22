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
                    caption: "Main",
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
                    $("#divSlide").slideUp();
                    $("#programmenu").val($("#programid").val());
                    $("#but_edit").prop("disabled",true);  
                    $("#but_view").prop("disabled",true);
                    $(".breadcrumb").append("<li id='"+$("#programid").val()+"' onclick='breadcrumbs(this)'><a>"+$("#programname").val()+"</a></li>");
                    $("#tableList").jqGrid().setGridParam({url : 'tableList/groupaccess.php?groupid='+$("#groupid").val()+'&programmenu='+$("#programid").val()}).trigger("reloadGrid");
                    $("#divSlide").slideDown();
                })
            })

            function breadcrumbs(obj){
                $("#divSlide").slideUp();
                $("#programmenu").val(obj.id);
                $("#but_edit").prop("disabled",true);  
                $("#but_view").prop("disabled",true);  
                $("#"+obj.id).nextAll('li').remove();         
                $("#tableList").jqGrid().setGridParam({url : 'tableList/groupaccess.php?groupid='+$("#groupid").val()+'&programmenu='+obj.id}).trigger("reloadGrid");
                $("#divSlide").slideDown();
            }
        </script>
    </head>

    <body>
        <table width="85%" border="1" align="center">
            <tr>
                <td class="menu" align="right">
                    <button type="button" class="but_edit" id="but_edit" disabled="true">
                        <img src="../img/icon/but_edit.png"/>
                    </button>
                    <button type="button" class="but_view" id="but_view" disabled="true">
                        <img src="../img/icon/but_view.png"/>
                    </button>
                    <button type="button" class="but_refresh" id="but_refresh" >
                        <img src="../img/icon/but_refresh.png"/>
                    </button>   
                </td>
            </tr>
            <tr >
                <td><table width="100%"  cellspacing="0" cellpadding="1"  >
                        <tr>
                            <td >
                                <ul class="breadcrumb" >
                                    <li id="main" onclick="breadcrumbs(this)"><a >Main</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td id="tdTree" align="center" height="520px">
                                <div id="divSlide">
                                    <table id="tableList"> </table>    
                                    <div id="tablePager"></div>
                                </div>

                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <div id="dialogForm" title="Create new item">
            <div class="sideleft" width='200px'>
                <div class="smalltitle"></div>
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