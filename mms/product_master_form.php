<?php
    //include_once('sschecker.php');
    //include_once('connect_db.php');
    $valid=false;
    if(isset($_GET['mrn'])){
        $valid=true;
        $updmrn=$_GET['mrn'];
        $sql="select * from patmast where MRN='$updmrn'";
        $res=mysql_query($sql);
        if (!$res) {
            die('Invalid query: '. mysql_error());
        }
        $row=mysql_fetch_assoc($res);
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
        <style>
            .test{    margin-left:1%;
            allign:top;
            border: thin solid grey;
    margin-bottom:1%;}
        </style>
    </head>

    <body>
        <table align="center" width="85%"height="509">
        <tr>
            <td width="100%" id="menu">
                 <?php
                    include('../nav/nav_form.php');
                ?>
            </td>
        </tr>

        <tr>
            <td>
                <form name="formProductMaster" method="post" action="">
                <div class="alongdiv">
                    <div class="smalltitle"></div>
                    <div class="bodydiv">
                        <table width="100%" border="0" >
                            <tr>
                                <td width="112"><label for="itemCode">Item Code :</label></td>
                                <td width="161">
                                    <input type="text" name="itemCode" id="itemCode"></td>
                                <td width="117"><label for="description">Description :</label></td>
                                <td colspan="3">
                                    <input name="description" type="text" id="description" size="80"></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td><label for="generic">Generic Name :</label></td>
                                <td colspan="3"><input name="generic" type="text" id="generic" size="80"></td>
                            </tr>
                            <tr>
                                <td><label for="groupcode2">Group Code :</label></td>
                                <td><select name="groupcode" id="groupcode2">
                                </select></td>
                                <td><label for="productcat">Category :</label></td>
                                <td width="163"><input type="text" name="productcat" id="productcat"></td>
                                <td width="111"><label for="subcatcode">Sub Category :</label></td>
                                <td width="200"><input type="text" name="subcatcode" id="subcatcode"></td>
                            </tr>
                            <tr>
                                <td><label for="uom">UOM :</label></td>
                                <td><input type="text" name="uom" id="uom"></td>
                                <td><label for="pouom">POUOM :</label></td>
                                <td><input type="text" name="pouom" id="pouom"></td>
                                <td><label for="itemtype">:Poison :</label></td>
                                <td><select name="itemtype" id="itemtype">
                                </select></td>
                            </tr>
                            <tr>
                                <td><label for="suppcode">Supplier Code :</label></td>
                                <td><input type="text" name="suppcode" id="suppcode"></td>
                                <td><label for="mstore">Main Store :</label></td>
                                <td><input type="text" name="mstore" id="mstore"></td>
                                <td><label for="costmargin">Profit Margin :</label></td>
                                <td><input type="text" name="costmargin" id="costmargin"></td>
                            </tr>
                        </table>
                    </div>
                    </div>
                    <div class="alongdiv">
                    <div class="smalltitle"></div>
                    <div class="bodydiv"><table width="100%" border="0">
                            <tr>
                                <td><label for="minqty">Min Stock Qty :</label></td>
                                <td><input type="text" name="minqty" id="minqty"></td>
                                <td><label for="maxqty">Max Stock Qty :</label></td>
                                <td><input type="text" name="maxqty" id="maxqty"></td>
                                <td><label for="units">Units :</label></td>
                                <td><input type="text" name="units" id="units"></td>
                            </tr>
                            <tr>
                                <td><label for="reordlevel">Reorder Level :</label></td>
                                <td><input type="text" name="reordlevel" id="reordlevel"></td>
                                <td><label for="reordqty">Reorder Qty :</label></td>
                                <td><input type="text" name="reordqty" id="reordqty"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div> 
                    </div>
                    <div class="alongdiv">
                    <div class="smalltitle"></div>
                    <div class="bodydiv"><table width="50%" border="0" align="center">
                            <tr>
                                <td><label for="reuse">Reuse :</label></td>
                                <td><select name="reuse" id="reuse">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                                <td><label for="rpkitem">Repack Item :</label></td>
                                <td><select name="rpkitem" id="rpkitem">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                                <td><label for="tagging">Tagging :</label></td>
                                <td><select name="tagging" id="tagging">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                            </tr>
                            <tr>
                                <td><label for="expdtflg">Expired Date :</label></td>
                                <td><select name="expdtflg" id="expdtflg">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                                <td><label for="chgflag">Charge :</label></td>
                                <td><select name="chgflag" id="chgflag">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                                <td><label for="active">Active :</label></td>
                                <td><select name="active" id="active">
                                <option value="1">Yes</option>
                        <option selected value="0">No</option>
                                </select></td>
                            </tr>
                        </table>
                    </div>
                    </div> 
                </form>
            </td>
        </tr>

        </table>


    </body>
</html>