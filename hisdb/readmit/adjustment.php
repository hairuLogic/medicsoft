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
</head>
<body>
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Adjustment</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Cancel Episode" class="orgbut" >
      <input type="button" value="Cancel Discharge" class="orgbut">   
      <input type="button" value="Cancel" class="orgbut">
      <input type="button" value="Save" class="orgbut"> 
      <input type="button" value="Exit" class="orgbut">     
    </div>
  
<div class="alongdiv"> 
<div class="bodydiv">
<table width="60%">
<tr>
    <td width="23%">Episode No</td>
    <td width="77%">&nbsp;</td>   
</tr>
<tr>
    <td width="23%"><input type="text"></td>
    <td width="77%">&nbsp;</td>   
</tr>
<tr>
    <td width="23%">Type</td>
    <td width="77%">&nbsp;</td>   
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
</tr>
<tr>
  <td>Bed Type</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
</tr>
<tr>
  <td>Bed</td>
  <td>Room</td>
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
</tr>
</table>
</div>
<div class="alongdiv"> 
<div class="bodydiv">
<table width="60%">
<tr>
    <td width="26%">Reg.Date</td>
    <td width="59%">Register By</td>  
    <td width="15%">Time</td> 
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
  <td><input type="text"></td>
</tr>
<tr>
  <td>Discharge Date</td>
  <td>Discharge By</td>
  <td>Time</td>
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
  <td><input type="text"></td>
</tr>
<tr>
  <td>Destination</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="text"></td>
  <td><input type="text"></td>
  <td>&nbsp;</td>
</tr>
</table>
</div>
</div>  
</form>