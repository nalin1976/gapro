<?php 
session_start();
if(!$authenticationApplied)
	include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$SCRequiredForPODetails = $xml->PurchaseOrder->SCRequiredForDetails;
$MatRatioIDRequiredForPoDetails = $xml->PurchaseOrder->MatRatioIDRequiredForDetails;
$DeliveryDateRequiredForDetails = $xml->PurchaseOrder->DeliveryDateRequiredForDetails;
$DisplayRevisionNoOnPOReport = $xml->PurchaseOrder->DisplayRevisionNoOnPOReport;
$DisplaySupplierCOdeOnReport = $xml->PurchaseOrder->DisplaySupplierCOdeOnReport;
$HighlightAdditionalPurchase = $xml->PurchaseOrder->HighlightAdditionalPurchase;
$ShowAccountsManager = $xml->PurchaseOrder->ShowAccountsManager;
$HighLightOverCostPO = $xml->PurchaseOrder->HighLightOverCostPO;
$ReportISORequired = $xml->companySettings->ReportISORequired;
$poStatus = 1;

//				$intPoNo="08/16841";
//				$intYear="8-8-2008";
				
				$intPoNo=$_GET["pono"];
			    $intYear=$_GET["year"];
				
				//$intPoNo="400055";
				//$intYear="2009";
				/*
				$SQL="SELECT purchaseorderdetails.intPoNo,purchaseorderdetails.intYear,orders.intStyleId, companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb
FROM companies INNER JOIN (purchaseorderdetails INNER JOIN orders ON purchaseorderdetails.intStyleId = orders.intStyleId) ON companies.intCompanyID = orders.intCompanyID
WHERE (((purchaseorderdetails.intPoNo)=".$intPoNo.")) and (((purchaseorderdetails.intYear)=".$intYear."));";

				*/
				$SQL = "SELECT purchaseorderheader.intPoNo,purchaseorderheader.intYear, purchaseorderheader.intStatus, companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, companies.strFax, companies.strVatAcNo, companies.strWeb
FROM companies INNER JOIN purchaseorderheader  ON companies.intCompanyID = purchaseorderheader.intInvCompID
WHERE (((purchaseorderheader.intPoNo)=$intPoNo)) and (((purchaseorderheader.intYear)=$intYear));";

				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{  
					$comName=$row["strName"];
					$comAddress1=$row["strAddress1"];
					$comAddress2=$row["strAddress2"];
					$comStreet=$row["strStreet"];
					$comCity=$row["strCity"];
					$comState=$row["strState"];
					$comCountry=$row["strCountry"];
					$comZipCode=$row["strZipCode"];
					$strPhone=$row["strPhone"];
					$comEMail=$row["strEMail"];
					$comFax=$row["strFax"];
					$comWeb=$row["strWeb"];
					$TQBNo=$row["strTQBNO"];
					$companyReg=$row["strRegNo"];
					$strVatNo = $row["strVatAcNo"];
					$poStatus = $row["intStatus"];
				$strAddress1new = trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
				$strAddress2new = trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
				$strStreetnew = trim($comStreet) == "" ? $comStreet : "," . $comStreet ;
				$strCitynew = trim($comCity) == "" ? $comCity : "," . $comCity;
				$strStatenew = trim($comState) == "" ? $comState : "," . $comState . "," ;
				}
				?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function sendEmail()
{
	var year = <?php echo  $_GET["year"];?>;
	var poNo = <?php echo  $_GET["pono"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	//if (checkemail(emailAddress))
	//{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'poemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
		xmlHttp.send(null);
	//}
}

function checkemail(str)
{
	var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function HandleEmail()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		
			if(xmlHttp.responseText == "True")
				alert("The Purchase Order has been emailed to the supplier.");
		}
	}
}


