<?php
	include_once('../connect_db.php');
	if(isset($_GET['prc'])){
		if($_GET['prc']=='fail'){
			$alert= 'ERROR: Wrong username and password';
		}
	}
	if(isset($_GET['lgn'])){
		if($_GET['lgn']=='nt'){
			$alert= 'ERROR: You try to acces pages that requires log in first';
		}
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<title>Untitled Document</title>
<style>
select{
	width:250px;
}
.alongdiv{
	width:400px;
}
#formmenu{	width:400px;
	margin: 10% auto;
}
#alert{
	padding:5px 5px 10px 10px;
	width:385px;
	margin-top:15px;
	border:thin solid red;
	color:#FFFFFF;
	font-weight:bold;
	-webkit-box-shadow: 3px 3px 2px #999;
    -moz-box-shadow: 3px 3px 2px #f999;
    box-shadow: 3px 3px 2px #999;
	background-image: linear-gradient(bottom, rgb(250,190,190) 0%, rgb(250,0,0) 47%, rgb(107,6,6) 100%);
	background-image: -o-linear-gradient(bottom, rgb(250,190,190) 0%, rgb(250,0,0) 47%, rgb(107,6,6) 100%);
	background-image: -moz-linear-gradient(bottom, rgb(250,190,190) 0%, rgb(250,0,0) 47%, rgb(107,6,6) 100%);
	background-image: -webkit-linear-gradient(bottom, rgb(250,190,190) 0%, rgb(250,0,0) 47%, rgb(107,6,6) 100%);
	background-image: -ms-linear-gradient(bottom, rgb(250,190,190) 0%, rgb(250,0,0) 47%, rgb(107,6,6) 100%);
	border-bottom-right-radius:10px;
	border-top-left-radius:10px;
}
</style>
</head>
<body>
	<div id="formmenu">
    	<div class="alongdiv">
        	<div class="smalltitle"><p>LOG IN</p></div>
            <div class="bodydiv">
            	
                <form method="post" name="login" action="prslogin.php">
                	<table>
                	<tr><td><label>LoginID</label></td><td><input type="text" id="usrname" name="usrname"/></td></tr>
                    <tr><td><label>Password</label></td><td><input type="password" id="pass" name="pass"/></td></tr>
                    <tr><td><label>Company</label></td><td><select name="comp">
                        <?php
                            $sql='select * from company';
                            $res=mysql_query($sql);
                            while($obj=mysql_fetch_object($res)){
                                echo "<option>{$obj->compname}</option>";
                            }
                        ?>
                    </select></td></tr>
                    </table>
                    <input type="submit" value="Proceed" id="button" class="orgbut"/>
                </form>
                
            </div>
            <?php
            	if(isset($alert)){
					echo "<div id='alert'>$alert</div>";
				}
			?>
        </div>
    </div>
	
</body>
</html>
