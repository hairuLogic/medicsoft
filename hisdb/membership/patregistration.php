<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subscriber List</title>
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
<script src="../js/jquery.formatCurrency-1.4.0.min.js"></script>
<script src="../js/jquery.timeentry.package-1.5.2/jquery.timeentry.min.js"></script>
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
		var MemberNo='0',gridsysno,thiz,table,det,upd=false,updnom,updappt,updbill=false;perdis();
		var wrongic = new Array();
		$('#timeappt').timeEntry({spinnerImage: '../js/jquery.timeentry.package-1.5.2/spinnerOrange.png',spinnerSize: [20, 20, 0], spinnerBigSize: [40, 40, 0]
			,useMouseWheel: true, show24Hours: true
		});
		$("#mcic").mask('?999999-99-9999');
		$("#postcode,#postcode2,#postcode3").mask('99999?');
		$("#registerpatdiv #newic, #nomineediv #newic").inputmask({"mask": "999999-99-9999"});
		$('#almc,#try,#episodediv,.placeholder,#imgmk,#read,#registerpatdiv,#tab-container,#agentbutton').hide();
		$('#dg,#verdg,#apptdg').dialog({autoOpen:false,modal:true});
		$('#registerpatdiv #dob,#nomineediv #dob,#dateappt,#aggdate,#expdate').datepicker({
			onSelect: function(date){
				getAge(date,'#registerpatdiv',false);
			},
			changeMonth: true,
			changeYear: true,
			showOn:"button",
			buttonImage: "../image/datepicker.gif",
			buttonImageOnly: true,
			dateFormat: "dd-mm-yy"
		});
		$('#joindate').datepicker({
			onSelect: function(date){var term=0;
				var rowid=$("#gridbill").jqGrid('getGridParam', 'selrow');var ret=$("#gridbill").jqGrid('getRowData',rowid);
				var term=ret.term;var ndate=date.split('-');var ndate3=parseInt(ndate[2])+parseInt(term);var newdate=ndate[0]+'-'+ndate[1]+'-'+ndate3;
				if(isNaN(ndate3)){$('#expdate').val(date);}else{$('#expdate').val(newdate);}
			},
			changeMonth: true,
			changeYear: true,
			showOn:"button",
			buttonImage: "../image/datepicker.gif",
			buttonImageOnly: true,
			dateFormat: "dd-mm-yy"
		});
		$('#billfees').blur(function(){$('#billfees').formatCurrency({symbol: 'RM'});});
		disabletextfield('#nomineediv .bodydiv');
		$('a[href=#nomineediv]').click(function(){
			$("#gridnominee").jqGrid('resetSelection');
			var rowid=$("#grid").jqGrid('getGridParam', 'selrow');
			$("#gridnominee").jqGrid('setSelection',rowid,true);
			updnom=false;//$('#canbutnom').click();
		});
		$('a[href=#apptdiv]').click(function(){
			menuappt(false,true,true);
		});
		$('a[href=#registerpatdiv]').click(function(){
			if(MemberNo==0){awaladdmenu();upd=false;}else{upd=true;basepatdata();basemenu();}
		});
		$('a[href=#billdiv]').click(function(){
			menubill(true,false,true,true);disabletextfield('#formbill');
			$("#gridbill").trigger("reloadGrid");$("#griddba").jqGrid('setGridParam',{url:"jgn tukar/dbatbl.php?mbrno="+MemberNo}).trigger("reloadGrid");
		});
		function hidesearchdiv(){
			$("#searchdiv").slideUp("fast");
			$(".placeholder").show();
			$('#tab-container').slideDown("fast");
		}
		function menudis(x){
			if(x==4){
				$('#addbut,#viewbut,#apptbut,#epibut').attr('disabled',true);
			}else if(x==3){
				$('#addbut').attr('disabled',false);
				$('#viewbut,#apptbut,#epibut').attr('disabled',true);
			}else if(x==0){
				$('#addbut,#viewbut,#apptbut,#epibut').attr('disabled',false);
			}
		}
		$('#refbut').click(function(){
			menudis(3);
			if($("#searchdiv").is(":hidden")){
				$('#tab-container').slideUp("fast");
				$("#searchdiv").slideDown("fast");
				$(".placeholder").hide();
			}$('#grid').trigger("reloadGrid");
			//MemberNo=0;
		});
		$('#viewbut').click(function(){
			menudis(0);var rowid=$("#grid").jqGrid('getGridParam', 'selrow');var ret=$("#grid").jqGrid('getRowData',rowid);
			if($("#searchdiv").not(":hidden")){
				hidesearchdiv();
				if(ret.category==='SUBSCRIBER'){
					$('a[href=#registerpatdiv]').click();
				}else{
					$('a[href=#nomineediv]').click();
				}
			}else{
				if(ret.category=='SUBSCRIBER'){
					$('a[href=#registerpatdiv]').click();
				}else{
					$('a[href=#nomineediv]').click();
				}
			}
		});
		$('#addbut').click(function(){
			menudis(4);
			if($("#searchdiv").not(":hidden")){
				hidesearchdiv();$('#tab-container').easytabs('select', '#registerpatdiv');
			}else{
				$('#tab-container').easytabs('select', '#registerpatdiv');
			}
			awaladdmenu();
		});
		$("#epibut").click(function(){
			menudis(0);
			maketimedate();
			if($("#searchdiv").not(":hidden")){
				hidesearchdiv();$('#tab-container').easytabs('select', '#episodediv');
			}else{
				$('#tab-container').easytabs('select', '#episodediv');
			}
		});
		$("#apptbut").click(function(){
			menudis(0);
			if($("#searchdiv").not(":hidden")){
				hidesearchdiv();$('#tab-container').easytabs('select', '#apptdiv');
				menuappt(false,true,true);
			}else{
				$('#tab-container').easytabs('select', '#apptdiv');
			}
		});
		$("#billbut").click(function(){
			menudis(0);
			if($("#searchdiv").not(":hidden")){
				hidesearchdiv();$('#tab-container').easytabs('select', '#billdiv');disabletextfield('#formbill');menubill(true,false,true,true);
			}else{
				$('#tab-container').easytabs('select', '#apptdiv');
			}
		});
		$(".minimize").click(function(){
			$("#searchdiv").slideUp("fast");
			$(".placeholder").show();
			if(MemberNo!=0){
				$('#tab-container').slideDown("fast");
				$('#registerpatdiv #canbut2').click();
			}
		});
		$(".maximize,.placeholder").click(function(){
			if(MemberNo!=0){menudis(0);}else{menudis(3);}
			$(".placeholder").hide();
			$('#tab-container').slideUp("fast");
			$("#searchdiv").slideDown("fast");
		});
		function loadfrontinfo(add1,add2,add3,offadd1,offadd2,offadd3,telh,telo){
			$('#curaddr12').val(add1);$('#curaddr22').val(add2);$('#curaddr32').val(add3);
			$('#offaddr12').val(offadd1);$('#offaddr22').val(offadd2);$('#offaddr32').val(offadd3);
			$('#telh').val(telh);$('#telo2').val(telo);
		}
		function loadtblinfo(mrn,mbrno,agreeno,name,ic,sex,dob,hp,add1,add2,add3,agent){
			$('.tblname').html(name);$('.tblic').html(ic);$('.tblmrn').html(mrn);$('.tblmbrno').html(mbrno);$('.tblagree').html(agreeno);
			$('.tblsex').html(sex);$('.tblhp').html(hp);
			$('.tbladd1').html(add1+"&nbsp;");$('.tbladd2').html(add2+"&nbsp;");
			$('.tbladd3').html(add3+"&nbsp;");$('#billagent').val(agent);ckall('#billdiv');
			var d = new Date();var n = d.getFullYear();
			var ndob=dob.split('-');var age=parseInt(n)-parseInt(ndob[0]);$('.tblage').html(age);
		}
		function loadappttblinfo(mrn,name,ic,dob,cat,hp){
			$('#apptdiv #tblinfo #appttblmbrno').html(mrn);$('#apptdiv #tblinfo #appttblname').html(name);$('#apptdiv #tblinfo #appttblnewic').html(ic);
			$('#apptdiv #tblinfo #appttbldob').html(dob);$('#apptdiv #tblinfo #appttblcat').html(cat);$('#apptdiv #tblinfo #appttblhp').html(hp);
			
		}
		function loadinfonom(Name,mrn,DOB,Newic,citizencode,racecode,religion,patstatus,sex,areacode,language,add1,add2,add3,telh,telhp,telo,email,note,category,relate){
			$('#nomname').val(Name);$('#nomineediv #dob').val(DOB);$('#nomineediv #newic').val(Newic);$('#nomcitizen').val(citizencode);$('#nomrace').val(racecode);
			$('#nomrel').val(religion);$('#nomstat').val(patstatus);$('#nomsex').val(sex);$('#nomarea').val(areacode);$('#nomineediv #mrn').val(mrn);
			$('#nomlang').val(language);$('#nomadd1').val(add1);$('#nomadd2').val(add2);$('#nomadd3').val(add3);$('#nomtelh').val(telh);$('input[name=nomcat][value='+category+']').prop("checked", true);
			$('#nomtelhp').val(telhp);$('#nomtelo').val(telo);$('#nomemail').val(email);$('#nomineediv #note').val(note);$('#nomrelate').val(relate);ckall('#nomineediv');
		}
		function menuappt(add,upd,del){
			$('#addbutappt').attr('disabled',add);$('#updbutappt').attr('disabled',upd);$('#delbutappt').attr('disabled',del);
		}
		function menubill(save,add,edit,cancel){
			$('#savbutbill').attr('disabled',save);$('#addbutbill').attr('disabled',add);$('#updbutbill').attr('disabled',edit);$('#canbutbill').attr('disabled',cancel);
		}
		$('#addbutappt').click(function(){updappt=false;$('#apptdg').dialog('open');cleartextfield('#apptdg');loadapptdg(true);});
		$('#updbutappt').click(function(){updappt=true;$('#apptdg').dialog('open');loadapptdg(false);});
		$('#delbutappt').click(function(){});
		$('#addbutbill').click(function(){updbill=false;menubill(false,true,true,false);enabletextfield('#formbill');cleartextfield('#formbill','#billagent,#billagent2,#billfees');});
		$('#updbutbill').click(function(){updbill=true;menubill(false,true,true,false);enabletextfield('#formbill');$('#billfees').formatCurrency({symbol: 'RM'});});
		$('#canbutbill').click(function(){updbill=false;menubill(true,false,true,true);cleartextfield('#formbill','#billagent,#billagent2,#billfees');disabletextfield('#formbill');});
		$("#grid").jqGrid({
			url:'jgn tukar/test1231.php?first=1',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['Member No.', 'MRN','Agreement No.','Name', 'Newic', 'Handphone', 'Birth Date', 'Sex', 'Categorybtl','Category','add1','add2','add3','off1','off2','off3','telhp','telo','E-mail','subsyno','agent'],
			colModel: [
				{name: 'MemberNo',index: 'MemberNo', width: 70},
				{name: 'mrn',index: 'mrn'},{name: 'agreeno',index: 'agreeno',hidden:true},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'telhp',index: 'telhp' },
				{name: 'DOB',index: 'DOB'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'category',index: 'category',hidden:true},
				{name: 'categoryicn',index: 'categoryicn'},
				{name: 'add1',index: 'add1',hidden:true},{name: 'add2',index: 'add1',hidden:true},{name: 'add3',index: 'add1',hidden:true},
				{name: 'offadd1',index: 'offadd1',hidden:true},{name: 'offadd2',index: 'offadd1',hidden:true},{name: 'offadd3',index: 'offadd1',hidden:true},
				{name: 'telh',index: 'telh',hidden:true},{name: 'telo',index: 'telo',hidden:true},
				{name: 'email',index: 'email'},{name: 'subsysno',index: 'subsysno',hidden:true},{name: 'agent',index: 'agent',hidden:true},
			],
			gridview: true,
			rowattr: function (rd) {
				if (rd.category === "NOMINEE") {
					return {"class": "zebrahijau"};
				}
			},
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
				return(true);
			},
			onSelectRow: function(rowid, e){
				var ret1=$("#grid").jqGrid('getRowData',rowid);
				var ret=$("#grid").jqGrid('getRowData',ret1.subsysno);//subscriber sysno
				MemberNo=ret1.MemberNo;gridsysno=ret1.subsysno;
				$("#gridnominee").jqGrid('setGridParam',{url:"jgn tukar/nomineetbl.php?mbrno="+MemberNo}).trigger("reloadGrid");
				$("#gridapptlist").jqGrid('setGridParam',{url:"jgn tukar/apptlisttbl.php?mbrno="+MemberNo+'&icnum='+ret1.Newic}).trigger("reloadGrid");
				$("#griddba").jqGrid('setGridParam',{url:"jgn tukar/dbatbl.php?mbrno="+MemberNo}).trigger("reloadGrid");
				loadfrontinfo(ret1.add1,ret1.add2,ret1.add3,ret1.offadd1,ret1.offadd2,ret1.offadd3,ret1.telh,ret1.telo);
				loadtblinfo(ret.mrn,ret.MemberNo,ret.agreeno,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.telhp,ret.add1,ret.add2,ret.add3,ret.agent);
				loadappttblinfo(ret1.MemberNo,ret1.Name,ret1.Newic,ret1.DOB,ret1.categoryicn,ret1.telhp);
				$('#viewbut,#epibut,#apptbut,#billbut').attr('disabled',false);
			},
			gridComplete :function(){
				$("#grid").jqGrid('setSelection',gridsysno,true);
			}
		});
		$("#gridnominee").jqGrid({
			url:'jgn tukar/nomineetbl.php',
			datatype: "xml",
			height: 200,
			width: 500,
			colNames: ['Member No.','MRN','Name','Birth Date','Newic','citizencode','racecode','religion','patstatus','Sex','areacode','languagecode','add1','add2','add3','telh','telhp','telo','email','note','Category','relate'],
			colModel: [
				{name: 'MemberNo',index: 'MemberNo', width: 100},
				{name: 'mrn',index: 'mrn', width: 100},
				{name: 'Name',index: 'Name', width: 300},
				{name: 'DOB',index: 'DOB'},
				{name: 'Newic',index: 'Newic'},
				{name: 'citizencode',index: 'citizencode',hidden:true},
				{name: 'racecode',index: 'racecode',hidden:true},
				{name: 'religion',index: 'religion',hidden:true},
				{name: 'patstatus',index: 'patstatus',hidden:true},
				{name: 'sex',index: 'sex'},
				{name: 'areacode',index: 'areacode',hidden:true},
				{name: 'languagecode',index: 'languagecode',hidden:true},
				{name: 'add1',index: 'add1',hidden:true,hidden:true},{name: 'add2',index: 'add1',hidden:true,hidden:true},{name: 'add3',index: 'add1',hidden:true,hidden:true},
				{name: 'telh',index: 'telh',hidden:true,hidden:true},{name: 'telhp',index: 'telhp',hidden:true},{name: 'telo',index: 'telo',hidden:true,hidden:true},
				{name: 'email',index: 'email',hidden:true},{name: 'note',index: 'note',hidden:true},
				{name: 'category',index: 'category'},{name: 'relate',index: 'relate',hidden:true},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pagernominee'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#gridnominee").jqGrid('resetSelection');
				return(true);
			},
			onSelectRow: function(rowid, e){
				$('#savbutnom,#canbutnom').attr('disabled',true);$('#addbutnom,#updbutnom').attr('disabled',false);
				var ret=$("#gridnominee").jqGrid('getRowData',rowid);
				enabletextfield('#nomineediv');
				loadinfonom(ret.Name,ret.mrn,ret.DOB,ret.Newic,ret.citizencode,ret.racecode,ret.religion,ret.patstatus,ret.sex,ret.areacode,ret.language,ret.add1,ret.add2,ret.add3,ret.telh,ret.telhp,ret.telo,ret.email,ret.note,ret.category,ret.relate);
				disabletextfield('#nomineediv .bodydiv');
			},
		});
		$("#gridapptlist").jqGrid({
			url:'jgn tukar/apptlisttbl.php',
			datatype: "xml",
			height: 200,
			width: 500,
			colNames: ['Date','Time','Status','Remarks'],
			colModel: [
				{name: 'apptdate',index: 'apptdate', width: 100},
				{name: 'appttime',index: 'appttime', width: 100},
				{name: 'apptstatus',index: 'apptstatus'},
				{name: 'remarks',index: 'remarks', width: 300},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pagerapptlist'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#gridapptlist").jqGrid('resetSelection');
				return(true);
			},
			onSelectRow: function(rowid, e){
				var ret=$("#gridapptlist").jqGrid('getRowData',rowid);
				loadapptdg(false);
				menuappt(false,false,false);
			},
			caption:"Appointment List",
		});
		$("#gridbill").jqGrid({
			url:'jgn tukar/billtbl.php',
			datatype: "xml",
			height: 180,
			width: 400,
			colNames:['Package Code','Package Name','pkgstat','Price','term','bflag'],
			colModel:[
				{name:'pkgcode',index:'pkgcode', width:100},
				{name:'description',index:'description', width:200},
				{name:'pkgstat',index:'pkgstat',hidden:true},
				{name:'price',index:'price', width:100,align:'right'},{name:'term',index:'term', width:100,hidden:true},{name:'bflag',index:'bflag', width:100,hidden:true},
			],
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pagerbill'),
			viewrecords: true,
			caption: 'Bill Type',
			multiselect: true,
			subGrid : true,
			subGridRowExpanded: function(subgrid_id, row_id) {
				var subgrid_table_id, pager_id;subgrid_table_id = subgrid_id+"_t";pager_id = "p_"+subgrid_table_id;
				$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
				jQuery("#"+subgrid_table_id).jqGrid({
					url:"jgn tukar/billtbldet.php?pkgcode="+row_id,
					datatype: "xml",
					colNames: ['Package Code','Package Name','Effective Date','Price'],
					colModel: [
						{name:"pkgcode",index:"pkgcode",width:100,align:'left'},
						{name:"description",index:"description",width:110,align:'left'},
						{name:"effectdate",index:"effectdate",width:100,align:'left'},
						{name:"price",index:"price",width:100,align:'right'},
					],
					viewrecords: true,
					rowNum:20,
					height: '100%',
					onSelectRow: function(rowid, e){
						var ret=$(this).jqGrid('getRowData',rowid);
						$('#billfees').val(ret.price);
						$('#billfees').formatCurrency({symbol: 'RM'});
					},
				});
			},
			beforeSelectRow: function(rowid, e){
				jQuery("#gridbill").jqGrid('resetSelection');
				return(true);
			},
			onSelectRow: function(rowid, e){
				var ret=$("#gridbill").jqGrid('getRowData',rowid);
				if(ret.pkgstat=='0' && $('#addbutbill').is(':disabled')){
					$('#expdate,#joindate').datepicker("option",{disabled:true});
				}else if(ret.pkgstat=='1' && $('#addbutbill').is(':disabled')){
					$('#expdate,#joindate').datepicker("option",{disabled:false});
				}
				if(ret.pkgstat=='1' && $('#expdate,#joindate').val()!=''){
					var ret=$("#gridbill").jqGrid('getRowData',rowid);var date=$('#joindate').val();
					var term=ret.term;var ndate=date.split('-');var ndate3=parseInt(ndate[2])+parseInt(term);var newdate=ndate[0]+'-'+ndate[1]+'-'+ndate3;
					if(isNaN(ndate3)){$('#expdate').val(date);}else{$('#expdate').val(newdate);}
				}
				$('#billfees').val(ret.price);
				$('#billfees').formatCurrency({symbol: 'RM'});
			},
		});
		$("#griddba").jqGrid({
			url:'jgn tukar/dbatbl.php',
			datatype: "xml",
			height: 200,
			width: 500,
			colNames: ['Description','Agent','Join Date','Agreement Date','Expiry Date','Fees','memberno','agentcode','pkgcode'],
			colModel: [
				{name: 'remark',index: 'remark', width: 300},
				{name: 'agent',index: 'agent', width: 200},
				{name: 'joindate',index: 'joindate', width: 150},
				{name: 'aggdate',index: 'aggdate', width: 150},
				{name: 'expdate',index: 'expdate', width: 150},
				{name: 'amount',index: 'amount', align:'right',width: 150},
				{name: 'memberno',index: 'memberno', width: 150},
				{name: 'agentcode',index: 'agentcode', width: 150},
				{name: 'pkgcode',index: 'pkgcode', width: 150},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pagerdba'),
			viewrecords: true,
			beforeSelectRow: function(rowid, e){
				jQuery("#griddba").jqGrid('resetSelection');
				return(true);
			},
			onSelectRow: function(rowid, e){
				menubill(true,false,false,true);disabletextfield('#formbill');
				var ret=$("#griddba").jqGrid('getRowData',rowid);
				loadbillinfo(ret.agentcode,ret.agent,ret.amount,ret.joindate,ret.aggdate,ret.expdate);
				jQuery("#gridbill").jqGrid('resetSelection');$("#gridbill").jqGrid('setSelection',ret.pkgcode,true);
			},
		});
		function loadbillinfo(ag,ag2,fees,joind,aggd,expd){
			$('#billagent').val(ag);$('#billagent2').val(ag2);$('#billfees').val(fees);$('#joindate').val(joind);$('#aggdate').val(aggd);$('#expdate').val(expd);
		}
		function loadapptdg(onlyfirsthalf){
			var rowid=$("#grid").jqGrid('getGridParam', 'selrow');
			var ret=$("#grid").jqGrid('getRowData',rowid);
			var rowid2=$("#gridapptlist").jqGrid('getGridParam', 'selrow');
			var ret2=$("#gridapptlist").jqGrid('getRowData',rowid2);
			if(onlyfirsthalf){
				$('#telhappt').val(ret.telh);$('#telhpappt').val(ret.telhp);$('#teloappt').val(ret.telo);$('#emailappt').val(ret.email);
			}else{
				$('#telhappt').val(ret.telh);$('#telhpappt').val(ret.telhp);$('#teloappt').val(ret.telo);$('#emailappt').val(ret.email);
				$('#dateappt').val(ret2.apptdate);$('#timeappt').val(ret2.appttime);$('#remarksappt').val(ret2.remarks);$('#statusappt').val(ret2.apptstatus);
			}
		}
		$('#updbutnom').click(function(){
			updnom=true;
			$('#savbutnom,#canbutnom').attr('disabled',false);$('#addbutnom,#updbutnom').attr('disabled',true);
			var rowid=$("#gridnominee").jqGrid('getGridParam', 'selrow');
			var ret=$("#gridnominee").jqGrid('getRowData',rowid);
			enabletextfield('#nomineediv');
			loadinfonom(ret.Name,ret.mrn,ret.DOB,ret.Newic,ret.citizencode,ret.racecode,ret.religion,ret.patstatus,ret.sex,ret.areacode,ret.language,ret.add1,ret.add2,ret.add3,ret.telh,ret.telhp,ret.telo,ret.email,ret.note,ret.relate);
			$('#nomname').focus();
		});
		$('#addbutnom').click(function(){
			updnom=false;
			cleartextfield('#nomineediv');
			$('#savbutnom,#canbutnom').attr('disabled',false);$('#addbutnom,#updbutnom').attr('disabled',true);
			enabletextfield('#nomineediv');
			$('#nomname').focus();
		});
		$('#canbutnom').click(function(){
			if(!updnom){cleartextfield('#nomineediv');
				$('#savbutnom,#canbutnom,#updbutnom').attr('disabled',true);$('#addbutnom').attr('disabled',false);}
			else if(updnom){
				var rowid=$("#gridnominee").jqGrid('getGridParam', 'selrow');
				var ret=$("#gridnominee").jqGrid('getRowData',rowid);
				enabletextfield('#nomineediv');
				loadinfonom(ret.Name,ret.mrn,ret.DOB,ret.Newic,ret.citizencode,ret.racecode,ret.religion,ret.patstatus,ret.sex,ret.areacode,ret.language,ret.add1,ret.add2,ret.add3,ret.telh,ret.telhp,ret.telo,ret.email,ret.note);
				$('#savbutnom,#canbutnom').attr('disabled',true);$('#addbutnom,#updbutnom').attr('disabled',false);
			}
			disabletextfield('#nomineediv .bodydiv');
		});
		$('#savbutnom').click(function(){
			if(checkform('reqnom')&&checkdgcode('ck','reqnom','#nomineediv')&&checkform2('reqnom2','#nomineediv')){
				$.blockUI({css:{border:'none',padding:'15px',backgroundColor:'#000','-webkit-border-radius': '10px','-moz-border-radius':'10px',opacity:.5,color:'#fff'}}); 
				if(!updnom){
					$.post('jgn tukar/nomineesave.php',$('#formnominee').serialize()+'&'+$.param({'mbrno':MemberNo}),function(data){
						var msg=$(data).find('msg').text();
						var cursysno=$(data).find('lastsysno').text();
						if(msg=='success'){
							$.unblockUI();updnom=true;$('#gridnominee').trigger("reloadGrid");
							$('#savbutnom,#canbutnom').attr('disabled',true);$('#addbutnom,#updbutnom').attr('disabled',false);
							disabletextfield('#nomineediv .bodydiv');
							jQuery("#gridnominee").jqGrid('setSelection',cursysno,true);
						}
					});
				}else if(updnom){
					var rowid=$("#gridnominee").jqGrid('getGridParam', 'selrow');
					$.post('jgn tukar/nomineeupd.php',$('#formnominee').serialize()+'&'+$.param({'mbrno':MemberNo,'nomsysno':rowid}),function(data){
						var msg=$(data).find('msg').text();
						if(msg=='success'){
							$.unblockUI();$('#gridnominee').trigger("reloadGrid");
							$('#savbutnom,#canbutnom').attr('disabled',true);$('#addbutnom,#updbutnom').attr('disabled',false);
							disabletextfield('#nomineediv .bodydiv');
							jQuery("#gridnominee").jqGrid('setSelection',rowid,true);
						}
					});
				}
			}
		});
		$('#saveappt').click(function(){
			if(checkform('reqappt')){
				$.blockUI({css:{border:'none',padding:'15px',backgroundColor:'#000','-webkit-border-radius': '10px','-moz-border-radius':'10px',opacity:.5,color:'#fff'}});
				var rowid=$("#grid").jqGrid('getGridParam', 'selrow');var sysno=$('#gridapptlist').jqGrid('getGridParam','selrow');
				var ret=$("#grid").jqGrid('getRowData',rowid);
				if(!updappt){
					$.post('jgn tukar/apptsave.php',$('#formappt').serialize()+'&'+$.param({'mbrno':ret.MemberNo,'icnum':ret.Newic}),function(data){
						var msg=$(data).find('msg').text();
						if(msg=='success'){
							$.unblockUI();$('#gridapptlist').trigger("reloadGrid");
							cleartextfield('#apptdg');$('#apptdg').dialog('close');menuappt(false,true,true);
						}
					});
				}else{
					$.post('jgn tukar/apptupd.php',$('#formappt').serialize()+'&'+$.param({'mbrno':ret.MemberNo,'icnum':ret.Newic,'sysno':sysno}),function(data){
						var msg=$(data).find('msg').text();
						if(msg=='success'){
							$.unblockUI();$('#gridapptlist').trigger("reloadGrid");
							cleartextfield('#apptdg');$('#apptdg').dialog('close');menuappt(false,true,true);
						}
					});
				}
			}
		});
		$('#delbutappt').click(function(){
			var sysno=$('#gridapptlist').jqGrid('getGridParam','selrow');
			var conf=confirm('Confirm appointment deletion?');
			if(conf==true){
				$.blockUI({css:{border:'none',padding:'15px',backgroundColor:'#000','-webkit-border-radius': '10px','-moz-border-radius':'10px',opacity:.5,color:'#fff'}});
				$.post('jgn tukar/apptdel.php',{sysno:sysno},function(data){
					var msg=$(data).find('msg').text();
					if(msg=='success'){
						$.unblockUI();$('#gridapptlist').trigger("reloadGrid");menuappt(false,true,true);
					}
				});
			}
		});
		$('#savbutbill').click(function(){
			if(checkform('reqbill')){ckaggdate(MemberNo);}//fucntion are just below there
		});
		function ckaggdate(mbrno){
			var aggdate=$( "#aggdate" ).val();expdate=$( "#expdate" ).val();
			$.get('jgn tukar/ckaggdate.php',{mbrno:mbrno,aggdate:aggdate,expdate:expdate},function(data){
				if(data==true){
					enabletextfield('#formbill',1);
					$.blockUI({css:{border:'none',padding:'15px',backgroundColor:'#000','-webkit-border-radius': '10px','-moz-border-radius':'10px',opacity:.5,color:'#fff'}});
					var rowid=$("#gridbill").jqGrid('getGridParam', 'selrow');var ret=$("#gridbill").jqGrid('getRowData',rowid);
					var rowid2=$("#grid").jqGrid('getGridParam', 'selrow');var ret2=$("#grid").jqGrid('getRowData',rowid2);
					var rowid3=$("#griddba").jqGrid('getGridParam', 'selrow');var billfees2 = $('#billfees').asNumber();
					if(!updbill){
						$.post('jgn tukar/billsave.php',$('#formbill').serialize()+'&'+$.param({'memberno':MemberNo,'pkgcode':ret.pkgcode,'pkgstat':ret.pkgstat,'description':ret.description,'billfees2':billfees2,'bflag':ret.bflag,'agreementno':ret2.agreeno}),function(data){
							var msg=$(data).find('msg').text();
							if(msg=='success'){
								$.unblockUI();$('#griddba').trigger("reloadGrid");cleartextfield('#formbill','#billagent,#billagent2');disabletextfield('#formbill');menubill(true,false,true,true);
							}
						});
					}else{
						$.post('jgn tukar/billupd.php',$('#formbill').serialize()+'&'+$.param({'memberno':MemberNo,'pkgcode':ret.pkgcode,'pkgstat':ret.pkgstat,'description':ret.description,'auditno':rowid3,'billfees2':billfees2,'bflag':ret.bflag,'agreementno':ret2.agreeno}),function(data){
							var msg=$(data).find('msg').text();
							if(msg=='success'){
								$.unblockUI();$('#griddba').trigger("reloadGrid");cleartextfield('#formbill','#billagent,#billagent2');disabletextfield('#formbill');menubill(true,false,true,true);
							}
						});
					}
				}
				else if(data==false){alert('Agreement data or expiry date invalid');}
			},'json');
		}
		function cleartextfield(div,not){
			$(div+' input[type=text]:not('+not+'),input[type=field]:not('+not+'),textarea:not('+not+')').val('');
		}
		function gosearch(opr){
			$('#viewbut').attr('disabled',true);
			var searchField=$('#searchField').val();
			var searchString=$('#searchString').val();
			var searchOper=opr;
			$("#grid").jqGrid('setGridParam',{url:"jgn tukar/test1231.php?first=2&searchField="+searchField+"&searchString="+searchString+"&searchOper="+searchOper}).trigger("reloadGrid");
			MemberNo=0;
		}
		$('#search').click(function(){
			gosearch('lk');
		});
		$('#mcsearch').click(function(){
			$('#viewbut').attr('disabled',true);
			$('#delbut').attr('disabled',true);
			$("#grid").jqGrid('setGridParam',{url:"jgn tukar/test1231.php?first=2&searchField=Newic&searchString="+$('#mcic').val()+"&searchOper=lk"}).trigger("reloadGrid");
			MemberNo=0;
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
			$('#searchField option[value=MyCard],#mykbut2').hide();
		}
		function perdis(){
			$('[perdis]').attr('disabled',true);
		}
		function disabletextfield(div){
			$(div+' #dob,#aggdate,#expdate,#joindate').datepicker("option",{disabled:true});
			$(div+' input').attr('disabled',true);$(div+' textarea').attr('disabled',true);
			$(div+' select').attr('disabled',true);
			perdis();
		}
		function enabletextfield(div,notperdis){//1 means no perdis
			$(div+' #dob,#aggdate,#expdate,#joindate').datepicker("option",{disabled:false});
			$(div+' input,textarea').attr('disabled',false);$(div+' textarea').attr('disabled',false);
			$(div+' select').attr('disabled',false);
			if(!notperdis)perdis();
		}
		function basemenu(){
			disabletextfield('#registerpatdiv .bodydiv');
			$('#addbut').attr('disabled',false);
			$('#updbut2').attr('disabled',true);
			$('#canbut2').attr('disabled',true);
			$('#savbut2').attr('disabled',true);
			if(upd){
				$('#updbut2').attr('disabled',false);}
		}
		$("#tabs").tabs();
		$("#nomineediv #newic").keydown(function(e){
			if(e.which==9){var pdate=$(this).val();icblur(pdate,'#nomineediv',true);var rowid=$("#gridnominee").jqGrid('getGridParam', 'selrow');
				if(updnom==true){
					isicrepeat("#nomineediv #newic",rowid,'upd');
				}else{
					isicrepeat("#nomineediv #newic",rowid,'add');
				}
			}
		});
		$("#registerpatdiv #newic").keydown(function(e){
			if(e.which==9){
				var pdate=$(this).val();var rowid=$("#grid").jqGrid('getGridParam', 'selrow');var ret1=$("#grid").jqGrid('getRowData',rowid);
				icblur(pdate,'#registerpatdiv',true);
				if(upd==true){
					isicrepeat("#registerpatdiv #newic",ret1.subsysno,'upd');
				}
			}
		});
		$("#nomineediv #newic").blur(function(){
			var pdate=$(this).val();icblur(pdate,'#nomineediv',false);
		});
		$("#registerpatdiv #newic").blur(function(){
			var pdate=$(this).val();icblur(pdate,'#registerpatdiv',false);
		});
		function icblur(pdate,div,x){//icblur(datestring, divname, for giving alert);
			if(pdate!=''&&pdate!='______-__-____'&&pdate.indexOf("_") == -1){
				var py=pdate.substr(0,2);
				if(parseInt(py)>20){
					var npy='19'+py;
				}else{
					var npy='20'+py;
				}
				var pm=pdate.substr(2,2);
				var pd=pdate.substr(4,2);
				getAge(pd+'-'+pm+'-'+npy,div,x);
			}else{
				if(x){if(pdate.indexOf("_") != -1){alert('invalid i/c');$(div+' #newic').focus();}}
				$(div+' #dob,'+div+' #year,'+div+' #month,'+div+' #day').val('');
			}
		}
		function getAge(dateString,div,x){//getage(datestring, divname, gives alert);
			newds=dateString.split('-');
			var pyear,pmonth,pday;
			if(newds[1]>12||newds[1]<1){
				$(div+' #dob,'+div+' #year,'+div+' #month,'+div+' #day').val('');wrongic[div]=true;if(x){alert('invalid '+div+' i/c');$(div+' #newic').focus();}return 0;}
			if(newds[0]>31||newds[0]<1){
				$(div+' #dob,'+div+' #year,'+div+' #month,'+div+' #day').val('');wrongic[div]=true;if(x){alert('invalid '+div+' i/c');$(div+' #newic').focus();}return 0;}
			var today = new Date();
			var birthDate = new Date(newds[2]+'-'+newds[1]+'-'+newds[0]);
			pyear = today.getFullYear() - birthDate.getFullYear();
			pmonth = today.getMonth() - birthDate.getMonth();
			if (pmonth < 0 || (pmonth === 0 && today.getDate() < birthDate.getDate())){pyear--;}
			if(today.getDate() < birthDate.getDate()){pmonth-=1;}
			if(pmonth<0){pmonth+=12;}
			pday=today.getDate() - birthDate.getDate();
			if(pday<0){var x=getNumberOfDays(today.getYear(),today.getMonth());pday+=x;}
			$(div+' #year').val(pyear);$(div+' #month').val(pmonth);$(div+' #day').val(pday);$(div+' #dob').val(dateString);
			wrongic[div]=false;
		}
		function getNumberOfDays(year,month) {
			var isLeap = ((year % 4) == 0 && ((year % 100) != 0 || (year % 400) == 0));
			return [31, (isLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		}
		$( "#dg" ).on( "dialogclose", function( event, ui ) {$('#dg').children('#dgres').html('');$('#dgtxt').val('');} );
		$( "#verdg" ).on( "dialogclose", function( event, ui ) {$('#verdg').children('#versel').html('');} );
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
					thiz.prev().val(description);
					thiz.prev().prev().val(code);
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
		function checkic(div){
			if(wrongic[div]){
				alert("Wrong i/c");$(div+' #newic').focus();return false;
			}
		}
		function checkform2(x,div){
			var cont=false;var error=[];
			$(div+' input['+x+']').each(function(){
				if($(this).val()==''){
					error.push($(this));
				}else if($(this).val()!=''){
					cont=true;
				}
			});
			if(!cont){
				alert(error[0].attr('alert')+' is invalid');
				error[0].focus();
			}
			return cont;
		}
		function checkform(x,y,div){//checkform(input attb to be check eg. req, special case for verify, divname *only need in special case)
			var cont=true;
			var error=[];
			if(y==2){cont=false;var ic=$(div+' #newic').val();
				if(checkic(div)==false){cont=false;}else{
					if(ic.indexOf("_") != -1){error.push($(div+' #newic'));cont=false;}else{
						if($('#name').val()==''){error.push($('#name'));cont=false;}
						else{
							$('input['+x+']').each(function(){
								if($(this).val()==''){
									error.push($(this));
								}else if($(this).val()!=''){
									cont=true;
								}
							});	
						}
					}	
				}
			}else{
				$('input['+x+']').each(function(){
					if($(this).val()==''){
						cont=false;
						error.push($(this));
					}
				});
			}
			if(!cont){
				alert(error[0].attr('alert')+' is invalid');
				error[0].focus();
			}
			return cont;
		}
		function checkdgcode(x,y,div){
			var cont=true;var error=[];
			$(div+' input['+x+']['+y+']').each(function(){
				if($(this).next().val()==''){
					cont=false;
					error.push($(this));
				}
			});
			if(!cont){
				alert(error[0].attr('alert')+' code is invalid');
				error[0].focus();
			}
			return cont;
		}
		function basepatdata(){
			$('#registerpatdiv #menu').prepend("<img id='img' src='../image/ajax-loader.gif' />");
			$.post('jgn tukar/g8user.php',{mbrno:MemberNo},function(data){
				$('#registerpatdiv #mrn').val($(data).find('mrn').text());$('#registerpatdiv #agrno').val($(data).find('agrno').text());
				$('#registerpatdiv #name').val($(data).find('name').text());$('#registerpatdiv #newic').attr('disabled',false);
				$('#registerpatdiv #newic').val($(data).find('newic').text());$('#registerpatdiv #newic').attr('disabled',true);
				$('#oldic').val($(data).find('oldic').text());
				$('#othno').val($(data).find('othno').text());
				$('#title').val($(data).find('title').text());$('#agent').val($(data).find('agent').text());$('#agentname').val($(data).find('agentname').text());
				$('#curaddr1').val($(data).find('curaddr1').text());$('#curaddr2').val($(data).find('curaddr2').text());$('#curaddr3').val($(data).find('curaddr3').text());
				$('#offaddr1').val($(data).find('offaddr1').text());$('#offaddr2').val($(data).find('offaddr2').text());$('#offaddr3').val($(data).find('offaddr3').text());
				$('#peraddr1').val($(data).find('peraddr1').text());$('#peraddr2').val($(data).find('peraddr2').text());$('#peraddr3').val($(data).find('peraddr3').text());
				$('#postcode').val($(data).find('postcode').text());$('#postcode2').val($(data).find('postcode2').text());$('#postcode3').val($(data).find('postcode3').text());
				$('#registerpatdiv #dob').val($(data).find('dob').text());
				if($(data).find('dob').text()!=''&&$(data).find('dob').text()!='00-00-0000'){
					getAge($(data).find('dob').text(),'#registerpatdiv',false);
				}
				$('#area').val($(data).find('areacode').text());
				$('#citizen').val($(data).find('citizen').text());
				$('#marital').val($(data).find('marital').text());
				$('#race').val($(data).find('race').text());
				$('#religion').val($(data).find('religion').text());
				$('#sex').val($(data).find('sex').text());
				$('#bloodgroup').val($(data).find('bloodgroup').text());
				$('#language').val($(data).find('language').text());
				$('#house').val($(data).find('house').text());
				$('#hp').val($(data).find('hp').text());
				$('#telo').val($(data).find('telo').text());$('#tfax').val($(data).find('tfax').text());
				$('#occupation').val($(data).find('occupation').text());
				$('#company').val($(data).find('company').text());
				$('#email').val($(data).find('email').text());
				$('#relcode').val($(data).find('relcode').text());
				$('#staffid').val($(data).find('staffid').text());
				$('#chno').val($(data).find('chno').text());
				$('#active').val($(data).find('active').text());
				$('#confidential').val($(data).find('confidential').text());
				$('#MRecord').val($(data).find('MRecord').text());
				$('#oldmrn').val($(data).find('oldmrn').text());
				$('#fstatus').val($(data).find('fstatus').text());
				$('#registerpatdiv #note').val($(data).find('note').text());
				ckall('#registerpatdiv');
				$('#registerpatdiv #menu').children(':first').fadeOut('slow',function(){$(this).remove();});
			});
		}
		function addmenu(){
			$('#registerpatdiv #newic').attr('disabled',false);
			$('#registerpatdiv input[type=text]').val('');
			$('#registerpatdiv input[type=field]').val('');
			$('#registerpatdiv textarea').val('');
			$('#registerpatdiv #newic').attr('disabled',true);
			upd=false;
			basemenu();
			enabletextfield('#registerpatdiv');
			$('#updbut2').attr('disabled',true);
			$('#canbut2').attr('disabled',false);
			$('#savbut2').attr('disabled',false);
		}
		function updmenu(){
			upd=true;
			basemenu();
			enabletextfield('#registerpatdiv');
			$('#updbut2').attr('disabled',true);
			$('#canbut2').attr('disabled',false);
			$('#savbut2').attr('disabled',false);
		}
		$('#updbut2').click(function(){
			if(upd||MemberNo!="")updmenu();
		});
		$('#canbut2').click(function(){
			if(!upd){
				$('#registerpatdiv input[type=text]').val('');
				$('#registerpatdiv input[type=field]').val('');
				$('#registerpatdiv textarea').val('');
				basemenu();$('#addbut').attr('disabled',false);
				if(MemberNo!=""){
					basepatdata();
					$('#updbut2').attr('disabled',false);
					menudis(0);
				}
			}else if(upd){
				basepatdata();
				basemenu();
				menudis(0);
			}else{}
		});
		$('#savbut2').click(function(){
			if(checkform('req2',2,'#registerpatdiv')&&checkform('req')&&checkform2('req3','#registerpatdiv')&&checkdgcode('ck','req','#registerpatdiv')){
			$.blockUI({css:{border:'none',padding:'15px',backgroundColor:'#000','-webkit-border-radius': '10px','-moz-border-radius':'10px',opacity:.5,color:'#fff'}}); 
			if(!upd){
				$.post('jgn tukar/cr8user.php',$('#cr8user').serialize(),function(data){
					var msg=$(data).find('msg').text();
					var mrnfromsave=$(data).find('mbrno').text();
					var gridsysnofromsave=$(data).find('sysno').text();
					if(msg=='success'&&mrnfromsave!=null&&gridsysnofromsave!=null){
						$.unblockUI();MemberNo=mrnfromsave;gridsysno=gridsysnofromsave;
						upd=true;basepatdata();basemenu();$("#grid").jqGrid().trigger("reloadGrid");$('a[href=#nomineediv]').click();
					}
				});
			}else if(upd){
				$.post('jgn tukar/upd8user.php',$('#cr8user').serialize()+'&'+$.param({'mbrno':MemberNo,'sysno':gridsysno}),function(data){
					var msg=$(data).find('msg').text();
					if(msg=='success'){
						$.unblockUI();
						$("#grid").jqGrid().trigger("reloadGrid");
						basepatdata();
						basemenu();
					}
				});
			}
			}
		});
		$('[ck]').keydown(function(e){
			if($.trim($(this).val())!=''&&e.which==9){
				ck($(this).attr('id'),true);
			}
		});
		function ckall(div){
			$(div+' [ck]').each(function(){
				ck($(this).attr('id'));			
			});
		}
		function awaladdmenu(){
			addmenu();
			$("#registerpatdiv input,#registerpatdiv select").attr('disabled',true);
			$("#alongdivatas input,#verdg input,#dgtxt,#dgfld").attr('disabled',false);
			perdis();
		}
		function ck(inp,nakAlert){
			inp='#'+inp;
			$.get('ck.php',{table:$(inp).next().next().attr('table'),txt:$(inp).val()},function(data){
				if(data=='fail'){
					if(nakAlert){
						alert('Wrong '+$(inp).attr('name')+' code');$(inp).focus();
					}
					$(inp).next().val('');
				}else{
					$(inp).next().val(data);
				}
			},'json');
		}
		function vernew(ic,othno,name,dob,year,month,day,mrn,agrno,agent,title){
			addmenu();
			$('#registerpatdiv #newic').val(ic); $('#othno').val(othno);$('#name').val(name),$('#registerpatdiv #dob').val(dob),$('#year').val(year),$('#month').val(month),$('#day').val(day);$('#registerpatdiv #mrn').val(mrn);$('#registerpatdiv #agrno').val(agrno);$('#registerpatdiv #agent').val(agent);$('#registerpatdiv #title').val(title);
			$('#curaddr1').focus();ck('registerpatdiv #agent');ck('registerpatdiv #title');
		}
		function isicrepeat(ic,rowid,state){//return true if ic repeat
			$.get('jgn tukar/checkicrep.php',{ic:$(ic).val(),sysno:rowid,state:state},function(data){
				if(data=="repeat"){
					alert("I/C already exist");$(ic).focus();
				}else{
					return false;//ic tak repeat
				}
			},'json');
		}
		$('#verify').click(function(){
			if(checkform('req2',2,'#registerpatdiv')){
				var ic=$('#registerpatdiv #newic').val(),othno=$('#othno').val(),name=$('#name').val(),dob=$('#registerpatdiv #dob').val(),year=$('#year').val(),month=$('#month').val(),day=$('#day').val();var mrn=$('#registerpatdiv #mrn').val();var agrno=$('#registerpatdiv #agrno').val();var agent=$('#registerpatdiv #agent').val();var title=$('#registerpatdiv #title').val();
				$.get('jgn tukar/verify.php',{ic:$.trim(ic),othno:othno},function(data){
					if(data.msg=='got'){var schema="<div class='alldgdiv'><table class='grey'><tr><th>Member No.</th><th>Name</th></tr>";
						$.each(data.pat,function(i,item){
							schema+="<tr class='pointer' index='"+i+"'><td>"+item['MemberNo']+"</td><td>"+item['name']+"</td></tr>";
						});schema+="</table></div>";
						$('#verdg').dialog('open');
					}else if(data.msg=='not'){
						vernew(ic,othno,name,dob,year,month,day,mrn,agrno,agent,title);
					}
					$('#verdg').children('#versel').html(schema);
					$('.pointer').on('click',function(event){
						var index=parseInt($(this).attr('index'));
						var mbrno=data.pat[index]['MemberNo'];
						updmenu();
						MemberNo=mbrno;basepatdata();
						$('#verdg').dialog('close');
					});
					$('#vernew').on('click',function(event){vernew(ic,othno,name,dob,year,month,day,mrn);$('#verdg').dialog('close');})
				},'json');		
			}
		});
		$('#mykbut2').click(function(){
			if($("#alongdivatas .bodydiv #imgmk").is(":hidden")){
				$("#alongdivatas .bodydiv #animate").animate({width:"88%"},500,function(){
					$("#alongdivatas .bodydiv #imgmk").show();$("#read").show();
				});	
			}else{
				$("#alongdivatas .bodydiv #imgmk").hide();$("#read").hide();
				$("#alongdivatas .bodydiv #animate").animate({width:"98%"},500);
			}
		});
		$('#tab-container').easytabs();
		function maketimedate(){
			var d=new Date();
			$('#eptime').html(d.toLocaleTimeString());
			$('#epdate').html(d.toLocaleDateString());
		}
	});
</script>
<style>
#searchdiv .sideleft{
	padding-bottom:2%;
}
#searchdiv .sideleft .bodydiv{
	padding:2%;
	width:96%;
}
#searchdiv .sideleft .bodydiv input{
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
	margin:1%;
	width:48%;
	border-collapse:separate;
	border-color:#FF0000;
	color:#333333;
	text-align:left;
	float:left;
}
#tblinfo td{
	background-color:#D5D5D5;
	padding:2px;
	width: 40%;
}
#tblinfo th{
	background-color:#D5D5D5;
	padding:2px;
	width:10%;
}
#tblinfo #tdatas{
	padding:15px 3px;
	background-color:#B8B8B8;
	color:#663300;
	text-align:justify;
	font-weight:bold;
}
.bodydiv{
	overflow:auto;
}
.wrapper2{
	padding-top:0%;
	width:98%;
	clear:both;
	overflow:auto;
}
.wrapper3{
	margin: 1%;
	width:48%;
	float:left;
	overflow:auto;
}
.block{
	overflow:auto;
	float:left;
	padding:0.5% 0.5%;
}#nomineediv .block{height:28px;}
.block label,.blockadd label{
	display:inline-block;
	width:17%;
	padding-right:1%;
}
.block input[type=button]{
	padding:1px 2px;
}
#dgbdy label{
	padding-right: 1%;
	width: 27% !important;
}
#dgbdy input[type=field]{
	width: 15% !important;
}
#dgbdy input[type=text]{
	margin-left: 1% !important;
	width: 35% !important;
}
#dgbdy .dialogbutton{
	margin-left: 1% !important;
	width: 10% !important;
}
#dgtxt,#dgfld{
	font-size:12px;
	width:100%;
}#dgsrch{
	background-color:#FFFFCC;
	padding:5px;
	margin-top:10px;
	border:thin solid #666666;
}
#tabs input[type=text]{
	width:90%;
}
#vermen input[type=button]{
	margin-top:10px;
	font-size:14px
}
#animate{
	float:left;
	width:98%;
}
#imgmk{
	border-color:#33CCFF;
	border-style:outset;
	border-width:3px;
	float:right;
	margin:3px;
}
.wrapper2 .label2{
	cursor:pointer;
	background-color: #FFF0B2 !important;
	display:block !important;
	width:20% !important;
	height:12% !important;
	margin:1% !important;
}
#episodediv .wrapper2,#episodediv .wrapper3{
	margin:1% 1% 0% 1%;
}
#nomineediv .wrapper2{
	margin:0;padding:0;
}
#episodediv input[type=field],#nomineediv .bodydiv input[type=field]{
	width:18%;
	margin:0% .5% .5% 1%;
}
#episodediv select,#nomineediv .bodydiv select{
	width:18%;
	margin-right:1%;
	padding:2px;
}
#episodediv input[type=button],#nomineediv .bodydiv input[type=button]{
	padding:1px 10px;
}
#episodediv input[type=text],#nomineediv .bodydiv input[type=text]{
	width:47%;
	margin:0% .5% .5% 1%;
}
.blockadd{
	overflow:auto;
	float:left;
	padding:0% 0.5%;
	width:48%;
	clear:both;
}
#apptdg .block{
	width: 250px;
	overflow:visible;
}
#apptdg .block input[type=text]{
	width: 100px; 
}
#apptdg .block label{
	width: 100px;display:inline-block;
}
#apptdg textarea{
	width: 200px;
	height:60px;
}
#usericn{
	background-image:url(../image/user.png);
	background-position:left;
	background-repeat:no-repeat;
}
#billdiv .block3{
	clear:both;
}
#billdiv .block3 label{
	width:120px; display:inline-block;
}
#billdiv .block3 input[type=text]{
	width:200px;
}
</style>
</head>
<body><?php include("../../include/header.php")?><span id="pagetitle">Subscriber List</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"><p>Exit</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="billbut"><p>Billing</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="apptbut"><p>Appointment</p></button><i class="divider"></i>
            <button type="button" disabled='true' id="viewbut"><p>View</p></button><i class="divider"></i>
            <button type="button" id="addbut"><p>Add</p></button><i class="divider"></i>
            <button type="button" id="refbut"><p>Refresh</p></button><i class="divider"></i>
        </div>
        <div class="placeholder">Subscriber List<span id="micon" class="maximize"></div>
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle" style="position:relative"><p>Subscriber List</p><span id="micon" class="minimize"></span></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option value="MRN">MRN</option>
                        <option value="MyCard">MyCard</option>
                        <option selected value="Name">Name</option>
                        <option value="Newic">New IC</option>
                        <option value="Oldic">Old IC</option>
                        <option value="DOB">Birth Date</option>
                        <option value="Sex">Sex</option>
                        <option value="Idnumber">Card ID</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    </table>
          	</div>
         </div>
		<div class="alongdiv" id="almc">
        	<div class="smalltitle"><p>MyCard</p></div>
            <div class="bodydiv">
        		<table style="width:78%" id="mctbl">
                	<tr>
                    	<td>Name</td><td colspan="3"><input type="text" id="mcname"/></td>
                    </tr>
                    <tr>
                    	<td>I/C</td><td><input type="text" id="mcic"/></td>
                        <td>Sex</td><td><input style="width:95%" type="text" id="mcsex"/></td>
                    </tr>
                    <tr>
                    	<td colspan="4" style="text-align:right;">
                        	<input type="button" value="try" id="try">
                        	<input type="button" value="Read MyCard" class="orgbut" onClick="try2()" id="read">
                        	<input type="button" id="mcsearch" value="Search" class="orgbut"/>
                        </td>
                    </tr>
                </table>
                <img name="" src="../image/mykad1.png" width="100" height="150" alt="" id="img">
            </div>
        </div>
        <div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
        <div class="sideleft" style="margin-right:1%;width:32.333%">
         	<div class="smalltitle"><p>Home</p></div>
            <div class="bodydiv">
                	<input type="text" id="curaddr12"/>
                    <input type="text" id="curaddr22"/>
                    <input type="text" id="curaddr32"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telh"/>
            </div>
         </div>
         <div class="sideleft" style="margin-right:1%;width:32.333%">
         	<div class="smalltitle"><p>Office</p></div>
            <div class="bodydiv">
                	<input type="text" id="offaddr12"/>
                    <input type="text" id="offaddr22"/>
                    <input type="text" id="offaddr32"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telo2"/>
            </div>
         </div>
         <div class="sideleft" style="margin-right:0%;width:33.333%">
         	<div class="smalltitle"><p>Payer Information</p></div>
            <div class="bodydiv">
                	<input type="text" id="peraddr12"/>
                    <input type="text" id="peraddr22"/>
                    <input type="text" id="peraddr32"/>
                    <input type="text" id="peraddr32"/>
            </div>
         </div></div><!--end searchdiv-->
         
         
