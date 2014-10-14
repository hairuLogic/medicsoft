<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Enquiry</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">MR Sheet</button>
            <button type="button">MR Folder</button>
            <button type="button">Dr Notes</button>
            <button type="button">Physio</button>
            <button type="button">X-Ray</button>
            <button type="button">Labotary</button>
            <button type="button">Biodata</button>
            <button type="button">Episode</button>
            
            <button type="button">Update</button>
            
            <button type="button">Register</button>
        </div>
        
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p>Search Patient</p></div>
            <div class="bodydiv">
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
          	</div>
         </div>
		
        <div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
         
         </div>
         
	</div>
    <object ID="mykad" name="mykad" CLASSID="CLSID:97DE6E33-4A00-4C5E-9CD8-A862D04A030D">
        <param name="flgAddress1" value="true">
        <param name="flgAddress2" value="true">
        <param name="flgAddress3" value="true">
        <param name="flgBirthDate" value="true">
        <param name="flgBirthPlace" value="true">
        <param name="flgCity" value="true">
        <param name="flgGender" value="true">
        <param name="flgGMPCName" value="true">
        <param name="flgIDNumber" value="true">
        <param name="flgOldIDNumber" value="true">
        <param name="flgPhoto" value="true">
        <param name="flgPostCode" value="true">
        <param name="flgRace" value="true">
        <param name="flgReligion" value="true">
        <param name="flgState" value="true">
	</object>

<?php
	include_once('../ip-footer.php');
?>