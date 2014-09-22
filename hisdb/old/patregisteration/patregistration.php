<?php
	include_once('sschecker.php');
	include_once('connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Demographic</title>
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<link href="formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script>
	$(function(){
		var updmrn,timeoutHnd,boldthesearch=false,servername='http://192.168.0.142/';
		$('#pageinfoin').hide();
		$('#pageinfotog').click(function(){
			$('#pageinfoin').slideToggle('fast');
		});
		/*$('#tablecss tr:not(:has(th))').click(function(){//tr:has(td)
			if(currenttr!=null){currenttr.removeClass('select');}
			currenttr=$(this);
			updmrn=$(this).attr('name');
			$(this).addClass('select');
			$('#delmrntext').val(updmrn);
			$('#updbut').attr('disabled',false);
			$('#updbut').text('Update MRN: '+updmrn);
			$('#delbut').attr('disabled',false);
			$('#delbut').text('Delete MRN: '+updmrn);
			
		});*/
		$('#refbut').click(function(){
			$('#grid').trigger("reloadGrid");
		});
		$('#updbut').click(function(){
			window.open(servername+'hisdb/registerpat.php?det=upd&mrn='+updmrn);
		});
		$('#addbut').click(function(){
			window.open(servername+'hisdb/registerpat.php?det=rgd&mrn=');
		});
		$("#grid").jqGrid({
			url:servername+'hisdb/test1231.php',
			datatype: "xml",
			height: 250,
			width:500,
			colNames: ['MRN', 'Name', 'Newic', 'Oldic', 'Birth Date', 'Sex', 'Card ID'],
			colModel: [
				{name: 'MRN',index: 'MRN', width: 30},
				{name: 'Name',index: 'Name'},
				{name: 'Newic',index: 'Newic'},
				{name: 'Oldic',index: 'Oldic'},
				{name: 'Birth Date',index: 'Birth Date'},
				{name: 'Sex',index: 'Sex', width: 30},
				{name: 'Card ID',index: 'Card ID'},
			],
			altRows: true,
			altclass: 'zebrabiru',
			multiselect: true,
			autowidth: true,
			rowNum:10,
			rowList:[10,20,30],
			pager: jQuery('#pager1'),
			viewrecords: true,
			/*afterInsertRow : function(rowid, rowdata){
				
			},*/
			beforeSelectRow: function(rowid, e){
				jQuery("#grid").jqGrid('resetSelection');
				updmrn=rowid;
				$('#updbut').attr('disabled',false);
				$('#delbut').attr('disabled',false);
				return(true);
			},
			caption: "Patient List",
		});
		function gosearch(opr){
			var searchField=$('#searchField').val();
			var searchString=$('#searchString').val();;
			var searchOper=opr;
			$("#grid").jqGrid('setGridParam',{url:servername+"hisdb/test1231.php?limit=10&searchField="+searchField+"&searchString="+searchString+"&searchOper="+searchOper}).trigger("reloadGrid");
		}
		$('#search').click(function(){
			gosearch('eq');
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
				gosearch('eq');
			}else{
				delay(function(){
					boldthesearch=true;
      				gosearch('lk');
    			}, 500 );
			}
		});
	
	});
</script>
<style>
</style>
</head>

<body>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> Company: <?php echo $_SESSION['companyName'];?><a href="logout.php">  Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
	<div id="formmenu">
    	<div id="menu">
        <span id="pagetitle">Patient Demographic</span>
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="submit" disabled='true' id="delbut" form='del'></button>
            <button type="button" disabled='true' id="updbut"></button>
            <button type="button" id="addbut"></button>
            <button type="button" id="refbut"></button>
        </div>
        
        <div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
        <div class="alongdiv">
        	<div class="smalltitle"><p>Search Patient</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option value="MRN">MRN</option>
                        <option selected value="Name">Name</option>
                        <option value="Newic">New IC</option>
                        <option value="Oldic">Old IC</option>
                        <option value="DOB">Birth Date</option>
                        <option value="Sex">Sex</option>
                        <option value="Idnumber">Card ID</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="search" class="orgbut"/></td>
                    </tr>
                    </table>
          	</div>
         </div>
	</div>
</body>
</html>

