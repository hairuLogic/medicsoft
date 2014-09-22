<?php
    session_start();
    $member=$_POST["member"];
    $compcode=$_SESSION['company'];
    $agentSql="";
    $addSql="";
    include '../../config.php';
    
    $parts = explode(' ', $member);
    $partsLength  = count($parts);
    while($partsLength>0){
        $partsLength--;
        $addSql .=" and (a.name LIKE '%$parts[$partsLength]%' or a.memberno LIKE '%$parts[$partsLength]%')";
    }
    if(isset($agent))    {
        $agent=$_GET['agent'];
        $agentSql="AND a.agentcode='$agent'";
    }
    $sql="SELECT COUNT(*) AS COUNT FROM membership as a WHERE a.compcode ='$compcode' $agentSql AND a.category='SUBSCRIBER' $addSql";
    $result=mysql_query($sql);
    $row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];

    
    if($count=="1"){
        $sql="SELECT a.memberno,a.name as membername,b.agentcode,b.name as agentname FROM membership a,agent b WHERE b.agentcode=a.agentcode AND a.compcode ='$compcode' $agentSql AND a.category='SUBSCRIBER' $addSql";

        $result=mysql_query($sql);
        $row = mysql_fetch_row($result,MYSQL_ASSOC);
        echo "<?xml version='1.0' encoding='utf-8'?>
        <tab>
            <msg>".$count."</msg>
            <memberno>".$row['memberno']."</memberno>
            <name>".$row['membername']."</name>
            <agent>".$row['agentcode']."</agent>
            <agentname>".$row['agentname']."</agentname>
        </tab>";
        //<amt1></amt1><amt2></amt2>
        exit();
    }
    else{
        $result1=mysql_query("SELECT COUNT(*) AS COUNT FROM membership as a WHERE a.compcode ='$compcode' $agentSql AND a.category='SUBSCRIBER' AND a.name LIKE '%{$member}%'");
        $row1 = mysql_fetch_array($result1);
        $count1 = $row1['COUNT'];
        if($count1=='0'){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>empty</msg></tab>";    
        }
        else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>pop</msg></tab>";    
        }
    }
?>