<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
<link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
<script src="../script/jquery-1.9.1.js"></script>
<script src="../script/jquery-ui-1.10.1.custom.js"></script>
<script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
<script>
	$(function(){
		$( "#tabs" ).tabs({ heightStyle: "auto" });//set height for tab
	});
</script>
</head>

<body>
<div style="clear: both; margin-bottom: 15px;">
    <div id="tabs" class="tabs" style="height:450px">
        <ul>
            <li><a href="#tabs-1">Charge Item</a></li>
            <li><a href="#tabs-2">Return Item</a></li>
        </ul>
        <div id="tabs-1" >
        </div>
        <div id="tabs-2">                               
        </div>                          
    </div>
</div> 
</body>
</html>