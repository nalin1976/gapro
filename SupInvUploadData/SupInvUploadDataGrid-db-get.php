<?php
session_start();
include "../Connector.php";
$compCode=$_SESSION["FactoryID"];

$RequestType = $_GET["RequestType"];

if($RequestType=="loadSerialNo")
{
 $strSQL2		=	"update syscontrol set  dblSupInvUploadDataNo= dblSupInvUploadDataNo+1  WHERE syscontrol.intCompanyID='$compCode'";
 $result_update	=	$db->RunQuery($strSQL2);
 header('Content-Type: text/xml'); 
 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $ResponseXML .= "<loadSerialNo>";
    $strSQL			=	"SELECT dblSupInvUploadDataNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
	$result			=	$db->RunQuery($strSQL);
	 while($row = mysql_fetch_array($result))
	 { 
	  $ResponseXML .= "<serialNo><![CDATA[" . $row["dblSupInvUploadDataNo"]  . "]]></serialNo>\n";	
	 }
	$ResponseXML .= "</loadSerialNo>";
	echo $ResponseXML;	
}

//------------------------------------------------------------------------------------------------


if($RequestType=="loadSupInvoice")
{
 header('Content-Type: text/xml'); 
 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 $hiddenSupId = $_GET["hiddenSupId"];
 
 $ResponseXML .= "<SupInvoice>";
 		 $ResponseXML .= "

				<tr class='mainHeading4'>
                    <td>#</td>
                    <td>Invoice No</td>
                    <td>Date</td>
                    <td>Amount</td>
                    <td>Description</td>
                    <td>GRN Amt</td>
					<td>Amt + NBT</td>
					<td>Tot Amt</td>
					<td>Currency</td>
					<td>PO</td>
					<td>Cost Center</td>
					<td>GL Acc</td>";
	 $sql3 = "SELECT taxtypes.strTaxType,taxtypes.dblRate FROM taxtypes Inner Join glaccounts ON taxtypes.intGLId = glaccounts.intGLAccID order by taxtypes.strTaxType";
	 $result3 = $db->RunQuery($sql3);	
	 $a=0;	   
	 while($row3 = mysql_fetch_array($result3))
	 { 
	  $a++;
	  $ResponseXML .= "<td>Tax $a</td>
			           <td>Value $a</td>";
	 }

	$ResponseXML .= "</tr>";
					
  $sql1 = "SELECT
			invoiceuploaddetails.strInvoiceNo,
			invoiceuploaddetails.dblAmount,
			invoiceuploaddetails.dtmInvoiceDate,
			suppliers.strTitle
			FROM
			invoiceuploadheader
			Inner Join invoiceuploaddetails ON invoiceuploadheader.intSerialNo = invoiceuploaddetails.intSerialNo
			Inner Join suppliers ON invoiceuploadheader.intSupplierId = suppliers.strSupplierID
 
			WHERE
            invoiceuploadheader.intSupplierId =  '$hiddenSupId'";
 $result1 = $db->RunQuery($sql1);	
 while($row1 = mysql_fetch_array($result1))
 { 
  $strInvoiceNo = $row1["strInvoiceNo"]; 
  $dtmInvoiceDate = $row1["dtmInvoiceDate"]; 
  $dblAmount = $row1["dblAmount"]; 
  $strTitle = $row1["strTitle"]; 
  $sup = substr($strTitle,0,5);
  $sql2 = "SELECT
			grnheader.intPoNo,
			grnheader.intYear,
			Sum(grndetails.dblValueBalance) AS grnAmount,
			currencytypes.strCurrency,
			costcenters.strDescription AS costcenter
			FROM
			grnheader
			Inner Join grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
			Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
			Inner Join currencytypes ON purchaseorderheader.strCurrency = currencytypes.intCurID
			Inner Join costcenters ON costcenters.intCostCenterId = purchaseorderheader.intSewCompID

			WHERE grnheader.strInvoiceNo = '$strInvoiceNo' group by grnheader.strInvoiceNo";
			
  $result2 = $db->RunQuery($sql2);
   if(mysql_num_rows($result2)){
   $i=0;
     while($row2 = mysql_fetch_array($result2))
     { 
	 $i++;
	 $intPoNo = $row2["intPoNo"]; 
	 $intYear = $row2["intYear"]; 
     $des = $sup."-".$strInvoiceNo."-".$intPoNo."-".$intYear;
	 $grnAmount = $row2["grnAmount"]; 
	 
	 $nbt = $grnAmount * 8/100;
	 $amtWithNBT = $grnAmount + $nbt;
	 
	 $strCurrency = $row2["strCurrency"]; 
	 $costcenter  = $row2["costcenter"]; 
	 
	 $ResponseXML .= "<tr class='bcgcolor-tblrowWhite'>";
	  $ResponseXML .="<td class='normalfnt'>$i</td>";
	  $ResponseXML .="<td class='normalfnt'>$strInvoiceNo</td>";
	  $ResponseXML .="<td class='normalfnt'>$dtmInvoiceDate</td>";
	  $ResponseXML .="<td class='normalfntRite'>$dblAmount</td>";
	  $ResponseXML .="<td class='normalfnt'>$des</td>";
	  $ResponseXML .="<td class='normalfntRite'>$grnAmount</td>";
	  $ResponseXML .="<td class='normalfntRite'>$amtWithNBT</td>";
	  $ResponseXML .="<td class='normalfnt'></td>";
	  $ResponseXML .="<td class='normalfnt'>$strCurrency</td>";
	  $ResponseXML .="<td class='normalfnt'>$intPoNo</td>";
	  $ResponseXML .="<td class='normalfnt'>$costcenter</td>";
	  $ResponseXML .="<td class='normalfnt'>GLAcc</td>";
	  
	 $sql3 = "SELECT taxtypes.strTaxType,taxtypes.dblRate FROM taxtypes Inner Join glaccounts ON taxtypes.intGLId = glaccounts.intGLAccID order by taxtypes.strTaxType";
	  $result3 = $db->RunQuery($sql3);	
	 	   
	 while($row3 = mysql_fetch_array($result3))
	 { 
	  $strTaxType = $row3["strTaxType"]; 
	  $ResponseXML .="<td class='normalfnt'>$strTaxType</td>";
	  $dblRate = $row3["dblRate"]; 
	  $taxAmt = $dblAmount * dblRate/100;
	  $ResponseXML .="<td class='normalfntRite'>$taxAmt</td>";
	 }
	  
	 $ResponseXML .= "</tr>";
	 
	 }
   }
 }	
 $ResponseXML .= "</SupInvoice>";
 echo $ResponseXML;		
}

?>