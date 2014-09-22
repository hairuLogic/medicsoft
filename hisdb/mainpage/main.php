<?php 
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Healthcare Information System</title>
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="mainjs.js"></script>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<style>
#header{
	position:relative;
}
#header h3{
	position:absolute;
	color:#FFFFFF;
	right:0;
	bottom:1px;
}
#header a{
	text-decoration:none;
	color:#FFFFFF;
}
#main{
	/*background-image:url(image/LogoMedicsoft.PNG);*/
	background-repeat:no-repeat;
	background-position:center;
	opacity:0.9;
}
#footer{
	position:absolute;
	background-image:url(image/logoMS.png);
	background-repeat:no-repeat;
	background-position:center;
	bottom:0;
	width:100%;
}
#navside{
	overflow:scroll;
}
#navside h2{
	padding-left:5px;
}
</style>
<script>
$(function() {
	var win={};
	$('#navside #patient li a,#navside #report li a').click(function(){
		var name=$(this).attr('id'),goto=$(this).attr('goto');
		if(win[name]!=null&&!win[name].closed){
			win[name].focus();
		}else{
			win[name]=window.open(goto);
		}
	});	
	$("#navside #filesetup li a").click(function(){
		var det=$(this).text();
		window.open('../citizen/allsetup.php?table='+det);
	});
	$("#navside h2,#navside h3").click(function(){
 		$(this).next().toggle();
  	});
	$("h2,h3").next().hide();
	$("#navside ol li").css('margin-left','5px');
});
</script>
</head>

<body>


<div id="header">
<h1>Healthcare Information System</h1>
<h3>User: <?php echo $_SESSION['username'];?><a href="../login/logout.php"> Log out</a></h3>
</div>
<div id="wrapper">
<div id="navside">
		<h2>Patient</h2>
        <ol id="patient">
        	<li><a href="#" id="winrp" goto="../registration/patregistration.php">Registration</a></li>
            <li><a href="#" id="epi" goto="episode.php">Episode</a></li>
        </ol>
        <h2>Order Entry</h2>
        <ol id="ordentry">
			<li><a href="#">General</a></li>
            <li><a href="#">Depart</a></li>
		</ol>
    	<h2>Setup</h2>
        <ol id="setup">
        <h3>File Setup</h3>
            <ol id="filesetup">
                <li><a href="#">Citizen</a></li>
                <li><a href="#">Religion</a></li>
                <li><a href="#">Country</a></li>
                <li><a href="#">Blood Group</a></li>
                <li><a href="#">Title</a></li>
                <li><a href="#">Race</a></li>
                <li><a href="#">Language</a></li>
                <li><a href="#">Marital</a></li>
                <li><a href="#">Occupation</a></li>
             </ol>
        </ol>
        <h2>Report</h2>
        <ol id="report">
            <li><a href="#" goto="../report-pdf/reportofpatient.php" id="rpdf">Report - PDF</a></li>
            <li><a href="#" goto="../report-excel/fixedexcel.php" id="rxls">Report - EXCEL</a></li>
            <li><a href="#" goto="../statistics/statistics.php" id="stats">Statistics</a></li>
        </ol>
</div>

<div><p id="time"><script>clock();</script></p></div>

    <div id="main">
  	</div>
  
  <div id="footer"></div>
</div>
</body>
</html>
