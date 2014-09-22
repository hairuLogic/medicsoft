<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient List</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/jquery.mb.browser.min.js"></script>
<script src="../../script/date_time.js"></script>
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
		$('#pageinfoin,#almc,#try,#episodediv,.placeholder').hide();
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
			colNames: ['MRN', 'Name', 'Newic', 'Handphone', 'Birth Date', 'Sex', 'Card ID','add1','add2','add3','off1','off2','off3','telhp','telo'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'Handphone',index: 'telhp'},
				{name: 'DOB',index: 'DOB'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'idnumber'},
				{name: 'add1',index: 'add1',hidden:true},{name: 'add2',index: 'add1',hidden:true},{name: 'add3',index: 'add1',hidden:true},
				{name: 'offadd1',index: 'offadd1',hidden:true},{name: 'offadd2',index: 'offadd1',hidden:true},{name: 'offadd3',index: 'offadd1',hidden:true},
				{name: 'telh',index: 'telh',hidden:true},
				{name: 'telo',index: 'telo',hidden:true},
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
<body><?php include("../../include/header.php")?><span id="pagetitle">Patient List</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button" id="epibut"></button>
            <button type="submit" disabled='true' id="delbut" form='del'></button>
            <button type="button" id="apptbut"></button>
            <button type="button" disabled='true' id="viewbut"></button>
            <button type="button" id="addbut"></button>
            <button type="button" id="refbut"></button>
        </div>
        <div class="placeholder">Patient List</div>
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Search Patient</p></div>
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
         <div class="sideleft">
         	<div class="smalltitle"><p>Home</p></div>
            <div class="bodydiv">
                	<input type="text" id="curaddr1"/>
                    <input type="text" id="curaddr2"/>
                    <input type="text" id="curaddr3"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telh"/>
            </div>
         </div>
         <div class="sideleft">
         	<div class="smalltitle"><p>Office</p></div>
            <div class="bodydiv">
                	<input type="text" id="offaddr1"/>
                    <input type="text" id="offaddr2"/>
                    <input type="text" id="offaddr3"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telo"/>
            </div>
         </div>
         <div class="sideleft" style="margin-right:0%;width:33.333%">
         	<div class="smalltitle"><p>Payer Information</p></div>
            <div class="bodydiv">
                	<input type="text" id="peraddr1"/>
                    <input type="text" id="peraddr2"/>
                    <input type="text" id="peraddr3"/>
                    <input type="text" id="peraddr3"/>
            </div>
         </div></div>
         <div id="episodediv"><div class="alongdiv">
         	<div class="smalltitle"><p>Episode</p></div>
         	<div class="bodydiv">
            	<table id="tblinfo">
                	<tr>
                    	<td colspan="4" id="tdatas">Patient Detail</td>
                    </tr>
                  <tr>
                    <th>Name</th>
                    <td id="tblname"></td>
                    <th>I/C</th>
                    <td id="tblic"></td>
                  </tr>
                  <tr>
                    <th>MRN</th>
                    <td id="tblmrn"></td>
                    <th>Sex</th>
                    <td id="tblsex"></td>
                  </tr>
                  <tr>
                  	<th>Age</th>
                    <td id="tblage"></td>
                    <th>Handphone</th>
                    <td id="tblhp"></td>
                  </tr>
                  <tr>
                  	<th rowspan="3">Address</th>
                    <td id="tbladdr1">-</td>
                    <th></th>
                    <td></td>
                  </tr>
                  <tr>
                    <td id="tbladdr2">-</td>
                    <th></th>
                    <td></td>
                  </tr>
                  <tr>
                    <td id="tbladdr3">-</td>
                    <th></th>
                    <td></td>
                  </tr>
                </table>

            	
            	<table>
                  <tr>
                    <th>Episode No</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                  <tr>
                  	<td><input type="text" /></td>
                    <td><input type="text" /></td>
                    <td><input type="text" /></td>
                    <td><input type="text" /></td>
                  </tr>
                </table>
            </div>
         </div></div>
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