</script>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body>
<?php 
if($poStatus == 1)
{
?>
<div style="position:absolute;top:200px;left:300px;">
<img src="images/pending.png">
</div>
<?php
} 
else if($poStatus == 11)
{
?>
<div style="position:absolute;top:200px;left:400px;">
<img src="images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);">
</div>
<?php
}
?>
<table width="800" border="0" align="center" cellpadding="0">
  <tr>
    <td colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td width="67%" class="tophead"><p class="topheadBLACK"><?php echo $comName; ?></p>
					<p class="normalfnt"><?php echo "$strAddress1new $strAddress2new, <br/>$strStreetnew $strCitynew $strStatenew $comCountry<br/> <b>Tel: $strPhone".",".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb . "<br>"  . ($strVatNo==""?"":" VAT NO: $strVatNo") . "   &nbsp;&nbsp; " . ($companyReg==""?"":" ( Company Reg. No : $companyReg )")  . "</b>";?></p>
				<p class="normalfnt"></p>     			</td>
                 <td width="12%" class="tophead"><div class="head2BLCK"><?php
                 if($poStatus == 10)
                 {
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo $xmlISO->ISOCodes->StylePOReport;
						}              
	                 
                   ?></div><div align="center"><img src="images/btn-email.png" alt="Email" width="91" height="24" class="mouseover" onclick="sendEmail();" /></div>
						<?php
						}
						?>                   
                   </td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK">PURCHASE ORDER <?php
    
   if($poStatus == 1)
	{
		echo " - PENDING APPROVAL";
	}
	else if($poStatus == 11)
	{
		echo " - CANCEL";
	}

?></p>
      <p class="head2BLCK"><?php echo "PO NO -  $intYear / $intPoNo";?></p>
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td width="50%">&nbsp;</td>
          <?php
		  
		  	$strSupplierID="";
			$strTitle="";
			$strAddress1="";
			$strAddress2="";
			$strStreet="";
			$strCity="";
			$strState="";
			$strCountry="";
			$strPayMode="";
			$strPayTerm="";
			$strShipmentMode="";
			$strShipmentTerm="";
			$strInstructions="";
			$dtmDate="";
			$intInvCompID=0;
			$intDelToCompID=0;
			$dtmDeliveryDate="";
			$intPrintStatus=0;
			$UserID=0;
			$CheckedID=-1;
			$AuthorisedID=-1;
			$currencyTitle = "";
			$currencyFraction = "";
			$currencyRate = 1;
			
		    $PO_Details="SELECT purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.strPINO, purchaseorderheader.intConfirmedBy, purchaseorderheader.strSupplierID, suppliers.strTitle, suppliers.strAddress1, suppliers.strAddress2, suppliers.strStreet, suppliers.strCity,suppliers.strSupplierCode , suppliers.strState, suppliers.strCountry, purchaseorderheader.strPayMode, purchaseorderheader.strPayTerm, purchaseorderheader.strShipmentMode, purchaseorderheader.strShipmentTerm, purchaseorderheader.strInstructions, purchaseorderheader.dtmDate, purchaseorderheader.intInvCompID, purchaseorderheader.intDelToCompID, purchaseorderheader.dtmDeliveryDate, purchaseorderheader.intPrintStatus, purchaseorderheader.intUserID, purchaseorderheader.intRevisedBy, purchaseorderheader.intRevisionNo, purchaseorderheader.intCheckedBy,purchaseorderheader.strCurrency, currencytypes.strFractionalUnit,  currencytypes.strTitle as currencyTitle, currencytypes.dblRate AS currencyRate  
