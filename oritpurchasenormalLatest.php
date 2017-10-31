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
$DisplayMotherCompany = $xml->PurchaseOrder->DisplayMotherCompany;
$InstructionFile = $xml->PurchaseOrder->InstructionFile;
$poStatus = 1;
				
				$intPoNo=$_GET["pono"];
			    $intYear=$_GET["year"];
				
				$SQL = "SELECT purchaseorderheader.intPoNo,purchaseorderheader.intYear, purchaseorderheader.intStatus, companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.intCountry, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, companies.strFax, companies.strVatAcNo, companies.strWeb,country.strCountry
FROM companies INNER JOIN purchaseorderheader  ON companies.intCompanyID = purchaseorderheader.intInvCompID Inner Join country ON companies.intCountry = country.intConID
WHERE (((purchaseorderheader.intPoNo)=$intPoNo)) and (((purchaseorderheader.intYear)=$intYear));";

				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{  
					$comName		= $row["strName"];
					$comAddress1	= $row["strAddress1"];
					$comAddress2	= $row["strAddress2"];
					$comStreet		= $row["strStreet"];
					$comCity		= $row["strCity"];
					$comState		= $row["strState"];
					$comCountry		= $row["strCountry"];
					//$comCountry		= getCountry($row["intCountry"]).".";
					$comZipCode		= $row["strZipCode"];
					$strPhone		= $row["strPhone"];
					$comEMail		= $row["strEMail"];
					$comFax			= $row["strFax"];
					$comWeb			= $row["strWeb"];
					$TQBNo			= $row["strTQBNO"];
					$companyReg		= $row["strRegNo"];
					$strVatNo 		= $row["strVatAcNo"];
					$poStatus 		= $row["intStatus"];
									
				}
				
				if($DisplayMotherCompany == "true")
				{
					$xmlObj = simplexml_load_file('company.xml');
					$comName = $xmlObj->Name->CompanyName;
					$comAddress1= $xmlObj->Address->AddressLine1;
					$comAddress2= $xmlObj->Address->AddressLine2;
					$comStreet= $xmlObj->Address->Street;
					$comCity= $xmlObj->Address->City;
					$comCountry= $xmlObj->Address->Country;
					$strPhone= $xmlObj->Address->Telephone;
					$comEMail= $xmlObj->Address->Email;
					$comFax= $xmlObj->Address->Fax;
					$comWeb= $xmlObj->Address->Web;
				}
				
				$strAddress1new = trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
				$strAddress2new = trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
				$strStreetnew = trim($comStreet) == "" ? $comStreet : $comStreet ;
				$strCitynew = trim($comCity) == "" ? $comCity : ", " . $comCity;
				
				?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
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

function detectspecialkeys(e)
{
	var evtobj=window.event? event : e
	
	 var charCode = (e.which) ? e.which : e.keyCode;

	if (evtobj.ctrlKey && charCode == 101 )
		sendEmail();
}

document.onkeypress=detectspecialkeys
	


