<?php
	include_once('sschecker.php');
	include_once('connect_db.php');
	$valid=false;
	if(isset($_GET['mrn'])){
		$valid=true;
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PatientRegistration</title>
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="reset.css" type="text/css"  />
<link href="formcss.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.js"></script>
<script src="jquery.blockUI.js"></script>
<script src="jquery.maskedinput.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(function(){
	var servername='http://192.168.0.142/';
	$('#pageinfoin').hide();
	$('#pageinfotog').click(function(){
		$('#pageinfoin').slideToggle('fast');
	});
	if($('#determine').val()=='upd'){
		basepatdata();
		updmenu();
	}else if($('#determine').val()=='rgd'){
		addmenu();
	}else{
		alert('error happen please close the page');
	}
	function disabletextfield(){
		$('input').attr('disabled',true);
		$('select').attr('disabled',true);
	}
	function enabletextfield(){
		$('input').attr('disabled',false);
		$('select').attr('disabled',false);
	}
	function basemenu(){
		disabletextfield();
		$('#addbut').attr('disabled',false);
		$('#updbut').attr('disabled',true);
		$('#canbut').attr('disabled',true);
		$('#savbut').attr('disabled',true);
		$('#delbut').attr('disabled',true);
		if($('#determine').val()=='upd')
			$('#updbut').attr('disabled',false);
	}
	$("#tabs").tabs();
	$("#dob").datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: "1970:2013",
	  dateFormat: "dd-mm-yy"
    });
	$('#citizendg').dialog({autoOpen:false,modal:true});//width:300,height:200
	$('#religiondg').dialog({autoOpen:false,modal:true});
	$('#racedg').dialog({autoOpen:false,modal:true});
	$('#languagedg').dialog({autoOpen:false,modal:true});
	$('#bloodgroupdg').dialog({autoOpen:false,modal:true});
	$('#titledg').dialog({autoOpen:false,modal:true});
	$('.dialogbutton').click(function(){
		var thiz=$(this);
		var name=$(this).attr('name');
		var dg='#'+$(this).attr('dg');
		$(dg).dialog('open');	
			$.post('tablegrey.php',{table:name},function(data){
				var append="<div class='alldgdiv'><table class='grey'><tr><th>Code</th><th>Description</th></tr>";
				$(data).find('point').each(function(){
					var code=$(this).find('code').text();
					var des=$(this).find('des').text();
					append+="<tr class='pointer'><td>"+code+'</td><td>'+des+'</td></tr>';
				});
				append+='</table></div>';
				$(dg).html(append);
				$('.pointer').on('click',function(event){
					var selected=$(this).children(':first').text();
					thiz.parent().prev().children(':first').val(selected);
					$(dg).dialog('close');
					thiz=null;
				});
			});
	});
	$("#postcode,#postcode2,#postcode3").mask('99999');
	$("#dob").mask('99-99-9999');
	$("#newic").mask('999999-99-9999');
	$("#hp").mask('999-9999999');
	$("#house").mask('99-99999999');
	$("#citizen,#language,#bloodgroup,#religion,#race").mask('a?aa');
	function checkform(){
		var cont=true,cont2=true;
		var error=[];
		$('.req').each(function(){
			if($(this).val()==''){
				cont=false;
				error.push($(this));
			}
		});
		$('.req2').each(function(){
			cont2=false;
			if($(this).val()!=''){
				cont2=true;
				
				return false;
			}else{
				error.push($(this));
			}
		});
		if(!cont2||!cont){
			alert(error[0].attr('name')+' is required');
			error[0].focus();
		}
		return (cont&&cont2);
	}
	function basepatdata(){
		$('#menu').prepend("<img id='img' src='image/ajax-loader.gif' />");
		$.post('g8user.php',{mrn:$('#mrn').val()},function(data){
			$('#mrnlabel').text('MRN: '+$('#mrn').val());
			$('#name').val($(data).find('name').text());
			$('#newic').val($(data).find('newic').text());
			$('#oldic').val($(data).find('oldic').text());
			$('#othno').val($(data).find('othno').text());
			$('#title').val($(data).find('title').text());
			$('#curaddr1').val($(data).find('curaddr1').text());$('#curaddr2').val($(data).find('curaddr2').text());$('#curaddr3').val($(data).find('curaddr3').text());
			$('#offaddr1').val($(data).find('offaddr1').text());$('#offaddr2').val($(data).find('offaddr2').text());$('#offaddr3').val($(data).find('offaddr3').text());
			$('#peraddr1').val($(data).find('peraddr1').text());$('#peraddr2').val($(data).find('peraddr2').text());$('#peraddr3').val($(data).find('peraddr3').text());
			$('#postcode').val($(data).find('postcode').text());$('#postcode2').val($(data).find('postcode2').text());$('#postcode3').val($(data).find('postcode3').text());
			$('#dob').val($(data).find('dob').text());
			$('#citizen').val($(data).find('citizen').text());
			$('#marital').val($(data).find('marital').text());
			$('#race').val($(data).find('race').text());
			$('#religion').val($(data).find('religion').text());
			$('#sex').val($(data).find('sex').text());
			$('#bloodgroup').val($(data).find('bloodgroup').text());
			$('#language').val($(data).find('language').text());
			$('#house').val($(data).find('house').text());
			$('#hp').val($(data).find('hp').text());
			$('#occupation').val($(data).find('occupation').text());
			$('#company').val($(data).find('company').text());
			$('#email').val($(data).find('email').text());
			$('#relcode').val($(data).find('relcode').text());
			$('#staffid').val($(data).find('staffid').text());
			$('#chno').val($(data).find('chno').text());
			$('#active').val($(data).find('active').text());
			$('#confidential').val($(data).find('confidential').text());
			$('#MRecord').val($(data).find('MRecord').text());
			$('#oldmrn').val($(data).find('oldmrn').text());
			$('#fstatus').val($(data).find('fstatus').text());
			$('#menu').children(':first').fadeOut('slow',function(){$(this).remove();});
		});
	}
	function addmenu(){
		$('input[type=text]').val('');
		$('input[type=field]').val('');
		$('textarea').val('');
		$('#determine').val('rgd');
		basemenu();
		enabletextfield();
		$('#addbut').attr('disabled',true);
		$('#updbut').attr('disabled',true);
		$('#canbut').attr('disabled',false);
		$('#savbut').attr('disabled',false);
	}
	function updmenu(){
		$('#determine').val('upd');
		basemenu();
		enabletextfield();
		$('#addbut').attr('disabled',true);
		$('#updbut').attr('disabled',true);
		$('#canbut').attr('disabled',false);
		$('#savbut').attr('disabled',false);
	}
	$('#addbut').click(function(){
		addmenu();
		if($('#mrn').val()!=''){
			$('#mrnlabel').text('');
		}
	});
	$('#updbut').click(function(){
		if($('#determine').val()=='upd'||$('mrn').val()!=''){
			updmenu()
		}else{
			alert('you come here by typing on url not clicking on link, so error will occur if continue update or saved');
		}
	});
	$('#canbut').click(function(){
		if($('#determine').val()=='rgd'){
			$('input[type=text]').val('');
			$('input[type=field]').val('');
			$('textarea').val('');
			basemenu();
			if($('#mrn').val()!=''){
				basepatdata();
				$('#updbut').attr('disabled',false);
			}
		}else if($('#determine').val()=='upd'){
			basepatdata();
			basemenu();
		}else{
			alert('you come here by typing on url not clicking on link, so error will occur if continue update or save');
		}
	});
	
	$('#savbut').click(function(){
		if(checkform()){
		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
		if($('#determine').val()=='rgd'){
			$.post('cr8user.php',$('#cr8user').serialize(),function(data){
				$msg=$(data).find('msg').text();
				$mrnfromsave=$(data).find('mrn').text();
				if($msg=='success'&&$mrnfromsave!=null){
					$.blockUI({ message: 'Save successfull!', onOverlayClick: $.unblockUI,
						css: {
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: .5, 
						color: '#fff',
					}});
					$('#mrn').val($mrnfromsave);
					$('#mrnlabel').text('MRN: '+$('#mrn').val());
					$('#determine').val('upd');
					basepatdata();
					basemenu();
				}
			});
		}else if($('#determine').val()=='upd'){
			$.post('upd8user.php',$('#cr8user').serialize(),function(data){
			$msg=$(data).find('msg').text();
			if($msg=='success'){
				$.blockUI({ message: 'Update successfull!', onOverlayClick: $.unblockUI,
					css: {
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff',
				} });
				basepatdata();
				basemenu();
			}
			});
		}
		}
		
	});
	$('.dialogbutton').parent().css('padding-left','0');
	$('.dialogbutton').parent().prev().css('padding-right','0');
});
</script>
<style>
textarea{
	width:300px;
	height:100px;
}
input[type=text],input[type=field]{
	width:95%;
}
#cr8user table{
	widows:100%
}
table td{

}
</style>
</head>
<body>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> Company: <?php echo $_SESSION['companyName'];?><a href="logout.php">  Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
            <div id="formmenu">
            <div id="menu">
            	<span id="pagetitle">Patient Registration</span>
           		<button type="button" onClick="window.close();" id="extbut"></button>
                <button type="button" id="canbut" ></button>
                <button type="button" id="updbut" ></button>
                <button type="button" id="addbut" ></button>
                <button type="button" id="savbut" ></button>
            </div>
            <input id="determine" value="<?php echo $_GET['det']; ?>" type="hidden"/>
            <form id="cr8user" method="post" name="cr8user" action="cr8user.php">
                <div class="alongdiv">
                    <div class="smalltitle"><p>Patient Information</p></div>
                    <div class="bodydiv"><input type="hidden" id="mrn" name="mrn" value="<?php echo $_GET['mrn']; ?>"/>
                    	<table>
                           	<tr>
                            <td><label id="mrnlabel"></label></td>
                            <td>Title:</td><td><input type="field" size='4' name="title" id="title"/></td><td><input type="button" value="..." class="dialogbutton" name="title" dg="titledg" load='0'/></td>
                            <td><label for="name">Name: </label></td><td width="65%"><input name="name" type="text" id="name" value='' size="60" class="req"/></td>
                            
                      	</table>
                    </div>
                </div>
                
                <div class="sideleft">
                    <div class="smalltitle"><p>Address</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            <div id="tabs">
                            	<ul>
                              	<li><a href="#curaddr">Current</a></li>
                                <li><a href="#offaddr">Office</a></li>
                                <li><a href="#peraddr">Permenant</a></li>
                              	</ul>
                                <div id="curaddr">
                                	<input type="text" name="curaddr1" id="curaddr1" size="70" class="req"/>
                                    <input type="text" name="curaddr2" id="curaddr2" size="70" class=""/>
                                    <input type="text" name="curaddr3" id="curaddr3" size="70" class=""/>
                                    <br/><br/>Postcode: <input type="text" name="postcode" id="postcode" class="req"/>
                                </div>
                                <div id="offaddr">
                                	<input type="text" name="offaddr1" id="offaddr1" size="70"/>
                                    <input type="text" name="offaddr2" id="offaddr2" size="70"/>
                                    <input type="text" name="offaddr3" id="offaddr3" size="70"/>
                                    <br/><br/>Postcode: <input type="text" name="postcode2" id="postcode2"/>
                                </div>
                                <div id="peraddr">
                                	<input type="text" name="peraddr1" id="peraddr1" size="70"/>
                                    <input type="text" name="peraddr2" id="peraddr2" size="70"/>
                                    <input type="text" name="peraddr3" id="peraddr3" size="70"/>
                                    <br/><br/>Postcode: <input type="text" name="postcode3" id="postcode3"/>
                                </div>
                             </div>	     
                            
                            </tr>
                        </table>
                  </div>
                </div>
                <div class="sideright">
                    <div class="smalltitle"><p>Other Information</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr><td>DOB: </td><td width="100%"><input type="text" name="dob" id="dob" class="req"/></td></tr>
                        </table>
                    	<table>
                        	<tr><td width="33%"><label for="newic">New IC: </label></td><td width="33%"><label for="newic">Old IC: </label></td><td width="33%"><label for="newic">Others No: </label></td></tr>
                            <tr><td width="33%"><input name="newic" type="text" id="newic"  value='' class="req2"/></td>
                            <td width="33%"><input name="oldic" type="text" id="oldic"  value='' class="req2"/></td>
                            <td width="33%"><input name="othno" type="text" id="othno"  value='' class="req2"/></td></tr>
                        </table>
                        <table>
                            <tr><td>Citizen: </td><td><input type="text" name="citizen" id="citizen" class="req"/></td><td><input type="button" value="..." class="dialogbutton" name="citizen" dg="citizendg" load='0'/></td></tr>
                            <tr><td>Marital: </td><td><input type="text" name="marital" id="marital"/></td></tr>
                        </table>
                        <table>	 
                        	<tr>
                            	<td width="15%">Race:</td><td><input type="field" size='4' name="race" id="race" class="req"/></td><td><input type="button" value="..." class="dialogbutton" name="racecode" dg="racedg" load='0'/></td>
                                <td width="15%">Religion:</td><td><input type="field" size='4' id="religion" name="religion" class="req"/></td><td><input type="button" value="..." name="religion" class="dialogbutton" dg="religiondg" load='0'/></td>
                          	</tr>
                            <tr>
                                <td>Blood Group:</td><td><input type="field" size='4' name="bloodgroup" id="bloodgroup" class="req"/></td><td><input type="button" value="..." class="dialogbutton" name="bloodgroup" dg="bloodgroupdg" load='0'/></td>
                            	<td>Language:</td><td><input type="field" size='4' name="language" id="language" class="req"/></td><td><input type="button" value="..." class="dialogbutton" name="languagecode" dg="languagedg" load='0'/></td>
                            </tr>
                            <tr><td width="15%">Sex:</td><td><select name="sex" id="sex" name="sex"><option>F</option><option>M</option></select></td></tr>  
                        </table>
                    </div>
                </div>
                
                <div class="sideleft">
                	<div class="smalltitle"><p>Phone Number</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            	<td>House</td><td><input type="text" name="house" id="house"/></td>
                            	<td>H/P</td><td><input type="text" name="hp" id="hp"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="alongdiv">
                    <div class="smalltitle"><p>Payer Information</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr><td>Occupation</td><td width="60%"><input type="text" name="occupation" id="occupation"/></td>
                            <td>Relationship Code:</td><td><input type="text" id="relcode" name="relcode"/></td></tr>
                            <tr><td>Company</td><td width="60%"><input type="text" name="company" id="company"/></td>
                            <td>Staff ID:</td> <td><input type="text" id="staffid" name="staffid"/></td></tr>
							<tr><td>E-mail</td><td width="60%"><input type="text" name="email" id="email"/></td>
                            <td>Child No:</td><td><input type="text" id="chno" name="chno"/></td></tr>
                        </table>
                    </div>
                </div>
                
                <div class="alongdiv">
                	<div class="smalltitle"><p>Patient Record</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            <td>Active<select name="active" id="active"><option>Yes</option><option>No</option></select></td>
                            <td>Confidential<select name="confidential" id="confidential"><option>Yes</option><option>No</option></select></td>
                            <td>Medical record<select name="MRecord" id="MRecord"><option>Yes</option><option>No</option></select></td>
                            <td>New MRN<input type="field" size='4' name="newmrn" id="newmrn"/></td>
                            <td>Old MRN<input type="field" size='4' name="oldmrn" id="oldmrn"/></td>
                            <td>Financial Status<input type="field" size='4' name="fstatus" id="fstatus"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        	</div>
	<div id="citizendg"></div> 
    <div id="religiondg"></div>
    <div id="titledg"></div>
    <div id="bloodgroupdg"></div>
    <div id="racedg"></div>
    <div id="languagedg"></div>    
</body> 
 	</html>