FROM suppliers INNER JOIN purchaseorderheader ON suppliers.strSupplierID = purchaseorderheader.strSupplierID inner join currencytypes on purchaseorderheader.strCurrency = currencytypes.strCurrency 
WHERE (((purchaseorderheader.intPONo)=".$intPoNo.")) and (((purchaseorderheader.intYear)=".$intYear."));
";	
			
		
			$result_pd = $db->RunQuery($PO_Details);
			while($row_pd = mysql_fetch_array($result_pd ))
			{
			
				$strSupplierID=$row_pd["strSupplierID"];
				$strTitle=$row_pd["strTitle"];
				$strAddress1=$row_pd["strAddress1"];
				$strAddress2=$row_pd["strAddress2"];
				$strStreet=$row_pd["strStreet"];
				$strCity=$row_pd["strCity"];
				$strState=$row_pd["strState"];
				$strCountry=$row_pd["strCountry"];
				$strPayMode=$row_pd["strPayMode"];
				$strPayTerm=$row_pd["strPayTerm"];
				$strShipmentMode=$row_pd["strShipmentMode"];
				$strShipmentTerm=$row_pd["strShipmentTerm"];
				$strInstructions=$row_pd["strInstructions"];
				$dtmDate=$row_pd["dtmDate"];
				$newpodate=substr($dtmDate,-19,10);
				$intInvCompID=$row_pd["intInvCompID"];
				$intDelToCompID=$row_pd["intDelToCompID"];
				$dtmDeliveryDate=$row_pd["dtmDeliveryDate"];
				$newdeldate=substr($dtmDeliveryDate,-19,10);
				$intPrintStatus=$row_pd["intPrintStatus"];
				$UserID=$row_pd["intUserID"];
				$CheckedID=$row_pd["intCheckedBy"];
				$AuthorisedID=$row_pd["intConfirmedBy"];
				$Currency=$row_pd["strCurrency"];
				$PINO=$row_pd["strPINO"];
				$currencyTitle = $row_pd["currencyTitle"];
				$revisionNo = $row_pd["intRevisionNo"]; 
				$currencyFraction = $row_pd["strFractionalUnit"]; 
				$supplierCode = $row_pd["strSupplierCode"];   
				$currencyRate = $row_pd["currencyRate"];  
				
				if ($CheckedID == "" || $CheckedID == null)
					$CheckedID = -1;
					
				if ($AuthorisedID == "" || $AuthorisedID == null)
					$AuthorisedID = -1;
				
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "," . $strState . "," ;
			}
		  ?>
          <td width="50%" class="normalfnth2Bm">
          <?php
		  $mes = "";
		  if($intPrintStatus==0)
		  {
		  	 $mes =  "(ORIGINAL)";
		  }
		  else 
		  {
		  	$mes = "(DUPLICATE)";
			
	      }
		  
		  if ($DisplayRevisionNoOnPOReport == "true")
			{
				if($revisionNo > 0)
			 	$mes .= " Revision No : " . $revisionNo ;
	
			}

		  echo $mes;
		  ?>          </td>
        </tr>
        
        <tr>
          <td><table width="100%" border="0" cellpadding="0">
            <tr>
              <td colspan="2"><table width="100%" border="0" cellpadding="0">
                <tr>
                  <td height="19" class="normalfnBLD1">Supplier Code </td>
                  <td width="65%" class="normalfnt"><?php
                  if ($DisplaySupplierCOdeOnReport == "true")
                   echo $supplierCode;
                   else
                   echo $strSupplierID;
                   
                   ?></td>
                </tr>
                <tr>
                  <td height="28" class="normalfnBLD1">Name</td>
                  <td class="normalfnt"><?php echo $strTitle;?></td>
                </tr>
                <tr>
                  <td class="normalfnBLD1">Address</td>
                  <td class="normalfnt"><?php
                  echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew $strCountry.";              
				  ?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="35%" class="normalfnBLD1">Pay.Method </td>
              <td width="65%" class="normalfnt"><?php 
			$SQL="select strDescription from popaymentmode where strPayModeId = '".$strPayMode."';";
			$mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$Description = $row["strDescription"];
			}
			  echo $Description;?></td>
            </tr>
            <tr>
              <td height="23" class="normalfnBLD1">Pay.Terms</td>
              <td class="normalfnt"><?php 
			$SQL="select strDescription from popaymentterms where strPayTermId = '".$strPayTerm."';";
			$mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$Description = $row["strDescription"];
			}
			  
			  echo $Description;?></td>
            </tr>
            <tr>
              <td class="normalfnBLD1">Ship.Method</td>
              <td class="normalfnt"><?php 
		    $SQL="select strDescription from shipmentmode where intShipmentModeId = '".$strShipmentMode."';";
		    $mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$Description = $row["strDescription"];
			}
			  
			  echo $Description;?></td>
            </tr>
            <tr>
              <td class="normalfnBLD1">Ship.Terms</td>
              <td class="normalfnt"><?php 
			$SQL="select strShipmentTerm from shipmentterms where strShipmentTermId = '".$strShipmentTerm."';";
		    $mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$Description = $row["strShipmentTerm"];
			}
			  echo $Description;?></td>
            </tr>
            <tr>
              <td class="normalfnBLD1">Instruction</td>
              <td class="normalfnt"><?php echo $strInstructions;?></td>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="0" cellpadding="0">
            <tr>
              <td width="34%" height="19" class="normalfnBLD1">P.O. Date</td>
              <td width="66%" class="normalfnt"><?php  echo $newpodate;?> </td>
            </tr>
            <tr>
              <td height="58" valign="top" class="normalfnBLD1">Deliver To </td>
              <?php
			  $DELTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.intCompanyID
