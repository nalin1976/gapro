<?php

session_start();
include "../Connector.php";	

# Get parameter values
$_intMaxDeliveries = $_GET['nodeli'];
$_arrStyleCodes = $_GET['arrstyles'];

$fProduct ="PRODUCTS.CSV";

$strEmbelishmentList = '';


$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);

# =============================================================
# Change On - 06/27/2016
# Chnage By - Nalin Jayakody
# Chnage For - To re-arrange the PRODUCT.CSV file request by FR
# ==============================================================
//$_arrHeader = array("P.CODE", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250","P.TYPE","P.DESCRIP","P.UDCosted Effi.","P.UDCosted SMV","P^WC:10");
# ==============================================================

//$_arrHeader = array("P.CODE","P.DESCRIP", "P.TYPE","P^WC:10", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250", "P.UDCosted Effi.","P.UDCosted SMV", "END");

# =============================================================
# Change On - 05/03/2017
# Chnage By - Nalin Jayakody
# Chnage For - To add new header lines to the PRODUCT.CSV
# =============================================================
//$_arrHeader = array("P.CODE","P.DESCRIP", "P.TYPE","P.CUST","P^WC:10", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250", "P.UDCosted Effi.","P.UDCosted SMV", "END");
# ============================================================= 
#
 $_arrHeader = array("P.CODE","P.TYPE","P.DESCRIP","P.CUST","P^WC:10","P^WC:100","P^WC:105","P^WC:110","P^WC:120","P^WC:140","P^WC:145","P^WC:160","P^WC:170","P^WC:180","P^WC:185","P^WC:190","P^WC:195","P^WC:200","P^WC:220","P^WC:225","P^WC:230","P^WC:231","P^WC:240","P^WC:250", "P.UDCosted Effi.","P.UDCosted SMV","P.UdEmb Type","P.UdHela Prod Code", "END");
# 
# Open product.csv
//$output = fopen($fProduct, "w");
$output = fopen('php://memory', "w");

# Add product.csv header details array to the main array variable
$_arrProductForCSV[0] = $_arrHeader;	
$iArrayPossition = 1;

# Get length of the style code array
$_intStyleCodeLength = count($_arrStyleCodesList);

$_arrProductDetails = array(); # Initialize product details array

