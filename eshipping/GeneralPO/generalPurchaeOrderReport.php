<?php
session_start();
include "../../Connector.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eplan Web - Genaral Po :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.style4 {
		font-size: xx-large;
		color: #FF0000;
	}
	.style3 {
		font-size: xx-large;
		color: #FF0000;
	}
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php
	
			$bulkPoNo=$_GET["bulkPoNo"];
			$intYear=$_GET["intYear"];

		$strSQL="		SELECT
						generalpurchaseorderheader.intGenPONo,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.dtmDate,
						generalpurchaseorderheader.intStatus,
						generalpurchaseorderheader.dtmDeliveryDate,
						generalpurchaseorderheader.strCurrency,
						companies.strName AS strName,
						companies.strAddress1 AS strAddress1,
						companies.strAddress2 AS strAddress2,
						companies.strStreet AS strStreet,
						companies.strCity AS strCity,
						companies.strCountry AS strCountry,
						companies.strPhone AS strPhone,
						companies.strEMail AS strEmail,
						companies.strFax AS strFax,
						companies.strWeb AS strWeb,
						popaymentmode.strDescription AS strPaymentMode,
						popaymentterms.strDescription AS strPayTerm,
						generalpurchaseorderheader.strPINO,
						dtoCompanies.strName AS dtostrName,
						dtoCompanies.strAddress1 AS dtostrAddress1,
						dtoCompanies.strAddress2 AS dtostrAddress2,
						dtoCompanies.strStreet AS dtostrStreet,
						dtoCompanies.strCity AS dtostrCity,
						dtoCompanies.strCountry AS dtostrCountry,
						dtoCompanies.strPhone AS dtostrPhone,
						dtoCompanies.strEMail AS dtostrEmail,
						dtoCompanies.strFax AS dtostrFax,
						dtoCompanies.strWeb AS dtostrWeb,
						invtoCompanies.strName AS invtostrName,
						invtoCompanies.strAddress1 AS invtostrAddress1,
						invtoCompanies.strAddress2 AS invtostrAddress2,
						invtoCompanies.strStreet AS invtostrStreet,
						invtoCompanies.strCity AS invtostrCity,
						invtoCompanies.strCountry AS invtostrCountry,
						invtoCompanies.strPhone AS invtostrPhone,
						invtoCompanies.strEMail AS invtostrEmail,
						invtoCompanies.strFax AS invtostrFax,
						invtoCompanies.strWeb AS invtostrWeb,
						suppliers.strTitle,
						generalpurchaseorderheader.intUserID AS UserID,
						generalpurchaseorderheader.intConfirmedBy AS AuthorizedBy
						FROM
						generalpurchaseorderheader
						Inner Join popaymentmode ON popaymentmode.strPayModeId = generalpurchaseorderheader.intPayMode
						Inner Join popaymentterms ON popaymentterms.strPayTermId = generalpurchaseorderheader.strPayTerm
						Inner Join companies ON companies.intCompanyID = generalpurchaseorderheader.intCompId
						Inner Join companies AS dtoCompanies ON dtoCompanies.intCompanyID = generalpurchaseorderheader.intDeliverTo
						Inner Join companies AS invtoCompanies ON invtoCompanies.intCompanyID = generalpurchaseorderheader.intInvoiceComp
						Inner Join suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID
						WHERE
						generalpurchaseorderheader.intGenPONo =  '$bulkPoNo' AND
						generalpurchaseorderheader.intYear =  '$intYear'
						";
				

					$result = $db->RunQuery($strSQL);
					
		
		while($row = mysql_fetch_array($result))
		{		
						$strBulkPONo		=$row["strBulkPONo"];
						$intYear			=$row["intYear"];
						$strName			=$row["strName"];
						$strAddress1		=$row["strAddress1"];
						$strAddress2		=$row["strAddress2"];
						$strStreet			=$row["strStreet"];
						$strCity			=$row["strCity"];
						$strCountry			=$row["strCountry"];
						$strPhone			=$row["strPhone"];
						$strEmail			=$row["strEmail"];
						$strFax				=$row["strFax"];
						$strWeb				=$row["strWeb"];
						$dtmDate				=$row["dtmDate"];
						$dtmDeliveryDate		=$row["dtmDeliveryDate"];
						$strCurrency		=$row["strCurrency"];
						$strPaymentMode		=$row["strPaymentMode"];
						//$strShipmentTerm	=$row["strShipmentTerm"];
						$strPayTerm			=$row["strPayTerm"];
						$strPINO			=$row["strPINO"];
						$intStatus			=$row["intStatus"];
						$dtostrName			=$row["dtostrName"];
						$dtostrAddress1		=$row["dtostrAddress1"];
						$dtostrAddress2		=$row["dtostrAddress2"];
						$dtostrStreet		=$row["dtostrStreet"];
						$dtostrCity			=$row["dtostrCity"];
						$dtostrCountry		=$row["dtostrCountry"];
						$dtostrPhone		=$row["dtostrPhone"];
						$dtostrEmail		=$row["dtostrEmail"];
						$dtostrFax			=$row["dtostrFax"];
						$dtostrWeb			=$row["dtostrWeb"];
						$invtostrName		=$row["invtostrName"];
						$invtostrAddress1	=$row["invtostrAddress1"];
						$invtostrAddress2	=$row["invtostrAddress2"];
						$invtostrStreet		=$row["invtostrStreet"];
						$invtostrCity		=$row["invtostrCity"];
						$invtostrCountry	=$row["invtostrCountry"];
						$invtostrPhone		=$row["invtostrPhone"];
						$invtostrEmail		=$row["invtostrEmail"];
						$invtostrFax		=$row["invtostrFax"];
						$invtostrWeb		=$row["invtostrWeb"];
						$strSupplierTitle 	= $row["strTitle"];
						$UserID 			= $row["UserID"];
						//$CheckedID 			= $row["CheckedID"];
						$AuthorisedID 		= $row["AuthorizedBy"];
						break;
		}
		
			echo $strName ?></p>
          <p class="normalfnt"><?PHP echo "$strAddress1 $strAddress2  $strStreet $strCity $strCountry . Tel: $strPhone  Fax: $strFax" ?> </p>
          <p class="normalfnt"><?php echo "E-Mail: $strEmail Web: $strWeb" ?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="5" class="head2"><p>GENERAL PURCHASE ORDER</p>
          <p>PO NO - <?php echo "$intYear/$bulkPoNo "?></p></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnth2B"> <?php echo $strSupplierTitle ?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">DELIVER TO:</td>
        <td width="27%" rowspan="4" valign="top" class="normalfnt"><?php echo "$dtostrName <br/> $dtostrAddress1 <br/> $dtostrAddress2 <br/> $dtostrStreet  <br> $dtostrCountry" ?></td>
      </tr>
      <tr>
        <td width="16%" class="normalfnth2B">P.O DATE</td>
        <td width="32%" class="normalfnt">: <?php echo substr("$dtmDate",0,10) ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">DELIVER DATE</td>
        <td class="normalfnt">: <?php echo substr("$dtmDeliveryDate",0,10) ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">PAYMENT MODE</td>
        <td class="normalfnt">: <?php echo "$strPaymentMode" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">PAYMENT TERMS</td>
        <td class="normalfnt">: <?php echo "$strPayTerm" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">INVOICE TO</td>
        <td rowspan="3" valign="top" class="normalfnt"><?php echo "$invtostrName <br/> $invtostrAddress1 <br/> $invtostrAddress2 <br/> $invtostrStreet  <br> $invtostrCountry" ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td height="26" class="normalfnth2B" style="text-align:center"> <?php 
		
		if($intStatus==10)
		{
			//echo "<span class=\"style4\">Cancelled General Po ";
		}
		elseif($intStatus==0)
		{
			echo "<span class=\"head2\">Not Approved";
		}
		?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="35%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="7%" class="normalfntBtab">UNIT</td>
        <td width="10%" class="normalfntBtab">RATE</td>
        <td width="8%" class="normalfntBtab">QTY</td>
        <td width="15%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
      <tr>
	  <?php 
	  	$strSQL = "SELECT
					generalpurchaseorderdetails.strUnit,
					generalpurchaseorderdetails.dblUnitPrice,
					generalpurchaseorderdetails.dblQty,
					genmatitemlist.strItemDescription as itemDescription
					FROM
					generalpurchaseorderdetails
					Inner Join genmatitemlist ON genmatitemlist.intItemSerial = generalpurchaseorderdetails.intMatDetailID
					WHERE
					generalpurchaseorderdetails.intGenPONo =  '$bulkPoNo' AND
					generalpurchaseorderdetails.intYear =   '$intYear'";
	  	$result = $db->RunQuery($strSQL);
		while($row = mysql_fetch_array($result))
		{
				$strDescription		=$row["itemDescription"];
				$strUnit			=$row["strUnit"];
				$dblUnitPrice		=$row["dblUnitPrice"];
				$dblQty				=$row["dblQty"];
				$totQty				+=$row["dblQty"];
	  
	  ?>
        <td class="normalfntTAB"><?php echo $strDescription  ?></td>
        <td class="normalfntTAB"><?php echo $strUnit  ?></td>
        <td class="normalfntMidTAB">
		<?php
			echo number_format($dblUnitPrice,4,".",",") ;
			//echo number_format($dblUnitPrice,2,".",",").  "(" . $strCurrency  . ")";
		?></td>
        <td class="normalfntRiteTAB"><?php echo $dblQty  ?></td>
        <td class="normalfntRiteTAB"><?php 
		
		$dblTotal =  $dblUnitPrice * $dblQty ;
		echo number_format($dblTotal,2,".",",");
		//echo number_format($dblTotal,2,".",",").  "(" . $strCurrency  . ")";
		$dblGrandTotal +=$dblTotal;
		  ?></td>
        </tr>
		<?php 
		
		}
		
		?>
      <tr>
			<td colspan="3" class="normalfntBtab">Grand Total</td>
			<td class="bigfntnm1rite" bgcolor="#CCCCCC"><?php echo $totQty  ?></td>
			<td class="bigfntnm1rite" bgcolor="#CCCCCC">
			<?php
				//$dblGrandTotal = number_format($dblGrandTotal,2,".",",");
				//echo $dblGrandTotal .  "(" . $strCurrency  . ")";
				if ($strCurrency != "")
				{
					$strCurrency = "(" . $strCurrency  . ")";
				}
					echo $strCurrency . number_format($dblGrandTotal,2,".",",");

			?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnth2B">Please supply accordance with the instructions herein the following:</td>
  </tr>
  <tr>
    <td colspan="2"><p class="normalfnth2B">Please indicate our PO No in all invoices, performa invoices, dispatch notes and all correspondance and deliver to above mentioned destination and invoice to the correct party.</p>
      <p class="normalfnth2B">Payment will be made in accordance with the stipulated quantities, prices and agreed terms and conditins.</p></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="13%" rowspan="2" class="normalfnt2bldBLACKmid">PREPARED BY :</td>
        <td width="17%" class="normalfntTAB2">
		<?php 
		
		$SQL_User="SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts
					WHERE (((useraccounts.intUserID)=".$UserID.")); ";
		$result_User = $db->RunQuery($SQL_User);
       if($row_user = mysql_fetch_array($result_User))
	   {
	   		echo $row_user["Name"];
	   }
	
		?>		</td>
        <td width="15%" rowspan="2" class="normalfnt2bldBLACKmid">CHECKED BY:</td>
        <td width="22%" class="normalfntTAB2">
        <?php /*?><?php 
		$SQL_Checked="SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts 
		WHERE (((useraccounts.intUserID)=".$CheckedID.")); ";
		$result_Checked = $db->RunQuery($SQL_Checked);
       if($row_check = mysql_fetch_array($result_Checked))
	   {
	   		echo $row_check["Name"];
	   }
	?><?php */?>        </td>
        <td width="7%">&nbsp;</td>
        <td width="26%" valign="top" class="normalfntTAB2">
          <?php 
		$SQL_Autho="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$AuthorisedID."));
";

		
		//echo $AuthorisedID;
		$result_Autho = $db->RunQuery($SQL_Autho);
       if($row_Autho = mysql_fetch_array($result_Autho))
	   {
	   	echo $row_Autho["Name"];
	   }
	?>         </td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">AUTHORISED BY</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid"><div align="center"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><?php 
	if($intStatus==0)
		include "genaralpoconfirmation.php"?></td>
  </tr>
</table>
<?php 
if($intStatus==10)
{
?>
<div style="position:absolute; top:200px; left:268px; width: 444px;">
<img src="../../images/cancelled.png" style="-moz-opacity:0.20;filter:alpha(opacity=20);"></div>
<?php
}
?>

</body>
</html>