FROM companies
WHERE (((companies.intCompanyID)=".$intDelToCompID."));";

				$result_del = $db->RunQuery($DELTO);
				if($row_del = mysql_fetch_array($result_del ))
				{
				$strAddress1=$row_del["strAddress1"];
				$strAddress2=$row_del["strAddress2"];
				$strStreet=$row_del["strStreet"];
				$strCity=$row_del["strCity"];
				$strState=$row_del["strState"];
                  
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "," . $strState . "," ;
				
				echo " <td valign=\"top\" class=\"normalfnt\"><p class=\"normalfnt\">".$row_del["strName"]."</p>";
					echo " <p class\"normalfnt\">";
					echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" . $row_del["strCountry"].".";
					echo "</p></td></tr>";
				  
				}
				else
				{
					echo " <td valign=\"top\" class=\"normalfnt\"><p class=\"normalfnt\"></p>";
					echo " <p class\"normalfnt\"></p></td></tr>";				
				}
			  ?>          
            <tr>
              <td height="50" valign="top" class="normalfnBLD1">Invoice To </td>
                          <?php
			  $INVTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.intCompanyID
FROM companies
WHERE (((companies.intCompanyID)=".$intInvCompID."));";
				
			
				$result_inv = $db->RunQuery($INVTO);
				if($row_inv = mysql_fetch_array($result_inv ))
				{
				  $strAddress1=$row_inv["strAddress1"];
				$strAddress2=$row_inv["strAddress2"];
				$strStreet=$row_inv["strStreet"];
				$strCity=$row_inv["strCity"];
				$strState=$row_inv["strState"];
                  
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "," . $strState . "," ;
				
				echo " <td valign=\"top\" class=\"normalfnt\"><p class=\"normalfnt\">".$row_inv["strName"]."</p>";
					echo " <p class\"normalfnt\">";
					echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" .$row_del["strCountry"].".";
					echo "</p></td></tr>";
				}
				else
				{
					echo " <td valign=\"top\" class=\"normalfnt\"><p class=\"normalfnt\"></p>";
					echo " <p class\"normalfnt\"></p></td></tr>";				
				}				
				
			  ?> 
          </table></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td width="272" height="22" class="normalfnBLD1TAB">REQUIRED DELIVERY DATE : <span class="normalfnt"><?php echo $newdeldate;?></span></td>
    <td width="273" class="normalfnBLD1TAB">Vat RegNo:<?php echo $VatRegNo ;?></td>
    <td width="227" class="normalfnBLD1TAB">PI No :<?php echo $PINO;?> </td>
    <td width="329" class="normalfnBLD1TAB">TQB No:<?php echo $TQBNo;?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td  bgcolor="#CCCCCC" class="bcgl1txt1B">Buyer PO </td>
        <td height="31" colspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B style1">Description</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Order#/ Sty #</td>
        <?php 
		if ($SCRequiredForPODetails == "true")
		{
		?>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B" width="6%">SC NO</td>
        <?php
		}
		if ($MatRatioIDRequiredForPoDetails == "true")
		{
		?>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Item Code</td>
        <?php
		}
		if ($DeliveryDateRequiredForDetails == "true")
		{
		?>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Del Date</td>
        <?php
		}
		?>
        
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">SIZE</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">COLOR</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">UNIT</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price (<?php echo $Currency; ?>) </td>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">QTY</td>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">VALUE</td>
        </tr>
       <?php
	  $totRATE_USD=0.0;
	  $totVALUE=0.0;
	  $totqty=0.0;
	  
	//  echo " <td class=\"normalfntBtab\">"."OD Qty:-". "24,000". "Was:-"."1"."%"."</td>";
	  
	  // coment by roshan for remove the TABLE ORDERDETAILS //
	  
