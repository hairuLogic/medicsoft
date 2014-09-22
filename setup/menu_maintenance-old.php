<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu Setup</title>
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/ui-lightness/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>

        <script>
            var Lst, id, opStatus, butCall, parentProg,rowid;
            $(function (){
                $("#tableList").jqGrid({
                    url:'tableList/mainmenu.php',
                    datatype: "xml",
                    colModel:[
                        {name:'progName',index:'progName', width:300},
                        {name:'progType',index:'progType', width:80},  
                        {name:'programid',index:'programid', hidden:true},
                        {name:'lineno',index:'lineno', hidden:true},
                        {name:'url',index:'url', hidden:true},   
                        {name:'remarks',index:'remarks', hidden:true},
                        {name:'condition1',index:'condition1', hidden:true},
                        {name:'condition2',index:'condition2', hidden:true},
                        {name:'condition3',index:'condition3', hidden:true},
                        {name:'bmpid',index:'bmpid', hidden:true},
                        {name:'programmenu',index:'programmenu', hidden:true},
                        {name:'child',index:'child', hidden:true}
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
                        parentProg=ret.programmenu;
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
                        getTree(id,ret.progName,ret.progType,ret.child);
                        return(true);                      
                    }
                });

                $('#gview_tableList .ui-jqgrid-hdiv').hide();

                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    width: 535,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/menu_maintenance_p.php',$('#formMenuMaintain').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    reset();    
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
                                    reset(); 
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

                $( "#but_add1" ).click(function() {
                    reset();
                    butCall='main';
                    parentProg='main';
                    $('#opStatus').val('insert');
                    $("#programmenu").val("main");
                    $("#programid").prop("readonly",false);
                    $('.iForm').val('');
                    $("#divWhat").prop("hidden",false);
                    $( "#dialogForm" ).dialog( "open" );
                });

                $( "#but_edit1" ).click(function() {
                    butCall='main';
                    opStatus='update';

                    $("#divWhat").prop("hidden",true);
                    $("#programid").prop("readonly",true);
                    $("#opStatus").val(opStatus);
                    if($("#programtypeA").val()=="M"){
                        $("#url").prop("disabled",true);
                    }
                    else{                        
                        $("#url").prop("disabled",false);
                    }
                    $( "#dialogForm" ).dialog( "open" );
                });

                $('#but_delete1').click(function(){
                    butCall='main';
                    $("#programmenu").val("main");
                    $('#opStatus').val('delete');
                    $('#dialogText').text("Delete this item?");
                    $( "#dialogAlert" ).dialog( "open" );
                })

                $( "#but_add2" ).click(function() {
                    butCall="sub";
                    parentProg=$("#programid").val();
                    $('#opStatus').val('insert');
                    $("#programmenu").val($("#programid").val());
                    $("#programid").prop("readonly",false);
                    $('.iForm').val('');
                    $("#divWhat").prop("hidden",false);
                    $( "#dialogForm" ).dialog( "open" );
                });

                $( "#but_edit2" ).click(function() {
                    butCall="sub";
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

                $('#but_delete2').click(function(){
                    butCall='sub';
                    $('#opStatus').val('delete');
                    $('#dialogText').text("Are You sure You want to delete this item?");
                    $("#dialogAlert").dialog( "open" );
                })

                $('#at_where').change(function () {
                    getSelect();
                })

                $('#programtypeA').change(function () {
                    if($('#programtypeA').val()=='M'){
                        $('#url').prop('disabled',true)
                    }
                    getSelect();
                })
            });

            function getSelect(){
                if($('#at_where').val()=='after' && $('#programtypeA').val()!=''){
                    $("#idAfter").prop("hidden",false);
                    $('#idAfter')
                    .find('option')
                    .remove()
                    .end()
                    $.post("process/menu_maintenance_p.php",{ id: parentProg, opStatus: 'program'} ,function(data) {
                        $.each( data, function( key, value ) {
                            $('#idAfter').append($("<option>").attr('value',key).text(value));
                        });
                        }, "json");    

                }
                else{
                    $("#idAfter").prop("hidden",true);
                }
            }

            function detailTree(id,lineno,programname,bmpid,condition1,condition2,condition3,remarks,url,programmenu,programtype,child)
            {
                $("#lineno").val(lineno);
                $("#programname").val(programname);
                $("#programid").val(id);
                $("#bmpid").val(bmpid);
                $("#condition1").val(condition1);
                $("#condition2").val(condition2);
                $("#condition3").val(condition3);
                $("#remarks").val(remarks);
                $("#url").val(url);
                $("#programmenu").val(programmenu);
                $("#programtypeA").val(programtype);
                $("#child").val(child);
                $('#but_delete2').prop('disabled',false);
                $('#but_delete1').prop('disabled',true);
                $("#but_edit2").prop("disabled",false);
                $("#but_edit1").prop("disabled",true);
                $("#tableList").jqGrid("resetSelection");
            }

            function getTree(id,progName,progType,child){
                if(progType=='M'){
                    $("#treeHead").text(progName);
                    $("#treeHead").attr('programid',$("#programid").val());
                    $("#treeHead").attr('programname',$("#programname").val());
                    $("#treeHead").attr('programtypeA',$("#programtypeA").val());
                    $("#treeHead").attr('bmpid',$("#bmpid").val());
                    $("#treeHead").attr('condition1',$("#condition1").val());
                    $("#treeHead").attr('condition2',$("#condition2").val());
                    $("#treeHead").attr('condition3',$("#condition4").val());
                    $("#treeHead").attr('remarks',$("#remarks").val());
                    $("#treeHead").attr('programmenu',$("#programmenu").val());
                    $("#treeHead").attr('lineno',$("#lineno").val());
                    $("#iframeTree").prop("src","iframe/menu_maintenance_tree.php?id="+id);
                    $('#but_add2').prop('disabled',false);
                }
                else{
                    $("#treeHead").text("");
                    $("#iframeTree").prop("src","");
                    $('#but_add2').prop('disabled',true);
                    $('#but_delete1').prop('disabled',false);
                }
                $('#but_delete1').prop('disabled',false);
                $('#but_add1').prop('disabled',false);
                $('#but_edit1').prop('disabled',false);
                $('#but_edit2').prop('disabled',true);
            };

            function reset(){
                if(butCall=="main"){
                     $("#tableList").jqGrid().trigger("reloadGrid");
                     $("#iframeTree").prop("src","");
                     $("#but_edit2").prop("disabled",true);
                     $("#but_add2").prop("disabled",true); 
                     $("#but_edit1").prop("disabled",true);
                     
                     $("#treeHead").text("");
                }
                else{
                    $("#iframeTree").prop("src","");
                    $("#iframeTree").prop("src","iframe/menu_maintenance_tree.php?id="+id);
                }
                $("#dialogForm").dialog( "close" );
                $("#at_where").val("first");
                $("#idAfter").prop("hidden",true);
                
                            
                
            }
        </script>
    </head>

    <body>
        <table width="85%" border="1" align="center">
            <tr>
                <td width="50%" class="menu" align="right">
                    <button type="button" class="but_add1" id="but_add1">
                        <img src="../img/icon/but_add.png"/>
                    </button>
                    <button type="button" class="but_edit1" id="but_edit1" disabled="true">
                        <img src="../img/icon/but_edit.png"/>
                    </button>
                    <button type="button" class="but_delete1" id="but_delete1" disabled="true">
                        <img src="../img/icon/but_delete.png"/>
                    </button>
                    <button type="button" class="but_refresh1" id="but_refresh1">
                        <img src="../img/icon/but_refresh.png"/>
                    </button>

                </td>
                <td class="menu" align="right">        
                    <button type="button" class="but_add2" id="but_add2" disabled="true">
                        <img src="../img/icon/but_add.png"/>
                    </button>
                    <button type="button" class="but_edit2" id="but_edit2" disabled="true">
                        <img src="../img/icon/but_edit.png"/>
                    </button>
                    <button type="button" class="but_delete2" id="but_delete2" disabled="true">
                        <img src="../img/icon/but_delete.png"/>
                    </button>
                    <button type="button" class="but_refresh2" id="but_refresh2" disabled="true">
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
                    <input type="text" name="test" id="test">
                </td>
                <td id="tdTree" align="center" height="550px">
                    <div class="divTree" align="left">
                        <div class="smalltitle"><p><a id="treeHead" onclick="document.getElementById('iframeTree').contentWindow.CngClass(this);"></a></p></div>
                        <div id="treeBody" class="bodydiv">
                            <iframe id="iframeTree" name="iframeTree" width="99%" height="99%" frameborder="0"></iframe>
                        </div>            
                    </div>
                </td>
            </tr>
        </table>

        <div id="dialogForm" title="Create new item">
            <div id="divWhat" class="sideleft" width='100%'>
                <div class="smalltitle"></div>
                <div class="bodydiv">
                    <form id="formMenuMaintain" method="post" action="" >
                    <table  border="0">
                        <tr>
                            <td><label for="programtypeA">Add Type</label></td>
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
            <div class="sideleft" width='100%'>
                <div class="smalltitle"></div>
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
                            <td>
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