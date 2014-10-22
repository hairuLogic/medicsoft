<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
	$id = $_GET[id];
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

function Link(id) {

    var row = id.split("=");
    var row_ID = row[1];
	var queueid= $("#grid").getCell(row_ID, 'Seq_No');
	var uri = "patientdetails.php?id=" + queueid;
    document.forms[0].action = uri;
    document.forms[0].method = "post";
    document.forms[0].submit();
}
 
$(function(){
           $("#grid").jqGrid({
				url:'data/queuelist.php?id=<?php echo $id ?>',
				datatype: "xml",
				height: 250,
				width:400,
				colNames: ['Seq No', 'Time','Name','MRN','Doctor','Status'],
				colModel: [
					{name: 'Seq_No',index: 'Seq_No',
					 width: 50,
					 editable: false,
					 sortable: false,
					 formatter: 'showlink',
					 formatoptions: { baseLinkUrl: 'javascript:', showAction: "Link('", addParam: "');"} 
					},					
					{name: 'Time',index: 'Time'},	
					{name: 'Name',index: 'Name'},
					{name: 'MRN',index: 'MRN'},
					{name: 'Doctor',index: 'Doctor'},
					{name: 'Status',index: 'Status'},							
					
				],
				altRows: true,
				altclass: 'zebrabiru',
				multiselect: false,
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
			
			$("#grid1").jqGrid({
				url:'test1231.php',
				datatype: "xml",
				height: 250,
				width:400,
				colNames: ['Medical', 'Antinatal'],
				colModel: [
					{name: 'Medical',index: 'Medical'},
					{name: 'Antinatal',index: 'Antinatal'},	
										
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
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Notes</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Complaint" class="orgbut" >
      <input type="button" value="ICD-10" class="orgbut">    
    </div>
<div class="alongdiv"></div> 
<div class="bodydiv">
<table width="100%">
<tr>
    <td width="100%">
    <table id="grid"></table>
      <div id="pager"></div>  
    <td>
</tr>
</table>    
</div>

</form>
</body>