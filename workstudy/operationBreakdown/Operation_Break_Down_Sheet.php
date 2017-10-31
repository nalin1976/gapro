<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Break Down Sheet</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script src="Operation.js"></script>
<script src="../../js/jquery-1.4.2.min.js"></script>
<script src="ajaxupload.js"></script>

<script src="../../javascript/tablegrid.js" type="text/javascript" ></script>
<script src="../../javascript/script.js" type="text/javascript" ></script>
<script src="../../javascript/styleNoOrderNoLoading.js" type="text/javascript" ></script>
<script>
function getScNo(type,id)
{
   var styleName = document.getElementById('cboStyles').value;
   var url=pub_IssueUrl+"styleNoOrderNoSCLoadingXML.php";
					url=url+"?RequestType="+type+"";
					    url += '&styleName='+URLEncode(styleName);
					
   var htmlobj=$.ajax({url:url,async:false});
   var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
   document.getElementById(''+id+'').innerHTML =  OrderNo;
	
}
</script>
<!--<script src="../../javascript/jquery.js"></script>-->
<!--<script src="../../javascript/jquery-ui.js"></script>-->



</head>
<body>
<?php
include "../../Connector.php";
?> 
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>

</table>
<!--<div class="main_bottom_big">
	<div class="main_top">
		<div class="main_text">Operation Break Down Sheet</div>
	</div>
	<div class="main_body">-->
    
<form id="frmOperationBrackDown" name="frmOperationBrackDown">
<table width="802" border="0" align="center" bgcolor="#FFFFFF" id="tbloperationbrackdown">
  <tr>
  <script src="jquery_002.js" type="text/javascript"></script><br>
<script src="jquery.js" type="text/javascript"></script><br>
<script src="jqueryTableDnDArticle.js" type="text/javascript"></script>
	<td align="center">
		<table width="80%" align="center" border="0" class="bcgl1" id="tblfrm">
			<tr>
				<td colspan="3"  class="mainHeading2">
				Operation Break Down Sheet				</td>
			</tr>
		<tr>
		<td colspan="2">
			<table  width="100%">
			  <tr>
                <td class="normalfnt" >Style No</td>
			    <td class="normalfnt"><select class="txtbox" style="width: 150px;" name="cboStyles" id="cboStyles" 
				onchange="getStylewiseOrderNoNew('OPBDGetStylewiseOrderNo',this.value,'styleNo');getScNo('OPBDgetStyleWiseSCNum','ordercombo');">
                    <option value="">Select One</option>
                    <?php
					//$SQL="	SELECT distinct strStyleID, intSRNO FROM specification  ";	
					$SQL = "select distinct strStyle from orders where intStatus='11' order by strStyle ASC";	
					$result = $db->RunQuery($SQL);	 
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"".$row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
					}		  
					?>
                  </select>                </td>
			   			    <td class="normalfnt">Total Output Hr</td>
			    <td class="normalfnt"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="totalOutputHr" id="totalOutputHr" readonly="readonly" /></td>
							<td class="normalfnt" width="113">Work Hours</td>
			<td class="normalfnt" width="139"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="workHours" id="workHours" value="9" onkeypress="return CheckforValidDecimal(this.value, 2,event);"></td>
				</tr>
				
				<tr>

				 <td class="normalfnt">Order  No</td>
			    <td class="normalfnt"><select class="txtbox" style="width: 150px;" name="styleNo" id="styleNo" onchange="updateHeader(this.value); updateDataGrid(this.value); ">
                    <option value="">Select One</option>
                    <?php
					//$SQL="	SELECT distinct strStyleID, intSRNO FROM specification  ";	
					$SQL = "select distinct intStyleId,strOrderNo from orders where intStatus='11' order by strStyle ASC";	
					$result = $db->RunQuery($SQL);	 
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"".$row["strOrderNo"] ."\">" . $row["strOrderNo"] ."</option>" ;
					}		  
					?>
                  </select>                </td>

						    <td class="normalfnt">Total SMV</td>
			    <td class="normalfnt"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="totalSMV" id="totalSMV" readonly="readonly" /></td>
			<td class="normalfnt" width="113">Helper SMV</td>
			<td class="normalfnt" width="139"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="helperSMV" id="helperSMV" readonly="readonly"></td>
			</tr>
			
			<tr>

			<td class="normalfnt" width="95">SC No</td>
			<td class="normalfnt" width="250">
			<div id="ordersdiv">
				<select class="txtbox" id="ordercombo" name="ordercombo" style="width: 150px;" onchange="updateHeader(this.value); updateDataGrid(this.value); 																																																																																																																																													getStyleNoFromSC('ordercombo','styleNo');">
			<option value="">Select One</option>
		<?php
		
