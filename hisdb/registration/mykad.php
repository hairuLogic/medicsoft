<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />

<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
/*<iframe src="mykad.php" style="width:800px; height:500px;"></iframe>

	var obj = new ActiveXObject("MyKad_OCX.MyKad");
	obj.flgAddress1=true;
	obj.flgAddress2=true;
	obj.flgAddress3=true;
	obj.flgBirthDate=true;
	obj.flgBirthPlace=true;
	obj.flgCity=true;
	obj.flgGender=true;
	obj.flgGMPCName=true;
	obj.flgIDNumber=true;
	obj.flgOldIDNumber=true;
	obj.flgPhoto=true;
	obj.flgPostCode=true;
	obj.flgRace=true;
	obj.flgReligion=true;
	obj.flgState=true;
*/	
function try2(){
		obj=document.getElementById("mykad");
		var nResult = obj.ReadCard();
		if(nResult==0){
			document.getElementById("name").value=obj.GetGMPCName();
			document.getElementById("icnum").value=obj.GetIDNumber();
			document.getElementById("addr1").value=obj.GetAddress1();
			document.getElementById("addr2").value=obj.GetAddress2();
			document.getElementById("addr3").value=obj.GetAddress3();
			document.getElementById("oldicnum").value=obj.GetOldIDNumber();
			document.getElementById("sex").value=obj.GetGender();
			document.getElementById("dob").value=obj.GetBirthDate();
			document.getElementById("race").value=obj.GetRace();
			document.getElementById("posc").value=obj.GetPostCode();
			document.getElementById("city").value=obj.GetCity();
			document.getElementById("rel").value=obj.GetReligion();
			document.getElementById("state").value=obj.GetState();
			document.getElementById("bplc").value=obj.GetBirthPlace();
			document.getElementById("img").src="file://C:/photo1.bmp";
		}else{	
			alert(obj.GetErrorDesc());		
		}
	}	
$(function(){
	$('#reg').click(function(){
		window.open("registerpat.php");
	});
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
			{name: 'Birth Date',index: 'DOB'},
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
			/*var ret=$("#grid").jqGrid('getRowData',rowid);
			updmrn=ret.MRN;
			$('#curaddr1').val(ret.add1);$('#curaddr2').val(ret.add2);$('#curaddr3').val(ret.add3);
			$('#offaddr1').val(ret.offadd1);$('#offaddr2').val(ret.offadd2);$('#offaddr3').val(ret.offadd3);
			$('#telh').val(ret.telh);$('#telo').val(ret.telo);
			$('#viewbut').attr('disabled',false);
			$('#delbut').attr('disabled',false);*/
			return(true);
		},
		caption: "Patient List"
	});
	$("#try").click(function(){
		$.get("ftptry.php",{id:$("#icnum").val()+".gif"}).done(
			function(data){
				$("#img").attr("src","../mykad_img/"+$("#icnum").val()+".gif");
			}
		);	
	});	
});
</SCRIPT>
<title>Untitled Document</title>
<style>
.block{
	padding:3px;
	border:1px black solid;	
	width:90%;
	clear:both;
	margin:10px auto;
	overflow:auto;
}
table{
	width:80%;
	float:left;
}
img{
	padding-left:2%;
	float:left;
}

td{
	text-align:right;
}
input[type=text]{
	width:98%;
}
</style>
</head>


<body>
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
<div class="block">
<table>
<tr>
	<td  width="15%">Name</td><td width="50%"><input type="text" id="name"/></td>
	<td  width="15%">IC Number</td><td  width="20%"><input type="text" id="icnum"/></td>
</tr>
<tr>
	<td>Address</td><td><input type="text" id="addr1"/></td>
	<td>Old IC</td><td><input type="text" id="oldicnum"/></td>
</tr>
<tr>
	<td></td><td><input type="text" id="addr2"/></td>
	<td>Sex</td><td><input type="text" id="sex"/></td>
</tr>
<tr>
	<td></td><td><input type="text" id="addr3"/></td>
	<td>D.O.B</td><td><input type="text" id="dob"/></td>
</tr>
<tr>
	<td>PostCode</td><td><input type="text" id="posc"/></td>
	<td>Race</td><td><input type="text" id="race"/></td>
</tr>
<tr>
	<td>City</td><td><input type="text" id="city"/></td>
	<td>Religion</td><td><input type="text" id="rel"/></td>
</tr>
<tr>
	<td>State</td><td><input type="text" id="state"/></td>
	<td>Birth Place</td><td><input type="text" id="bplc"/></td>
</tr>
</table>
<img name="" src="" width="150" height="200" alt="" id="img">
</div>
<div class="block" style="text-align:right">
	<input type="button" value="Update" id="upd"/>
	<input type="button" value="Register" id="reg"/>
  	<input type="button" value="Read Mykad" id="read" onClick="try2()"/>
    <input type="button" value="try" id="try"/>
    <!--<form action="upload_file.php" method="post"
        enctype="multipart/form-data">
        <label for="file">Filename:</label>
        <input type="file" name="file" id="file">
        <label for="save">Save as:</label>
        <input style="width:100px" type="text" name="text" id="text">
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>-->
</div>
<div class="block" style="border:none">
	<table id="grid"></table>
	<div id="pager1"></div>
</div>
</body>
</html>
