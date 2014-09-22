<?php
session_start();

    $compcode=$_SESSION['company'];
    $groupid=$_GET['groupid'];
    $programmenu=$_GET['programmenu'];

    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
    // connect to the database

    include '../../config.php';

    $result = mysql_query("SELECT COUNT(*) AS count FROM programtab a
        LEFT JOIN groupacc b
        ON a.programmenu = b.programmenu 
        and a.lineno=b.lineno 
        and a.compcode=b.compcode
        and b.groupid='{$groupid}'
        WHERE a.programmenu = '{$programmenu}'
        and a.compcode='{$compcode}'");
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)
    $SQL = "SELECT a.lineno,a.programname,programtype,a.programid,
    CASE WHEN b.canrun =1 THEN 'Yes' ELSE 'No' END as canrun,
    CASE WHEN b.yesall =1 THEN 'Yes' ELSE 'No' END as yesall
    FROM programtab a
    LEFT JOIN groupacc b
    ON a.programmenu = b.programmenu 
    and a.lineno=b.lineno 
    and a.compcode=b.compcode
    and b.groupid='{$groupid}'
    WHERE a.programmenu = '{$programmenu}'
    and a.compcode='{$compcode}'
    ORDER BY lineno LIMIT $start , $limit";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
        header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
        header("Content-type: text/xml;charset=utf-8");
    }
    $et = ">";

    echo "<?xml version='1.0' encoding='utf-8'?$et\n";
    echo "<rows>";
    echo "<page>".$page."</page>";
    echo "<total>".$total_pages."</total>";
    echo "<records>".$count."</records>";
    // be sure to put text data in CDATA
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {

        echo "<row id='". $row['lineno']."'>";
        echo "<cell><![CDATA[".$row['lineno']."]]></cell>"; 
        echo "<cell><![CDATA[".$row['programname']."]]></cell>";
        echo "<cell><![CDATA[".$row['programtype']."]]></cell>";
        echo "<cell><![CDATA[".$row['programid']."]]></cell>";
        echo "<cell><![CDATA[".$row['canrun']."]]></cell>";
        echo "<cell><![CDATA[".$row['yesall']."]]></cell>";
        echo "</row>";

    }
    echo "</rows>";        
?>