<?php
	session_start();
	
	include "../Connector.php";
$backwardseperator = '../';
	$StyleNo=$_GET["StyleNo"];
	$MainMatID=$_GET["MainMatID"];
	$SubCatID=$_GET["SubCatID"];
	$MatDetailID=$_GET["MatDetailID"];
	$BuyerPO='0';
$report_companyId =$_SESSION["FactoryID"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Requisitions Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$strSQL= "SELECT strName,strAddress1,strAddress2,strCity,strCountry,strPhone,strFax,strEMail,strWeb FROM companies WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;
$result=$db->RunQuery($strSQL);

while($row = mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] ;//+ " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
}
	$strSQL="SELECT advancepayment.PaymentNo,advancepayment.paydate,suppliers.strTitle FROM advancepayment INNER JOIN suppliers ON advancepayment.supid =  suppliers.strSupplierID WHERE advancepayment.PaymentNo = $intPaymentNo AND advancepayment.strType='$strPaymentType'";


$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["paydate"];
}

?>
<table width="959" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?><!--<table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%" rowspan="4"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="5%" rowspan="4" class="normalfnt">&nbsp;</td>
        <td colspan="4" class="tophead"><p align="left" class="topheadBLACK"><?php echo $companyName; ?></p>            </td>
      </tr>
      <tr>
        <td colspan="4" class="tophead"><div align="left"><span class="normalfnt"><?php echo $address; ?></span></div></td>
      </tr>
      <tr>
        <td width="7%" class="tophead"><span class="normalfnt"><strong>Tel</strong>: </span></td>
        <td width="22%" class="tophead"><span class="normalfnt"><?php echo $phone; ?></span></td>
        <td width="12%" class="tophead"><span class="normalfnt"><strong>Fax</strong>: </span></td>
        <td width="30%" class="tophead"><span class="normalfnt"><?php echo $fax; ?></span></td>
      </tr>
      <tr>
        <td class="tophead"><span class="normalfnt"><strong>E-Mail</strong>: </span></td>
        <td class="tophead"><span class="normalfnt"><?php echo $email; ?></span></td>
        <td class="tophead"><span class="normalfnt"><strong>Web</strong>:  </span></td>
        <td class="tophead"><span class="normalfnt"><?php echo $web; ?></span></td>
      </tr>
    </table>--></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td width="100%" height="36" class="head2">Material Requisitions Report</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
        <td width="7%" height="25" class="normalfntBtab">MRN No</td>
        <td width="7%" class="normalfntBtab">DATE</td>
        <td width="11%" height="25" class="normalfntBtab">STYLE</td>
        <td width="10%" height="25" class="normalfntBtab">BUYER PO NO</td>
        <td width="21%" height="25" class="normalfntBtab">METERIAL</td>
        <td width="7%" height="25" class="normalfntBtab">COLOUR</td>
        <td width="7%" height="25" class="normalfntBtab">SIZE</td>
        <td width="7%" height="25" class="normalfntBtab">MRN QTY.</td>
        <td width="7%" class="normalfntBtab">ISSUED QTY</td>
        <td width="16%" class="normalfntBtab">BALANCE TO ISSUE</td>
        </tr>
		<?php
			$total = 0;
			
			//$strSQL="SELECT * ,(frightcharge+couriercharge+bankcharge) AS charges FROM advancepayment WHERE PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType'";
			
			
			$strSQL="SELECT   ISD.dblBalanceQty as dblBalanceQtytoIssue,  ISD.dblQty as issueQty,  MIL.strItemDescription, MIL.intMainCatID,  MIL.intSubCatID,  MRH.intMatRequisitionNo,  MRH.intMRNYear, DATE_FORMAT(MRH.dtmDate,'%y/%c/%e') AS dtmDate ,  MRH.strDepartmentCode,  MRH.intRequestedBy,  MRH.intStatus,  MRH.intUserId,  MRH.intCompanyID,  MRD.intMatRequisitionNo,  MRD.intYear,  MRD.intStyleId,  MRD.strBuyerPONO,  MRD.strMatDetailID,  MRD.strColor,  MRD.strSize,  MRD.dblQty,  MRD.dblBalQty,  MRD.strNotes  FROM matrequisition MRH INNER JOIN matrequisitiondetails MRD ON (MRH.intMatRequisitionNo=MRD.intMatRequisitionNo)  AND (MRH.intMRNYear=MRD.intYear) INNER JOIN matitemlist MIL ON (MRD.strMatDetailID=MIL.intItemSerial) LEFT JOIN issuesdetails ISD ON (ISD.intMatRequisitionNo=MRD.intMatRequisitionNo)   AND (ISD.intMatReqYear=MRD.intYear)   AND  (MRD.intStyleId=ISD.intStyleId) WHERE (MRD.intStyleId = '$StyleNo')";
  
			if($BuyerPO!="0")
			{
				$strSQL.="AND (MRD.strBuyerPONO = '$BuyerPO')";
			}
			else if($BuyerPO=="0")
			{
				$strSQL.="AND (MRD.strBuyerPONO = '#Main Ratio#')";
			}
			
			if($MainMatID!=0)
			{
				$strSQL.="AND (MIL.intMainCatID = '$MainMatID')" ;
			}
			
			if($SubCatID!=0)
			{
				$strSQL.="AND (MIL.intSubCatID = '$SubCatID')" ;
			}
			
			if($MatDetailID!=0)
			{
				$strSQL.="AND (MRD.strMatDetailID = '$MatDetailID')";
			}
			
			
			$result=$db->RunQuery($strSQL);
			
			while($row = mysql_fetch_array($result))
			{ 
		?>
				<tr>
				<td height="18" class="normalfntMid"><?PHP echo($row["intMatRequisitionNo"]);  ?></td>
				<td class="normalfnt"><?PHP echo($row["dtmDate"]);  ?></td>
				<td class="normalfnt"><?PHP echo getStyleName($row["intStyleId"]);  ?></td>
				<td class="normalfnt"><?PHP echo($row["strBuyerPONO"]);  ?></td>
				<td class="normalfnt"><?PHP echo($row["strItemDescription"]);  ?></td>
				<td class="normalfntMid"><?PHP echo($row["strColor"]);  ?></td>
				<td class="normalfntMid"><?PHP echo($row["strSize"]);  ?></td>
				<td class="normalfntMid"><?PHP echo($row["dblQty"]);  ?></td>
				<td class="normalfntMid"><?PHP echo($row["issueQty"]);  ?></td>
				<td class="normalfntMid"><?PHP echo($row["dblBalanceQtytoIssue"]);  ?></td>	
				</tr>
		<?php
			}
		?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="5%" class="normalfnt">User : </td>
        <td width="9%" class="normalfntMid">
          <?php 
		
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>        </td>
        <td width="4%" class="normalfnt">Date:</td>
        <td width="12%" class="normalfntMid"><?php echo date("Y/m/d"); ?></td>
        <td width="64%" class="normalfnt">&nbsp;</td>
        <td width="6%" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
<?php 
function getStyleName($styleID)
{
	global $db;
	
	$SQL = "select strStyle from orders where intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}
?>
</body>
</html>
