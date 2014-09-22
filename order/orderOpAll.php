<?php
session_start();
/*$epistype=$_GET["epistype"];
if ($epistype=="op"||$epistype=="dp"){
		
}*/
$isuedept="";
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ordering</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
            var mrn,episno,mrnOld,chgCode,chgDesc,amt1,amt2,fieldName;
            $(function(){
				var now = new Date();
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = (day)+"/"+(month)+"/"+now.getFullYear() ;
				
                $( "#tabs" ).tabs({ heightStyle: "auto" });//set height for tab
	//-------------------insert total amount at tab header-------------->>>>start
				var textElement = $("<label for='total'>Total Amount : </label>");
				var totalElement = $('<input type="text" class="" name="total" id="total" size="12" tabIndex="-1" readonly>');
				textElement.css('position', 'absolute');
				textElement.css('right', '170px');
				textElement.css('top', '15px');
				totalElement.css('position', 'absolute');
				totalElement.css('right', '40px');
				totalElement.css('top', '7px');
				$("#tabs").append(textElement);
				$("#tabs").append(totalElement);
	//-------------------insert total amount at tab header-------------->>>>end
                $("#tablePt").jqGrid({
                    url:'tableList/orderPt.php?deptcode=all&epistycode=op',
                    datatype: "xml",
                    colModel:[
                        {label:'Date',name:'reg_date',index:'reg_date',width:90},
                        {label:'Membership',name:'memberno',index:'memberno',width:100},
                        {label:'Name',name:'name',index:'name',width:350}, 
                        {label:'Tel. Home',name:'telh',index:'telh',width:90}, 
                        {label:'Tel. HP',name:'telhp',index:'telhp',width:90},   
                        {label:'DOB',name:'DOB',index:'DOB',width:80},   
                        {label:'Citizen',name:'citiDes',index:'citiDes',width:90}  ,
                        {label:'debtorName',name:'debtorName',index:'debtorName',hidden:true},
						{label:'payercode',name:'payercode',index:'payercode',hidden:true},
                        {label:'Newic',name:'Newic',index:'Newic',hidden:true},   
                        {label:'ageyy',name:'ageyy',index:'ageyy',hidden:true},
                        {label:'Sex',name:'Sex',index:'Sex',hidden:true} ,
                        {label:'caseDes',name:'caseDes',index:'caseDes',hidden:true} , 
                        {label:'mrn',name:'mrn',index:'mrn',hidden:true} ,
                        {label:'episno',name:'episno',index:'episno',hidden:true},
						{label:'epistycode',name:'epistycode',index:'epistycode',hidden:true}  ,
						{label:'regdept',name:'regdept',index:'regdept',hidden:true}     
                    ],
                    viewrecords: true,
                    height: "250",
                    autowidth: true,
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPt'),
                    beforeSelectRow : function(rowid, e){
                        var ret=$("#tablePt").jqGrid('getRowData',rowid);						
                        mrn=ret.mrn;
                        episno=ret.episno;
                        $("#debtor").val(ret.debtorName);
						$("#payercode").val(ret.payercode);
						$("#payername").val(ret.debtorName);
                        $("#case").val(ret.caseDes);
						$("#mrn").val(ret.mrn);
						$("#mrn1").val(ret.mrn);
						$("#name").val(ret.name);
						$("#dob").val(ret.DOB);
						$("#sex").val(ret.Sex);
						$("#episno").val(ret.episno);
						$("#episno1").val(ret.episno);
						$("#reg_date").val(ret.reg_date);
						$("#caseO").val(ret.caseDes);
						$("#epistycode").val(ret.epistycode);
						$("#epistycode1").val(ret.epistycode);
						$("#chgDept").val(ret.regdept);
						////age/payer////doctor
                        $("#orderButton").prop("disabled",false);
                        $("#tablePt").jqGrid().setGridParam({hidegrid: false});//display hide grid
						$(".minimize").show();
						$("#cancelChgTrx").click();
                        return(true);            
                    },
                    onHeaderClick:function(){
                        $(".tableDetail").slideToggle( "fast" );
                    }
                });

                $("#tableOrder").jqGrid({
                    datatype: "xml",
                    colModel:[
                        {label:'Date',name:'trxdate',index:'trxdate',width:89},
                        {label:'Code',name:'chgcode',index:'chgcode',width:175}, 					
                        {label:'description',name:'description',index:'description',width:372},
                        {label:'isudept',name:'isudept',index:'isudept'},	
                        {label:'quantity',name:'quantity',index:'quantity',width:75}, 
                        {label:'amount',name:'amount',index:'amount',width:75},					
                        {label:'TT',name:'trxtype',index:'trxtype',width:46} ,
						{label:'trxtime',name:'trxtime',index:'trxtime',width:46,hidden:true},    
                    ],
                    viewrecords: true,
                    height: "200",
					width:"974",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPt'),
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
						$("#chgDate").val(ret.trxdate); 
						$("#chgTime").val(ret.trxtime);
						$("#chgQuantity").val(ret.quantity); 
						$("#chgAmount").val(ret.amount); 
                        return(true);            
                    }
					
                });
				$("#gbox_tableOrder .ui-jqgrid-hdiv").hide(); //hide table column title
				
				$("#chgmastList").jqGrid({
                    datatype: "xml",
                    colModel:[
                        {label:'Code',name:'chgcode',index:'chgcode', width:100},
                        {label:'Description',name:'description',index:'description', width:270},
						{label:'Brandname',name:'brandname',index:'brandname', width:270} ,
						{label:'amt1',name:'amt1',index:'amt1',hidden:true},
						{label:'amt2',name:'amt2',index:'amt2',hidden:true},  						
						{label:'chgtype',name:'chgtype',index:'chgtype',hidden:true},
						{label:'chggroup',name:'chggroup',index:'chgtype',hidden:true}
                    ],
                    rowNum:10,
                    viewrecords: true,
                    height: "300",
                    caption: "Charge Master",
					altRows: true,
					rowList:[10,20,30],
					pager: jQuery('#tablePagerChgmast'),
                    beforeSelectRow: function(rowid, e){      
                        var ret=$("#chgmastList").jqGrid('getRowData',rowid);   
                        chgCode=rowid;
						chgDesc=ret.description;
						amt1=ret.amt1;
						amt2=ret.amt2;
						$("#amt1").val(amt1);
						$("#amt2").val(amt2);
						$("#chgtype").val(ret.chgtype);
						$("#chggroup").val(ret.chggroup);
                        return(true); 
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
							
                            $( this ).dialog( "close" );
							$("#chgDept").focus();
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
							$("#chgCode").focus();
                        }
                    }
                });
				$( "#dialogAlertClick" ).dialog({//alert when click button
                    autoOpen: false,
                    width: 400,
                    modal: true
                });
				var alertClickDelete={
					"Delete":function(){
                     	$("#opStatus").val("delete");
						$.post('process/orderChgTrx.php',$('#chgTrxForm').serialize(),function(data){
							$msg=$(data).find('msg').text();
							if($msg=='success'){
								$("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno}).trigger("reloadGrid");	
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
			   	$( "#chgDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
				});
				$( "#searchDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
				});
				$('#chgDate').val(today);
                $("#orderButton").click(function(){
					//toggle screen
                    $(".maindiv").slideToggle("fast");
                    $(".placeholder").slideToggle("fast");
                    $(".secondDiv").slideToggle("fast");
					//toggle button
                    $("#orderButton").prop("disabled",true);
                    $("#listButton").prop("disabled",false);
					$("#chgCode").focus();
					//call function		
					$("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno}).trigger("reloadGrid");		
					var dob = new Date($("#dob").val());
					var today = new Date();
					var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
					$("#age").val(age);
					
					 
                });
				
                $("#listButton").click(function(){
					//toggle screen
                    $(".maindiv").slideToggle("fast");
                    $(".placeholder").slideToggle("fast");
                    $(".secondDiv").slideToggle("fast");
					//toggle button
                    $("#orderButton").prop("disabled",false);
                    $("#listButton").prop("disabled",true)
                });
				$("#but_refresh").click(function(){
					//toggle screen
                    $(".maindiv").show("fast");
                    $(".placeholder").hide("fast");
                    $(".secondDiv").hide("fast");
					//toggle button
                    $("#orderButton").prop("disabled",true);
                    $("#listButton").prop("disabled",true)
					//refresh all table 
					$("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno}).trigger("reloadGrid");
					$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php'}).trigger("reloadGrid");
					$("#tablePt").jqGrid().setGridParam({url:'tableList/orderPt.php?deptcode=all&epistycode=op'}).trigger("reloadGrid");	
                });
				$("#chgQuantity").change(function(){
					$("#chgAmount").val($("#chgQuantity").val()*amt1);	
				});
				$("#help").click(function(){
					$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php'}).trigger("reloadGrid");
					$("#dialogList").dialog( "open" );	
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
									$('#dialogText').text("Charge Code not in database");
									$("#chgDesc").val("");
									$( "#dialogAlert" ).dialog( "open" );	
								}
								else if($msg=='pop'){
									if ($("#chgCode").val()=="") return 0;
									$("#dialogList").dialog( "open" );
									$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php?chgCode='+$("#chgCode").val()}).trigger("reloadGrid");	
								}
								else{
									/*$value=$(data).find('value').text();*/
									amt1=$(data).find('amt1').text();
									amt2=$(data).find('amt2').text();
									$("#chgDept").focus();	
									$("#amt1").val($(data).find('amt1').text());
									$("#amt2").val($(data).find('amt2').text());
									$("#chgtype").val($(data).find('chgtype').text());
									$("#chggroup").val($(data).find('chggroup').text());
									$("#chgDesc").val($(data).find('description').text()); 	
									$("#chgAmount").val(''); 
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
				$("#cancelChgTrx").click(function(){
					//empty form
					$('.iForm').val('');
					$('#chgDate').val(today);
					//togle enable disable
					$('.iForm').prop("readonly",false); 
					$('#chgDept').prop("readonly",false);
					$("#help").prop("disabled",false); 
					//togle button delete n save
					$("#saveChgTrx").show();
					$("#deleteChgTrx").hide();
					$("#chgCode").focus();
					
					$("#tableOrder").jqGrid('resetSelection');
				});
				$("#saveChgTrx").click(function(){
					$("#opStatus").val("insert");
					$.post('process/orderChgTrx.php',$('#chgTrxForm').serialize(),function(data){
						$msg=$(data).find('msg').text();
						if($msg=='success'){
							$("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno}).trigger("reloadGrid");	
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
				$(".minimize").click(function(){
					$("#orderButton").click();
				});
				$(".maximize").click(function(){
					$("#listButton").click();
				});
				
				//START/coding section for searching table and data		
				$("#searchString").on('keydown',  function(e) { //search pt
					var keyCode = e.keyCode || e.which; 
					//check for tab n enter key 
					if (keyCode == 9 || keyCode == 13) { 
						e.preventDefault(); 
						//check length of character
						searchPt();
					} 
				});
				$("#but_search").click(function(){//search pt
					searchPt();	
				});
				/*
				$("#searchField1").change(function(){
					if($("#searchField1").val()=="trxdate"){
						$("#searchString1").val("");
						$('#searchDate').val(today);	
						$("#searchString1").hide("fast");
						$("#searchDate").show("fast");	
					}
					else{
						$("#searchString1").val("");
						$('#searchDate').val(today);
						$("#searchString1").show("fast");
						$("#searchDate").hide("fast");
					}
				});
				$("#searchString1").on('keydown',  function(e) { //search pt
					var keyCode = e.keyCode || e.which; 
					//check for tab n enter key 
					if (keyCode == 9 || keyCode == 13) { 
						e.preventDefault(); 
						//check length of character
						searchOrder(mrn,episno);
					} 
				});
				$("#but_search1").click(function(){//search pt
					searchOrder(mrn,episno);	
				});
				$("#searchDate").on('keydown',  function(e) { //search pt
					var keyCode = e.keyCode || e.which; 
					//check for tab n enter key 
					if (keyCode == 9 || keyCode == 13) { 
						e.preventDefault(); 
						//check length of character
						searchOrder(mrn,episno);
					} 
				});*/
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
				//END/coding section for searching table and data 
            });
			function searchPt(){
				var trf = $("#tablePt tbody:first tr:first")[0];
				$("#tablePt tbody:first").empty().append(trf);
				$("#tablePt").jqGrid().setGridParam({url:'tableList/orderPt.php?deptcode=all&epistycode=op&searchString='+$("#searchString").val()+'&searchField='+$("#searchField").val()}).trigger("reloadGrid");
			};
			function searchOrder(mrn,episno){
				var trf = $("#tableOrder tbody:first tr:first")[0];
				$("#tableOrder tbody:first").empty().append(trf);
				$("#tableOrder").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno+'&searchString1='+$("#searchString1").val()+'&searchField1='+$("#searchField1").val()+'&searchDate='+$("#searchDate").val()}).trigger("reloadGrid");
			};
			function searchChgmast(){
				var trf = $("#tableOrder tbody:first tr:first")[0];
				$("#tableOrder tbody:first").empty().append(trf);
				$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php?searchString2='+$("#searchString2").val()+"&searchField2="+$("#searchField2").val()}).trigger("reloadGrid");
			};
        </script>
    </head>

    <body>
        <span id="pagetitle">Patient Order</span>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1"></h2>
                <div class="rfloat specfloat">   
                    <i class="topbar-divider"></i>
                    <button id="listButton" class="button" title="Patient List" disabled>
                        <i id="listIcon" class="iconButton"></i>
                        <p>Patient</p>
                    </button>                   
                    <i class="topbar-divider"></i>
                    <button id="orderButton" class="button" title="Order" disabled>
                        <i id="orderIcon" class="iconButton"></i>
                        <p>Order</p>
                    </button> 
                    <i class="topbar-divider"></i>
                    <button id="but_refresh" class="button" title="Refresh Data" >
                        <i id="refreshIcon" class="iconButton"></i>
                        <p>Refresh</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="placeholder" style="display: none;"><p>Patient List</p><span id="micon" class="maximize"></span></div>
        <div class="maindiv">
            <div class="alongdiv">
                <div class="smalltitle" style="position:relative"><p>Patient List</p><span id="micon" class="minimize" style="display:none"></span></div>
                <div class="bodydiv">
                    <table>
                        <tr>
                            <td><label>Search by: </label><select id="searchField">
                                    <option selected value="Name">Name</option>
                                    <option value="Membership">Membership</option>
                                </select></td>
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
                <table id="tablePt"> </table>    
                <div id="tablePagerPt"></div>
            </div>
            <div class="alongdiv">
                <div class="smalltitle" style="position:relative"><p>Patient Details</p></div>
                <div class="bodydiv">
                    <div style="width: 40%;margin: 0 auto;">
                        <table>
                            <tr>
                                <td >
                                    <label for="debtor">Debtor</label>
                                </td>
                                <td >
                                    <input type="text"  name="debtor" id="debtor" size="40" readonly/>
                                </td>                            
                            </tr>
                            <tr>
                                <td ><label for="case">Case</label></td>
                                <td colspan="3">
                                    <input name="case" type="text" id="case" size="40" readonly/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="secondDiv" style="display:none">
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1">Order Entry</h2>
            </div>
        </div>
        <div class="content-body" >
            <div class="body-inner">
                <div id="tdTree" >
                    <div class="tableDetail2">
                        <div class="sideleft">
                            <div class="smalltitle"><p>Biodata</p></div>
                            <div class="bodydiv">
								<table border="0" cellspacing="0" cellpadding="0" style="height:156px">
                                  <tr>
                                    <td><label>MRN:</label></td>
                                    <td><input name="mrn" id="mrn" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Name: </label></td>
                                    <td><input name="name" id="name" type="text" value="" size="60" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>DOB: </label></td>
                                    <td><input name="dob" id="dob" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Sex: </label></td>
                                    <td><input name="sex" id="sex" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Age: </label></td>
                                    <td><input name="age" id="age" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Payer: </label></td>
                                    <td>
                                    	<input name="payercode" id="payercode" type="text" value="" size="10" readonly />
                                        <input type="text"  name="payername" id="payername" size="50" readonly/>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        <div class="sideleft">
                            <div class="smalltitle"><p>Episode</p></div>
                            <div class="bodydiv" style="height:156px">
								<table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><label>Episode No: </label></td>
                                    <td><input name="episno" id="episno" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Episode Type: </label></td>
                                    <td><input name="epistycode" id="epistycode" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Date: </label></td>
                                    <td><input name="reg_date" id="reg_date" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Case: </label></td>
                                    <td><input name="caseO" id="caseO" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Doctor: </label></td>
                                    <td><input name="doctor" id="doctor" type="text" value="" readonly /></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both; margin-bottom: 15px;">
                        <div id="tabs" class="tabs" style="height:450px">
                            <ul>
                                <li><a href="#tabs-1">Charge Item</a></li>
                                <li><a href="#tabs-2">Return Item</a></li>
                            </ul>
                            <div id="tabs-1" >    
                            	<div  style="overflow:auto">
                                
                                    <table border="0" cellspacing="0" cellpadding="0">                                        
                                            <tr>
                                                <td><div class="jqGridField"><label for="chgDate">Date</label></div></td>
                                                <td><div class="jqGridField"><label for="chgCode">Code</label></div></td>
                                                <td><div class="jqGridField"><label for="chgDesc">Description</label></div></td>
                                                <td><div class="jqGridField"><label for="chgDept">Dept</label></div></td>
                                                <td><div class="jqGridField"><label for="chgQuantity">Quantity</label></div></td>
                                                <td><div class="jqGridField"><label for="chgAmount">Amount</label></div></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr><form id="chgTrxForm" method="post">
                                                <td><input type="text" class="iForm" name="chgDate" id="chgDate" style="width: 82px;"></td>
                                                <td><input type="text" class="iForm" name="chgCode" id="chgCode" size="16">
                                                    <input name="help" type="button" id="help" value="..." tabIndex="-1"></td>
                                                <td><input type="text" class="iForm" name="chgDesc" id="chgDesc" size="47" tabIndex="-1" readonly></td>
                                                <td><input type="text" name="chgDept" id="chgDept" size="17" value=""> </td>
                                                <td><input type="number" class="iForm" name="chgQuantity" id="chgQuantity" size="9" style="width: 70px;"></td>
                                                <td><input type="text" class="iForm" name="chgAmount" id="chgAmount" size="7" tabIndex="-1" readonly></td>
                                                <td style="display:none"> 
                                                	<input name="mrn" id="mrn1" type="text" value="" readonly />
                                                    <input name="amt1" class="iForm" id="amt1" type="text" value="" readonly />
                                                    <input name="amt2" class="iForm" id="amt2" type="text" value="" readonly />
                                                    <input name="chgTime" class="iForm" id="chgTime" type="text" value="" readonly />
                                                    <input name="epistycode1"id="epistycode1" type="text" value="" readonly />
                                                    <input name="chgtype" class="iForm" id="chgtype" type="text" value="" readonly />
                                                    <input name="episno1"id="episno1" type="text" value="" readonly />
                                                    <input name="opStatus" id="opStatus" type="text" value="" readonly />
                                                    <input name="chggroup" class="iForm" id="chggroup" type="text" value="" readonly />
                                                </td>
                                                </form>
                                                <td>
                                                	<button id="saveChgTrx" class="buttonSmall" title="Save">
                                                		<i id="thickIcon" class="iconButton"></i>
                                                	</button>
                                                    <button id="deleteChgTrx" class="buttonSmall" title="Delete" style="display:none">
                                                		<i id="delete1Icon" class="iconButton"></i>
                                                	</button>
                                                    <button id="cancelChgTrx" class="buttonSmall" title="Cancel">
                                                    	<i id="wrongIcon" class="iconButton"></i>
                                                	</button>
                                                 </td>                                               
                                            </tr>
                                        </table>
                                    <div style="clear: both;">
                                        <table id="tableOrder"> </table>    
                                        <div id="tablePagerOrder"></div>
                                    </div>
                                    <!--<div class="alongdiv" style="width: 99.6%;">
                                        <div class="smalltitle" style="position:relative"><p>Charge Search</p><span id="micon" class="minimize"></span></div>
                                        <div class="bodydiv">
                                            <table>
                                                <tr>
                                                    <td><label>Search by: </label><select id="searchField1">
                                                            <option selected value="description">Description</option>
                                                            <option  value="trxdate">Date</option>
                                                            <option value="chgcode">Code</option>
                                                        </select></td>
                                                    <td>
                                                    	<input type="text" id="searchString1" size="35"/>
                                                        <input type="text" name="searchDate" id="searchDate" style="width: 82px;" hidden>
                                                    </td>
                                                    <td>
                                                        <button id="but_search1" class="button" title="Search" >
                                                            <i id="searchIcon" class="iconButton"></i>Search
                                                        </button>
                                                     </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>-->
                            	</div>
                            </div>
                            <div id="tabs-2">                               
                            </div>                          
                        </div>
                    </div> 
                </div> 
            </div> 
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
        <div id="dialogAlertClick" title="Alert">
            <p id="dialogTextClick"></p>
        </div>
        <div id="dialogAlert" title="Alert">
            <p id="dialogText"></p>
        </div>
        <?php include("../include/end.php")?>
    </body>
</html>