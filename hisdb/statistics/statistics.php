<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script>
$(function() {
	$("#datefrom").datepicker({
		changeMonth: true,
      	changeYear: true,
		dateFormat: 'dd/mm/yy'
	});
	$("#dateuntil").datepicker({
		changeMonth: true,
      	changeYear: true,
		dateFormat: 'dd/mm/yy'
	});
	$("#submit").click(function(){
		$.blockUI({ css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			} });
		$.get('statisticsres.php',{dateuntil:$('#dateuntil').val(),datefrom:$('#datefrom').val()},function(data){
			$.unblockUI();
			alert(data.count+' number of rows inserted to statistics table');
			setTimeout(location.href="http://localhost:8080/pentaho",3000);
		},'json');
	});
});
</script>
<style>
.try{
	margin: 10px 10px;
}
</style>
</head>

<body>

<div id="formmenu">
	<div id="menu">
    	<span id="pagetitle">Statistics</span>
       	<button type="button" onClick="window.close();" id="extbut"></button>
    </div>
	<div class="alongdiv">
    	<div class="smalltitle"><p>Statistics Date Range</p></div>
        <div class="bodydiv">
        	<div class="try">
            	<input type="text" id="datefrom"/> to <input type="text" id="dateuntil"/>
            	<input type="button" value="submit" id="submit"/>
            </div>
        </div>
    </div>
</div>
</body>
</html>