/*	   $SL_PODATA="SELECT  matitemlist.strItemDescription,orderdetails.strOrderNo, purchaseorderdetails.strBuyerPONO, orderdetails.intStyleId, 
purchaseorderdetails.dtmItemDeliveryDate, purchaseorderdetails.strSize, purchaseorderdetails.dblAdditionalQty,
purchaseorderdetails.intYear, purchaseorderdetails.strColor, purchaseorderdetails.strUnit, 
purchaseorderdetails.dblUnitPrice, purchaseorderdetails.dblQty, purchaseorderdetails.intPoNo,purchaseorderdetails.strRemarks,purchaseorderdetails.intPOType 
FROM (purchaseorderdetails INNER JOIN orderdetails 
ON purchaseorderdetails.intStyleId = orderdetails.intStyleId AND purchaseorderdetails.intMatDetailID = orderdetails.intMatDetailID )
INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
WHERE (((purchaseorderdetails.intPoNo)=".$intPoNo.")) and (((purchaseorderdetails.intYear)=".$intYear."));
";*/

$SL_PODATA = "SELECT
			matitemlist.strItemDescription,
			matitemlist.intItemSerial,
			purchaseorderdetails.strBuyerPONO,
			purchaseorderdetails.dtmItemDeliveryDate,
			purchaseorderdetails.strSize,
			purchaseorderdetails.dblAdditionalQty,
			purchaseorderdetails.intYear,
			purchaseorderdetails.strColor,
			purchaseorderdetails.strUnit,
			purchaseorderdetails.dblUnitPrice,
			purchaseorderdetails.dblQty,
			purchaseorderdetails.intPoNo,
			purchaseorderdetails.strRemarks,
			purchaseorderdetails.intPOType,
			orders.strOrderNo,
			orders.intStyleId,
			specification.intSRNO,
			materialratio.materialRatioID
			FROM
			(purchaseorderdetails)
			left Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
			left Join orders ON purchaseorderdetails.intStyleId = orders.intStyleId
			left join specification on purchaseorderdetails.intStyleId = specification.intStyleId
			left join materialratio on purchaseorderdetails.intStyleId = materialratio.intStyleId and purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID and purchaseorderdetails.strColor = materialratio.strColor and purchaseorderdetails.strSize = materialratio.strSize aND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO
			WHERE (((purchaseorderdetails.intPoNo)='$intPoNo')) and (((purchaseorderdetails.intYear)='$intYear'))";
		
	
	   $result_podata = $db->RunQuery($SL_PODATA);
       while($row_podata = mysql_fetch_array($result_podata ))
	   {
			$newItemDeliveryDate=substr($row_podata["dtmItemDeliveryDate"],-19,10);
		    $totRATE_USD+=$row_podata["dblUnitPrice"];
			$totVALUE+=$row_podata["dblUnitPrice"]*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]);
			$totqty+=($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]);
			
			if($row_podata["intPOType"]==1)
				$strDescription = $row_podata["strItemDescription"] . " - " . $row_podata["strRemarks"] . "<font class=\"error1\"> - Freight </font>";
			else
				$strDescription = $row_podata["strItemDescription"] . " - " . $row_podata["strRemarks"];
			
			$styID = $row_podata["intStyleId"];
			$matCode = $row_podata["intItemSerial"];
			$costingPrice = $row_podata["dblUnitPrice"];
			$sqlPricediff = "SELECT dblUnitPrice FROM specificationdetails WHERE intStyleId = '$styID' AND strMatDetailID = '$matCode' ";
			
			$resultcost = $db->RunQuery($sqlPricediff);
       	while($rowcost = mysql_fetch_array($resultcost))
	   	{
	   		$costingPrice = $rowcost["dblUnitPrice"];
	   		break;
	   	}
	   	$purchasedPrice = round($row_podata["dblUnitPrice"],4) / $currencyRate;
	   	
	 ?>
      <tr <?php if ($poStatus == 1 && $costingPrice < $purchasedPrice && $HighLightOverCostPO == "true") {?> bgcolor="#FF6633" <?php } ?>>
        <td class="normalfntTAB9"><?php echo $row_podata["strBuyerPONO"]; ?></td>
       
