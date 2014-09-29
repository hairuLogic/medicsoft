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
function openreport(rptno){
	
	if(rptno == 1){
	   url = "det_cha_by_pat_in_wd.php";
	   title = "Details Charged By Patient In Wards";
	}else if(rptno == 2){
	    url = "pat_disch_report.php";
	   title = "Patient Discharge Report";
    }else if(rptno == 3){
		url = "rev_analyst_by_dept.php";	
		title = "Revenue Analysis By Department";
	}else if(rptno == 4){
		url = "bed_occupancy_report.php";
		title = "Bed Occupancy Report";
	}else if(rptno == 5){
		url = "sum_rev_analyst_by_dept.php";
		title = "Summary Revenue Analysis By Department";
	}else if(rptno == 6){
		url = "deposit_reminder.php";
		title = "Deposit Reminder";
	}else if(rptno == 7){
		url = "charges_analysis_statistic.php";
		title = "Charges Analysis (Statistic)";
	}else if(rptno == 8){
		url = "inpatient_reg_ministry_report.php";
		title = "In Patient Registration Ministry Report";
	}else if(rptno == 9){
		url = "disp_charge_sum.php";
		title = "Disposable Charges Summary";		
	}else if(rptno == 10){
		url = "physio_report.php";
		title = "Physioterapy Report";
	}else if(rptno == 11){
		url = "disp_charge_sum_by_doc.php";
		title = "Disposable Charges Summary By Doctor";	
	}else if(rptno == 12){
		url = "daily_bed_cansus.php";
		title = "Daily Bed Cansus";	
	}else if(rptno == 13){
		url = "outpatient_reg.php";
		title = "Outpatient Registration";	
    }else if(rptno == 14){
		url = "daily_bed_list_by_ward.php";
		title = "Daily Bed Listing By Ward Selection";	
	}else if(rptno == 15){
		url = "inpatient_reg.php";
		title = "Inpatient Registration";
	}else if(rptno == 16){
		url = "daily_revenue.php";
		title = "Daily Revenue";	
	}
	var myWindow = window.open(url,null,"width=400,height=400,titlebar=no,addressbar=0,resizable=no");
	
}
</script>
</head>
<body>
<?php include("../../include/header.php")?>
<span id="pagetitle">Daily Report</span>
<div id="formmenu">
<div class="smalltitle" align="center"><p>List OF Reports</p></div>
<div class="alongdiv"> 
<div class="bodydiv">
<form>
<table width="100%">
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(1)">&nbsp;Details Charged By Patient In Wards</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(2)">&nbsp;Patient Discharge Report</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(3)">&nbsp;Revenue Analysis By Department</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(4)">&nbsp;Bed Occupancy Report</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(5)">&nbsp;Summary Revenue Analysis By Department</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(6)">&nbsp;Deposit Reminder</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(7)">&nbsp;Charges Analysis (Statistic)</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(8)">&nbsp;Inpatient Admission Ministry Report</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(9)">&nbsp;Disposable Charges Summary</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(10)">&nbsp;Physiotherapy Report</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(11)">&nbsp;Charge Summary By Doctor</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(12)">&nbsp;Daily Bed Cencus</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(13)">&nbsp;Outpatient Registration</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(14)">&nbsp;Daily Bed Listing By Wards</td>
</tr>
<tr>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(15)">&nbsp;Inpatient Registration</td>
    <td><input type="button" value="&#10140;" class="orgbut" onclick="openreport(16)">&nbsp;Daily Revenue</td>
</tr>
</table>
</form>
</div>
</div>