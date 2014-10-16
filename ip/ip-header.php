<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Registration</title>
<link href="../../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../../css/reset.css" type="text/css"  />
<link href="../../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../../js/jquery-1.9.1.js"></script>
<script src="../../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../../js/jquery.maskedinput.min.js"></script>
<script src="../../js/jquery.mb.browser.min.js"></script>
<script src="../../../script/date_time.js"></script>
<script>
	function try2(){
		var obj=document.getElementById("mykad");
		var nResult = obj.ReadCard();
		if(nResult==0){
			document.getElementById("mcname").value=obj.GetGMPCName();
			document.getElementById("mcic").value=obj.GetIDNumber();
			document.getElementById("mcsex").value=obj.GetGender();
			document.getElementById("try").click();
		}else{	
			alert(obj.GetErrorDesc());		
		}
	}
	$(function(){
		var updmrn;
		$("#mcic").mask('?999999-99-9999');
		$('#pageinfoin,#almc,#try,#episodediv,.placeholder').show();
		$('#pageinfotog').click(function(){
			$('#pageinfoin').slideToggle('fast');
		});
		$('#refbut').click(function(){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			$('#grid').trigger("reloadGrid");
		});
		$('#viewbut').click(function(){
			window.open('registerpat.php?det=upd&mrn='+updmrn);
		});
		$('#addbut').click(function(){
			window.open('registerpat.php?det=rgd&mrn=');
		});
		$('#mykbut').click(function(){
			window.open('mycard.php');
		});
		function loadinfo(mrn,name,ic,sex,dob,hp,add1,add2,add3,offadd1,offadd2,offadd3,telh,telo){
			$('#curaddr1').val(add1);$('#curaddr2').val(add2);$('#curaddr3').val(add3);
			$('#offaddr1').val(offadd1);$('#offaddr2').val(offadd2);$('#offaddr3').val(offadd3);
			$('#telh').val(telh);$('#telo').val(telo);
			$('#tblname').html(name);$('#tblic').html(ic);$('#tblmrn').html(mrn);$('#tblsex').html(sex);$('#tblhp').html(hp);
			$('#tbladdr1').html(add1+"&nbsp;");$('#tbladdr2').html(add2+"&nbsp;");$('#tbladdr3').html(add3+"&nbsp;");
			var d = new Date();var n = d.getFullYear();
			var ndob=dob.split('-');var age=parseInt(n)-parseInt(ndob[0]);$('#tblage').html(age);
		}
		$("#grid").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'HUKM MRN', 'Name', 'Newic', 'Birth Date', 'Sex', 'Card ID'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'HUKM MRN',index: 'telhp'},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'DOB',index: 'DOB'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'idnumber'}
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
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "Patient List",
		});
		$("#grid1").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'Name', 'IC Number', 'Birth Date', 'Sex', 'Card ID'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Race'}
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
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "Patient Record on System",
		});

		$("#grid-episode").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Episode', 'Type', 'Reg Date', 'Case', 'Pay Type', 'Doctor', 'End Date', 'Status'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Race'}
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
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		$("#grid-ip-queue").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Date', 'MRN', 'HUKM MRN', 'Name', 'DOB', 'Doctor', 'Ward', 'Room', 'Bed'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Race'}
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager-ip-queue'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid-ip-queue").jqGrid('resetSelection');
				var ret=$("#grid-ip-queue").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "List of Patient",
		});

		$("#grid-chargestrans").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Chg Code', 'Description', 'Chg Grp', 'Trx Date', 'Trx Type', 'Quantity', 'Amount', 'Tax Amt', 'UOM', 'Bill No','Bill Date','Audit No','Document Ref'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Race'}
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
				var ret=$("#grid").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		$("#grid-gen-ord-entry").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['TT Date','Charge Code','Description','Issue Dept','Qty','Amt','Dosage'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Race'}
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager-gen-ord-entry'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid-gen-ord-entry").jqGrid('resetSelection');
				var ret=$("#grid-gen-ord-entry").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		$("#grid-ip-genbill").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN','Episode No','Name','New IC','Old IC','DOB'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'IC Number'},
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30}
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: false,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager-gen-ord-entry'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid-gen-ord-entry").jqGrid('resetSelection');
				var ret=$("#grid-gen-ord-entry").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		$("#grid-ip-discharge").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Payer Code','Name','Reference No'],
			colModel: [
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30}
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: false,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager-gen-ord-entry'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid-gen-ord-entry").jqGrid('resetSelection');
				var ret=$("#grid-gen-ord-entry").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		$("#grid-ip-coverage").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['No','Payer Code','Fin Class','Limit Amount','All Group?'],
			colModel: [
				{name: 'DOB',index: 'Date Birth'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Sex',index: 'Sex', width: 30}
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: false,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager-gen-ord-entry'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#grid-gen-ord-entry").jqGrid('resetSelection');
				var ret=$("#grid-gen-ord-entry").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			}
		});

		function gosearch(opr){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			var searchField=$('#searchField').val();
			var searchString=$('#searchString').val();
			var searchOper=opr;
			$("#grid").jqGrid('setGridParam',{url:"test1231.php?searchField="+searchField+"&searchString="+searchString+"&searchOper="+searchOper}).trigger("reloadGrid");
		}
		$('#search').click(function(){
			gosearch('lk');
		});
		$('#mcsearch').click(function(){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			$("#grid").jqGrid('setGridParam',{url:"test1231.php?searchField=Newic&searchString="+$('#mcic').val()+"&searchOper=lk"}).trigger("reloadGrid");
		});
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		$('#searchString').keyup(function (e){
			if (e.keyCode == 13) {
				gosearch('lk');
			}else{
				delay(function(){
					boldthesearch=true;
      				gosearch('lk');
    			}, 500 );
			}
		});
		$('#searchField').change(function(){
			if($('#searchField').val()=="MyCard" && $("#almc").is(":hidden")){
				$("#almc").slideDown("fast");
			}else{
				$("#almc").slideUp("fast");
			}
		});
		$("#try").click(function(){
			loadimg();
		});
		function loadimg(type){
			$.get("ftptry.php",{id:$("#mcic").val()+".bmp"}).done(
				function(data){
					//$("#img").attr("src","../mykad_img/"+$("#mcic").val()+".bmp");
					$("#img").attr("src","file:///C:/photo1.bmp");
				});
		}
		if(!jQuery.browser.msie){
			$('#searchField option[value=MyCard]').hide();
		}
		$("#epibut").click(function(){
			if($("#searchdiv").is(":hidden")){
				$(".placeholder").hide();
				$("#searchdiv").slideDown("fast");
				$("#episodediv").slideUp("fast");
			}else{
				$(".placeholder").show();
				$("#searchdiv").slideUp("fast");
				$("#episodediv").slideDown("fast");
			}	
		});
		$(".placeholder").click(function(){
			$(".placeholder").hide();
			$("#searchdiv").slideDown("fast");
			$("#episodediv").slideUp("fast");
		});
	});
