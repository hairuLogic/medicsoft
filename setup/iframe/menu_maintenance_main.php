<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style type="text/css">
table {
	background-color: #FFFBF0;
}
</style>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" margin="0px">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tbody>
    	<?php
		include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
			$myQuery = 'SELECT * FROM programtab where compcode="aa" and programmenu ="main" order by lineno';
			$result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				echo "<tr id='".$row[programid]."'>";
				echo	"<td>".$row[programname]."</td>";
				echo	"<td>".$row[programtype]."</td>";
				echo "</tr>";
			}
		?>


  </tbody>
</table>
</body>
</html>