/*		$SQL="	SELECT DISTINCT s.intStyleId,s.intSRNO 
				FROM specification s order by intSRNO DESC";*/
			$SQL = "SELECT
					specification.intSRNO,
					specification.intStyleId
					FROM
					orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId where intStatus='11' order by intSRNO ASC ";	
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
			</select>
			</div></td>
			<td class="normalfnt" width="154"> Machine Output Hr</td>
			<td class="normalfnt" width="181"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="machineOutputHr" id="machineOutputHr" readonly="readonly"></td>
 <td class="normalfnt">Machine SMV</td>
			    <td class="normalfnt"><input style="width:80px;" class="txtbox" type="text" maxlength="10" name="machineSMV" id="machineSMV" readonly="readonly"></td>
			</tr>

            
			</table>		</tr>
		<tr>
				<td>
					<table width="100%">
						<tr>
						<td width="92" height="50" class="normalfnt"  >Comments</td>
						<td class="normalfnt" width="361"><textarea name="comments" class="txtbox" id="comments" style="width:353px;"></textarea>
							<input type="hidden" id="dataAdded" name="dataAdded" value="ok" />						</td>
						<td width="491" align="right" valign="bottom"><img src="../../images/operational.jpg" alt="Op +" border="0" class="mouseover" onclick="loadComponents(this);" id="btnOperational"/></td>
						</tr>
					</table>				</td>
		</tr>
		<tr>
			<td colspan="2" align="center" >
				<table>
				<tr>
				<td width="841">
				<div id="divcons" class="main_border_line" style="overflow:scroll; height:300px; width:950px;">
					<div id="datagrid">
					<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblOperationSelection">
						<caption style="background-color:#FBF8B3"></caption>
						<tr>
							<th style="background-color:#FBF8B3">Serial No</th>
							<th style="background-color:#FBF8B3">Machine</th>
							<th style="background-color:#FBF8B3">Components</th>
							<th style="background-color:#FBF8B3">Opt Code</th>
							<th style="background-color:#FBF8B3">Operations</th>
							<th style="background-color:#FBF8B3">SMV</th>
							<th style="background-color:#FBF8B3">Machine</th>
							<th style="background-color:#FBF8B3"># Opr</th>
							<th style="background-color:#FBF8B3">Target 100%</th>
							<th style="background-color:#FBF8B3">SMV (TMU)</th>
							<th style="background-color:#FBF8B3">&nbsp;</th>
						</tr>			 
					</table>		
					</div>		
				</div>				</td>
				</tr>
