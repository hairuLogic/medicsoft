<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MyKad</title>

<script language="javascript">
	var obj = new ActiveXObject("MyKad_OCX.MyKasd");
	
	

		
		var nResult = obj.ReadCard();
		if(nResult==0){
			alert("reading");
		}else{
			alert(obj.GetErrorDesc());
		}

	
	
	
</script>  
</head>

<body>
	<input type="button" onClick="cmdmainclick()" value="try" />


</body>
</html>
