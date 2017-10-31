<?php
	session_start();
	
	include "../../Connector.php";

	$intPaymentNo=$_GET["PayNo"];
	$strPaymentType=$_GET["strPaymentType"];

	$STRUSER="";
	$strFactory="";
	//$report_companyId=$_SESSION['UserID'];
	$report_companyId=$_SESSION['FactoryID'];
	$backwardseperator 	= "../../";
	//echo $strPaymentType;
	//echo ("ddd");
	$printType="DUPLICATE";
	$sqlChkOD="select intPrintStaus from advancepayment where advancepayment.PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType';";
	$resChk=$db->RunQuery($sqlChkOD);
	while($row=mysql_fetch_array($resChk)){
	if($row['intPrintStaus'] == 0)
		$printType="ORIGINAL";
		$sqlUp="update advancepayment set intPrintStaus=1 where advancepayment.PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType';";
		$resUp=$db->RunQuery($sqlUp);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADVANCE PAYMENT</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$strSQL= "SELECT
companies.strName,
companies.strAddress1,
companies.strAddress2,
companies.strCity,
strCountry,
companies.strPhone,
companies.strFax,
companies.strEMail,
companies.strWeb,
companies.strComCode,
country.strCountry
FROM
companies
Inner Join country ON companies.intCountry = country.intConID
WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;

$result=$db->RunQuery($strSQL);

while($row = mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] ;//+ " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
	$strFactory=$row["strComCode"];
	
}
	 $strSQL="SELECT advancepayment.intPaymentNo,advancepayment.intUserID,advancepayment.dtmPayDate,suppliers.strTitle FROM advancepayment 
	              INNER JOIN suppliers ON advancepayment.intSupplierId =  suppliers.strSupplierID 
				  WHERE advancepayment.intPaymentNo = $intPaymentNo AND advancepayment.strType='$strPaymentType'";


$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtmPayDate"];
	$STRUSER=$row["intUserID"];
}

?>
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
      	<td> <?php include('../../reportHeader.php'); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="4" class="head2">ADVANCE PAYMENT- <?php 
																		if($strPaymentType=="S")
																		{
																			echo(strtoupper("Style"));
																		}
																		else if($strPaymentType=="G")
																		{
																			echo(strtoupper("General"));
																		}
																		else if($strPaymentType=="B")
																		{
																			echo(strtoupper("Bulk"));
																		}
																		 ?></td> <td class="tablezRED style6" style="text-align:center"><?php echo($printType); ?></td>
      </tr>
      <tr>
        <td width="8%" class="normalfnth2B">PAYEE</td>
        <td width="40%" class="normalfnt"><?php echo($payee); ?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">PAYMENT NO</td>
        <td width="27%" class="normalfnt"><?php echo($intPaymentNo); ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">DATE</td>
        <td class="normalfnt"><?php echo($date); ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
        <td width="36%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT</td>
        <td width="10%" class="normalfntBtab">TAX</td>
        <td width="13%" class="normalfntBtab">CHARGES</td>
        <td width="11%" class="normalfntBtab">DISCOUNT</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		$total = 0;

		$strSQL="SELECT (dblFreightCharge+dblCourierCharge+dblBankCharge) AS charges,dblDiscount,dblPoAmt,dblTaxAmt,dblTotAmt 
		           FROM advancepayment WHERE intPaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType'";
	//echo $strSQL;

	$result=$db->RunQuery($strSQL);
	
	while($row = mysql_fetch_array($result))
	{ 
		?>
      <tr>
        <td class="normalfntTAB"><?php echo  $row["strDescription"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["dblPoAmt"],4))  ; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["dblTaxAmt"],4)) ; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["charges"],4))  ; ?></td>
        <td class="normalfntMidTAB"><?php echo(number_format($row["dblDiscount"],4))  ; ?></td>
        <td class="normalfntRiteTAB"><?php 
		
		$total += $row["dblTotAmt"];
		
		echo(number_format($row["dblTotAmt"],4)); ?></td>
        </tr>
		<?php
		}
		?>

      <tr>
        <td class="normalfnth2Bm">Grand Total</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="nfhighlite1"><?php echo(number_format($total,4))  ; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="25%" height="25" class="normalfntBtab">ACCOUNT</td>
        <td width="15%" class="normalfntBtab">A/C CODE</td>
        <td width="15%" class="normalfntBtab">AMOUNT</td>
        <!--<td width="35%" class="normalfntBtab">ADDRESS</td>-->
        </tr>
			<?php
		   $total = 0;
						
			$strSQL = "SELECT
						glaccounts.strDescription,
						advancepaymentsglallowcation.Amount,
						glaccounts.strAccID,
						companies.strName
						FROM
						advancepayment
						Inner Join advancepaymentsglallowcation ON advancepayment.intPaymentNo = advancepaymentsglallowcation.paymentNo 
						AND advancepayment.strType = advancepaymentsglallowcation.strType
						Inner Join glaccounts ON advancepaymentsglallowcation.glAccNo = glaccounts.strAccID
						Inner Join companies ON advancepayment.intCompanyId = companies.intCompanyID
						WHERE
						advancepayment.intPaymentNo =  '$intPaymentNo' AND advancepayment.strType = '$strPaymentType'";			
		
//echo($strSQL);

	$result=$db->RunQuery($strSQL);
	
	    while($row = mysql_fetch_array($result))
	   { 
		?>
      <tr>
        <td height="18" class="normalfntTAB"><?php echo  $row["strDescription"]; ?></td>
        <td class="normalfntTAB"><?php echo  $row["strAccID"]; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php echo(number_format($row["Amount"],4))  ; ?></td>
        <!--<td class="normalfntTAB"  style="text-align:left"><?php echo  $row["strName"]; ?></td>-->
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
        <td width="20%" class="normalfnt">PREPARED BY</td>
        <td width="25%" class="bcgl1txt1"><?php 
		
		$SQL = "select Name from useraccounts where intUserID ='$STRUSER'";//" . $_SESSION["UserID"] ;
		$result = $db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">CHECKED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">AUTHORIZED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">APPROVED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">RECEIVED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
