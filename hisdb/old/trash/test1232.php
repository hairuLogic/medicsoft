<?php
include_once('connect_db.php');
$q="select COUNT(*) as count from patmast";
$r=mysql_query($q);

$row=mysql_fetch_row($r);
echo $row[0];

?>