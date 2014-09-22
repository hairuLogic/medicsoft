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
        <link rel="shortcut icon" href="../img/icon/medicsoftLOGO-favicon.ico?v=2" > 
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
            var pkg,effectdate;
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
                        $("#pkgname").text(ret.description);
                        $("#pkgTerm").val(ret.term);
						$("#pkgCodeDetail").val(ret.pkgcode);
						$("#pkgCodeBenefit").val(ret.pkgcode);
						$("#pkgCodeEffect").val(ret.pkgcode);
						$("#pkgDescriptionEffect").val(ret.description);
						$("#pkgTermEffect").val(ret.term);
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
				$( "#pkgHeadEffectDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
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
					$(".pkgHeadDate").show();
					$("#pkgDescription").prop("readonly",false);	
                });
                $("#but_edit").click(function(){
                    $("#opStatus" ).val("update");
                    $("#dialogPkgMastForm" ).dialog("open");
					$(".pkgHeadDate").hide();
					$("#pkgDescription").prop("readonly",true);	
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
                    $("#packageButton").toggle();
                    $("#mainButton").toggle();                
                    /*$("#chgCode").focus();*/
                    //call function		                    
					$("#tablePackageEffect").jqGrid().setGridParam({url:'tableList/packageEffect.php?pkgcode='+pkg,datatype:'xml'}).trigger("reloadGrid");
					resetTablePackageBenefit(pkg);					
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
                    $("#packageButton").toggle();
                    $("#mainButton").toggle();   
                });
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Effecct  & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				$("#tablePackageEffect").jqGrid({
                    datatype: "local",
                    colModel:[					
                        {label:'Effective Date',name:'pkgEffDate',index:'pkgEffDate',width:100},
                        {label:'Description',name:'description',index:'description',width:350},
                        {label:'Price',name:'price',index:'price',width:100}
                    ],
                    viewrecords: true,
                    height: "150",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageEffect'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageEffect").jqGrid('getRowData',rowid);
						effectdate=ret.pkgEffDate;
						$("#pkgPrice").val(ret.price);
						$("#pkgEffectDate").val(ret.pkgEffDate);
						$("#pkgEffectDateOld").val(ret.pkgEffDate);
						$("#pkgEffectDateDetail").val(ret.pkgEffDate);
						$("#but_edit_effect").prop("disabled",false);
						$("#but_add_detail").prop("disabled",false);
						resetTablePackageDetail(pkg,effectdate);
						
                        return(true);            
                    }
                });	
				$("#dialogEffectiveForm").dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/package_maintenance_effect.php',$('#formPkgEffective').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    $("#tablePackageEffect").jqGrid().trigger("reloadGrid");
                                    $("#dialogEffectiveForm").dialog("close");
                                }
								else if($msg=='countfail'){
									$('#dialogText').text("Item already use by patient. Update Fail.");
                                    $( "#dialogAlert" ).dialog( "open" );
									$("#dialogEffectiveForm").dialog("close");	
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
				$( "#but_add_effect" ).click(function(){
					$("#opStatusEffect").val("insert");
					$("#pkgPrice").val("");
					$("#pkgEffectDate").val("");
					$("#pkgEffectDateOld").val("");
					$("#tablePackageEffect").jqGrid('resetSelection');
					$("#but_edit_effect").prop("disabled",true);
					$("#dialogEffectiveForm").dialog("open");
					$("#pkgPrice").focus();
				});
				$( "#but_edit_effect" ).click(function(){
					$("#opStatusEffect").val("update");
					$("#dialogEffectiveForm").dialog("open");
					$("#pkgPrice").focus();
				});
			   	$( "#pkgEffectDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
				});				
				
				//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Header Effecct & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                $( "#tabs" ).tabs();//set height for tab
                
                $("#tablePackageBenefit").jqGrid({
                    datatype: "local",
                    colModel:[
                        {label:'Effective Date',name:'detEffDate',index:'detEffDate',width:100},
						{label:'Expiry Date',name:'detExpDate',index:'detExpDate',width:100},					
                        {label:'Description',name:'description',index:'description',width:200},
                        {label:'Remark',name:'remark',index:'remark',width:300},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90, hidden:true},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90, hidden:true}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90},
						{label:'Max Quantity',name:'chgcode',index:'chgcode',width:90, hidden:true}
                    ],
                    viewrecords: true,
                    height: "250",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageBenefit'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageBenefit").jqGrid('getRowData',rowid);
						$("#chgCodeBenefit").val(ret.chgcode);
						$("#pkgBenefitDescription").val(ret.description);
						$("#remarkBenefit").val(ret.remark);
						$("#maxqtyBenefit").val(ret.maxqty);
						$("#benefitEffectDate").val(ret.detEffDate);
						$("#benefitExpiredDate").val(ret.detExpDate);
						
						$("#but_edit_benefit").prop("disabled",false);	
                        return(true);            
                    }
                });		
				$("#dialogPkgBenefitForm").dialog({//alert when mandatory item not enter
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/packageBenefit_maintenance_p.php',$('#formPkgBenefit').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    resetTablePackageBenefit(pkg);
                                    $( "#dialogPkgBenefitForm" ).dialog("close");
                                }
                                else if($msg=='countfail'){
									$('#dialogText').text("Item already use by patient. Update Fail.");
                                    $( "#dialogAlert" ).dialog( "open" );
									$("#dialogPkgBenefitForm").dialog("close");	
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
				$("#tablePackageDetail").jqGrid({
                    datatype: "local",
                    colModel:[
                        {label:'Effective Date',name:'detEffDate',index:'detEffDate',width:100, hidden:true},					
                        {label:'Description',name:'description',index:'description',width:200},
                        {label:'Remark',name:'remark',index:'remark',width:300},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "250",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageDetail'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageDetail").jqGrid('getRowData',rowid);                        
                        $("#chgCodeDetail").val(rowid); 	
                        $("#pkgDetailDescription").val(ret.description); 
                        $("#freqqty").val(ret.freqqty);
                        $("#intervl").val(ret.intervl); 
                        $("#maxqty").val(ret.maxqty);
                        $("#remarkDetail").val(ret.remark);
                        //togle button n input state
                        $("#but_edit_detail").prop("disabled",false);
                        return(true);            
                    }
                });						
                $("#dialogPkgDetailForm").dialog({//alert when mandatory item not enterdialog 
                    autoOpen: false,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Save":function(){
                            $.post('process/packageDetail_maintenance_p.php',$('#formPkgDetail').serialize(),function(data){
                                $msg=$(data).find('msg').text();
                                if($msg=='success'){
                                    resetTablePackageDetail(pkg,effectdate);
                                    $( "#dialogPkgDetailForm" ).dialog("close");
                                }
                                else if($msg=='countfail'){
									$('#dialogText').text("Item already use by patient. Update Fail.");
                                    $( "#dialogAlert" ).dialog( "open" );
									$("#dialogPkgDetailForm").dialog("close");	
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
				$( "#benefitEffectDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
				});
				$( "#benefitExpiredDate" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat:"dd/mm/yy"
				});
				
                $("#but_add_detail").click(function(){
					$("input[name='detailType']")[0].checked = true;
                    $(".iForm1" ).val("");
                    $("#opStatusDetail" ).val("insert");
                    $("#but_edit_detail").prop("disabled",true);
                    $("#tablePackageDetail").jqGrid('resetSelection');
                    $("#dialogPkgDetailForm").dialog( "open" );
					$("#radioPkgDetail").show();
					$("#helpPkgDetail").show();
                });
                $("#but_edit_detail").click(function(){					
					$("#buttonClick" ).val("detail");
                    $("#opStatusDetail" ).val("update");
                    $("#dialogPkgDetailForm" ).dialog("open");
					$("#radioPkgDetail").hide();
					$("#helpPkgDetail").hide();
                });
				
				$("#but_add_benefit").click(function(){
					$("input[name='benefitType']")[0].checked = true;
                    $(".iForm2" ).val("");
                    $("#opStatusBenefit" ).val("insert");
                    $("#but_edit_Benefit").prop("disabled",true);
                    $("#tablePackageBenefit").jqGrid('resetSelection');
                    $("#dialogPkgBenefitForm").dialog( "open" );
					$("#radioPkgBenefit").show();
					$("#helpPkgBenefit").show();
                });
                $("#but_edit_benefit").click(function(){
                    $("#opStatusBenefit" ).val("update");
                    $("#dialogPkgBenefitForm" ).dialog("open");
					$("#radioPkgBenefit").hide();
					$("#helpPkgBenefit").hide();
                });
				
                $("input[name='detailType']").change(function(){
					
					if($("input[name=detailType]:checked").val()=="new"){
                    	$("#pkgDetailDescription").prop("readonly",false);	
						$("#helpPkgDetail").hide();	
					}
					else{
                    	$("#pkgDetailDescription").prop("readonly",true);
						$("#helpPkgDetail").show();	
					}
					$("#formPkgDetail .iForm1").val("");
                });
				$("input[name='benefitType']").change(function(){
					if($("input[name=benefitType]:checked").val()=="new"){
                    	$("#pkgBenefitDescription").prop("readonly",false);	
						$("#helpPkgBenefit").hide();
					}
					else{
                    	$("#pkgBenefitDescription").prop("readonly",true);	
						$("#helpPkgBenefit").show();
					}
					$("#formPkgBenefit .iForm1").val("");
                });
				
				
				$("#helpPkgDetail").click(function(){
					$("#dialogPkgDetailList").dialog("open");					
					resetTableExtPkgDetail(pkg);
				});
				$("#helpPkgBenefit").click(function(){
					$("#dialogPkgBenefitList").dialog("open");
					resetTableExtPkgBenefit(pkg);
				});
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Detail Button & Function ENDDD<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				
			///////////////////////////////help
				$("#tableExtPkgDetail").jqGrid({
                    datatype: "local",
                    colModel:[					
                        {label:'Description',name:'description',index:'description',width:200},
                        {label:'Remark',name:'remark',index:'remark',width:300},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "200",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    onSelectRow : function(rowid, e){
                        var ret=$("#tableExtPkgDetail").jqGrid('getRowData',rowid);
						$("#chgCodeDetail").val(rowid);
						$("#pkgDetailDescription").val(ret.description);
						$("#remarkDetail").val(ret.remark);
						$("#freqqty").val(ret.freqqty);
						$("#intervl").val(ret.intervl);
						$("#maxqty").val(ret.maxqty);						
                        return(true);            
                    }
                });	
				$("#dialogPkgDetailList").dialog({//alert when mandatory item not enter dialogPkgBenefitForm
                    autoOpen: false,
                    width: 820,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
							$("#freqqty").focus();
							$( this ).dialog( "close" );
                        },
                        Cancel: function() {
							$("#formPkgDetail .iForm1").val("");
                            $( this ).dialog( "close" );
                        }
                    }
                });
				$("#tableExtPkgBenefit").jqGrid({
                    datatype: "local",
                    colModel:[					
                        {label:'Effective Date',name:'detEffDate',index:'detEffDate',width:100, hidden:true},
						{label:'Expiry Date',name:'detExpDate',index:'detExpDate',width:100, hidden:true},					
                        {label:'Description',name:'description',index:'description',width:300},
                        {label:'Remark',name:'remark',index:'remark',width:200}, 
						{label:'Frequency',name:'freqqty',index:'freqqty',width:90, hidden:true},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90, hidden:true},
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "200",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    onSelectRow : function(rowid, e){
                        var ret=$("#tableExtPkgBenefit").jqGrid('getRowData',rowid);
						$("#chgCodeBenefit").val(rowid);
						$("#pkgBenefitDescription").val(ret.description);
						$("#remarkBenefit").val(ret.remark);
						$("#maxqtyBenefit").val(ret.maxqty);					
                        return(true);            
                    }
                });	
				$("#dialogPkgBenefitList").dialog({//alert when mandatory item not enter dialogPkgBenefitForm
                    autoOpen: false,
                    width: 820,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
							$("#maxqtyBenefit").focus();
							$( this ).dialog( "close" );
                        },
                        Cancel: function() {
							$("#formPkgDetail .iForm1").val("");
                            $( this ).dialog( "close" );
                        }
                    }
                });
				function resetTablePackageDetail(pkg,effectdate){
					var trf = $("#tablePackageDetail tbody:first tr:first")[0];
					$("#tablePackageDetail tbody:first").empty().append(trf);
					$("#tablePackageDetail").jqGrid().setGridParam({url:'tableList/packageDetail.php?pkgcode='+pkg+'&effectdate='+effectdate,datatype:'xml'}).trigger("reloadGrid");
            	};
				function resetTablePackageBenefit(pkg){
					var trf = $("#tablePackageBenefit tbody:first tr:first")[0];
					$("#tablePackageBenefit tbody:first").empty().append(trf);
					$("#tablePackageBenefit").jqGrid().setGridParam({url:'tableList/packageBenefit.php?pkgcode='+pkg,datatype:'xml'}).trigger("reloadGrid");
            	};
				function resetTableExtPkgDetail(pkg){
					var trf = $("#tableExtPkgDetail tbody:first tr:first")[0];
					$("#tableExtPkgDetail tbody:first").empty().append(trf);
					$("#tableExtPkgDetail").jqGrid().setGridParam({url:'tableList/packageExtDetail.php?pkgcode='+pkg,datatype:'xml'}).trigger("reloadGrid");
            	};
				function resetTableExtPkgBenefit(pkg){
					var trf = $("#tableExtPkgBenefit tbody:first tr:first")[0];
					$("#tableExtPkgBenefit tbody:first").empty().append(trf);
					$("#tableExtPkgBenefit").jqGrid().setGridParam({url:'tableList/packageBenefit.php?pkgcode='+pkg,datatype:'xml'}).trigger("reloadGrid");
            	};
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
                    <div  id="packageButton" class="rfloat" style="display:none">
                        <i class="topbar-divider"></i>
                        <button id="but_list" class="button" title="Package Header"  disabled="true">
                            <i id="listIcon" class="iconButton"></i>
                            <p>Package</p>
                        </button>
                    </div>
                    <div id="mainButton" class="rfloat">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="placeholder" style="display: none;"><p id="pkgname"></p><span id="micon" class="maximize"></span></div>
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
                    <h2 id="content-main-heading" class="title1">Package Effective Date</h2>
                    <div class="rfloat specfloat">   
                        <i class="topbar-divider"></i>
                        <button id="but_add_effect" class="button" title="Add">
                            <i id="addIcon" class="iconButton"></i>
                            <p>Add</p>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="but_edit_effect" class="button" title="Edit" disabled="true">
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
                                <table id="tablePackageEffect"> </table> 
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
            <div style="clear: both; margin-bottom: 15px;">
                <div id="tabs" class="tabs" style="background: #ECECEC;">
                    <ul>
                        <li><a href="#tabs-1">Package Detail</a></li>
                        <li><a href="#tabs-2">Package Benefit</a></li>
                    </ul>
                    <div id="tabs-1" >
                        <div class="content-header-new">
                            <div class="header-inner-new">
                                <div class="rfloat specfloat">   
                                    <i class="topbar-divider"></i>
                                    <button id="but_add_detail" class="button" title="Add" disabled="true">
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
                        </div>
                    </div>
                    <div id="tabs-2">   
                        <div class="content-header-new">
                            <div class="header-inner-new">
                                <div class="rfloat specfloat">   
                                    <i class="topbar-divider"></i>
                                    <button id="but_add_benefit" class="button" title="Add">
                                        <i id="addIcon" class="iconButton"></i>
                                        <p>Add</p>
                                    </button>
                                    <i class="topbar-divider"></i>
                                    <button id="but_edit_benefit" class="button" title="Edit" disabled="true">
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
                                            <table id="tablePackageBenefit"> </table>    
                                            <div id="tablePagerPackageBenefit"></div>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>                            
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
                                    <input name="pkgDescription" class="iForm" type="text" id="pkgDescription" size="40" readonly />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="pkgTerm">Term(Years):</label></td>
                                <td><input type="text" class="iForm" name="pkgTerm" id="pkgTerm" /></td>
                            </tr>
                            <tr class="pkgHeadDate" style="display:none">
                                <td><label for="pkgHeadEffectDate">Effective Date:</label></td>
                                <td><input type="text" class="iForm" name="pkgHeadEffectDate" id="pkgHeadEffectDate" /></td>
                            </tr>
                            <tr class="pkgHeadDate" style="display:none">
                                <td><label for="pkgHeadPrice">Price:</label></td>
                                <td><input type="text" class="iForm" name="pkgHeadPrice" id="pkgHeadPrice" /></td>
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
        <div id="dialogEffectiveForm" title="Package Header">
            <div class="alongdiv">
                <div class="bodydiv">
                    <form id="formPkgEffective" method="post" action="">
                        <table>
                            <tr style="display:none">
                                <td >
                                    <label for="pkgCodeEffect">Package Code:</label>
                                </td>
                                <td >
                                    <input type="text" class="iForm" name="pkgCodeEffect" id="pkgCodeEffect" />
                                </td>
                            </tr>
                            <tr>
                                <td ><label for="pkgDescriptionEffect">Description:</label></td>
                                <td colspan="3">
                                    <input name="pkgDescriptionEffect" class="iForm" type="text" id="pkgDescriptionEffect" size="40" readonly/>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="pkgPrice">Price:</label></td>
                                <td><input type="text" class="iForm" name="pkgPrice" id="pkgPrice" /></td>
                            </tr>
                            <tr>
                                <td ><label for="pkgEffectDate">Effective Date:</label></td>
                                <td colspan="3">
                                    <input type="text" class="iForm" name="pkgEffectDate" id="pkgEffectDate" style="width: 82px;">
                                </td>
                            </tr>
                            <tr >
                                <td style="display:none">
                                	<input type="text" name="pkgTermEffect" id="pkgTermEffect">
                                    <input type="text" name="pkgEffectDateOld" id="pkgEffectDateOld">
                                    <input type="text" name="opStatusEffect" id="opStatusEffect">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="dialogPkgDetailForm" title="Package Detail">
            <form id="formPkgDetail" method="post" action="">
                <div class="alongdiv" id="radioPkgDetail">
                    <div class="bodydiv">
                        <input type="radio" name="detailType" value="old" checked>Use Existing Detail
                        <input type="radio" name="detailType" value="new">Create New Detail
                    </div>
                </div>
                <div id="detailProgramme" class="alongdiv">
                    <div class="bodydiv">                
                        <table>
                            <tr>
                                <td ><label for="pkgDetailDescription">Description:</label></td>
                                <td colspan="3">
                                    <input name="pkgDetailDescription" class="iForm1" type="text" id="pkgDetailDescription" size="30" readonly/>
                                    <input type="button" name="helpPkgDetail" id="helpPkgDetail" value="..." tabIndex="-1" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="freqqty">Frequency:</label></td>
                                <td><input type="text" class="iForm1" name="freqqty" id="freqqty" /></td>
                            </tr>
                            <tr>
                                <td><label for="intervl">Interval Each Test (Years):</label></td>
                                <td><input type="text" class="iForm1" name="intervl" id="intervl" /></td>
                            </tr>
                            <tr >
                                <td><label for="maxqty">Max Test Quantity:</label></td>
                                <td><input type="text" class="iForm1" name="maxqty" id="maxqty" /></td>
                            </tr>
                            <tr >
                                <td><label for="remarkDetail">Remarks:</label></td>
                                <td><textarea name="remarkDetail" id="remarkDetail" style="width:250px;height:70px" class="iForm1"></textarea></td>
                            </tr>
                            <tr >
                                <td style="display:none">
                                    <input type="text" name="pkgCodeDetail" id="pkgCodeDetail" value='lala'/>
                                    <input type="text" name="chgCodeDetail" id="chgCodeDetail" />
                                    <input type="text" name="pkgEffectDateDetail" id="pkgEffectDateDetail" />
                                    <input type="text" name="opStatusDetail" id="opStatusDetail">
                                </td>
                            </tr>
                        </table>                
                    </div>
                </div>
            </form>
        </div>
        <div id="dialogPkgBenefitForm" title="Package Benefit">
            <form id="formPkgBenefit" method="post" action="">
                <div class="alongdiv" id="radioPkgBenefit">
                    <div class="bodydiv">
                        <input type="radio" name="benefitType" value="old" checked>Use Existing Benefit
                        <input type="radio" name="benefitType" value="new">Create New Benefit
                    </div>
                </div>
                <div id="benefitProgramme" class="alongdiv">
                    <div class="bodydiv">                
                        <table>
                            <tr>
                                <td ><label for="pkgBenefitDescription">Description:</label></td>
                                <td colspan="3">
                                    <input name="pkgBenefitDescription" class="iForm2" type="text" id="pkgBenefitDescription" size="30" readonly/>
                                    <input type="button" name="helpPkgBenefit" id="helpPkgBenefit" value="..." tabIndex="-1">
                                </td>
                            </tr>
                            <tr >
                                <td><label for="maxqtyBenefit">Max Test Quantity:</label></td>
                                <td><input type="text" class="iForm2" name="maxqtyBenefit" id="maxqtyBenefit" /></td>
                            </tr>
                            <tr >
                                <td><label for="remarkBenefit">Remarks:</label></td>
                                <td><textarea name="remarkBenefit" id="remarkBenefit" style="width:250px;height:70px" class="iForm2"></textarea></td>
                            </tr>
                            <tr>
                                <td><label for="benefitEffectDate">Effective Date:</label></td>
                                <td><input type="text" class="iForm2" name="benefitEffectDate" id="benefitEffectDate" style="width: 82px;"></td>
                            </tr>
                            <tr>
                                <td><label for="benefitExpiredDate">Expired Date:</label></td>
                                <td><input type="text" class="iForm2" name="benefitExpiredDate" id="benefitExpiredDate" style="width: 82px;"></td>
                            </tr>
                            <tr >
                                <td style="display:none">
                                    <input type="text" name="pkgCodeBenefit" id="pkgCodeBenefit" />
                                    <input type="text" name="chgCodeBenefit" id="chgCodeBenefit" />
                                    <input type="text" name="opStatusBenefit" id="opStatusBenefit">
                                </td>
                            </tr>
                        </table>                
                    </div>
                </div>
            </form>
        </div>
        
        <div id="dialogPkgDetailList" title="List">
            <div >
                <table id="tableExtPkgDetail"> </table>    
            </div>    
        </div>
        <div id="dialogPkgBenefitList" title="List">
            <div >
                <table id="tableExtPkgBenefit"> </table>    
            </div>    
        </div>
        <div id="dialogAlert" title="Alert">
            <p id="dialogText"></p>
        </div>
    </body>
</html>