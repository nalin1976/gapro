<?php
$backwardseperator = "";
session_start();
$programmer  = "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Issues Log</title>

<link  rel="stylesheet" type="text/css" href="css/erpstyle.css"/>

<script type="text/javascript" src="javascript/script.js"></script>    
<script type="text/javascript" src="javascript/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript" src="javascript/issuesLog.js"></script>

<link href="css/tableGrib.css" rel="stylesheet" type="text/css" />
<link href="css/JqueryTabs.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/tablegrid.js"></script>

<style type="text/css">
	.trans_layoutNEw
	{
		width:800px; height:auto;
		border:1px solid;
		border-bottom-color:#550000;
		border-top-color:#550000;
		border-left-color:#550000;
		border-right-color:#550000;
		background-color:#FFFFFF;
		padding-right:15px;
		padding-top:10px;
		padding-left:30px;
		padding-right:30px;
		margin-top:20px;
		-moz-border-radius-bottomright:5px;
		-moz-border-radius-bottomleft:5px;
		-moz-border-radius-topright:10px;
		-moz-border-radius-topleft:10px;
		border-bottom:13px solid #550000;
		border-top:30px solid #550000;
	}
</style>
<?php include"Connector.php"; ?>
</head>
<body>
	<table width="100%" align="center">
		<tr>
    		<td><?php include 'Header.php'; ?></td>
		</tr>
	</table>
	<div>
		<div align="center">
			<div class="trans_layoutNEw" style="padding-bottom:20px; width:600px;">
				<div class="trans_text" style="color:#ffffff;">Issues Log<span class="volu"></span></div>
					<div align="left" style="padding-bottom:05px; width:500px;"> 
						 <table width="100%" border="0" class="">
						 	<tr>
								<td class="normalfnt">Request No</td>
								<td class="normalfnt">
									<?php 
										$SQL = "SELECT syscontrol.dblRequestNo FROM syscontrol";
										$result = $db->RunQuery($SQL);
										while($row = mysql_fetch_array($result))
										{
									?>
										<input type="text" id="txtRquestNo" name="txtRquestNo" readonly="readonly" width="100px;" style="background-color:#CCCCCC;" tabindex="1" value="<?php echo $row["dblRequestNo"];?>" />
									<?php
										}
									?>
									</td>
						 	</tr>
							<tr>
								<td class="normalfnt">Project Name</td>
								<td class="normalfnt">
									<input type="text" id="txtProjectName" name="txtProjectName" style="width:265px;" tabindex="2" />
						 	</tr>
							<tr>
								<td class="normalfnt">Attention To</td>
								<td class="normalfnt">
									<select style="width:266px;" id="cboAttentTo" name="cboAttentTo" tabindex="3">
									<?php 
										$SQL = "SELECT programmers.intProgrammerId,
							               			   programmers.strEmpNo,
										   			   programmers.strProgrammerName
												FROM 
							               			   programmers";
										$result = $db->RunQuery($SQL);
										while($row = mysql_fetch_array($result))
				   						 {
				    					   echo "<option value=".$row["intProgrammerId"].">".$row["strProgrammerName"]."</option>";
				    					}
									?>
									</select>
						 	</tr>
							<tr>
								<td class="normalfnt">User</td>
								<td class="normalfnt">
									<input type="text" id="txtUser" name="txtUser" style="width:265px;" tabindex="4" />
						 	</tr>
							<tr>
								<td class="normalfnt">Description</td>
								<td class="normalfnt">
									<textarea id="txtDescription" name="txtDescription" style="width:263px; height:auto;" class="normalfnt" tabindex="5" ></textarea>
						 	</tr>
							<tr>
								<td class="normalfnt">Attachement</td>
								<td class="normalfnt">
									<input name="file" type="file" class="txtbox" id="file" size="36" tabindex="6" />
						 	</tr>
							<tr>
								<td class="normalfnt">Reported By</td>
								<td class="normalfnt">
									<input type="text" id="txtReportedBy" name="txtReportedBy" style="width:265px;" tabindex="7" />
						 	</tr>
							<tr>
								<td class="normalfnt">Status</td>
								<td class="normalfnt">
									<select style="width:130px;" id="cboStatus" name="cboStatus" tabindex="8">
										<option value=""></option>
										<option value="0">Open</option>
										<option value="1">Close</option>
									</select>
						 	</tr>
					  </table>
					</div>
						<table width="100%" border="0" style="margin-top:10px;">
							<tr>
								<td width="25%">&nbsp;</td>
								<td width="12%"><img src="images/new.png" id="butNew" name="butNew" onclick="clearForm();" width="90" tabindex="12" /></td>
								<td width="12%"><img src="images/save.png" id="butSave" name="butSave" onclick="saveIssues();" width="80" tabindex="9" /></td>
								<td width="12%"><img src="images/report.png" id="butReport" name="butReport" alt="close" border="0" onclick="" tabindex="10" /></td>
								<td width="12%"><a href="main.php"><img src="images/close.png" alt="close" width="90" border="0" tabindex="11" /></a></td>
								<td width="32%">&nbsp;</td>
							</tr>
						</table>
				</div>
			</div>
		</div>
	</div>
</body>