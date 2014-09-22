<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(function(){
	var table='billtype',thiz;$('#dg').dialog({autoOpen:false,modal:true});
	basemenu();
	function disableall(){
		$('#menu button').attr('disabled',true);
		disabletextfield();
	}
	$("#grid").jqGrid({
			url:"billtypetbl.php",
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Code','Description','Package','Created by','Date Created'],
			colModel: [
				{name: 'Code',index: 'Code', width: 50},
				{name: 'Description',index: 'Description'},
				{name: 'pkgflag',index: 'pkgflag',width: 20},
				{name: 'Lastupdate',index: 'adddate',width: 50},
				{name: 'Lastuser',index: 'addby',width: 50},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager1'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid").jqGrid('resetSelection');
				disabletextfield();
				var ret=$("#grid").jqGrid('getRowData',rowid);
				$('#code').val(ret.Code);
				$('#desc').val(ret.Description);
				$('#pkgstat').val(ret.pkgflag);
				$('#cr8by').val(ret.Lastupdate);
				$('#cr8d8').val(ret.Lastuser);
				$('#rowid').val(rowid);
				$('#updoradd').val('upd');
				selmenu();
				
				return(true);
			},
			caption:"Properties List",
	});
	function checkform(){
		var cont=true;
		var error=[];
		$('.req').each(function(){
			if($(this).val()==''){
				cont=false;
				error.push($(this));
			}
		});
		if(!cont){
			alert(error[0].attr('name')+' is required');
			error[0].focus();
		}
		return cont;
	}
	function enabletextfield(){
		$('#formtable input[type=text],#formtable input[type=button],#formtable select').attr('disabled',false);
		$('#code').focus();
	}
	function disabletextfield(){
		$('#formtable input[type=text],#formtable input[type=button],#formtable select').attr('disabled',true);
	}
	function basemenu(){
		disabletextfield()
		$('#addbut').attr('disabled',false);
		$('#canbut').attr('disabled',true);
		$('#updbut').attr('disabled',true);
		$('#savbut').attr('disabled',true);
		$('#delbut').attr('disabled',true);
		$('#refbut').attr('disabled',false);
		$('#extbut').attr('disabled',false);
	}
	function addmenu(){
		$('#formtable input[type=text]').val('');
		basemenu();
		enabletextfield();
		$('#updoradd').val('add');
		$('#cr8by').val($('#username').val());
		var now=new Date();
		$('#cr8d8').val(now.getDate()+'-'+(parseInt(now.getMonth())+1)+'-'+now.getFullYear());
		$('#savbut').attr('disabled',false);
		$('#canbut').attr('disabled',false);
		$('#addbut').attr('disabled',true);
	}
	function canmenu(){
		if($('#updoradd').val()=='add'){
			basemenu();
			jQuery("#grid").jqGrid('resetSelection');
			$('#formtable input[type=text]').val('');
		}else if($('#updoradd').val()=='upd'){
			var rets=$("#grid").jqGrid('getRowData',$('#rowid').val());
			$('#code').val(rets.Code);
			$('#desc').val(rets.Description);
			$('#cr8by').val(rets.Lastupdate);
			$('#cr8d8').val(rets.Lastuser);
			selmenu();
		}
	}
	function updmenu(){
		basemenu();
		enabletextfield();
		$('#savbut').attr('disabled',false);
		$('#canbut').attr('disabled',false);
		$('#addbut').attr('disabled',true);
	}
	function delmenu(){
		basemenu();
	}
	function selmenu(){
		basemenu();
		$('#updbut').attr('disabled',false);
		$('#delbut').attr('disabled',false);
	}
	function dooperation(oper){
		var cont=checkform();
		if(oper=='del')cont=true;
		if(cont){
		disableall();
		$('#menu').prepend("<img id='img' src='../image/ajax-loader.gif' />");
		$.get('allsetupaddnupd.php',{oper:$('#updoradd').val(),code:$('#code').val(),des:$('#desc').val(),pkgstat:$('#pkgstat').val(),table:table,id:$('#rowid').val(),username:$('#username').val()},function(data){
			$msg=$(data).find('msg').text();
			if($msg=='success'){
				$('#menu').children(':first').fadeOut('slow',function(){
					$(this).remove();
					if($('#updoradd').val()=='upd'){
						$('#menu').prepend("<p id='afterimg'>Update Successfull!</p>");
						$('#updoradd').val('add');
						canmenu();
					}else if($('#updoradd').val()=='add'){
						$('#menu').prepend("<p id='afterimg'>Add Successfull!</p>");
						addmenu();
					}else if($('#updoradd').val()=='del'){
						$('#menu').prepend("<p id='afterimg'>Delete Successfull!</p>");
						$('#updoradd').val('add');
						canmenu();
					}
					$('#menu').children(':first').fadeOut(3000,function(){$(this).remove();});
					$('#grid').trigger("reloadGrid");
				});
			}else if($msg=='failure'){
				$('#menu').children(':first').fadeOut('slow',function(){
					$(this).remove();
					$('#menu').prepend("<p id='afterimg'>Operation Failed</p>");
					$('#updoradd').val('add');
					canmenu();
					$('#menu').children(':first').fadeOut(3000,function(){$(this).remove();});
					$('#grid').trigger("reloadGrid");
				});
			}
		});
		}
	}
	$('#addbut').click(function(){
		addmenu();
		jQuery("#grid").jqGrid('resetSelection');
		$('#rowid').val('');
		enabletextfield();
	});
	$('#canbut').click(function(){
		canmenu();
	});
	$('#updbut').click(function(){
		updmenu();
	});
	$('#savbut,#delbut').click(function(){
		if($(this).attr('id')=="delbut"){
			$('#updoradd').val('del');
			dooperation('del');
		}else{
			dooperation();
		}
	});
	$('#refbut').click(function(){
		$('#grid').trigger("reloadGrid");
	});
	$('#desc').keyup(function (e){
		if (e.keyCode == 13) {
			dooperation();
		}
	});
	$('.dialogbutton').click(function(){
		thiz=$(this);
		table=$(this).attr('table');
		var title=$(this).attr('title');
		$('#dg').dialog('option','title',title);
		$('#dg').dialog('open');
		dgsearch();
	});
	function dgsearch(y,x){
		$.get('tablegrey.php',{table:table,fld:y,txt:x},function(data){
			var append="<div class='alldgdiv'><table class='grey'><tr><th>Code</th><th>Description</th></tr>";
			$.each(data,function(i,item){
				append+="<tr class='pointer' index='"+i+"'><td>"+item[0]+"</td><td>"+item[1]+"</td></tr>";
			});
			append+='</table></div>';
			$('#dg').children('#dgres').html(append);
			$('.pointer').on('click',function(event){
				var index=parseInt($(this).attr('index'));
				var code=data[index][0];
				var description=data[index][1];
				thiz.prev().val(code);
				$('#desc').val(description);
				$(dg).dialog('close');
				thiz=null;
			});
		},'json');
	}
	$('#dgtxt').keyup(function(e){
		var x=$(this).val();
		var y=$('#dgfld').val();
		dgsearch(y,x);
	});
	$('#pkgstat').change(function(){
		if($(this).val()=='No'){$('#butsel').attr('disabled',true);}
		else{$('#butsel').attr('disabled',false);}
	});
});
</script>
<style>
table,td,th,tr{
	padding:0;
	margin:0;
	text-align:left;
	font-weight:normal;
}
.smalltitle{
	position:relative;
}
#toggletable{
	position:relative;
	height:32px;
}
#in{
	z-index:99;
	top:-1px;
	right:10px;
	padding:3px;
	position:absolute;
	float:right;
	border-bottom: thin solid black;
	border-left: thin solid black;
	background-color:#333333;
	color:#FFFFFF;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
	-webkit-box-shadow: 0px 2px 3px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:0px 2px 3px rgba(50, 50, 50, 0.75);
	box-shadow:0px20px 3px rgba(50, 50, 50, 0.75);
}
#toggler{
	font-size:16px;
	position:absolute;
	bottom:-2px;
	right:10px;
	padding:3px;
	border:solid thin black;
	cursor:pointer;
	background-color:#333333;
	-webkit-box-shadow: 0px -2px 3px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:0px -2px 3px rgba(50, 50, 50, 0.75);
	box-shadow:0px -2px 3px rgba(50, 50, 50, 0.75);
	-moz-border-radius-topleft: 5px;
	-webkit-border-top-left-radius: 5px;
	 border-top-left-radius: 5px;
	-moz-border-radius-topright: 5px;
	-webkit-border-top-right-radius: 5px;
	border-top-right-radius: 5px;
	color:white;
}
#afterimg{
	position:absolute;
	bottom:5px;
	left:15px;
	width:210px;
	background-color:#FFFFCC;
	border: thin solid red;
	text-align:center;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	color:red; 
}
#formtable tr td input[type=text]{
	width:95%;
}
#dgsrch{
	background-color:#FFFFCC;
	padding:5px;
	margin-top:10px;
	border:thin solid #666666;
}
</style>
<title>Bill Setup</title>
</head>

