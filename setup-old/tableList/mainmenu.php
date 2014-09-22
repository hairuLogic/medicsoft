<?php
    session_start();
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    $programid=$_GET['programid'];
    $compcode=$_SESSION['company'];
    if(!$sidx) $sidx =1;
    // connect to the database

    include '../../config.php';

    $result = mysql_query("SELECT COUNT(*) AS count FROM programtab where compcode='{$compcode}'");
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)
    $SQL = "SELECT * FROM programtab where programmenu='{$programid}' and compcode='{$compcode}' ORDER BY lineno LIMIT $start , $limit";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
        header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
        header("Content-type: text/xml;charset=utf-8");
    }
    $et = ">";

    echo "<?xml version='1.0' encoding='utf-8'?$et\n";
    echo "<rows>";
        echo $_SESSION['username'];
    echo "<page>".$page."</page>";
    echo "<total>".$total_pages."</total>";
    echo "<records>".$count."</records>";
    // be sure to put text data in CDATA
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
        //echo $row['programid'];
		//get child
        $SQL1 = "SELECT count(programid) as child FROM programtab where programmenu='{$row['programid']}'";
        $result1 = mysql_query( $SQL1 ) or die("Couldn't execute query.".mysql_error());
        $row1 = mysql_fetch_array($result1);

        echo "<row id='". $row['programid'].$row['lineno']."'>"; 

        echo "<cell><![CDATA[". $row['programid']."]]></cell>";
        if($row[programtype]=='m'){
            echo "<cell><![CDATA[". strtoupper($row['programname'])."]]></cell>";
        }
        else{
            echo "<cell><![CDATA[". $row['programname']."]]></cell>";
        }
        echo "<cell><![CDATA[". strtoupper($row['programtype'])."]]></cell>";
        echo "<cell><![CDATA[". $row['lineno']."]]></cell>";
        echo "<cell><![CDATA[". $row['url']."]]></cell>";
        echo "<cell><![CDATA[". $row['remarks']."]]></cell>";
        echo "<cell><![CDATA[". $row['condition1']."]]></cell>";
        echo "<cell><![CDATA[". $row['condition2']."]]></cell>";
        echo "<cell><![CDATA[". $row['condition3']."]]></cell>";
        echo "<cell><![CDATA[". $row['bmpid']."]]></cell>";
        echo "<cell><![CDATA[". $row['programmenu']."]]></cell>";
        echo "<cell><![CDATA[". $row1['child']."]]></cell>";
        echo "</row>";

    }
    echo "</rows>";        
?>