function sendEmail()
{
	var year = <?php echo  $_GET["year"];?>;
	var poNo = <?php echo  $_GET["pono"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	if (checkemail(emailAddress))
	{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'poemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
		xmlHttp.send(null);
	}
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
if($poStatus == 1 || $poStatus == 2 ||$poStatus == 5)
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
<div style="position:absolute;top:200px;left:400px;"><img src="images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php
}
?>
<table width="800" border="0" align="center" cellpadding="0">
  <tr>
    <td colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="images/logo.jpg" alt="" class="normalfnt" /></td>

              <td width="6%" class="normalfnt">&nbsp;</td>
			    <td width="62%" class="tophead"><p class="topheadBLACK"><?php echo $comName; ?></p>
				 <?php
				 if($strVatNo != "" || $companyReg != "")
				 echo ($strVatNo==""?"":"<span class=\"normalfnt\"> VAT NO: $strVatNo") . "   &nbsp;&nbsp; " . ($companyReg==""?"":" ( Company Reg. No : $companyReg )</span></b>");
				 
				 ?>
					<p class="normalfnt"><?php echo "$strAddress1new $strAddress2new, <br/>$strStreetnew $strCitynew, $comCountry<br/> <b>Tel: $strPhone".",".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
				<p class="normalfnt"></p>     			</td>
                <td width="12%" class="tophead"><div class="head2BLCK"><?php
                 if($poStatus == 10)
                 {
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo $xmlISO->ISOCodes->StylePOReport;
						}              
	                 
                   ?></div><div align="center"><img src="images/btn-email.png" style="visibility:hidden;" alt="Email" width="91" height="24" class="mouseover" onclick="sendEmail();" /></div>
						<?php
						}
						?>                </td>
              </tr>
			  <!--<tr>
			  <td width="85%"><?php //include 'reportHeader.php'?></td>
			  <td width="15%"></td>
			  </tr>-->

          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK">&nbsp;</p>
      
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
			
			
		    $PO_Details="SELECT purchaseorderheader.intPONo,purchaseorderheader.intYear,DATE_FORMAT(purchaseorderheader.dtmETD, '%d-%M-%Y')  AS dtmETD,DATE_FORMAT(purchaseorderheader.dtmETA, '%d-%M-%Y')  AS dtmETA ,purchaseorderheader.strPINO, purchaseorderheader.intConfirmedBy,purchaseorderheader.dtmConfirmedDate, purchaseorderheader.strSupplierID, suppliers.strTitle, suppliers.strAddress1, suppliers.strAddress2, suppliers.strVatRegNo, suppliers.strTQBNo ,suppliers.strStreet, suppliers.strCity,suppliers.strSupplierCode , suppliers.strState, suppliers.strCountry, purchaseorderheader.strPayMode, purchaseorderheader.strPayTerm, purchaseorderheader.strShipmentMode, purchaseorderheader.strShipmentTerm, purchaseorderheader.strInstructions, DATE_FORMAT(purchaseorderheader.dtmDate, '%d-%M-%Y')  AS dtmDate, purchaseorderheader.intInvCompID, purchaseorderheader.intDelToCompID, DATE_FORMAT(purchaseorderheader.dtmDeliveryDate, '%d-%M-%Y')  AS dtmDeliveryDate , purchaseorderheader.intPrintStatus, purchaseorderheader.intUserID,purchaseorderheader.dtmDate as preparedDate, purchaseorderheader.intRevisedBy, purchaseorderheader.intRevisionNo, purchaseorderheader.intCheckedBy,purchaseorderheader.strCurrency, currencytypes.strFractionalUnit,  purchaseorderheader.strCurrency as currencyTitle, purchaseorderheader.dblExchangeRate AS currencyRate , purchaseorderheader.intFirstApprovedBy,purchaseorderheader.dtmFirstAppDate FROM suppliers INNER JOIN purchaseorderheader ON suppliers.strSupplierID = purchaseorderheader.strSupplierID inner join currencytypes on purchaseorderheader.strCurrency = currencytypes.intCurID 
