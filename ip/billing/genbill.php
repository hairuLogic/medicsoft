<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Generate Bill</span>
	<div id="formmenu">
		
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Search By</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option selected value="MRN">Name</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Proceed" class="orgbut"/></td>
                    </tr>
                    </table>
          	</div>
         </div>
		
        <div class="alongdiv">
            	<table id="grid-ip-genbill"></table>
				<div id="pager-ip-genbill"></div>
        </div>
         
        <div class="alongdiv">
        
        	
        <span>Episode Details</span>
        	<table style="width: 100%">
				<tr>
					<td>HUKM MRN</td>
					<td colspan="5"><input type="text" id="searchString1"/></td>
				</tr>
				<tr>
					<td>Type</td>
					<td><input type="text" id="searchString0"/></td>
					<td>Reg Date Time</td>
					<td><input type="text" id="searchString5"/></td>
					<td>Case</td>
					<td><input type="text" id="searchString7"/></td>
				</tr>
				<tr>
					<td>Doctor</td>
					<td colspan="5"><input type="text" id="searchString2"/></td>
				</tr>
				<tr>
					<td>Payer</td>
					<td colspan="5"><input type="text" id="searchString3"/></td>
				</tr>
				<tr>
					<td>Bed</td>
					<td><input type="text" id="searchString4"/></td>
					<td>Bed Type</td>
					<td><input type="text" id="searchString6"/></td>
					<td>Ward</td>
					<td><input type="text" id="searchString8"/></td>
				</tr>
			</table>
        
        	
        
        </div>
         
         </div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>