<!--	   <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>-->
			<td colspan="2" class="normalfntTAB9"><?php echo $strDescription  ;  ?></td>
			<td class="normalfntTAB9"><?php echo $row_podata["strOrderNo"]."/".$row_podata["intStyleId"]; ?><table width="100%" border="0" cellpadding="0"><tr>
			<td width="45%"></td><td width="6%"></td>
			<td width="49%"></td></tr></table></td>
             <?php 
			if ($SCRequiredForPODetails == "true")
			{
			?>
			<td class="normalfntMidTAB9"><?php echo $row_podata["intSRNO"]; ?></td>
			<?php
			}
			if ($MatRatioIDRequiredForPoDetails == "true")
			{
			?>
			<td class="normalfntMidTAB9"><?php echo $row_podata["materialRatioID"]; ?></td>
			<?php
			}
			if ($DeliveryDateRequiredForDetails == "true")
			{
			?>
			<td class="normalfntMidTAB9"><?php echo $newItemDeliveryDate; ?></td>
			<?php
			}
			?>
			
			<td class="normalfntMidTAB9"><?php echo $row_podata["strSize"]; ?></td>
			<td class="normalfntMidTAB9"><?php echo $row_podata["strColor"]; ?></td>
			<td class="normalfntMidTAB9"><?php echo $row_podata["strUnit"]; ?></td>
			<td class="normalfntMidTAB9"><div align="right"><?php
			if ($poStatus == 1 && $costingPrice < $purchasedPrice && $HighLightOverCostPO == "true")
			{
				echo "[" . number_format($costingPrice,4) . "] ";
			}			
			 echo number_format($row_podata["dblUnitPrice"],4); ?></div></td>
			<td class="normalfntMidTAB9"><div align="right"><?php echo $row_podata["dblQty"] + $row_podata["dblAdditionalQty"]; ?></div>
			<?php
			if($poStatus == 1 && $HighlightAdditionalPurchase == "true" && $row_podata["dblAdditionalQty"] > 0 )
			{
				echo "<br><div align=\"right\" class=\"error1\">(" . $row_podata["dblQty"] . "+" . $row_podata["dblAdditionalQty"]. ")</div>";
				
			}			
			?>			
			</td>
			<td class="normalfntMidTAB9"><div align="right"><?php echo number_format(($row_podata["dblUnitPrice"]*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"])),2);?></div></td>
		  <!--	
	  	 	echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>";
			echo "<td class=\"normalfntTAB\">".$row_podata["strItemDescription"]."</td>";
			echo " <td class=\"normalfntTAB\"><table width=\"100%\" border=\"0\" cellpadding=\"0\"><tr>";
			echo "<td width=\"45%\">".$row_podata["strOrderNo"]."</td><td width=\"6%\">/</td>";
			echo "<td width=\"49%\">".$row_podata["intStyleId"]."</td></tr></table></td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["dtmItemDeliveryDate"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["strSize"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["strColor"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["strUnit"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["dblUnitPrice"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["dblQty"]."</td>";
			echo "<td class=\"normalfntMidTAB\">".$row_podata["dblUnitPrice"]*$row_podata["dblQty"]."</td>";
			$totRATE_USD+=$row_podata["dblUnitPrice"];
			$totVALUE+=$row_podata["dblUnitPrice"]*$row_podata["dblQty"];
	   }
	   else
	   {
	    	echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>";
			echo "<td class=\"normalfntTAB\"></td>";
			echo " <td class=\"normalfntTAB\"><table width=\"100%\" border=\"0\" cellpadding=\"0\"><tr>";
			echo "<td width=\"45%\"></td><td width=\"6%\">/</td>";
			echo "<td width=\"49%\"></td></tr></table></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";
			echo "<td class=\"normalfntMidTAB\"></td>";			-->
      </tr>
<?php
}
?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="86%" class="bigfntnm1mid">Total</td>
        <td width="7%" class="bigfntnm1mid"><?php echo round($totqty,2);?></td>
        <td width="7%" class="bigfntnm1rite"><?php echo number_format(round($totVALUE,2),2);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" colspan="4" class="normalfnth2B"><?php
	//$num=100005;
	$totVarValue=convert_number(round($totVALUE,2));
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
        return "$number"; 
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 
//	    $Dn = floor($number / 10);       /* -10 (deci) */ 
 //   $n = $number % 100;               /* .0 */ 
//	    $Dn = floor($number / 10);       /* -100 (centi) */ 
 //   $n = $number % 1000;               /* .00 */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eighty", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
	
	
} 

