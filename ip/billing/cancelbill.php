<?php
	include_once('../ip-header.php');
?><span id="pagetitle">Cancel Bill</span>
<div id="formmenu">
	<div id="searchdiv">
		<div class="alongdiv">
			<input type="button" value="Proceed"> <input type="button" value="Exit">
		</div>
		<div class="alongdiv">
			
			
			
			<table style="width: 100%">
				<tr>
					<td colspan="2"><table>
                    <tr>
                    	<td><select id="searchField">
                        <option selected value="MRN">Bill No.</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Search" class="orgbut"/></td>
                    </tr>
                    </table>
</td>
				</tr>
				<tr>
					<td colspan="2">        <div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
</td>
				</tr>
				<tr>
					<td rowspan="2">        <div class="alongdiv">
            	<table id="grid1"></table>
        </div>
</td>
					<td>
					<table style="width: 100%">
						<tr>
							<td>MRN<br><input type="text"><input type="text" style="width: 30px"></td>
						</tr>
						<tr>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td><input type="text"></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td><textarea></textarea></td>
				</tr>
			</table>
			
			
			
		</div>
	</div>
</div>
<?php
	include_once('../ip-footer.php');
?>