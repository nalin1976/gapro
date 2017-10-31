<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Credit Note</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>
</head>
<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutB">
		<div class="trans_text">Credit Note<span class="volu"></span></div>
			<table width="100%" border="0">
				<tr>
					<td width="83%" height="400" style="border:1px solid #cccccc;">
						<table width="100%" border="0">
							<tr>
								<td width="12%" class="normalfnt">Supplier</td>
								<td colspan="6">
									<select style="width: 370px;" class="txtbox">
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="normalfnt">Invoice</td>
								<td colspan="2">
									<select style="width: 117px;" class="txtbox">
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
				  	  	  	  	</td>
								<td width="19%" class="normalfnt">Acc Pay Inv</td>
								<td colspan="2">
									<select style="width: 127px;" class="txtbox">
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
				  	  	  	  	</td>
							</tr>
							<tr>
								<td class="normalfnt">Cr. Note No</td>
					  	  	  	<td colspan="2"><input type="text" style="width:115px;" class="txtbox" /></td>
								<td colspan="3" class="normalfnt" bgcolor="#b8b8b9">Invoice Details</td>
							</tr>
							<tr>
								<td class="normalfnt">Tax</td>
							  	<td colspan="2"><input type="text" style="width:115px;" class="txtbox" /></td>
								<td width="19%" class="normalfnt" bgcolor="#e5e6e7">Currency</td>
					  	  	  <td width="12%" bgcolor="#e5e6e7"><input type="text" style="width:60px;" class="txtbox" /></td>
						  	  <td width="28%" bgcolor="#e5e6e7"><input type="text" style="width:60px;" class="txtbox" /></td>
							</tr>
							<tr>
								<td class="normalfnt">Amount</td>
						  	  	<td colspan="2"><input type="text" style="width:115px;" class="txtbox" /></td>
								<td width="19%" class="normalfnt" bgcolor="#e5e6e7">Total Tax</td>
					  	  	  	<td colspan="2" bgcolor="#e5e6e7"><input type="text" style="width:125px;" class="txtbox" /></td>
							</tr>
							<tr>
								<td class="normalfnt">Total</td>
						  	  	<td colspan="2"><input type="text" style="width:115px;" class="txtbox" /></td>
								<td width="19%" class="normalfnt" bgcolor="#e5e6e7">Amount</td>
						  	  	<td colspan="2" bgcolor="#e5e6e7"><input type="text" style="width:125px;" class="txtbox" /></td>
							</tr>
							<tr>
								<td class="normalfnt">Currency</td>
					  	  	  <td width="10%"><input type="text" style="width:55px;" class="txtbox" /></td>
				  	  	  	  <td width="19%"><input type="text" style="width:53px;" class="txtbox" /></td>								
								<td width="19%" class="normalfnt">Total amount</td>
						  	  	<td colspan="2"><input type="text" style="width:125px;" class="txtbox" /></td>

							</tr>
							<tr>
								<td class="normalfnt">Date</td>
								<td colspan="2">
									<select style="width: 117px;" class="txtbox">
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
					  	  	  	</td>
								<td width="19%" class="normalfnt">Balance</td>
								<td colspan="2"><input type="text" style="width:125px;" class="txtbox" /></td>
							</tr>
							<tr>
								<td class="normalfnt">Batch No</td>
						  	  <td width="10%"><input type="text" style="width:55px;" class="txtbox" /></td>
						  	  	<td width="19%"><img src="../images/search.png" width="60" /></td>
					  	  	  <td width="19%"><input type="text" style="width:100px;" class="txtbox" /></td>
						  	  <td colspan="2"><input type="text" style="width:125px;" class="txtbox" /></td>
							</tr>
							<tr>
								<td width="12%" class="normalfnt">Remarks</td>
								<td colspan="6"><input type="text" style="width:368px;" class="txtbox" /></td>
							</tr>
					  </table>
					  <div style="overflow:scroll; height:150px; width:472px;">
						<table style="width:448px" class="transGrid" border="1" cellspacing="1">
							<thead>
								<tr>
									<td colspan="3">GL Accounts</td>			
								</tr>	
								<tr>
									<td width="255">GL Accounts ID</td>
									<td width="255">Description</td>
									<td width="254">Amount</td>				
								</tr>		
							</thead>	
							<tbody>
								<tr>
									<td width="255">****</td>
									<td width="255">****</td>
									<td width="254">****</td>				
								</tr>
								<tr>
									<td width="255">****</td>
									<td width="255">****</td>
									<td width="254">****</td>				
								</tr>	
							</tbody>
						</table>
					</div>
				  </td>
				  <td>&nbsp;</td>
					<td>
						<table width="419" height="400" border="0">
							<tr>
								<td style="border:1px solid #ffffff; margin-left:10px;">
									<table width="399" border="0">
										<tr>
											<td width="38">&nbsp;</td>
								  	  	  	<td width="23" class="normalfnt"><input type="radio" name="one" class="txtbox" /></td>
											<td width="107" class="normalfnt">Style Invoices</td>
								  	  	  	<td width="26" class="normalfnt"><input type="radio" name="one"  class="txtbox" /></td>
											<td width="183" class="normalfnt">General Invoices</td>
										</tr>
							  	  </table>
									<div style="overflow:scroll; height:120px; width:400px;">
										<table style="width:382px" class="transGrid" border="1" cellspacing="1">
											<thead>
												<tr>
													<td colspan="3">Tax Type</td>			
												</tr>	
												<tr>
													<td width="255">Tax Type</td>
													<td width="255">Rate</td>
													<td width="254">Amount</td>				
												</tr>		
											</thead>	
											<tbody>
												<tr>
													<td width="255">****</td>
													<td width="255">****</td>
													<td width="254">****</td>				
												</tr>
												<tr>
													<td width="255">****</td>
													<td width="255">****</td>
													<td width="254">****</td>				
												</tr>	
											</tbody>
										</table>
									</div>
									<br />
									<table width="399" border="0" style="border:1px solid #cccccc;">
										<tr>
											<td colspan="5"class="normalfntb">Previous Credit Note Summery</td>
										</tr>
											<td width="1">&nbsp;</td>
								  	  	  	<td width="69" class="normalfnt">Amount</td>
											<td width="117" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
								  	  	  	<td width="49" class="normalfnt">Taxes</td>
											<td width="141" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
										</tr>
								  	</table>
									<br />
									<table width="399" border="0" style="border:1px solid #cccccc;">
										<tr>
											<td colspan="5"class="normalfntb">Previous Debit Note Summery</td>
										</tr>
										<tr>
											<td width="1">&nbsp;</td>
								  	  	  	<td width="69" class="normalfnt">Amount</td>
										  	<td width="117" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
								  	  	  	<td width="49" class="normalfnt">Taxes</td>
										  	<td width="141" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
										</tr>
								  	</table>
									<br />
									<table width="399" border="0">
										<tr>
											<td colspan="5"class="normalfntb">&nbsp;</td>
										</tr>
										<tr>
											<td width="1">&nbsp;</td>
								  	  	  	<td width="69" class="normalfnt">AccPac ID</td>
										  	<td width="117" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
								  	  	  	<td width="49" class="normalfnt">Vat No</td>
										  	<td width="141" class="normalfnt"><input type="text" style="width:115px;" class="txtbox" /></td>
										</tr>
								  	</table>
									<br />
									<table width="399" height="34" border="0">
										<tr>
											<td width="34%">&nbsp;</td>
											<td width="12%"><img src="../images/new.png" width="90" /></td>
											<td width="11%"><img src="../images/save.png" width="80" /></td>
											<td width="12%"><a href="../main.php"><img src="../images/close.png" alt="close" width="90" border="0" /></a></td>
											<td width="31%">&nbsp;</td>
										</tr>
								  </table>
								  <br />
								</td>
							</tr>
					  </table>
				  </td>
				</tr>
		  </table>
		  <br />
		  <div style="overflow:scroll; height:120px; width:900px;">
			<table style="width:882px" class="transGrid" border="1" cellspacing="1">
				<thead>
					<tr>
						<td colspan="39">Tax Type</td>			
					</tr>	
					<tr>
						<td width="255">Supplier Name</td>
						<td width="255">Invoice No</td>
						<td width="255">Credit No</td>	
						<td width="255">Date</td>
						<td width="255">Amount</td>
						<td width="255">Tax</td>
						<td width="255">Currence</td>
						<td width="255">Rate</td>
						<td width="255">Remarks</td>	
					</tr>		
				</thead>	
				<tbody>
					<tr>
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>	
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>			
					</tr>
					<tr>
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>
						<td width="255">****</td>
						<td width="255">****</td>
						<td width="254">****</td>				
					</tr>	
				</tbody>
			</table>
		</div>
		 <br />
		</div>
	</div>
</div>
</body>
</html>
