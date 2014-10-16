<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">General In-Patient Queue</span>
	<div id="formmenu">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Return Items</button>
            <button type="button">Additional Item</button>
            <button type="button">Label</button>
            <button type="button">Process</button>
        </div>
        <div class="alongdiv">
        	<table style="width: 100%">
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<th colspan="2">Patient Search</th>
						</tr>
						<tr>
							<td>&nbsp;MRN<br>
							<input type="text" id="searchString0"/></td>
							<td>Episode<br>
							<input type="text" id="searchString1"/></td>
						</tr>
						<tr>
							<td colspan="2">
							<input type="text" id="searchString4" style="width: 296px"/></td>
						</tr>
						<tr>
							<td>DOB<br><input type="text" id="searchString2"/></td>
							<td>HUKM MRN<br>
							<input type="text" id="searchString3"/></td>
						</tr>
						</table>
					</td>
					<td>
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
					<td>
					<table style="width: 100%">
						<tr>
							<th>Episode Details</th>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					</td>
					<td>
					<table style="width: 100%">
						<tr>
							<th>Charge Details</th>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
        </div>

        
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>