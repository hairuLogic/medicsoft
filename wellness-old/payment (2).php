<?php
    include_once('../sschecker.php');

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Payment</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
        <style>
		td{
			padding:2px;
		}
		</style>
        <script>
		var amtout; 
		$(function(){
			var agent,memberno,lastsel;
			var mydata = [];
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = (day)+"/"+(month)+"/"+now.getFullYear() ;
				
			$("#payemenDiv *").prop("disabled", true);//disable all child
			
			$("#but_add").click(function(){
				$("#payemenDiv *").prop("disabled", false);
				/*$("#agent").prop("disabled", false);
				$("#agentName").prop("disabled", false);
				$("#helpAgent").prop("disabled", false);
				$("#member").prop("disabled", false);
				$("#memberName").prop("disabled", false);
				$("#helpMember").prop("disabled", false);*/
				$("#but_cancel").prop("disabled", false);
				$("#but_add").prop("disabled", true);
				$("#agent").focus();
				$("#but_save").prop("disabled", false);	
			});
			$("#but_cancel").click(function(){
				$("#payemenDiv *").prop("disabled", true);
				$("#but_cancel").prop("disabled", true);
				$("#but_save").prop("disabled", true);
				$("#but_add").prop("disabled", false);
				$('#date').val(today);
				$('.iForm').val('');
			});
			
			$( "#dateHIS" ).datepicker({
				  changeMonth: true,
				  changeYear: true,
				  dateFormat:"dd/mm/yy"
			});
			$( "#dateManual" ).datepicker({
				  changeMonth: true,
				  changeYear: true,
				  dateFormat:"dd/mm/yy"
			});
			$('#dateHIS').val(today);
			$('#dateManual').val(today);
			
			$("#tableActivity").jqGrid({				
				datatype: "local",
				colModel:[
					{label:'Date',name:'date',index:'date',width:80},
					{label:'Bil no',name:'bilno',index:'bilno',width:80},
					{label:'Remaks',name:'remarks',index:'remarks',width:250},  
					{label:'Amt Outstanding',name:'amtout',index:'amtout',width:90},   
					{label:'Amount Pay',name:'amtpay',index:'amtpay',width:90, formatter:test}  ,
					{label:'Balance',name:'balance',index:'balance',width:90}						 
				],
				viewrecords: true,
				height: "250",
				autowidth: true,
				hidegrid: false,
				rowNum:10,
				rowList:[10,20,30],
				pager: jQuery('#tablePagerActivity'),	
             });
			function test(cellvalue, options, rowObject){
				return '<input type="text" name="target'+options.rowId+'" id="target'+options.rowId+'" onkeyup="myFunction('+options.rowId+')" style=" width: 97%; ">';
			}
			$("#tableActivity").jqGrid('navGrid',"#prowed1",{edit:false,add:false,del:false});
			
			$("#but_save").click(function(){	
				var rowAmtpay=new Array(); 
				var idAmtpay=new Array();
				var outAmt=new Array();
				if($("#agent").val()!="" && $("#member").val()!="" && $("#payMode").val()!="" && $("#receiptno").val()!=""){
					rows=$("#tableActivity").getGridParam("records");
					var totalamt=0;
					for (var i=1;i<=rows;i++)
					{ 					
						var ret=$("#tableActivity").jqGrid('getRowData',i); 
						
						rowAmtpay[i]=$("#target"+i).val();
						idAmtpay[i]=ret.bilno;
						outAmt[i]=ret.amtout;
					}
					$.post('process/edit_dbacthdr2.php', {'rowAmtpay[]':rowAmtpay,'idAmtpay[]':idAmtpay,'outAmt[]':outAmt},function(data){
						$msg=$(data).find('msg').text();
						if($msg=="success"){
							$("#but_cancel").click();
							resetTableActivity();
						}
					});
				}
				else{
					$('#dialogText').text("Please insert all the required data");
					$( "#dialogAlert" ).dialog( "open" );	
				}
			});
////////////////////+++++++++++Help Function+++++++++++++////////////////////////////////////
			$("#agentList").jqGrid({
				datatype: "local",//datatype: "xml",
				colModel:[
					{label:'Code',name:'chgcode',index:'chgcode', width:100},
					{label:'Name',name:'name',index:'name', width:270}
				],
				rowNum:10,
				viewrecords: true,
				height: "200",
				caption: "Agent List",
				altRows: true,
				rowList:[10,20,30],
				pager: jQuery('#tablePagerAgent'),
				onSelectRow : function(rowid, e){
					var ret=$("#agentList").jqGrid('getRowData',rowid);
					agent=rowid;
					return(true);             
				}					
			});			
			$( "#helpAgentPop" ).dialog({
				autoOpen: false,
				width: 600,
				height: 500,
				modal: true,
				buttons: {
					"Confirm":function(){
						$("#agent").val(agent);
						$( this ).dialog( "close" );
						$("#agent").focus();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						$("#agent").focus();
					}
				}
			});
			$("#agent").focusout(function(e) { 
				if($.trim($("#agent").val()).length>0){
					$.post('process/checkAgent.php',{agent:$("#agent").val()},function(data){
						$msg=$(data).find('msg').text();
						if($msg=='empty'){
							$("#agent").focus();
							$('#dialogText').text("Agent not in database");
							$( "#dialogAlert" ).dialog( "open" );	
						}
						else if($msg=='pop'){
							if ($("#agent").val()=="") return 0;
							$("#helpAgentPop").dialog( "open" );
							$("#agentList").jqGrid().setGridParam({url : 'tableList/agent.php?agent='+$("#agent").val(),datatype:'xml'}).trigger("reloadGrid");	
						}
						else{
							//$("#chgQuantity").focus();	
							$("#agent").val($(data).find('agentcode').text()); 	
							$("#agentName").val($(data).find('name').text());
							$("#member").prop("disabled", false);
							$("#memberName").prop("disabled", false);
							$("#helpMember").prop("disabled", false);
							$("#member").focus();	
						}
					});
				}
			});
			$("#agent").on('keydown',  function(e) { 
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if ( keyCode == 13) { 
					e.preventDefault(); 
				} 
			});
			$("#helpAgent").click(function(){
				$("#agentList").jqGrid().setGridParam({url : 'tableList/agent.php',datatype:'xml'}).trigger("reloadGrid");	
				$("#helpAgentPop").dialog( "open" );				
			});
			$("#searchString1").on('keydown',  function(e) { //search pt
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if (keyCode == 9 || keyCode == 13) { 
					e.preventDefault(); 
					//check length of character
					searchAgent();
				} 
			});
			$("#but_search1").click(function(){//search pt
				searchAgent();	
			});
			
			$("#memberList").jqGrid({
				datatype: "local",//datatype: "xml",
				colModel:[
					{label:'Member No',name:'memberno',index:'memberno', width:100},
					{label:'Mrn',name:'mrn',index:'mrn', width:100},
					{label:'Name',name:'name',index:'name', width:270}
				],
				rowNum:10,
				viewrecords: true,
				height: "200",
				caption: "Subscriber List",
				altRows: true,
				rowList:[10,20,30],
				pager: jQuery('#tablePagerMember'),
				onSelectRow : function(rowid, e){
					var ret=$("#memberList").jqGrid('getRowData',rowid);
					memberno=rowid;
					return(true);             
				}					
			});			
			$( "#helpMemberPop" ).dialog({
				autoOpen: false,
				width: 600,
				height: 500,
				modal: true,
				buttons: {
					"Confirm":function(){
						$("#member").val(memberno);
						$( this ).dialog( "close" );
						$("#member").focus();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						$("#member").focus();
					}
				}
			});
			$("#member").focusout(function(e) { 
				if($.trim($("#member").val()).length>0){
					$.post('process/checkMember.php',{member:$("#member").val(),agent:$("#agent").val()},function(data){
						$msg=$(data).find('msg').text();
						if($msg=='empty'){							
							$('#dialogText').text("Subscriber with word "+$("#member").val()+" not in database");
							$( "#dialogAlert" ).dialog( "open" );
							$("#member").val("");
							$("#member").focus();	
						}
						else if($msg=='pop'){
							if ($("#member").val()=="") return 0;
							$("#helpMemberPop").dialog( "open" );
							$("#memberList").jqGrid().setGridParam({url : 'tableList/member_payment.php?agent='+$("#agent").val()+"&member="+$("#member").val(),datatype:'xml'}).trigger("reloadGrid");	
						}
						else{
							//$("#chgQuantity").focus();
							$("#agent").val($(data).find('agent').text()); 	
							$("#agentName").val($(data).find('agentname').text());	
							$("#member").val($(data).find('memberno').text()); 	
							$("#memberName").val($(data).find('name').text());
							$("#payemenDiv *").prop("disabled", false);
							$("#date").focus();
							$("#tableActivity").jqGrid().setGridParam({url :"tableList/dbacthdr2.php?memberno="+$("#member").val(),datatype:'xml'}).trigger("reloadGrid");
						}
					});
				}
			});
			$("#member").on('keydown',  function(e) { 
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if ( keyCode == 13) { 
					e.preventDefault(); 
				} 
			});
			$("#helpMember").click(function(){
				$("#memberList").jqGrid().setGridParam({url : 'tableList/member_payment.php?agent='+$("#agent").val(),datatype:'xml'}).trigger("reloadGrid");	
				$("#helpMemberPop").dialog( "open" );				
			});
			$("#searchString2").on('keydown',  function(e) { //search pt
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if (keyCode == 9 || keyCode == 13) { 
					e.preventDefault(); 
					//check length of character
					searchMember();
				} 
			});
			$("#but_search2").click(function(){//search pt
				searchMember();	
			});
			
			$("#paymodeList").jqGrid({
				datatype: "local",//datatype: "xml",
				colModel:[
					{label:'Code',name:'chgcode',index:'chgcode', width:100},
					{label:'Name',name:'name',index:'name', width:270}
				],
				rowNum:10,
				viewrecords: true,
				height: "200",
				caption: "Paymode List",
				altRows: true,
				rowList:[10,20,30],
				pager: jQuery('#tablePagerPaymode'),
				onSelectRow : function(rowid, e){
					var ret=$("#paymodeList").jqGrid('getRowData',rowid);
					payMode=rowid;
					return(true);             
				}					
			});			
			$( "#helpPaymodePop" ).dialog({
				autoOpen: false,
				width: 600,
				height: 500,
				modal: true,
				buttons: {
					"Confirm":function(){
						$("#payMode").val(payMode);
						$( this ).dialog( "close" );
						$("#payMode").focus();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						$("#payMode").focus();
					}
				}
			});
			$("#payMode").focusout(function(e) { 
				if($.trim($("#payMode").val()).length>0){
					$.post('process/checkPaymode.php',{paymode:$("#payMode").val()},function(data){
						$msg=$(data).find('msg').text();
						if($msg=='empty'){
							$("#payMode").focus();
							$('#dialogText').text("Paymode not in database");
							$( "#dialogAlert" ).dialog( "open" );	
						}
						else if($msg=='pop'){
							if ($("#payMode").val()=="") return 0;
							$("#helpPaymodePop").dialog( "open" );
							$("#paymodeList").jqGrid().setGridParam({url : 'tableList/paymode.php?paymode='+$("#payMode").val(),datatype:'xml'}).trigger("reloadGrid");	
						}
						else{
							//$("#chgQuantity").focus();	
							$("#payMode").val($(data).find('paymode').text()); 
						}
					});
				}
			});
			$("#payMode").on('keydown',  function(e) { 
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if (keyCode == 13) { 
					e.preventDefault(); 					
				} 
			});
			$("#helpPayMode").click(function(){
				$("#paymodeList").jqGrid().setGridParam({url : 'tableList/paymode.php',datatype:'xml'}).trigger("reloadGrid");	
				$("#helpPaymodePop").dialog( "open" );				
			});
			$("#searchString3").on('keydown',  function(e) { //search pt
				var keyCode = e.keyCode || e.which; 
				//check for tab n enter key 
				if (keyCode == 9 || keyCode == 13) { 
					e.preventDefault(); 
					//check length of character
					searchPaymode();
				} 
			});
			$("#but_search3").click(function(){//search pt
				searchPaymode();	
			});
///////////+++++++++++++++++ALERT++++++++++////////////////////////
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
		});
		
		function myFunction(id){
			var ret=$("#tableActivity").jqGrid('getRowData',id); 
			$("#tableActivity").setRowData(id, {balance: ret.amtout-$("#target"+id).val()});
			rows=$("#tableActivity").getGridParam("records");
			var totalamt=0;
			for (var i=1;i<=rows;i++)
			{ 
				if($("#target"+i).val()!==""){
					totalamt=totalamt+parseInt($("#target"+i).val());
				}
			}
			$("#totalamt").val(totalamt);
		};
		function searchAgent(){
			var trf = $("#agentList tbody:first tr:first")[0];
			$("#agentList tbody:first").empty().append(trf);
			$("#agentList").jqGrid().setGridParam({url : 'tableList/agent.php?searchString='+$("#searchString1").val()+"&searchField="+$("#searchField1").val()}).trigger("reloadGrid");
		};
		function searchMember(){
			var trf = $("#memberList tbody:first tr:first")[0];
			$("#memberList tbody:first").empty().append(trf);
			$("#memberList").jqGrid().setGridParam({url : 'tableList/member_payment.php?searchString='+$("#searchString2").val()+"&searchField="+$("#searchField2").val()+'&agent='+$("#agent").val()}).trigger("reloadGrid");
		};
		function searchPaymode(){
			var trf = $("#paymodeList tbody:first tr:first")[0];
			$("#paymodeList tbody:first").empty().append(trf);
			$("#paymodeList").jqGrid().setGridParam({url : 'tableList/member_payment.php?searchString='+$("#searchString3").val()+"&searchField="+$("#searchField3").val()+'&agent='+$("#agent").val()}).trigger("reloadGrid");
		};
		function resetTableActivity(){
			var trf = $("#tableActivity tbody:first tr:first")[0];
			$("#tableActivity tbody:first").empty().append(trf);
		};
		</script>
