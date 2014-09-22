<?php
session_start();
//include_once('../sschecker.php');

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pakage</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
			var pakage;
			$(function(){
				$( "#tabs" ).tabs({ heightStyle: "auto" });//set height for tab
				$("#tablePt").jqGrid({
                    url:'tableList/pakage.php',
                    datatype: "xml",
                    colModel:[
                        {label:'Code',name:'pkgcode',index:'pkgcode',width:90},
                        {label:'Description',name:'description',index:'description',width:350},
                        {label:'Term',name:'term',index:'term',width:100}
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
						pakage=		ret.pkgCode;			
                        $("#pkgCode").val(ret.pkgCode);
						$("#pkgDescription").val(ret.description);
						$("#pkgTerm").val(ret.term);
						////age/payer////doctor
						$("#but_edit").prop("disabled",false);
                        $("#but_view").prop("disabled",false);
						$("#but_delete").prop("disabled",false);
                        //$("#tablePt").jqGrid().setGridParam({hidegrid: false});//display hide grid
						$(".minimize").show();
                        return(true);            
                    }
                });	
				$("#tablePakageDetail").jqGrid({
                    datatype: "xml",
                    colModel:[
                        {label:'pkgcode',name:'pkgcode',index:'pkgcode',width:86},
                        {label:'chgcode',name:'chgcode',index:'chgcode',width:175}, 					
                        {label:'description',name:'description',index:'description',width:372},
                        {label:'freqqty',name:'freqqty',index:'freqqty'},	
                        {label:'intervl',name:'intervl',index:'intervl',width:75}, 
                        {label:'maxqty',name:'maxqty',index:'maxqty',width:75}
                    ],
                    viewrecords: true,
                    height: "200",
					width:"974",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPakageDetail'),
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
				$("#dialogPkgMastForm").dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/pakage_maintenance_p.php',$('#formPkgHeader').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tablePt").jqGrid().trigger("reloadGrid");
                                    $( "#dialogPkgMastForm" ).dialog("close");
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
				$("#but_add").click(function(){
					$("#opStatus" ).val("insert");
					$("#dialogPkgMastForm" ).dialog( "open" );
				});
				$("#but_view").click(function(){
					//toggle screen
                    $(".maindiv").slideToggle("fast");
                    $(".placeholder").slideToggle("fast");
                    $(".secondDiv").slideToggle("fast");
					//toggle button
					$("#but_list").prop("disabled",false);
                    $("#but_view").prop("disabled",true);   
					$("#but_add").prop("disabled",true);
					$("#but_edit").prop("disabled",true);
					$("#but_delete").prop("disabled",true);                 
					/*$("#chgCode").focus();*/
					//call function		
					$("#tablePakageDetail").jqGrid().setGridParam({url:'tableList/pakageDetail.php?pakage='+pakage}).trigger("reloadGrid");
                });
				$("#but_list").click(function(){
					//toggle screen
                    $(".maindiv").slideToggle("fast");
                    $(".placeholder").slideToggle("fast");
                    $(".secondDiv").slideToggle("fast");
					//toggle button
                    $("#but_view").prop("disabled",false);
                    $("#but_list").prop("disabled",true);
					$("#but_add").prop("disabled",false);
					$("#but_edit").prop("disabled",false);
					$("#but_delete").prop("disabled",false);
                });
			});
        </script>
	</head>
<body>
	<span id="pagetitle">Pakage Maintenance</span>
	<?php include("../include/headerf.php")?>
    <?php include("../include/start.php")?>
    <div class="content-header-new">
        <div class="header-inner-new">
            <h2 id="content-main-heading" class="title1"></h2>
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
                <button id="but_view" class="button" title="Detail" disabled="true" >
                    <i id="viewIcon" class="iconButton"></i>
                    <p>Detail</p>
                </button>
                <i class="topbar-divider"></i>
                <button id="but_list" class="button" title="Pakage Header"  disabled="true">
                    <i id="listIcon" class="iconButton"></i>
                    <p>Pakage</p>
                </button>
        	</div>
        </div>
    </div>
    <div class="placeholder" style="display: none;"><p>Pakage List</p><span id="micon" class="maximize"></span></div>
    <div class="maindiv">
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative">
            	<p>Pakage List</p>
                <span id="micon" class="minimize" style="display:none"></span>
            </div>
            <div class="bodydiv">
                <table>
                    <tr>
                        <td><label>Search by: </label><select id="searchField">
                                <option selected value="Name">Name</option>
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
    </div>
    <div class="secondDiv" style="display:none">
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1">Pakage Detail</h2>
            </div>
        </div>
        <div style="clear: both; margin-bottom: 15px;">
        <div class="content-body" >
            <div class="body-inner">
            	<div id="tdTree" >
                    <div id="tabs" class="tabs" style="height:450px">
                        <ul>
                            <li><a href="#tabs-1">Detail</a></li>
                        </ul>
                        <div id="tabs-1" >    
                            <div  style="overflow:auto">
                                <table border="0" cellspacing="0" cellpadding="0">                                        
                                    <tr>
                                        <td><div class="jqGridField"><label for="pkgcode">pkgcode</label></div></td>
                                        <td><div class="jqGridField"><label for="chgcode">chgcode</label></div></td>
                                        <td><div class="jqGridField"><label for="pkgDtlDesc">description</label></div></td>
                                        <td><div class="jqGridField"><label for="freqqty">Frequency</label></div></td>
                                        <td><div class="jqGridField"><label for="chgQuantity">Interval</label></div></td>
                                        <td><div class="jqGridField"><label for="maxqty">Max Quantity</label></div></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr><form id="chgTrxForm" method="post">
                                        <td><input type="text" class="iForm" name="pkgcode" id="pkgcode" size="9"></td>
                                        <td><input type="text" class="iForm" name="chgcode" id="chgcode" size="16">
                                            <input name="help" type="button" id="help" value="..." tabIndex="-1"></td>
                                        <td><input type="text" class="iForm" name="pkgDtlDesc" id="pkgDtlDesc" size="50" tabIndex="-1"></td>
                                        <td><input type="number" class="iForm" name="freqqty" id="freqqty"  style="width:70px;"></td>
                                        <td><input type="number" class="iForm" name="intervl" id="intervl" style="width:70px;"></td>
                                        <td><input type="number" class="iForm" name="chgAmount" id="maxqty" style="width:90px;" ></td>
                                        <td style="display:none"> 
                                            <input name="mrn" id="mrn1" type="text" value="" readonly />
                                            <input name="amt1" class="iForm" id="amt1" type="text" value="" readonly />
                                            <input name="amt2" class="iForm" id="amt2" type="text" value="" readonly />
                                            <input name="chgTime" class="iForm" id="chgTime" type="text" value="" readonly />
                                            <input name="epistycode1"id="epistycode1" type="text" value="" readonly />
                                            <input name="chgtype" class="iForm" id="chgtype" type="text" value="" readonly />
                                            <input name="episno1"id="episno1" type="text" value="" readonly />
                                            <input name="opStatus1" id="opStatus1" type="text" value="" readonly />
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
                                <table id="tablePakageDetail"> </table>    
                                <div id="tablePagerPakageDetail"></div>
                            </div>
                        </div>
                    </div>
                </div>
     		</div>
    	</div>
    </div>
    <div id="dialogPkgMastForm" title="Pakage Header">
        <div class="alongdiv">
            <div class="bodydiv">
                <form id="formPkgHeader" method="post" action="">
                    <table>
                        <tr style="display:none">
                            <td >
                                <label for="pkgCode">Pakage Code:</label>
                            </td>
                            <td >
                                <input type="text" class="iForm" name="pkgCode" id="pkgCode" />
                            </td>
                        </tr>
                        <tr>
                           <td ><label for="pkgDescription">Description:</label></td>
                            <td colspan="3">
                                <input name="pkgDescription" class="iForm" type="text" id="pkgDescription" size="40" />
                            </td>
                        </tr>
                        <tr>
                            <td><label for="pkgTerm">Term</label></td>
                            <td><input type="text" class="iForm" name="pkgTerm" id="pkgTerm" /></td>
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
</body>
</html>