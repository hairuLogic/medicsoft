<?php 
    include_once('../sschecker.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ordering</title> 
        <link rel="stylesheet" href="../css/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
			var mrn,episno,mrnOld,chgCode,chgDesc;
			$(function(){
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
                        {label:'debtorName',name:'debtorName',index:'debtorName',width:50,hidden:true},
						{label:'Newic',name:'Newic',index:'Newic',width:70,hidden:true},   
                        {label:'ageyy',name:'ageyy',index:'ageyy',width:50,hidden:true}  ,
                        {label:'Sex',name:'Sex',index:'Sex',width:50,hidden:true} ,
						{label:'caseDes',name:'caseDes',index:'caseDes',width:50,hidden:true} , 
						{label:'mrn',name:'mrn',index:'mrn',width:50,hidden:true} ,
						{label:'episno',name:'episno',index:'episno',width:50,hidden:true}      
                    ],
                    rowNum:50,
                    viewrecords: true,
                    height: "350",
                    caption: "Patients List",
                    beforeSelectRow : function(rowid, e){
                        var ret=$("#tablePt").jqGrid('getRowData',rowid);						
						mrn=ret.mrn;
						episno=ret.episno;
                        $("#debtor").val(ret.debtorName);
                        $("#case").val(ret.caseDes);
						$("#orderButton").prop("disabled",false);
						$("#tablePt").jqGrid().setGridParam({hidegrid: false});//display hide grid
                        return(true);            
                    },
					onHeaderClick:function(){
						$(".tableDetail").slideToggle( "fast" );
					}
                });
				
				$("#tableOrder").jqGrid({
                    url:'tableList/orderList.php?mrn='+mrn+'&episno='+episno,
                    datatype: "xml",
                    colModel:[
                        {label:'Date',name:'trxdate',index:'trxdate',width:126},
                        {label:'Code',name:'chgcode',index:'chgcode',width:174}, 					
                        {label:'description',name:'description',index:'description',width:370},
                        {label:'quantity',name:'quantity',index:'quantity',width:80}, 
                        {label:'amount',name:'amount',index:'amount',width:80},   
                        {label:'isudept',name:'isudept',index:'isudept',hidden:true},						
                        {label:'TT',name:'trxtype',index:'trxtype',width:40}   
                    ],
                    rowNum:50,
                    viewrecords: true,
                    height: "350",
					width:"950",
                    onSelectRow : function(rowid, e){
                        var ret=$("#tableOrder").jqGrid('getRowData',rowid);
                        return(true);            
                    }
                });
				
				$("#chgmastList").jqGrid({
                    datatype: "xml",
                    colModel:[
                        {label:'Code',name:'chgcode',index:'chgcode', width:100},
                        {label:'Description',name:'description',index:'description', width:270},
						{label:'Brandname',name:'brandname',index:'brandname', width:270}  						
                    ],
                    rowNum:50,
                    viewrecords: true,
                    height: "300",
                    caption: "Charge Master",
					altRows: true,
					rowNum:50,
					rowList:[50,100,150],
					pager: jQuery('#tablePagerChgmast'),
                    beforeSelectRow: function(rowid, e){      
                        var ret=$("#chgmastList").jqGrid('getRowData',rowid);   
                        chgCode=rowid;
						chgDesc=ret.description;
                        return(true); 
                    }
                });
				
				$( "#dialogList" ).dialog({
                    autoOpen: false,
                    width: 700,
					height: 500,
                    modal: true,
                    buttons: {
                        "Confirm":function(){
                            $("#chgCode").val(chgCode);							
							$("#chgDesc").val(chgDesc);
                            $( this ).dialog( "close" ); 
							
							$("#chgQuantity").focus();
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
				
				$( "#tabs" ).tabs({ heightStyle: "auto" });//set height for tab
				$("#tablePt > .ui-jqgrid-titlebar").hide();//hide tablePt title bar
				
				$("#orderButton").click(function(){
					if(mrn!=mrnOld){
						resetOrder();
					};
					//togle order
					$("#ptList").slideToggle( "fast" );
					$("#orderButton").prop("disabled",true);
					$("#listButton").prop("disabled",false);
					$("#ptOrder").slideToggle("fast");
					$(this).toggleClass("active");
					//set mrn selected
					mrnOld=mrn;		
					$("#chgCode").focus()							
				});
				
				$("#listButton").click(function(){
					$("#ptList").slideToggle( "fast" );
					$("#orderButton").prop("disabled",false);
					$("#listButton").prop("disabled",true);
					//togle order
					$("#ptOrder").slideToggle("fast");
					$(this).toggleClass("active");
					return false;
				});
				
				$("#help").click(function(){
					$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMast.php'}).trigger("reloadGrid");
					$("#dialogList").dialog( "open" )	
				});
			});	
			
			
			function resetOrder(){//run when user choose other patient
				$("#tableList").jqGrid().setGridParam({url : 'tableList/orderList.php?mrn='+mrn+'&episno='+episno}).trigger("reloadGrid");
			}
		</script>             
    </head>

    <body>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
            <div class="content-header">
                <div class="header-inner">
                    <h2 id="content-main-heading" class="title1">Patient Order</h2>
                    <div class="rfloat specfloat">   
                        <i class="topbar-divider"></i>
                        <button id="listButton" class="button" title="Patient List" disabled>
                        	<i id="listIcon" class="iconButton"></i>
                        </button>                   
                        <i class="topbar-divider"></i>
                        <button id="orderButton" class="button" title="Order" disabled>
                        	<i id="orderIcon" class="iconButton"></i>
                        </button>                        
                        <i class="topbar-divider"></i>
                        <button id="but_refresh" class="button" title="Refresh Data" >
                            <i id="refreshIcon" class="iconButton"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="content-body" id="ptList">
            <div class="body-inner">
                <div id="tdTree" >
                    <table id="tablePt"> </table>    
                    <div id="tablePagerPt"></div>
                    <div class="tableDetail">
                    	<div style="width: 40%;margin: 0 auto;">
                            <table>
                                <tr>
                                    <td >
                                        <label for="debtor">Debtor</label>
                                    </td>
                                    <td >
                                        <input type="text"  name="debtor" id="debtor" size="40" disabled/>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td ><label for="case">Case</label></td>
                                    <td colspan="3">
                                        <input name="case" type="text" id="case" size="40" disabled/>
                                    </td>
                                </tr>
                             </table>
                         </div>
                    </div>
                     
                </div>
            </div>
        </div>
        <span class="divider" ></span>
        <div id="ptOrder" style="display: none;"> 
            <div class="content-header" >
                <div class="header-inner">
                    <h2 id="content-main-heading" class="title2">Order item for </h2>                   
                </div>
            </div>
            <div class="content-body" >
                <div class="body-inner">
                    <div id="tdTree" >
                    	<div class="tableDetail">
                    		<div class="tableDetail-inner">
                                <div class="content-header-info" >
                                    <div class="header-inner-info">
                                        <h2 id="content-main-heading-info" class="title2">Order item for </h2>                   
                                    </div>
                                </div>
                                <div class="content-body-info" >
                                    <div class="body-inner-info">
                                        lasdfmksdmcks
                                    </div>
                                </div>
                            </div>
                            <div class="tableDetail-inner">
                                <div class="content-header-info" >
                                    <div class="header-inner-info">
                                        <h2 id="content-main-heading-info" class="title2">Order item for </h2>                   
                                    </div>
                                </div>
                                <div class="content-body-info" >
                                    <div class="body-inner-info">
                                        lasdfmksdmcks
                                    </div>
                                </div>
                            </div>
                         </div>
                         <div style="clear: both; margin-bottom: 15px;">
                         	 <div id="tabs" class="tabs">
                                <ul>
                                    <li><a href="#tabs-1">Charge Item</a></li>
                                    <li><a href="#tabs-2">Return Item</a></li>
                                </ul>
                                <div id="tabs-1">     
                                	<table border="0" cellspacing="0" cellpadding="0" style="padding-left: 12px;">
                                        <form name="form1" method="post" action="">
                                            <tr>
                                                <td style="padding-left: 5px;"><label for="chgDate">Date</label></td>
                                                <td style="padding-left: 5px;"><label for="chgCode">Code</label></td>
                                                <td style="padding-left: 5px;"><label for="chgDesc">Description</label></td>
                                                <td style="padding-left: 5px;"><label for="chgQuantity">Quantity</label></td>
                                                <td style="padding-left: 5px;"><label for="chgAmount">Amount</label></td>
                                            </tr>
                                            <tr>
                                                <td width="82"><input type="date" name="chgDate" id="chgDate" style="width: 130px;"></td>
                                                <td width="188"><input type="text" name="chgCode" id="chgCode" size="22">
                                                <input name="help" type="button" id="help" value="..."></td>
                                                <td width="343"><input type="text" name="chgDesc" id="chgDesc" size="53" disabled></td>
                                                <td width="82"><input type="text" name="chgQuantity" id="chgQuantity" size="9"></td>
                                                <td width="82"><input type="text" name="chgAmount" id="chgAmount" size="9" disabled></td>
                                            </tr>
                                        </form>
                                    </table>
                                    <div style="clear: both;">
                                        <table id="tableOrder"> </table>    
                                        <div id="tablePagerOrder"></div>
                                    </div>
                                </div>
                                <div id="tabs-2">                               
                                </div>                          
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
        </div>
		<?php include("../include/end.php")?>
    </body>
</html>