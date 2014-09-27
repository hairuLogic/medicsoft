 <?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient List</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/jquery.mb.browser.min.js"></script>
<script src="../../script/date_time.js"></script>
<script>
$(function(){
	$("#grid2").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Description', 'Amount', 'MMA Code', 'MMA Description'],
			colModel: [
				{name: 'Description',index: 'Description', width: 30},
				{name: 'Amount',index: 'Amount'},
				{name: 'MMA Code',index: 'MMA Code'},
				{name: 'MMA Description',index: 'MMA Description'},						
				
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager2'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid2").jqGrid('resetSelection');
				var ret=$("#grid2").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			//caption: "Patient List",
		});
	
	$("#grid1").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Bill Date', 'Bill No', 'Payer', 'Doctor Charges', 'Total Amount'],
			colModel: [
				{name: 'Bill Date',index: 'Bill Date', width: 30},
				{name: 'Bill No',index: 'Bill No'},
				{name: 'Payer',index: 'Payer'},
				{name: 'Doctor Charges',index: 'Doctor Charges'},
				{name: 'Total Amount',index: 'Total Amount'},				
				
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
				jQuery("#grid1").jqGrid('resetSelection');
				var ret=$("#grid1").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			//caption: "Patient List",
		});
	
	$("#grid").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'Name', 'New ic', 'Old ic', 'Birth Date', 'Age(Yrs)'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'Old ic',index: 'oldic'},
				{name: 'DOB',index: 'DOB'},
				{name: 'AGE',index: 'AGE'},
				
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid").jqGrid('resetSelection');
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			//caption: "Patient List",
		});
});
</script>
</head>
<body>
<?php include("../../include/header.php")?><span id="pagetitle">MMA Entry</span>
<div id="formmenu">
        <div id="menu" >
        <input type="button" value="MMA" class="orgbut">
        <input type="button" value="Save" class="orgbut">
        <input type="button" value="Cancel" class="orgbut">
        <input type="button" value="Print" class="orgbut">
        </div>
        <div id="searchdiv">
        <div class="alongdiv">
        	<div class="smalltitle"><p>Search MMA</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option value="Mm">Mm</option>                       
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    </table>
          	 </div>
             </div>
        </div>
   <div class="alongdiv">
   <table id="grid"></table>
   <div id="pager"></div>
   <div class="alongdiv">
   <table id="grid1"></table>
   <div id="pager1"></div>
     <div class="alongdiv">
    <table id="grid2"></table>
   <div id="pager2"></div>
   </div>
   </div>
</div>
</body>