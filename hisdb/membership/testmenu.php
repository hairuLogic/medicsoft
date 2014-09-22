<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/reset.css" rel="stylesheet" media="screen" type="text/css"  />
<link href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" rel="stylesheet" type="text/css" media="screen" />
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link href="../js/jquery.timeentry.package-1.5.2/jquery.timeentry.css" rel="stylesheet" type="text/css"/>
<link href="../js/tkahn-Smooth-Div-Scroll-4f5c825/css/smoothDivScroll.css" rel="stylesheet" type="text/css"/>
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
<script src="../js/tkahn-Smooth-Div-Scroll-4f5c825/js/jquery.smoothdivscroll-1.3-min.js"></script>
</head>
<style>
	#menu{
		overflow:auto;
	}
	.try{
		height:16px;
		padding:5px;
		width:70px;
		margin:2px 5px;
		display:inline-block;
		float:left;
		color:#FFFFFF;
		background-color:#999999;
		text-align:center;
	}
</style>
<script>
$(function(){
	var arr=new Array('1','2','3','4','5','6','7','8','9','10'),index=0;
	$('#for').click(function(){
		index++;populate();
	});
	$('#bac').click(function(){
		index--;populate();
	});
	populate();
	function populate(){
		var x=index;
		$('.try').each(function(i,e){
			$(this).html(arr[x]);
			x++;
		});
		if((index+1)+5>arr.length){
			$('#for').prop('disabled',true);
		}else{
			$('#for').prop('disabled',false);
		}
		if(index==0){
			$('#bac').prop('disabled',true)
		}else{
			$('#bac').prop('disabled',false);
		}
	}
});
</script>
<body>
    <div id="menu">
        	<div class="try"></div>
            <div class="try"></div>
            <div class="try"></div>
            <div class="try"></div>
            <div class="try"></div>
        <input type="button" value="forward" id="for"/>
        <input type="button" value="back" id="bac"/>
    </div>
</body>
</html>