//$convrt=substr(round($totVALUE,2),-2);
$convrt = explode(".",round($totVALUE,2));

$cents =  $convrt[1];
if ($cents < 10)
$cents = $convrt[1] . "0";

$centsvalue=centsname($cents);
function centsname($number)
{		
      $Dn = floor($number / 10);       /* -10 (deci) */ 
      $n = $number % 10;               /* .0 */ 
	  
	   $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eighty", "Ninety"); 
		
 if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 
	
	if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
	
}


echo $totVarValue." $currencyTitle and ".$centsvalue ." $currencyFraction only.";
?></span></td>
  </tr>  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4">
	<?php include 'poContents.php'; ?>
	</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="14%" class="normalfnt2bldBLACKmid">PREPARED BY</td>
        <td >&nbsp;</td>
        <td width="21%" class="normalfnt2bldBLACKmid">CHECKED BY</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="14%" class="normalfntTAB2">
          <?php 
		
		$SQL_User="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$UserID."));
";
		$result_User = $db->RunQuery($SQL_User);
       if($row_user = mysql_fetch_array($result_User))
	   {
	   		echo $row_user["Name"];
	   }
	
		?>        </td>
        <td width="11%">&nbsp;</td>
        <td width="21%" class="normalfntTAB2">
          <?php 
		$SQL_Checked="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$CheckedID."));
";
		$result_Checked = $db->RunQuery($SQL_Checked);
       if($row_check = mysql_fetch_array($result_Checked))
	   {
	   		echo $row_check["Name"];
	   }
	?>       </td>
        <td width="9%">&nbsp;</td>
        <td width="19%" class="normalfntTAB2"><?php 
		$SQL_Autho="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$AuthorisedID."));
";

		$result_Autho = $db->RunQuery($SQL_Autho);
		$AuthorizedName = "";
       if($row_Autho = mysql_fetch_array($result_Autho))
	   {
	   	$AuthorizedName =  $row_Autho["Name"];
	   }
	   
	   if ($ShowAccountsManager != "true")
	   	echo $AuthorizedName;
	?></td>
        </tr>
      <tr>
        <td width="14%" class="normalfnt2bldBLACKmid"><span class="normalfnth2Bm">Merchandiser</span></td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td width="21%" class="normalfnth2Bm">Merchandising Manager</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">
        Authorized By </td>
        </tr>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<?php
if ($intPrintStatus == 0 && $poStatus == 10)
{
	$sql = "update purchaseorderheader set intPrintStatus = 1 where intPONo = '$intPoNo' and intYear = '$intYear';";
	$db->ExecuteQuery($sql);
}

?>
</body>
</html>