<body><?php include("../../include/header.php")?><span id="pagetitle">Bill Setup</span>
	
	<div id="formmenu">
    	<div id="menu">
            <button type="button" id="canbut" ><p>Cancel</p></button><i class="divider"></i>
            <button type="button" id="delbut" ><p>Delete</p></button><i class="divider"></i>
            <button type="button" id="updbut" ><p>Edit</p></button><i class="divider"></i>
            <button type="button" id="addbut" ><p>Add</p></button><i class="divider"></i>
            <button type="button" id="savbut" ><p>Save</p></button><i class="divider"></i>
            <button type="button" id="refbut" ><p>Refresh</p></button>
        </div>
        <input type="hidden" id="username" value="<?php echo $_SESSION['username'];?>"/>
        <input type="hidden" id="updoradd"/>
        <input type="hidden" id="rowid"/>
        <div class="alongdiv">
       <div class="smalltitle"><p>Table form</p></div>
       <div class="bodydiv">
        <table id="formtable" width="100%">
        <tr><th style="padding:0 5px;"><label>Package</label></th><th><label>Code</label></th><th><label>Description</label></th><th><label>Created By</label></th><th><label>Created Date</label></th></tr>
        <tr>
        <td width="5%" style="padding:0 5px;"><select id="pkgstat" name="pkgstat"><option>Yes</option><option>No</option></select></td>
        <td width="10%"><input type="text" id="code" name="Code" class='req' style="width:70%"/><input type="button" class="dialogbutton" value="..." table="pkgmast" title="Code Selection" style="width:20px; margin-left:3px" id="butsel"/></td>
        <td width="30%"><input type="text" id="desc" name="Description" class="req"/></td>
        <td width="10%"><input type="text" id="cr8by" name="cr8by"/></td>
        <td width="10%"><input type="text" id="cr8d8" name="cr8d8"/></td></tr>
        </table>
        </div>
        </div>
        
        <div class="alongdiv">
        	<table id="grid"></table>
			<div id="pager1"></div>
        </div>
	</div>
    <div id="dg" title="">
        <div id="dgres"></div>
        <div id="dgsrch">
            <select id="dgfld" style="width:98%"><option>pkgcode</option><option selected>description</option></select>
            <input type="text" id="dgtxt" style="width:98%"/>
        </div>
    </div>
</body>
</html>
