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