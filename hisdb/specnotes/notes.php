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
$(function(){
           $("#grid").jqGrid({
				url:'test1231.php',
				datatype: "xml",
				height: 250,
				width:400,
				colNames: ['Seq No', 'Time','Name','HUKM MRN','MRN','','Doctor','Status'],
				colModel: [
					{name: 'Seq No',index: 'Seq No'},
					{name: 'Time',index: 'Time'},	
					{name: 'Name',index: 'Name'},
					{name: 'HUKM MRN',index: 'HUKM MRN'},	
					{name: 'MRN',index: 'MRN'},
					{name: '',index: ''},	
					{name: 'Doctor',index: 'Doctor'},
					{name: 'Status',index: 'Status'},	
							
					
				],
				altRows: true,
				altclass: 'zebrabiru',
				multiselect: true,
				autowidth: true,
				rowNum:10,
				rowList:[10,20,30],
				pager: jQuery('#pager'),
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
				//caption: "Patient List",
			});
			
			$("#grid1").jqGrid({
				url:'test1231.php',
				datatype: "xml",
				height: 250,
				width:400,
				colNames: ['Medical', 'Antinatal'],
				colModel: [
					{name: 'Medical',index: 'Medical'},
					{name: 'Antinatal',index: 'Antinatal'},	
										
				],
				altRows: true,
				altclass: 'zebrabiru',
				multiselect: true,
				autowidth: true,
				rowNum:10,
				rowList:[10,20,30],
				pager: jQuery('#pager'),
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
				//caption: "Patient List",
			});
});
</script>
</head>
<body>
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Notes</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Complaint" class="orgbut" >
      <input type="button" value="ICD-10" class="orgbut">    
    </div>
<div class="alongdiv"></div> 
<div class="bodydiv">
<table width="100%">
<tr>
    <td width="50%"><table id="grid"></table>
      <div id="pager"></div>   </td>
    <td>
    <table width="100%">
    <tr>
        <th>Patient Biodata</th>
    </tr>
    <tr>
       <td><textarea cols="70" rows="10"></textarea></td>
    </tr>
    <tr>
       <td><div id="menu" >
      <input type="button" value="Note" class="orgbut" >
      <input type="button" value="Call" class="orgbut">    
      <input type="button" value="Cancel" class="orgbut">   
      <input type="button" value="Save" class="orgbut">   
    </div></td>
    </tr>
    </table>
    </td>
</tr>
</table>
<br>
<div id="menu" >
      <input type="button" value="Laboratory" class="orgbut" >
      <input type="button" value="Radiology" class="orgbut">    
      <input type="button" value="Physioterapy" class="orgbut">   
      <input type="button" value="Pharmacy" class="orgbut">   
      <input type="button" value="Clinic" class="orgbut">
      <input type="button" value="Audiology" class="orgbut">  
      <input type="button" value="Radioterapy" class="orgbut">
       <input type="button" value="Respiratory" class="orgbut">
        <input type="button" value="Disposable" class="orgbut">
         <input type="button" value="Consultant Fees" class="orgbut">
          <input type="button" value="Referral" class="orgbut">
           <input type="button" value="Nuclear" class="orgbut">
    </div>
 
<table width="100%">
<tr>
    <td width="50%">
        <table width="100%">
        <tr>
            <td colspan="2">Patient Complaint&nbsp;<input type="text"></td>
        </tr>
        <tr>
            <th width="50%">Clinical Note</th>
            <th width="50%">History</th>
        </tr>
        <tr>
            <td>History Of Presenting Complaint</td>
            <td rowspan="6" valign="top"><textarea cols="40" rows="10"></textarea></td>
        </tr>
        <tr>
            <td><textarea cols="40" rows="5"></textarea></td>
            </tr>
        <tr>
           <th>Diagnosis</th>
           </tr>
        <tr>
           <td><input type="text"><input type="button" value="..."></td>
           </tr>
        <tr>
           <th>Plan</th>
           </tr>
        <tr>
           <td><textarea cols="40" rows="5"></textarea></td>
        </tr>
        <tr>
           <td colspan="2">Follow up&nbsp;<input type="text"></td>
        </tr>
        </table>
    </td>
    <td valign="top">
    <table width="100%">
    <tr>
        <th colspan="2">Physical Examination</th>
    </tr>
    <tr>
        <td><table id="grid1"></table></td>
    </tr>
    <tr>
        <th colspan="2">Others</th>
    </tr>
    <tr>
        <td><textarea cols="40" rows="5"></textarea></td>
    </tr>
    </table>
    </td>
</tr>
</table>
<br>
<table width="100%" border="1">
<tr>
    <th colspan="5">Vital Sign</th>
</tr>
<tr>
    <td>Height</td>
    <td>BP</td>
    <td>Temperature</td>
    <td>BMI</td>
    <td>Vision(R)</td>
</tr>
<tr>
    <td><input type="text">&nbsp;CM</td>
    <td><input type="text"></td>
    <td><input type="text">OC</td>
    <td><input type="text"></td>
    <td><input type="text"></td>
</tr>
<tr>
    <td>Weight</td>
    <td>Pulse Rate</td>
    <td>Respiration</td>
    <td>Color Blind</td>
    <td>Vision(L)</td>
</tr>
<tr>
    <td><input type="text">&nbsp;Kg</td>
    <td><input type="text"></td>
    <td><input type="text">OC</td>
    <td><select></select></td>
    <td><input type="text"></td>
</tr>
</table>
 <div id="menu" >
      <input type="button" value="Human Body" class="orgbut" >
      <input type="button" value="Hand Written" class="orgbut">  
      <input type="button" value="Past/Current Visit" class="orgbut"> 
      <input type="button" value="Referal Letter" class="orgbut">   
      <input type="button" value="MC Letter" class="orgbut"> 
      <input type="button" value="MC History" class="orgbut"> 
    </div>
</div>

</form>
</body>