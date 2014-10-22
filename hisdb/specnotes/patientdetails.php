<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient List</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css" />
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/jquery.jqGrid.min.js"></script>
<script src="../js/jquery.jqGrid-4.4.4/js/i18n/grid.locale-en.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/jquery.mb.browser.min.js"></script>
<script src="../../script/date_time.js"></script>
<script>
			// Wait until the DOM has loaded before querying the document
			$(document).ready(function(){
				$('ul.tabs').each(function(){
					// For each set of tabs, we want to keep track of
					// which tab is active and it's associated content
					var $active, $content, $links = $(this).find('a');

					// If the location.hash matches one of the links, use that as the active tab.
					// If no match is found, use the first link as the initial active tab.
					$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
					$active.addClass('active');

					$content = $($active[0].hash);

					// Hide the remaining content
					$links.not($active).each(function () {
						$(this.hash).hide();
					});

					// Bind the click event handler
					$(this).on('click', 'a', function(e){
						// Make the old tab inactive.
						$active.removeClass('active');
						$content.hide();

						// Update the variables with the new link and content
						$active = $(this);
						$content = $(this.hash);

						// Make the tab active.
						$active.addClass('active');
						$content.show();

						// Prevent the anchor's default click action
						e.preventDefault();
					});
				});
			});
			
function savedetails(id){
  
  var uri = "patientdetails.php";
  uri += "?process=add" ;
  uri += "&id=" + id ;
  document.forms[0].action = uri;
  document.forms[0].method = "post";
  document.forms[0].submit();
  
}

function goback(id){
  var uri = "notes.php";
  uri += "?id=" + id ;
  document.forms[0].action = uri;
  document.forms[0].method = "post";
  document.forms[0].submit();	
}
			
</script>
        <style>
			* {padding:0; margin:0;}

			html {
				
				padding:15px 15px 0;
				font-family:sans-serif;
				font-size:14px;
			}

			p, h3 { 
				margin-bottom:15px;
			}

			

			.tabs li {
				list-style:none;
				display:inline;
			}

			.tabs a {
				padding:5px 10px;
				display:inline-block;
				background:#666;
				color:#fff;
				text-decoration:none;
			}

			.tabs a.active {
				background:#f7b03b;
				color:#000;
			}

		</style>
</head>
</html>
<?php

$id = $_GET["id"];

$sql = "select patmast.*,occupation.description,queue.ageyy,queue.attndoctor from queue ";
$sql.= "left join patmast on patmast.mrn = queue.mrn ";
$sql.= "left join occupation on occupation.occupcode = patmast.occupcode ";
$sql.= "where queueno = '$id'";
$rs = mysql_query($sql);
$data_array = mysql_fetch_array($rs);

$name  = $data_array["name"];
$icno  = $data_array["newic"];
$dob  = $data_array["dob"];
$telhp  = $data_array["tel_hp"];
$sex = $data_array["sex"];
$occupation = $data_array["description"];
$age = $data_array["ageyy"];
$episodeno = $data_array["episno"];
$mrn = $data_array["mrn"];
$doc = $data_array["attndoctor"];

$sql = "select * from pathealth where mrn='$mrn' and episno='$episodeno'";
$rs1 = mysql_query($sql);
$details = mysql_fetch_array($rs1);
$complaint = $details["complain"];
$clinicalnote = $details["clinicnote"];
$plan = $details["plan"];
$weight = $details["weight"];
$height = $details["height"];
$bp = $details["bp"];
$pulse = $details["pulse"];
$temp = $details["temperature"];
$visionR = $details["visionr"];
$visionL = $details["visionl"];
$resp = $details["respiration"];
$colblind = $details["colorblind"];

