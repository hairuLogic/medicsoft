<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
<link href="../css/reset.css" rel="stylesheet" media="screen" type="text/css"  />
<link href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" rel="stylesheet" type="text/css" media="screen" />
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link href="../js/jquery.timeentry.package-1.5.2/jquery.timeentry.css" rel="stylesheet" type="text/css"/>
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/jquery.inputmask.js"></script>
<script src="../js/jquery.mb.browser.min.js"></script>
<script src="../js/jquery.easytabs.min.js"></script>
<script src="../js/jquery.formatCurrency-1.4.0.min.js"></script>
<script src="../js/jquery.timeentry.package-1.5.2/jquery.timeentry.min.js"></script>
<script>
$(function(){
	var rowidarray=new Array();var todel;
	function del(e,i,a){
		if(e==todel){
			rowidarray.splice(i, 1);
		}
	}
	function sel(e,i,a){
		$("#grid").jqGrid('setSelection',e,false);
	}
	$("#grid").jqGrid({
		url:'jgn tukar/test1231.php?first=1',
		datatype: "xml",
		height: 250,
		width:500,
		colNames: ['Member No.', 'MRN','Agreement No.','Name', 'Newic', 'Handphone', 'Birth Date', 'Sex', 'Categorybtl','Category','add1','add2','add3','off1','off2','off3','telhp','telo','E-mail','subsyno','agent'],
		colModel: [
			{name: 'MemberNo',index: 'MemberNo', width: 70},
			{name: 'mrn',index: 'mrn'},{name: 'agreeno',index: 'agreeno',hidden:true},
			{name: 'Name',index: 'Name'},
			{name: 'Newic',index: 'Newic'},
			{name: 'telhp',index: 'telhp' },
			{name: 'DOB',index: 'DOB'},
			{name: 'Sex',index: 'Sex', width: 30},
			{name: 'category',index: 'category',hidden:true},
			{name: 'categoryicn',index: 'categoryicn'},
			{name: 'add1',index: 'add1',hidden:true},{name: 'add2',index: 'add1',hidden:true},{name: 'add3',index: 'add1',hidden:true},
			{name: 'offadd1',index: 'offadd1',hidden:true},{name: 'offadd2',index: 'offadd1',hidden:true},{name: 'offadd3',index: 'offadd1',hidden:true},
			{name: 'telh',index: 'telh',hidden:true},{name: 'telo',index: 'telo',hidden:true},
			{name: 'email',index: 'email'},{name: 'subsysno',index: 'subsysno',hidden:true},{name: 'agent',index: 'agent',hidden:true},
		],
		gridview: true,
		rowattr: function (rd) {
			if (rd.category === "NOMINEE") {
				return {"class": "zebrahijau"};
			}
		},
		altRows: true,
		altclass: 'zebrabiru',
		multiselect: true,
		autowidth: true,
		rowNum:10,
		rowList:[10,20,30],
		pager: jQuery('#pager1'),
		viewrecords: true,
		beforeSelectRow: function(rowid, e){
			return(true);
		},
		onSelectRow: function(rowid, e){
			var ret=$("#grid").jqGrid('getRowData',rowid);
			if(e==true){
				rowidarray.push(rowid);
				$("#list4").jqGrid('addRowData',rowid,{MemberNo:ret.MemberNo,mrn:ret.mrn,Name:ret.Name,agreeno:ret.agreeno},'first');
			}else if(e==false){
				todel=rowid;rowidarray.forEach(del);
				$("#list4").jqGrid('delRowData',rowid);
			}
		},
		gridComplete :function(){
			rowidarray.forEach(sel);
		}
	});
	
	jQuery("#list4").jqGrid({
		datatype: "local",
		height: 250,
		width:500,
		colNames:['Member No','MRN', 'Name', 'Agreement No.'],
		colModel:[
			{name: 'MemberNo',index: 'MemberNo', width: 70},
			{name: 'mrn',index: 'mrn', width: 70},
			{name: 'Name',index: 'Name', width: 120},
			{name: 'agreeno',index: 'agreeno', width: 70},	
		],
		multiselect: true,
		autowidth: true,
		altclass: 'zebrabiru',
	});
	
	$('#repexlbut').click(function(){
		location.href="reportexl.php?rowidarray="+rowidarray;		
	});

});
</script>

</head>
<body>
<body><?php include("../../include/header.php")?><span id="pagetitle">Label</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"><p>Exit</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="viewbut"><p>View</p></button><i class="divider"></i>
            <button type="button" onClick="window.close();" id="repexlbut"><p>Excel</p></button><i class="divider"></i>
            <button type="button" onClick="window.close();" id="reppdfbut"><p>PDF</p></button><i class="divider"></i>
        </div>
        <div class="alongdiv">
            <table id="grid"></table>
            <div id="pager1"></div>
        </div>
        <div class="alongdiv">
       	 	<table id="list4"></table>
    	</div>
    </div>
</body>
</html>

