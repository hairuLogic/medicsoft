<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">General In-Patient Queue</span>
	<div id="formmenu">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Delete</button>
            <button type="button">Cancel</button>
            <button type="button">Refresh</button>
            <button type="button">All Label</button>
            <button type="button">Select Label</button>
            <button type="button"> </button>
            <button type="button">LIS</button>            
            <button type="button">Print</button>            
            <button type="button" onclick="window.open('hospital.edit.php','_blank')">Edit</button>
        </div>
        <div id="searchdiv">
        <div class="alongdiv">
        	
        
            <table style="width: 100%">
				<tr>
					<td>Biodata</td>
						<td>Clinical Notes</td>
						<td>Allergy</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
        	
        
         </div>
        <div class="alongdiv">
        <table><tr><td> 		<button type="button">Total by Code</button> 
 		<button type="button">Sort by Date</button>       
 		<button type="button">Sort by Desc</button>       
 		<button type="button">Calendar</button>       
 		<button type="button">Doctor Handwriting</button>       
</td><td> 		Deposit: <input type="text">
 		Total: <input type="text">
</td></tr></table>
        	
        
         </div>
		
        <div class="alongdiv">
            	<table id="grid-gen-ord-entry"></table>
				<div id="pager-gen-ord-entry"></div>
        </div>
         
        <div class="alongdiv">
        
        	
        
        	<table style="width: 100%">
				<tr>
					<td rowspan="4" style="width:60%">&nbsp;</td>
					<td>Item Expiry</td>
						</tr>
						<tr>
							<td>
							<table style="width: 100%">
								<tr>
									<td>Batch No</td>
								<td>Exp Date</td>
								<td>BalQty</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td>Remarks</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
        
        	
        
        </div>
         
         </div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>