<?php
session_start();
//include "../Connector.php";
include "../autoconnect.php";

$iMaxDeliveries = 0;

// ==================================================================================
# Transfering orders which are not in the 'fr_ordertransfer' table
// ==================================================================================
/*
$sql = " SELECT orders.intStyleId, orders.strStyle, specification.intSRNO
         FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId
         WHERE intStatus = 11 AND orders.intStyleId NOT IN ( SELECT intStyleId FROM fr_orderstransfer  )
         ORDER BY intSRNO ";

$result = $db->RunQuery($sql);

while($row = mysql_fetch_array($result)){
    
    $iStyleCode = $row["intStyleId"];
    $sStyleId   = $row["strStyle"];
    
    $_strStylePrefix = "";
    
    $iBracketPos = strpos($sStyleId, "(");
    
    if($iBracketPos > 0){
       $_strStylePrefix = substr($sStyleId,0,$iBracketPos); 
    }else{
        $_strStylePrefix = $sStyleId;
    }
    
    
    
    
    //echo $_strStylePrefix."<br />";
    
    $sqlAddStyle = " INSERT INTO fr_orderstransfer(intStyleId, booTransfer, strStylePrefix) VALUES($iStyleCode,0, '$_strStylePrefix')";
    $db->ExecuteQuery($sqlAddStyle);
    //echo $row["strStyle"]."-".$row["intSRNO"]."<br />";
    
} */
// ==================================================================================


# Get max deliveries count from which not transfer to FR
# ==================================================================================

/*    $sqlMaxDeliveries = " SELECT MAX(StyleCount) AS MaxDeliveries 
                          FROM 
                               (SELECT Count(deliveryschedule.intStyleId) AS StyleCount, deliveryschedule.intStyleId
                                FROM deliveryschedule INNER JOIN fr_orderstransfer ON deliveryschedule.intStyleId = fr_orderstransfer.intStyleId
                                WHERE
                                fr_orderstransfer.booTransfer = 0
                                GROUP BY deliveryschedule.intStyleId
                                ORDER BY 
                                Count(deliveryschedule.intStyleId) DESC) AS A ";
    
    $rsDeliveries = $db->RunQuery($sqlMaxDeliveries);
    $arrMaxDeliveries = mysql_fetch_row($rsDeliveries);
    
    # assign max delivery count to variable
    $iMaxDeliveries = $arrMaxDeliveries[0];      */    


# ==================================================================================
    
# Create PRODUCT.CSV file
# ==============================================================================

$fProduct ="PRODUCTS.CSV";

$_arrHeader = array("P.CODE","P.TYPE","P.DESCRIP","P.CUST","P^WC:10","P^WC:100","P^WC:105","P^WC:110","P^WC:120","P^WC:140","P^WC:145","P^WC:160","P^WC:170","P^WC:180","P^WC:185","P^WC:190","P^WC:195","P^WC:200","P^WC:220","P^WC:225","P^WC:230","P^WC:231","P^WC:240","P^WC:250", "P.UDCosted Effi.","P.UDCosted SMV","P.UdEmb Type","P.UdHela Prod Code", "END");

$output = fopen('php://memory', "w");

$_arrProductForCSV[0] = $_arrHeader;	
$iArrayPossition = 1;


$rsProductList = GetProductsNeedToTransfer();

while($rowProductList = mysql_fetch_array($rsProductList)){
    
    $_styleCode = $rowProductList[0];
    
    $rsProductDetails = GetProductDetails($_styleCode);
    
    $_intStylePartRowCount =  mysql_num_rows($rsProductDetails);
         
    //echo $_intStylePartRowCount."<br />";
    
    if($_intStylePartRowCount>1){		  	  
  	
	 while($row = mysql_fetch_array($rsProductDetails)){	
             
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
	  
	   while($row = mysql_fetch_array($rsProductDetails)){
               
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
//readfile($fProduct);

fpassthru($output);

    


        


function GetProductsNeedToTransfer(){
    
    global $db;
    
    /*$sqlProductTrList = " SELECT orders.intStyleId, specification.intSRNO
                          FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                               INNER JOIN stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
                               INNER JOIN fr_producttransferlist ON stylepartdetails.intStyleId = fr_producttransferlist.intStyleId
                          WHERE fr_producttransferlist.booTransfered =  '0'";*/
    
    /* $sqlProductTrList = " SELECT orders.intStyleId, specification.intSRNO 
                          FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                               INNER JOIN fr_producttransferlist ON orders.intStyleId = fr_producttransferlist.intStyleId
                          WHERE fr_producttransferlist.booTransfered =  '0' 
                          ORDER BY specification.intSRNO ASC "; */
    
    $sqlProductTrList = " SELECT orders.intStyleId, specification.intSRNO
                          FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                          WHERE specification.intSRNO >= '18000' 
                          ORDER BY specification.intSRNO ASC ";

    
    $_rsProductList = $db->RunQuery($sqlProductTrList);
    
    return $_rsProductList;
    
}

function GetProductDetails($prmStyleCode){
    
    global $db;
    
    $sqlProduct = " SELECT specification.intSRNO, orders.strStyle, orders.strDescription, orders.intQty,
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
                    WHERE fr_producttransferlist.booTransfered =  '0' AND  orders.intStyleId = ".$prmStyleCode;
    
    $_rsProductDetails = $db->RunQuery($sqlProduct);
    
    return $_rsProductDetails;
    
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
        
function IsEmbelishmentExist($varValue){
    
    $_isEmbExist = 0;
    //echo $varValue;
    if(($varValue != 0)){
        $_isEmbExist = 1; 
    }
    
    return  $_isEmbExist;
    
}

?>
