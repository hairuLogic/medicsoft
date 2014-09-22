<?php
	include_once('connect_db.php');
	$title=$_GET['title'];
	$sql=$_GET['sql']." order by MRN ASC limit 0,1000";
	$len=$_GET['len'];
	$head=explode(',',$_GET['head']);
	$res=mysql_query($sql);
	header("Content-Disposition: attachment; filename=$title.xls");
	echo "<p>$title</p></br>";
	echo "<table><tr>";
	foreach($head as $t)echo "<th>$t</th>";
	echo "</tr>";
	while ($row = mysql_fetch_array($res, MYSQL_NUM)) {
		echo "<tr>";
		for($x=0;$x<$len;$x++)echo "<td>$row[$x]</td>";
		echo "</tr>";
	}
	echo "</table>";

?>
