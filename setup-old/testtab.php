<?php
    include_once('../sschecker.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/sunny/jquery-ui.css" />      
        <link rel="stylesheet" type="text/css" media="screen" href="../jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">  
        <link rel="stylesheet" type="text/css" media="screen" href="../style_main.css">    
        <script src="../script/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
        <script src="../jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script> 
        <script>
            $(function(){
                $( "#tabs" ).tabs();//set height for tab
                $("#tablePackageEffect").jqGrid({
                    datatype: "local",
                    colModel:[					
                        {label:'Effective Date',name:'pkgEffDate',index:'pkgEffDate',width:100},
                        {label:'Description',name:'description',index:'description',width:350},
                        {label:'Price',name:'price',index:'price',width:100}
                    ],
                    viewrecords: true,
                    height: "150",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageEffect'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageEffect").jqGrid('getRowData',rowid);
                        return(true);            
                    }
                });	
                $("#tablePackageBenefit").jqGrid({
                    datatype: "local",
                    colModel:[
                        {label:'Effective Date',name:'detEffDate',index:'detEffDate',width:100},					
                        {label:'Description',name:'description',index:'description',width:200},
                        {label:'Remark',name:'remark',index:'remark',width:300},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "150",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageBenefit'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageDetail").jqGrid('getRowData',rowid);
                        return(true);            
                    }
                });		
				
                $("#tablePackageDetail").jqGrid({
                    datatype: "local",
                    colModel:[
                        {label:'Effective Date',name:'detEffDate',index:'detEffDate',width:100},					
                        {label:'Description',name:'description',index:'description',width:200},
                        {label:'Remark',name:'remark',index:'remark',width:300},
                        {label:'Frequency',name:'freqqty',index:'freqqty',width:90},	
                        {label:'Interval Year',name:'intervl',index:'intervl',width:90}, 
                        {label:'Max Quantity',name:'maxqty',index:'maxqty',width:90}
                    ],
                    viewrecords: true,
                    height: "150",
                    hidegrid: false,
                    rowNum:10,
                    rowList:[10,20,30],
                    pager: jQuery('#tablePagerPackageDetail'),
                    onSelectRow : function(rowid, e){
                        var ret=$("#tablePackageDetail").jqGrid('getRowData',rowid);
                        return(true);            
                    }
                });						
            });
        </script>
    </head>

    <body>
        <span id="pagetitle">Package Maintenance</span>
        <?php include("../include/headerf.php")?>
        <?php include("../include/start.php")?>
        <div class="content-header-new">
            <div class="header-inner-new">
                <h2 id="content-main-heading" class="title1"></h2>
                <div class="rfloat specfloat">   
                    <i class="topbar-divider"></i>
                    <button id="but_list" class="button" title="Package Header" >
                        <i id="listIcon" class="iconButton"></i>
                        <p>Package</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="placeholder"><p id="pkgname"></p><span id="micon" class="maximize"></span></div>
        <div class="secondDiv">
            <div class="content-header-new">
                <div class="header-inner-new">
                    <h2 id="content-main-heading" class="title1">Package Effective Date</h2>
                    <div class="rfloat specfloat">   
                        <i class="topbar-divider"></i>
                        <button id="but_add_effect" class="button" title="Add">
                            <i id="addIcon" class="iconButton"></i>
                            <p>Add</p>
                        </button>
                        <i class="topbar-divider"></i>
                        <button id="but_edit_effect" class="button" title="Edit" disabled="true">
                            <i id="editIcon" class="iconButton"></i>
                            <p>Edit</p>
                        </button>            
                    </div>
                </div>
            </div>
            <div style="clear: both; margin-bottom: 15px;">
                <div class="content-body" >
                    <div class="body-inner">
                        <div id="tdTree" >
                            <div style="clear: both;">
                                <table id="tablePackageEffect"> </table> 
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
            <div style="clear: both; margin-bottom: 15px;">
                <div id="tabs" class="tabs" style="background: #ECECEC;">
                    <ul>
                        <li><a href="#tabs-1">Package Detail</a></li>
                        <li><a href="#tabs-2">Package Benefit</a></li>
                    </ul>
                    <div id="tabs-1" >
                        <div class="content-header-new">
                            <div class="header-inner-new">
                                <div class="rfloat specfloat">   
                                    <i class="topbar-divider"></i>
                                    <button id="but_add_detail" class="button" title="Add">
                                        <i id="addIcon" class="iconButton"></i>
                                        <p>Add</p>
                                    </button>
                                    <i class="topbar-divider"></i>
                                    <button id="but_edit_detail" class="button" title="Edit" disabled="true">
                                        <i id="editIcon" class="iconButton"></i>
                                        <p>Edit</p>
                                    </button>            
                                </div>
                            </div>
                        </div>
                        <div style="clear: both; margin-bottom: 15px;">
                            <div class="content-body" >
                                <div class="body-inner">
                                    <div id="tdTree" >
                                        <div style="clear: both;">
                                            <table id="tablePackageDetail"> </table>    
                                            <div id="tablePagerPackageDetail"></div>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tabs-2">   
                        <div class="content-header-new">
                            <div class="header-inner-new">
                                <div class="rfloat specfloat">   
                                    <i class="topbar-divider"></i>
                                    <button id="but_add_detail" class="button" title="Add">
                                        <i id="addIcon" class="iconButton"></i>
                                        <p>Add</p>
                                    </button>
                                    <i class="topbar-divider"></i>
                                    <button id="but_edit_detail" class="button" title="Edit" disabled="true">
                                        <i id="editIcon" class="iconButton"></i>
                                        <p>Edit</p>
                                    </button>            
                                </div>
                            </div>
                        </div>
                        <div style="clear: both; margin-bottom: 15px;">
                            <div class="content-body" >
                                <div class="body-inner">
                                    <div id="tdTree" >
                                        <div style="clear: both;">
                                            <table id="tablePackageBenefit"> </table>    
                                            <div id="tablePagerPackageBenefit"></div>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>                            
                    </div>                          
                </div>
            </div>
        </div> 
    </body>
</html>