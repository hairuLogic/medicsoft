<!doctype html>
<html lang="en">
<head>
       <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">   
        <script src="../script/jquery-1.8.3.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
    <script>
		$(function(){
			$("#chgmastList").jqGrid({
				url : 'tableList/orderChgMastTest.php',
				datatype: "xml",
				colModel:[
					{label:'Code',name:'chgcode',index:'chgcode', width:100},
					{label:'Description',name:'description',index:'description', width:270},
					{label:'Brandname',name:'brandname',index:'brandname', width:270} ,
					{label:'amt1',name:'amt1',index:'amt1'},
					{label:'amt2',name:'amt2',index:'amt2'},  						
					{label:'chgtype',name:'chgtype',index:'chgtype',hidden:true},
					{label:'chggroup',name:'chggroup',index:'chgtype',hidden:true}
				],
				rowNum:10,
				height: "300",
				caption: "Charge Master"
			});
			$("#searchString2").on('keydown',  function(e) { //search pt
					var keyCode = e.keyCode || e.which; 
					//check for tab n enter key 
					if (keyCode == 9 || keyCode == 13) { 
						e.preventDefault(); 
						//check length of character
						searchChgmast();
					} 
				});
				$("#but_search2").click(function(){//search pt
					searchChgmast();	
				});
		});
		function searchChgmast(){
			var trf = $("#tableOrder tbody:first tr:first")[0];
			$("#tableOrder tbody:first").empty().append(trf);
			$("#chgmastList").jqGrid().setGridParam({url : 'tableList/orderChgMastTest.php?searchString2='+$("#searchString2").val()+"&searchField2="+$("#searchField2").val()}).trigger("reloadGrid");
		};
    </script>
</head>
<body>
	 <div >
     	<table id="chgmastList"> </table>   
     </div>     
     <div class="bodydiv">
        <table>
            <tr>
                <td>
                	<label>Search by: </label><select id="searchField2">
                        <option selected value="word">Description/Brandname</option>
                        <option  value="chgcode">Code</option>
                    </select></td>
                <td>
                    <input type="text" id="searchString2" size="35"/>
                </td>
                <td>
                    <button id="but_search2" class="button" title="Search" >
                        <i id="searchIcon" class="iconButton"></i>Search
                    </button>
                </td>
            </tr>
        </table>
    </div> 
</body>
</html>