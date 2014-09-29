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

			// Wait until the DOM has loaded before querying the document
			$(document).ready(function(){
				$('ul.tabs').each(function(){
					// For each set of tabs, we want to keep track of
					// which tab is active and it's associated content
					var $active, $content, $links = $(this).find('a');

					// If the location.hash matches one of the links, use that as the active tab.
					// If no match is found, use the first link as the initial active tab.
					$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
					$active.addClass('active');

					$content = $($active[0].hash);

					// Hide the remaining content
					$links.not($active).each(function () {
						$(this.hash).hide();
					});

					// Bind the click event handler
					$(this).on('click', 'a', function(e){
						// Make the old tab inactive.
						$active.removeClass('active');
						$content.hide();

						// Update the variables with the new link and content
						$active = $(this);
						$content = $(this.hash);

						// Make the tab active.
						$active.addClass('active');
						$content.show();

						// Prevent the anchor's default click action
						e.preventDefault();
					});
				});
			});
			
function exportxls(){
	window.open("template/statement.xls");
}
			
</script>
<style>
			* {padding:0; margin:0;}

			html {
				
				padding:15px 15px 0;
				font-family:sans-serif;
				font-size:14px;
			}

			p, h3 { 
				margin-bottom:15px;
			}

			

			.tabs li {
				list-style:none;
				display:inline;
			}

			.tabs a {
				padding:5px 10px;
				display:inline-block;
				background:#666;
				color:#fff;
				text-decoration:none;
			}

			.tabs a.active {
				background:#f7b03b;
				color:#000;
			}

		</style>
</head>
<body>
<?php include("../../include/header.php")?>
<span id="pagetitle">Statement Of Account</span>
<form>
<div id="formmenu">
<div class="smalltitle" align="center"><p>List OF Reports</p></div>
<div class="alongdiv"> 
<div id="menu" >
      <input type="button" value="Export To Excell" onclick="exportxls()" class="orgbut">
      <input type="button" value="Print" class="orgbut">
      <input type="button" value="Exit" class="orgbut">     
    </div>
    <div class="alongdiv"> 
<div class="bodydiv">

<table width="100%">
<tr>
    <td width="10%">Date</td>
    <td width="93%"><input type="text"></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="text"></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="text" size="40"></td>
</tr>
<tr>
    <td>Debtor From</td>
    <td><input type="text">
    <input type="button" value="..."></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="text" size="40"></td>
</tr>
<tr>
    <td>Debtor To:</td>
    <td><input type="text">
    <input type="button" value="..."></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="text" size="40"></td>
</tr>
</table>
</form>
</div>
<div class="alongdiv"> </div>

 <ul class='tabs'>
               <li><a href='#tab1'>Printing Option</a></li>
</ul>
<div id='tab1'>
<table>
<tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>Printing Type</td>
</tr>
<tr>
    <td>Group 1:</td>
    <td><input type="text" size="10"> Days</td>
    <td><select>
        <option>STANDARD</option>
        </select>
    </td>
</tr>
<tr>
    <td>Group 2:</td>
    <td><input type="text" size="10"> Days</td>
    <td><select>
        <option>AS AT DATE</option>
        </select>
    </td>
</tr>
<tr>
    <td>Group 3:</td>
    <td><input type="text" size="10"> Days</td>
    <td>Merge Bill</td>
</tr>
<tr>
    <td>Group 4:</td>
    <td><input type="text" size="10"> Days</td>
    <td><select>
        <option>NO</option>
        </select>
    </td>
</tr>
</table>
</div>
</div>             
  
