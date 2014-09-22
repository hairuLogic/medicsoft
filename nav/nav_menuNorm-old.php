
<script>
    var x;
    $(document).ready(function() {
        //Class 'contentContainer' refers to 'li' that has child with it.
        //By default the child ul of 'contentContainer' will be set to 'display:none'
        $("#treeMenu li").toggle(
            function() { // START FIRST CLICK FUNCTION
                if (($(this).hasClass('contentContainer'+x) || $(this).hasClass('contentViewing'+x))&& $('.'+'contentViewing'+x).text() != $(this).text()) {                                        
                    $('.contentViewing'+x).children('ul').slideUp()
                    $('.contentViewing'+x).removeClass().addClass('contentContainer'+x);
                }    
                if ($(this).hasClass('contentContainer'+x)) {
                    $(this).children('ul').slideDown()
                    $(this).removeClass('contentContainer'+x).addClass('contentViewing'+x);
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
                if (($(this).hasClass('contentContainer'+x) || $(this).hasClass('contentViewing'+x)) && $('.contentViewing'+x).text() != $(this).text()) {                                        
                    $('.contentViewing'+x).children('ul').slideUp()
                    $('.contentViewing'+x).removeClass().addClass('contentContainer'+x);
                }  
                if (($(this).hasClass('contentContainerMain') || $(this).hasClass('contentViewingMain')) && $('.contentViewingMain').text() != $(this).text()) {                                        
                    $('.contentViewingMain').children('ul').slideUp()
                    $('.contentViewingMain').removeClass().addClass('contentContainerMain');
                }                  
                if ($(this).hasClass('contentViewing'+x)) {
                    $(this).children('ul').slideUp()
                    $(this).removeClass('contentViewing'+x).addClass('contentContainer'+x);
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
			
        ).on('mousedown', 'a', function(e) { 
            if( e.which == 1 ) { e.preventDefault();
                  myWin=window.open(this.href,"_self");
               }  
            else if ( e.which == 2 ) { e.preventDefault();
                  myWin=window.open(this.href);
               }
              
        }); // END TOGGLE FUNCTION 


    });      // END DOCUMENT READY

    function CngClass(y){
        x=y-1;
    };
</script>

<?php

    $compcode= $_SESSION['company'];
    $groupid=$_SESSION['groupid'];
    include( $_SERVER['DOCUMENT_ROOT'] . '/medicsoft/config.php');
    $x=0;
    $rowX = array();
    $myQueryX = array();
    $resultX= array();
    $class = 'contentContainerMain';

    $myQuery = "select * from programtab a inner join groupacc b on a.programmenu=b.programmenu and a.lineno = b.lineno  where  b.groupid='{$groupid}' and b.compcode='{$compcode}' and b.programmenu='main' order by b.lineno";
    $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());

    echo '<div id="tree" width="100%"><ul id="treeMenu"><h1>MENU</h1>';
    
    while($rowX[x] = mysql_fetch_array($result))
    {
        menu($rowX[x],$x,$class,$compcode);
    }

    function menu($rowX,$x,$class,$compcode){
        $x = $x+1;

        if($rowX['programtype']=='M')
        {            
            echo '<li class="'.$class.'" onclick="CngClass('.$x.')">'.strtoupper($rowX['programname']); 
            $myQueryX[x] = "select * from programtab a inner join groupacc b on a.programmenu=b.programmenu and a.lineno = b.lineno  where  b.groupid='{$_SESSION['groupid']}' and b.compcode='{$compcode}' and b.programmenu='{$rowX['programid']}' order by b.lineno";            
            $resultX[x]=mysql_query($myQueryX[x])or die($myQueryX[x]."<br/><br/>".mysql_error());

            $class='contentContainer'.$x;
            echo '<ul style="display: none">';
            while($rowX[x] = mysql_fetch_array($resultX[x]))
            {
                menu($rowX[x],$x,$class,$compcode);
            }

            echo '</ul></li>';   
        }
        else
        {
            $SQL1 = "select * from programtab a inner join groupacc b on a.programmenu=b.programmenu and a.lineno = b.lineno  where  b.groupid='{$_SESSION['groupid']}' and b.compcode='{$compcode}' and b.programmenu='{$rowX['programid']}'";
            $result1 = mysql_query( $SQL1 ) or die("Couldn't execute query.".mysql_error());

            $row1 = mysql_fetch_array($result1); 

            echo "<li><a href='".$rowX['url']."' class='link'>".$rowX["programname"]."</a></li>"; 
        }
        $x = $x-1;
        return $x;
    }
?>