<tr>
				<td width="841">
					<div id="datagrid2">
					<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblStyleCategory">
						<caption style="background-color:#FBF8B3"></caption>
						<tr>
							<th style="background-color:#FBF8B3">Style</th>
							<th style="background-color:#FBF8B3">Category</th>
							<th style="background-color:#FBF8B3">Teams</th>
							<th style="background-color:#FBF8B3">#Operators</th>
							<th style="background-color:#FBF8B3">#Helpers</th>
						</tr>			 
					</table>	
				</div>				<input type="hidden" value="0" name="txtInputBoxFlag" id="txtInputBoxFlag" />	</td>
				</tr>				</table>			</td>
		</tr>
		<tr>		</tr>
		<tr>
			<td align="center">
				<table>
					<tr>
						<td colspan="8"><b>Color Codes</b></td>
					</tr>
					<tr>
						<td width="86" class="normalfnt">&nbsp;</td>
						<td width="29" class="normalfnt"><img src="../../images/ok-mark.png"/></td>
						<td width="17"><img src="../../images/yellow.jpg"/></td>
						<td width="53" class="normalfnt">Machine</td>
						<td width="17"><img src="../../images/green.jpg"/></td>
						<td width="48" class="normalfnt">Helper</td>
						<td width="17"><img src="../../images/blue.jpg"/></td>
						<td width="220" class="normalfnt">O/ Factory</td>
					</tr>
				</table>			</td>
		</tr>
		<tr >
			<td colspan="2" align="center" >
			<table  border="0" id="btntable" class="tableBorder">
				<tr>
					
					<td><img src="../../images/new.png" class="mouseover" border="0" onclick="pageClear();" ></td>
					<td><img src="../../images/pt.png" class="mouseover" border="0" onClick="loadPichTime(this);" id="PT"></td>
					<td><img src="../../images/place_seq.png" class="mouseover"></td>
					<td><img src="../../images/layout.png" class="mouseover"  onclick="openLayoutPageNewTab();" /></td>
					<td><img src="../../images/save.png" alt="Save" name="Save" id="Save" class="mouseover" onclick="saveOperationBrakDownSheet()"></td>
            <td><img src="../../images/CopyOrder2.jpg" alt="Copy Operation BreakDown"    class="mouseover" onclick="loadOperationBreakDown();" /></td>
					<td><img id="butReport" src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="loadOperatBreakDownReport();"/></td>
					<td><img src="../../images/close.png" id="Close" border="0" onclick="backToTheMainPage();" class="mouseover"></td>
				</tr>
			</table>			</td>
		</tr>
  </table>
	</td>
	</tr>
	</table>
<div style="left:570px; top:487px; z-index:10; position:absolute; width: 280px; visibility:hidden; height: 65px;" id="copyOperationBreakDown">
  <table width="352" height="56" border="0" cellpadding="0" cellspacing="0" class="tablezRED">     
          <tr>
            <td colspan="5" bgcolor="#550000"  align="right"><img src="../../images/cross.png" onClick="callClose()" alt="Close" name="Close" width="17" height="17" id="Close"/></td>
          </tr>
          <tr>
            <td width="80"><div align="center">Style</div></td>
<td>
                <select name="cboCopyPopupStyle" class="txtbox" id="cboCopyPopupStyle" style="width:150px" onchange="loadScSyle(this.value)">
			<option value="">select</option>
                <?php
			$sql_query 	="SELECT distinct strStyleID
						 FROM `ws_operationbreakdownheader` ";
			
			$result =$db->RunQuery($sql_query);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strStyleID"]."\">".$row["strStyleID"]."</option>";
			}
				?>
                </select></td>
            <td width="80"><div align="center">SC</div></td>
<td>
                <select name="cboCopyPopupSC" class="txtbox" id="cboCopyPopupSC" style="width:100px" onchange="loadScSyle(this.value)">
			<option value="">select</option>
		<?php
		
		$SQL="	SELECT DISTINCT s.strStyleID,s.intSRNO
FROM
specification AS s
Inner Join ws_operationbreakdownheader ON s.strStyleID = ws_operationbreakdownheader.strStyleID
order by intSRNO ASc";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strStyleID"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
                </select></td>
            <td><img src="../../images/go.png" alt="Copy PO" width="30" height="22" vspace="3" class="mouseover" onclick="copyOperationBreakDown();" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"></div></td>
            <td width="157">&nbsp;</td>
            <td width="48">&nbsp;</td>
          </tr>
  </table>
</div></form>
<!--</div>
</div>-->
</body>
</html>