WHERE (((purchaseorderheader.intPONo)=".$intPoNo.")) and (((purchaseorderheader.intYear)=".$intYear."));
";	
		
	
			$result_pd = $db->RunQuery($PO_Details);
			while($row_pd = mysql_fetch_array($result_pd ))
			{
				$strSupplierID		= $row_pd["strSupplierID"];
				$strTitle			= $row_pd["strTitle"];
				$strAddress1		= $row_pd["strAddress1"];
				$strAddress2		= $row_pd["strAddress2"];
				$strStreet			= $row_pd["strStreet"];
				$strCity			= $row_pd["strCity"];
				$strState			= $row_pd["strState"];
				$strCountry			= $row_pd["strCountry"];
				$strPayMode			= $row_pd["strPayMode"];
				$strPayTerm			= $row_pd["strPayTerm"];
				$newpodate			= $row_pd["dtmDate"];
				$strShipmentMode	= $row_pd["strShipmentMode"];
				$strShipmentTerm	= $row_pd["strShipmentTerm"];
				$strInstructions	= $row_pd["strInstructions"];
				
				$intInvCompID		= $row_pd["intInvCompID"];
				$intDelToCompID		= $row_pd["intDelToCompID"];
				$newdeldate			= $row_pd["dtmDeliveryDate"];
				$intPrintStatus		= $row_pd["intPrintStatus"];
				
				$UserID				= $row_pd["intUserID"];				
				$preparedDate		= $row_pd["preparedDate"];
				
				$AuthorisedID		= $row_pd["intConfirmedBy"];
				$AuthorisedDate		= $row_pd["dtmConfirmedDate"];
				
				$checkDate			= $row_pd["dtmFirstAppDate"];
				$CheckedID			= $row_pd["intFirstApprovedBy"];
				
				$Currency			= $row_pd["strCurrency"];
				$PINO				= $row_pd["strPINO"];
				$currencyTitle 		= $row_pd["currencyTitle"];
				$revisionNo 		= $row_pd["intRevisionNo"]; 
				$currencyFraction 	= $row_pd["strFractionalUnit"]; 
				$supplierCode 		= $row_pd["strSupplierCode"];   
				$currencyRate 		= $row_pd["currencyRate"];  
				$ETD				= $row_pd["dtmETD"];
				$ETA				= $row_pd["dtmETA"];
				$supvat				= $row_pd["strVatRegNo"];
				$suptqb				= $row_pd["strTQBNo"];

				if ($CheckedID == "" || $CheckedID == null)
					$CheckedID = -1;
					
				if ($AuthorisedID == "" || $AuthorisedID == null)
					$AuthorisedID = -1;
				
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "" . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "" . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "" . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "" . $strState . "," ;
			}
		  ?>
          <p class="head2BLCK">PURCHASE ORDER</p>
      <p class="head2BLCK">&nbsp;</p>
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td><span class="head2BLCK"><?php echo "PO NO -  $intYear / $intPoNo";?><span class="normalfnth2Bm">
            &nbsp;
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
		  ?>
          </span></span></td>
          <td class="normalfnth2Bm"><div align="right"><span class="normalfnBLD1">PO Date : 
            <?php  echo $newpodate;?>
          </span></div></td>
        </tr>
        <tr>
          <td width="56%">&nbsp;</td>
        
          <td width="44%" class="normalfnth2Bm">&nbsp;</td>
        </tr>
        
        <tr>
          <td><table width="100%" border="0" cellpadding="0">
            <tr>
              <td colspan="3"><table width="100%" border="0" cellpadding="0">
                <tr>
                  <td width="27%" height="19" class="normalfnBLD1">Supplier Code</td>
                  <td width="1%" class="normalfnBLD1">:</td>
                  <td width="72%" class="normalfnt"><?php
                  if ($DisplaySupplierCOdeOnReport == "true")
                   echo $supplierCode;
                   else
                   echo $strSupplierID;
                   
                   ?></td>
                </tr>
                <tr>
                  <td height="28" class="normalfnBLD1">Name</td>
                  <td class="normalfnBLD1">:</td>
                  <td class="normalfnt"><?php echo $strTitle;?></td>
                </tr>
                <tr>
                  <td height="23" class="normalfnBLD1">Address</td>
                  <td class="normalfnBLD1">:</td>
                  <td class="normalfnt"><?php
                  echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew <br>";
				  echo getCountry1($strCountry).".";              
				  ?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="27%" height="23" class="normalfnBLD1">Pay Mode</td>
              <td width="1%" class="normalfnBLD1">:</td>
              <td width="72%" class="normalfnt"><?php 
			$SQL="select strDescription from popaymentmode where strPayModeId = '".$strPayMode."';";
			$mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$PayModeDescription = $row["strDescription"];
			}
			  echo $PayModeDescription;?></td>
            </tr>
            <tr>
              <td height="23" class="normalfnBLD1">Pay Term</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php 
			$SQL="select strDescription from popaymentterms where strPayTermId = '".$strPayTerm."';";
			$mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$PayTermDescription = $row["strDescription"];
			}
			  
			  echo $PayTermDescription;?></td>
            </tr>
            <tr>
              <td height="23" class="normalfnBLD1">Ship. Mode</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php 
		    $SQL="select strDescription from shipmentmode where intShipmentModeId = '".$strShipmentMode."';";
		    $mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$shipModeDescription = $row["strDescription"];
			}
			  
			  echo $shipModeDescription;?></td>
            </tr>
            <tr>
              <td height="23" class="normalfnBLD1">Ship. Term</td>
              <td class="normalfnBLD1">:</td>
              <td class="normalfnt"><?php 
			$SQL="select strShipmentTerm from shipmentterms where strShipmentTermId = '".$strShipmentTerm."';";
		    $mainresult = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($mainresult))
			{
				$shipTermDescription = $row["strShipmentTerm"];
			}
			  echo $shipTermDescription;?></td>
            </tr>
            <tr>
              <td height="23" class="normalfnBLD1" valign="top">&nbsp;</td>
              <td class="normalfnBLD1" valign="top"></td>
              <td class="normalfnt"></td>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="0" cellpadding="0">
            <tr>
              <td height="46" colspan="2" valign="top" ><div style="border: 1px solid #999999;">
			  <table width="419" height="44">
			  <tr>
			  <td width="171" valign="top" class="normalfnBLD1">Deliver To : </td>
			  <td width="338" valign="top"><?php
			  $DELTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.intCountry, companies.intCompanyID
