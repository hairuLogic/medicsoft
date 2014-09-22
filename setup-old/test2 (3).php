<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        <link rel="stylesheet" href="../css/jquery-ui-themes-1.10.3/ui-lightness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="../script/jquery-ui-1.10.1.custom.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">

        <script>
            $(function (){
                $( "#dialogForm" ).dialog({
                    autoOpen: false,
                    height: 390,
                    width: 930,
                    modal: true,
                    buttons: {
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                $( "#but_add1" ).click(function() {
                    $( "#dialogForm" ).dialog( "open" );
                });
                $( "#create-user" ).click(function() {
                    $( "#dialogForm" ).dialog( "open" );
                });
            });


        </script>
    </head>

    <body>
        <button  id="but_add1">
            <img src="../img/icon/but_add.png"/>
        </button>
        <button id="create-user">...</button>

        <div id="dialogForm" title="Create new item">
            <div id="dialogForm" title="Create new item">
            <div class="sideleft" width='100%'>
                <div class="smalltitle"></div>
                <div class="bodydiv">
                    <table  border="0">
                        <tr>
                            <td><label for="programtypeA">Add Type</label></td>
                            <td><select name="programtypeA" id="programtypeA"><option value="p">P</option><option value="m">M</option>
                                </select></td>

                            <td><label for="at_where"> At </label></td>
                            <td><select name="at_where" id="at_where">
                                    <option value="first">First</option>
                                    <option value="last">Last</option>
                                    <option value="after">After</option>
                                </select></td>
                            <td><select name="idAfter" id="idAfter" hidden="true">
                                </select></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="sideleft" width='100%'>
                <div class="smalltitle"></div>
                <div class="bodydiv">
                    <form id="formMenuMaintain" method="post" action="" >
                        <table >
                            <tr>
                                <td><label for="lineno">Line No</label></td>
                                <td><input type="text" name="lineno" id="lineno"></td>
                                <td><label for="programname">Description</label></td>
                                <td colspan="3"><input name="programname" type="text" id="programname" size="60"></td>
                            </tr>
                            <tr>
                                <td><label for="programtype">Program Type</label></td>
                                <td><select name="programtype" id="programtype"><option value="p">P</option><option value="m">M</option>
                                    </select></td>
                                <td><label for="programid">Program Id</label></td>
                                <td><input type="text" name="programid" id="programid"></td>
                                <td><label for="bmpid">Bmpid</label>
                                </td>
                                <td><input type="text" name="bmpid" id="bmpid"></td>
                            </tr>
                            <tr>
                                <td><label for="condition1">Condition1</label></td>
                                <td><input type="text" name="condition1" id="condition1"></td>
                                <td><label for="condition2">Condition 2</label></td>
                                <td><input type="text" name="condition2" id="condition2"></td>
                                <td><label for="condition3">Condition3</label>
                                </td>
                                <td><input type="text" name="condition3" id="condition3"></td>
                            </tr>
                            <tr>
                                <td><label for="remarks">Remarks</label></td>
                                <td ><input type="text" name="remarks" id="remarks"></td>
                                <td><label for="url">URL</label></td>
                                <td colspan="3"><input name="url" type="text" id="url" size="60"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div> 
        </div> 
    </body>
</html>