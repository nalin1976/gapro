<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include "../../eshipLoginDB.php";
	include $backwardseperator."authentication.inc";
	
	$eshipDB = new eshipLoginDB();
	$styleID = $_GET["styleID"];	
	$invoiceID = $_GET["invoiceID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CVWS</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<?php 
	$sql_fs = " select intStatus from  firstsale_shippingdata where intStyleId='$styleID' and dblInvoiceId='$invoiceID' ";
	$result_fs = $db->RunQuery($sql_fs);
	$rowFS = mysql_fetch_array($result_fs);
	
	$fsStatus = $rowFS["intStatus"];
	
	if($fsStatus == 0)
	{
?>
<div style="position:absolute;top:200px;left:250px;">
<img src="../../images/pending.png">
</div>
<?php 
	}
	if($fsStatus==10)
	{
?>
<div style="position:absolute;top:200px;left:400px;"><img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php 
}
	
	$invoiceId = $_GET["invoiceID"];

	$sql_fsData= "Select fss.strOrderNo,fss.strOrderColorCode,fss.strComInvNo,fss.strInvoiceNo,
				date_format(fsh.dtmOTLdate,'%d-%M-%Y') as invDate,fsh.intApprovedBy ,fsh.intStyleId 
				from  firstsale_shippingdata fss inner join firstsalecostworksheetheader fsh on
				fss.intStyleId = fsh.intStyleId
				where fss.intStyleId='$styleID' and fss.dblInvoiceId='$invoiceId' ";

	$res_fsData =$db->RunQuery($sql_fsData);
	$rowFS = mysql_fetch_array($res_fsData); 
	
	$orderNo = $rowFS["strOrderNo"];
	$color  = $rowFS["strOrderColorCode"];
	$commInvNo = $rowFS["strComInvNo"];
	$invoiceNo = $rowFS["strInvoiceNo"];
	$intApprovedBy = $rowFS["intApprovedBy"];
	$intStyleId = $rowFS["intStyleId"];
	//$invoiceDate = $rowFS["invDate"];
	//get shipping details
	
	$sql_shipData= "select splh.strProductCode,date_format(cih.dtmSailingDate,'%d-%M-%Y')  as SailingDate,sum(cid.dblQuantity) as dblQuantity,cih.strCarrier,cid.strBuyerPONo,
			cid.strFabric, cid.strSpecDesc as strDescOfGoods,
			date_format(DATE_SUB(cih.dtmSailingDate,INTERVAL 2 DAY),'%d-%M-%Y') AS invoiceDate,
			cih.strLCBankID,cih.strDeliverTo,cid.dblUnitPrice,fi.strGender,
			c.strName as customer,c.strAddress1 as cutomerAdd1,c.strAddress2 as cutomerAdd2,c.strCountry custCountry,
			b.strName as buyer,b.strAddress1 as buyerAdd1,b.strAddress2 as buyerAdd2,b.strCountry as buyerCountry,
			city.strPortOfLoading as loadingPort, city.strCity as destination,
			cid.strHSCode as HTSdata,cih.strCSCId
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo  -- and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join finalinvoice fi on fi.strInvoiceNo = cih.strInvoiceNo
			inner join customers c on  c.strCustomerID = cih.strCompanyID
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			inner join city on city.strCityCode = cih.strFinalDest
			where cid.strInvoiceNo ='$commInvNo'  and splh.intStyleId='$intStyleId' group by splh.intStyleId ";
			 	 
	$res_ShipData = $eshipDB->RunQuery($sql_shipData);
	$rowS = mysql_fetch_array($res_ShipData); 
	
	$strBuyerPONo = $rowS["strBuyerPONo"];
	$customer = $rowS["customer"];
	$customer_add1 = $rowS["cutomerAdd1"];
	$cutomerAdd2  = $rowS["cutomerAdd2"];
	$customer_country = $rowS["custCountry"];
	
	$buyer = 	$rowS["buyer"];
	$buyer_add1 = $rowS["buyerAdd1"];
	$buyer_add2 = $rowS["buyerAdd2"];
	$buyer_country	 = $rowS["buyerCountry"]; 
	
	$itemDesc = $rowS["strFabric"]; 
	$itemDescOther = $rowS["strDescOfGoods"]; 
	
	$styleNo = $rowS["strProductCode"]; 
	$shipQty = $rowS["dblQuantity"]; 
	$usHTSdata = $rowS["HTSdata"]; 
	
	$port = $rowS["loadingPort"]; 
	$carrier = $rowS["strCarrier"]; 
	$finalDestination = $rowS["destination"]; 
	$sailingDate = $rowS["SailingDate"]; 
	
	$invoiceDate = $rowS["invoiceDate"];
	$shipTo =  $rowS["strDeliverTo"];
	if($shipTo =='' || is_null($shipTo))
		$shipTo = $rowS["strCSCId"];

	$res_shipTo  = getShipToBuyerDetails($shipTo);
	$rowShip = mysql_fetch_array($res_shipTo);
	$shipToBuyer = $rowShip["strName"];
	$shipToBuyerAdd1 = $rowShip["strAddress1"];
	$shipToBuyerAdd2 = $rowShip["strAddress2"];
	$shipToBuyerCountry = $rowShip["strCountry"];
	
	
	$xmlObj = simplexml_load_file('../../company.xml');
					$comName = $xmlObj->Name->CompanyName;
					$comAddress1= $xmlObj->Address->AddressLine1;
					$comAddress2= $xmlObj->Address->AddressLine2;
					$comStreet= $xmlObj->Address->Street;
					$comCity= $xmlObj->Address->City;
					$comCountry= $xmlObj->Address->Country;
					$comstrPhone= $xmlObj->Address->Telephone;
					$comEMail= $xmlObj->Address->Email;
					$comFax= $xmlObj->Address->Fax;
					$comWeb= $xmlObj->Address->Web;
					$comVatNo = $xmlObj->Address->VatRegNo;
					$comTQBNo = $xmlObj->Address->TQBRegNo;
	 
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">U.S. Customs Value Worksheet Summary</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="2" style="width:800PX; line-height:17PX;" align="center">
      <tr>
        <td width="338" class="border-top-left-fntsize12" style="font-weight:bold;">MANUFACTURER</td>
        <td width="462" class="border-Left-Top-right-fntsize12" style="font-weight:bold;">CMPW / Factory Invoice Number</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $customer;  ?></td>
        <td class="border-Left-Top-right-fntsize12" ><?php echo $invoiceNo; ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $customer_add1.' '.$cutomerAdd2; ?></td>
        <td rowspan="2" class="border-All-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="34%" style="font-weight:bold; font-size:12px; font-family:Verdana;">Invoice Date</td>
            <td width="66%" class="normalfnt_size12"><?php  echo $invoiceDate; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize12"><?php echo $customer_country; ?></td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold">Buyer / For Account &amp; Risk of Messers</td>
        <td class="border-Left-bottom-right-fntsize12" style="font-weight:bold">Ultimate Consignee</td>
      </tr>
      <tr>
        <td rowspan="8" class="border-bottom-left-fntsize12"><table width="100%" border="0">
          <tr>
            <td height="27" class="normalfnt_size12"><?php echo strtoupper($comName); ?></td>
          </tr>
          <tr>
            <td height="27" class="normalfnt_size12"><?php echo strtoupper($comAddress1).', '.strtoupper($comAddress2); ?></td>
          </tr>
          <tr>
            <td height="27" class="normalfnt_size12"><?php echo strtoupper($comStreet).', '.strtoupper($comCity); ?> </td>
          </tr>
          <tr>
            <td height="27" class="normalfnt_size12"><?php echo strtoupper($comCountry); ?>. </td>
          </tr>
          <tr>
            <td height="27" class="normalfnt_size12">TEL # <?php echo $comstrPhone; ?>, FAX# <?php echo $comFax; ?><td>
          </tr>
        </table></td>
        <td class="border-left-right"><?php echo $buyer; ?></td>
      </tr>
      <tr>
        <td class="border-left-right"><?php echo $buyer_add1.' '.$buyer_add2; ?></td>
      </tr>
      <tr>
        <td class="border-left-right"><?php echo ($buyer_country==''?'&nbsp;':$buyer_country); ?></td>
      </tr>
      <tr>
        <td class="border-left-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right" style="font-weight:bold">Shipped To</td>
      </tr>
      <tr>
        <td class="border-left-right"><?php echo $shipToBuyer;  ?></td>
      </tr>
      <tr>
        <td class="border-left-right"><?php echo $shipToBuyerAdd1.' '.$shipToBuyerAdd2; ?></td>
      </tr>
      <tr>
        <td class="border-Left-bottom-right"><?php echo $shipToBuyerCountry; ?></td>
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold">Port of Loading :&nbsp;&nbsp;&nbsp;<span style="font-family:Verdana; font-size:12px; text-align:center; font-weight:normal" >Colombo</span></td>
        <td class="border-Left-bottom-right-fntsize12"><span style="font-weight:bold">Final Destination :</span>&nbsp;&nbsp;&nbsp;<?php echo $finalDestination; ?></td>
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold">Carrier : &nbsp;&nbsp;&nbsp; <span style="font-family:Verdana; font-size:12px; text-align:center; font-weight:normal" ><?php echo $carrier; ?></span></td>
        <td class="border-Left-bottom-right-fntsize12" ><span style="font-weight:bold">Saling on or about :</span>&nbsp;&nbsp;&nbsp;<?php echo $sailingDate; ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12" style="font-weight:bold" height="25">Product Description</td>
        <td class="border-right-fntsize12"><?php echo $itemDesc.'&nbsp;'.$itemDescOther; ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12" style="font-weight:bold" height="25">US Customer Purchase Order :</td>
        <td class="border-right-fntsize12"><?php echo $strBuyerPONo; ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12" style="font-weight:bold" height="25">Style Number :</td>
        <td class="border-right-fntsize12"><?php echo getStyleName($styleID); ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12" style="font-weight:bold" height="25">Quantity (Number of pairs) :</td>
        <td class="border-right-fntsize12"><?php echo $shipQty; ?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12" style="font-weight:bold" height="25">Country of Origin :</td>
        <td class="border-right-fntsize12">Sri Lanka </td>
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold" height="25">U.S.HTS Data :</td>
        <td class="border-bottom-right-fntsize12"><?php echo $usHTSdata; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-All-fntsize12"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="377" class="normalfntb" >COST BREAKDOWN</td>
            <td width="95" class="normalfntb">VALUE PRICE</td>
            <td width="328" class="normalfntb">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><table width="737" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td width="319" class="normalfnt_size12">Material</td>
				<?php 
					$sql_mat = "select sum(fsd.dblValue) as Matprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=1 ";
				
				$result_mat  =$db->RunQuery($sql_mat);
				$row_mat = mysql_fetch_array($result_mat); 
				$matPrice = $row_mat["Matprice"];
				?>
                <td width="122" class="normalfnt_size12" style="text-align:right"><?php echo number_format($matPrice,2); ?></td>
                <td width="296">&nbsp;</td>
              </tr>
              <tr>
			  <?php 
					$sql_acc = "select sum(fsd.dblValue) as Accprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=2 ";
				
				$result_acc  =$db->RunQuery($sql_acc);
				$row_acc = mysql_fetch_array($result_acc);
				
				$accPrice = $row_acc["Accprice"];
				$type =2;
				$invProcesAccVal = getInvProcessValue($styleID,$type);
				$accPrice += $invProcesAccVal;
				?>
                <td class="normalfnt_size12">Accessories</td>
                <td class="normalfnt_size12" style="text-align:right"><?php echo number_format($accPrice,2); ?></td>
                <td>&nbsp;</td>
              </tr>
              <?php 
			  //check Hanger or belts available
			  $chkHangerAv = checkOtherAccAV(5,$styleID);
			  $hangerPrice=0;
			  if($chkHangerAv == '1')
			  {
			  		$hangerPrice = getOtherAccPrice(5,$styleID);
			  ?>
              <tr>
               <td class="normalfnt_size12">Hanger</td>
                <td class="normalfnt_size12" style="text-align:right"><?php echo number_format($hangerPrice,2); ?></td>
                <td>&nbsp;</td>
              </tr>
              <?php 
			  }
			  ?>
               <?php 
			  //check  belts available
			  $chkBeltsAv = checkOtherAccAV(6,$styleID);
			  $beltsPrice=0;
			  if($chkBeltsAv == '1')
			  {
			  		$beltsPrice = getOtherAccPrice(6,$styleID);
			  ?>
              <tr>
               <td class="normalfnt_size12">Belts</td>
                <td class="normalfnt_size12" style="text-align:right"><?php echo number_format($beltsPrice,2); ?></td>
                <td>&nbsp;</td>
              </tr>
              <?php 
			  }
			  ?>
              <tr>
			  <?php 
			  $invProcesAccVal=0;
					$sql_trans = "select sum(fsd.dblValue) as Transprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=5 ";
				
				$result_trans  =$db->RunQuery($sql_trans);
				$row_trans = mysql_fetch_array($result_trans);
				
				$transPrice = $row_trans["Transprice"];
				$type =3;
				$invProcesAccVal = getInvProcessValue($styleID,$type);
				$transPrice += $invProcesAccVal;
				?>
                 <?php 
			  $invProcesAccVal=0;
					$sql_trans = "select sum(fsd.dblValue) as Transprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=3 ";
				
				$result_trans  =$db->RunQuery($sql_trans);
				$row_trans = mysql_fetch_array($result_trans);
				
				$transPrice = $row_trans["Transprice"];
				$type =3;
				$invProcesAccVal = getInvProcessValue($styleID,$type);
				$transPrice += $invProcesAccVal;
				?>
                <td class="normalfnt_size12">Transporting Assists &amp; Other Services</td>
                <td class="normalfnt_size12" style="text-align:right"><?php echo number_format($transPrice,2); ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
			   <?php 
					$sql_cmpw = "select sum(fsd.dblValue) as cmpwprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=4 ";
				
				$result_cmpw  =$db->RunQuery($sql_cmpw);
				$row_cmpw = mysql_fetch_array($result_cmpw);
				
				$CmpwPrice = $row_cmpw["cmpwprice"];
				?>
                <td class="normalfnt_size12">CMPW</td>
                <td class="normalfnt_size12" style="text-align:right"><?php echo number_format($CmpwPrice,2); ?></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td class="normalfnt_size12" style="font-weight:bold"> Total First Sale Price</td>
            <td class="normalfnt_size12" style="text-align:right; font-weight:bold"><?php $totCost = round($matPrice,2) + round($accPrice,2)+round($transPrice,2)+round($CmpwPrice,2)+round($hangerPrice,2)+round($beltsPrice,2);
			echo number_format($totCost,2);
			
			$totCostValue = round($totCost,2)*$shipQty;
			 ?></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold">Total To Be Declared To U.S Customs</td>
        <td class="border-bottom-right-fntsize12" style="font-weight:bold"><table width="100%" border="0">
          <tr>
            <td width="29%" class="normalfnt_size12" style="text-align:right; font-weight:bold"><?php echo number_format($totCostValue,2); ?></td>
            <td width="71%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
	  <?php 
	 $totVarValue=convert_number(round($totCostValue,2));
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
$convrt = explode(".",round($totCostValue,2));

$cents =  $convrt[1];
if ($cents < 10)
$cents = $convrt[1];

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

	  ?>
        <td colspan="2" class="border-Left-bottom-right-fntsize12" style="font-weight:bold"><?php echo $totVarValue.' '.'AND '.$cents.' / '.'100 ONLY'; ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-All-fntsize12"><table width="800" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="4" class="normalfnt">I certify that the above calculation are a true and accurate reflection of the style described and that the </td>
            </tr>
          <tr>
            <td colspan="4" class="normalfnt">goods in question have been or will be sold to <?php echo $buyer; ?> at the invoice price quoted.</td>
            </tr>
          <tr>
            <td width="111">&nbsp;</td>
            <td width="353">&nbsp;</td>
            <td width="74">&nbsp;</td>
            <td width="231">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt" style="font-style:italic">Signed :</td>
             <?php 
			
			if($fsStatus == 1)
			{
			?>
           <td rowspan="2" align="left"><img src="<?php echo '../../upload files/approvalImg/'. $intApprovedBy.'.jpg'; ?>" width="241" height="115"></td>
           <?php 
			}
			else
			{
			?>
            <td>&nbsp;</td>
             <?php 
			 }
			 ?>
            <td class="normalfnt" style="font-style:italic">Date :</td>
            <td class="normalfntTAB2" style="text-align:left"><?php echo $invoiceDate; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            
            
             
            <td>&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td class="normalfnt">Sureshinie Fernando</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getInvProcessValue($styleID,$type)
{
	global $db;
	
	$sql = "select sum(dblUnitprice) as dblUnitprice from firstsale_invprocessdetails where intStyleId='$styleID' and intFScategoryId='$type'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return number_format($row["dblUnitprice"],4);
}
function getStyleName($styleID)
{
	global $db;
	$sql = "select strStyle from orders where intStyleId='$styleID'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}

function getShipToBuyerDetails($shipTo)
{
	$eshipDB = new eshipLoginDB();
	$sql = "select * from buyers where strBuyerID='$shipTo' ";
	return $eshipDB->RunQuery($sql);
}

function checkOtherAccAV($type,$styleId)
{
	global $db;
	$sql = "select * from firstsalecostworksheetdetail fsd 	where fsd.intStyleId = '$styleId' and fsd.strType='$type' ";
	return $db->CheckRecordAvailability($sql);
}

function getOtherAccPrice($type,$styleId)
{
	global $db;
	$sql = "select sum(fsd.dblValue) as totPrice 	from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleId' and fsd.strType='$type' ";
				
				$result  =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				
				return $row["totPrice"];
}
?>
</body>
</html>