</script>
<style>
.sideleft{
	width:32.3333%;
	padding-bottom:2%;
}
.sideleft .bodydiv{
	padding:2%;
	width:96%;
}
.sideleft .bodydiv input{
	width:98%;
}
#almc .bodydiv{
	overflow:auto;
}
#mctbl{
	float:left;
}
#mctbl input[type=text]{
	width:98%;
}
#almc img{
	margin:3px;
	border-color:#33CCFF;
	border-style:outset;
	border-width:3px;
	float:left;
}
#tblinfo{
	border-radius: 10px 10px 5px 5px;
	padding:1px;
	margin:1% auto;
	width:98%;
	border:thin solid #4D7094;
	color:#333333;
	text-align:left;
}
#tblinfo td{
	padding:2px;
	border:thin solid #4D7094;
	width: 40%;
	color:#000000;
	opacity:.6;
}
#tblinfo th{
	padding:2px;
	border:thin solid #4D7094;
	width:10%
}
#tblinfo #tdatas{
	border-radius: 10px 10px 0px 0px;
	padding:5px;
	font-size:large;
	text-align:center;
	border:thin solid #4D7094;
	background-color:#4D7094;
	color:#FFFFFF;
	opacity:1;
}
</style>
</head>
<body><?php include("../../../include/header.php")?>