</head>

<body>
	<span id="pagetitle">Payment</span>
	<?php include("../include/headerf.php")?>
    <?php include("../include/start.php")?>
    <div class="content-header-new">
        <div class="header-inner-new">
            <h2 id="content-main-heading" class="title1"></h2>
            <div class="rfloat specfloat">  
                <i class="topbar-divider"></i>
                <button id="but_add" class="button" title="New" >
                    <i id="addIcon" class="iconButton"></i>
                    <p>New</p>
                </button>     
                <i class="topbar-divider"></i>
                <button id="but_save" class="button" title="Save" form="formdata" disabled>
                    <i id="saveIcon" class="iconButton"></i>
                    <p>Save</p>
                </button>
                <i class="topbar-divider"></i>
                <button id="but_cancel" class="button" title="Cancel" disabled>
                    <i id="cancelIcon" class="iconButton"></i>
                    <p>Cancel</p>
                </button>    
            </div>
        </div>
    </div>
    <div class="maindiv">
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative">
                <p ></p>
                <span id="micon" class="minimize" style="display:none"></span>
            </div>
            <div class="bodydiv" >
            <div id="payemenDiv" style="margin:0 auto;width:55%">
            <form id="formdata" action="">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>Agent:</td>
                  <td><input type="text" name="agent" id="agent" class="iForm"><input name="helpAgent" type="button" id="helpAgent" value="..." tabIndex="-1" required></td>
                  <td>Subscriber:</td>
                  <td><input type="text" name="member" id="member" class="iForm"><input name="helpMember" type="button" id="helpMember" value="..." tabIndex="-1"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="text" name="agentName" id="agentName"  tabIndex="-1" class="iForm" readonly></td>
                  <td>&nbsp;</td>
                  <td><input type="text" name="memberName" id="memberName" tabIndex="-1" class="iForm"  readonly></td>
                </tr>
                <tr>
                  <td>Payment Mode:</td>
                  <td><input type="text" name="payMode" id="payMode" class="iForm">
                  <input name="helpPayMode" type="button" id="helpPayMode" value="..." tabIndex="-1"></td>
                  <td>Amount</td>
                  <td><input type="text" name="totalamt" id="totalamt" class="iForm"></td>
                </tr>
                <tr>
                  <td>HIS Date:</td>
                  <td><input type="text" name="dateHIS" id="dateHIS"></td>
                  <td>HIS Receipt No:</td>
                  <td><input type="text" name="receiptno" id="receiptno" class="iForm"></td>
                </tr>
                <tr>
                  <td>Manual Date:</td>
                  <td><input type="text" name="dateManual" id="dateManual"></td>
                  <td>Manual Receipt No:</td>
                  <td><input type="text" name="receiptno" id="receiptno" class="iForm"></td>
                </tr>
                <tr>
                  <td>Remark:</td>
                  <td colspan="3"><textarea name="textarea" id="textarea" style="width:100%;height:40px" class="iForm" required></textarea></td>
                </tr>
              </table>
              </form>
            	</div>
            </div>
        </div>
        
        <div id="tableDiv" class="alongdiv">
            <table id="tableActivity"> </table>    
            <div id="tablePagerActivity"></div>
        </div> 
    </div>
    <div id="helpAgentPop" title="List">
        <div >
            <table id="agentList"> </table>    
            <div id="tablePagerAgent"></div>
        </div>      
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative"><p>Agent Search</p><span id="micon" class="minimize"></span></div>
            <div class="bodydiv">
                <table>
                    <tr>
                        <td><label>Search by: </label><select id="searchField1">
                                <option selected value="word">Name</option>
                                <option  value="chgcode">Code</option>
                            </select></td>
                        <td>
                            <input type="text" id="searchString1" size="35"/>
                        </td>
                        <td>
                            <button id="but_search1" class="button" title="Search" >
                                <i id="searchIcon" class="iconButton"></i>Search
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>   
    </div>
    <div id="helpMemberPop" title="List">
        <div >
            <table id="memberList"> </table>    
            <div id="tablePagerMember"></div>
        </div>      
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative"><p>Subscriber Search</p><span id="micon" class="minimize"></span></div>
            <div class="bodydiv">
                <table>
                    <tr>
                        <td><label>Search by: </label><select id="searchField2">
                                <option selected value="word">Name</option>
                                <option  value="chgcode">MRN</option>
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
    <div id="helpPaymodePop" title="List">
        <div >
            <table id="paymodeList"> </table>    
            <div id="tablePagerPaymode"></div>
        </div>      
        <div class="alongdiv">
            <div class="smalltitle" style="position:relative"><p>Paymode Search</p><span id="micon" class="minimize"></span></div>
            <div class="bodydiv">
                <table>
                    <tr>
                        <td><label>Search by: </label><select id="searchField3">
                                <option selected value="word">Name</option>
                                <option  value="chgcode">Code</option>
                            </select></td>
                        <td>
                            <input type="text" id="searchString3" size="35"/>
                        </td>
                        <td>
                            <button id="but_search3" class="button" title="Search" >
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
</body>
</html>