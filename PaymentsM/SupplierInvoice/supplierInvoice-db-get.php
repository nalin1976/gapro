<?php
session_start(); 
include "../../Connector.php";
$request = $_GET["request"];
if($request=='loadTxtDetails')
{
	$supplierID= $_GET['supplierID'];
	
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLSupplierAccountCredit>";
	$sql="SELECT  suppliers.strAccPaccID,suppliers.intCreditPeriod FROM suppliers WHERE suppliers.strSupplierID ='$supplierID'";
	$result=$db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	 {
		while($row=mysql_fetch_array($result))
		{
		$ResponseXML.="<strAccPaccID><![CDATA[" . $row["strAccPaccID"]  . "]]></strAccPaccID>";
		$ResponseXML.="<intCreditPeriod><![CDATA[" . $row["intCreditPeriod"]  . "]]></intCreditPeriod>";
		}
		$ResponseXML.="</XMLSupplierAccountCredit>";
		echo $ResponseXML;
	 }
	 else
	 {
		$ResponseXML.="<strAccPaccID><![CDATA[]]></strAccPaccID>";
		$ResponseXML.="<intCreditPeriod><![CDATA[]]></intCreditPeriod>"; 
		$ResponseXML.="</XMLSupplierAccountCredit>";
		echo $ResponseXML;
	 }
}

else if($request=='loadGridDetails')
{
    $supplierID= $_GET['supplierID'];
	$sqlGrid="SELECT
			suppliers.strTitle,
			grnheader.strInvoiceNo,
			sum(grndetails.dblValueBalance) AS TotQTY,
			invoiceheader.strDescription
			FROM
			suppliers
			INNER JOIN purchaseorderheader ON suppliers.strSupplierID = purchaseorderheader.strSupplierID
			INNER JOIN grnheader ON purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
			INNER JOIN grndetails ON grnheader.intGRNYear = grndetails.intGRNYear AND grnheader.intGrnNo = grndetails.intGrnNo
			INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = grnheader.strInvoiceNo
			WHERE suppliers.strSupplierID='$supplierID'
			GROUP BY
			suppliers.strSupplierID,
			grnheader.strInvoiceNo";	
	$resultGrid=$db->RunQuery($sqlGrid);
	if(mysql_num_rows($resultGrid)>0)
	 {	$i=1;
		while($rowGrid=mysql_fetch_array($resultGrid))
		{
		
		         echo"<tr>
                        <td width=\"40\" height=\"22\" class=\"normalfnt\" style=\"padding-left:23px;\"><input type=\"checkbox\" name=\"chkInvoive\" id=\"chkInvoive\"  /></td>
                        <td width=\"102\" class=\"normalfnt\"style=\"padding-left:13px;\">".$rowGrid['strInvoiceNo']."</td>
                        <td width=\"302\" class=\"normalfnt\"style=\"padding-left:13px;\">".$rowGrid['strDescription']."</td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\" >".$rowGrid['TotQTY']."</td>
                        <td width=\"115\" class=\"normalfnt\" ><input type=\"text\" name=\"txtCommission\" id=\"txtCommission\"  style=\"height:15px; text-align:right;\" maxlength=\"30\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"/></td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\">&nbsp;</td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\">&nbsp;</td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\">&nbsp;</td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\">&nbsp;</td>
                        <td width=\"115\" class=\"normalfnt\"style=\"padding-left:13px;\">&nbsp;</td>
                        <td width=\"115\" class=\"normalfnt\" ><input type=\"text\" name=\"txtFreight\" id=\"txtFreight\"  style=\"height:15px; text-align:right;\" maxlength=\"30\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"/></td>
                        <td width=\"115\" class=\"normalfnt\" ><input type=\"text\" name=\"txtInsurance\" id=\"txtInsurance\"  style=\"height:15px; text-align:right;\" maxlength=\"30\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"/></td>
                        <td width=\"115\" class=\"normalfnt\" ><input type=\"text\" name=\"txtOther\" id=\"txtOther\"  style=\"height:15px;text-align:right;\"  maxlength=\"30\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"/></td>
                       </tr>"; 
		$i++;
			
		}
	 }
	 else
	 {
		return;
	 }
	
}

?>