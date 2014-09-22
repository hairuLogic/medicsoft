<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Product Master</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../style.css">
        <script src="../script/jquery-1.8.3.js"></script>
        <script type="">

            var Lst;
            var id;
            var opStatus;

            $(document).ready(function() {

                //Class 'contentContainer' refers to 'li' that has child with it.
                //By default the child ul of 'contentContainer' will be set to 'display:none'

                $("#treeMenu li").toggle(

                    function() { // START FIRST CLICK FUNCTION
                        if ($(this).hasClass('contentContainer')) {
                            $(this).children('ul').slideDown()
                            $(this).removeClass('contentContainer').addClass('contentViewing');
                        }
                        if (($(this).hasClass('contentContainerMain') || $(this).hasClass('contentViewingMain'))&& $('.contentViewingMain').text() != $(this).text()) {                                        
                            $('.contentViewingMain').children('ul').slideUp()
                            $('.contentViewingMain').removeClass().addClass('contentContainerMain');
                        }                      

                        if ($(this).hasClass('contentContainerMain')) {
                            $(this).children('ul').slideDown()
                            $(this).removeClass('contentContainerMain').addClass('contentViewingMain');
                        }
                        else if ($(this).hasClass('contentViewingMain')) {
                            $(this).children('ul').slideUp()
                            $(this).removeClass('contentViewingMain').addClass('contentContainerMain');
                        }

                    }, // END FIRST CLICK FUNCTION

                    function() { // START SECOND CLICK FUNCTION
                        if (($(this).hasClass('contentContainerMain') || $(this).hasClass('contentViewingMain')) && $('.contentViewingMain').text() != $(this).text()) {                                        
                            $('.contentViewingMain').children('ul').slideUp()
                            $('.contentViewingMain').removeClass().addClass('contentContainerMain');
                        }                  
                        if ($(this).hasClass('contentViewing')) {
                            $(this).children('ul').slideUp()
                            $(this).removeClass('contentViewing').addClass('contentContainer');
                        }
                        if ($(this).hasClass('contentContainerMain')) {
                            $(this).children('ul').slideDown()
                            $(this).removeClass('contentContainerMain').addClass('contentViewingMain');
                        }
                        else if ($(this).hasClass('contentViewingMain')) {
                            $(this).children('ul').slideUp()
                            $(this).removeClass('contentViewingMain').addClass('contentContainerMain');
                        }

                    } // END SECOND CLICK FUNCTIOn
                ); // END TOGGLE FUNCTION 

                //$('#formMenuMaintain input[type=text],select').prop('disabled',true);   

                $('#but_add').click(function(){
                    $('#formMenuMaintain input[type=text],select').prop('value',''); 
                    $('#formMenuMaintain input[type=text],select').prop('disabled',false);           
                    $('#treeMenu').hide();
                    opStatus = 'update';
                    butChangeEnable();
                });

                $('#but_edit').click(function(){
                    $('#formMenuMaintain input[type=text],select').prop('disabled',false);            
                    $('#treeMenu').hide();
                    opStatus = 'update';
                    butChangeEnable();
                });    

                $('#but_cancel').click(function(){
                    $('#formMenuMaintain input[type=text],select').prop('disabled',true);            
                    $('#treeMenu').show();
                    butSelectEnable();
                });  
            });   

            function CngClass(obj){
                if (Lst) Lst.className='';
                obj.className='Clicked';
                id = obj.id;
                parentId = obj.getAttribute("programmenu");
                Lst=obj;

                $("#lineno").val(obj.getAttribute("lineno"));
                $("#programname").val(obj.getAttribute("programname"));
                $("#programid").val(id);
                $("#programtype").val(obj.getAttribute("programtype"));
                $("#bmpid").val(obj.getAttribute("bmpid"));
                $("#condition1").val(obj.getAttribute("condition1"));
                $("#condition2").val(obj.getAttribute("condition2"));
                $("#condition3").val(obj.getAttribute("condition3"));
                $("#remarks").val(obj.getAttribute("remarks"));
                $("#url").val(obj.getAttribute("url"));
                if(id !='main'){
                    butSelectEnable(obj);    
                }
                else{
                    $("#but_add").prop("disabled",false);
                    $("#but_edit").prop("disabled",true);
                    $("#but_delete").prop("disabled",true);
                    $("#but_save").prop("disabled",true);
                    $("#but_cancel").prop("disabled",true);
                    $("#but_refresh").prop("disabled",true);
                }

            };
            function butSelectEnable(obj){
                $("#but_edit").prop("disabled",false);
                $("#but_delete").prop("disabled",false);
                $("#but_add").prop("disabled",false);
                $("#but_save").prop("disabled",true);
                $("#but_cancel").prop("disabled",true);
                $("#but_refresh").prop("disabled",true);

                if($(obj).closest('li').attr('class')=='p'){
                    $("#but_add").prop("disabled",true);
                }
                return false;
            };
            function butChangeEnable(){     
                $("#but_save").prop("disabled",false);
                $("#but_cancel").prop("disabled",false);
                $("#but_refresh").prop("disabled",false);
                $("#but_edit").prop("disabled",true);
                $("#but_delete").prop("disabled",true);
                $("#but_add").prop("disabled",true);
                return false;
            };
        </script>
        <style>
            .notClicked {background-color:transparent}
            .Clicked { background-color: lightblue}
            li div{width: 100%;}
        </style>
    </head>

    <body>
        <table align="center" width="85%">
            <tr>
                <td width="100%" id="menu" colspan="2">
                    <?php
                       //include('../nav/nav_selectMenu.php');
                    ?>
                </td>
            </tr>
            <tr>
                <td id="tdTree">
                    <div class="divTree">
                        <div class="smalltitle"><p><a onclick="CngClass(this);" id="main">Main</a></p></div>
                        <div id="treeBody" class="bodydiv">
                            <?php
                                include('../config.php');
                                $x=1;
                                $rowX = array();
                                $myQueryX = array();
                                $resultX= array();
                                $class = 'contentContainerMain';

                                $myQuery = 'SELECT * FROM programtab where compcode="aa" and programmenu ="main" order by lineno';
                                $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());

                                echo '<div id="tree" width="100%"><ul id="treeMenu">';
                                while($rowX[x] = mysql_fetch_array($result))
                                {
                                    menu($rowX[x],$x,$class);
                                }

                                function menu($rowX,$x,$class){
                                    $x = $x+1;
                                    if($rowX['programtype']=='m')
                                    {              
                                        echo '<li width="100%" class="'.$class.'"><div ="100px" onclick="CngClass(this);" class="notClicked" id="'.$rowX['programid'].'" lineno="'.$rowX['lineno'].'" programname="'.$rowX['programname'].'" programtype="'.$rowX['programtype'].'" bmpid="'.$rowX['bmpid'].'" condition1="'.$rowX['condition1'].'" condition2="'.$rowX['condition2'].'" condition3="'.$rowX['condition3'].'" remarks="'.$rowX['remarks'].'" url="'.$rowX['url'].'" programmenu="'.$rowX['programmenu'].'">'.strtoupper($rowX['programname']).'</div>' ; 
                                        $class='contentContainer';
                                        $myQueryX[x] = "SELECT * FROM programtab where compcode='aa' and programmenu ='".$rowX['programid']."' order by lineno";            
                                        $resultX[x]=mysql_query($myQueryX[x])or die($myQueryX[x]."<br/><br/>".mysql_error());

                                        echo '<ul style="display: none">';
                                        while($rowX[x] = mysql_fetch_array($resultX[x]))
                                        {
                                            menu($rowX[x],$x,$class);
                                        }

                                        echo '</ul></li>';   
                                    }
                                    else
                                    {

                                        echo '<li class="'.$rowX['programtype'].'"><div onclick="CngClass(this);" class="notClicked" id="'.$rowX['programid'].'"  lineno="'.$rowX['lineno'].'" programname="'.$rowX['programname'].'" programtype="'.$rowX['programtype'].'" bmpid="'.$rowX['bmpid'].'" condition1="'.$rowX['condition1'].'" condition2="'.$rowX['condition2'].'" condition3="'.$rowX['condition3'].'" remarks="'.$rowX['remarks'].'" url="'.$rowX['url'].'" programmenu="'.$rowX['programmenu'].'">'.$rowX["programname"].'</div></li>';
                                    }
                                    $x = $x-1;
                                    return $x;
                                }

                            ?>

                        </div>            
                    </div>

                </td>
                <td id="tdSide">
                  <div class="sideleft" width='100%'>
                        <div class="smalltitle"></div>
                        <div class="bodydiv">
                          <table  border="0">
                              <tr>
                                <td><label for="programtype">Add Type</label></td>
                                        <td><select name="programtype" id="programtype"><option value="p">P</option><option value="m">M</option>
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
                    <div class="sideright" width='100%'>
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
                                        <td colspan="3"><input name="url" type="text" id="url" size="60">                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </body>
</html>