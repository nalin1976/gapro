<?php
include "../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate Pass TransferIn :: Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<?php 
	$mainStore=$_GET["mainStore"];
	$GatePass=$_GET["GatePassNo"];
	
	$mainStoreID=$_GET["mainStoreID"];
	$GatePassID=$_GET["GatePassNoID"];
	$chkBox=$_GET["chkBox"];
	
	//$pubTransInNo ="124";
	//	$pubTransInYear="2009";
?>
<table width="1200" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="../images/logo.jpg" class="normalfnt" /></td>
        <td width="1%" class="normalfnt">&nbsp;</td>
<?php
	 $SQLHeader="SELECT ".
				"CONCAT(TIH.intTINYear,'/',TIH.intTransferInNo) AS TransferInNo, ".
				"CONCAT(TIH.intGPYear,'/',TIH.intGatePassNo) AS GatePassNo, ".
				"TIH.dtmDate, ".
				"TIH.intStatus, ".
				"TIH.strRemarks, ".
				"TIH.intStatus, ".
				"UA.Name, ".
				"CO.strName, ".
				"CO.strAddress1, ".
				"CO.strAddress2, ".
				"CO.strStreet, ".
				"CO.strCity, ". 
				"CO.intCountry, ".
				"CO.strZipCode, ".
				"CO.strPhone, ".
				"CO.strEMail, ".
				"CO.strFax, ".
				"CO.strWeb ".				
				"FROM ".
				"gategasstransferinheader AS TIH ".
				"Inner Join useraccounts AS UA ON TIH.intUserid = UA.intUserID ".
				"Inner Join companies AS CO ON UA.intCompanyID = CO.intCompanyID ";
			//echo $SQLHeader;
			$resultHeader=$db->RunQuery($SQLHeader);			
			while($row=mysql_fetch_array($resultHeader))
			{
				$TransferInNo 	=$row["TransferInNo"];
				$GatePassNo		=$row["GatePassNo"];
				$Date			=$row["dtmDate"];
				$Remarks		=$row["strRemarks"];
				$UserName		=$row["Name"];
				$CompanyName 	=$row["strName"];
				$Address1    	=$row["strAddress1"];
				$Address2    	=$row["strAddress2"];
				$Street    		=$row["strStreet"];
				$City    		=$row["strCity"];
				$Country    	=$row["strCountry"];
				$ZipCode    	=$row["strZipCode"];
				$Phone    		=$row["strPhone"];
				$Fax    		=$row["strFax"];
				$EMail    		=$row["strEMail"];				
				$Web    		=$row["strWeb"];				
				$Status			=$row["intStatus"];
				
				
			}
			
?>
        <!--<td width="75%" class="tophead"><p class="topheadBLACK"><?php echo $CompanyName;?></p>
            <p class="normalfnt"><?php echo $Address1."&nbsp;".$Address2."&nbsp;".$Street;?></p>
			<p class="normalfnt"><?php echo $City."&nbsp;".$Country.".";?></p>
			<p class="normalfnt"><?php echo "Tel : "."(".($ZipCode).") ".$Phone." , Fax : "."(".($ZipCode).") ".$Fax.".";?></p>
          <p class="normalfnt"><?php echo "E-Mail : ".$EMail." , Web : ".$Web ?></p></td>-->
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="6" class="head2">Goods In Transit Report </td>
      </tr>

      <tr>
        <td width="8%" class="normalfnth2B">Main Store </td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="33%" class="normalfnt"><?php echo $mainStore;?></td>
        <td width="14%">&nbsp;</td>
        <td width="17%" class="normalfnth2B"> </td>
        <td width="27%" class="normalfnt"></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B"></td>
        <td height="13" class="normalfnth2B"></td>
        <td class="normalfnt" ></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td width="27%" valign="top" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>

 <!-- <tr>
    <td colspan="2" class="normalfnth2B"><p class="normalfnth2B">PLEASE SUPPLY IN ACCORDANCE WITH THE INSTRUCTIONS HEREIN THE FOLLOWING : </p>
    <p class="normalfntSM">PLEASE INDICATE OUR P.O NO IN ALL YOUR INVOICES, PERFORMA INVOICES AND OTHER RELEVANT DOCUMENTS AND DELIVER TO THE ABOVE MENTIONED DESTINATION AND INVOICE TO THE CORRECT PARTY.</p></td>
  </tr>-->
  <tr>  	
    <td colspan="3" class="normalfntRiteSML"><div align="center"><span class="style4"></span></div></td>
  </tr>
 
   <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">
<thead>

 <tr>
 <td class='normalfntBtab' align="center" width="3%"><font  style='font-size: 11px;' > #</font></td>
 <td class='normalfntBtab' align="center" width="35%"><font  style='font-size: 11px;' > Description</font></td>
 <td class='normalfntBtab' align="center" width="10%"><font  style='font-size: 11px;' > Style</font></td>
 <td class='normalfntBtab' align="center" width="10%"><font  style='font-size: 11px;' > Buyer Po No</font></td>
 <td class='normalfntBtab' align="center" width="3%"><font  style='font-size: 11px;' >Color</font></td>
 <td class='normalfntBtab' align="center" width="2%"><font  style='font-size: 11px;' > Size</font></td>
 <td class='normalfntBtab' align="center" width="6%"><font  style='font-size: 11px;' > GP Qty</font></td>
  <td class='normalfntBtab' align="center" width="10%"><font  style='font-size: 11px;' > Trans In Store</font></td>
 <td class='normalfntBtab' align="center" width="6%"><font  style='font-size: 11px;' > Trans Qty</font></td>
 <td class='normalfntBtab' align="center" width="6%"><font  style='font-size: 11px;' > Balance Qty</font></td>
 </tr>
