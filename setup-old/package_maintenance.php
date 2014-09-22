<?php
include_once('../sschecker.php');

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Package</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
			var pkg;
			$(function(){
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Button & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<	
				$("#tablePackage").jqGrid({
                    url:'tableList/package.php',
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
                    pager: jQuery('#tablePagerPackage'),
                    beforeSelectRow : function(rowid, e){
                        var ret=$("#tablePackage").jqGrid('getRowData',rowid);	
						pkg=rowid;			
                        $("#pkgCode").val(ret.pkgcode);
						$("#pkgDescription").val(ret.description);
						$("#pkgTerm").val(ret.term);
						////age/payer////doctor
						$("#but_edit").prop("disabled",false);
                        $("#but_view").prop("disabled",false);
                        //$("#tablePt").jqGrid().setGridParam({hidegrid: false});//display hide grid
						$(".minimize").show();
                        return(true);            
                    }
                });	
				$("#dialogPkgMastForm").dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/package_maintenance_p.php',$('#formPkgHeader').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tablePackage").jqGrid().trigger("reloadGrid");
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
					$("#dialogPkgMastForm" ).dialog("open");
					$("#pkgCode").val("");
					$("#pkgDescription").val("");
					$("#pkgTerm").val("");
					$("#but_list").prop("disabled",true);
                    $("#but_view").prop("disabled",true);   
					$("#but_edit").prop("disabled",true);
					$("#but_delete").prop("disabled",true);
					$("#tablePackage").jqGrid('resetSelection');
				});
				$("#but_edit").click(function(){
					$("#opStatus" ).val("update");
					$("#dialogPkgMastForm" ).dialog("open");
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
					$("#tablePackageDetail").jqGrid().setGridParam({url:'tableList/packageDetail.php?pkgcode='+pkg}).trigger("reloadGrid");
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
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				$("#tablePackageDetail").jqGrid({
					url:'tableList/packageDetail.php?pkgcode='+pkg,
                    datatype: "xml",
                    colModel:[
                        {label:'Package Code',name:'pkgcode',index:'pkgcode',width:90},
                        {label:'Charge Code',name:'chgcode',index:'chgcode',width:90}, 					
                        {label:'Description',name:'description',index:'description',width:500},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "250",
					width:"974",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageDetail'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageDetail").jqGrid('getRowData',rowid);
						$("#pkgCodeDetail").val(ret.pkgcode);
						$("#chgCodeDetail").val(ret.chgcode); 	
						$("#pkgDetailDescription").val(ret.description); 
						$("#freqqty").val(ret.freqqty);
						$("#intervl").val(ret.intervl); 
						$("#maxqty").val(ret.maxqty);
						//togle button n input state
						$("#but_edit_detail").prop("disabled",false);

                        return(true);            
                    }
                });						
				$("#dialogPkgDetailForm").dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/packageDetail_maintenance_p.php',$('#formPkgDetail').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tablePackageDetail").jqGrid().trigger("reloadGrid");
                                    $( "#dialogPkgDetailForm" ).dialog("close");
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
				$("#but_add_detail").click(function(){
					$(".iForm1" ).val("");
					$("#opStatusDetail" ).val("insert");
					$("#pkgCodeDetail" ).val(pkg);
					$("#but_edit_detail").prop("disabled",true);
					$("#tablePackageDetail").jqGrid('resetSelection');
					$("#dialogPkgDetailForm").dialog( "open" );
				});
				$("#but_edit_detail").click(function(){
					$("#opStatusDetail" ).val("update");
					$("#dialogPkgDetailForm" ).dialog("open");
				});
				$("input[name='detailType']").change(function(){
					$(".benefitOff").toggle();	
				});
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
			});
        </script>
	</head>
