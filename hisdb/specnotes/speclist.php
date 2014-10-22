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
function opennotes(id){
var uri = "notes.php";
    uri += "?doc=" + id; 
document.forms[0].action = uri;
document.forms[0].method = "post";
document.forms[0].submit();
}

function Link(id) {

    var row = id.split("=");
    var row_ID = row[1];
	var doccode= $("#grid").getCell(row_ID, 'Doctor_Code');
	var uri = "notes.php?id=" + doccode;
    document.forms[0].action = uri;
    document.forms[0].method = "post";
    document.forms[0].submit();
}

					
$(function(){
           $("#grid").jqGrid({
				url:'data/doctorlist.php',
				datatype: "xml",
				height: 250,
				colNames: ['Doctor Code', 'Doctor Name'],
				colModel: [{ name: 'Doctor_Code', index: 'Doctor_Code',
				             width: 100,
							 editable: false,
							 sortable: false,
							 formatter: 'showlink',
							 formatoptions: { baseLinkUrl: 'javascript:', showAction: "Link('", addParam: "');"} },
                           { name: 'Doctor_Name', index: 'Doctor_Name', 
						     width: 400, 
							 editable: false,
							 sortable: false }],
				altRows: true,
				altclass: 'zebrabiru',
				multiselect: false,
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
<style>
#tblinfo{
	border-radius: 10px 10px 5px 5px;
	padding:1px;
	margin:1% auto;
	width:98%;
	border:thin solid #4D7094;
	color:#333333;
	
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
<body>
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Specialist Notes</span>
<div id="formmenu">
     <div class="alongdiv">  
    <div class="bodydiv">
        <table>
        <tr>
          	<td><select id="searchField">
                <option value="Mm">Description</option>                       
                </select></td>
          	<td><input type="text" id="searchString"/></td>
            <td><input type="button" id="search" value="Search" class="orgbut"/></td>
        </tr>
        </table>
    </div>
    <div class="bodydiv">
      <div class="alongdiv">  
      <table id="grid"></table>
      <div id="pager"></div>      
    </div>
</div>
</form>
</body>