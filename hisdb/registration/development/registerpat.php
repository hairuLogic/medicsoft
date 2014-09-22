<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
	$valid=false;
	if(isset($_GET['mrn'])){
		$valid=true;
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Patient Registration</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(function(){
	var thiz,table,basepat;
	$('#pageinfoin').hide();
	$('#pageinfotog').click(function(){
		$('#pageinfoin').slideToggle('fast');
	});
	if($('#determine').val()=='upd'){
		basepatdata();
		basemenu();
	}else if($('#determine').val()=='rgd'){
		awaladdmenu();
	}else{
	}
	function perdis(){
		$('[perdis]').attr('disabled',true);
	}
	function disabletextfield(){
		$('input').attr('disabled',true);
		$('select').attr('disabled',true);
		perdis();
	}
	function enabletextfield(){
		$('input').attr('disabled',false);
		$('select').attr('disabled',false);
		perdis();
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
	$("#newic").blur(function(){
		var pdate=$('#newic').val();
		if(pdate!=''&&pdate!='______-__-____'){
			var py=pdate.substr(0,2);
			if(parseInt(py)>20){
				var npy='19'+py;
			}else{
				var npy='20'+py;
			}
			var pm=pdate.substr(2,2);
			var pd=pdate.substr(4,2);
			getAge(pd+'-'+pm+'-'+npy,true);
		}else{
			$('#dob,#year,#month,#day').val('');
		}
	});
	$('#dob').blur(function(){
		var dob=$(this).val();
		if(dob!=''&&dob!='__-__-____'){
			getAge(dob,false);
		}else{
			$('#dob,#year,#month,#day').val('');
		}
	});
	$('#dg,#verdg').dialog({autoOpen:false,modal:true});
	$( "#dg" ).on( "dialogclose", function( event, ui ) {$('#dg').children('#dgres').html('');} );
	$( "#verdg" ).on( "dialogclose", function( event, ui ) {$('#verdg').children('#versel').html('');} );
	$('.dialogbutton').click(function(){
		thiz=$(this);
		table=$(this).attr('table');
		var title=$(this).attr('title');
		$('#dg').dialog('option','title',title);
		$('#dg').dialog('open');
		dgsearch();
	});
	function dgsearch(y,x){
		$.get('tablegrey.php',{table:table,fld:y,txt:x},function(data){
			var append="<div class='alldgdiv'><table class='grey'><tr><th>Code</th><th>Description</th></tr>";
			$.each(data,function(i,item){
				append+="<tr class='pointer' index='"+i+"'><td>"+item['code']+"</td><td>"+item['description']+"</td></tr>";
			});
			append+='</table></div>';
			$('#dg').children('#dgres').html(append);
			$('.pointer').on('click',function(event){
				var index=parseInt($(this).attr('index'));
				var code=data[index]['code'];
				var description=data[index]['description'];
				thiz.prev().val(description);
				thiz.prev().prev().val(code);
				$(dg).dialog('close');
				thiz=null;
			});
		},'json');
	}
	$('#dgtxt').keyup(function(e){
		var x=$(this).val();
		var y=$('#dgfld').val();
		dgsearch(y,x);
	});
	$("#postcode,#postcode2,#postcode3").mask('99999');
	$("#dob").mask('99-99-9999');
	$("#newic").mask('999999-99-9999');
	$("#hp").mask('999-9999999');
	$("#house").mask('99-99999999');
	$("#citizen,#language,#bloodgroup,#religion,#race").mask('a?aaa');
	function checkform(x,y){
		var cont=true;
		var error=[];
		if(y==2){cont=false;
			$('input['+x+']').each(function(){
				if($(this).val()==''){
					error.push($(this));
				}else if($(this).val()!=''){
					cont=true;
				}
			});
		}else{
			$('input['+x+']').each(function(){
				if($(this).val()==''){
					cont=false;
					error.push($(this));
				}
			});
		}
		if(!cont){
			alert(error[0].attr('name')+' is required');
			error[0].focus();
		}
		return cont;
	}
	function basepatdata(){
		$('#menu').prepend("<img id='img' src='../image/ajax-loader.gif' />");
		$.post('g8user.php',{mrn:$('#mrn').val()},function(data){
			$('#mrnlabel').val($('#mrn').val());
			basepat=data;
			$('#name').val(data.name);
			$('#newic').val(data.newic);
			$('#oldic').val(data.oldic);
			$('#othno').val(data.othno);
			$('#title').val(data.title);
			$('#curaddr1').val(data.curaddr1);$('#curaddr2').val(data.curaddr2);$('#curaddr3').val(data.curaddr3);
			$('#offaddr1').val(data.offaddr1);$('#offaddr2').val(data.offaddr2);$('#offaddr3').val(data.offaddr3);
			$('#peraddr1').val(data.peraddr1);$('#peraddr2').val(data.peraddr2);$('#peraddr3').val(data.peraddr3);
			$('#postcode').val(data.postcode);$('#postcode2').val(data.postcode2);$('#postcode3').val(data.postcode3);
			$('#dob').val(data.dob);
			if(data.dob!=''){
				getAge(data.dob,false);
			}
			$('#area').val(data.areacode);
			$('#citizen').val(data.citizen);
			$('#marital').val(data.marital);
			$('#race').val(data.race);
			$('#religion').val(data.religion);
			$('#sex').val(data.sex);
			$('#bloodgroup').val(data.bloodgroup);
			$('#language').val(data.language);
			$('#house').val(data.house);
			$('#hp').val(data.hp);
			$('#telo').val(data.telo);
			$('#occupation').val(data.occupation);
			$('#company').val(data.company);
			$('#email').val(data.email);
			$('#relcode').val(data.relcode);
			$('#staffid').val(data.staffid);
			$('#chno').val(data.chno);
			$('#active').val(data.active);
			$('#confidential').val(data.confidential);
			$('#MRecord').val(data.MRecord);
			$('#oldmrn').val(data.oldmrn);
			$('#fstatus').val(data.fstatus);
			ckall();
			$('#menu').children(':first').fadeOut('slow',function(){$(this).remove();});
		},'json');
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
		awaladdmenu();
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
		if(checkform('req')){
		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
		alert($('#cr8user').serialize());
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
					$('#mrn').val($mrnfromsave);$('#mrnlabel').val($mrnfromsave);
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
	function getAge(dateString,i){
		newds=dateString.split('-');
		var pyear,pmonth,pday;
		var today = new Date();
		var birthDate = new Date(newds[2]+'-'+newds[1]+'-'+newds[0]);
		pyear = today.getFullYear() - birthDate.getFullYear();
		pmonth = today.getMonth() - birthDate.getMonth();
		if (pmonth < 0 || (pmonth === 0 && today.getDate() < birthDate.getDate())){pyear--;}
		if(today.getDate() < birthDate.getDate()){pmonth-=1;}
		if(pmonth<0){pmonth+=12;}
		pday=today.getDate() - birthDate.getDate();
		if(pday<0){var x=getNumberOfDays(today.getYear(),today.getMonth());pday+=x;}
		$('#year').val(pyear);$('#month').val(pmonth);$('#day').val(pday);
		if(i)$('#dob').val(dateString);
	}
	function getNumberOfDays(year,month) {
		var isLeap = ((year % 4) == 0 && ((year % 100) != 0 || (year % 400) == 0));
		return [31, (isLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
	}
	$('[ck]').blur(function(){
		ck($(this).attr('id'));
	});
	function ckall(){
		$('[ck]').each(function(){
			ck($(this).attr('id'));			
		});
	}
	function awaladdmenu(){
		addmenu();
		$("input,select").attr('disabled',true);
		$("#alongdivatas input,#verdg input").attr('disabled',false);
		perdis();
	}
	function ck(inp){
		if($(inp).val()!=''&&$(inp).val()!='____'){
			inp='#'+inp;
			$.get('ck.php',{table:$(inp).next().next().attr('table'),txt:$(inp).val()},function(data){$(inp).next().val(data);},'json');
		}
	}
	//$('#curaddr1').keyup(function(){alert('asd')});
	$('#verify').click(function(){
		if(checkform('req2',2)){
			$('#verdg').dialog('open');
			var ic=$('#newic').val(), othno = $('#othno').val(), name=$('#name').val();
			$.get('verify.php',{ic:ic,othno:othno},function(data){
				if(data.msg=='got'){var schema="<div class='alldgdiv'><table class='grey'><tr><th>MRN</th><th>Name</th></tr>";
					$.each(data.pat,function(i,item){
						schema+="<tr class='pointer' index='"+i+"'><td>"+item['mrn']+"</td><td>"+item['name']+"</td></tr>";
					});schema+="</table></div>";
				}else if(data.msg=='not'){
					var schema="<div class='alldgdiv'>No data in database</div>";
				}
				$('#verdg').children('#versel').html(schema);
				$('.pointer').on('click',function(event){
					var index=parseInt($(this).attr('index'));
					var mrn=data.pat[index]['mrn'];
					updmenu();
					$('#mrn').val(mrn);basepatdata();
					$('#verdg').dialog('close');
				});
				$('#vernew').on('click',function(event){
					addmenu();
					$('#newic').val(ic); $('#othno').val(othno);$('#name').val(name);
					$('#verdg').dialog('close');
				})
			},'json');		
		}
	});
});
</script>
<style>
.bodydiv{
	overflow:auto;
}
.wrapper{
	width:100%;
	clear:both;
	overflow:auto;
}
textarea{
	width:300px;
	height:100px;
}
input[type=text],input[type=field]{
}
#cr8user table{
	widows:100%
}
.block{
	overflow:auto;
	float:left;
	padding:1%;
}
.block label{
	display:inline-block;
	width:19%;
	padding-right:1%;
}
.block input[type=button]{
	width:19%;
	padding-right:1%;	
}
#dgbdy label{
	padding-right: 1%;
	width: 30% !important;
}
#dgbdy input[type=field]{
	width: 15% !important;
}
#dgbdy input[type=text]{
	margin-left: 1% !important;
	width: 35% !important;
}
#dgbdy input[type=button]{
	margin-left: 1% !important;
	width: 10% !important;
}
#dgtxt,#dgfld{
	font-size:12px;
	width:100%;
}#dgsrch{
	background-color:#FFFFCC;
	padding:5px;
	margin-top:10px;
	border:thin solid #666666;
}
#tabs input[type=text]{
	width:90%;
}
#vermen input[type=button]{
	margin-top:10px;
	font-size:14px
}
</style>
</head>
<body><span id="pagetitle">Patient Demographic</span>
	<div id="pageinfo">
		<div id="pageinfoin">User: <?php echo $_SESSION['username'];?> | Company: <?php echo $_SESSION['companyName'];?><a href="logout.php"> | Log out</a></div>
        <div id="pageinfotog">PageInfo</div>
    </div>
            <div id="formmenu">
            <div id="menu">
           		<button type="button" onClick="window.close();" id="extbut"></button>
                <button type="button" id="canbut" ></button>
                <button type="button" id="updbut" ></button>
                <button type="button" id="addbut" ></button>
                <button type="button" id="daypbut" ></button>
                <button type="button" id="inpbut" ></button>
                <button type="button" id="outpbut" ></button>
                <button type="button" id="savbut" ></button>
            </div>
            <input id="determine" value="<?php echo $_GET['det']; ?>" type="hidden"/>
            <form id="cr8user" method="post" name="cr8user" action="cr8user.php">
                <div class="alongdiv" id="alongdivatas">
                    <div class="smalltitle"><p>Patient Information</p></div>
                    <div class="bodydiv">
                        <div class="wrapper">
                        	<div class="block" style="width:15%"><label style="width:30%">MRN</label>
                            	<input type="hidden" id="mrn" name="mrn" value="<?php echo $_GET['mrn']; ?>">
                        	  	<input type="field" perdis id="mrnlabel" style="width:60%" value="<?php echo $_GET['mrn']; ?>">
                        	</div>
                        	<div class="block" style="width:25%"><label for="title" style="width:10%">Title</label>
                                <input style="width:20%;" type="field" name="title" id="title" ck/><input style="width: 35%;margin-left:1%	" type="text" perdis>
                                <input style="width:20%;" type="button" value="..." class="dialogbutton" table="title" title="Title Selection"/></div>
                            <div class="block" style="width:54%"><label for="name" style="width:7%">Name</label>
                                <input style="width:86%;" name="name" type="text" id="name" value='' req/></div>
                        </div>
                    		
                      	<div class="wrapper">
                        	<div class="block" style="width:38%"><label style="width:10%">I/C</label><input style="width:78%" name="newic" type="text" id="newic"  value='' req2/></div>
                            <div class="block" style="width:58%"><label style="width:15%">Other No.</label><input style="width:79%" name="othno" type="text" id="othno"  value='' req2></div>
                        </div>
                        
                        <div class="wrapper" style="background:#CCCCCC; margin:1%; width:98%; border-radius: 5px">
                        	<div class="block" style="width:47%"><label>DOB</label><input style="width:90%" type="field" name="dob" id="dob" req/></div>
                            <div class="block" style="width:15%"><label>Year</label><input style="width:90%" type="field" id="year" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Month</label><input style="width:90%" type="field" id="month" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Day</label><input style="width:90%" type="field" id="day" size="4" perdis/></div>
                        </div>
                        <div class="wrapper"><input type="button" value="verify" id="verify" class="orgbut" style="float:right;margin-right:5px;margin-bottom:5px"/></div>
                    </div>
                </div>
                

                <div class="sideleft">
                    <div class="smalltitle"><p>Address</p></div>
                    <div class="bodydiv">
                        <div id="tabs">
                            <ul>
                            <li><a href="#curaddr">Current</a></li>
                            <li><a href="#offaddr">Office</a></li>
                            <li><a href="#peraddr">Permenant</a></li>
                            </ul>
                            <div id="curaddr">
                                <input type="text" name="curaddr1" id="curaddr1"  req/>
                                <input type="text" name="curaddr2" id="curaddr2"  class=""/>
                                <input type="text" name="curaddr3" id="curaddr3"  class=""/>
                                <br/><br/>Postcode: <input type="text" name="postcode" id="postcode" class="req"/>
                            </div>
                            <div id="offaddr">
                                <input type="text" name="offaddr1" id="offaddr1" />
                                <input type="text" name="offaddr2" id="offaddr2" />
                                <input type="text" name="offaddr3" id="offaddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode2" id="postcode2"/>
                            </div>
                            <div id="peraddr">
                                <input type="text" name="peraddr1" id="peraddr1" />
                                <input type="text" name="peraddr2" id="peraddr2" />
                                <input type="text" name="peraddr3" id="peraddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode3" id="postcode3"/>
                            </div>
                         </div>
                         <div class="block" style="width:98%">
                            <label>Area:</label><input style="width:10%;" type="field" name="area" id="area" req ck/>
                            <input type="text" perdis style="width:50%;">
                            <input type="button" value="..." class="dialogbutton" table="areacode" title="Area Selection" style="width:5%;"/>
                        </div>
                  </div>
                </div>
                
                <div class="sideright" id="dgbdy">
                	<div class="smalltitle"><p>Other Information</p></div>
                    <div class="bodydiv">
                        <div class="wrapper">
                        	<div class="block" style="width:48%">
                            	<label>Citizen:</label><input type="field" name="citizen" id="citizen" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="citizen" title="Citizen Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	 <label>Race:</label><input type="field" name="race" id="race" req ck/>
                                 <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="racecode" title="Race Selection"/>
                            </div>
                        	<div class="block" style="width:48%">
                            	<label>Religion:</label><input type="field" id="religion" name="religion" req ck/>
                                <input type="text" perdis><input type="button" value="..." table="religion" class="dialogbutton" title="Religion Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	<label>Blood Group:</label><input type="field" name="bloodgroup" id="bloodgroup" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="bloodgroup" title="Blood Group Selection">
                            </div>
                            <div class="block" style="width:48%">
                            	<label>Language:</label><input type="field" name="language" id="language" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="languagecode" title="Language Selection"/>
                            </div>
                        </div>
                        
                        <div class="wrapper">
                        	<div class="block" style="width:48%">Sex:<select name="sex" id="sex"><option>F</option><option>M</option></select></div>
                            <div class="block" style="width:48%">Marital:<select name="marital" id="marital"><option>M</option><option>S</option></select></div>
                        </div>
               		</div>         
                </div>
                
                <div class="sideright">
                	<div class="smalltitle"><p>Phone Number</p></div>
                    <div class="bodydiv">
                    	<div class="block" style="width:31%"><label>House</label><input style="width:92%" type="text" name="house" id="house"/></div>
                        <div class="block" style="width:31%"><label>H/P</label><input style="width:92%" type="text" name="hp" id="hp"/></div>
                        <div class="block" style="width:31%"><label>Office</label><input style="width:92%" type="text" name="telo" id="telo"/></div>
                    </div>
                </div>
                
                <div class="alongdiv">
                    <div class="smalltitle"><p>Payer Information</p></div>
                    <div class="bodydiv">
                    	<div id="wrapper" style="width:59%;clear:none;float:left">
                        	<div class="block" style="width:100%">
                                <label>Occupation</label><input style="width:10%;" type="field" name="occupation" id="occupation" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="occupation" title="Occupation Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%">
                                <label>Company</label><input style="width:10%;" type="field" name="company" id="company" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="companycode" title="Company Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%"><label>E-mail</label><input type="text" name="email" id="email"/></div>
                        </div>
                        
                        <div id="wrapper" style="width:39%;clear:none;float:left">
                        	<div class="block" style="width:100%"><label>Relationship Code</label><input style="width:60%" type="text" id="relcode" name="relcode"/></div>
                            <div class="block" style="width:100%"><label>Staff ID</label><input style="width:60%" type="text" id="staffid" name="staffid"/></div>
                            <div class="block" style="width:100%"><label>Child No</label><input style="width:60%" type="text" id="chno" name="chno"/></div>
                        </div>
                        	
                            
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
    
    <div id="dg" title="">
        <div id="dgres"></div>
        <div id="dgsrch">
            <select id="dgfld"><option>Code</option><option selected>Description</option></select>
            <input type="text" id="dgtxt"/>
    </div>
    <div id="verdg" title="Name Verification">
    	<div id='versel'></div>
        <div id='vermen'>
        	<input type="button" value="new mrn" id="vernew" class="orgbut"/>
        </div>
    </div>
</div>   
</body> 
 </html>
