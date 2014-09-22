
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../../style.css">
        <script src="../../script/jquery-1.8.3.js"></script>
        <script>
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

            });   


            function CngClass(obj){
                if (Lst) Lst.className='';
                obj.className='Clicked';
                id = obj.id;
                lineno=obj.lineno;
                programtype = obj.programtype;
                parentId = obj.getAttribute("programmenu");
                parent.detailTree(obj.getAttribute("programid"),obj.getAttribute("lineno"),obj.getAttribute("programname"),obj.getAttribute("bmpid"),obj.getAttribute("condition1"),obj.getAttribute("condition2"),obj.getAttribute("condition3"),obj.getAttribute("remarks"),obj.getAttribute("url"),obj.getAttribute("programmenu"),obj.getAttribute("programtype"),obj.getAttribute("child"));
                Lst=obj;
            };

        </script>
        <style>
            .notClicked {background-color:transparent}
            .Clicked { background-color: lightblue}
            li div{width: 100%;}
        </style>
    </head>

    <body>
        <?php
            $id = $_GET['id'];
            $compcode= '9a';
            include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
            $x=1;
            $rowX = array();
            $myQueryX = array();
            $resultX= array();
            $class = 'contentContainerMain';

            $myQuery = 'SELECT * FROM programtab where compcode="'.$compcode.'" and programmenu ="'.$id.'" order by lineno';
            $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());

            echo '<div id="tree" width="100%"><ul id="treeMenu">';
            while($rowX[$x] = mysql_fetch_array($result))
            {
                menu($rowX[$x],$x,$class,$compcode);
            }

            function menu($rowX,$x,$class,$compcode){
                $x = $x+1;

                if($rowX['programtype']=='M')
                {            
                    $SQL1 = "SELECT count(programid) as child FROM programtab where programmenu='".$rowX['programid']."' and compcode='".$compcode."'";
                    $result1 = mysql_query( $SQL1 ) or die("Couldn't execute query.".mysql_error());

                    $row1 = mysql_fetch_array($result1);  
                    
                    echo '<li width="100%" class="'.$class.'"><div ="100px" onclick="CngClass(this);" class="notClicked" id="'.$rowX['programid'].'" programid="'.$rowX['programid'].'" lineno="'.$rowX['lineno'].'" programname="'.$rowX['programname'].'" programtype="'.$rowX['programtype'].'" bmpid="'.$rowX['bmpid'].'" condition1="'.$rowX['condition1'].'" condition2="'.$rowX['condition2'].'" condition3="'.$rowX['condition3'].'" remarks="'.$rowX['remarks'].'" url="'.$rowX['url'].'" programmenu="'.$rowX['programmenu'].'" child="'.$row1['child'].'">'.strtoupper($rowX['programname']).'</div>' ; 
                    $class='contentContainer';
                    $myQueryX[$x] = "SELECT * FROM programtab where compcode='".$compcode."' and programmenu ='".$rowX['programid']."' order by lineno";            
                    $resultX[$x]=mysql_query($myQueryX[$x])or die($myQueryX[$x]."<br/><br/>".mysql_error());

                    echo '<ul style="display: none">';
                    while($rowX[$x] = mysql_fetch_array($resultX[$x]))
                    {
                        menu($rowX[$x],$x,$class,$compcode);
                    }

                    echo '</ul></li>';   
                }
                else
                {
                    $SQL1 = "SELECT count(programid) as child FROM programtab where programmenu='".$rowX['programid']."'";
                    $result1 = mysql_query( $SQL1 ) or die("Couldn't execute query.".mysql_error());

                    $row1 = mysql_fetch_array($result1); 
                    
                    echo '<li class="'.$rowX['programtype'].'"><div onclick="CngClass(this);" class="notClicked" id="'.$rowX['programid'].'" programid="'.$rowX['programid'].'" lineno="'.$rowX['lineno'].'" programname="'.$rowX['programname'].'" programtype="'.$rowX['programtype'].'" bmpid="'.$rowX['bmpid'].'" condition1="'.$rowX['condition1'].'" condition2="'.$rowX['condition2'].'" condition3="'.$rowX['condition3'].'" remarks="'.$rowX['remarks'].'" url="'.$rowX['url'].'" programmenu="'.$rowX['programmenu'].'" child="'.$row1['child'].'">'.$rowX["programname"].'</div></li>';
                }
                $x = $x-1;
                return $x;
            }
        ?>
    </body>
</html>