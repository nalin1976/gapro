<?php
session_start();
include "../Connector.php";	
$backwardseperator = "../";
$companyId=$_SESSION["FactoryID"];	
$urlGrnNo	 	= $_GET["intGRNno"];
$urlGrnYear 	= $_GET["intGRNYear"];
$urlGrn = "$urlGrnYear/$urlGrnNo";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Trim Inspection</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="TrimInspactionGrnWise.js"></script>
<script type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/styleNoOrderNoLoading.js" type="text/javascript"></script>
</head>

<form name="frmTrimInspectionGrn" id="frmTrimInspectionGrn" method="post">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="95%" border="0" align="center"  class="tableBorder">
  <tr>
    <td height="25" class="mainHeading">Trim Inspection</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="100%"><table id="header" width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
		    <td width="7%" height="25" class="normalfnt">&nbsp;Style No </td>
            <td width="16%" class="normalfnt"><select name="cboStyles" class="txtbox" id="cboStyles" style="width:150px" 
			onchange="getStylewiseOrderNoNew('TrimGetStylewiseOrderNo',this.value,'cboOrderNo');getScNo('TrimGetStylewiseSCNo','cboSR');LoadGrnNo();">
<?php
		$SQL="SELECT DISTINCT GD.intStyleId,O.strStyle FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 order by strStyle ASC";	
	 
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
			
	<td class="normalfnt">SC&nbsp;</td>
    <td><select name="cboSR" class="txtbox" style="width:50px" id="cboSR" onchange="getStyleNoFromSC('cboSR','cboOrderNo');LoadGrnNo();">
        <option value="Select One" selected="selected"></option>
     <?php
	
	$SQL = "SELECT DISTINCT
			GD.intStyleId,
			O.strStyle,
			specification.intSRNO
			FROM
			grndetails AS GD
			Inner Join grnheader AS GH ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			Inner Join orders AS O ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID
			Inner Join matsubcategory AS MSC ON MSC.intSubCatNo = MIL.intSubCatID
			Inner Join specification ON O.intStyleId = specification.intStyleId
			WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 order by intSRNO DESC";
	
		
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
		$SQL="SELECT DISTINCT GD.intStyleId,O.strOrderNo FROM grndetails GD
				left JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				left join orders O on O.intStyleId=GD.intStyleId
				left join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				left join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 order by strOrderNo ASC";	
	 
			 echo "<option value =\"".""."\">"."Select One"."</option>";
		 $result =$db->RunQuery($SQL);		 
		 while($row =mysql_fetch_array($result))
		 {
			if($row["grnNO"]==$urlGrn)
				echo "<option selected=\"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
		 }			 
?>
            </select></td>
            <td width="7%" class="normalfnt">GRN No</td>
            <td width="17%" class="normalfnt"><select name="cboGrnNo" class="txtbox" id="cboGrnNo" style="width:150px" >
<?php		
		$SQL="SELECT DISTINCT CONCAT(GH.intGRNYear ,'/',GH.intGrnNo) AS grnNO
				FROM grndetails GD 
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 order by grnNO DESC";
			 
			 echo "<option value =\"".""."\">"."Select One"."</option>";
			 $result =$db->RunQuery($SQL);
			 
			 while($row =mysql_fetch_array($result))
			 {
			 	if($row["grnNO"]==$urlGrn)
					echo "<option selected=\"selected\" value=\"".""."\">".$row["grnNO"]."</option>";
				else
			 		echo "<option value=\"".$row["grnNO"]."\">".$row["grnNO"]."</option>";
			 }			 
?>
                        </select></td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkAllPreInsp" id="chkAllPreInsp" onclick="CheckAllPreInsp(this);" /></td>
            <td width="12%" class="normalfnt">All Pre-Inspection</td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkAllVisInsp" id="chkAllVisInsp" onclick="CheckAllVisInsp(this);"  /></td>
            <td width="15%" class="normalfnt">All Visual Inspection</td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkAllAppInsp" id="chkAllAppInsp" onclick="CheckAllAppInsp(this);CheckAllPreInsp(this);CheckAllVisInsp(this);"  /></td>
            <td width="12%" class="normalfnt">All Approved</td>
            <td width="8%" class="normalfnt"><img src="../images/search.png" alt="search" width="80" height="24"  onclick="LoadGrnDetailsOnClick();" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
      <tr>
        <td class="mainHeading2">&nbsp;</td>
        </tr>
      <tr>
        <td><div id="divTrimInspectionGrn" style="overflow:scroll; height:420px; width:1250px;">
          <table id="tblTrimInspectionGrn" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4" >
              <td width="9%" height="25" >Style No</td>
              <td width="7%" >OrderNo</td>
              <td width="8%" >Style Name</td>
              <td width="14%" >Item Description</td>
              <td width="5%" >Color</td>
              <td width="5%" >Size</td>
              <td width="4%" >Unit</td>
              <td width="6%" >Qty</td>
              <td width="2%" >Pre Insp</td>
              <td width="4%" >Pre Insp Qty</td>
              <td width="2%" >Vis Insp</td>
              <td width="4%" >% Qty</td>
              <td width="2%" >Approve</td>
              <td width="4%" >Approve Qty</td>
              <td width="6%" >Remarks&nbsp;<input type="checkbox" name="chkRemarks" id="chkRemarks"   onclick="sameApproveReason();"  /></td>
              <td width="3%" >Reject</td>
              <td width="4%" >Rej Qty</td>
              <td width="6%" >Rej Reason&nbsp;<input type="checkbox" name="chkRejR" id="chkRejR"   onclick="sameRejReason();"  /></td>
              <td width="3%" >Sp App</td>
              <td width="4%" >Sp App Qty</td>
              <td width="6%" >Spec Reason&nbsp;<input type="checkbox" name="chkSpeApR" id="chkSpeApR"   onclick="sameSpeAppReason();"  /></td>
			<td width="0%">GRN No </td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" align="center" class="tableBorder">
      <tr>
        <td><div align="center"/> 
        <img src="../images/new.png" width="96" height="24" onclick="newPage();" />
        <img src="../images/save.png" style="display:none" alt="Save" onclick="SaveGrnTrimInsDetails();" id="butSave" />
		<img src="../images/conform.png" style="display:none" alt="Save" onclick="ConfirmGrnTrimInsDetails();" id="butConfirm" />
        <a href="../main.php"><img src="../images/close.png" alt="close" width="97" border="0" height="24" /></a>
       </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
