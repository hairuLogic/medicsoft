<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">General In-Patient Queue</span>
	<div id="formmenu">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Address</button>
            <button type="button">Save</button>
            <button type="button">Cancel</button>
            <button type="button">Edit</button>
            <button type="button">Add</button>
        </div>
        <div id="searchdiv">
		
        <div class="alongdiv">
            	<table id="grid-ip-coverage"></table>
				<div id="pager-ip-coverage"></div>
        </div>
         
        <div class="alongdiv">
        
        	<table style="width: 100%">
				<tr>
					<th>Patient Info</th>
				</tr>
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<td>MRN</td>
								<td><input type="text" id="searchString"/></td>
								<td>Episode No</td>
								<td><input type="text" id="searchString1"/></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><input type="text" id="searchString0"/></td>
								<td>Type</td>
								<td><input type="text" id="searchString2"/></td>
							</tr>
						</table>
						</td>
				</tr>
				<tr>
					<th>Payer Details</th>
				</tr>
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<td>Payer No</td>
								<td><input type="text" id="searchString3"/></td>
								<td>Fin Class</td>
								<td><input type="text" id="searchString4"/></td>
							</tr>
							<tr>
								<td>Bill Type</td>
								<td colspan="3">
								<input type="text" id="searchString5"/><input type="text" id="searchString11"/></td>
							</tr>
							<tr>
								<td>Payer Code</td>
								<td colspan="3">
								<input type="text" id="searchString6"/><input type="text" id="searchString12"/></td>
							</tr>
							<tr>
								<td>List Amount</td>
								<td colspan="3">
								<input type="text" id="searchString7"/></td>
							</tr>
							<tr>
								<td>All Group</td>
								<td colspan="3">
								<input type="text" id="searchString8"/> <input type="button" value="Exception"></td>
							</tr>
							<tr>
								<td>Reference No</td>
								<td colspan="3">
								<input type="text" id="searchString9"/></td>
							</tr>
							<tr>
								<td>Our Reference</td>
								<td colspan="3">
								<input type="text" id="searchString10"/></td>
							</tr>
						</table>
						</td>
				</tr>
			</table>
        
        </div>
         
         </div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>