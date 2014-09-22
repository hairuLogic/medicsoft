<?php
    include_once('../sschecker.php');

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AR Inquiry</title> 
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
        <style>
		td{
			padding:2px;
		}
		</style>
        <script>
			$(function(){
				$("#tableInquiry").jqGrid({
                    url:'tableList/arinquiry.php',
                    datatype: "xml",
                    colModel:[
                        {label:'MemberNo',name: 'MemberNo',index: 'MemberNo', width: 70},
                        {label:'Name',name: 'Name',index: 'Name', width: 300},
                        {label:'Newic',name: 'Newic',index: 'Newic', width: 100},
                        {label:'Handphone',name: 'Handphone',index: 'telhp', width: 100},
                        {label:'DOB',name: 'DOB',index: 'DOB', width: 50},
                        {label:'Sex',name: 'Sex',index: 'Sex', width: 30},
                        {label:'Category',name: 'Category',index: 'Category', width: 100},
                        {label:'Term',name: 'add1',index: 'add1',hidden:true},
                        {label:'Term',name: 'add2',index: 'add1',hidden:true},
                        {label:'Term',name: 'add3',index: 'add1',hidden:true},
                        {label:'Term',name: 'offadd1',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd2',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'offadd3',index: 'offadd1',hidden:true},
                        {label:'Term',name: 'telh',index: 'telh',hidden:true},
                        {label:'Term',name: 'telo',index: 'telo',hidden:true},
                        {label:'Term',name: 'mrn',index: 'mrn',hidden:true},
						{label:'Term',name: 'pkgcode',index: 'pkgcode',hidden:true}
                    ],
                    viewrecords: true,
                    height: "250",
                    autowidth: true,
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerInquiry'),
                    beforeSelectRow : function(rowid, e){
                        return(true);            
                    }
                });	
			});
		</script>
	</head>

<body>
	<span id="pagetitle">AR Inquiry</span>
	<?php include("../include/headerf.php")?>
    <?php include("../include/start.php")?>
    	<div class="maindiv">
            <div class="alongdiv" style="margin-top:5%">
                <div class="smalltitle" style="position:relative">
  
                    <span id="micon" class="minimize" style="display:none"></span>
                </div>
                <div class="bodydiv">
                    <table>
                        <tr>
                            <td>
                                <label>Search by: </label><select id="searchField">
                                    <option selected value="Name">Name</option>
                                    <option value="MRN">MRN</option>
                                    <option value="IdNo">NRIC/Passport</option>
                                </select>
                            </td>
                            <td><input type="text" id="searchString" size="35"/></td>
                            <td>
                                <button id="but_search" class="button" title="Search" >
                                    <i id="searchIcon" class="iconButton"></i>Search
                                </button> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="alongdiv">
                <table id="tableInquiry"> </table>    
                <div id="tablePagerInquiry"></div>
            </div>
        </div>
</body>
</html>