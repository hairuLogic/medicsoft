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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Registration</title>
<link href="../css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="../css/reset.css" type="text/css"  />
<link href="../css/formcss.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.1.custom.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/jquery.inputmask.js"></script>
<script src="../js/jquery.mb.browser.min.js"></script>
<script src="patregistrationjs.js"></script>
<script>
$(function(){
	var thiz,table,wrongic;
	$("#postcode,#postcode2,#postcode3").mask('99999?');
	//$("#dob").mask('?99-99-9999');
	$("#newic").inputmask({"mask": "999999-99-9999"});
	$('#pageinfoin,#imgmk,#read').hide();
	if(!jQuery.browser.msie){
		$('#mykbut2').hide();
	}
	$('#dob').datepicker({
		onSelect: function(date){
			getAge(date,false);
		},
		changeMonth: true,
      	changeYear: true,
		showOn:"button",
		buttonImage: "../image/datepicker.gif",
		buttonImageOnly: true,
		dateFormat: "dd-mm-yy"
	});
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
		$('#dob').datepicker("option",{disabled:true});
		$('input').attr('disabled',true);
		$('select').attr('disabled',true);
		perdis();
	}
	function enabletextfield(){
		$('#dob').datepicker("option",{disabled:false});
		$('input').attr('disabled',false);
		$('select').attr('disabled',false);
		perdis();
	}
	function basemenu(){
		disabletextfield();
		$('#addbut2').attr('disabled',false);
		$('#updbut2').attr('disabled',true);
		$('#canbut2').attr('disabled',true);
		$('#savbut2').attr('disabled',true);
		$('#delbut').attr('disabled',true);
		$('#inpbut').attr('disabled',true);
		$('#daypbut').attr('disabled',true);
		$('#outpbut').attr('disabled',true);
		if($('#determine').val()=='upd'){
			$('#updbut2').attr('disabled',false);
			$('#inpbut').attr('disabled',false);
			$('#daypbut').attr('disabled',false);
			$('#outpbut').attr('disabled',false);}
	}
	$("#tabs").tabs();
	$("#newic").keydown(function(e){
		if(e.which==9){var pdate=$('#newic').val();icblur(pdate,true,true);}
	});
	$("#newic").blur(function(){
		var pdate=$('#newic').val();icblur(pdate,true,false);
	});
	function icblur(pdate,x,y){
		if(pdate!=''&&pdate!='______-__-____'&&pdate.indexOf("_") == -1){
			var py=pdate.substr(0,2);
			if(parseInt(py)>20){
				var npy='19'+py;
			}else{
				var npy='20'+py;
			}
			var pm=pdate.substr(2,2);
			var pd=pdate.substr(4,2);
			getAge(pd+'-'+pm+'-'+npy,x,y);
		}else{
			if(y){if(pdate.indexOf("_") != -1){alert('wrong i/c');$('#newic').focus();}}
			$('#dob,#year,#month,#day').val('');
		}
	}
	function getAge(dateString,i,x){
		newds=dateString.split('-');
		var pyear,pmonth,pday;
		if(newds[1]>12||newds[1]<1){$('#dob,#year,#month,#day').val('');wrongic=true;if(x){alert('wrong i/c');$('#newic').focus();}return 0;}
		if(newds[0]>31||newds[0]<1){$('#dob,#year,#month,#day').val('');wrongic=true;if(x){alert('wrong i/c');$('#newic').focus();}return 0;}
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
		if(i)$('#dob').val(dateString);wrongic=false;
	}
	function getNumberOfDays(year,month) {
		var isLeap = ((year % 4) == 0 && ((year % 100) != 0 || (year % 400) == 0));
		return [31, (isLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
	}
	/*$('#dob').blur(function(){
		var dob=$(this).val();
		if(dob!=''&&dob!='__-__-____'){
			getAge(dob,false);
		}else{
			
		}
	});*/
	$('#dg,#verdg').dialog({autoOpen:false,modal:true});
	$( "#dg" ).on( "dialogclose", function( event, ui ) {$('#dg').children('#dgres').html('');$('#dgtxt').val('');} );
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
				append+="<tr class='pointer' index='"+i+"'><td>"+item[0]+"</td><td>"+item[1]+"</td></tr>";
			});
			append+='</table></div>';
			$('#dg').children('#dgres').html(append);
			$('.pointer').on('click',function(event){
				var index=parseInt($(this).attr('index'));
				var code=data[index][0];
				var description=data[index][1];
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
	function checkform(x,y){
		var cont=true;
		var error=[];
		if(y==2){cont=false;var ic=$('#newic').val();
			if(wrongic){alert("Wrong i/c");$('#newic').focus();cont=false;}else{
				if(ic.indexOf("_") != -1){error.push($('#newic'));cont=false;}else{
					if($('#name').val()==''){error.push($('#name'));cont=false;}
					else{
						$('input['+x+']').each(function(){
							if($(this).val()==''){
								error.push($(this));
							}else if($(this).val()!=''){
								cont=true;
							}
						});	
					}
				}	
			}
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
	function checkdgcode(x){
		var cont=true;var error=[];
		$('input['+x+'][req]').each(function(){
			if($(this).next().val()==''){
				cont=false;
				error.push($(this));
			}
		});
		if(!cont){
			alert(error[0].attr('name')+' code is wrong');
			error[0].focus();
		}
		return cont;
	}
	function basepatdata(){
		$('#menu').prepend("<img id='img' src='../image/ajax-loader.gif' />");
		$.post('jgn tukar/g8user.php',{mrn:$('#mrn').val()},function(data){
			$('#mrnlabel').val($('#mrn').val());
			$('#name').val($(data).find('name').text());$('#newic').attr('disabled',false);
			$('#newic').val($(data).find('newic').text());$('#newic').attr('disabled',true);
			$('#oldic').val($(data).find('oldic').text());
			$('#othno').val($(data).find('othno').text());
			$('#title').val($(data).find('title').text());
			$('#curaddr1').val($(data).find('curaddr1').text());$('#curaddr2').val($(data).find('curaddr2').text());$('#curaddr3').val($(data).find('curaddr3').text());
			$('#offaddr1').val($(data).find('offaddr1').text());$('#offaddr2').val($(data).find('offaddr2').text());$('#offaddr3').val($(data).find('offaddr3').text());
			$('#peraddr1').val($(data).find('peraddr1').text());$('#peraddr2').val($(data).find('peraddr2').text());$('#peraddr3').val($(data).find('peraddr3').text());
			$('#postcode').val($(data).find('postcode').text());$('#postcode2').val($(data).find('postcode2').text());$('#postcode3').val($(data).find('postcode3').text());
			$('#dob').val($(data).find('dob').text());
			if($(data).find('dob').text()!=''&&$(data).find('dob').text()!='00-00-0000'){
				getAge($(data).find('dob').text(),false);
			}
			$('#area').val($(data).find('areacode').text());
			$('#citizen').val($(data).find('citizen').text());
			$('#marital').val($(data).find('marital').text());
			$('#race').val($(data).find('race').text());
			$('#religion').val($(data).find('religion').text());
			$('#sex').val($(data).find('sex').text());
			$('#bloodgroup').val($(data).find('bloodgroup').text());
			$('#language').val($(data).find('language').text());
			$('#house').val($(data).find('house').text());
			$('#hp').val($(data).find('hp').text());
			$('#telo').val($(data).find('telo').text());
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
			ckall();
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
		$('#addbut2').attr('disabled',true);
		$('#updbut2').attr('disabled',true);
		$('#canbut2').attr('disabled',false);
		$('#savbut2').attr('disabled',false);
		$('#inpbut').attr('disabled',true);
		$('#daypbut').attr('disabled',true);
		$('#outpbut').attr('disabled',true);
	}
	function updmenu(){
		$('#determine').val('upd');
		basemenu();
		enabletextfield();
		$('#addbut2').attr('disabled',true);
		$('#updbut2').attr('disabled',true);
		$('#canbut2').attr('disabled',false);
		$('#savbut2').attr('disabled',false);
		$('#inpbut').attr('disabled',false);
		$('#daypbut').attr('disabled',false);
		$('#outpbut').attr('disabled',false);
		
	}
	$('#addbut2').click(function(){
		awaladdmenu();
	});
	$('#updbut2').click(function(){
		if($('#determine').val()=='upd'||$('mrn').val()!=''){
			updmenu()
		}else{
			alert('you come here by typing on url not clicking on link, so error will occur if continue update or saved');
		}
	});
	$('#canbut2').click(function(){
		if($('#determine').val()=='rgd'){
			$('input[type=text]').val('');
			$('input[type=field]').val('');
			$('textarea').val('');
			basemenu();
			if($('#mrn').val()!=''){
				basepatdata();
				$('#updbut2').attr('disabled',false);
				$('#inpbut').attr('disabled',false);
				$('#daypbut').attr('disabled',false);
				$('#outpbut').attr('disabled',false);
			}
		}else if($('#determine').val()=='upd'){
			basepatdata();
			basemenu();
		}else{
			alert('you come here by typing on url not clicking on link, so error will occur if continue update or save');
		}
	});
	$('#savbut2').click(function(){
		if(checkform('req2',2)&&checkform('req')&&checkdgcode('ck')){
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
			$.post('jgn tukar/cr8user.php',$('#cr8user').serialize(),function(data){
				$msg=$(data).find('msg').text();
				$mrnfromsave=$(data).find('mrn').text();
				if($msg=='success'&&$mrnfromsave!=null){
					$.unblockUI();
					$('#mrn').val($mrnfromsave);$('#mrnlabel').val($mrnfromsave);
					$('#determine').val('upd');
					basepatdata();
					basemenu();
				}
			});
		}else if($('#determine').val()=='upd'){
			$.post('jgn tukar/upd8user.php',$('#cr8user').serialize(),function(data){
			$msg=$(data).find('msg').text();
			if($msg=='success'){
				$.unblockUI();
				basepatdata();
				basemenu();
			}
			});
		}
		}
	});
	$('[ck]').keydown(function(e){
		if($.trim($(this).val())!=''&&e.which==9){
			ck($(this).attr('id'),true);
		}
	});
	function ckall(){
		$('[ck]').each(function(){
			ck($(this).attr('id'));			
		});
	}
	function awaladdmenu(){
		addmenu();
		$("input,select").attr('disabled',true);
		$("#alongdivatas input,#verdg input,#dgtxt,#dgfld").attr('disabled',false);
		perdis();
	}
	function ck(inp,nakAlert){
		inp='#'+inp;
		$.get('ck.php',{table:$(inp).next().next().attr('table'),txt:$(inp).val()},function(data){
			if(data=='fail'){
				if(nakAlert){
					alert('Wrong '+$(inp).attr('name')+' code');$(inp).focus();
				}
				$(inp).next().val('');
			}else{
				$(inp).next().val(data);
			}
		},'json');
	}
	function vernew(ic,othno,name,dob,year,month,day){
		addmenu();
		$('#newic').val(ic); $('#othno').val(othno);$('#name').val(name),$('#dob').val(dob),$('#year').val(year),$('#month').val(month),$('#day').val(day);
		$('#curaddr1').focus();
	}
	$('#verify').click(function(){
		if(checkform('req2',2)){
			var ic=$('#newic').val(),othno=$('#othno').val(),name=$('#name').val(),dob=$('#dob').val(),year=$('#year').val(),month=$('#month').val(),day=$('#day').val();
			$.get('jgn tukar/verify.php',{ic:$.trim(ic),othno:othno},function(data){
				if(data.msg=='got'){var schema="<div class='alldgdiv'><table class='grey'><tr><th>MRN</th><th>Name</th></tr>";
					$.each(data.pat,function(i,item){
						schema+="<tr class='pointer' index='"+i+"'><td>"+item['mrn']+"</td><td>"+item['name']+"</td></tr>";
					});schema+="</table></div>";
					$('#verdg').dialog('open');
				}else if(data.msg=='not'){
					vernew(ic,othno,name,dob,year,month,day);
				}
				$('#verdg').children('#versel').html(schema);
				$('.pointer').on('click',function(event){
					var index=parseInt($(this).attr('index'));
					var mrn=data.pat[index]['mrn'];
					updmenu();
					$('#mrn').val(mrn);basepatdata();
					$('#verdg').dialog('close');
				});
				$('#vernew').on('click',function(event){vernew(ic,othno,name,dob,year,month,day);$('#verdg').dialog('close');})
			},'json');		
		}
	});
	$('#mykbut2').click(function(){
		if($("#alongdivatas .bodydiv #imgmk").is(":hidden")){
			$("#alongdivatas .bodydiv #animate").animate({width:"88%"},500,function(){
				$("#alongdivatas .bodydiv #imgmk").show();$("#read").show();
			});	
		}else{
			$("#alongdivatas .bodydiv #imgmk").hide();$("#read").hide();
			$("#alongdivatas .bodydiv #animate").animate({width:"98%"},500);
		}
		
	});
	$('#plistbut').click(function(){
		window.open('patregistration.php',"_self");
	});
});
</script>
<style>
.bodydiv{
	overflow:auto;
}
.wrapper2{
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
#dgbdy .dialogbutton{
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
input[type=text]:focus,input[type=field]:focus{
	background-color:#E0F0FF;
}
#tabs input[type=text]{
	width:90%;
}
#vermen input[type=button]{
	margin-top:10px;
	font-size:14px
}
#animate{
	float:left;
	width:98%;
}
#imgmk{
	border-color:#33CCFF;
	border-style:outset;
	border-width:3px;
	float:right;
	margin:3px;
}
</style>
</head>
<body><?php include("../../include/header.php")?><span id="pagetitle">Membership Demographic</span>
            <div id="formmenu">
            <div id="menu">
           		<button type="button" onClick="window.close();" id="extbut"></button>
                <button type="button" id="canbut2" ></button>
                <button type="button" id="updbut2" ></button>
                <button type="button" id="addbut2" ></button>
                <button type="button" id="daypbut" ></button>
                <button type="button" id="inpbut" ></button>
                <button type="button" id="outpbut" ></button>
                <button type="button" id="mykbut2" >mykad</button>
                <button type="button" id="savbut2" ></button>
                <button type="button" id="plistbut" >Patient List</button>
            </div>
            <input id="determine" value="<?php echo $_GET['det']; ?>" type="hidden"/>
            <form id="cr8user" method="post" name="cr8user" action="jgn tukar/cr8user.php">
                <div class="alongdiv" id="alongdivatas">
                    <div class="smalltitle"><p>Membership Information</p></div>
                    <div class="bodydiv">
                        <div id="animate"><div class="wrapper2">
                        	<div class="block" style="width:15%"><label style="width:30%">MRN</label>
                            	<input type="hidden" id="mrn" name="mrn" value="<?php echo $_GET['mrn']; ?>">
                        	  	<input type="field" perdis id="mrnlabel" style="width:60%" value="<?php echo $_GET['mrn']; ?>">
                        	</div>
                        	<div class="block" style="width:25%"><label for="title" style="width:10%">Title</label>
                                <input style="width:20%;" type="field" name="title" id="title" ck/><input style="width: 35%;margin-left:1%	" type="text" perdis>
                                <input style="width:20%;" type="button" value="..." class="dialogbutton" table="title" title="Title Selection"/></div>
                            <div class="block" style="width:54%"><label for="name" style="width:7%">Name</label>
                                <input style="width:86%;" name="name" type="text" id="name" value='' req /></div>
                        </div>
                    		
                      	<div class="wrapper2" style="width:48%; margin:1%; clear:none; float:left" >
                        	<div class="block" style="width:38%"><label style="width:15%">I/C</label><input style="width:85%" name="newic" type="text" id="newic"  value='' req2/></div>
                            <div class="block" style="width:58%"><label style="width:30%">Other No.</label><input style="width:85%" name="othno" type="text" id="othno"  value='' req2></div>
                        </div>
                        
                        <div class="wrapper2" style="background:#CCCCCC; margin:1% 1% 1% 0%; width:48%; border-radius: 5px; clear:none; float:left">
                        	<div class="block" style="width:47%"><label>DOB</label><input style="width:88%" type="field" name="dob" id="dob" readonly req/></div>
                            <div class="block" style="width:15%"><label>Year</label><input style="width:90%" type="field" id="year" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Month</label><input style="width:90%" type="field" id="month" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Day</label><input style="width:90%" type="field" id="day" size="4" perdis/></div>
                        </div>
                        <div class="wrapper2">
                        	<input type="button" value="verify" id="verify" class="orgbut" style="float:right;margin-right:5px;margin-bottom:5px"/>
                        	<input type="button" value="Read MyCard" class="orgbut" onClick="try2()" id="read" style="float:right;margin-right:5px;margin-bottom:5px">
                        </div></div>
                        <img name="" src="../image/mykad1.png" width="100" height="150" alt="" id="imgmk">
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
                                <br/><br/>Postcode: <input type="text" name="postcode" id="postcode" req/>
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
                        <div class="wrapper2">
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
                        
                        <div class="wrapper2">
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
                    	<div id="wrapper2" style="width:59%;clear:none;float:left">
                        	<div class="block" style="width:100%">
                                <label>Occupation</label><input style="width:10%;" type="field" name="occupation" id="occupation" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="occupation" title="Occupation Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%">
                                <label>Company</label><input style="width:10%;" type="field" name="company" id="company" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="debtormast" title="Company Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%"><label>E-mail</label><input type="text" name="email" id="email" style="width:71%"/></div>
                        </div>
                        
                        <div id="wrapper2" style="width:39%;clear:none;float:left">
                        	<div class="block" style="width:100%">
                            	<label>Relationship Code</label><input style="width:10%" type="field" id="relcode" name="relcode" ck/>
                                <input type="text" perdis style="width:50%;">
                               	<input type="button" value="..." class="dialogbutton" table="relatcode" title="Relationship Code Selection" style="width:5%;"/>
                           	</div>
                            <div class="block" style="width:100%"><label>Staff ID</label><input style="width:61%" type="text" id="staffid" name="staffid"/></div>
                            <div class="block" style="width:100%"><label>Child No</label><input style="width:61%" type="text" id="chno" name="chno"/></div>
                        </div>
                        	
                            
                    </div>
                </div>
                
                <div class="alongdiv">
                	<div class="smalltitle"><p>Membership Record</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            <td>Active<select name="active" id="active" perdis><option>Yes</option><option>No</option></select></td>
                            <td>Confidential<select name="confidential" id="confidential" perdis><option>Yes</option><option>No</option></select></td>
                            <td>Medical record<select name="MRecord" id="MRecord" perdis><option>Yes</option><option>No</option></select></td>
                            <td>New MRN<input type="field" size='4' name="newmrn" id="newmrn" perdis/></td>
                            <td>Old MRN<input type="field" size='4' name="oldmrn" id="oldmrn" perdis/></td>
                            <td>Financial Status<input type="field" size='4' name="fstatus" id="fstatus" perdis/></td>
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
    <!--<div id="mykdg" title="MyKad">
    	<iframe src="mykad.php" style="width:100%; height:100%;"></iframe>
    </div>-->
</div>   
</body> 
 </html>