if($_GET['process'] == "add"){
	
   //Vital Sign Tab	
   $height = $_POST["txtheight"];
   $bp = $_POST["txtbp"];
   $temp = $_POST["txttemp"];
   $epsno = $_POST["txtepsno"];
   //$bmi = $_POST["txtbmi"];
   $visionR = $_POST["txtvisionR"];
   $visionL = $_POST["txtvisionL"];
   $weight = $_POST["txtweight"];
   $pulse = $_POST["txtpulse"];
   $resp = $_POST["txtrespiration"];
   $colblind = $_POST["txtcolblind"];
   $complaint = $_POST["txtcomplaint"];
   $clinicalnote = $_POST["txtclinicalnote"];
   $plan = $_POST["txtplan"];
   $mrn = $_POST["txtmrn"];
   
   
   $sql = "select count(*) as cnt from pathealth where episno ='$epsno' and mrn='$mrn'";
   $rs = mysql_query($sql);
   $data_array = mysql_fetch_array($rs);
   $val = $data_array["cnt"];
   
   if($val == 0){
   
   $sql = "insert into pathealth ";
   $sql.= "(episno,height,bp,temperature,visionr,weight,pulse,respiration,colorblind ";
   $sql.= ",visionl,complain,clinicnote,plan,mrn)";
   $sql.= " values ";
   $sql.= "('$epsno','$height','$bp','$temp','$visionR','$weight','$pulse','$resp','$colblind', ";
   $sql.= "'$visionL','$complaint','$clinicalnote','$plan','$mrn')";
   
   }else{
   
   $sql = "update pathealth set ";
   $sql.= "height='$height',";
   $sql.= "bp='$bp',";
   $sql.= "temperature='$temp',";
   $sql.= "visionr='$visionR',";
   $sql.= "weight='$weight',";
   $sql.= "pulse='$pulse',";
   $sql.= "respiration='$resp',";
   $sql.= "colorblind='$colblind',";
   $sql.= "visionl='$visionL',";
   $sql.= "complain='$complaint',";
   $sql.= "clinicnote='$clinicalnote',";
   $sql.= "plan='$plan' ";
   $sql.= "where mrn='$mrn' and episno='$epsno'";
   
   }

   mysql_query($sql);
   
   echo "<script type='text/javascript'>
      alert('Record has been Succesfully Update!'); 
      window.location = 'patientdetails.php?id=$id';
      </script>";	
	
}

?>
<body>
<?php include("../../include/header.php")?>
<form>
<span id="pagetitle">Patient Details</span>
<div id="formmenu">
    <div id="menu" >
      <input type="button" value="Note" class="orgbut" >
      <input type="button" value="Call" class="orgbut">    
      <input type="button" value="Cancel" class="orgbut" onclick="goback('<?php echo $doc ?>')">   
      <input type="button" value="Save" class="orgbut" onclick="savedetails(<?php echo $id ?>)">       
    </div>
<div class="alongdiv"></div> 
<div class="bodydiv">
<ul class='tabs'>
     <li><a href='#tab1'>Patient Biodata</a></li>
     <li><a href='#tab2'>Complaint</a></li>
     <li><a href='#tab3'>Clinical Note</a></li>
     <li><a href='#tab4'>Diagnosis</a></li>
     <li><a href='#tab5'>Plan</a></li>
     <li><a href='#tab6'>History</a></li>
     <li><a href='#tab7'>Physical Examination</a></li>
     <li><a href='#tab8'>Vital Sign</a></li>
</ul>
<div id='tab1'>
    <table width="100%">
        <tr>
           <td width="10%">MRN No</td>
           <td colspan="3"><?php echo $mrn ?></td>
        </tr>
        <tr>
            <td width="10%">Name:</td>
            <td width="40%" align="left"><?php echo $name?></td>
            <td width="10%">Ic:</td>
            <td width="40%" align="left"><?php echo $icno?></td>
        </tr>
        <tr>
            <td>DOB:</td>
            <td><?php echo date("j M Y",strtotime($dob))?></td>
            <td>Age:</td>
            <td><?php echo $age ?></td>
        </tr>
           <tr>
            <td>Tel:</td>
            <td><?php echo $telhp ?></td>
            <td>Sex:</td>
            <td><?php echo $sex ?></td>
        </tr>
        <tr>
            <td>Occupation:</td>
            <td><?php echo $occupation ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<div id='tab2'>
   <table width="100%">
      <tr> 
	      <td><textarea cols="80" rows="10" name="txtcomplaint" id="txtcomplaint"><?php echo $complaint ?></textarea></td>
      </tr>
   </table>       
</div>
<div id='tab3'>
   <table width="100%">
       <tr>
            <td>History Of Presenting Complaint</td>
       </tr>
       <tr>     
            <td ><textarea cols="80" rows="10" name="txtclinicalnote" id="txtclinicalnote"><?php echo $clinicalnote ?></textarea></td>
        </tr>
    </table>    
