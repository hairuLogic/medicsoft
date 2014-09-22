<?php
	include_once('connect_db.php');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Healthcare Information System</title>
<link  rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="mainjs.js"></script>
<link href="base.css" rel="stylesheet" type="text/css">
<style>
</style>
<script>
$(function() {
    $( "#dialogcr8" ).dialog({
		width: 400,
		autoOpen: false,
		buttons:{
			"Add":function(){
				$.post('cr8rel.php',$('#cr8rel').serialize());
				$(this).dialog('close');
			},
			'Close':function(){
				$(this).dialog('close');
			}
		}
	});
	
	$('#patregis').click(function(){
		window.open('http://localhost/hisdb/registerpat.php');
	});
	
	$( "#dialogupd8" ).dialog({
		width: 400,
		autoOpen: false,
		buttons:{
			"Update":function(){
				$.post('upd8rel.php',$('#upd8rel').serialize());
				$(this).dialog('close');
			},
			'Close':function(){
				$(this).dialog('close');
			}
		}
	});
	
	$('#opendialog').click(function(){
		$('#dialogcr8').dialog('open');
	});
	
	$('.point').click(function(){
		var rc=$(this).text();
		var res=$(this).next().text();
		$('#rc2').attr('value',rc);
		$('#des2').attr('value',res);
		$('#dialogupd8').dialog('open');
	});
  });
</script>
</head>

<body>


<div id="header">
<h1>Healthcare Information System</h1>
</div>
<div id="wrapper">
<div id="navside">
		<ol>
        	<li id="patregis"><a href="#">Patient Registration</a></li>
        </ol>
    	<h2 id="setup">Setup</h2>
        <ol id="setupOl">
            <li><a href="#">Citizen</a></li>
          	<li id="nav-current"><a href="religion.php">Religion</a></li>
          	<li><a href="#">Country</a></li>
            <li><a href="#">State</a></li>
            <li><a href="#">Area</a></li>
            <li><a href="#">Occupation</a></li>
            <li><a href="#">Race</a></li>
            <li><a href="#">Language</a></li>
        </ol>
</div>

<div><p id="time"><script>clock();</script></p></div>

    <div id="main">
    	<h2>Religion Information</h2>
   		<?php
        	$sql="select ReligionCode, Description from religion";
			$que=mysql_query($sql);
			echo "<table><tr><th>ReligionCode</th><th>Description</th></tr>";
			while($obj=mysql_fetch_object($que)){
				
				echo "<tr>
					<td class='point'>{$obj->ReligionCode}</td>
					<td>{$obj->Description}</td>
				</tr>";
			}
			echo"</table>";
		?>
        <input type="button" class="ui-button" id="opendialog" value="Create New"/>
       
  </div>
    
    <div id="dialogcr8" title="Create new Input">
            <div id="formmenu">
        	<form id="cr8rel" method="post" name="cr8rel">
                <div class="alongdiv">
                    <div class="smalltitle"><p class="titlediv">Religion Information</p></div>
                    <div class="bodydiv">
                    	<table>
                           	<tr><td><label for="name">ReligionCode: </label></td><td><input name="rc" type="field" class="ui-corner-all" id="rc" /></td></tr>
                            <tr><td><label for="newic">Description: </label></td><td><input name="des" type="field" class="ui-corner-all" id="des" /></td></tr>
                      	</table>
                    </div>
                </div>
            </form>
        </div>
    </div><!--habis dialogcr8-->
    
     <div id="dialogupd8" title="Create new Input">
            <div id="formmenu">
        	<form id="upd8rel" method="post" name="upd8rel">
                <div class="alongdiv">
                    <div class="smalltitle"><p class="titlediv">Religion Information</p></div>
                    <div class="bodydiv">
                    	<table>
                           	<tr><td><label for="name">ReligionCode: </label></td><td><input name="rc2" type="field" class="ui-corner-all" id="rc2" /></td></tr>
                            <tr><td><label for="newic">Description: </label></td><td><input name="des2" type="field" class="ui-corner-all" id="des2" /></td></tr>
                      	</table>
                    </div>
                </div>
            </form>
        </div>
    </div><!--habis dialogcr8-->
    
  <div id="footer">    </div>
</div>
</body>
</html>
