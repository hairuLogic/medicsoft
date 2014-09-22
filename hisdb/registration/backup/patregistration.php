<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Demographic</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script>
	$(function(){
		var updmrn;
		$('#pageinfoin').hide();
		$('#pageinfotog').click(function(){
			$('#pageinfoin').slideToggle('fast');
		});
		$('#refbut').click(function(){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			$('#grid').trigger("reloadGrid");
		});
		$('#viewbut').click(function(){
			window.open('registerpat.php?det=upd&mrn='+updmrn);
		});
		$('#addbut').click(function(){
			window.open('registerpat.php?det=rgd&mrn=');
		});
		$("#grid").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'Name', 'Newic', 'Oldic', 'Birth Date', 'Sex', 'Card ID','add1','add2','add3','off1','off2','off3'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'Oldic',index: 'Oldic'},
				{name: 'Birth Date',index: 'Birth Date'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Card ID'},
				{name: 'add1',index: 'add1',hidden:true},{name: 'add2',index: 'add1',hidden:true},{name: 'add3',index: 'add1',hidden:true},
				{name: 'offadd1',index: 'offadd1',hidden:true},{name: 'offadd2',index: 'offadd1',hidden:true},{name: 'offadd3',index: 'offadd1',hidden:true},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager1'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid").jqGrid('resetSelection');
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				$('#curaddr1').val(ret.add1);$('#curaddr2').val(ret.add2);$('#curaddr3').val(ret.add3);
				$('#offaddr1').val(ret.offadd1);$('#offaddr2').val(ret.offadd2);$('#offaddr3').val(ret.offadd3);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "Patient List",
		});
		function gosearch(opr){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			var searchField=$('#searchField').val();
			var searchString=$('#searchString').val();
			var searchOper=opr;
			$("#grid").jqGrid('setGridParam',{url:"test1231.php?searchField="+searchField+"&searchString="+searchString+"&searchOper="+searchOper}).trigger("reloadGrid");
		}
		$('#search').click(function(){
			gosearch('eq');
		});
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		$('#searchString').keyup(function (e){
			if (e.keyCode == 13) {
				gosearch('eq');
			}else{
				delay(function(){
					boldthesearch=true;
      				gosearch('lk');
    			}, 500 );
			}
		});
	});
</script>
<style>
.sideleft{
	width:32.3333%;
	padding-bottom:2%;
}
.sideleft .bodydiv{
	padding:2%;
	width:96%;
}
.sideleft .bodydiv input{
	width:98%;
}
</style>
</head>

<body>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> | Company: <?php echo $_SESSION['companyName'];?><a href="logout.php"> | Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button" id="epibut"></button>
            <button type="submit" disabled='true' id="delbut" form='del'></button>
            <button type="button" id="apptbut"></button>
            <button type="button" disabled='true' id="viewbut"></button>
            <button type="button" id="addbut"></button>
            <button type="button" id="refbut"></button>
        </div>
        
        <div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
        <div class="alongdiv">
        	<div class="smalltitle"><p>Search Patient</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option value="MRN">MRN</option>
                        <option selected value="Name">Name</option>
                        <option value="Newic">New IC</option>
                        <option value="Oldic">Old IC</option>
                        <option value="DOB">Birth Date</option>
                        <option value="Sex">Sex</option>
                        <option value="Idnumber">Card ID</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="search" class="orgbut"/></td>
                    </tr>
                    </table>
          	</div>
         </div>
         <div class="sideleft">
         	<div class="smalltitle"><p>Home</p></div>
            <div class="bodydiv">
                	<input type="text" id="curaddr1"/>
                    <input type="text" id="curaddr2"/>
                    <input type="text" id="curaddr3"/>
            </div>
         </div>
         <div class="sideleft">
         	<div class="smalltitle"><p>Office</p></div>
            <div class="bodydiv">
                	<input type="text" id="offaddr1"/>
                    <input type="text" id="offaddr2"/>
                    <input type="text" id="offaddr3"/>
            </div>
         </div>
         <div class="sideleft" style="margin-right:0%;width:33.333%">
         	<div class="smalltitle"><p>Payer Information</p></div>
            <div class="bodydiv">
                	<input type="text" id="peraddr1"/>
                    <input type="text" id="peraddr2"/>
                    <input type="text" id="peraddr3"/>
            </div>
         </div>
	</div>
</body>
</html>

