<?php
	include "../Connector.php";
	session_start();
	
	$StyleID		= $_GET["StyleID"];
	$companyId		= $_SESSION["FactoryID"];
	$buyerPoNo		= $_GET["buyerPoNo"];
	$mainStoreId	= $_GET["mainStore"];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gatepass Items</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<form name="frmItemPoPUp" id="frmItemPoPUp">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="17" class="mainHeading"><div align="center">Stock Items</div></td>
        </tr>
      <tr>
        <td><div id="divItemPopUp" style="overflow:scroll; height:394px; width:950px;" class="tableBorder">
          <table id="tblItemPopUp" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
              <td width="3%" height="25"><input type="checkbox" name="checkbox1" id="checkbox1" onclick="SelectAll(this)"/></td>
              <td width="9%">Issue No</td>
              <td width="15%">Materials</td>
              <td width="31%">Description</td>
              <td width="7%">BuyerPoNo</td>
              <td width="10%">Color</td>
              <td width="9%">Size</td>
              <td width="5%">Units</td>
              <td width="10%">Qty</td>	
              <td width="4%">GRN No</td>	
              <td width="4%">GRN Type</td>			  
<?php
/*$SQL="SELECT DISTINCT ".
	"ID.intStyleId, ".
	"ID.strBuyerPONO, ".
	"ID.intMatDetailID, ".
	"ID.strColor, ".
	"ID.strSize, ".
	"Sum(ID.dblBalanceQty) AS QTY, ".
	"MIL.strItemDescription, ".
	"concat(ID.intIssueYear,'/',ID.intIssueNo) as IssueNo, ".
	"concat(ID.intMatReqYear,'/',ID.intMatRequisitionNo) as MrnNo, ".
	"MIL.strUnit, ".
	"MMC.strDescription, ".
	"MIL.intSubCatID ".
	"FROM ".
	"issuesdetails AS ID ".
	"Inner Join issues AS I ON ID.intIssueNo = I.intIssueNo AND ID.intIssueYear = I.intIssueYear ".
	"Inner Join matitemlist AS MIL ON MIL.intItemSerial = ID.intMatDetailID ".
	"Inner Join matmaincategory AS MMC ON MMC.intID = MIL.intMainCatID ".
	"WHERE ".
	"I.intStatus =  '1' AND ".
	"I.intCompanyID =  '$companyId' AND ".
	"ID.intStyleId =  '$StyleID' AND ".
	"ID.strBuyerPONO =  '$buyerPoNo' ".
	"GROUP BY ".
	"ID.intStyleId, ".
	"ID.strBuyerPONO, ".
	"ID.intMatDetailID, ".
	"ID.strColor, ".
	"ID.strSize, ". 
	"ID.intIssueNo, ".
	"ID.intIssueYear ".
	"ORDER BY ".
	"MMC.intID,MIL.strItemDescription ASC;";*/
	
	/*$SQL = " SELECT DISTINCT ID.intStyleId, ID.strBuyerPONO, ID.intMatDetailID, ID.strColor, ID.strSize,
	round((ID.dblBalanceQty),2) AS QTY, MIL.strItemDescription, concat(ID.intIssueYear,'/',ID.intIssueNo) as IssueNo,
	concat(ID.intMatReqYear,'/',ID.intMatRequisitionNo) as MrnNo, MIL.strUnit, MMC.strDescription, MIL.intSubCatID,
	concat(ID.intGrnYear,'/',ID.intGrnNo) as GRNno,ID.strGRNType
	FROM issuesdetails AS ID 
	Inner Join issues AS I ON ID.intIssueNo = I.intIssueNo AND ID.intIssueYear = I.intIssueYear 
	Inner Join matitemlist AS MIL ON MIL.intItemSerial = ID.intMatDetailID 
	Inner Join matmaincategory AS MMC ON MMC.intID = MIL.intMainCatID 
	WHERE I.intStatus = '1' 
	AND I.intCompanyID = '$companyId' 
	AND ID.intStyleId = '$StyleID' 
	AND ID.strBuyerPONO = '$buyerPoNo'
	and ID.dblBalanceQty >0
	ORDER BY MMC.intID,MIL.strItemDescription,ID.intIssueNo,ID.intIssueYear ; ";*/
	
	$SQL = "SELECT DISTINCT