<body>
	<span id="pagetitle">Package Maintenance</span>
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
                <button id="but_view" class="button" title="Detail" disabled="true" >
                    <i id="viewIcon" class="iconButton"></i>
                    <p>Detail</p>
                </button>
                <i class="topbar-divider"></i>
                <button id="but_list" class="button" title="Package Header"  disabled="true">
                    <i id="listIcon" class="iconButton"></i>
                    <p>Package</p>
                </button>
        	</div>
        </div>
    </div>
    <div class="placeholder" style="display: none;"><p>Package List</p><span id="micon" class="maximize"></span></div>
    <div class="maindiv">
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative">
            	<p>Package List</p>
                <span id="micon" class="minimize" style="display:none"></span>
            </div>
            <div class="bodydiv">
                <table>
                    <tr>
                        <td>
                        	<label>Search by: </label><select id="searchField">
                                <option selected value="Name">Name</option>
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
            <table id="tablePackage"> </table>    
            <div id="tablePagerPackage"></div>
        </div>
    </div>
    <div class="secondDiv" style="display:none">
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1">Package Detail</h2>
                <div class="rfloat specfloat">   
                    <i class="topbar-divider"></i>
                    <button id="but_add_detail" class="button" title="Add">
                        <i id="addIcon" class="iconButton"></i>
                        <p>Add</p>
                    </button>
                    <i class="topbar-divider"></i>
                    <button id="but_edit_detail" class="button" title="Edit" disabled="true">
                        <i id="editIcon" class="iconButton"></i>
                        <p>Edit</p>
                    </button>            
                </div>
            </div>
        </div>
        <div style="clear: both; margin-bottom: 15px;">
        <div class="content-body" >
            <div class="body-inner">
            	<div id="tdTree" >
                    <div style="clear: both;">
                        <table id="tablePackageDetail"> </table>    
                    <div id="tablePagerPackageDetail"></div>
                </div>      
     		</div>
    	</div>
    </div>
    <div id="dialogPkgMastForm" title="Package Header">
     	
        <div class="alongdiv">
            <div class="bodydiv">
                <form id="formPkgHeader" method="post" action="">
                    <table>
                        <tr style="display:none">
                            <td >
                                <label for="pkgCode">Package Code:</label>
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
                            <td><label for="pkgTerm">Term(Years):</label></td>
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
    <div id="dialogPkgDetailForm" title="Package Detail">
    	<form id="formPkgDetail" method="post" action="">
    	<div class="alongdiv">
            <div class="bodydiv">
            	<input type="radio" name="detailType" value="Programme" checked>Programme
				<input type="radio" name="detailType" value="Benefit">Benefit
            </div>
        </div>
        <div id="detailProgramme" class="alongdiv">
            <div class="bodydiv">                
                    <table>
                        <tr>
                        	<td ><label for="pkgDetailDescription">Description:</label></td>
                            <td colspan="3">
                                <input name="pkgDetailDescription" class="iForm1" type="text" id="pkgDetailDescription" size="40" />
                            </td>
                        </tr>
                        <tr class="benefitOff">
                            <td><label for="freqqty">Frequency:</label></td>
                            <td><input type="text" class="iForm1" name="freqqty" id="freqqty" /></td>
                        </tr>
                        <tr class="benefitOff">
                            <td><label for="intervl">Interval Each Test (Years):</label></td>
                            <td><input type="text" class="iForm1" name="intervl" id="intervl" /></td>
                        </tr>
                        <tr >
                            <td><label for="maxqty">Max Test Quantity:</label></td>
                            <td><input type="text" class="iForm1" name="maxqty" id="maxqty" /></td>
                        </tr>
                        <tr >
                            <td style="display:none">
                            	<input type="text" class="iForm1" name="pkgCodeDetail" id="pkgCodeDetail" />
                                <input type="text" class="iForm1" name="chgCodeDetail" id="chgCodeDetail" />
                                <input type="text" name="opStatusDetail" id="opStatusDetail">
                            </td>
                        </tr>
                    </table>                
            </div>
        </div>
        </form>
    </div>
</body>
</html>