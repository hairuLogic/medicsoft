<?php
	include_once('sschecker.php');
	include_once('connect_db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<link href="formcss.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<title>Statistics</title>
<script>
$(function(){
	var mrnarr=[],newdata=[];
	$('#pageinfoin').hide();
	$('#pageinfotog').click(function(){
		$('#pageinfoin').slideToggle('fast');
	});
	function getsectbl(col){
		if(col=='sex')return 'sex';
		if(col=='race')return 'racecode';
		if(col=='citizen')return 'citizen';
		if(col=='religion')return 'religion';
		if(col=='language')return 'languagecode';
		if(col=='marital')return 'Marital';
	}
	function getcol(col){
		if(col=='sex')return 'sex';
		if(col=='race')return 'racecode';
		if(col=='citizen')return 'citizencode';
		if(col=='religion')return 'religion';
		if(col=='language')return 'languagecode';
		if(col=='marital')return 'Maritalcode';
	}
	function hideall(kecuali){
		$('#tabs11 a').each(function(){
			if($(this).attr('href')==kecuali){
				$(this).attr('class','act');
				getdata(kecuali.slice(1),getcol(kecuali.slice(1)),getsectbl(kecuali.slice(1)));
			}else{
				$(this).attr('class','');
			}
		});
	}
	hideall('#sex');
	$('#tabs11 li').click(function(){
		var selected=$(this).children(":first").attr('href');
		hideall(selected);
	});
	var options={
			chart: {
				renderTo:'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
			credits: {
            	enabled: false
        	},
            tooltip: {
            	valueDecimals: 2
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Total'
            }]
		}
	var chart=new Highcharts.Chart(options);
	
	function getdata(titlecol,col,sectbl){
		$.get('statsphpget.php',{col:col,sectbl:sectbl},function(data){
			newdata.length=0;
			newdata=data;
			chart.series[0].setData(newdata);
			chart.setTitle({ text: 'Statistics of patient '+titlecol+' as of 2013' });
			$.each(chart.series[0].data, function (i, point) {
				 point.update(newdata[i], false);
			});
			chart.redraw();
		}, "json");
	}
	
});
</script>
<style>
.smalltitle{
	height:30px;
}
.bodydiv{
	padding-right:1px;
}
</style>
</head>

<body>
    <div id="pageinfo">
        <div id="pageinfoin">User: <?php echo $_SESSION['username'];?> | Company: <?php echo $_SESSION['companyName'];?><a href="logout.php"> | Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
    <div id="formmenu">
    	<div id="menu">
        <span id="pagetitle">Statistics</span>
        <button type="button" onClick="window.close();" id="extbut"></button>
        </div>
		<div class="alongdiv">
    		<div class="smalltitle">
        		<div id="tabs11">
            		<ul>
                	<li><a href="#sex"><span>Sex</span></a></li>
                	<li><a href="#race"><span>Race</span></a></li>
                    <li><a href="#citizen"><span>Citizen</span></a></li>
                    <li><a href="#religion"><span>Religion</span></a></li>
                    <li><a href="#language"><span>Language</span></a></li>
                    <li><a href="#marital"><span>Marital</span></a></li>
            		</ul>
        		</div>
    		</div>
    	
        
        <div id="bodytab">
            <div class="bodydiv"/><div id="container"></div></div>
        </div>
    </div>
    </div>
    
   
</body>
</html>
