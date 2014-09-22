<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script src="../js/jquery.timeentry.package-1.5.2/jquery.timeentry.min.js"></script>
<title>Appointment</title>
<script>
	$(function(){
		var d=new Date();datenow=dateFormatter(d);
		var dates = new Array();
		$( "#datepicker" ).datepicker({
			onSelect:function(date){
				$("#gridappt").jqGrid("setCaption","Appointment on: "+date);
				$("#gridappt").jqGrid('setGridParam',{url:"jgn tukar/appttbl.php?date="+date}).trigger("reloadGrid");
			},
			dateFormat: "dd-mm-yy",
			beforeShowDay: highlightDays,
		});
		$("#gridappt").jqGrid({
			url:'jgn tukar/appttbl.php?date='+datenow,
			datatype: "xml",
			height: 270,
			width: 500,
			colNames:['Time','Member No.','Name','I/C number','handphone'],
			colModel:[
				{name:'time',index:'time', width:80, align:'center'},
				{name:'mbrno',index:'mbrno', width:120, align:'center'},
				{name:'name',index:'name', width:400, align:'center'},
				{name:'icnum',index:'icnum', width:200, align:'center'},
				{name:'handphone',index:'handphone', width:150, align:'center'},
			],
			autowidth: true,
			caption: 'Appointment on: '+datenow,
			beforeSelectRow: function(rowid, e){
				jQuery("#gridappt").jqGrid('resetSelection');
				return(true);
			},
			onSelectRow: function(rowid, e){
			},
		});populatedate();
		function populatedate(){
			$.get("jgn tukar/loaddatepicker.php",{},function(data){
				for(var x=0;x<data.length;x++){
					dates.push(data[x]);
				}
				$( "#datepicker" ).datepicker( "refresh" );
			},'json');
		}
		function highlightDays(date) {
			for (var i = 0; i < dates.length; i++) {
				if (new Date(dates[i]).toString() == date.toString()) {              
					return [true, 'highlight'];
				}
			}
          	return [true, ''];
 		}  
		function dateFormatter(date){
			if(Date.parse('2/6/2009')=== 1233896400000){
				return [date.getMonth()+1, date.getDate(), date.getFullYear()].join('-');
			}
			return [date.getDate(), date.getMonth()+1, date.getFullYear()].join('-');
		}
		$('#refbut').click(function(){
			populatedate();$("#gridappt").trigger("reloadGrid");
		});
	});
</script>
<style>
	td.highlight {
		background-color: #FF9999 !important;
	}
</style>
</head>
<body><?php include("../../include/header.php")?><span id="pagetitle">Appointment</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"><p>Exit</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="apptbut"><p>Appointment</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="viewbut"><p>View</p></button><i class="divider"></i>
            <button type="button" id="addbut"><p>Add</p></button><i class="divider"></i>
            <button type="button" id="refbut"><p>Refresh</p></button><i class="divider"></i>
        </div>
        
        <div class="sideleft" style="width:24%; margin-top:1%;">
            <div id="datepicker" style="margin:1% auto; width:98%;"></div>
        </div>
        <div class="sideright" style="width:74%; margin-top:1%;">
        	<table id="gridappt"></table>
            <div id="pagerappt"></div>
        </div>
  	</div>

</body>
</html>
