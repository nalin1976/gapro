<?php

include "../Connector.php";
include "../navtransfer/msssqlconnect.php";

$connectNavision = new ClassConnectMSSQL();

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$queryRequest = $_GET["reqid"];

if($queryRequest == "NotTransfer"){

	$ResponseXML = "";

	$ResponseXML = "<ORDERSLIST>";

	$sql = " SELECT specification.intSRNO, orders.strStyle, specification.intStyleId
             FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId
             WHERE orders.intStatus =  '11' AND specification.intStyleId NOT IN(SELECT styleId  FROM nav_budjetSC)
             ORDER BY specification.intSRNO ";

    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
    	 $ResponseXML .= "<SCNO><![CDATA[" . $row["intSRNO"]  . "]]></SCNO>\n";
    	 $ResponseXML .= "<STYLE_CODE><![CDATA[" . $row["strStyle"]  . "]]></STYLE_CODE>\n";
    	 $ResponseXML .= "<STYLEID><![CDATA[" . $row["intStyleId"]  . "]]></STYLEID>\n";
    }         

    $ResponseXML .= "</ORDERSLIST>";

    echo $ResponseXML;
}    

if($queryRequest == "OrderDetails"){

	$orderCode = $_GET["ordercode"];

	$ResponseXML = "";

	$ResponseXML = "<ORDERDETAILS>";

	$sql = " SELECT specification.intSRNO, matsubcategory.StrCatCode, orders.dtmDate, orderdetails.intMatDetailID, 
	                matitemlist.strItemDescription, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc,
                    orderdetails.reaWastage, orders.intQty, orderdetails.dblTotalQty, orderdetails.dblTotalValue
             FROM   specification Inner Join specificationdetails ON specification.intStyleId = specificationdetails.intStyleId
                    Inner Join orders ON specificationdetails.intStyleId = orders.intStyleId Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId AND specificationdetails.strMatDetailID = orderdetails.intMatDetailID
                    Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial Inner Join matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo
             WHERE  ((orderdetails.intstatus =  '1') OR (orderdetails.intstatus IS NULL)) AND specification.intStyleId =  '$orderCode'";

    $resOrderDetails = $db->RunQuery($sql);
    
    while($rowOrderDetails = mysql_fetch_array($resOrderDetails)){

    	$ResponseXML .= "<SCNO><![CDATA[" . $rowOrderDetails["intSRNO"]  . "]]></SCNO>\n";
    	$ResponseXML .= "<TASK_CODE><![CDATA[" . $rowOrderDetails["StrCatCode"]  . "]]></TASK_CODE>\n";
    	$ResponseXML .= "<O_DATE><![CDATA[" . $rowOrderDetails["dtmDate"]  . "]]></O_DATE>\n";
    	$ResponseXML .= "<ITEM_ID><![CDATA[" . $rowOrderDetails["intMatDetailID"]  . "]]></ITEM_ID>\n";
    	$ResponseXML .= "<ITEM_DESC><![CDATA[" . $rowOrderDetails["strItemDescription"]  . "]]></ITEM_DESC>\n";
    	$ResponseXML .= "<ITEM_UNIT><![CDATA[" . $rowOrderDetails["strUnit"]  . "]]></ITEM_UNIT>\n";
    	$ResponseXML .= "<ITEM_TOT_VALUE><![CDATA[" . $rowOrderDetails["dblTotalValue"]  . "]]></ITEM_TOT_VALUE>\n";
    	$ResponseXML .= "<ITEM_TOT_QTY><![CDATA[" . $rowOrderDetails["dblTotalQty"]  . "]]></ITEM_TOT_QTY>\n";
    	$ResponseXML .= "<ITEM_PRICE><![CDATA[" . $rowOrderDetails["dblUnitPrice"]  . "]]></ITEM_PRICE>\n";

    }        

    $ResponseXML .= "</ORDERDETAILS>";

    echo $ResponseXML;

}

if($queryRequest == "IsInNavision"){

	$jobNo 		= $_GET["jobNo"];
	$taskCode 	= $_GET["taskcode"];
	$itemCode	= $_GET["itemcode"];

	$ResponseXML = "";

	$ResponseXML = "<ORDER_EXIST>";

	$sql = ' SELECT JOBNo, TaskNo, ItemNo 
             FROM   [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning]
             WHERE        (JOBNo = '."'".$jobNo."'".') AND (TaskNo = '."'".$taskCode."'".') AND (ItemNo = '."'".$itemCode."'".')';

    $resItemExist = $connectNavision->ExecuteQuery($sql);
    //echo sqlsrv_num_rows($resItemExist);
    //echo $resItemExist;
    //if(sqlsrv_has_rows($resItemExist))
    if(mssql_num_rows($resItemExist) > 0)
    	$ResponseXML .= "<LINE_EXIST><![CDATA[1]]></LINE_EXIST>\n";
    else
    	$ResponseXML .= "<LINE_EXIST><![CDATA[0]]></LINE_EXIST>\n";    

    $ResponseXML .= "</ORDER_EXIST>";

    echo $ResponseXML;

   
}

