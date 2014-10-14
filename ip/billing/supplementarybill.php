
<head>
<meta content="en-us" http-equiv="Content-Language">
</head>

<table style="width: 100%">
	<tr>
		<td valign="top">
		<table style="width: 100%">
			<tr>
				<th colspan="3">Patient Search</th>
			</tr>
			<tr>
				<td>HUKM MRN<br><input type="text"></td>
				<td>MRN<br><input type="text"></td>
				<td>Episode<br><input type="text"></td>
			</tr>
			<tr>
				<td colspan="3"><input type="text"></td>
			</tr>
			<tr>
				<td colspan="3">DOB<br><input type="text"></td>
			</tr>
		</table>
		</td>
		<td valign="top">
		<table style="width: 100%">
			<tr>
				<th>Payer Information</th>
			</tr>
			<tr>
				<td><textarea></textarea></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="2">
		<div id="menu">
            <button type="button">Split Bill</button>
            <button type="button">Single Bill</button>
        	<button type="button" onClick="window.close();" id="extbut">Exit</button>
        </div>
		</td>
	</tr>
	<tr>
		<td valign="top">
		<table style="width: 100%">
			<tr>
				<th>Episode Details</th>
			</tr>
			<tr>
				<td>
				<div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
</td>
			</tr>
		</table>
		</td>
		<td valign="top">
		<table style="width: 100%">
			<tr>
				<th>Charge Details</th>
			</tr>
			<tr>
				<td><div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
