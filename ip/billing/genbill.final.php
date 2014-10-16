<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Generate Bill</span>
	<div id="formmenu">
		
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Final Bill</p></div>
            
         </div>
		
        <div class="alongdiv">
        
        	<table style="width: 100%">
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<td>MRN<br><input type="text" id="searchString9"/></td>
								<td>HUKM MRN<br>
								<input type="text" id="searchString10"/></td>
								<td>Type<br>
								<input type="text" id="searchString11"/></td>
								<td>Register Date<br>
								<input type="text" id="searchString12"/></td>
								<td>Time<br>
								<input type="text" id="searchString13"/></td>
								<td>Date Stay<br>
								<input type="text" id="searchString14"/></td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td>Name:
						<input type="text" id="searchString15" style="width: 340px"/></td>
					</tr>
					<tr>
						<td>
						<table style="width: 100%">
							<tr>
								<td>Total Charges<br>
								<input type="text" id="searchString16"/></td>
								<td>Less Deposit<br>
								<input type="text" id="searchString17"/></td>
								<td>Payment/Refund<br>
								<input type="text" id="searchString18"/></td>
								<td>Invoice No.<br>
								<input type="text" id="searchString19"/></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
        
        </div>
         
        <div class="alongdiv">
        
        	
        <span>Episode Details</span>
        	
        
        	
        
        </div>
         
         </div>
		
		<div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Discharge Information</p></div>
            
         </div>
         
		
         	   <table style="width: 100%">
				   <tr>
					   <td colspan="2">            	<table id="grid-ip-discharge"></table>
				<div id="pager-ip-discharge"></div>
</td>
				   </tr>
				   <tr>
					   <td>
					   <table style="width: 100%">
						   <tr>
							   <td>Discharge Date Time<br>
								<input type="text" id="searchString20"/></td>
						   </tr>
						   <tr>
							   <td>Mode<br>
								<input type="text" id="searchString21"/></td>
						   </tr>
						   <tr>
							   <td>Destination<br>
								<input type="text" id="searchString22"/></td>
						   </tr>
						   <tr>
							   <td>Remark<br>
								<input type="text" id="searchString23"/></td>
						   </tr>
					   </table>
					   </td>
					   <td>
					   <table style="width: 100%">
						   <tr>
							   <td><button type="button">Coverage</button> </td>
						   </tr>
						   <tr>
							   <td>
					   <button type="button">View Charges</button> </td>
						   </tr>
						   <tr>
							   <td>
					   <button type="button">View GL</button> </td>
						   </tr>
						   <tr>
							   <td>
					   <button type="button">Split Bill</button> </td>
						   </tr>
						   <tr>
							   <td>
					   <button type="button">Single Bill</button> </td>
						   </tr>
						   <tr>
							   <td>
					   <button type="button">Exit</button> </td>
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