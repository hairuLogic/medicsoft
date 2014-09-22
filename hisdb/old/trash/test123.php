<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script type="text/javascript"> 
(function( $ ){
   $.fn.myfunction = function() {
      alert('hello world');
   }; 
})( jQuery );
jQuery().ready(function (){
$("#grid").jqGrid({
	url:'http://localhost/hisdb/test1231.php',
    datatype: "xml",
    height: 250,
	width:500,
    colNames: ['MRN', 'Name', 'Newic'],
    colModel: [{
        name: 'MRN',
        index: 'MRN',
		width: 250},
    {
        name: 'Name',
        index: 'Name',
		width: 250},
    {
        name: 'Newic',
		index: 'Newic',
		width: 250},
    ],
   	autowidth: true,
	rowList:[10,20,30],
	pager: jQuery('#pager1'),
    viewrecords: true,
    caption: "Stack Overflow Example",
}).navGrid('#pager1',{edit:false,add:false,del:false});

$('#butest').click(function(){
	this.myfunction();
});			
</script> 
<title>Untitled Document</title>
</head>

<body>
<table id="grid"></table>
<div id="pager1"></div>
<input type="button" id="butest"/>
</body>
</html>