FROM companies
WHERE (((companies.intCompanyID)=".$intDelToCompID."));";

				$result_del = $db->RunQuery($DELTO);
				if($row_del = mysql_fetch_array($result_del ))
				{
				$strAddress1=$row_del["strAddress1"];
				$strAddress2=$row_del["strAddress2"];
				$strStreet=$row_del["strStreet"];
				$strCity=$row_del["strCity"];
				//$strState=$row_del["strState"];
                  
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "" . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "" . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "" . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "" . $strState . "" ;
				$detToCountry = getCountry($intDelToCompID);
				echo " <p class=\"normalfnt\">".$row_del["strName"]."<br>";

					echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" . $detToCountry.".</p>";
					
				  
				}
				
			  ?></td>
			  </tr>
			  </table>
			  
			  </div></td>
			  </tr>
               <tr>
              <td height="58" colspan="2" valign="top" ><div style="border: 1px solid #999999;">
			  <table width="416" height="40">
			  <tr>
			  <td width="171" valign="top" class="normalfnBLD1">Invoice To : </td>
			  <td width="338" valign="top"> <?php
			  $INVTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.intCountry, companies.intCompanyID
FROM companies
WHERE (((companies.intCompanyID)=".$intInvCompID."));";
				
			
				$result_inv = $db->RunQuery($INVTO);
				if($row_inv = mysql_fetch_array($result_inv ))
				{
				  $strAddress1=$row_inv["strAddress1"];
				$strAddress2=$row_inv["strAddress2"];
				$strStreet=$row_inv["strStreet"];
				$strCity=$row_inv["strCity"];
				//$strState=$row_inv["strState"];
                  
				$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
				$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "" . $strAddress2;
				$strStreetnew = trim($strStreet) == "" ? $strStreet : "" . $strStreet ;
				$strCitynew = trim($strCity) == "" ? $strCity : "" . $strCity;
				$strStatenew = trim($strState) == "" ? $strState : "" . $strState . "," ;
				$invToComCountry = getCountry($intInvCompID);
				echo " <p class=\"normalfnt\">".$row_inv["strName"]."<br>";

					echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" .$invToComCountry.".";
					echo "</p>";
				}
						
				
			  ?></td>
			  </tr>
			  </table>
			  
			  </div></td>
			  </tr>
			  <tr>
			  <td width="32%" height="23" class="normalfnth2B">ETA Date </td>
  			  <td width="68%"><span class="normalfnBLD1">: </span>&nbsp;<span class="normalfnt"><?php echo $ETA;?></span></td>
			  </tr>
			  <tr>
			    <td height="23" class="normalfnth2B">ETD Date </td>
			    <td><span class="normalfnBLD1">: </span>&nbsp;<span class="normalfnt"><?php echo $ETD;?></span></td>
		      </tr>
          </table></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td width="272" height="22" class="normalfntTAB"><span>DELIVERY DATE :</span> <span class="normalfnBLD1"><?php echo $newdeldate;?></span></td>
    <td width="273" class="normalfntTAB">VAT Reg. No.:<?php echo $supvat ;?></td>
    <td width="227" class="normalfntTAB">PI No :<?php echo $PINO;?> </td>
    <td width="329" class="normalfntTAB">TQB No:<?php echo $suptqb;?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
    <thead>
      <tr>
     	 <td height="31" colspan="1"  bgcolor="#CCCCCC" class="bcgl1txt1B">Buyer PO </td>
        <td height="31" colspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">Description</td>
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
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Order#/Style#</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Item Code</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Size</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Color</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Unit</td>
        <td bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price <br />(<?php echo GetCurrencyName($Currency); ?>) </td>
        <?php 
		if($poStatus == 2 || $poStatus==5)
		{
		?>
         <td bgcolor="#CCCCCC" class="bcgl1txt1B">Max USD <br/>
          Rate</td> 
        <?php 
		}
		?>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Qty</td>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Value</td>
        </tr>
        </thead>
       <?php
	  $totRATE_USD=0.0;
	  $totVALUE=0.0;
	  $totqty=0.0;
	  $orderno="";
	  $styleno="";
	  
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

