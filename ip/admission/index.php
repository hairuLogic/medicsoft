<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Patient Registration</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Alert</button>
            <button type="button">Episode</button>
            <button type="button">OTC Episode</button>
            <button type="button">Import</button>
            <button type="button" id="mykbut">My Kad</button>
            <button type="button">GP</button>
            
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
         <div class="sideleft">
         	<div class="smalltitle"><p>Home</p></div>
            <div class="bodydiv">
                	<input type="text" id="curaddr1"/>
                    <input type="text" id="curaddr2"/>
                    <input type="text" id="curaddr3"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telh"/>
            </div>
         </div>
         <div class="sideleft">
         	<div class="smalltitle"><p>Office</p></div>
            <div class="bodydiv">
                	<input type="text" id="offaddr1"/>
                    <input type="text" id="offaddr2"/>
                    <input type="text" id="offaddr3"/>
                    <label style="width:28%; margin-right:2%">Telephone:</label><input style="width:70%" type="text" id="telo"/>
            </div>
         </div>
         <div class="sideleft" style="margin-right:0%;width:33.333%">
         	<div class="smalltitle"><p>Payer Information</p></div>
            <div class="bodydiv">
                	<input type="text" id="peraddr1"/>
                    <input type="text" id="peraddr2"/>
                    <input type="text" id="peraddr3"/>
                    <input type="text" id="peraddr3"/>
            </div>
         </div></div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>