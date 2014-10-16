<?php
	include_once('../ip-header.php');
?><span id="pagetitle">Patient Registration</span>
<div id="formmenu">
	<div id="menu">
		<button id="extbut" onclick="window.close();" type="button"></button>
		<button id="epibut" type="button"></button>
		<button id="epibut" type="button"></button>
		<button id="epibut" type="button"></button>
		<button id="epibut" type="button"></button>
		<button id="epibut" type="button"></button>
		<button id="epibut" type="button"></button></div>
	<table>
		<tr>
			<td style="width: 50px">
			view GL
			<button id="epibut" type="button"></button>
			Doctor
			<button id="epibut" type="button"></button>
			Payer
			<button id="epibut" type="button"></button>
			Next Of
			<button id="epibut" type="button"></button>
			Deposit
			<button id="epibut" type="button"></button>
			Bed Allocation
			<button id="epibut" type="button"></button></td>
			<td style="width: 100%; vertical-align: top">
			<div id="episodediv">
				<div class="alongdiv">
					<div class="smalltitle">
						<p>Episode</p>
					</div>
					<div class="bodydiv">
						<table>
							<tr>
								<th>Episode No</th>
								<th>Type</th>
								<th>Date</th>
								<th>Time</th>
								<th>HUKM MRN</th>
							</tr>
							<tr>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
							</tr>
						</table>
						<table style="width: 100%">
							<tr>
								<td colspan="2">Reg Dept</td>
								<td rowspan="22" style="width: 40%; vertical-align: bottom">
								<table>
									<tr>
										<td colspan="2">New Case</td>
									</tr>
									<tr>
										<td>Pregnant</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>Non-Pregnant</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2">Follow Up</td>
									</tr>
									<tr>
										<td>Pregnant</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>Non-Pregnant</td>
										<td>&nbsp;</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Reg Source</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Case</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Doctor</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Fin Class</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Pay Mode</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Payer</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Bill Type</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Admin Fee</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td colspan="2">Reference No</td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" /><input type="text" /></td>
							</tr>
							<tr>
								<td>Our Reference No</td>
								<td>Queue No</td>
							</tr>
							<tr>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			</td>
		</tr>
	</table>
</div>
<?php
	include_once('../ip-footer.php');
?>