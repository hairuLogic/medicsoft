<table style="width: 100%">
	<tr>
		<td colspan="2" style="height: 36px"><table>
                    <tr>
                    	<td>Search By:<select id="searchField">
                        <option selected value="MRN">Invoice No.</option>
                        </select></td>
                    	<td><input type="text" id="searchString"/></td>
                        <td><input type="button" id="search" value="Proceed" class="orgbut"/><input type="button" id="search" value="Exit" class="orgbut"/></td>
                    </tr>
                    </table>
</td>
	</tr>
	<tr>
		<th colspan="2">Recompute Bill</th>
	</tr>
	<tr>
		<td colspan="2"><div class="alongdiv">
            	<table id="grid"></table>
				<div id="pager1"></div>
        </div>
</td>
	</tr>
	<tr>
		<td colspan="2">
		<div id="menu">
        	<button type="button" onClick="window.close();" id="extbut">Save</button>
            <button type="button">Cancel</button>
            <button type="button">Edit</button>
            <button type="button">Coverage</button>
        </div>
		
		</td>
	</tr>
	<tr>
		<th colspan="2">
		Payer Information</th>
	</tr>
	<tr>
		<td>
		<table style="width: 100%">
			<tr>
				<th colspan="2">Current Debtor</th>
			</tr>
			<tr>
				<td style="height: 26px">Debtor Code</td>
				<td style="height: 26px"><input type="text"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>Bill Type</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>Remark</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>Our Reference</td>
				<td><input type="text"></td>
			</tr>
		</table>
		</td>
		<td valign="top">
		<table style="width: 100%">
			<tr>
				<th colspan="2">New Debtor</th>
			</tr>
			<tr>
				<td>Debtor Code</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>Bill Type</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="text"></td>
			</tr>
			<tr>
				<td>Remark</td>
				<td><input type="text"></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
