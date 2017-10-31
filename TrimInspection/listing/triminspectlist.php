<?php
session_start();
include "../../Connector.php";	
$backwardseperator = "../../";
$companyId		= $_SESSION["FactoryID"];	
$urlGrnNo	 	= $_GET["intGRNno"];
$urlGrnYear 	= $_GET["intGRNYear"];
$urlGrn 		= "$urlGrnYear/$urlGrnNo";	
include "../../authentication.inc";

$chkNotInspect	= $_POST["chkNotInspect"];
$cboOrderNo		= $_POST["cboOrderNo"];
$cboGrnNo		= $_POST["cboGrnNo"];
$cboGrnNoArray	= explode('/',$cboGrnNo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Trim Inspection Listing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="triminspectlist.js"></script>
<script type="text/javascript" src="../../javascript/script.js" ></script>
<script type="text/javascript" src="../../javascript/styleNoOrderNoLoading.js" ></script>


</head>
<style type="text/css">
.Approved{
	color:#009900;
	<!--text-decoration:blink;-->
	font-size:12px;
	font-weight:bold
}
.Reject{
	color:#FF0000;
	<!--text-decoration:blink;-->
	font-size:12px;
	font-weight:bold;
}
</style>
<form name="frmTrimInspectList" id="frmTrimInspectList" method="post" action="triminspectlist.php">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="95%" border="0" align="center"  class="tableBorder">
  <tr>
    <td height="25" class="mainHeading">Trim Inspection Listing </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="100%"><table id="header" width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
		    <td width="7%" height="25" class="normalfnt">&nbsp;Style No </td>
            <td width="16%" class="normalfnt"><select name="cboStyles" class="txtbox" id="cboStyles" style="width:150px" onchange="getStylewiseOrderNoNew('TrimListGetStylewiseOrderNo',this.value,'cboOrderNo');getScNo('TrimListGetStylewiseSCNo','cboSR');">
<?php
		$SQL="SELECT DISTINCT O.strStyle FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' 
				and MSC.intInspection=1 order by strStyle";	
	 
			 echo "<option value =\"".""."\">"."Select One"."</option>";
		 $result =$db->RunQuery($SQL);		 
		 while($row =mysql_fetch_array($result))
		 {
			if($row["grnNO"]==$urlGrn)
				echo "<option selected=\"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
			else
				echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
		 }			 
?>
            </select></td>
			
	<td class="normalfnt">SCNo&nbsp;</td>
    <td><select name="cboSR" class="txtbox" style="width:50px" id="cboSR" onchange="getStyleNoFromSC('cboSR','cboOrderNo');LoadGrnNo();">
        <option value="Select One" selected="selected"></option>
     <?php
	
/*	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by specification.intSRNO desc";*/
		
	$SQL = "SELECT DISTINCT
			GD.intStyleId,
			O.strOrderNo,
			specification.intSRNO
			FROM
			grndetails AS GD
			Inner Join grnheader AS GH ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			Inner Join orders AS O ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID
			Inner Join matsubcategory AS MSC ON MSC.intSubCatNo = MIL.intSubCatID
			Inner Join specification ON O.intStyleId = specification.intStyleId order by specification.intSRNO desc";	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
	    </select></td>
            <td width="7%" height="25" class="normalfnt">&nbsp;Order No </td>
            <td width="16%" class="normalfnt"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px" 
			onchange="getSC('cboSR','cboOrderNo');getStyleNoFromSC('cboSR','cboOrderNo');LoadGrnNo();">
<?php
		$SQL = "SELECT DISTINCT GD.intStyleId,O.strOrderNo FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' 
				and MSC.intInspection=1 order by strOrderNo";	

			 echo "<option value =\"".""."\">"."Select One"."</option>";
		 $result =$db->RunQuery($SQL);		 
		 while($row =mysql_fetch_array($result))
		 {
			if($row["intStyleId"]==$cboOrderNo)
				echo "<option selected=\"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
		 }			 
?>
            </select></td>
            <td width="7%" class="normalfnt">GRN No</td>
            <td width="17%" class="normalfnt"><select name="cboGrnNo" class="txtbox" id="cboGrnNo" style="width:150px" >
<?php
	//$SQL="select distinct concat(GH.intGRNYear,'/',GH.intGrnNo)as grnNo from grnheader GH where GH.intStatus=1 and GH.intCompanyID=$companyId order by grnNo desc";			 
		$SQL = "SELECT DISTINCT CONCAT(GH.intGRNYear ,'/',GH.intGrnNo) AS grnNO 
			FROM grndetails GD
			inner join grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
			inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
			WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId'
			and MSC.intInspection=1 order by grnNO desc";
if($cboOrderNo!="")
	$SQL .= " and ";		
			 echo "<option value =\"".""."\">"."Select One"."</option>";
			 $result =$db->RunQuery($SQL);
			 
			 while($row =mysql_fetch_array($result))
			 {
			 	if($row["grnNO"]==$cboGrnNo)
					echo "<option selected=\"selected\" value=\"".$row["grnNO"]."\">".$row["grnNO"]."</option>";
				else
			 		echo "<option value=\"".$row["grnNO"]."\">".$row["grnNO"]."</option>";
			 }			 
?>
                        </select></td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkNotInspect" id="chkNotInspect" <?php echo($chkNotInspect ? "checked":"")?>/></td>
            <td width="19%" class="normalfnt">Show Not Trim Inspect Items </td>
            <td width="2%" class="normalfnt">&nbsp;</td>
            <td width="12%" class="normalfnt">&nbsp;</td>
            <td width="8%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24"  onclick="SubmitForm();" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
      <tr>
        <td class="mainHeading2">Listing</td>
        </tr>
      <tr>
        <td><div id="divTrimInspectionGrn" style="overflow:scroll; height:420px; width:1250px;">
          <table id="tblTrimInspectionGrn" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4" >
              <td width="3%">GRN No </td>
              <td width="6%" height="25" >Style No</td>
              <td width="6%" >OrderNo</td>
              <td width="7%" >Style Name</td>
              <td width="12%" >Item Description</td>
              <td width="4%" >Color</td>
              <td width="4%" >Size</td>
              <td width="3%" >Unit</td>
              <td width="5%" >Qty</td>
              <td width="4%" >Approved</td>
              <td width="4%" >Approve Qty</td>
              <td width="4%" >Approve Remarks&nbsp;</td>
              <td width="3%" >Rejected</td>
              <td width="2%" >Reject Qty</td>
              <td width="4%" >Reject Reason&nbsp;</td>
              <td width="4%" nowrap="nowrap" >SP <br /> Approved</td>
              <td width="4%" nowrap="nowrap" >SP Approved<br />Qty</td>
              <td width="4%" nowrap="nowrap" >SP Approved<br />Reason</td>
              <td width="4%" >Saved By </td>
              <td width="4%" >Saved Date </td>
              <td width="2%" >Approved By </td>
              <td width="2%" >Approved Date </td>
              <td width="2%" nowrap="nowrap" >SP Approve<br />
               Confirm By</td>
              <td width="2%" nowrap="nowrap" >SP Approve<br />
                Confirm Date</td>
              </tr>
<?php
$booFirst = true;
$sql="select concat(GH.intGRNYear,'/',GH.intGrnNo)as grnNo,O.strStyle,O.strOrderNo,O.strDescription,MIL.strItemDescription,GD.strColor,GD.strSize,PD.strUnit,GD.dblQty,
GD.intInspApproved,
(select Name from useraccounts UA where UA.intUserID=GD.intTrimIBy)as trimInsPectBy,GD.strComment,
GD.intApprovedQty,GD.intReject,GD.intRejectQty,GD.strReason,
(select Name from useraccounts UA where UA.intUserID=GD.intTrimIConfirmBy)as trimInsConfirmBy,
GD.dtmTrimIDate,GD.intTrimIConfirmDate,MSC.intInspection,GD.intSpecialApp,GD.strSpecialAppReason,GD.intSpecialAppQty,
(select Name from useraccounts UA where UA.intUserID=GD.intSATrimIConfirmBy)as SAConfirmedBy,GD.intSATrimIConfirmDate
from grnheader GH 
inner join grndetails GD on GD.intGrnNo=GH.intGrnNo
inner join orders O on O.intStyleId=GD.intStyleId
inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
inner join purchaseorderdetails PD on PD.intYear=GH.intYear and PD.intPoNo=GH.intPoNo and PD.intStyleId=GD.intStyleId and PD.intMatDetailID=GD.intMatDetailID and PD.strColor=GD.strColor and PD.strSize=GD.strSize and PD.strBuyerPONO=GD.strBuyerPONO 
where GH.intStatus=1 ";
if(!$chkNotInspect)
	$sql .= "and MSC.intInspection=1 ";
if($cboOrderNo!="")
{
	$sql .= "and O.intStyleId='$cboOrderNo' ";
	$booFirst = false;
}
if($cboGrnNo!="")
{
	$sql .= "and GH.intGRNYear='$cboGrnNoArray[0]' and GH.intGrnNo='$cboGrnNoArray[1]' ";
	$booFirst = false;
}

if(!$booFirst)
	$sql .= "order by grnNo,O.strOrderNo,MIL.strItemDescription,GD.strColor,GD.strSize";
else
	$sql .= "order by GH.dtmRecievedDate limit 0,200";
	
	//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
$className = "bcgcolor-tblrowWhite";
	if($row["intInspection"]=='0')
		$className = "bcgcolor-InvoiceCostTrim";
?>
            <tr class="<?php echo $className;?>" >
              <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["grnNo"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDescription"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblQty"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="Approved"><?php echo ($row["intInspApproved"]=='1' ? '&radic;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo ($row["intInspApproved"]=='1' ? $row["intApprovedQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strComment"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="Reject"><?php echo ($row["intReject"]=='1' ? '&times;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo ($row["intReject"]=='1' ? $row["intRejectQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strReason"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="Approved"><?php echo ($row["intSpecialApp"]=='1' ? '&radic;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo ($row["intSpecialApp"]=='1' ? $row["intSpecialAppQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSpecialAppReason"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["trimInsPectBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["dtmTrimIDate"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["trimInsConfirmBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intTrimIConfirmDate"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["SAConfirmedBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intSATrimIConfirmDate"];?>&nbsp;</td>
              </tr>
<?php
}
?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" align="center" class="tableBorder">
      <tr>
        <td class="normalfntMid">
        <img src="../../images/new.png"  onclick="newPage();" />
        <img src="../../images/report.png" alt="Report" id="butSave" onclick="ViewReport();"/>
        <a href="../../main.php"><img src="../../images/close.png" alt="close" border="0" /></a>
       </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