for($i=0;$i<$_intStyleCodeLength;$i++){
 
  # Get the product details for give style code
  $_resProduct = GetDetailsForProduct($_arrStyleCodesList[$i]);
  
  $_intStylePartRowCount =  mysql_num_rows($_resProduct);
  
  if($_intStylePartRowCount>1){		  	  
  	
	 while($row = mysql_fetch_array($_resProduct)){	
             
                  $strEmbelishmentList = GetEmbelishmentList(IsEmbelishmentExist($row["intCPL"]), IsEmbelishmentExist($row["intPreSew"]),
                                                             IsEmbelishmentExist($row["intPrint"]),IsEmbelishmentExist($row["intEMB"]), IsEmbelishmentExist($row["intBNP"]),IsEmbelishmentExist($row["intHTP"]), IsEmbelishmentExist($row["intSA"]),
                                                             IsEmbelishmentExist($row["intDA"]), IsEmbelishmentExist($row["intSmoking"]), IsEmbelishmentExist($row["intOther"]),IsEmbelishmentExist($row["intPleating"]),
                                                             IsEmbelishmentExist($row["intWash"]), $row["iGarmentDye"], IsEmbelishmentExist($row["intPressing"]), $row["iPermanantCreasing"]);
			  
		  $_arrProductDetails[0] = $row["strStylePrefix"]." - ".$row["strPartName"];                  
                  $_arrProductDetails[1] = $row["strCatName"];
                  $_arrProductDetails[2] = $row["strDescription"];
                  $_arrProductDetails[3] = $row["strName"];
		  $_arrProductDetails[4] = "1";
		  $_arrProductDetails[5] = "1";
		  $_arrProductDetails[6] = IsEmbelishmentExist($row["intCPL"]);//"1";
		  $_arrProductDetails[7] = IsEmbelishmentExist($row["intPreSew"]);
		  $_arrProductDetails[8] = IsEmbelishmentExist($row["intPrint"]);
		  $_arrProductDetails[9] = IsEmbelishmentExist($row["intEMB"]);
		  $_arrProductDetails[10] = IsEmbelishmentExist($row["intBNP"]);
                  //$_arrProductDetails[10] = $row["strStyle"];
		  $_arrProductDetails[11] = IsEmbelishmentExist($row["intHTP"]);
		  $_arrProductDetails[12] = IsEmbelishmentExist($row["intSA"]);
                  $_arrProductDetails[13] = IsEmbelishmentExist($row["intDA"]);
                  $_arrProductDetails[14] = IsEmbelishmentExist($row["intSmoking"]);
                  $_arrProductDetails[15] = IsEmbelishmentExist($row["intOther"]);
                  $_arrProductDetails[16] = IsEmbelishmentExist($row["intPleating"]);
                  $_arrProductDetails[17] = $row["reaSMV"];
                  $_arrProductDetails[18] = IsEmbelishmentExist($row["intWash"]);
                  $_arrProductDetails[19] = $row["iGarmentDye"];
                  $_arrProductDetails[20] = IsEmbelishmentExist($row["intPressing"]);
                  $_arrProductDetails[21] = $row["iPermanantCreasing"];
                  $_arrProductDetails[22] = $row["reaPackSMV"];
                  $_arrProductDetails[23] = "1";
                  $_arrProductDetails[24] = $row["reaEfficiencyLevel"];
                  $_arrProductDetails[25] = $row["reaSMV"];
                  $_arrProductDetails[26] = $strEmbelishmentList;
                  $_arrProductDetails[27] = $row["intStyleId"];
                  $_arrProductDetails[28] = "END";
		  
		  $_arrProductForCSV [$iArrayPossition] = $_arrProductDetails;
		  $iArrayPossition++;
	  }
	  
  }else{ # Only 1 style part consist for the order
	  
	   while($row = mysql_fetch_array($_resProduct)){
               
                $strEmbelishmentList = GetEmbelishmentList(IsEmbelishmentExist($row["intCPL"]), IsEmbelishmentExist($row["intPreSew"]),
                                                             IsEmbelishmentExist($row["intPrint"]),IsEmbelishmentExist($row["intEMB"]), IsEmbelishmentExist($row["intBNP"]),IsEmbelishmentExist($row["intHTP"]), IsEmbelishmentExist($row["intSA"]),
                                                             IsEmbelishmentExist($row["intDA"]), IsEmbelishmentExist($row["intSmoking"]), IsEmbelishmentExist($row["intOther"]),IsEmbelishmentExist($row["intPleating"]),
                                                             IsEmbelishmentExist($row["intWash"]), $row["iGarmentDye"], IsEmbelishmentExist($row["intPressing"]), $row["iPermanantCreasing"]);
			  
		  $_arrProductDetails[0] = $row["strStylePrefix"];                  
                  $_arrProductDetails[1] = $row["strCatName"];
                  $_arrProductDetails[2] = $row["strDescription"];
                  $_arrProductDetails[3] = $row["strName"];
		  $_arrProductDetails[4] = "1";
                  $_arrProductDetails[5] = "1";
                  $_arrProductDetails[6] = IsEmbelishmentExist($row["intCPL"]);//"1";
		  $_arrProductDetails[7] = IsEmbelishmentExist($row["intPreSew"]);
		  $_arrProductDetails[8] = IsEmbelishmentExist($row["intPrint"]);
		  $_arrProductDetails[9] = IsEmbelishmentExist($row["intEMB"]);
		  $_arrProductDetails[10] = IsEmbelishmentExist($row["intBNP"]);
		  //$_arrProductDetails[10] = $row["strStyle"];
                  $_arrProductDetails[11] = IsEmbelishmentExist($row["intHTP"]);
                  $_arrProductDetails[12] = IsEmbelishmentExist($row["intSA"]);
                  $_arrProductDetails[13] = IsEmbelishmentExist($row["intDA"]);
                  $_arrProductDetails[14] = IsEmbelishmentExist($row["intSmoking"]);
                  $_arrProductDetails[15] = IsEmbelishmentExist($row["intOther"]);
                  $_arrProductDetails[16] = IsEmbelishmentExist($row["intPleating"]);
                  $_arrProductDetails[17] = $row["reaSMV"];
                  $_arrProductDetails[18] = $row["intWash"];
                  $_arrProductDetails[19] = $row["iGarmentDye"];
                  $_arrProductDetails[20] = $row["intPressing"];
                  $_arrProductDetails[21] = $row["iPermanantCreasing"];
                  $_arrProductDetails[22] = $row["reaPackSMV"];
                  $_arrProductDetails[23] = "1";
                  $_arrProductDetails[24] = $row["reaEfficiencyLevel"];
                  $_arrProductDetails[25] = $row["reaSMV"];
                  $_arrProductDetails[26] = $strEmbelishmentList;
                  $_arrProductDetails[27] = $row["intStyleId"];
                  $_arrProductDetails[28] = "END";
                  
	  }
	  
	  $_arrProductForCSV [$iArrayPossition] = $_arrProductDetails;
	  $iArrayPossition++;
  }
  
  
  
  # update the transfer status of the product
  SetProductTransferStatus($_arrStyleCodesList[$i]);  
}




# Create full PRODUCTS.CSV file
foreach($_arrProductForCSV as $rowHeader){
	fputcsv($output, $rowHeader);	
}

