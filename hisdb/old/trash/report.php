<?php
	include_once('sschecker.php');
	include_once('connect_db.php');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<link href="formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<title>Untitled Document</title><br>
<script>
$(function(){
	var servername='http://192.168.0.142/'
	,newparam={
		url:servername+"hisdb/reportall2.php?table="+'religion',
		datatype: "xml",
		height: 250,
		width:1000,
		altRows: true,
		altclass: 'zebrabiru',
		multiselect: true,
		autowidth: true,
		rowNum:10,
		rowList:[10,20,30],
		pager: jQuery('#pager1'),
		viewrecords: true,
		gridComplete: function(){
			$("#selcol input[type=checkbox]").each(function(){
				var name=$(this).attr('id');
				if($(this).is(':checked')){
					showcol(name);
				}else{
					hidecol(name)
				}
			});
		},
	};
	$('#selcol').hide();
	setgridcol('religion');
	getcolname('religion');
	function setgridcol(table){
		var colNames=[],colModel=[];
		$.get('reportall.php',{table:table},function(data){
			var many=$(data).find('many').text();
			$(data).find('thx').each(function(){
				var x=$(this).find('val').text(),y=$(this).find('name').text();
				colNames.push(y);
				var obj={name:x,index:x};
				colModel.push(obj);
			});
			newparam.colNames=colNames;
			newparam.colModel=colModel;
			newparam.caption=$("#seltblform input[type=radio]:checked").parent().text();
			$("#grid").GridUnload();
			$("#grid").jqGrid(newparam);
			
		});
	}
	$('#pageinfoin').hide();
	$('#pageinfotog').click(function(){
		$('#pageinfoin').slideToggle('fast');
	});
	$('#seltblform input[type=radio]').click(function(){
		var table=$(this).attr('id');
		setgridcol(table);
		getcolname(table);
		setnewparam('url',servername+'hisdb/reportall2.php?table='+table);
	});
	
	function getcolname(table){
		$('#selcol').children().each(function(){
			$(this).remove();
		});
		$.post('reportres.php',{table:table},function(data){
			var x=0;
			$(data).find('row').each(function(){
				if(x%6==0)$('#selcol').append("<tr>");
				var colname=$(this).find('column').text(),checked=$(this).find('checked').text(),name=$(this).find('name').text();
				if(checked=='no'){
				$('#selcol').append("<td><input id='"+name+"' name='"+colname+"' type='checkbox' value='"+colname+"'><label for='"+name+"'>"+colname+"</label></td>");
				}else{
				$('#selcol').append("<td><input id='"+name+"' name='"+colname+"' type='checkbox' value='"+colname+"' checked><label for='"+name+"'>"+colname+"</label></td>");
				}
				if(x%6==0)$('#selcol').append("</tr>");
				x++;
			});
			$("#selcol input[type=checkbox]").on("click",function(event){
				var name=$(this).attr('id');
				if($(this).is(':checked')){
					showcol(name);
				}else{
					hidecol(name)
				}
			});
		});
		
	}
	function setnewparam(name,value){
		if(name=='url')newparam.url=value;
		$("#grid").GridUnload();
		$("#grid").jqGrid(newparam);
	}
	function hidecol(name){
		$("#grid").jqGrid('hideCol',name);
		$("#grid").setGridWidth($('.alongdiv').width());
	}
	function showcol(name){
		$("#grid").jqGrid('showCol',name);
		$("#grid").setGridWidth($('.alongdiv').width());
	}
	$('#selcoltog').click(function(){
		$('#selcol').slideToggle('fast');
	});
	$('#xlsrep').click(function(){
		var col=[],str,tbl=$('#seltblform input[type=radio]:checked').attr('id'),head=[],title=$("#seltblform input[type=radio]:checked").parent().text()+" Report";
		$("#selcol input[type=checkbox]:checked").each(function(){
			col.push($(this).attr('id'));
			head.push($(this).attr('name'));
		});
		if(tbl=='patmast'){
			str="select "+col.join()+" from patmast, religion, citizen, marital, languagecode, title, racecode, bloodgroup where patmast.Religion=religion.Code and patmast.Citizencode=citizen.Code and patmast.MaritalCode=marital.Code and patmast.LanguageCode=languagecode.Code and patmast.TitleCode=title.Code and patmast.RaceCode=racecode.Code and patmast.bloodgrp=bloodgroup.Code";
		}else{
			str="select "+col.join()+" from "+$('#seltblform input[type=radio]:checked').attr('id');
		}
		title+="( "+new Date().toISOString()+" )";
		var chg="reportproduce.php?sql="+str+"&len="+col.length+"&head="+head.join()+"&title="+title;		
		location.href=chg;
	});
	$('#refbut').click(function(){
		$('#grid').trigger("reloadGrid");
	});
});
</script>
<style>
#seltblform,#selcol{
	position:relative;
	padding:3px;
	margin:3px;
	background-color:#333333;
	border: thin solid #000000;
	color:#FFFFFF;
	-webkit-box-shadow: 0px 2px 3px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:0px 2px 3px rgba(50, 50, 50, 0.75);
	box-shadow:0px20px 3px rgba(50, 50, 50, 0.75);
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	 border-radius: 5px;
}
#selcoltog{
	cursor: pointer;
	padding:3px;
	position:absolute;
	right:8px;
	border: solid thin #000000;
	border-top:none;
	bottom:-23px;
	z-index:99;
	background-color:#333333;
	-webkit-box-shadow: 0px 2px 3px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:0px 2px 3px rgba(50, 50, 50, 0.75);
	box-shadow:0px20px 3px rgba(50, 50, 50, 0.75);
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	 border-bottom-left-radius: 5px;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px;
}
</style>
</head>
<body>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> Company: <?php echo $_SESSION['companyName'];?><a href="logout.php">  Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
    <div id="formmenu">
    	<div id="menu">
        	<span id="pagetitle">Report</span>
            <button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button" id="refbut" ></button>
            <button id="xlsrep">Produce Report</button>
        </div>
        <div class="alongdiv">
            <table id="grid"></table>
            <div id="pager1"></div>
  		</div>
        <div class="alongdiv">
        	<form id="seltblform">
            	<div id="selcoltog">Select Column</div>
            	<label><input type="radio" name="tablerg" value="" id="patmast">Patient Master</label>
            	<label><input type="radio" name="tablerg" value="" id="religion" checked>Religion</label>
                <label><input type="radio" name="tablerg" value="" id="racecode">Race</label>
                <label><input type="radio" name="tablerg" value="" id="bloodgroup">Blood Group</label>
                <label><input type="radio" name="tablerg" value="" id="citizen">Citizen</label>
                <label><input type="radio" name="tablerg" value="" id="country">Country</label>
                <label><input type="radio" name="tablerg" value="" id="languagecode">Language</label>
                <label><input type="radio" name="tablerg" value="" id="title">Title</label>
                <label><input type="radio" name="tablerg" value="" id="marital">Marital</label>
                <label><input type="radio" name="tablerg" value="" id="occupation">Occupation</label>
            </form>
      		<form id="selcol">
            	<table></table>
            </form>
        </div>
   	</div>
    
</body>
</html>
