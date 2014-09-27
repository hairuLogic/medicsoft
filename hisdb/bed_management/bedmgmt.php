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
				width:500,
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
				caption: "Patient List",
			});
});

function openlodger(){
	
var uri = "lodger.php";
document.forms[0].action = uri;
document.forms[0].method = "post";
document.forms[0].submit();
}
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
<span id="pagetitle">Bed Management</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Lodger" onclick="openlodger()" class="orgbut">
      <input type="button" value="Refresh" class="orgbut">
      <input type="button" value="Update" class="orgbut">
      <input type="button" value="Save" class="orgbut">
      <input type="button" value="Cancel" class="orgbut">
      <input type="button" value="Search" class="orgbut">
      <input type="button" value="Exit" class="orgbut">
    </div>
    <div id="searchdiv">
        <div class="alongdiv">
        	<div class="smalltitle"><p>Search Bed Management</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td>Search By:<select id="searchField">
                        <option value="Mm">Bed No</option>                       
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
     <div class="bodydiv">
     <table id="tblinfo" width="100%">
     <tr>
         <td colspan="4" id="tdatas">Bed Information</td>
     </tr>
     <tr >
         <td rowspan="6" valign="bottom"><img src="../../img/bed.jpg" width="200" height="150" style="vertical-align:middle"></td>
         <td>Bed Number</td>
         <td>Tel Ext</td>
         <td>Room</td>         
     </tr>
     <tr>
         <td><input type="text"></td>
         <td><input type="text"></td>
         <td><input type="text"></td>
         
     </tr><tr>
         <td>Ward</td>
         <td>Static</td>
         <td>Status</td>
         
     </tr>
     <tr>
         <td><input type="text"></td>
         <td><input type="text"></td>
         <td><input type="text"></td>
         
     </tr>
     <tr>
         <td>Bed Type</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
        
     </tr>
     <tr>
         <td><input type="text"></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
        
     </tr>
     </table>
     </div>
</div>
</form>
</body>

