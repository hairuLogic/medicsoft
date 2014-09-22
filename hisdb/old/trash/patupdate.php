<?php
	include_once('connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PatientRegistration</title>
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link  rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script>
$(function(){
	$('input').attr('disabled',true);
	$('select').attr('disabled',true);
	$('textarea').attr('disabled',true);
	
	$('#religiondg').dialog({
		autoOpen:false,
		modal:true
	});
	$('#religionbutton').click(function(){
		$('#religiondg').dialog('open');
	})
	$('.pointer').click(function(){
		$('#religion').attr('value',$(this).attr('name'));
		$('#religiondg').dialog('close');
	})
	$('#addbut').click(function(){
		$('input').attr('disabled',false);
		$('select').attr('disabled',false);
		$('textarea').attr('disabled',false);
		$('#savbut').attr('disabled',false);
	});
});
</script>
<style>
td{
	padding:8px;
}
button{
	margin:0 10px;
	width:70px;
	height:60px;
	text-align:center;
	float:right;
}
#menu,.bodydiv{
	-webkit-box-shadow: 3px 3px 2px #999;
    -moz-box-shadow: 3px 3px 2px #f999;
    box-shadow: 3px 3px 2px #999;
}
#menu{
	height:60px;
	border: thin solid black;
	background-color:#FFFFCC;
}
#formmenu{
	margin:1%;
	width:80%;
	margin:3% auto;
	height:100%;
}
.sideright{
	margin-left:1%;
	margin-bottom:1%;
	float:right;
	width:49%;
}
.sideleft{
	margin-right:1%;
	margin-bottom:1%;
	float:left;
	width:49%;
}
.smalltitle{
	border-top-right-radius:10px;
	border-top-left-radius:10px;
	width:100%;
	color:#FFFFFF;
	background-image: linear-gradient(bottom, #EBAC23 21%, #EBD461 74%, #EDEADF 93%);
	background-image: -o-linear-gradient(bottom, #EBAC23 21%, #EBD461 74%, #EDEADF 93%);
	background-image: -moz-linear-gradient(bottom, #EBAC23 21%, #EBD461 74%, #EDEADF 93%);
	background-image: -webkit-linear-gradient(bottom, #EBAC23 21%, #EBD461 74%, #EDEADF 93%);
	background-image: -ms-linear-gradient(bottom, #EBAC23 21%, #EBD461 74%, #EDEADF 93%);
	background-repeat:repeat-x;
	border:thin solid #FFCC00;
}
.bodydiv{	
	border:thin solid black;
	width:100%;
	background-color:#FFFFCC;
}
.alongdiv{
	margin-bottom:1%;
	margin-top:1%;
	clear:both;
	width:100%;
}
.titlediv{
	padding-left:10px;
	padding-top:3px;
	padding-bottom:3px;
	font-weight:bold;
}
form{
	padding:5px;
}
.grey{
	border:thin solid black;
}
.grey td{
	border:thin solid black;
	font-size:16px;
}
.grey tr:hover{
	border:thin solid black;
	background:#FFFFCC;
	cursor:pointer;
}
.grey th{
	padding:5px;
	border:thin solid black;
}

</style>
</head>

<body>
            <div id="formmenu">
        	<form id="cr8user" method="post" name="cr8user" action="cr8user.php">
            <div id="menu">
            	<button  type="button" onClick="window.close();">Exit</button>
                <button id="addbut" type="button">Add</button>
                <button type="button" disabled='true'>Update</button>
                <button type="button" onClick="window.close();">Cancel</button>
                <button type="button" disabled='true'>Delete</button>
                <button type="submit" disabled='true' id="savbut">Save</button>
            </div>
                <div class="alongdiv">
                    <div class="smalltitle"><p class="titlediv">Patient Information</p></div>
                    <div class="bodydiv">
                    	<table>
                           	<tr>
                            <td><label for="name">Name: </label></td><td><input name="name" type="text" class="ui-corner-all" id="name" /></td>
                            <td><label for="newic">New IC: </label></td><td><input name="newic" type="text" class="ui-corner-all" id="newic" /></td>
                            <td><label for="oldic">Old IC: </label></td><td><input name="oldic" type="text" class="ui-corner-all" id="oldic" /></td></tr>
                      	</table>
                    </div>
                </div>
                
                <div class="sideleft">
                    <div class="smalltitle"><p class="titlediv">Address</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr><td>Type</td>
                        	<td><select name="jumpMenu" id="jumpMenu">
                              <option id="current">Current</option>
                              <option id="old">Old</option>
                              <option id="future">Future</option>
                            </select></td></tr>
                            <tr><td>Address: </td><td><textarea class="ui-corner-all"></textarea></td></tr>
                            <tr><td>Postcode: </td><td><input type="text" class="ui-corner-all" /></td></tr>
                        </table>
                  </div>
                </div>
                <div class="sideright">
                    <div class="smalltitle"><p class="titlediv">Other Information</p></div>
                    <div class="bodydiv">
                    	
                        <table>
                            <tr><td>DOB: </td><td><input type="text" class="ui-corner-all" /></td></tr>
                            <tr><td>Citizen: </td><td><input type="text" class="ui-corner-all"/></td></tr>
                            <tr><td>Marital</td><td><input type="text" class="ui-corner-all"/></td></tr>
                        </table>
                        <table>	 
                        	<tr>
                            	<td>Race:</td><td><input type="text" size='4'/><input type="button" value="..."/></td>
                                <td>Religion:</td><td><input type="text" size='4' id="religion"/><input type="button" value="..." id="religionbutton"/></td>
                                <td>Sex:</td><td><select name="sex" id="sex"><option>F</option><option>M</option></select></td>
                          	</tr>
                            <tr>
                                <td>Blood Group:</td><td><input type="text" size='4'/><input type="button" value="..."/></td>
                            	<td>Language:</td><td><input type="text" size='4'/><input type="button" value="..."/></td>
                            </tr>    
                        </table>
                    </div>
                </div>
                
                <div class="sideleft">
                	<div class="smalltitle"><p class="titlediv">Phone Number</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            	<td>House</td><td><input type="text" class="ui-corner-all" /></td>
                            	<td>H/P</td><td><input type="text" class="ui-corner-all" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="alongdiv">
                    <div class="smalltitle"><p class="titlediv">Payer Information</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr><td>Occupation</td><td><input type="text" class="ui-corner-all" /></td></tr>
                            <td>Company</td><td><input type="text" class="ui-corner-all" /></td>

                            <td>E-mail</td><td><input type="text" class="ui-corner-all" /></td></tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    
    
    <div id="religiondg">
    	<?php 
			$sql='select ReligionCode,Description from religion';
			$res=mysql_query($sql);
			echo "<table class='grey'><tr><th>Religion Code</th><th>Description</th></tr>";
			while($obj=mysql_fetch_object($res)){
				echo "<tr class='pointer' name='{$obj->ReligionCode}'><td>{$obj->ReligionCode}</td><td>{$obj->Description}</td></tr>";
			}
			echo "</table>"
		?>
    </div>
</body>
</html>
