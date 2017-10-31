<?php 
session_start();
include "authentication.inc";
include "Connector.php";


//				$intPoNo="08/16841";
//				$intYear="8-8-2008";
				
				$intPoNo=$_GET["pono"];
			    $intYear=$_GET["year"];
				$poStatus = 1;

				
				//$intPoNo="400055";
				//$intYear="2009";
				/*
				$SQL="SELECT purchaseorderdetails.intPoNo,purchaseorderdetails.intYear,orders.intStyleId, companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb
FROM companies INNER JOIN (purchaseorderdetails INNER JOIN orders ON purchaseorderdetails.intStyleId = orders.intStyleId) ON companies.intCompanyID = orders.intCompanyID
WHERE (((purchaseorderdetails.intPoNo)=".$intPoNo.")) and (((purchaseorderdetails.intYear)=".$intYear."));";

				*/
				$SQL = "SELECT purchaseorderheader.intPoNo,purchaseorderheader.intYear, purchaseorderheader.intStatus, companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb
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
					$VatRegNo=$row["strRegNo"];
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
.style2 {color: #CCCCCC}
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
<img src="images/cancelled.png" style="-moz-opacity:0.20;filter:alpha(opacity=20);">
</div>
<?php
}
?>
<table width="800" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td width="67%" class="tophead"><p class="topheadBLACK"><?php echo $comName; ?></p>
					<p class="normalfnt"><?php echo "$strAddress1new $strAddress2new, <br/>$strStreetnew $strCitynew $strStatenew $comCountry<br/> <b>Tel: $strPhone".",".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb . "</b>" ;?></p>
				<p class="normalfnt"></p>     			</td>
                 <td width="12%" class="tophead">
                 <?php
                  if($poStatus == 10)
                 {
                 ?>
                 <div align="center"><img src="images/btn-email.png" alt="Email" width="91" height="24" class="mouseover" onclick="sendEmail();" /></div>
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
    <td><p class="head2BLCK">OTHER PURCHASE ORDER</p>
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
			
		    $PO_Details="SELECT purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.strPINO, purchaseorderheader.intConfirmedBy, purchaseorderheader.strSupplierID, suppliers.strTitle, suppliers.strAddress1, suppliers.strAddress2, suppliers.strStreet, suppliers.strCity, suppliers.strState, suppliers.strCountry, purchaseorderheader.strPayMode, purchaseorderheader.strPayTerm, purchaseorderheader.strShipmentMode, purchaseorderheader.strShipmentTerm, purchaseorderheader.strInstructions, purchaseorderheader.dtmDate, purchaseorderheader.intInvCompID, purchaseorderheader.intDelToCompID, purchaseorderheader.dtmDeliveryDate, purchaseorderheader.intPrintStatus, purchaseorderheader.intUserID, purchaseorderheader.intRevisedBy, purchaseorderheader.intCheckedBy,purchaseorderheader.strCurrency, currencytypes.strTitle as currencyTitle 
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
		  if($intPrintStatus==0)
		  	echo "(ORIGINAL)";
		  else 
		  	echo "(DUPLICATE)";
		  
		  ?>          </td>
        </tr>
        
        <tr>
          <td><table width="100%" border="0" cellpadding="0">
            <tr>
              <td colspan="2"><table width="100%" border="0" cellpadding="0">
                <tr>
                  <td height="19" class="normalfnBLD1">Supplier Code </td>
                  <td width="65%" class="normalfnt"><?php echo $strSupplierID;?></td>
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
    <td class="normalfnt2BI">PLEASE SUPPLY IN ACCORDANCE WITH THE INSTRUCTIONS HEREIN THE FOLLOWING:<br />
      PLEASE INDICATE OUR P.O NO IN ALL YOURS INVOICES, PERFORMA INVOICES AND OTHER RELEVANT DOCUMENT AND DELIVER TO THE ABOVE MENTIONED DESTINATION AND INVOICE TO THE CORRECT PARTY.<br />
    PLEASE ISSUE SUSPENDED VAT INVOICES</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="16%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Item Category </td>
        <td width="12%" height="31" bgcolor="#CCCCCC" class="bcgl1txt1B style1">Style </td>
        <td width="11%" bgcolor="#CCCCCC" class="bcgl1txt1B">Buyer PO No </td>
        <td width="23%" bgcolor="#CCCCCC" class="bcgl1txt1B">Description</td>
        <td width="14%" bgcolor="#CCCCCC" class="bcgl1txt1B">Unit   </td>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Rate (USD) </td>
        <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Qty</td>
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

$SQL1 = "
				SELECT
				matsubcategory.StrCatName		as strCatName,
				intStyleId						as intStyleId,
				strBuyerPONO					as strBuyerPoNo,
				matitemlist.strItemDescription	as strDescription,
				purchaseorderdetails.strUnit	as strUnit,
				dblUnitPrice					as strUnitPrice,	
				purchaseorderdetails.intMatDetailID as intMatDetailID, 
				sum(dblQty) 					as TotalQty,
				SUM(dblAdditionalQty) AS AdditionalTotalQty  ,
				purchaseorderdetails.strRemarks
				FROM
				purchaseorderdetails
				Inner Join matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
				Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
				WHERE
				purchaseorderdetails.intPoNo =  '$intPoNo' AND
				purchaseorderdetails.intYear =  '$intYear'
				GROUP BY
				purchaseorderdetails.intMatDetailID,
				purchaseorderdetails.intStyleId,
				purchaseorderdetails.strBuyerPONO ";
				
		
	   $result1 = $db->RunQuery($SQL1);
	  
       while($row = mysql_fetch_array($result1 ))
	   {
				$strCatName 		= $row["strCatName"];
				$strStyleId			= $row["intStyleId"];
				$strBuyerPoNo		= $row["strBuyerPoNo"];
				$strDescription		= $row["strDescription"] . " " . $row["strRemarks"] ;
				$strUnit			= $row["strUnit"];
				$strUnitPrice		= $row["strUnitPrice"];
				$TotalQty			= $row["TotalQty"];
				$matID = $row["intMatDetailID"]; 
				$AdditionalTotalQty			= $row["AdditionalTotalQty"];
				
				 $totVALUE += ($TotalQty + $AdditionalTotalQty) * $strUnitPrice;
				 $totqty += ($TotalQty + $AdditionalTotalQty); 
	 ?>
      <tr>
        	<td height="20" class="normalfntTAB9"><span class="style1"><?php echo $strCatName;  ?></span></td>
			<td class="normalfntTAB9"><span class="style1"><?php echo $strStyleId;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo $strBuyerPoNo;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo $strDescription;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo $strUnit;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo $strUnitPrice;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo $TotalQty;  ?></span></td>
			<td class="normalfntMidTAB9"><span class="style1"><?php echo (($TotalQty + $AdditionalTotalQty) * $strUnitPrice);  ?></span></td>
      </tr>
		
      <tr>
        <td height="25" colspan="8"><table width="416"  border="0" cellspacing="0">
          <tr>
		   <td width="234" bgcolor="#BCC7EB" class="normalfntMidTAB">Color / Size </td>
		  <?php
		  $sizeCount=0;
		  //$sizeQty[];
		  $y=0;
		  $FinalQty=0;
		  $SQL2 = "SELECT  distinct strSize FROM purchaseorderdetails WHERE intPoNo =  '$intPoNo' AND intYear =  '$intYear' and intMatDetailID='$matID' and intStyleId='$strStyleId' ;";
		  $result2 = $db->RunQuery($SQL2);
		   $QtySizeWise='';
		   while($row2 = mysql_fetch_array($result2 ))
		   {
		   		$strSize = $row2["strSize"];
				$sizeCount++;
				$arrSize[$sizeCount]=$strSize;
		   ?>
           
            <td width="86"  bgcolor="#BCC7EB" class="normalfntMidTAB"><?php echo $strSize;  ?></td>
            
			
			<?php 
			}
			?>
			<td width="90" bgcolor="#BCC7EB" class="normalfntMidTAB">Total</td>
          </tr>
		  <?php
		  $SQL3 = "SELECT distinct strColor FROM purchaseorderdetails WHERE intPoNo =  '$intPoNo' AND intYear =  '$intYear'  and intMatDetailID='$matID'  and intStyleId='$strStyleId'; ";
		 
		  $result3 = $db->RunQuery($SQL3);
		   while($row3 = mysql_fetch_array($result3 ))
		   {
		   		$strColor = $row3["strColor"];
				$Qty = $row3["dblQty"];
		   ?>
          <tr>
            <td bgcolor="#BCC7EB" class="normalfntMidTAB"><?php echo $strColor;  ?></td>
			<?php 
			$Fqty=0;
			
			for($i=0;$i<$sizeCount;$i++)
			{
					  $SQL4 = "SELECT dblQty FROM purchaseorderdetails 
					  WHERE intPoNo =  '$intPoNo' AND intYear =  '$intYear' AND strColor='$strColor' and strSize='".$arrSize[$i+1]."'  and intMatDetailID='$matID'  and intStyleId='$strStyleId';";
					  $result4 = $db->RunQuery($SQL4);
					  $Qty=0;
					   while($row4 = mysql_fetch_array($result4 ))
					   {
							$Qty = $row4["dblQty"];
							$Fqty+=$Qty;
							$QtySizeWise[$i]+=$Qty;
							$FinalQty+=$Qty;
							
			?>
            <td class="normalfntRiteTAB"><?php echo $Qty;  ?></td>
			<?php 
							break;
						}
			}
							
			?>
            <td class="normalfntRiteTAB"><?php echo $Fqty;  ?></td>
          </tr>
		<?php 
			}
		?>
		            <tr>
            <td bgcolor="#BCC7EB" class="normalfntMidTAB">Total</td>
			<?php 
			$Fqty=0;
			for($i=0;$i<$sizeCount;$i++)
			{
			?>
            <td class="normalfntRiteTAB"><?php echo $QtySizeWise[$i]; ?></td>
			<?php 
			}
			?>
            <td class="normalfntRiteTAB"><?php echo $FinalQty; ?></td>
          </tr>
        </table></td>
        </tr>
		<tr height="5"><td>&nbsp;</td></tr>
<?php
}
?>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="84%" class="bigfntnm1mid">Total</td>
        <td width="8%" class="bigfntnm1mid"><?php echo number_format($totqty,0); ?></td>
        <td width="8%" class="bigfntnm1rite"><?php echo number_format($totVALUE,2); ?></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td ><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="74%" height="47" ><span class="style2"></span></td>
        <td width="13%"><span class="style2"></span></td>
        <td width="13%" ><span class="style2"></span></td>
      </tr>
      <tr>
        <td height="24" colspan="3" class="normalfnth2B" >&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="13%" rowspan="2" class="normalfnt2bldBLACKmid">PREPARED BY :</td>
        <td width="17%" class="normalfntTAB2">
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
	
		?></td>
        <td width="15%" rowspan="2" class="normalfnt2bldBLACKmid">CHECKED BY:</td>
        <td width="22%" class="normalfntTAB2">
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
	?>        </td>
        <td width="7%">&nbsp;</td>
        <td width="26%" class="normalfntTAB2"><p class="normalfntMid"><?php // echo $row_del["strName"]?></p>
          <?php 
		$SQL_Autho="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$AuthorisedID."));
";

		$result_Autho = $db->RunQuery($SQL_Autho);
       if($row_Autho = mysql_fetch_array($result_Autho))
	   {
	   	echo $row_Autho["Name"];
	   }
	?>          </td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">Merchandiser</td>
        <td class="normalfnth2Bm">Merchandising Manager</td>
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
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
