<?php
    include_once('../sschecker.php');

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Subscription</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
        <style>
            #tblinfo{
                margin:1%;
                width:48%;
                border-collapse:separate;
                border-color:#FF0000;
                color:#333333;
                text-align:left;
                float:left;
            }
            #tblinfo td{
                background-color:#D5D5D5;
                padding:2px;
                width: 40%;
            }
            #tblinfo th{
                background-color:#D5D5D5;
                padding:2px;
                width:10%;
            }
            #tblinfo #tdatas{
                padding:15px 3px;
                background-color:#B8B8B8;
                color:#663300;
                text-align:justify;
                font-weight:bold;
            }
        </style> 
        <script>
            var pkg,mrn,MemberNo,currentEpiStat,chgCode,chgDesc,episno,pkgcode;
            $(function(){
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Button & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<	
                $("#tableMember").jqGrid({
                    url:'tableList/memberlist.php',
                    datatype: "xml",
                    colModel:[
                        {label:'MemberNo',name: 'MemberNo',index: 'MemberNo', width: 70},
                        {label:'Name',name: 'Name',index: 'Name', width: 300},
                        {label:'Newic',name: 'Newic',index: 'Newic', width: 100},
                        {label:'Handphone',name: 'Handphone',index: 'telhp', width: 100},
                        {label:'DOB',name: 'DOB',index: 'DOB', width: 50},
                        {label:'Sex',name: 'Sex',index: 'Sex', width: 30},
                        {label:'Category',name: 'Category',index: 'Category', width: 100},
                        {label:'Term',name: 'add1',index: 'add1',hidden:true},
                        {label:'Term',name: 'add2',index: 'add1',hidden:true},
                        {label:'Term',name: 'add3',index: 'add1',hidden:true},
                        {label:'Term',name: 'offadd1',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd2',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd3',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'telh',index: 'telh',hidden:true},
                        {label:'Term',name: 'telo',index: 'telo',hidden:true},
                        {label:'Term',name: 'mrn',index: 'mrn',hidden:true},
						{label:'Term',name: 'pkgcode',index: 'pkgcode',hidden:true}
                    ],
                    viewrecords: true,
                    height: "250",
                    autowidth: true,
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerMember'),
                    beforeSelectRow : function(rowid, e){
                        var ret=$("#tableMember").jqGrid('getRowData',rowid);	
                        mrn=ret.mrn;
                        MemberNo=ret.MemberNo;
                        $("#tableNominee").jqGrid().setGridParam({url:'tableList/nomineelist.php?mrn='+mrn,datatype:'xml'}).trigger("reloadGrid");                        
                        $("#mrn1").val(ret.mrn);
                        $("#but_order").prop("disabled",false); 	
                        $("#memberName").text(ret.Name);

                        pkgcode=ret.pkgcode;
                       /* $("#pkgDescription").val(ret.description);
                        $("#pkgTerm").val(ret.term);
                        ////age/payer////doctor
                        $("#but_edit").prop("disabled",false);
                        $("#but_view").prop("disabled",false);
                        //$("#tablePt").jqGrid().setGridParam({hidegrid: false});//display hide grid
                        $(".minimize").show();*/
                        return(true);            
                    }
                });	

                $("#but_order").click(function(){
                    //toggle screen
                    $(".maindiv").slideUp("fast");
                    //$(".placeholder").slideDown("fast");
                    $(".orderDiv").slideDown("fast");
                    $(".paymentDiv").slideUp("fast");
                    //toggle button
                    $("#but_member").prop("disabled",false);
                    $("#but_order").prop("disabled",true);                
                    /*$("#chgCode").focus();*/
                    //call function		
                    var trf = $("#tableEpisode tbody:first tr:first")[0];
                    $("#tableEpisode tbody:first").empty().append(trf);
                    $("#tableEpisode").jqGrid().setGridParam({url:'tableList/episode.php?mrn='+mrn,datatype:'xml'}).trigger("reloadGrid");
                    getSubscriberDetail(MemberNo);
                });
                $("#but_member").click(function(){
                    //toggle screen
                    $(".maindiv").slideDown("fast");
                    //$(".placeholder").slideUp("fast");
                    $(".orderDiv").slideUp("fast");
                    $(".paymentDiv").slideUp("fast")
                    //toggle button
                    $("#but_member").prop("disabled",true);
                    $("#but_order").prop("disabled",false); 
                });
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                $("#tableNominee").jqGrid({		
                    datatype: "local",//datatype: "xml",
                    colModel:[
                        {label:'MRN',name: 'MRN',index: 'MRN', width: 100},
                        {label:'Name',name: 'Name',index: 'Name', width: 350},
                        {label:'Newic',name: 'Newic',index: 'Newic', width: 150},
                        {label:'Handphone',name: 'Handphone',index: 'telhp', width: 100},
                        {label:'DOB',name: 'DOB',index: 'DOB', width: 90},
                        {label:'Sex',name: 'Sex',index: 'Sex', width: 70},
                        {label:'Category',name: 'Category',index: 'Category', width: 100},
                        {label:'Term',name: 'add1',index: 'add1',hidden:true},
                        {label:'Term',name: 'add2',index: 'add1',hidden:true},
                        {label:'Term',name: 'add3',index: 'add1',hidden:true},
                        {label:'Term',name: 'offadd1',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd2',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd3',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'telh',index: 'telh',hidden:true},
                        {label:'Term',name: 'telo',index: 'telo',hidden:true},
                        {label:'Term',name: 'mrn',index: 'mrn',hidden:true}
                    ],
                    viewrecords: true,
                    height: "23",
                    autowidth: true,
                    hidegrid: false,
                    sortable: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    hoverrows:false,
                    beforeSelectRow : function(rowid, e){
                        return false;            
                    }
                });	
                $("#tableEpisode").jqGrid({
                    datatype: "local",
                    colModel:[
                        {label:'Reg Date',name:'regdate',index:'regdate',width:80},
                        {label:'Discharge',name:'discharge',index:'discharge',width:80},
                        {label:'Delete',name:'delete',index:'delete',width:50, formatter:test},	
                        {label:'episno',name:'episno',index:'episno',hidden:true}		
                    ],
                    viewrecords: true,
                    height: "300",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerEpisode'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tableEpisode").jqGrid('getRowData',rowid);
                        episno=ret.episno;
                        $("#episno1").val(episno);
                        var trf = $("#tableOrder tbody:first tr:first")[0];
                        $("#tableOrder tbody:first").empty().append(trf);
                        $("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno,datatype:'xml'}).trigger("reloadGrid");	
                        if(ret.discharge!=''){$("#tableOrderDiv *").prop("disabled", true);}
                        else {
                            $("#tableOrderDiv *").prop("disabled", false);
                            $("#chgCode").focus();
                        }
                        return(true);            
                    }
                });
                ///function for table episode formatter..
                function test(cellvalue, options, rowObject){
                    $("div.ui-inline-del").hide();
                    if (cellvalue==="1"){
                        //$("div.ui-inline-del", "tr",'#'+options.rowId).show();
                        //$("tr#"+options.rowId+ " div.ui-inline-del").show();
                        //$('tr#'+options.rowId+' td:last div:first div.ui-inline-del').show();

                        return '<div class="menuPulldown" onClick="deleteEpisode('+options.rowId+')" onmouseover="jQuery(this).addClass(\'ui-state-hover\');" onmouseout="jQuery(this).removeClass(\'ui-state-hover\');" style="padding-left: 14px;" title="Delete Episode"><span class="ui-icon ui-icon-trash"></span></div>';
                    }
                    else {
                        return "";
                    }
                }

                $("#tableOrder").jqGrid({
                    datatype: "local",//datatype: "xml",
                    colModel:[
                        {label:'Code',name:'chgcode',index:'chgcode',width:198},
                        {label:'Description',name:'description',index:'description',width:316},
                        {label:'Quantity',name:'quantity',index:'quantity',width:80}, 				   
                    ],
                    viewrecords: true,
                    height: "270",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerOrder'),
                    loadComplete: function(data) {
                        var myUserData = $("#tableOrder").getGridParam('userData');
                        $("#total").val("RM "+myUserData.totalamount);
                    },
                    onSelectRow : function(rowid, e){
                        var ret=$("#tableOrder").jqGrid('getRowData',rowid);
                        //togle button n input state
                        $("#saveChgTrx").hide();
                        $("#deleteChgTrx").show();
                        $('.iForm').prop("readonly",true); 
                        $('#chgDept').prop("readonly",true);
                        $("#help").prop("disabled",true); 
                        //assign value
                        $("#chgCode").val(ret.chgcode);
                        $("#chgDesc").val(ret.description); 

                        $("#chgQuantity").val(ret.quantity);	
                        /*$("#chgDate").val(ret.trxdate); 
                        $("#chgTime").val(ret.trxtime); 
                        $("#chgAmount").val(ret.amount); */
                        return(true);            
                    }					
                });
                $("#chgmastList").jqGrid({
                    datatype: "local",//datatype: "xml",
                    colModel:[
                        {label:'Code',name:'chgcode',index:'chgcode', width:100},
                        {label:'Description',name:'description',index:'description', width:270}/*,
                        {label:'Brandname',name:'brandname',index:'brandname', width:270}*/
                    ],
                    rowNum:10,
                    viewrecords: true,
                    height: "300",
                    caption: "Charge Master",
                    altRows: true,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerChgmast'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#chgmastList").jqGrid('getRowData',rowid);   
                        chgCode=rowid;
                        chgDesc=ret.description;
                        return(true);             
                    }					
                });
                $( "#dialogEpisode" ).dialog({//alert when click button
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $.post('process/episode_p.php',{mrn:mrn,opStatus:'new'},function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tableEpisode").jqGrid().trigger("reloadGrid");
                                    $("#tableOrderDiv *").prop("disabled", false);
                                    $("#dialogEpisode").dialog("close");
                                    setTimeout(function() {
                                        $("#tableEpisode").jqGrid('setSelection',$(data).find('id').text());
                                        }, 5000);

                                    $("#chgCode").focus();
                                }
                                else if($msg!='fail'){
                                    $("#tableOrderDiv *").prop("disabled", false);
                                    $("#dialogEpisode").dialog("close");
                                    $("#tableEpisode").jqGrid('setSelection',$msg); 
                                    $("#chgCode").focus();
                                }
                                else alert();
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                $( "#dialogList" ).dialog({
                    autoOpen: false,
                    width: 700,
                    height: 600,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $("#chgCode").val(chgCode);
                            $("#chgDesc").val(chgDesc);
                            $("#chgQuantity").val(1);
                            $( this ).dialog( "close" );
                            $("#chgQuantity").focus();
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                            $("#chgCode").focus();
                        }
                    }
                });
                $( "#dialogAlert" ).dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: {
                        "OK":function(){
                            $( this ).dialog( "close" );
                        }
                    }
                });
                $( "#dialogAlertClick" ).dialog({//alert when click button
                    autoOpen: false,
                    width: 400,
                    modal: true
                });
                var alertClickDelete={//button for dialog alert click
                    "Delete":function(){
                        $("#opStatus").val("delete");
                        $.post('process/orderChgTrx.php',$('#chgTrxForm').serialize(),function(data){
                            $msg=$(data).find('msg').text();
                            if($msg=='success'){
                                var trf = $("#tableOrder tbody:first tr:first")[0];
                                $("#tableOrder tbody:first").empty().append(trf);
                                $("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno,datatype:'xml'}).trigger("reloadGrid");	
                                $( "#dialogAlertClick" ).dialog( "close" );
                                $( "#cancelChgTrx" ).click();
                            }
                            else{
                                alert("fail");
                            }
                        });
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                };
                $("#gbox_tableOrder .ui-jqgrid-hdiv").hide(); //hide table column title
                $("#tableOrderDiv *").prop("disabled", true);//disable all child

                $( "#but_add_order" ).click(function(){
                    $('#dialogTextEpisode').text("Add new episode?");
                    $("#dialogEpisode").dialog( "open" );
                });
                $("#chgCode").on('keydown',  function(e) { 
                    var keyCode = e.keyCode || e.which; 
                    //check for tab n enter key 
                    if (keyCode == 9 || keyCode == 13) { 
                        e.preventDefault(); 
                        //check length of character
                        if($.trim($("#chgCode").val()).length>2){
                            $.post('process/checkChgCode.php',{chgCode:$("#chgCode").val()},function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='empty'){
                                    $("#chgCode").focus();
                                    fieldName=$("#chgCode").attr("name");
                                    $('#dialogText').text("Item not in database");
                                    $("#chgDesc").val("");
                                    $( "#dialogAlert" ).dialog( "open" );	
                                }
                                else if($msg=='pop'){
                                    if ($("#chgCode").val()=="") return 0;
                                    $("#dialogList").dialog( "open" );
                                    $("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php?chgCode='+$("#chgCode").val()+"&pkgcode="+pkgcode,datatype:'xml'}).trigger("reloadGrid");	
                                }
                                else{
                                    /*$value=$(data).find('value').text();*/
                                    $("#chgQuantity").val(1);
                                    $("#chgQuantity").focus();	
                                    $("#chgDesc").val($(data).find('description').text()); 	
                                    $("#chgQuantity").val(''); 	
                                }
                            });
                        }
                        else{
                            $("#chgCode").focus();
                            $('#dialogText').text("Please enter atleast more than 3 character for increase searching performance");
                            $( "#dialogAlert" ).dialog( "open" );
                        }
                    } 
                });
                $("#chgQuantity").focusin(function(){
                    if ($("#chgCode").val()==""){
                        $("#chgCode").focus();
                        fieldName=$("#chgCode").attr("name");
                        $('#dialogText').text(fieldName+" cannot be empty");
                        $( "#dialogAlert" ).dialog( "open" );			
                    }
                });
                $("#help").click(function(){
                    $("#chgmastList").jqGrid().setGridParam({url:'tableList/orderChgMast.php?pkgcode='+pkgcode,datatype:'xml'}).trigger("reloadGrid");
                    $("#dialogList").dialog( "open" );	
                });
                $("#saveChgTrx").click(function(){
                    $("#opStatus").val("insert");
                    $.post('process/orderChgTrx.php',$('#chgTrxForm').serialize(),function(data){
                        $msg=$(data).find('msg').text();
                        if($msg=='success'){
                            $("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno,datatype:'xml'}).trigger("reloadGrid");	
                        }
                        else{
                            alert("fail");
                        }
                    });
                });
                $("#deleteChgTrx").click(function(){
                    $("#dialogAlertClick").dialog('option', 'buttons', alertClickDelete);
                    $( "#dialogAlertClick" ).dialog( "open" );
                    $('#dialogTextClick').text("Are you sure to delete this record");
                });
                $("#cancelChgTrx").click(function(){
                    //empty form
                    $('.iForm').val('');
                    //togle enable disable
                    $('.iForm').prop("readonly",false); 
                    $("#help").prop("disabled",false); 
                    //togle button delete n save
                    $("#saveChgTrx").show();
                    $("#deleteChgTrx").hide();
                    $("#chgCode").focus();

                    $("#tableOrder").jqGrid('resetSelection');
                });

                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

                //START/coding section for searching table and data		
                $("#searchString").on('keydown',  function(e) { //search pt
                    var keyCode = e.keyCode || e.which; 
                    //check for tab n enter key 
                    if (keyCode == 9 || keyCode == 13) { 
                        e.preventDefault(); 
                        //check length of character
                        searchMember();
                    } 
                });
                $("#but_search").click(function(){//search pt
                    searchMember();	
                });
                $("#searchString2").on('keydown',  function(e) { //search pt
                    var keyCode = e.keyCode || e.which; 
                    //check for tab n enter key 
                    if (keyCode == 9 || keyCode == 13) { 
                        e.preventDefault(); 
                        //check length of character
                        searchChgmast();
                    } 
                });
                $("#but_search2").click(function(){//search pt
                    searchChgmast();	
                });
            });
            function deleteEpisode(rown){
                $.post('process/episode_p.php',{id:rown,opStatus:'delete'},function(data){
                    $msg=$(data).find('msg').text();
                    if($msg=='success'){
                        $("#tableEpisode").jqGrid().trigger("reloadGrid");
                        $("#tableOrderDiv *").prop("disabled", true);
                    }
                    else if($msg!='fail'){
                        alert();
                    }
                });
            }
            function searchMember(){
                var trf = $("#tableMember tbody:first tr:first")[0];
                $("#tableMember tbody:first").empty().append(trf);
                $("#tableMember").jqGrid().setGridParam({url:'tableList/memberlist.php?searchString='+$("#searchString").val()+'&searchField='+$("#searchField").val()}).trigger("reloadGrid");
            };
            function searchChgmast(){
                var trf = $("#chgmastList tbody:first tr:first")[0];
                $("#chgmastList tbody:first").empty().append(trf);
                $("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php?searchString2='+$("#searchString2").val()+"&searchField2="+$("#searchField2").val()+"&pkgcode="+pkgcode}).trigger("reloadGrid");
            };
            function getSubscriberDetail(MemberNo){
                $.post('process/getSubscriberDetail.php',{MemberNo:MemberNo},function(data){
                    $msg=$(data).find('msg').text();
                    $("#tblname").text($(data).find('Name').text());
                    $("#tblmrn").text($(data).find('mrn').text());
                    $("#tblsex").text($(data).find('Sex').text());
                    $("#tblhp").text($(data).find('telh').text());
                    $("#tbladdress1").text($(data).find('Address1').text());
                    $("#tbladdress2").text($(data).find('Address2').text());
                    $("#tbladdress3").text($(data).find('Address3').text());
                    $("#tblage").text($(data).find('age').text());
					$("#agentname").val($(data).find('agent').text());
					$("#pkgname").val($(data).find('pakage').text());
                    if($msg=='fail'){
                        alert($msg);
                    }
                });
            };
        </script>
    </head>
    <body>
        <span id="pagetitle">Subscription</span>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1"></h2>
                <div class="rfloat specfloat">      
                    <i class="topbar-divider"></i>
                    <button id="but_order" class="button" title="Order Entry" disabled>
                        <i id="orderIcon" class="iconButton"></i>
                        <p>Order</p>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_member" class="button" title="Member List" disabled>
                        <i id="listIcon" class="iconButton"></i>
                        <p>Member</p>
                    </button>                     
                </div>
            </div>
        </div>
        <!--<div class="placeholder" style="display: none;"><p id="memberName">Member List</p><span id="micon" class="maximize"></span></div>-->
        <div class="maindiv">
            <div class="alongdiv">
                <div class="smalltitle" style="position:relative">
                    <p >Member List</p>
                    <span id="micon" class="minimize" style="display:none"></span>
                </div>
                <div class="bodydiv">
                    <table>
                        <tr>
                            <td>
                                <label>Search by: </label><select id="searchField">
                                    <option selected value="Name">Name</option>
                                    <option value="MRN">MRN</option>
                                    <option value="IdNo">NRIC/Passport</option>
                                </select>
                            </td>
                            <td><input type="text" id="searchString" size="35"/></td>
                            <td>
                                <button id="but_search" class="button" title="Search" >
                                    <i id="searchIcon" class="iconButton"></i>Search
                                </button> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="alongdiv">
                <table id="tableMember"> </table>    
                <div id="tablePagerMember"></div>
            </div>
        </div>

        <div class="orderDiv" style="margin-top: 10px; display: block;display: none;">
            <div style="clear: both; margin-bottom: 15px;">            	
                <div class="content-body" style=" border-radius: 6px 6px 0 0; " >                    
                    <div class="body-inner" style="height: 1000px;">
                        <div id="tdTree" >
                            <div class="alongdiv" style="margin-top: 0;">
                                <div class="smalltitle"><p>Subscriber</p></div>
                                <div class="bodydiv" style="height: 300px;padding: 0;overflow-y:scroll" >
                                
                                    <table id="tblinfo" style="width:98%">
                                        <tr>
                                            <td colspan="4" id="tdatas">Detail</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td id="tblname"></td>
                                            <th>Address</th>
                                            <td id="tbladdress1"></td>
                                        </tr>
                                        <tr>
                                            <th>MRN</th>
                                            <td id="tblmrn"></td>
                                            <th></th>
                                            <td id="tbladdress2"></td>
                                        </tr>
                                        <tr>
                                            <th>Sex</th>
                                            <td id="tblsex"></td>
                                            <th></th>
                                            <td id="tbladdress3"></td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td id="tblage"></td>
                                            <th>Handphone</th>
                                            <td id="tblhp"></td>
                                        </tr>
                                    </table>              
									<table>
                                    	<tr>
                                        	<td>
                                            	<h3>Package :</h3>
                                            </td>
                                            <td>
                                             <input name="pkgname" id="pkgname" type="text" value="" readonly size="40"/>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            	<h3>Agent :</h3>
                                            </td>
                                            <td>
                                            <input name="agentname" id="agentname" type="text" value="" readonly size="40"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="alongdiv">
                                <table id="tableNominee"> </table>   
                            </div>
                            <div class="detailMenu">
                                <h2 id="content-main-heading" class="title1"></h2>
                                <div class="rfloat specfloat">   
                                    <i class="topbar-divider"></i>
                                    <button id="but_add_order" class="button" title="Add">
                                        <i id="addIcon" class="iconButton"></i>
                                        <p>Add</p>
                                    </button>       
                                </div>
                            </div>
                            <div class="tableDetail2">
                                <div class="sideleft" style=" width: 30%">
                                    <div class="smalltitle"><p>Episode</p></div>
                                    <div class="bodydiv" style="height:400px ">
                                        <div style="overflow:auto;float: right;">
                                            <table id="tableEpisode"> </table>    
                                            <div id="tablePagerEpisode"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sideleft" style=" width: 68%">
                                    <div class="smalltitle"><p>Order</p></div>
                                    <div class="bodydiv"  style="height:400px ">
                                        <div id="tableOrderDiv" style="overflow:auto;margin:auto;">
                                            <table id="tableOrderForm" border="0" cellspacing="0" cellpadding="0" >                                       			<tr>
                                                    <td><div class="jqGridField"><label for="chgCode">Code</label></div></td>
                                                    <td><div class="jqGridField"><label for="chgDesc">Description</label></div></td>
                                                    <td><div class="jqGridField"><label for="chgQuantity">Quantity</label></div></td>
                                                </tr>
                                                <tr><form id="chgTrxForm" method="post">
                                                        <td><input type="text" class="iForm" name="chgCode" id="chgCode" size="22">
                                                            <input name="help" type="button" id="help" value="..." tabIndex="-1"></td>
                                                        <td><input type="text" class="iForm" name="chgDesc" id="chgDesc" size="47" tabIndex="-1" readonly></td>
                                                        <td><input type="number" class="iForm" name="chgQuantity" id="chgQuantity" style="width: 80px;"></td>

                                                        <td style="display:none"> 
                                                            <input name="mrn" id="mrn1" type="text" value="" readonly />
                                                            <input name="amt1" class="iForm" id="amt1" type="text" value="amt1" readonly />
                                                            <input name="amt2" class="iForm" id="amt2" type="text" value="amt2" readonly />
                                                            <input name="chgTime" class="iForm" id="chgTime" type="text" value="chgTime" readonly />
                                                            <input name="epistycode1"id="epistycode1" type="text" value="epistycode1" readonly />
                                                            <input name="chgtype" class="iForm" id="chgtype" type="text" value="pkg" readonly />
                                                            <input name="episno1"id="episno1" type="text" value="" readonly />
                                                            <input name="opStatus" id="opStatus" type="text" value="" readonly />
                                                            <input name="chggroup" class="iForm" id="chggroup" type="text" value="chggroup" readonly />
                                                        </td>
                                                    </form>
                                                    <td>
                                                        <button id="saveChgTrx" class="buttonSmall" title="Save">
                                                            <i id="thickIcon" class="iconButton" style="margin-left:0"></i>
                                                        </button>
                                                        <button id="deleteChgTrx" class="buttonSmall" title="Delete" style="display:none">
                                                            <i id="delete1Icon" class="iconButton" style="margin-left:0"></i>
                                                        </button>
                                                        <button id="cancelChgTrx" class="buttonSmall" title="Cancel">
                                                            <i id="wrongIcon" class="iconButton" style="margin-left:0"></i>
                                                        </button>
                                                    </td>                                               
                                                </tr>
                                            </table>
                                            <div style="float: left;">
                                                <table id="tableOrder"> </table>    
                                                <div id="tablePagerOrder"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="paymentDiv" style="display:none">
            <div class="content-header-new">
                <div class="header-inner-new">
                    <h2 id="content-main-heading" class="title1">Payment</h2>
                </div>
            </div>
            <div style="clear: both; margin-bottom: 15px;">
                <div class="content-body" >
                    <div class="body-inner">
                        <div id="tdTree" >
                            <div style="clear: both;">
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>        
        <div id="dialogEpisode" title="Alert">
            <p id="dialogTextEpisode"></p>
        </div>
        <div id="dialogList" title="List">
            <div >
                <table id="chgmastList"> </table>    
                <div id="tablePagerChgmast"></div>
            </div>      
            <div class="alongdiv">
                <div class="smalltitle" style="position:relative"><p>Item Search</p><span id="micon" class="minimize"></span></div>
                <div class="bodydiv">
                    <table>
                        <tr>
                            <td><label>Search by: </label><select id="searchField2">
                                    <option selected value="word">Description/Brandname</option>
                                    <option  value="chgcode">Code</option>
                                </select></td>
                            <td>
                                <input type="text" id="searchString2" size="35"/>
                            </td>
                            <td>
                                <button id="but_search2" class="button" title="Search" >
                                    <i id="searchIcon" class="iconButton"></i>Search
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>    
        </div>
        <div id="dialogAlert" title="Alert">
            <p id="dialogText"></p>
        </div>
        <div id="dialogAlertClick" title="Alert">
            <p id="dialogTextClick"></p>
        </div>
    </body>
</html>