ID.intStyleId,
ID.strBuyerPONO,
ID.intMatDetailID,
ID.strColor,
ID.strSize,
round((ID.dblBalanceQty),2) AS QTY,
MIL.strItemDescription,
concat(ID.intIssueYear,'/',ID.intIssueNo) AS IssueNo,
concat(ID.intMatReqYear,'/',ID.intMatRequisitionNo) AS MrnNo,
MMC.strDescription,
MIL.intSubCatID,
concat(ID.intGrnYear,'/',ID.intGrnNo) AS GRNno,
ID.strGRNType,
specificationdetails.strUnit
FROM
issuesdetails AS ID
INNER JOIN issues AS I ON ID.intIssueNo = I.intIssueNo AND ID.intIssueYear = I.intIssueYear
INNER JOIN matitemlist AS MIL ON MIL.intItemSerial = ID.intMatDetailID
INNER JOIN matmaincategory AS MMC ON MMC.intID = MIL.intMainCatID
INNER JOIN specificationdetails ON ID.intStyleId = specificationdetails.intStyleId AND ID.intMatDetailID = specificationdetails.strMatDetailID
WHERE I.intStatus = '1' AND I.intCompanyID = '$companyId' AND ID.intStyleId = '$StyleID' 
AND ID.strBuyerPONO = '$buyerPoNo' and ID.dblBalanceQty >0
ORDER BY MMC.intID,MIL.strItemDescription,ID.intIssueNo,ID.intIssueYear";
		 
	$result =$db->RunQuery($SQL);				
	while ($row=mysql_fetch_array($result))
	{
		$QTY	= $row["QTY"];
		if($QTY>0)
		{
			$buyerPONO	 = $row["strBuyerPONO"];
			$styleId	 = $row["intStyleId"];
			$buyerPoName = $row["strBuyerPONO"];
			$grnType 	 = $row["strGRNType"];	
			
			switch($grnType)
			{
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
			}
			
			if($buyerPONO != '#Main Ratio#')
				//$buyerPoName = getBuyerPOName($styleId,$buyerPONO);
                            $buyerPoName =  getBuyerPONameForChange($styleId,$buyerPONO);
		
?>              
</tr>
<?php
$classtext = "";
					if ($row % 2 == 0)
						$classtext = "bcgcolor-tblrowWhite";
					else
					 	$classtext = "bcgcolor-tblrow";
?>
			  

            <tr class="bcgcolor-tblrowWhite" height="15" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background=''">
              <td class="normalfntRite"><div align="center">
                  <input type="checkbox" name="checkbox" id="checkbox"/>
              </div></td>
              <td class="normalfnt" id="<?php echo $row["intSubCatID"]  ?>"><?php echo $row["IssueNo"]?></td>
              <td class="normalfntSM"><?php echo $row["strDescription"] ?></td>
              <td class="normalfntSM" id="<?php echo $row["intMatDetailID"]  ?>"><?php echo $row["strItemDescription"]  ?></td>
              <td class="normalfntMidSML" id="<?php echo $row["strBuyerPONO"] ?>" ><?php echo  $buyerPoName;?></td>
              <td class="normalfntMidSML" id="<?php echo $row["MrnNo"]  ?>"><?php echo  $row["strColor"] ?></td>
              <td class="normalfntMidSML"><?php echo $row["strSize"] ?></td>
              <td class="normalfntMidSML"><?php echo $row["strUnit"] ?></td>
              <td class="normalfntRite"><?php echo round($QTY,2) ;?></td>
              <td class="normalfnt"><?php echo $row["GRNno"] ;?></td>
              <td class="normalfnt" id="<?php echo $grnType; ?>"><?php echo $strGRNType; ?></td>					 
              </tr>  
<?php
		}
}
?> 
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0">
      <tr>
        <td width="64%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td width="43%" class="normalfnt">&nbsp;</td>
            <td width="10%" class="normalfnt"><img src="../images/ok.png" alt="ok" width="86" height="24" onclick="AddToMainPage();"/></td>
            <td width="47%" class="normalfnt"><img src="../images/close.png" alt="close" width="97" height="24" onclick="closeWindow();" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php 
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function getBuyerPONameForChange($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPoName='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
?>
</form>
</body>
</html>
