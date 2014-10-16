<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Episode</span>
	<div id="formmenu">
    	<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut"></button>
            <button type="button">Charges</button>
            <button type="button">Forms</button>
            <button type="button">Panel</button>
            <button type="button">Guarantee Letter</button>
            <button type="button">Next of Kin</button>
            <button type="button">Payer</button>
            
            <button type="button">Episode Notes</button>
            
            <button type="button">Charges</button>
        </div>
        
        <div id="searchdiv"><div class="alongdiv">
        	<div class="smalltitle"><p></p></div>
            <div class="bodydiv">
                	<table>
                    <tr><td>MRN</td>
                    	<td>HUKM MRN</td>
                    	<td>NAME</td>
                    </tr>
                    </table>
          	</div>
         </div>
		
        <div class="alongdiv">
            	<table id="grid-episode"></table>
				<div id="pager1"></div>
        </div>
         
         </div>
         
	</div>
    

<?php
	include_once('../ip-footer.php');
?>