/*$sql_new	="select orders.strOrderNo,orders.strStyle from orders,purchaseorderdetails 
			 WHERE purchaseorderdetails.intStyleId =orders.intStyleId and  (((purchaseorderdetails.intPoNo)='$intPoNo')) and (((purchaseorderdetails.intYear)='$intYear')) group by orders.strOrderNo ;";

		$result_new= $db->RunQuery($sql_new);
		while($row_new = mysql_fetch_array($result_new))
		{
			$styleno=$row_new["strStyle"];
			$orderno=$row_new["strOrderNo"];
			
		}*/
		
		

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
			orders.strStyle,
			orders.intQty,
			specification.intSRNO,
			materialratio.materialRatioID,
			s.dblUnitPrice as MaxUSDRate
			FROM
			(purchaseorderdetails)
			left Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
			left Join orders ON purchaseorderdetails.intStyleId = orders.intStyleId
			left join specification on purchaseorderdetails.intStyleId = specification.intStyleId
			left join materialratio on purchaseorderdetails.intStyleId = materialratio.intStyleId and purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID and purchaseorderdetails.strColor = materialratio.strColor and purchaseorderdetails.strSize = materialratio.strSize aND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO
			inner join specificationdetails s on s.strMatDetailID = purchaseorderdetails.intMatDetailID and purchaseorderdetails.intStyleId = s.intStyleId
			WHERE (((purchaseorderdetails.intPoNo)='$intPoNo')) and (((purchaseorderdetails.intYear)='$intYear'))
			order by orders.strOrderNo,matitemlist.strItemDescription
			 ";
		$previd=0;
	   $result_podata = $db->RunQuery($SL_PODATA);
       while($row_podata = mysql_fetch_array($result_podata ))
	   {
	   		$currentid=$row_podata["intStyleId"];
			$buyerPO=$row_podata["strBuyerPONO"];
			$newItemDeliveryDate=substr($row_podata["dtmItemDeliveryDate"],-19,10);
		    $totRATE_USD+=$row_podata["dblUnitPrice"];
			$totVALUE+=round($row_podata["dblUnitPrice"],4)*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]);
			$totqty+=($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]);
			
			if($row_podata["intPOType"]==1 )
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
	   	$buyerPoName = '#Main Ratio#';
		if($row_podata["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerPoName($row_podata["strBuyerPONO"]);
		
		$strURLbom="bomitemreport.php?styleID=$styID";	
	 ?>
     <?php
	 if($previd!=$currentid)
	 {
	 ?>
       <tr bgcolor="#F2F2F2" <?php if ($poStatus == 1 < round($costingPrice,4) && round($purchasedPrice,4) && $HighLightOverCostPO == "true") {?> bgcolor="#FF6633" <?php } ?>>
         <!-- <td height="20" colspan="12" class="normalfntTAB9">&nbsp;<b>Order No : </b><a href="<?php echo $strURLbom; ?>" target="bomitemreport.php"><?php echo $row_podata["strOrderNo"];?></a>&nbsp;&nbsp;&nbsp;<b>Style No : </b><?php echo $row_podata["strStyle"];?>&nbsp;&nbsp;<b>  Order Qty : </b><?php echo $row_podata["intQty"];?> </td> -->        
	    </tr>
		 <tr <?php if ($poStatus == 1 && round($costingPrice,4) < round($purchasedPrice,4) && $HighLightOverCostPO == "true") {?> bgcolor="#FF6633" <?php } ?>>
         <td colspan="1" class="border-right-fntsize9"> &nbsp;<?php echo $buyerPO ; ?> </td>
        <td colspan="2" class="border-right-fntsize9"> &nbsp;<?php echo $strDescription ; ?><table width="100%" border="0" cellpadding="0"> 
            <tr>
              <td width="45%"></td><td width="6%"></td>
			  <td width="49%"></td></tr>
          </table></td>
		  <?php 
			if ($SCRequiredForPODetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $row_podata["intSRNO"]; ?></td>
			<?php
			}
			if ($MatRatioIDRequiredForPoDetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $row_podata["materialRatioID"]; ?></td>
			<?php
			}
			if ($DeliveryDateRequiredForDetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $newItemDeliveryDate; ?></td>
			<?php
			}
			?>
            <td class="border-right-fntsize9" style="text-align:center;"><?php echo $row_podata["strStyle"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["materialRatioID"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strSize"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strColor"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strUnit"]; ?></td>
			<td class="border-right-fntsize9"><div align="right"><?php
			if ($poStatus == 1 && round($costingPrice,4) < round($purchasedPrice,4)  && $HighLightOverCostPO == "true")
			{
				echo "[" . number_format($costingPrice,4) . "] ";
			}			
			 echo number_format($row_podata["dblUnitPrice"],4); ?></div></td>
             <?php 
		if($poStatus == 2 || $poStatus==5)
		{
		?>
         <td class="border-right-fntsize9" style="text-align:right"><?php echo number_format($row_podata["MaxUSDRate"],4); ?></td> 
        <?php 
		}
		?>
			<td class="border-right-fntsize9"><div align="right"><?php echo $row_podata["dblQty"] + $row_podata["dblAdditionalQty"]; ?></div>
			<?php
			if($poStatus == 1 && $HighlightAdditionalPurchase == "true" && $row_podata["dblAdditionalQty"] > 0 )
			{
				echo "<br><div align=\"right\" class=\"error1\">(" . $row_podata["dblQty"] . "+" . $row_podata["dblAdditionalQty"]. ")</div>";
				
			}			
			?>			</td>
			<td style="font-family:Verdana; font-size:9px"><div align="right"><?php echo
			 number_format((round($row_podata["dblUnitPrice"],4)*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"])),2);?></div></td></tr>
		<?php
		
	  }
	  else
	  {?>	
	   
       <tr <?php if ($poStatus == 1 && round($costingPrice,4) < round($purchasedPrice,4) && $HighLightOverCostPO == "true") {?> bgcolor="#FF6633" <?php } ?>>
       <td colspan="1" class="border-right-fntsize9"> &nbsp;<?php echo $buyerPO ; ?> </td>
        <td colspan="2" class="border-right-fntsize9">&nbsp;<?php echo $strDescription ; ?> <table width="100%" border="0" cellpadding="0">
            <tr>
              <td width="45%"></td><td width="6%"></td>
			  <td width="49%"></td></tr>
          </table></td>
       
<!--	   <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>-->
			<?php 
			if ($SCRequiredForPODetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $row_podata["intSRNO"]; ?></td>
			<?php
			}
			if ($MatRatioIDRequiredForPoDetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $row_podata["materialRatioID"]; ?></td>
			<?php
			}
			if ($DeliveryDateRequiredForDetails == "true")
			{
			?>
			<td class="border-right-fntsize9"><?php echo $newItemDeliveryDate; ?></td>
			<?php
			}
			?>
			<td class="border-right-fntsize9"><?php echo $row_podata["materialRatioID"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strSize"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strColor"]; ?></td>
			<td class="border-right-fntsize9"><?php echo $row_podata["strUnit"]; ?></td>
			<td class="border-right-fntsize9"><div align="right"><?php
			if ($poStatus == 1 && round($costingPrice,4) < round($purchasedPrice,4)  && $HighLightOverCostPO == "true")
			{
				echo "[" . number_format($costingPrice,4) . "] ";
			}			
			 echo number_format($row_podata["dblUnitPrice"],4); ?></div></td>
             <?php 
		if($poStatus == 2 || $poStatus==5)
		{
		?>
         <td class="border-right-fntsize9" style="text-align:right"><?php echo number_format($row_podata["MaxUSDRate"],4); ?></td> 
        <?php 
		}
		?>
			<td class="border-right-fntsize9"><div align="right"><?php echo $row_podata["dblQty"] + $row_podata["dblAdditionalQty"]; ?></div>
			<?php
			if($poStatus == 1 && $HighlightAdditionalPurchase == "true" && $row_podata["dblAdditionalQty"] > 0 )
			{
				echo "<br><div align=\"right\" class=\"error1\">(" . $row_podata["dblQty"] . "+" . $row_podata["dblAdditionalQty"]. ")</div>";
				
			}			
			?>			</td>
			<td style="font-family:Verdana; font-size:9px"><div align="right"><?php echo 
			number_format((round($row_podata["dblUnitPrice"],4)*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"])),2);?></div></td>
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
			$previd=$currentid;
}

?>
      <!--<tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>-->
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

$currencyTitle = GetCurrencyName($currencyTitle);
echo $totVarValue." $currencyTitle and ".$centsvalue ." $currencyFraction only.";
?></span></td>
  </tr>  
  <tr>
    <td colspan="4"><table width="639" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="104" class="normalfnBLD1">Instruction </td>
        <td width="535" class="normalfnt"><span class="normalfnBLD1">:</span> <?php echo $strInstructions;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4">
	<?php include "$InstructionFile"; ?>	</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="7%" class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td width="22%" class="normalfnt2bldBLACKmid">Prepared By</td>
        <td width="8%" >&nbsp;</td>
        <td width="24%" class="normalfnt2bldBLACKmid">Checked By</td>
        <td width="9%">&nbsp;</td>
        <td width="22%" >&nbsp;</td>
        <td width="8%">&nbsp;</td>
        </tr>
      <tr>
        <td width="7%" >&nbsp;</td>
        <td width="22%" class="normalfntTAB2">
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
        <td width="8%">&nbsp;</td>
        <td width="24%" class="normalfntTAB2">
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
        <td width="22%" class="normalfntTAB2"><?php 
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
        <td width="8%"></td>
        </tr>
      <tr>
        <td width="7%" >&nbsp;</td>
        <td width="22%" class="normalfnt2bldBLACKmid"><span class="normalfnth2Bm">Merchandiser</span></td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td width="24%" class="normalfnth2Bm">Authorised By </td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">
        Accountant</td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfntMidSML"><?php echo $preparedDate;?></td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfntMidSML"><?php echo $checkDate;?></td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfntMidSML"><?php echo $AuthorisedDate;?></td>
        <td class="normalfnt2bldBLACKmid"><div align="center"></div></td>
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
function GetBuyerPoName($buyerPoNo)
{
global $db;
	$sql="select distinct strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoNo'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];	
}

function getCountry($comID)
{
	$SQL = "SELECT CN.strCountry FROM country CN INNER JOIN companies CM ON
			CN.intConID = CM.intCountry 
			WHERE CM.intCompanyID=$comID";
			
			 global $db;
			$result = $db->RunQuery($SQL);
			$row = mysql_fetch_array($result);
			$Country = $row["strCountry"];
			
		return $Country;	
}

function getCountry1($comID)
{
	$SQL = "SELECT strCountry FROM country where intConID='$comID'";
			
			 global $db;
			$result = $db->RunQuery($SQL);
			$row = mysql_fetch_array($result);
			$Country = $row["strCountry"];
			
		return $Country;	
}
function GetCurrencyName($currencyId)
{
global $db;
	$sql="select strCurrency from currencytypes  where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strCurrency"];
}
?>
</body>
</html>