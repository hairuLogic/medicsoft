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
<title>Patient Report</title>
<script>
$(function(){
	var mrnarr=[];
	$('#pageinfoin').hide();
	$('#pageinfotog').click(function(){
		$('#pageinfoin').slideToggle('fast');
	});
	function chksbmt(){
		len=mrnarr.length;
		if(len==1){
			var curmrn=$('#mrn').val();
			if(curmrn!=mrnarr[0]){
				$('#submit').attr("disabled",true);
			}else{
				$('#submit').attr("disabled",false);
			}
		}
	}
	$("#srchmrn").click(function(){
		getdata();
	});
	$('#mrn').keyup(function(e){
		if (e.keyCode == 13) {
			getdata();
		}else{
			chksbmt();
		}
	});
	function getdata(){
		$('#name').closest('td').append("<img id='snakeload' src='../image/snakeload.gif' />");
		var mrn=$('#mrn').val();
		$.get('getname.php',{mrn:mrn},function(data){
			if(data.msg=='success'){
				mrnarr.length=0;
				mrnarr.push(mrn);
				$('#name').next().fadeOut('slow',function(){$(this).remove();});
				$('#name').val(data.data[0].Name);
				$('#submit').attr("disabled",false);
			}else if(data.msg=='no rows'){
				$('#name').next().fadeOut('slow',function(){
					$(this).remove();
					alert('No record found');
					$('#name').val('');
					$('#mrn').focus();
				});
			}
		}, "json");
	}
	$('#submit').click(function(){
		location.href="reportforpatpdf.php?mrn="+mrnarr;
	});
	$("#grid").jqGrid({
		url:'test1231.php',
		datatype: "xml",
		height: 250,
		width: 500,
		colNames: ['MRN', 'Name', 'Newic', 'Oldic', 'Birth Date', 'Sex', 'Card ID'],
		colModel: [
			{name: 'MRN',index: 'MRN', width: 30},
			{name: 'Name',index: 'Name'},
			{name: 'Newic',index: 'Newic'},
			{name: 'Oldic',index: 'Oldic'},
			{name: 'Birth Date',index: 'Birth Date'},
			{name: 'Sex',index: 'Sex', width: 30},
			{name: 'Card ID',index: 'Card ID'},
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
			inserttoarr(rowid);
			return(true);
		},
		caption: "Patient List",
	});
	function inserttoarr(rowid){
		$('#genbut').attr("disabled",false);
		if($.inArray(rowid,mrnarr)==-1){
			mrnarr.push(rowid);
		}else{
			mrnarr.splice($.inArray(rowid,mrnarr),1);
		}
		if(mrnarr.length==0)$('#genbut').attr("disabled",true);
		
	}
	function rstall(){
		mrnarr.length=0;
		$("#grid").jqGrid('resetSelection');
		$('#genbut').attr("disabled",true);
	}
	function genpdf(){
		location.href="reportforpatpdf.php?mrn="+mrnarr;
	}
	function hideall(kecuali){
		$('#tabs11 a').each(function(){
			if($(this).attr('href')==kecuali){
				$($(this).attr('href')).show("slow");
				$(this).attr('class','act');
			}else{
				$($(this).attr('href')).hide();
				$(this).attr('class','');
			}
		});
	}
	$('#rstbut').click(function(){
		rstall();
	});
	$('#genbut').click(function(){
		genpdf();
	});
	hideall('#individual');
	$('#tabs11 li').click(function(){
		var selected=$(this).children(":first").attr('href');
		if(selected=='#list'){
			rstall()
		}
		hideall(selected);
	});
});
</script>
<style>
#individual .bodydiv{
	padding:10px;
	margin:0px auto 10px auto;
	width:400px;
	height:100px;
}
#individual{
	background-color:#CCCCCC;
}
#individual .smalltitle{
	padding:0px 10px 0 10px;
	margin:10px auto 0px auto;
	height:auto;
	width:400px;
}
#individual td{
	padding:0px;
	padding-left:3px;
}
#individual input[type=text]{
	width:200px;
}
#individual #srchmrn{
	background-image:url(../image/true2.png);
	background-position:center;
	background-repeat:no-repeat;
	width:50px;
	margin-left:10px;
}
#individual label{
	font-size:13px;
	font-weight:bold;
}
#snakeload{
	margin-left:5px;
}
.smalltitle{
	height:30px;
}
</style>
</head>

<body>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> | Company: <?php echo $_SESSION['companyName'];?><a href="logout.php"> | Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
    <div id="formmenu">
    	<div id="menu">
        <span id="pagetitle">Patient Report</span>
        <button type="button" onClick="window.close();" id="extbut"></button>
        <button type="button" id="refbut" ></button>
        <button type="button" id="rstbut" disabled>Reset Button</button>
        <button type="button" id="genbut" disabled>Generate Button</button>
        </div>
        
 		<div class="alongdiv">
        <div class="smalltitle">
        	<div id="tabs11">
            <ul>
                <li><a href="#individual"><span>Individual</span></a></li>
                <li><a href="#list"><span>List</span></a></li>
            </ul>
        	</div>
        </div>
        	
                <div class="bodydiv" id="individual">
                <div class="smalltitle"><p>Individual Report</p></div>
                    <div class="bodydiv">
                        <table>
                            <tr><td><label for="mrn">MRN: </label></td><td><input id="mrn" type="text"/><input id="srchmrn" type="button" class="dialogbutton"/></td></tr>
                            <tr><td><label for="name">Name: </label></td><td><input id="name" type="text"/></td></tr>
                            <tr><td><label>Generate PDF: </label></td><td><input id="submit" type="button" value="Generate" class="orgbut" disabled="true"/></td></tr>
                        </table>
                    </div>
                </div>
                
                <div id="list">
                    <table id="grid"></table>
                    <div id="pager1"></div>
                </div>
                
        	
        </div>
    </div>
</body>
</html>