# Close opened PRODUCTS.CSV file
//fclose($output);
fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fProduct);
header('Cache-Control: max-age=0');

fpassthru($output);

function GetDetailsForProduct($prmStyleCode){
	
	global $db;
        
        # ===========================================================
        # Comment On - 05/03/2017
        # Comment By - Nalin Jayakody
        # Comment For - Get embelishment types to the PRODUCT.CSV file
        # ===========================================================
	
	/*$strSql = " SELECT
specification.intSRNO,
orders.strStyle,
orders.strDescription,
orders.intQty,
stylepartdetails.strPartName,
fr_producttransferlist.strStylePrefix,
orders.reaSMV,
orders.reaEfficiencyLevel,
stylepartdetails.dblsmv,
productcategory.strCatName
FROM
specification
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
Inner Join fr_producttransferlist ON stylepartdetails.intStyleId = fr_producttransferlist.intStyleId
Left Join productcategory ON orders.productSubCategory = productcategory.intCatId
WHERE
fr_producttransferlist.booTransfered =  '0' AND
orders.intStyleId = ".$prmStyleCode;*/
        
        # ===========================================================
        
        $strSql = " SELECT specification.intSRNO, orders.strStyle, orders.strDescription, orders.intQty,
                          stylepartdetails.strPartName, fr_producttransferlist.strStylePrefix, orders.reaSMV,
                          orders.reaEfficiencyLevel, stylepartdetails.dblsmv, productcategory.strCatName, buyers.strName,
                          orders.intCPL, orders.intBNP, orders.intDA, orders.intEMB, orders.intHeatSeal, orders.intHTP,
                          orders.intHW, orders.intPleating, orders.intPreSew, orders.intPressing, orders.intPrint,
                          orders.intSA, orders.intSmoking, orders.intWash, stylepartdetails.iGarmentDye, stylepartdetails.iPermanantCreasing,
                          orders.intOther, orders.intStyleId, orders.reaPackSMV
                    FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                    INNER JOIN stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
                    INNER JOIN fr_producttransferlist ON stylepartdetails.intStyleId = fr_producttransferlist.intStyleId
                    LEFT JOIN productcategory ON orders.productSubCategory = productcategory.intCatId
                    INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
                    WHERE fr_producttransferlist.booTransfered =  '0' AND
                          orders.intStyleId = ".$prmStyleCode;
        

$result = $db->RunQuery($strSql);

return $result;

}

function SetProductTransferStatus($prmStyleCode){
	
	global $db;
	
	$strSql = " UPDATE fr_producttransferlist SET booTransfered = 1 WHERE intStyleId = ".$prmStyleCode;
	
	$db->ExecuteQuery($strSql);
}

function IsEmbelishmentExist($varValue){
    
    $_isEmbExist = 0;
    //echo $varValue;
    if(($varValue != 0)){
        $_isEmbExist = 1; 
    }
    
    return  $_isEmbExist;
    
}

function GetEmbelishmentList($prmIsCPL, $prmIsPreSew, $prmIsPrint, $prmIsEMB, $prmIsBNP, $prmIsHTP, $prmIsSA, $prmIsDA, 
                           $prmIsSmoking, $prmIsOther, $prmIsPleating, $prmIsWash, $prmIsGDye, $prmIsPressing, $prmIsPC){
    
    $_strEmbNameList = '';
    
    if($prmIsCPL == 1){     $_strEmbNameList .= "CPL/";   }
    if($prmIsPreSew == 1){  $_strEmbNameList .= "PreSew/";}
    if($prmIsPrint == 1){   $_strEmbNameList .= "Print/"; }
    if($prmIsEMB == 1){     $_strEmbNameList .= "Embroidery/"; }
    if($prmIsBNP == 1){     $_strEmbNameList .= "Back Neck Printing/"; }
    if($prmIsHTP == 1){     $_strEmbNameList .= "Heat Transfer Printing/"; }
    if($prmIsSA == 1){     $_strEmbNameList .= "Sequins Attach/"; }
    if($prmIsDA == 1){     $_strEmbNameList .= "Diamonds Attach/"; }
    if($prmIsSmoking == 1){     $_strEmbNameList .= "Smoking/"; }
    if($prmIsOther == 1){     $_strEmbNameList .= "Other/"; }
    if($prmIsPleating == 1){     $_strEmbNameList .= "Pleating/"; }
    if($prmIsWash == 1){     $_strEmbNameList .= "Washing/"; }
    if($prmIsGDye == 1){     $_strEmbNameList .= "Garment Dye/"; }
    if($prmIsPressing == 1){     $_strEmbNameList .= "Pressing/"; }
    if($prmIsPC == 1){     $_strEmbNameList .= "Permanant Creasing/"; }
    
    
    
    return $_strEmbNameList;
    
    
}


?>