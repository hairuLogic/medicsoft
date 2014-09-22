<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Master</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../style.css">
<script src="../script/jquery-1.8.3.js"></script>
<script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script type="">
$(function (){
    var id;
    $("#tableList").jqGrid({
        url:'tableList/productList.php',
        datatype: "xml",
        colNames:['Item Code','Item Description', 'UOM','Group Code','Product Category'],
        colModel:[
           {name:'Item Code',index:'Item Code', width:80},
           {name:'Item Description',index:'Item Description', width:400},
           {name:'UOM',index:'UOM', width:60},
           {name:'Group Code',index:'Group Code', width:90},        
           {name:'Product Category',index:'Product Category', width:90}      
        ],
        rowNum:100,
        autowidth: true,
        pager: jQuery('#tablePager'),
        viewrecords: true,
        sortorder: "desc",
        height: "300",
        caption: "Product List",
        beforeSelectRow: function(rowid, e){
                id=rowid;
                return(true);
            }
    });

    $('#but_add').click(function(){
        window.open('../mms/product_master_form.php');
    });
    $('#but_edit').click(function(){
        window.open('../mms/product_master_form1.php?rowid='+id);
    });
});    
</script>
</head>

<body>
<table align="center" width="85%">
  <tr>
    <td width="100%" id="menu">
    <?php
		include('../nav/nav_selectItem.php');
	?>
    </td>
  </tr>
  <tr>
    <td height="300">
        <div>
            <table id="tableList"> </table>    
            <div id="tablePager"></div>
        </div>
        
        <div class="alongdiv">
            <div class="smalltitle"><p>Search</p></div>
            <div class="bodydiv">
                    <table>
                    <tr>
                        <td><label>Search by: </label><select id="searchField">
                        <option value="itemcode">itemcode</option>
                        <option selected value="description">description</option>
                        </select></td>
                        <td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="search" class="orgbut"/></td>
                    </tr>
                    </table>
              </div>
         </div>
    </td>
  </tr>
</table>
	
</body>
</html>