<script>
	var x=1;
	function CngClass(y){
        x=y;
		$('.contentContainer'+x).parent().children('ul').slideToggle();
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
    $class = 'contentContainer';

    $myQuery = "select * from programtab a inner join groupacc b on a.programmenu=b.programmenu and a.lineno = b.lineno  where  b.groupid='{$groupid}' and b.compcode='{$compcode}' and b.programmenu='main' order by b.lineno";
    $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());

    echo '<div id="tree" width="100%"><ul id="treeMenu"><h1>MENU</h1>';
    $y=0;
    while($rowX[$x] = mysql_fetch_array($result))
    {        
        $y=$y+1;
		$xx = $y;
        menu($rowX[$x],$xx,$class,$compcode,$y);
    }

    function menu($rowX,$x,$class,$compcode,$y){
		
        $x = $y.$x;
        if($rowX['programtype']=='M')
        {            
            echo '<li><span class="'.$class.$x.'" onclick="CngClass('.$x.')">'.strtoupper($rowX['programname'])."</span>"; 
            $myQueryX[$x] = "select * from programtab a inner join groupacc b on a.programmenu=b.programmenu and a.lineno = b.lineno  where  b.groupid='{$_SESSION['groupid']}' and b.compcode='{$compcode}' and b.programmenu='{$rowX['programid']}' order by b.lineno";            
            $resultX[$x]=mysql_query($myQueryX[$x])or die($myQueryX[$x]."<br/><br/>".mysql_error());

            //$class='contentContainer'.$x;
            echo '<ul style="display: none">';
            while($rowX[$x] = mysql_fetch_array($resultX[$x]))
            {
                $y=$y+1;
                menu($rowX[$x],$x,$class,$compcode,$y);
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