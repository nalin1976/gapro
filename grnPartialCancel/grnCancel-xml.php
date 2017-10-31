<?php

include "../Connector.php";
		
$id=$_GET["id"];

if($id=="getPoDetails")
{
	$poNo=$_GET["poNo"];
	$year=$_GET["year"];
	
	$SQL="	SELECT
			purchaseorderdetails.intStyleId,
			purchaseorderdetails.intMatDetailID,
			matitemlist.strItemDescription,
			purchaseorderdetails.strColor,
			purchaseorderdetails.strSize,
			purchaseorderdetails.strBuyerPONO,
			purchaseorderdetails.strRemarks,
			purchaseorderdetails.dblUnitPrice,
			purchaseorderdetails.dblPending
			FROM
			purchaseorderdetails
			Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
			Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
			WHERE
			purchaseorderdetails.intYear =  '$year' AND
			purchaseorderdetails.intPoNo =  '$poNo' AND
			purchaseorderdetails.dblPending >  '0' 	";		
	
				$result = $db->RunQuery($SQL);
				
			$header = " <tr>
              <td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" height=\"22\">Del</td>
              <td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style Id </td>
              <td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discription</td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>
              <td width=\"7%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>
              <td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PoNo </td>
              <td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks </td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Unit Price </td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>
              <td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Value</td>
            </tr>";
				
				
/*							<div align=\"center\" ><img src=\"../images/del.png\"  border=\"0\" alt=\"search\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"removeRow(this);\"/></div>	*/
				while($row = mysql_fetch_array($result))
				{
					$qty = (float)$row["dblPending"];
					$unitPrice = number_format((float)$row["dblUnitPrice"],2);
					$value = number_format(($unitPrice * (float)$row["dblPending"]),2);
					$tableString .= "
					<tr id=\"".$row["intMatDetailID"]."\" >
				<td height=\"18\">

				<div align=\"center\"><input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"rowclickColorChange(this);\" />
				</div>
				</td>
				<td class=\"normalfnt\">".$row["intStyleId"]."</td>
				<td class=\"normalfnt\">".$row["strItemDescription"]."</td>
				<td class=\"normalfnt\">".$row["strColor"]."</td>
				<td class=\"normalfnt\">".$row["strSize"]."</td>
				<td class=\"normalfnt\">".$row["strBuyerPONO"]."</td>
				<td class=\"normalfnt\">".$row["strRemarks"]."</td>
				<td class=\"normalfnt\">".$unitPrice."</td>
				<td class=\"normalfnt\"><input name=\"txtQty\" type=\"text\" class=\"txtbox\" id=\"$qty\" size=\"12\" value='$qty' style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal2(this, 4,event);\" onkeyup=\"validNum(this);\" /></td>
				<td class=\"normalfntRite\" >$value</td>
			</tr>
					
					";
				}
				echo $header.$tableString;
} 