if($queryRequest == "GetMaxNo"){

	$ResponseXML = "";

	$ResponseXML = "<MAX_LINE>";

	$sql = 'SELECT MAX(BLineNo) AS TRLineNo FROM [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning]';

	$resMaxNo = $connectNavision->ExecuteQuery($sql);

	//$arrRes = mssql_fetch_row[$resMaxNo];
	//while($row=sqlsrv_fetch_array($resMaxNo)){
    while($row=mssql_fetch_array($resMaxNo)){

		$ResponseXML .= "<LINE_NO><![CDATA[" . $row["TRLineNo"]  . "]]></LINE_NO>\n";
        

	}

	$ResponseXML .= "</MAX_LINE>";
    echo  $ResponseXML;

}

if($queryRequest == "SaveLines"){

	$jobNo  	= $_GET["jobno"];
	$taskCode 	= $_GET["taskcode"];
	$LineNo 	= $_GET["lineno"];
	$CostDate	= $_GET["costdate"];
	$ItemCode   = $_GET["itemcode"];
	$ItemDesc   = $_GET["itemdesc"];
	$UOM 		= $_GET["uom"];
	$unitPrice  = $_GET["itemprice"];
	$ItemValue  = $_GET["itemvalue"];
	$SCNO 		= $_GET["scno"];
	$ItemQty 	= $_GET["itemqty"];
    $LocationCode = $_GET["loccode"];
    $GenProd    = $_GET["genprod"];
    $type       = $_GET["type"];
    $lineType   = $_GET["linetype"];
    $status     = $_GET["status"];
    $quom       = $_GET["quom"];
    $contLine   = $_GET["conline"];
    $scheduleLine = $_GET["scheline"];
    $exRate     = $_GET["exrate"];
    $DocNo      = $_GET["docno"];



	$sql = 'INSERT INTO [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning](JOBNo,TaskNo, BLineNo, CostedDate, DocNo, Type, ItemNo, Description, UOM, LocationCode, GenProd, DocDate, LineAmountLKR, UnitCost, TotCost, UnitPrice, TotalPrice, LineAmountLKR2, [Line Type], Status, QUOM, ContractLine, ScheduleLine, QTY, AmountUSD, ExRate, SCNo, F_Remove, B_Transfered, [Not Transfered])
	       VALUES ('."'".$jobNo."','".$taskCode."',".$LineNo.",'".$CostDate."','".$DocNo."','".$type."','".$ItemCode."','".$ItemDesc."','".$UOM."','".$LocationCode."','".$GenProd."','".$CostDate."',".$ItemValue.",".$unitPrice.",".$ItemValue.",".$unitPrice.",".$ItemValue.",".$ItemValue.",".$lineType.",".$status.",".$quom .",'".$contLine."','".$scheduleLine."',".$ItemQty.",".$ItemValue.",".$exRate.",'".$SCNO."',0,'N','N')";

	$resSave = $connectNavision->ExecuteQuery($sql);    




	$ResponseXML = "";

	$ResponseXML = "<SAVE_LINE>";
	if(!$resSave){
		$ResponseXML .= "<RES><![CDATA[0]]></RES>\n";
		$ResponseXML .= "<QYE><![CDATA[".$sql."]]></QYE>\n";
	}else{
		$ResponseXML .= "<RES><![CDATA[1]]></RES>\n";
		$ResponseXML .= "<QYE><![CDATA[N/A]]></QYE>\n";
	}
	
	$ResponseXML .= "</SAVE_LINE>";

	echo $ResponseXML;

}


if($queryRequest == "OrderHeader"){

	$orderCode = $_GET["ordercode"];

	$ResponseXML = "";

	$ResponseXML = "<ORDER_HEADER>";

	$sql = " SELECT specification.intSRNO, orders.intQty, orders.reaSMV, orders.reaEfficiencyLevel, orders.intSubContractQty,
                    orders.dtmDate, orders.dblFacOHCostMin
             FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId
             WHERE orders.intStyleId = '$orderCode'";

    $resOrderHeader = $db->RunQuery($sql);

    while($rowOrderHeader = mysql_fetch_array($resOrderHeader)){

    	$ResponseXML .= "<SCNO><![CDATA[" . $rowOrderHeader["intSRNO"]  . "]]></SCNO>\n";
    	$ResponseXML .= "<ORDER_QTY><![CDATA[" . $rowOrderHeader["intQty"]  . "]]></ORDER_QTY>\n";
    	$ResponseXML .= "<EFF><![CDATA[" . $rowOrderHeader["reaEfficiencyLevel"]  . "]]></EFF>\n";
    	$ResponseXML .= "<SUB_QTY><![CDATA[" . $rowOrderHeader["intSubContractQty"]  . "]]></SUB_QTY>\n";
    	$ResponseXML .= "<O_DATE><![CDATA[" . $rowOrderHeader["dtmDate"]  . "]]></O_DATE>\n";
    	$ResponseXML .= "<FAC_OH><![CDATA[" . $rowOrderHeader["dblFacOHCostMin"]  . "]]></FAC_OH>\n";
    	$ResponseXML .= "<SMV><![CDATA[" . $rowOrderHeader["reaSMV"]  . "]]></SMV>\n";
    	

    }        

    $ResponseXML .= "</ORDER_HEADER>";

    echo $ResponseXML;

}

if($queryRequest == "LabourExist"){

    $JobNo = $_GET["jobno"];

    $ResponseXML = "";

    $ResponseXML = "<LABOUR_EXIST>";

    $sql = ' SELECT * 
             FROM  [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning]
             WHERE   (JOBNo = '."'".$JobNo."'".') AND (TaskNo = '."'14'".') AND (ItemNo = '."'E001'".')';


    $resBugjetExist = $connectNavision->ExecuteQuery($sql);         

    //if(sqlsrv_has_rows($resBugjetExist))
    if(mssql_num_rows($resBugjetExist))
        $ResponseXML .= "<L_EXIST><![CDATA[1]]></L_EXIST>\n";
    else
        $ResponseXML .= "<L_EXIST><![CDATA[0]]></L_EXIST>\n";    

    $ResponseXML .= "</LABOUR_EXIST>";

    echo $ResponseXML; 
}

if($queryRequest == "GetFinance"){

    $orderCode = $_GET["ordercode"];

    $ResponseXML = "";

    $ResponseXML = "<FIN_INFO>";


    $sql = " SELECT specification.intSRNO, orders.intQty, orders.dtmDate, (orders.reaFinance + orders.reaECSCharge) as TOT_FIN
             FROM orders Inner Join specification ON orders.intStyleId = specification.intStyleId
             WHERE orders.intStyleId =  '$orderCode'";

    $resFinCost = $db->RunQuery($sql);

    while($rowFinCost = mysql_fetch_array($resFinCost)){
    
        $ResponseXML .= "<SCNO><![CDATA[" . $rowFinCost["intSRNO"]  . "]]></SCNO>\n";
        $ResponseXML .= "<ORDER_QTY><![CDATA[" . $rowFinCost["intQty"]  . "]]></ORDER_QTY>\n";
        $ResponseXML .= "<O_DATE><![CDATA[" . $rowFinCost["dtmDate"]  . "]]></O_DATE>\n";
        $ResponseXML .= "<FIN><![CDATA[" . $rowFinCost["TOT_FIN"]  . "]]></FIN>\n";
    }  

    $ResponseXML .= "</FIN_INFO>";

    echo $ResponseXML;       

}

if($queryRequest == "FinanceExist"){

    $JobNo = $_GET["jobno"];

    $ResponseXML = "";

    $ResponseXML = "<FINANCE_EXIST>";

    $sql = ' SELECT * 
             FROM  [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning]
             WHERE   (JOBNo = '."'".$JobNo."'".') AND (TaskNo = '."'506'".') AND (ItemNo = '."'F001'".')';


    $resBugjetExist = $connectNavision->ExecuteQuery($sql);         

    //if(sqlsrv_has_rows($resBugjetExist))
    if(mssql_num_rows($resBugjetExist))
        $ResponseXML .= "<F_EXIST><![CDATA[1]]></F_EXIST>\n";
    else
        $ResponseXML .= "<F_EXIST><![CDATA[0]]></F_EXIST>\n";    

    $ResponseXML .= "</FINANCE_EXIST>";

    echo $ResponseXML; 
}

if($queryRequest == "AddTransfer"){

    $orderCode = $_GET["ordercode"];

    $sql = "INSERT INTO nav_budjetSC(styleId) VALUES('$orderCode')";

    $restransfer = $db->RunQuery($sql);

}



?>