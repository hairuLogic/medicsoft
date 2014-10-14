<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">General In-Patient Queue</span>
	<div id="formmenu">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Nursing</button>
            <button type="button">Physio</button>
            <button type="button">Consultant</button>
            <button type="button">X-Ray</button>
            <button type="button">Med. Supp</button>
            <button type="button" onclick="window.open('hospital.php','_self')">Hospital</button>
            
            <button type="button">Laboratory</button>
            
            <button type="button">Pharmacy</button>
        </div>
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Search Patient</p></div>
            <div class="bodydiv">
                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option selected value="MRN">Name</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    <tr>
                    	<td><input type="radio"> Out Patient</td>
                    	<td><input type="radio"> In Patient</td>
                        <td>&nbsp;</td>
                    </tr>
                    </table>
          	</div>
         </div>
		
        <div class="alongdiv">
            	<table id="grid-ip-queue"></table>
				<div id="pager-ip-queue"></div>
        </div>
         
        <div class="alongdiv">
        
        	<table style="width: 100%">
				<tr>
					<td>Doctor:</td>
						<td colspan="5"><input type="text"></td>
					</tr>
					<tr>
						<td>Debtor:</td>
						<td><input type="text"></td>
						<td>Charges Amt:</td>
						<td><input type="text">(Billed)</td>
						<td>HUKM MRN:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Case</td>
						<td><input type="text"></td>
						<td>Deposit Paid:</td>
						<td><input type="text"></td>
						<td>Charges Amt:</td>
						<td><input type="text">(Un Bill)</td>
					</tr>
				</table>
        
        </div>
         
         </div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>