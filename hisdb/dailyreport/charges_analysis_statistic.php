<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Charges Analysis (Statistic)</title>
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
function openme(){
  var itm = document.frm.optitem.value;	

  if(itm == '2'){
  window.open("template/stockanalysis.xls");
  }else{
   window.open("template/chargeanalysis.xls");
  }
}

</script>
</head>
<body>
<form name="frm">
<div id="formmenu">
<div class="smalltitle"><p>Item Movement</p></div>
      <div class="alongdiv">
      <div id="menu">
      <input type="button" value="Export To Excel" class="orgbut" onclick="openme()">
      <input type="button" value="Print" class="orgbut">
      <input type="button" value="Exit" class="orgbut">
      </div>
      <div class="alongdiv">
      <div class="bodydiv">
      <table align="center">
      <tr>
         <Td colspan="3"><select name="optitem">
             <option value='1'>Charge Analysis</option>
             <option value='2'>Stock Analysis</option>
             </select>
         </Td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>Date From</td>
         <td>To</td>
      </tr>
      <tr>
          <td><select name="select">
            <option>Bill date</option>           
          </select></td>
          <td><input type="text" size="10"></td>
          <td><input type="text" size="10"></td>         
        </tr>
      <tr>
          <td>Item From</td>
          <td>Item To</td>
          <td>&nbsp;</td>          
        </tr>
      <tr>
        <td><input type="text" size="10"></td>
        <td><input type="text" size="10"></td>
        <td>&nbsp;</td>        
        </tr>
      <tr>
        <td>Dept From</td>
        <td>Dept To</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="text" size="10"></td>
        <td><input type="text" size="10"></td>
        <td>&nbsp;</td>
      </tr>
      </table>
      </div>
</div>
</form>
</body>
</html>