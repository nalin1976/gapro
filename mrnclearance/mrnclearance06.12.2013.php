<?php
	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";
	
						
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: MRN Clearance</title>
<style type="text/css">

</style>
<script type="text/javascript" src="mrnclearance.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--start -for calander-->
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />

<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>

<!--End -for calander-->
<script>
var MRNno=-1;
function setMrnNo()
{
MRNno=document.getElementById("cboMRNNo").value;
}
</script>
</head>

<body >
<form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
    
    <tr>
      <td height="26"class="mainHeading"> MRN Clearance </td>
    </tr>
    <tr>
      <td height="38"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr>
            <td height="35" valign="top"><table width="100%" height="35" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td width="4%" height="35" class="normalfnt">&nbsp;</td>
                  <td width="12%" height="35" class="normalfnth2B">MRN No: </td>
                  <td width="34%" height="35" class="normalfnt"><select name="cboMRNNo"  class="txtbox" id="cboMRNNo" style="width:300px" onchange="setMrnNo();" >
                      <option value="1">Select one</option>
                      <?php 
					 		$user=$_SESSION["UserID"];
					  	
				  			$sqlMrn="select 	
							intMatRequisitionNo, 
							intMRNYear,	
							intUserId 	
							from 
							matrequisition 
							";
							$MrnResult=$db->RunQuery($sqlMrn);
							while($mrnrow=mysql_fetch_array($MrnResult))
							{?>
                      <option value="<?php echo $mrnrow["intMatRequisitionNo"]."/".$mrnrow["intMRNYear"];?>"><?php echo $mrnrow["intMRNYear"]."/".$mrnrow["intMatRequisitionNo"];?></option>
                      <?php }?>
                      >
                  </select></td>
                  <td width="11%" height="35" class="normalfnt"><img height="24" border="0" width="80" alt="search" src="../images/search.png" class="mouseover" onclick="getMRNDetails();"/></td>
                  <td width="18%" class="normalfnt">&nbsp;</td>
                  <td width="9%" class="normalfnt">&nbsp;</td>
                  <td width="12%" height="35" class="normalfnt">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="55%" class="mainHeading2" id="commonBinID" title="MRN Details" style="text-align:left">&nbsp;Material Requisition Number :
                  <span id="currentNo">&nbsp;</span></td>
                  <td width="34%" class="mainHeading2" ></td>
                  <td width="11%" class="mainHeading2" >&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="300" class="normalfnt"><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
                <table id="tblMRN"width="930" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                  <tr class="mainHeading4">
                    <td width="3%" height="25" >Del</td>
                    <td width="9%" >Style</td>
                    <td width="9%" >Buyer Po</td>
                    <td width="15%" >Description</td>
                    <td width="8%" >Color</td>
                    <td width="8%" >Size</td>
                    <td width="6%" >MRN Qty</td>
                    <td width="6%" >Issued Qty</td>
                    <td width="6%" >Balance</td>
                    <td width="7%" >Adjust MRN Qty </td>
                    <td width="7%" >GRN No </td>
                    <td width="9%" >GRN Year </td>
                    <td width="7%" >GRN Type </td>
                  </tr>
                  <!--            <tr>
              <td class="normalfnt"><img src="../images/del.png" alt="del" width="15" height="15"/></td>
             <td class="normalfnt">NA</td>
			  <td class="normalfntMidSML">Tags Hand Bag- Ref# - TIWLH</td>
              <td class="normalfntMidSML">0</td>
              <td class="normalfntMidSML">0.2544</td>
              <td class="normalfntMidSML">NA</td>
              <td class="normalfntMidSML">NA</td>
              <td class="normalfntMidSML">PCS</td>
              <td class="normalfntRite">0.20</td>
              <td class="normalfntMidSML"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return isNumberKey(event);" value="0" /></td>              
              <td class="normalfntMidSML"><img src="../images/location.png" alt="add" width="80" height="15" /></td>
              </tr>-->
                </table>
            </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
     
    </tr>
    <tr >
      <td height="30"><table width="100%" border="0" class="bcgl1">
          <tr >
            <td class="normalfnt" style="text-align:center"="center"><img src="../images/new.png" alt="new" border="0" id="cmdNew" width="96" height="24" onclick="newWindow();"/><img src="../images/save-confirm.png" alt="Save" name="cmdSave" width="174" height="24" id="cmdSave" onclick="preparetosave();" /><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a><a href="../main.php"></a></td>
            </tr>
      </table></td>
    </tr>
  </table></td>
  </tr>
</table>

</form>
<!--Start - Search popup-->

<!--End - Search popup-->
</body>
</html>
