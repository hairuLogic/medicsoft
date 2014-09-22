<?php
include '../../config.php';
     $a4=mysql_query("SELECT programmenu,lineno FROM `programtab` where compcode='9a' and programid='d'");
        while($row = mysql_fetch_array($a4)){
            $a5 = mysql_query("SELECT groupid from groupacc where programmenu='main' and compcode='9a' and yesall='1'");
            while($row1 = mysql_fetch_array($a5)){
                $a6 = mysql_query("INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun,yesall) SELECT '{$compcode}','{$row1["groupid"]}','{$programmenu}',lineno,1,0 FROM programtab where compcode='{$compcode}' and programid='{$programid}' and programmenu='{$programmenu}'");
            }
?>

programtypeA:M
at_where:first
programid:c
remarks:
programname:c
condition1:
condition2:
condition3:
bmpid:
url:
opStatus:insert
programmenu:d
lineno:1
child:
