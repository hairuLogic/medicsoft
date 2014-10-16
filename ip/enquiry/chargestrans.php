<?php
	include_once('../ip-header.php');
?><span id="pagetitle">Charges Transaction</span>
<div id="formmenu">
	<div id="menu">
		<button id="extbut" onclick="window.close();" type="button"></button>
		<button type="button">Charges</button><button type="button">Forms
		</button><button type="button">Panel</button><button type="button">Guarantee 
		Letter</button><button type="button">Next of Kin</button>
		<button type="button">Payer</button><button type="button">Episode Notes
		</button><button type="button">Charges</button></div>
	<div id="searchdiv">
		<div class="alongdiv">
			<div class="smalltitle">
				<p>Charges Transaction Info</p>
			</div>
			<div class="bodydiv">
				<table>
					<tr>
						<td><select id="searchField">
						<option selected="" value="MRN">Group</option>
						<option value="MyCard">HUKM MRN</option>
						<option value="Name">Name</option>
						<option value="Newic">New IC</option>
						<option value="Oldic">Old IC</option>
						<option value="DOB">Birth Date</option>
						<option value="Sex">Sex</option>
						<option value="Idnumber">Card ID</option>
						</select></td>
						<td><input id="searchString0" type="text" /><input id="searchString" type="text" /></td>
						<td>
						<input id="search" class="orgbut" type="button" value="Search" /></td>
						<td>
						Total Charges:<input type="text" id="searchString1"/> </td>
					</tr>
					<tr>
						<td><select id="searchField">
						<option selected="" value="MRN">Description</option>
						<option value="MyCard">HUKM MRN</option>
						<option value="Name">Name</option>
						<option value="Newic">New IC</option>
						<option value="Oldic">Old IC</option>
						<option value="DOB">Birth Date</option>
						<option value="Sex">Sex</option>
						<option value="Idnumber">Card ID</option>
						</select></td>
						<td><input id="searchString" type="text" /></td>
						<td>
						<input id="search" class="orgbut" type="button" value="Search" /></td>
						<td>
						&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="alongdiv">
			<table id="grid-chargestrans">
			</table>
			<button type="button">Detail Info</button>
			<button type="button">Pharmacy Info</button>
			<button type="button">Sort Description</button>
			<button type="button">Sort Code</button>
			<div id="pager1">
			</div>
		</div>
		<div class="alongdiv">
			<div class="bodydiv">
				
				<table style="width: 100%">
					<tr>
						<td>Chg Group:</td>
						<td><input type="text"></td>
						<td>Take Home Entry:</td>
						<td><input type="text"></td>
						<td>Late Charges Entry:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Trans Date:</td>
						<td><input type="text"></td>
						<td>Chg Class:</td>
						<td><input type="text"></td>
						<td>Bill Flag:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Time:</td>
						<td><input type="text"></td>
						<td>MMA Code:</td>
						<td><input type="text"></td>
						<td>Bill Date:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Dbt Acc Code:</td>
						<td><input type="text"></td>
						<td>Unit Price:</td>
						<td><input type="text"></td>
						<td>Bill Time:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Cr Acc Code:</td>
						<td><input type="text"></td>
						<td>Quantity:</td>
						<td><input type="text"></td>
						<td>Bill No:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Issuing Dept:</td>
						<td><input type="text"></td>
						<td>Amount:</td>
						<td><input type="text"></td>
						<td>Inv Code:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Doctor Code:</td>
						<td><input type="text"></td>
						<td>Tax Amt</td>
						<td><input type="text"></td>
						<td>Last User:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="text"></td>
						<td>Bill Code:</td>
						<td><input type="text"></td>
						<td>Last Updated:</td>
						<td><input type="text"></td>
					</tr>
					<tr>
						<td>Document Ref:</td>
						<td><input type="text"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Remarks:</td>
						<td><input type="text"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				
			</div>
		</div>

	</div>
</div>
<?php
	include_once('../ip-footer.php');
?>