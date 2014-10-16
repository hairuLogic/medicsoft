<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Patient Registration</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
            <button type="button" id="epibut"></button>
        </div>
<div class="alongdiv" id="almc">
        	<div class="smalltitle"><p>Patient Information from MyCard</p></div>
            <div class="bodydiv">
        		<table style="width:78%" id="mctbl">
                	<tr>
                    	<td>Name</td><td><input type="text" id="mcname"/></td>
                        <td>IC Number</td><td>
							<input style="width:95%" type="text" id="mcsex0"/></td>
                    </tr>
                    <tr>
                    	<td>Address</td><td><input type="text" id="mcic"/></td>
                        <td>Old IC</td><td>
							<input style="width:95%" type="text" id="mcsex1"/></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td><td><input type="text" id="mcic0"/></td>
                        <td>Sex</td><td><input style="width:95%" type="text" id="mcsex"/></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td><td><input type="text" id="mcic1"/></td>
                        <td>D.O.B</td><td>
							<input style="width:95%" type="text" id="mcsex2"/></td>
                    </tr>
                    <tr>
                    	<td>Postcode</td><td><input type="text" id="mcic2"/></td>
                        <td>Race</td><td>
							<input style="width:95%" type="text" id="mcsex3"/></td>
                    </tr>
                    <tr>
                    	<td>City</td><td><input type="text" id="mcic3"/></td>
                        <td>Religion</td><td>
							<input style="width:95%" type="text" id="mcsex4"/></td>
                    </tr>
                    <tr>
                    	<td>State</td><td><input type="text" id="mcic4"/></td>
                        <td>Birth Place</td><td>
							<input style="width:95%" type="text" id="mcsex5"/></td>
                    </tr>
                    <tr>
                    	<td colspan="4" style="text-align:right;">
                        	<input type="button" value="Register" id="try">
                        	<input type="button" value="Read MyCard" class="orgbut" onClick="try2()" id="read">
                        </td>
                    </tr>
                </table>
                <img name="" src="../../image/mykad1.png" width="100" height="150" alt="" id="img">
            </div>
        </div>       
        
<div class="alongdiv">

                	<table>
                    <tr>
                    	<td><label>Search by: </label><select id="searchField">
                        <option selected value="MRN">MRN</option>
                        <option value="MyCard">HUKM MRN</option>
                        <option value="Name">Name</option>
                        <option value="Newic">New IC</option>
                        <option value="Oldic">Old IC</option>
                        <option value="DOB">Birth Date</option>
                        <option value="Sex">Sex</option>
                        <option value="Idnumber">Card ID</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    </table>

            	<table id="grid1"></table>
				<div id="pager1"></div>
        </div>        
        
 <input type="button" id="search" value="Update Record" class="orgbut"/>       
 <input type="button" id="search" value="Episode" class="orgbut"/>       
 <input type="button" id="search" value="Cancel" class="orgbut"/>       
         
	</div>

<?php
	include_once('../ip-footer.php');
?>