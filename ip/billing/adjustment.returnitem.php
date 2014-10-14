<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Item Additional Entry</span>
	<div id="formmenu">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut">Remove Item</button>
            <button type="button">Save</button>
        </div>
        <div class="alongdiv">
        	
        	<table style="width: 100%">
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<th>Charges Details</th>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>
					<select id="searchField" name="D1">
                        <option selected value="MRN">Name</option>
                        </select><input type="text" id="searchString"/></td>
				</tr>
				<tr>
					<td>
					<table style="width: 100%">
						<tr>
							<th>Item Return Details</th>
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