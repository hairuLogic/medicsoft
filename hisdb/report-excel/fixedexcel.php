<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
 	$( "#from" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: "dd-mm-yy"
    });
    $( "#to" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: "dd-mm-yy"
    });
	$('#subm').click(function(){
		location.href="fixedphp2.php?from="+$('#from').val()+"&to="+$('#to').val();		
	});
});

</script>
<style>
	.bodydiv{
		width:70%;
		padding: 10px;
		margin:auto;
	}
</style>
<title>Untitled Document</title>
</head>

<body>
	<div id="formmenu">
        <div class="alongdiv">
            <div class="bodydiv">
            	<label for="from">From</label><input type="text" id="from" name="from" />
           		<label for="to">to</label><input type="text" id="to" name="to" />
                <input type="button" value="Generate" id="subm"/>
            </div>
        </div>
    </div>
</body>
</html>
