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
		</script>
<script>
$(function(){
    
	$("#grid2").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 150,
			width:500,
			colNames: ['Seq. No.', 'ICD Code', 'Description'],
			colModel: [
				{name: 'Seq. No.',index: 'Seq. No.'},
				{name: 'ICD Code',index: 'ICD Code'},
				{name: 'Description',index: 'Description'},
					
				
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
				jQuery("#grid2").jqGrid('resetSelection');
				var ret=$("#grid2").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			//caption: "Episode",
		});
	

	$("#grid1").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 350,
			width:500,
			colNames: ['Bill Date', 'Bill No', 'Payer', 'Doctor Charges', 'Total Amount'],
			colModel: [
				{name: 'Bill Date',index: 'Bill Date', width: 30},
				{name: 'Bill No',index: 'Bill No'},
				{name: 'Payer',index: 'Payer'},
				{name: 'Doctor Charges',index: 'Doctor Charges'},
				{name: 'Total Amount',index: 'Total Amount'},				
				
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
				jQuery("#grid1").jqGrid('resetSelection');
				var ret=$("#grid1").jqGrid('getRowData',rowid);
				updmrn=ret.MRN;
				loadinfo(ret.MRN,ret.Name,ret.Newic,ret.Sex,ret.DOB,ret.Handphone,ret.add1,ret.add2,ret.add3,ret.offadd1,ret.offadd2,ret.offadd3,ret.telh,ret.telo);
				$('#viewbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "Episode",
		});
	
	$("#grid").jqGrid({
			url:'test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'Name', 'New ic', 'Old ic', 'Birth Date', 'Age(Yrs)'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'Old ic',index: 'oldic'},
				{name: 'DOB',index: 'DOB'},
				{name: 'AGE',index: 'AGE'},
				
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
			caption: "Patient List",
		});
});
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
        <span id="pagetitle">ICD Entry</span>
<div id="formmenu">
        <div id="menu" >
        <input type="button" value="MMA" class="orgbut">
        <input type="button" value="Save" class="orgbut">
        <input type="button" value="Cancel" class="orgbut">
        <input type="button" value="Print" class="orgbut">
        </div>
        <div id="searchdiv">
        <div class="alongdiv">
        	<div class="smalltitle"><p>Search ICD</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><select id="searchField">
                        <option value="Mm">Name (Word)</option>                       
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    </table>
          	 </div>
             </div>
        </div>
   <div class="alongdiv">
   <table id="grid"></table>
   <div id="pager"></div>
   <div class="alongdiv">
   <table width="100%">
   <tr>
       <td width="60%">
           <table id="grid1"></table>
           <div id="pager1"></div>
       </td>
       <td> <br>    
           <ul class='tabs'>
               <li><a href='#tab1'>Diagnosis</a></li>
               <li><a href='#tab2'>Procedure</a></li>
               <li><a href='#tab3'>External Course</a></li>
               <li><a href='#tab4'>Underlying Course</a></li>
           </ul>
           <div id='tab1'>
               <div class="alongdiv"></div>
               <input type="button" value="Delete" class="orgbut">
               <input type="button" value="Add ICD-10" class="orgbut">
               <input type="button" value="Edit Sequence" class="orgbut">
               <div class="alongdiv"></div>
           </div>
           <div id='tab2'>
               <div class="alongdiv"></div>
               <input type="button" value="Delete" class="orgbut">
               <input type="button" value="Add Procedure" class="orgbut">
               <input type="button" value="Edit Sequence" class="orgbut">
               <div class="alongdiv"></div>
           </div>
           <div id='tab3'>
                <div class="alongdiv"></div>
               <input type="button" value="Delete" class="orgbut">
               <input type="button" value="ICD-10" class="orgbut">
               <input type="button" value="Edit Sequence" class="orgbut">
               <div class="alongdiv"></div>
           </div>
           <div id='tab4'>
               <div class="alongdiv"></div>
               <input type="button" value="Delete" class="orgbut">
               <input type="button" value="ICD-10" class="orgbut">
               <input type="button" value="Edit Sequence" class="orgbut">
               <div class="alongdiv"></div>
           </div>
           <div class="alongdiv"></div>
           <table id="grid2"></table>
           <div id="pager2"></div>
           <div class="alongdiv"></div>
           <textarea cols="60" rows="10"></textarea>
       </td>
   </tr>
   </table>
  
   </div>
</div>
</body>