</thead>
<?php

$SQL1="SELECT
gatepassdetails.intGatePassNo,
gatepassdetails.intGPYear,
orders.strStyle,
materialratio.materialRatioID,
gatepassdetails.intMatDetailId,
gatepassdetails.strColor,
gatepassdetails.strSize,
gatepassdetails.dblQty,
gatepassdetails.dblBalQty,
(gatepassdetails.dblQty-gatepassdetails.dblBalQty)AS TIqty,
mainstores.strName,
mainTo.strName AS transTo,
mainFrom.dtmDate,
matitemlist.strItemDescription,
stocktransactions.dblQty AS tranQty
FROM gatepassdetails Left Join stocktransactions ON gatepassdetails.intGatePassNo = stocktransactions.intDocumentNo AND gatepassdetails.intGPYear = stocktransactions.intDocumentYear AND gatepassdetails.intStyleId = stocktransactions.intStyleId AND gatepassdetails.strBuyerPONO = stocktransactions.strBuyerPoNo AND gatepassdetails.intMatDetailId = stocktransactions.intMatDetailId AND gatepassdetails.strColor = stocktransactions.strColor AND gatepassdetails.strSize = stocktransactions.strSize Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID Inner Join gatepass AS mainFrom ON mainFrom.intGatePassNo = gatepassdetails.intGatePassNo AND mainFrom.intGPYear = gatepassdetails.intGPYear Inner Join mainstores AS mainTo ON mainTo.strMainID = mainFrom.strTo Inner Join matitemlist ON matitemlist.intItemSerial = gatepassdetails.intMatDetailId
Inner Join orders ON orders.intStyleId = gatepassdetails.intStyleId
Inner Join materialratio ON materialratio.intStyleId = gatepassdetails.intStyleId AND materialratio.strMatDetailID = gatepassdetails.intMatDetailId AND materialratio.strColor = gatepassdetails.strColor AND materialratio.strSize = gatepassdetails.strSize AND materialratio.strBuyerPONO = gatepassdetails.strBuyerPONO
WHERE 
mainFrom.intStatus = '1'";


if($mainStoreID != ""){
$SQL1.=" AND stocktransactions.strMainStoresID = '$mainStoreID'";
}
if($chkBox == '0'){
$SQL1.=" AND gatepassdetails.dblBalQty> '0'";
}
if($chkBox == '1'){
$SQL1.=" AND gatepassdetails.dblQty =  gatepassdetails.dblBalQty";
}
if($GatePassID != " "){
$SQL1.=" AND gatepassdetails.intGatePassNo = '$GatePassID'";
}
$SQL1.=" ORDER BY gatepassdetails.intGatePassNo";
   $flg_newdocyn = "";
   $flg_firstyn  = "";
   $te_docmain   = ""; 
   

		//echo $SQL1;				 		   			    
        $result = $db->RunQuery($SQL1);

	    $i=1;

		while($row = mysql_fetch_array($result))
		{
		
        $strItemDescription = $row["strItemDescription"];
		$intGatePassNo = $row["intGPYear"]."/".$row["intGatePassNo"];
		$strStyleNo = $row["strStyle"];
		$strBuyerPoNo = $row["materialRatioID"];
		$strColor = $row["strColor"];
		$strSize  = $row["strSize"];
		$gatepassQty  = $row["dblQty"];
		$transTo  = $row["transTo"];
		$transferQty  = $row["TIqty"];
		$balance  = $row["dblBalQty"];
		$dtmDate  = $row["dtmDate"];
		
    if($te_docmain != $intGatePassNo)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $intGatePassNo;
	

    if($flg_newdocyn == "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
      echo "<tr>";
	  echo "<td></td>";
	  echo "<td></td>";
	  echo "<td></td>";   
	  echo "<td></td>";
	  echo "<td></td>"; 
	  echo "<td></td>"; 
	  echo "<td></td>";     
      echo "</tr>";
     }	    
    } 
	
	if(number_format($balance,2)>0){
	
	if($flg_newdocyn== "y")
    {
     echo "<tr bgcolor='#E4E4E4'>";
     echo "<td class='normalfnt' colspan='10'>Gate Pass No :&nbsp;&nbsp;$intGatePassNo &nbsp;&nbsp;Date :  $dtmDate</td>";
     echo "</tr>"; 
    }  
	 
	 
?>
	
     <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''">	
	 <?php
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strItemDescription</td>";
	  echo"<td class='normalfnt'>$strStyleNo</td>";
	  echo"<td class='normalfnt'>$strBuyerPoNo</td>";
	  echo"<td class='normalfnt'>$strColor</td>";
	  echo"<td class='normalfntRite'>$strSize</td>";
	  echo"<td class='normalfntRite'>".number_format($gatepassQty,2)."</td>";
	  echo"<td class='normalfnt'>$transTo</td>";
	  echo"<td class='normalfntRite'>".number_format($transferQty,2)."</td>";
	  echo"<td class='normalfntRite'>".number_format($balance,2)."</td>";
   echo"</tr>";	
    $i++;	
	 }
   }
	
   ?>						
</table>
</td>
  </tr>
</table>
</body>
</html>
