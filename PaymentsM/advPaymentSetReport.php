<?php
include "../Connector.php";
$backwardseperator = "../";
include "{$backwardseperator}authentication.inc";

$userId	= $_GET["UserId"];
$report_companyId  = $_SESSION["FactoryID"];
$SupID	= $_GET["cboSuppliers"];
$type      	    = $_GET["type"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Advance Payment Settlement Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  </table>
 <table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">
<?php
   if($type == 'S'){
   	$strSQL="	SELECT DISTINCT
				purchaseorderheader.strSupplierID,
				purchaseorderheader.intYear,
				purchaseorderheader.intPONo,
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) as po,
				(purchaseorderheader.dblPOValue ) AS dblPOValue,
				purchaseorderdetails.intStyleId,
				advancepaymentpos.dblpaidAmount as paidAmount, 
				if(isnull(purchaseorderheader.dblPOSettledAmt),0,purchaseorderheader.dblPOSettledAmt) as settledAmt,
				advancepaymentpos.intPaymentNo,
               (advancepaymentpos.dblpaidAmount + if(isnull(purchaseorderheader.dblPOSettledAmt),0,purchaseorderheader.dblPOSettledAmt))AS dblPoBalance,
			    suppliers.strTitle
				FROM
				purchaseorderdetails
				Inner Join purchaseorderheader ON (purchaseorderdetails.intPoNo = purchaseorderheader.intPONo) 
				AND (purchaseorderdetails.intYear = purchaseorderheader.intYear)
				Inner Join popaymentterms ON (purchaseorderheader.strPayTerm = popaymentterms.strPayTermId)
				Left Join purchaseorderheader_excess ON purchaseorderheader.intPONo = purchaseorderheader_excess.intPONo
				Inner Join advancepaymentpos ON purchaseorderheader.intPONo = advancepaymentpos.intPOno
				Left Join grnheader ON purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
				Left Join grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
				Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
				WHERE  popaymentterms.intAdvance='1' AND intSurended != 1 ";
				
				if($SupID != ' '){
				$strSQL .=" AND purchaseorderheader.strSupplierID = '$SupID'";
				}
				
				$strSQL .=" GROUP BY  purchaseorderheader.strSupplierID,
				purchaseorderheader.intYear,  
				purchaseorderheader.intPONo
				ORDER BY advancepaymentpos.intPaymentNo,purchaseorderdetails.intPoNo,suppliers.strTitle";
   }
   else if($type == 'B'){
    $strSQL = "SELECT DISTINCT
				bulkpurchaseorderheader.strSupplierID,
				bulkpurchaseorderheader.intYear,
				bulkpurchaseorderheader.intBulkPoNo as intPONo,
				concat(bulkpurchaseorderheader.intYear,'/',bulkpurchaseorderheader.intBulkPoNo) as po,
				
				(bulkpurchaseorderheader.dblTotalValue ) AS dblPOValue,
				0 as intStyleId,
				advancepaymentpos.paidAmount as paidAmount, 
				if(isnull(bulkpurchaseorderheader.dblPOSettledAmt),0,bulkpurchaseorderheader.dblPOSettledAmt) as settledAmt,
				advancepaymentpos.PaymentNo,
               (advancepaymentpos.paidAmount + if(isnull(bulkpurchaseorderheader.dblPOSettledAmt),0,bulkpurchaseorderheader.dblPOSettledAmt))AS dblPoBalance,
			    suppliers.strTitle
				FROM
				bulkpurchaseorderdetails
				Inner Join bulkpurchaseorderheader ON (bulkpurchaseorderdetails.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo) 
				AND (bulkpurchaseorderdetails.intYear = bulkpurchaseorderheader.intYear)
				Inner Join popaymentterms ON (bulkpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)			
				Inner Join advancepaymentpos ON bulkpurchaseorderheader.intBulkPoNo = advancepaymentpos.POno
				Left Join bulkgrnheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intYear
				Left Join bulkgrndetails ON bulkgrnheader.intBulkGrnNo = bulkgrndetails.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear
				Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
				WHERE popaymentterms.intAdvance='1' AND intSurended != 1 AND advancepaymentpos.strType='B' ";
				if($SupID != ''){
				$strSQL .=" AND purchaseorderheader.strSupplierID = '$SupID'";
				}
				$strSQL .=" GROUP BY  bulkpurchaseorderheader.strSupplierID,
				bulkpurchaseorderheader.intYear,  
				bulkpurchaseorderheader.intBulkPONo
				ORDER BY advancepaymentpos.PaymentNo,bulkpurchaseorderdetails.intBulkPoNo,suppliers.strTitle";
   }
   //echo $strSQL;
   $result=$db->RunQuery($strSQL);
   
      $flg_newpgyn  = ""; 
      $flg_firstyn  = "";
      $flg_newdocyn = "";
      $te_docmain   = ""; 
	  
	  $te_totPaidAmount = 0;
	  $te_totSettledAmt = 0;
	  $te_totPoBalance  = 0;
	  
	 while($row = mysql_fetch_array($result))
	 {
	  $strSupplierID = $row["strTitle"];
	  $paidAmount = $row["paidAmount"];
	  $settledAmt = $row["settledAmt"];
	  $dblPoBalance = $row["dblPoBalance"];
	   
	  $te_totPaidAmount   += $paidAmount;
	  $te_totSettledAmt   += $settledAmt;
	  $te_totPoBalance    += $dblPoBalance;
	 
    if($te_docmain != $strSupplierID)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $strSupplierID;
	
	if($flg_newdocyn== "y" || $flg_newpgyn == "y")
    {
	?>
   
  <thead>
  <tr>
    <td class="normalfnt" colspan="6"><b>Supplier  &nbsp - &nbsp;<?php echo $strSupplierID;?></b></td>
  </tr>
    <tr>
     <td colspan="6" class="normalfnt2bldBLACKmid">Advance Payment Settlement Report</td>
  </tr>
  
   <tr>
    <td class="normalfntMid"><b>Payment No</b></td>
    <td class="normalfntMid"><b>Advance Paid</b></td>
    <td class="normalfntMid"><b>PO No</b></td>
    <td class="normalfntMid"><b>PO Amount</b></td>
	<td class="normalfntMid"><b>Set Amount</b></td>
	<td class="normalfntMid"><b>Balance</b></td>
   </tr>
  </thead>
  
  
	<?php
	} 
	?>
   <tr>
    <td class="normalfntMid"><?php echo $row["intPaymentNo"];?></td>
    <td class="normalfntRite"><?php echo $row["paidAmount"];?></td>
    <td class="normalfntRite"><?php echo $row["po"];?></td>
    <td class="normalfntRite"><?php echo $row["dblPOValue"];?></td>
	<td class="normalfntRite"><?php echo $row["settledAmt"];?></td>
	<td class="normalfntRite"><?php echo $row["dblPoBalance"];?></td>
   </tr>
   <?php
	 $flg_firstyn  = "n";
     $flg_firstyn2 = "n"; 
  }
  ?>
   <tr>
    <td class="normalfnt2bldBLACKmid">TOTAL</td>
    <td class="normalfntRite"><b><?php echo $te_totPaidAmount;?></b></td>
	<td class="normalfnt"></td>
	<td class="normalfnt"></td>
	<td class="normalfntRite"><b><?php echo $te_totSettledAmt;?></b></td>
	<td class="normalfntRite"><b><?php echo $te_totPoBalance;?></b></td>
   </tr>
 </table>
</body>
</html>
