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
           $("#grid").jqGrid({
				url:'test1231.php',
				datatype: "xml",
				height: 250,
				width:400,
				colNames: ['Bed Number', 'Bed Type', 'Room', 'Ward', 'Room Status', 'MRN','Epis.No','Name'],
				colModel: [
					{name: 'Bed Number',index: 'Bed Number'},
					{name: 'Bed Type',index: 'Bed Type'},
					{name: 'Room',index: 'Room'},
					{name: 'Ward',index: 'Ward'},
					{name: 'Room Status',index: 'Room Status'},
					{name: 'MRN',index: 'MRN'},
					{name: 'Epis.No',index: 'Epis.No'},
					{name: 'Name',index: 'Name'},
					
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
<style>
#tblinfo{
	border-radius: 10px 10px 5px 5px;
	padding:1px;
	margin:1% auto;
	width:98%;
	border:thin solid #4D7094;
	color:#333333;
	
}
#tblinfo td{
	padding:2px;
	border:thin solid #4D7094;
	width: 40%;
	color:#000000;
	opacity:.6;
}
#tblinfo th{
	padding:2px;
	border:thin solid #4D7094;
	width:10%
}
#tblinfo #tdatas{
	border-radius: 10px 10px 0px 0px;
	padding:5px;
	font-size:large;
	text-align:center;
	border:thin solid #4D7094;
	background-color:#4D7094;
	color:#FFFFFF;
	opacity:1;
}
</style>
</head>
<body>
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Lodger Maintenance</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Cancel"  class="orgbut">
      <input type="button" value="Proceed" class="orgbut">    
    </div>
    <div class="bodydiv">
<table width="100%">
<tr>
    <td width="10%">MRN:</td>
    <td width="17%"><input type="text"></td>
    <td width="37%"><input type="text"></td>
    <td width="6%">Episode</td>
    <td width="30%"><input type="text"></td>
</tr>
<tr>
    <td width="10%">Ward:</td>
    <td width="17%"><input type="text"></td>
    <td><input type="text"></td>
    <td>Room</td>
    <td><input type="text"></td>
</tr>
<tr>
    <td width="10%">Type:</td>
    <td width="17%"><input type="text"></td>
    <td><input type="text"></td>
    <td>Bed No.</td>
    <td><input type="text"></td>
</tr>
</table>
   </div>
   <div class="alongdiv">
   <div class="bodydiv">
   <table>
      <tr>
       	<td>Ward:</td>
        <td><select id="searchField">
                 <option value="Mm"></option>                       
                 </select></td>
        <td>Bed No</td>
        <td><select id="searchField">
                 <option value="Mm"></option>                       
                 </select></td>
                    </tr>
                    </table>
                    <div class="alongdiv">  
               <table id="grid"></table>
              
     <div id="pager"></div>      
     </div>
</div>
</form>
</body>