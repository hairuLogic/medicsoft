clock();
	function checklength(i){  
        if (i<10){  
         i="0"+i;}  
         return i;  
 	}
	function turnDay(x){
		switch(x){
			case 0:return "Sunday";break;
			case 1:return "Monday";break;
			case 2:return "Tuesday";break;
			case 3:return "Wednesday";break;
			case 4:return "Thursday";break;
			case 5:return "Friday";break;
			case 6:return "Saturday";break;
		}
	}
	function clock(){  
	   var now = new Date();
	   var day2 = turnDay(now.getDay());
	   var day= now.getDate();
	   var month = now.getMonth()+1;
	   var year = now.getFullYear();
	   var hours = checklength(now.getHours());  
	   var minutes = checklength(now.getMinutes());  
	   var seconds = checklength(now.getSeconds());  
	   var format = 1;  //0=24 hour format, 1=12 hour format  
	   var time;  
	  
	   if (format == 1){
	   		if (hours >= 12){  
		   		if (hours ==12){  
			 	hours = 12;  
		   		}else{  
			 	hours = hours-12;  
				}time=day2+',   '+day+'/'+month+'/'+year+' -- '+hours+':'+minutes+':'+seconds+' PM';  
			
			}else if(hours < 12){  
				if (hours ==0){  
					hours=12;  
				}  
		  		time=day2+',   '+day+'/'+month+'/'+year+' -- '+hours+':'+minutes+':'+seconds+' AM';  
		 	}  
	   	}
		  
  		if (format == 0){  
     	time= hours+':'+minutes+':'+seconds;  
  		}
		
  	document.getElementById("time").innerHTML=time;  
  	setTimeout("clock();", 500);  
 	}