</div>
<div id='tab4'>
    <table width='100%'>
       <tr>
           <td><input type="text" size="40"><input type="button" value="..."></td>
       </tr>
    </table>
</div>
<div id='tab5'>
    <table width='100%'>
       <tr>
           <td><textarea cols="80" rows="10" name="txtplan" id="txtplan"><?php echo $plan ?></textarea></td>
       </tr>
    </table>
</div>
<div id='tab6'>
    <table width='100%'>
       <tr>
           <td><textarea cols="80" rows="10"></textarea></td>
       </tr>
    </table>
</div>
<div id='tab7'>
    <table width="100%">
    <tr>
        <td>Physical Examination</td>
    </tr>
    <tr>
        <td><table id="grid1"></table></td>
    </tr>
    <tr>
        <td>Others</td>
    </tr>
    <tr>
        <td><textarea cols="80" rows="10"></textarea></td>
    </tr>
    </table>
</div>
<div id='tab8'>
	<table width="100%" border="1">
    <tr>
        <th colspan="5">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="5">&nbsp;</th>
    </tr>
    <tr>
        <td>Height</td>
        <td>BP</td>
        <td>Temperature</td>
        <td>BMI</td>
        <td>Vision(R)</td>
    </tr>
    <tr>
        <td><input type="text" name="txtheight" id="txtheight" value="<?php echo $height ?>">&nbsp;CM</td>
        <td><input type="text" name="txtbp" id="txtbp" value="<?php echo $bp ?>"></td>
        <td><input type="text" name="txttemp" id="txttemp" value="<?php echo $temp ?>">OC</td>
        <td><input type="text" name="txtbmi" id="txtbmi"></td>
        <td><input type="text" name="txtvisionR" id="txtvisionR" value="<?php echo $visionR ?>"></td>
    </tr>
    <tr>
        <td>Weight</td>
        <td>Pulse Rate</td>
        <td>Respiration</td>
        <td>Color Blind</td>
        <td>Vision(L)</td>
    </tr>
    <tr>
        <td><input type="text" name="txtweight" id="txtweight" value="<?php echo $weight ?>">&nbsp;Kg</td>
        <td><input type="text" name="txtpulse" id="txtpulse" value="<?php echo $pulse ?>"></td>
        <td><input type="text" name="txtrespiration" id="txtrespiration" value="<?php echo $resp ?>">OC</td>
        <td><select name="txtcolblind" id="txtcolblind">
            <option value="No" <?php if($colblind == "No"){ echo "selected='selected'";}?>>No</option>
            <option value="Yes" <?php if($colblind == "Yes"){ echo "selected='selected'";}?>>Yes</option>
            </select></td>
        <td><input type="text" name="txtvisionL" id="txtvisionL" value="<?php echo $visionL ?>"></td>
    </tr>
    </table>
    
</div>
</div>
<div class="alongdiv"></div> 
<div id="menu" >
<table width="100%">
    <tr align="Center">
       <td><input type="button" value="Laboratory" class="orgbut"></td>
       <td><input type="button" value="Radiology" class="orgbut"></td>
       <td><input type="button" value="Physioterapy" class="orgbut"></td>
       <td><input type="button" value="Pharmacy" class="orgbut"></td>
       <td><input type="button" value="Clinic" class="orgbut"></td>
       <td><input type="button" value="Audiology" class="orgbut"></td>
    </tr>
    <tr align="Center">
       <td><input type="button" value="Radioterapy" class="orgbut"></td>
       <td><input type="button" value="Respiratory" class="orgbut"></td>
       <td><input type="button" value="Disposable" class="orgbut"></td>
       <td><input type="button" value="Consultant Fees" class="orgbut"></td>
       <td><input type="button" value="Referral" class="orgbut"></td>
       <td><input type="button" value="Nuclear" class="orgbut"></td>
    </tr>
</table>

      
      
         
     
      
        
      
       
        
         
          
           
    </div>
 </div>
<input type="hidden" name="txtepsno" value="<?php echo $episodeno ?>">
<input type="hidden" name="txtmrn" value="<?php echo $mrn ?>">
 <form>   
</body>