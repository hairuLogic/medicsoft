<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Revenue Analysis By Department</title>
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

<div id="formmenu">
<div class="smalltitle"><p>Department Charges</p></div>
      <div class="alongdiv">
      <div id="menu">
      <input type="button" value="Print" class="orgbut">
      <input type="button" value="Exit" class="orgbut">
      </div>
      <div class="alongdiv">
      <div class="bodydiv">
      <table align="center">
      <tr>
          <td>Dept From</td>
          <td>Dept To</td>
        </tr>
      <tr>
          <td><input type="text" size="10"></td>
          <td><input type="text" size="10"></td>
        </tr>
      <tr>
        <td>Date From</td>
        <td>Date To</td>
        </tr>
      <tr>
        <td><input type="text" size="10"></td>
        <td><input type="text" size="10"></td>
        </tr>
      <tr>
        <td>Item FRom</td>
        <td>Item To</td>
        </tr>
      <tr>
        <td><input type="text" size="10"></td>
        <td><input type="text" size="10"></td>
        </tr>
      </table>
      </div>
</div>
</body>
</html>