<div id="tab-container" class="tab-container">
    <ul class='etabs'>
        <li class='tab' id="tab1"><a href="#registerpatdiv">Subscriber Demographic</a></li>
        <li class='tab' id="tab2"><a href="#nomineediv">Beneficiary/Proxy</a></li>
        <li class='tab' id="tab3"><a href="#apptdiv">Appointment</a></li>
        <!--<li class='tab' id="tab4"><a href="#episodediv">Episode</a></li>-->
        <li class='tab' id="tab4"><a href="#billdiv">Billing Information</a></li>
    </ul>
<div class="panel-container">
          	<div id="registerpatdiv">
         		<div id="menu">
                    <button type="button" id="canbut2" ><p>Cancel</p></button><i class="divider"></i>
                    <button type="button" id="updbut2" ><p>Edit</p></button><i class="divider"></i>
                    <button type="button" id="mykbut2" ><p>mykad</p></button>
                    <button type="button" id="savbut2" ><p>Save</p></button><i class="divider"></i>
            	</div>
            <form id="cr8user" method="post" name="cr8user" action="jgn tukar/cr8user.php">
                <div class="alongdiv" id="alongdivatas">
                    <div class="smalltitle"><p>Subscriber Information</p></div>
                    <div class="bodydiv">
                        <div id="animate"><div class="wrapper2">
                        	<div class="block" style="width:20%"><label style="width:20%">MRN</label>
                        	  	<input type="field" id="mrn" style="width:50%" name="mrn" alert="Name" req>
                        	</div>
                            <div class="block" style="width:20%">
                        	  	<label style="width:40%">Agreement No.</label>
                        	  	<input type="field" id="agrno" name='agrno' style="width: 40%" alert="Agreement Number" req>
                        	</div>
                            <div class="block" style="width:27%"><label style="width:18%">Agent</label>
                        	  	<input type="field" id="agent" style="width: 15%" name='agent' alert="Agent" req ck><input type="text" perdis style="width: 30%;margin-left:1%">
                                <input style="width:15%;" type="button" value="..." class="dialogbutton" table="agent" title="Agent Selection"/>
                        	</div>
                            <div class="block" style="width:27%"><label for="title" style="width:25%">Salutation</label>
                                <input style="width:15%;" type="field" name="title" id="title" alert="Salutation" ck/><input style="width: 30%;margin-left:1%	" type="text" perdis>
                                <input style="width:15%;" type="button" value="..." class="dialogbutton" table="title" title="Title Selection"/></div>
                        </div>
                        
                    	<div class="wrapper2">
                            <div class="block" style="width:78%"><label for="name" style="width:10%">Name</label>
                                <input style="width:86%;" name="name" type="text" id="name" value='' req /></div>
                        </div>
                        	
                      	<div class="wrapper2" style="width:48%; margin:0.5%; clear:none; float:left" >
                        	<div class="block" style="width:38%"><label style="width:15%">I/C</label><input style="width:85%" name="newic" type="text" id="newic"  value='' alert="I/C" req2/></div>
                            <div class="block" style="width:58%"><label style="width:30%">Other No.</label><input style="width:85%" name="othno" type="text" id="othno"  value='' alert="Other Number" req2></div>
                        </div>
                        
                        <div class="wrapper2" style="background:#CCCCCC; margin:0.5% 0.5% 0.5% 0%; width:48%; border-radius: 5px; clear:none; float:left">
                        	<div class="block" style="width:47%"><label>DOB</label><input style="width:88%" type="field" name="dob" id="dob" readonly alert="DOB" req/></div>
                            <div class="block" style="width:15%"><label>Year</label><input style="width:88%" type="field" id="year" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Month</label><input style="width:88%" type="field" id="month" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Day</label><input style="width:88%" type="field" id="day" size="4" perdis/></div>
                        </div>
                        <div class="wrapper2">
                        	<input type="button" value="verify" id="verify" class="orgbut" style="float:right;margin-right:5px;margin-bottom:5px"/>
                        	<input type="button" value="Read MyCard" class="orgbut" onClick="try2()" id="read" style="float:right;margin-right:5px;margin-bottom:5px">
                        </div></div>
                        <img name="" src="../image/mykad1.png" width="100" height="150" alt="" id="imgmk">
                    </div>
                </div>
                

                <div class="sideleft">
                    <div class="smalltitle"><p>Address</p></div>
                    <div class="bodydiv">
                        <div id="tabs">
                            <ul>
                            <li><a href="#curaddr">Current</a></li>
                            <li><a href="#offaddr">Office</a></li>
                            <li><a href="#peraddr">Permenant</a></li>
                            </ul>
                            <div id="curaddr">
                                <input type="text" name="curaddr1" id="curaddr1"  alert="Address" req/>
                                <input type="text" name="curaddr2" id="curaddr2"  class=""/>
                                <input type="text" name="curaddr3" id="curaddr3"  class=""/>
                                <br/><br/>Postcode: <input type="text" name="postcode" id="postcode" req/>
                            </div>
                            <div id="offaddr">
                                <input type="text" name="offaddr1" id="offaddr1" />
                                <input type="text" name="offaddr2" id="offaddr2" />
                                <input type="text" name="offaddr3" id="offaddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode2" id="postcode2"/>
                            </div>
                            <div id="peraddr">
                                <input type="text" name="peraddr1" id="peraddr1" />
                                <input type="text" name="peraddr2" id="peraddr2" />
                                <input type="text" name="peraddr3" id="peraddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode3" id="postcode3"/>
                            </div>
                         </div>
                         <div class="block" style="width:98%">
                            <label>Area:</label><input style="width:10%;" type="field" name="area" id="area" alert="Area" req ck/>
                            <input type="text" perdis style="width:50%;">
                            <input type="button" value="..." class="dialogbutton" table="areacode" title="Area Selection" style="width:5%;"/>
                        </div>
                  </div>
                </div>
                
                <div class="sideright" id="dgbdy">
                	<div class="smalltitle"><p>Other Information</p></div>
                    <div class="bodydiv">
                        <div class="wrapper2">
                        	<div class="block" style="width:48%">
                            	<label>Citizen:</label><input type="field" name="citizen" id="citizen" alert="Citizen" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="citizen" title="Citizen Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	 <label>Race:</label><input type="field" name="race" id="race" alert="Race" req ck/>
                                 <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="racecode" title="Race Selection"/>
                            </div>
                        	<div class="block" style="width:48%">
                            	<label>Religion:</label><input type="field" id="religion" name="religion" alert="Religion" req ck/>
                                <input type="text" perdis><input type="button" value="..." table="religion" class="dialogbutton" title="Religion Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	<label>Language:</label><input type="field" name="language" id="language" alert="Language" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="languagecode" title="Language Selection"/>
                            </div>
                        </div>
                        
                        <div class="wrapper2">
                        	<div class="block" style="width:48%">Sex:<select name="sex" id="sex"><option>F</option><option>M</option></select></div>
                            <div class="block" style="width:48%">Marital:<select name="marital" id="marital"><option>M</option><option>S</option></select></div>
                        </div>
               		</div>         
                </div>
                
                <div class="sideright">
                	<div class="smalltitle"><p>Phone Number</p></div>
                    <div class="bodydiv">
                    	<div class="block" style="width:45%"><label style="width:22%">House</label><input style="width:72%" type="text" name="house" id="house" alert="Phone Number" req3/></div>
                        <div class="block" style="width:45%"><label style="width:22%">H/P</label><input style="width:72%" type="text" name="hp" id="hp" alert="" req3/></div>
                        <div class="block" style="width:45%"><label style="width:22%">Office</label><input style="width:72%" type="text" name="telo" id="telo" alert="" req3/></div>
                        <div class="block" style="width:45%"><label style="width:22%">fax</label><input style="width:72%" type="text" name="tfax" id="tfax" alert="" req3/></div>
                    </div>
                </div>
                
                <div class="alongdiv">
                    <div class="smalltitle"><p>Payer Information</p></div>
                    <div class="bodydiv">
                    	<div id="wrapper2" style="width:59%;clear:none;float:left;padding-top:1%;">
                        	<div class="block" style="width:100%">
                                <label>Occupation</label><input style="width:10%;" type="field" name="occupation" id="occupation" alert="Occupation" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="occupation" title="Occupation Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%">
                                <label>Company</label><input style="width:10%;" type="field" name="company" id="company" alert="Company" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="debtormast" title="Company Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%"><label>E-mail</label><input type="text" name="email" id="email" style="width:71%"/></div>
                        </div>
                        
                        <div id="wrapper2" style="width:40%;clear:none;float:left;padding-top:1%;">
                        	<div class="block" style="width:100%">
                            	<label>Relationship Code</label><input style="width:10%" type="field" id="relcode" name="relcode" alert="Relationship Code" ck/>
                                <input type="text" perdis style="width:50%;">
                               	<input type="button" value="..." class="dialogbutton" table="relationship" title="Relationship Code Selection" style="width:8%;"/>
                           	</div>
                            <div class="block" style="width:100%"><label>Staff ID</label><input style="width:61%" type="text" id="staffid" name="staffid"/></div>
                            <div class="block" style="width:100%"><label>Child No</label><input style="width:61%" type="text" id="chno" name="chno"/></div>
                        </div>
                        	
                            
                    </div>
                </div>
                
                <div class="alongdiv">
                	<div class="smalltitle"><p>Subscriber Record</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            <td>Active<select name="active" id="active"><option value="1">Yes</option><option value="0">No</option></select></td>
                            <td>Confidential<select name="confidential" id="confidential"><option value="1">Yes</option><option value="0">No</option></select></td>
                            <td>Medical record<select name="MRecord" id="MRecord"><option value="1">Yes</option><option value="0">No</option></select></td>
                            <td>New MRN<input type="field" size='4' name="newmrn" id="newmrn"/></td>
                            <td>Old MRN<input type="field" size='4' name="oldmrn" id="oldmrn"/></td>
                            <td>Financial Status<input type="field" size='4' name="fstatus" id="fstatus"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="alongdiv">
                	<div class="smalltitle"><p>Note/Remarks</p></div>
                	<div class="bodydiv">
                    	<textarea id="note" name="note" style="margin:0.5%; width:96%; height:100px;"></textarea>
                    </div>
                </div>
            </form>
	</div>   <!--end registerpatdiv-->

	<div id="nomineediv">
    	<div class="alongdiv">
        	<div class="smalltitle"><p>Subscriber Info</p></div>
         	<div class="bodydiv">
            	<table id="tblinfo">
                    <tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                    <tr><th>Name</th><td class="tblname"></td></tr>
                    <tr><th>I/C</th><td class="tblic"></td></tr>
                    <tr><th>MRN</th><td class="tblmrn"></td></tr>
                    <tr><th>Agreement No</th><td class="tblagree"></td></tr>
                    <tr><th>Member No</th><td class="tblmbrno"></td></tr>
                    <tr><th>Age</th><td class="tblage"></td></tr>
                </table>
				<table id="tblinfo">
                	<tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                	<tr><th>Address</th><td class="tbladd1"></td></tr>
                	<tr><th>&nbsp;</th><td class="tbladd2"></td></tr>
                  	<tr><th>&nbsp;</th><td class="tbladd3"></td></tr>
                    <tr><th>Handphone</th><td class="tblhp"></td></tr>
                    <tr><th>Sex</th><td class="tblsex"></td></tr>
                </table>
            </div>
        </div>
    	<div id="menu">
            <button type="button" id="canbutnom" disabled><p>Cancel</p></button><i class="divider"></i>
            <button type="button" id="updbutnom" disabled><p>Edit</p></button><i class="divider"></i>
            <button type="button" id="addbutnom" ><p>Add</p></button><i class="divider"></i>
            <button type="button" id="savbutnom" disabled><p>Save</p></button><i class="divider"></i>
        </div>
    	<div class="alongdiv" style="overflow:auto">
            <table id="gridnominee"></table>
			<div id="pagernominee"></div>
        </div>
        <div class="alongdiv">
        	<div class="smalltitle"><p>Nominee Info</p></div>
           	<div class="bodydiv">
                <form id="formnominee">
                    <div class="wrapper2">
                        <div class="block" style="width:48%;"><label>Name</label><input type="text" id="nomname" alert="Name" reqnom name="nomname"/></div>
                        <div class="block" style="width:48%;"><label>Category</label><label style="width:22%"><input name="nomcat" type="radio" value="BENEFICIARY">Beneficiary</label><label style="width:22%"><input name="nomcat" type="radio" value="PROXY">Proxy</label></div>
                        <div class="block" style="width:48%;"><label>IC No</label><input type="text" id="newic" alert="I/C Number" reqnom name="nomnewic"/></div>
                        <div class="block" style="width:48%;"><label>DOB</label><input type="text" id="dob" alert="DOB" reqnom name="nomdob" readonly/></div>
                        <div class="block" style="width:48%;"><label>MRN</label><input type="text" id="mrn" alert="MRN" reqnom name="nommrn"/></div>
                        <div class="block" style="width:48%;">
                            <label>Citizen</label><input type="field" id="nomcitizen" ck alert="Citizen" reqnom name="nomcitizen"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="citizen" title="Citizen Selection"/>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Race</label><input type="field" id="nomrace" alert="Race" ck reqnom name="nomrace"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="racecode" title="Race Selection"/>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Religion</label><input type="field" id="nomrel" alert="Religion" ck reqnom name="nomrel"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="religion" title="Religion Selection"/>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Area</label><input type="field" id="nomarea" alert="Area" ck reqnom name="nomarea"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="areacode" title="Area Selection"/>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Relationship</label><input type="field" id="nomrelate" alert="Relationship code" ck reqnom name="nomrelate"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="relationship" title="Relationship Selection"/>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Language</label><input type="field" id="nomlang" alert="Language" ck name="nomlang"/><input type="text" perdis/>
                            <input type="button" class="dialogbutton" value="..." table="languagecode" title="Language Selection"/>
                        </div>
                    </div>
                    <div class="wrapper2">
                        <div class="block" style="width:48%;">
                            <label>Status</label><select id="nomstat" name="nomstat"><option value="1">Active</option><option value="0">Cancelled</option></select>
                        </div>
                        <div class="block" style="width:48%;">
                            <label>Sex</label><select id="nomsex" name="nomsex"><option>F</option><option>M</option><option>U</option></select>
                        </div>
                    </div>
                    <div class="wrapper2">
                        <div class="blockadd">
                            <label>Address</label><input id="nomadd1" type="text" style="width:70%" alert="Address" reqnom name="nomadd1"/>
                        </div>
                        <div class="blockadd">
                            <label></label><input id="nomadd2" type="text" style="width:70%" name="nomadd2"/>
                        </div>
                        <div class="blockadd">
                            <label></label><input id="nomadd3" type="text" style="width:70%" name="nomadd3"/>
                        </div>
                        
                    </div>
                    <div class="wrapper2">
                        <div class="block" style="width:48%"><label>tel(H)</label><input id="nomtelh" type="text" name="nomtelh" alert="Phone" reqnom2/></div>
                        <div class="block" style="width:48%"><label>tel(HP)</label><input id="nomtelhp" type="text" name="nomtelhp" alert="" reqnom2/></div>
                        <div class="block" style="width:48%"><label>tel(O)</label><input id="nomtelo" type="text" name="nomtelo" alert="" reqnom2/></div>
                        <div class="block" style="width:48%"><label>email</label><input id="nomemail" type="text" name="nomemail" alert="" reqnom2/></div>
                    </div>
                    <div class="wrapper2">
                    	<div class="block" style="width:48%;height:128px;"><label>Note/Remark</label><textarea id="note" name="note" style="width:98%; height:100px;"></textarea></div>
                    </div>
                </form>
         	</div>
        </div>
    </div><!--end of nomineediv-->
    
	<div id="apptdiv">
    	<div class="alongdiv">
        	<div class="smalltitle"><p>Subscriber Info</p></div>
         	<div class="bodydiv">
            	<table id="tblinfo">
                    <tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                    <tr><th>Name</th><td class="tblname"></td></tr>
                    <tr><th>I/C</th><td class="tblic"></td></tr>
                    <tr><th>MRN</th><td class="tblmrn"></td></tr>
                    <tr><th>Agreement No</th><td class="tblagree"></td></tr>
                    <tr><th>Member No</th><td class="tblmbrno"></td></tr>
                    <tr><th>Age</th><td class="tblage"></td></tr>
                </table>
				<table id="tblinfo">
                	<tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                	<tr><th>Address</th><td class="tbladd1"></td></tr>
                	<tr><th>&nbsp;</th><td class="tbladd2"></td></tr>
                  	<tr><th>&nbsp;</th><td class="tbladd3"></td></tr>
                    <tr><th>Handphone</th><td class="tblhp"></td></tr>
                    <tr><th>Sex</th><td class="tblsex"></td></tr>
                </table>
            </div>
        </div>
    	<div class="alongdiv" style="overflow:auto">
            	<table id="tblinfo" style="width:98%;">
                	<tr>
                    	<td id="tdatas" style="width:50px;">Member No.</td>
                    	<td id="tdatas" style="width:200px;">Name</td>
                        <td id="tdatas" style="width:100px;">DOB</td>
                        <td id="tdatas" style="width:200px;">Newic</td>
                        <td id="tdatas" style="width:100px;">Category</td>
                        <td id="tdatas" style="width:200px;">Handphone</td>
                    </tr>
                    <tr>
                    	<td id="appttblmbrno" style="width:50px;">&nbsp;</td>
                        <td id="appttblname" style="width:50px;">&nbsp;</td>
                        <td id="appttbldob" style="width:50px;">&nbsp;</td>
                        <td id="appttblnewic" style="width:50px;">&nbsp;</td>
                        <td id="appttblcat" style="width:50px;">&nbsp;</td>
                        <td id="appttblhp" style="width:50px;">&nbsp;</td></tr>
                </table>
        </div>
    	<div id="menu">
            <button type="button" id="delbutappt" disabled><p>Delete</p></button><i class="divider"></i>
            <button type="button" id="updbutappt" disabled><p>Edit</p></button><i class="divider"></i>
            <button type="button" id="addbutappt" disabled><p>Add</p></button><i class="divider"></i>
        </div>
        <div class="alongdiv" style="overflow:auto">
            <table id="gridapptlist"></table>
			<div id="pagerapptlist"></div>
        </div>
   	</div><!--end of apptdiv-->
           
	<!--<div id="episodediv">
		<div class="alongdiv">
        	<div class="smalltitle"><p>Membership Info</p></div>
         	<div class="bodydiv">
            	<table id="tblinfo">
                    <tr><td colspan="4" id="tdatas">Patient Detail</td></tr>
                    <tr><th>Name</th><td id="tblname"></td></tr>
                    <tr><th>I/C</th><td id="tblic"></td></tr>
                    <tr><th>MRN</th><td id="tblmrn"></td></tr>
                    <tr><th>Sex</th><td id="tblsex"></td></tr>
                    <tr><th>Age</th><td id="tblage"></td></tr>
              		<tr><th>Handphone</th><td id="tblhp"></td></tr>
                </table>
				<table id="tblinfo">
                	<tr><td colspan="4" id="tdatas">Episode Detail</td></tr>
                	<tr><th>Episode No</th><td id="epno"></td></tr>
                	<tr><th>Type</th><td id="eptype">OP</td></tr>
                  	<tr><th>Date</th><td id="epdate"></td></tr>
                  	<tr><th>Time</th><td id="eptime"></td></tr>
                </table>
            </div>
         </div>
         <div class="alongdiv">
         	<div class="smalltitle"><p>Episode</p></div>
            <div class="bodydiv">
            	<div class="wrapper2">
                	<div class="block" style="width:48%;">
                    	<label>Reg Dept</label><input type="field"/><input type="text"/><input type="button" class="dialogbutton" value="..."/>
                    </div>
                	<div class="block" style="width:48%;">
                    	<label>Reg Source</label><input type="field"/><input type="text"/><input type="button" class="dialogbutton" value="..."/>
                    </div>
                	<div class="block" style="width:48%;">
                    	<label>Case</label><input type="field"/><input type="text"/><input type="button" class="dialogbutton" value="..."/>
                    </div>
                    <div class="block" style="width:48%;">
                    	<label>Doctor</label><input type="field"/><input type="text"/><input type="button" class="dialogbutton" value="..."/>
                    </div>
                    <div class="block" style="width:48%;">
                    	<label>Fin Class</label><input type="field"/><input type="text"/><input type="button" class="dialogbutton" value="..."/>
                    </div>
               	</div>
                <div class="wrapper2">
                    <div class="block" style="width:48%;">
                        <label>Pay Mode</label><select></select>
                    </div>
                    <div class="block" style="width:48%;">
                        <label>Admin Fees</label><select><option>Yes</option><option>No</option></select>
                    </div>
                </div>
                <div class="wrapper2">
                    <div class="block" style="width:48%;">
                    	<label>Reference Number</label><input type="field"/>
                    </div>
                    <div class="block" style="width:48%;">
                    	<label>Queue No</label><input type="field"/>
                    </div>
                </div>
                <div class="wrapper2">
                	<div class="block" style="width:98%;">
                    	<label>Case</label>
                        <label class="label2"><input name="epcase" type="radio" value="pregnant">Pregnant</label>
                        <label class="label2"><input name="epcase" type="radio" value="followup">Follow Up</label>
                        <label class="label2"><input name="epcase" type="radio" value="newcase">New Case</label>
                        <label class="label2"><input name="epcase" type="radio" value="newcasepregnant">New Case Pregnant</label>
                   	</div>
              	</div>
            </div>
         </div>
	</div><!--end episodediv-->
    <div id="billdiv" style="overflow:auto;">
        <div class="alongdiv">
        	<div class="smalltitle"><p>Subscriber Info</p></div>
         	<div class="bodydiv">
            	<table id="tblinfo">
                    <tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                    <tr><th>Name</th><td class="tblname"></td></tr>
                    <tr><th>I/C</th><td class="tblic"></td></tr>
                    <tr><th>MRN</th><td class="tblmrn"></td></tr>
                    <tr><th>Agreement No</th><td class="tblagree"></td></tr>
                    <tr><th>Member No</th><td class="tblmbrno"></td></tr>
                    <tr><th>Age</th><td class="tblage"></td></tr>
                </table>
				<table id="tblinfo">
                	<tr><td colspan="2" id="tdatas">Subscriber Detail</td></tr>
                	<tr><th>Address</th><td class="tbladd1"></td></tr>
                	<tr><th>&nbsp;</th><td class="tbladd2"></td></tr>
                  	<tr><th>&nbsp;</th><td class="tbladd3"></td></tr>
                    <tr><th>Handphone</th><td class="tblhp"></td></tr>
                    <tr><th>Sex</th><td class="tblsex"></td></tr>
                </table>
            </div>
        </div>
        <div id="menu">
            <button type="button" id="canbutbill" disabled><p>Cancel</p></button><i class="divider"></i>
            <button type="button" id="updbutbill" disabled><p>Edit</p></button><i class="divider"></i>
            <button type="button" id="addbutbill" ><p>Add</p></button><i class="divider"></i>
            <button type="button" id="savbutbill" disabled><p>Save</p></button><i class="divider"></i>
        </div>
        <div class="sideleft" style="width:49%; margin-top:1%; overflow:auto">
            <table id="gridbill"></table>
            <div id="pagerbill"></div>
        </div>
        <div class="sideright" style="width:49%; margin-top:1%; overflow:auto;">
        	<form id="formbill" name="formbill">
                <div class="block3"><label>Agent</label><input type="field" id="billagent" style="width:50px" ck alert="Agent" reqbill name="billagent" perdis/>
                	<input type="text" perdis style="width:144px; margin-left:1px" id="billagent2"/><input type="button" id='agentbutton' table="agent"/>
                </div>
                <div class="block3"><label>Agreement Date</label><input type="text" id="aggdate" name='aggdate' alert="Agreement Date" reqbill readonly/></div>
                <div class="block3"><label>Join Date</label><input type="text" id="joindate" name='joindate' alert="Join Date" reqbill readonly/></div>
               <div class="block3"> <label>Expiry Date</label><input type="text" id="expdate" name='expdate' alert="Expiry Date" reqbill readonly/></div>
               <div class="block3"><label>Fees</label><input type="text" id="billfees" name='billfees' alert="Fees" reqbill  style="text-align: right" perdis/></div>
           </form>
        </div>
        <div class="alongdiv" style="overflow:auto">
        	 <table id="griddba"></table>
            <div id="dbapager"></div>
        </div>
    </div><!--end of billdiv-->
    
    <div id="dg" title="">
        <div id="dgres"></div>
        <div id="dgsrch">
            <select id="dgfld"><option>Code</option><option selected>Description</option></select>
            <input type="text" id="dgtxt" style="width:98%"/>
        </div>
    </div>
    <div id="verdg" title="Name Verification">
        <div id='versel'></div>
        <div id='vermen'>
            <input type="button" value="new mrn" id="vernew" class="orgbut"/>
        </div>
    </div>
    <div id="apptdg" title="Add appointment">
    	<div class="bodydiv">
            <form name="formappt" id="formappt">
                <div class="wrapper2">
                    <div class="block"><label>Date</label><input type="text" id="dateappt" name="dateappt" reqappt readonly/></div>
                    <div class="block"><label>Time</label><input type="text" id="timeappt" name="timeappt" reqappt/></div>
                    <div class="block"><label>Status</label><select id="statusappt" name="statusappt"><option>Open</option><option>Attend</option><option>Not Attend</option><option>Cancelled</option></select>
                    <div class="block"><label>Tel(H)</label><input type="text" id="telhappt" name="telhappt"/></div>
                    <div class="block"><label>Tel(HP)</label><input type="text" id="telhpappt" name="telhpappt"/></div>
                    <div class="block"><label>Tel(O)</label><input type="text" id="teloappt" name="teloappt"/></div>
                    <div class="block"><label>Email</label><input type="text" id="emailappt" name="emailappt"/></div>
                    <div class="block"><label>Remarks</label><textarea id="remarksappt" name="remarksappt"></textarea></div>
                </div>
            </form>
            <div class="wrapper2">
                <input type="button" value="save" id="saveappt" class="orgbut"/>
            </div>
    	</div>
    </div>
</div>
</div>
    <object ID="mykad" name="mykad" CLASSID="CLSID:97DE6E33-4A00-4C5E-9CD8-A862D04A030D">
        <param name="flgAddress1" value="true">
        <param name="flgAddress2" value="true">
        <param name="flgAddress3" value="true">
        <param name="flgBirthDate" value="true">
        <param name="flgBirthPlace" value="true">
        <param name="flgCity" value="true">
        <param name="flgGender" value="true">
        <param name="flgGMPCName" value="true">
        <param name="flgIDNumber" value="true">
        <param name="flgOldIDNumber" value="true">
        <param name="flgPhoto" value="true">
        <param name="flgPostCode" value="true">
        <param name="flgRace" value="true">
        <param name="flgReligion" value="true">
        <param name="flgState" value="true">
	</object>
</body>
</html>