if($id=="getGRNDetails")
{
	$intGrnNo           =$_GET["poNo"];
	$intGrnYear         =$_GET["year"];
	$intCompanyId		=$_SESSION["FactoryID"];
	$intUserId		= 	$_SESSION["UserID"];
	
	
	$SQLSTN = "select * from grnheader where intGrnNo='$intGrnNo' and intGRNYear='$intGrnYear' ";
	$RESULTstn = $db->RunQuery($SQLSTN);
	
	while($rwSTN = mysql_fetch_array($RESULTstn))
	{
		$GRNstnNo = $rwSTN["intSTNno"];
	}
	
	//Get main Store ID & Stock
	if($GRNstnNo != '')
	{
		$SQLmainStore = "SELECT strMainID FROM mainstores WHERE intCompanyId='$intCompanyId' AND intAutomateCompany ='1' AND intStatus ='1'";
		/*$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo=$GRNstnNo AND intDocumentYear=$intGrnYear AND strType='STNT'";*/
		
		}
	else
	{
		$SQLmainStore = "SELECT strMainID FROM mainstores WHERE intCompanyId='$intCompanyId' AND intStatus ='1' and intAutomateCompany ='0'";
		
		/*$STNSQL = "SELECT * FROM stocktransactions where intDocumentNo=$intGrnNo AND intDocumentYear=$intGrnYear AND strType='GRN'";*/
		}
		
		
	
	$reStore = $db->RunQuery($SQLmainStore);
		while($rowS = mysql_fetch_array($reStore))
			{
				$MainStoreID = $rowS["strMainID"];
			}
			
	//$pSQL = "SELECT * FROM grndetails where intGrnNo=$intGrnNo AND intGRNYear=$intGrnYear";
	$pSQL = " SELECT g.intGrnNo, g.intGRNYear, g.intStyleId, g.strBuyerPONO, g.intMatDetailID,
			g.strColor, g.strSize, g.dblQty, g.dblPaymentPrice, g.dblPoPrice, m.strItemDescription 
			FROM grndetails g INNER JOIN matitemlist m on m.intItemSerial = g.intMatDetailID
			 where g.intGrnNo='$intGrnNo' AND g.intGRNYear='$intGrnYear' ";
			 
	$pResult = $db->RunQuery($pSQL);
	
	$header = " <tr>
              <td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" height=\"22\">Sel</td>
              <td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style Id </td>
              <td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discription</td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>
              <td width=\"7%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>
              <td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PoNo </td>
              <td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks </td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Unit Price </td>
              <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>
              <td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Value</td>
            </tr>";
			
			
	while($row = mysql_fetch_array($pResult))
			{
			   $intStyleId		=$row["intStyleId"];
			   $intMatDetailID	=$row["intMatDetailID"];
			   $strColor		=$row["strColor"];
			   $strSize		    = $row["strSize"];
			   $strBuyerPONO	=$row["strBuyerPONO"];
			   $GRNdblQty			=$row["dblQty"];
					   
			   $SQLStock = "SELECT SUM(dblQty) AS StockQty FROM stocktransactions WHERE intStyleId='$intStyleId' AND strBuyerPONO = '$strBuyerPONO' AND intMatDetailId = '$intMatDetailID' AND strColor='$strColor' AND strSize='$strSize' AND strMainStoresID = '$MainStoreID'";
					
					   $resStock =  $db->RunQuery($SQLStock);
					   
				   while($rowST = mysql_fetch_array($resStock))
				   {
						$StockQty = $rowST["StockQty"];
						/*$tableString .= "<tr >
						<td height=\"18\">
		
										</td>
						<td class=\"normalfnt\" >".$StockQty."</td>
						</tr>";  */
						if($StockQty < $GRNdblQty || $StockQty==0)
						{
							//echo "Some items hasn't quntity in stock . So you can't cancel this grn.";
							//return;
						}
						else
						{
						
						 
							$SQLMRN = " SELECT SUM(dblQty) AS MRNqty FROM matrequisitiondetails md INNER JOIN matrequisition m ON
md.intMatRequisitionNo = m.intMatRequisitionNo and md.intYear = m.intMRNYear
  WHERE intStyleId='$intStyleId' AND strBuyerPONO='$strBuyerPONO' AND strMatDetailID ='$intMatDetailID' AND strColor='$strColor' AND strSize='$strSize' AND
strMainStoresID='$MainStoreID' ";
					   
					  $resMRN =  $db->RunQuery($SQLMRN);
					   
						   while($rowM = mysql_fetch_array($resMRN))
						   {
														
								if($rowM["MRNqty"]>0)
								{
									//echo "Items already MRN. Can't cancel GRN ";
									//return;
								}
								else
								{
									$StyleName = StyleName($intStyleId);
								$buyerPOName = getBuyerPOName($intStyleId,$row["strBuyerPONO"]);
								
								//$StyleName = '12';
								$qty = (float)$GRNdblQty;
							$unitPrice = number_format((float)$row["dblPoPrice"],2);
							$value = number_format(($unitPrice * (float)$GRNdblQty),2);
							
							$tableString .= "
							<tr id=\"".$row["intMatDetailID"]."\" >
						<td height=\"18\">
		
						<div align=\"center\"><input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"rowclickColorChange(this);\" />
						</div>
						</td>
						<td class=\"normalfnt\" id=\"".$intStyleId."\">".$StyleName."</td>
						<td class=\"normalfnt\">".$row["strItemDescription"]."</td>
						<td class=\"normalfnt\">".$row["strColor"]."</td>
						<td class=\"normalfnt\">".$row["strSize"]."</td>
						<td class=\"normalfnt\" id=\"".$row["strBuyerPONO"]."\">".$buyerPOName."</td>
						<td class=\"normalfnt\">".$row["strRemarks"]."</td>
						<td class=\"normalfnt\">".$unitPrice."</td>
						<td class=\"normalfnt\"><input name=\"txtQty\" type=\"text\" class=\"txtbox\" id=\"$qty\" size=\"12\" value='$qty' style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal2(this, 4,event);\" onkeyup=\"validNum(this);\" /></td>
						<td class=\"normalfntRite\" >$value</td>
					</tr>
							
							";
								}
							}
						}
				}	   
					   
			}
	echo $header.$tableString;
}

function StyleName($styleID)
{
	global $db;
	$SQL = " SELECT strStyle FROM orders WHERE intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strStyle"];
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

?>