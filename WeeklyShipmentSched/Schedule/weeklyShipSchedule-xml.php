<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];


if($id=="loadWeekly")
{
 $StyleNo = $_GET["StyleNo"];
 $OrderNo = $_GET["OrderNo"];
 $cboBuyer = $_GET["cboBuyer"];
 $WeeklySchedNo = $_GET["WeeklySchedNo"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadMonShipSched>";
		
				$SQL_Dest = "SELECT intDestID,strDestName FROM destination order by strDestName";
                $str = ''; 		
              		$result_Dest= $db->RunQuery($SQL_Dest);
 					$str .= "<option></option>";	
              		while($row_Dest = mysql_fetch_array($result_Dest))
						{
						 $intDestID = $row_Dest["intDestID"];
						 $str .= "<option  value=\"$intDestID\">" . $row_Dest["strDestName"] ."</option>";						 
						}
		
$SQL = "SELECT DISTINCT
DATE(monthlyshipmentschedule.dtmDate) AS dtmDate,
monthlyshipmentschedule.dblDeliveryQty,
orders.strDescription,
buyers.strName AS buyername,
monthlyshipmentschedule.dblShipNowQuantitySea AS monQtySea,
monthlyshipmentschedule.dblShipNowQuantityAir AS monQtyAir,
(monthlyshipmentschedule.dblShipNowQuantitySea + monthlyshipmentschedule.dblShipNowQuantityAir)AS TotMonthlyQty,
monthlyshipmentschedule.intSerial,
monthlyshipmentschedule.strWeek,
orders.intQty,
orders.intStyleId,
orders.strOrderNo,
orders.strStyle,
buyers.intBuyerID,
orderdata.intStyleID,
orderdata.strWearhouse,
orderdata.strDimention,
orderdata.intShipMode,
orderdata.strVessal,
DATE(orderdata.dtVessalDate)AS dtVessalDate,
orderdata.dblPcsPerPack,
orderdata.strItemID,
orderdata.strWashCode,
orderdata.intDestination,
orderdata.intPayTerm,
orderdata.intShipTerm,
orderdata.strGrmtType,
orderdata.strQuataCat,
orderdata.strGender,
orderdata.strCTNSize,
orderdata.strCTNType,
orderdata.strPONo,
orderdata.isBottom,
orderdata.strName,
orderdata.strDescription,
orderdata.strItemDescription,
orderdata.intBuyerID,
orderdata.strFabricRefNo,
orderdata.strSupplierID,
shipmentmode.strDescription AS shipmentmodeDes,
popaymentterms.strDescription,
shipmentterms.strShipmentTerm,
suppliers.strTitle,
monthlyshipmentschedule.intScheduleNo,
monthlyshipmentschedule.strSchedNo,
monthlyshipmentschedule.intYear,
monthlyshipmentschedule.intMonth,
monthlyshipmentschedule.strSchedDate
FROM
monthlyshipmentschedule
left Join buyers ON monthlyshipmentschedule.intBuyerId = buyers.intBuyerID
left Join orders ON monthlyshipmentschedule.intStyleId = orders.intStyleId
left Join orderdata ON orders.intStyleId = orderdata.intStyleID
left Join shipmentmode ON orderdata.intShipMode = shipmentmode.intShipmentModeId
left Join popaymentterms ON orderdata.intPayTerm = popaymentterms.strPayTermId
left Join shipmentterms ON orderdata.intShipTerm = shipmentterms.strShipmentTermId
left Join suppliers ON orderdata.strSupplierID = suppliers.strSupplierID
		WHERE monthlyshipmentschedule.strSchedNo='$WeeklySchedNo'";


		if($StyleNo !="" && $OrderNo=="" && $cboBuyer==""){
		$SQL.= " AND monthlyshipmentschedule.intStyleId='$StyleNo'";
		}
		if($OrderNo!="" && $StyleNo =="" && $cboBuyer==""){
		$SQL.= " AND monthlyshipmentschedule.intStyleId='$OrderNo'";
		}
		if($cboBuyer!="" && $StyleNo =="" && $OrderNo==""){
		$SQL.= " AND monthlyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if($StyleNo!="" && $OrderNo!="" && $cboBuyer==""){
		$SQL.= " AND  monthlyshipmentschedule.intStyleId='$StyleNo'
		         AND monthlyshipmentschedule.intStyleId='$OrderNo'";
		}
		if($StyleNo!=""  && $cboBuyer!="" && $OrderNo==""){
		$SQL.= " AND  monthlyshipmentschedule.intStyleId='$StyleNo'
		         AND monthlyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if( $OrderNo!="" && $cboBuyer!="" && $StyleNo==""){
		$SQL.= " AND  monthlyshipmentschedule.intStyleId='$OrderNo'
		         AND monthlyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if($StyleNo!="" && $OrderNo!="" && $cboBuyer!=""){
		$SQL.= " AND  monthlyshipmentschedule.intStyleId='$StyleNo'
		         AND monthlyshipmentschedule.intStyleId='$OrderNo'  AND monthlyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		$SQL.= " ORDER BY
                 monthlyshipmentschedule.strWeek ASC";
		
		$result = $db->RunQuery($SQL);
		///echo $SQL;

			while($row = mysql_fetch_array($result))
			{
			
			$dtmDate= $row['dtmDate'];  
			//echo $dtmDate;
			$intStyleId= $row["intStyleId"];
			$strSchedDate= $row["strSchedDate"];  
			$TotMonthlyQty= $row["TotMonthlyQty"];
			$strWeekMon= $row["strWeek"];
	
			$SQL2="SELECT 
			 SUM(dblShipNowQuantityAir+dblShipNowQuantitySea)AS TotWeeklyQty,dblShipNowQuantityAir,dblShipNowQuantitySea,strWeek as strWeekWeekly,strRemarks
			 FROM weeklyshipmentschedule 
			 WHERE deliveryDate='$dtmDate' AND intStyleId='$intStyleId' AND intScheduleNo='$WeeklySchedNo' AND etdDate='$strSchedDate'";
		//echo $SQL2;
			$result2 = $db->RunQuery($SQL2);
			
			while($row2 = mysql_fetch_array($result2))
			{
			$dblShipNowQuantityAir= $row2["dblShipNowQuantityAir"];
			$dblShipNowQuantitySea= $row2["dblShipNowQuantitySea"];
			$TotWeeklyQty= $row2["TotWeeklyQty"];
			$strWeekWeekly= $row2["strWeekWeekly"];
			$strRemarks= $row2["strRemarks"];
			 $week = $strWeekWeekly; 
			if($week == ""){
			 $week = $strWeekMon;
			}
			$balqty = $TotMonthlyQty - $TotWeeklyQty;
			}

			//if($TotMonthlyQty > $TotWeeklyQty){
			//echo $SQL2;
			
    		$ResponseXML .= "<deldate><![CDATA[".trim($row["dtmDate"])  . "]]></deldate>\n";	
		    $ResponseXML .= "<orderno><![CDATA[".trim($row["strOrderNo"])  . "]]></orderno>\n";
			$ResponseXML .= "<intStyleId><![CDATA[".trim($row["intStyleId"])  . "]]></intStyleId>\n";
			$ResponseXML .= "<strStyle><![CDATA[".trim($row["strStyle"])  . "]]></strStyle>\n";
			$ResponseXML .= "<orderqty><![CDATA[".trim($row["intQty"])  . "]]></orderqty>\n";
			$ResponseXML .= "<delqty><![CDATA[".trim($row["dblDeliveryQty"])  . "]]></delqty>\n";
			$ResponseXML .= "<description><![CDATA[".trim($row["strDescription"])."]]></description>\n";
			$ResponseXML .= "<unitprice><![CDATA[".number_format(trim($row["dblUnitPrice"]),2)."]]></unitprice>\n";	
			$ResponseXML .= "<merchandiser><![CDATA[".trim($row["name"])."]]></merchandiser>\n";
			$ResponseXML .= "<buyer><![CDATA[".trim($row["buyername"])."]]></buyer>\n";
			$ResponseXML .= "<intBuyerID><![CDATA[".trim($row["intBuyerId"])."]]></intBuyerID>\n";
			$ResponseXML .= "<scheduledate><![CDATA[".trim($row["strSchedDate"])."]]></scheduledate>\n";
			$ResponseXML .= "<dblPcsPerPack><![CDATA[".trim($row["dblPcsPerPack"])."]]></dblPcsPerPack>\n";
			$ResponseXML .= "<shipmode><![CDATA[".trim($row["shipmentmodeDes"])."]]></shipmode>\n";
			$ResponseXML .= "<intShipmentModeId><![CDATA[".trim($row["intShipMode"])."]]></intShipmentModeId>\n";
			$ResponseXML .= "<strVessal><![CDATA[".trim($row["strVessal"])."]]></strVessal>\n";
			$ResponseXML .= "<dtVessalDate><![CDATA[".trim($row["dtVessalDate"])."]]></dtVessalDate>\n";
			$ResponseXML .= "<strWearhouse><![CDATA[".trim($row["strWarehouse"])."]]></strWearhouse>\n";
			$ResponseXML .= "<strDimention><![CDATA[".trim($row["strDimention"])."]]></strDimention>\n";
			$ResponseXML .= "<comnam><![CDATA[".trim($row["strCompany"])."]]></comnam>\n";
			$ResponseXML .= "<strColor><![CDATA[".trim($row["strColour"])."]]></strColor>\n";
            $ResponseXML .= "<monQtySea><![CDATA[".trim($row["monQtySea"])."]]></monQtySea>\n";
			$ResponseXML .= "<monQtyAir><![CDATA[".trim($row["monQtyAir"])."]]></monQtyAir>\n";
			$ResponseXML .= "<dblLength><![CDATA[".trim($row["dblLength"])."]]></dblLength>\n";
			$ResponseXML .= "<dblHight><![CDATA[".trim($row["dblHeight"])."]]></dblHight>\n";
			$ResponseXML .= "<dblWidth><![CDATA[".trim($row["dblWidth"])."]]></dblWidth>\n";
			$ResponseXML .= "<CBM><![CDATA[".trim($row["dblCBM"])."]]></CBM>\n";
			$ResponseXML .= "<dbllblcomposition><![CDATA[".trim($row["dbllblcomposition"])."]]></dbllblcomposition>\n";	
			$ResponseXML .= "<intSerial><![CDATA[".trim($row["intSerial"])."]]></intSerial>\n";	
			$ResponseXML .= "<strWashCode><![CDATA[".trim($row["strWashCode"])."]]></strWashCode>\n";	
			$ResponseXML .= "<strSchedDate><![CDATA[".trim($row["strSchedDate"])."]]></strSchedDate>\n";
			$ResponseXML .= "<balqty><![CDATA[".trim($balqty)."]]></balqty>\n";	
			//$ResponseXML .= "<strWeek><![CDATA[".trim($row["strWeek"])."]]></strWeek>\n";
			$ResponseXML .= "<strWeek><![CDATA[".$week."]]></strWeek>\n";
			$ResponseXML .= "<dblShipNowQuantityAir><![CDATA[".$dblShipNowQuantityAir."]]></dblShipNowQuantityAir>\n";
			$ResponseXML .= "<dblShipNowQuantitySea><![CDATA[".$dblShipNowQuantitySea."]]></dblShipNowQuantitySea>\n";
			$ResponseXML .= "<dest><![CDATA[".$str."]]></dest>\n";	
			$ResponseXML .= "<strRemarks><![CDATA[".$strRemarks."]]></strRemarks>\n";	
			 //}		
			}
			$ResponseXML .= "</loadMonShipSched>";
			
		echo $ResponseXML;
}

//-------------------------------------------MODIFY----------------------------------------------------------------------------

if($id=="loadWeeklyModify")
{
 $StyleNo = $_GET["StyleNo"];
 $OrderNo = $_GET["OrderNo"];
 $cboBuyer = $_GET["cboBuyer"];
 $WeeklySchedNo = $_GET["WeeklySchedNo"];

		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadMonShipSched>";
		
$SQL = "SELECT  distinct weeklyshipmentschedule.intSerial,
        weeklyshipmentschedule.strWeek,
        DATE(weeklyshipmentschedule.deliveryDate)AS deliveryDate,     
		weeklyshipmentschedule.intStyleId,        
		weeklyshipmentschedule.dblOrderQty,       
		weeklyshipmentschedule.dblDeliveryQty,    
		weeklyshipmentschedule.dblActualQty,      
		weeklyshipmentschedule.dblExportQty,      
		weeklyshipmentschedule.dblMonQtySea,
		weeklyshipmentschedule.dblMonQtyAir,         
		weeklyshipmentschedule.dblBalanceQty,     
		weeklyshipmentschedule.dblShipNowQuantitySea as weeklyShipNowQtySea,
		weeklyshipmentschedule.dblShipNowQuantityAir as weeklyShipNowQtyAir,
		(weeklyshipmentschedule.dblShipNowQuantitySea + weeklyshipmentschedule.dblShipNowQuantityAir) AS TotWeeklyQty,
		weeklyshipmentschedule.strCtn,            
		weeklyshipmentschedule.strColour,                                                                                 
		weeklyshipmentschedule.strRemarks,        
		weeklyshipmentschedule.strPerPackCode,    
		weeklyshipmentschedule.strWashCode,       
		weeklyshipmentschedule.ISDNo,             
		weeklyshipmentschedule.strDONo,           
		weeklyshipmentschedule.strDCNo,           
		weeklyshipmentschedule.dblLength,         
		weeklyshipmentschedule.dblWidth,          
		weeklyshipmentschedule.dblHeight,         
		weeklyshipmentschedule.dblPcsPerPack,     
		weeklyshipmentschedule.dblCBM,            
		weeklyshipmentschedule.strLabelCompo,     
		weeklyshipmentschedule.strWarehouse,      
		weeklyshipmentschedule.dblDimension,      
		weeklyshipmentschedule.intMode,           
		weeklyshipmentschedule.strvessel,         
		weeklyshipmentschedule.dtmVesddt,         
		weeklyshipmentschedule.strSchedDate,      
		weeklyshipmentschedule.strItemID,         
		weeklyshipmentschedule.dblExeRate,        
		weeklyshipmentschedule.strCtnGroupNo,  
		weeklyshipmentschedule.etdDate, 
		weeklyshipmentschedule.strWashCode,   
		orders.intStyleId,
		orders.strOrderNo,
		orders.strStyle,
		shipmentmode.intShipmentModeId,
        shipmentmode.strDescription AS shipmode

		FROM weeklyshipmentschedule 
		LEFT JOIN orders ON weeklyshipmentschedule.intStyleId = orders.intStyleId
		LEFT Join monthlyshipmentschedule ON monthlyshipmentschedule.strSchedNo = weeklyshipmentschedule.intScheduleNo AND monthlyshipmentschedule.intStyleId = weeklyshipmentschedule.intStyleId AND monthlyshipmentschedule.dtmDate = weeklyshipmentschedule.deliveryDate
		LEFT Join shipmentmode ON weeklyshipmentschedule.intMode = shipmentmode.intShipmentModeId
		WHERE weeklyshipmentschedule.intScheduleNo='$WeeklySchedNo'";


		if($StyleNo !="" && $OrderNo=="" && $cboBuyer==""){
		$SQL.= " AND weeklyshipmentschedule.intStyleId='$StyleNo'";
		}
		if($OrderNo!="" && $StyleNo =="" && $cboBuyer==""){
		$SQL.= " AND weeklyshipmentschedule.intStyleId='$OrderNo'";
		}
		if($cboBuyer!="" && $StyleNo =="" && $OrderNo==""){
		$SQL.= " AND weeklyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if($StyleNo!="" && $OrderNo!="" && $cboBuyer==""){
		$SQL.= " AND  weeklyshipmentschedule.intStyleId='$StyleNo'
		         AND weeklyshipmentschedule.intStyleId='$OrderNo'";
		}
		if($StyleNo!=""  && $cboBuyer!="" && $OrderNo==""){
		$SQL.= " AND  weeklyshipmentschedule.intStyleId='$StyleNo'
		         AND weeklyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if( $OrderNo!="" && $cboBuyer!="" && $StyleNo==""){
		$SQL.= " AND  weeklyshipmentschedule.intStyleId='$OrderNo'
		         AND weeklyshipmentschedule.intBuyerId='$cboBuyer'";
		}
		if($StyleNo!="" && $OrderNo!="" && $cboBuyer!=""){
		$SQL.= " AND  weeklyshipmentschedule.intStyleId='$StyleNo'
		         AND weeklyshipmentschedule.intStyleId='$OrderNo'  AND weeklyshipmentschedule.intBuyerId='$cboBuyer'";
		}

		
		$result = $db->RunQuery($SQL);
		//echo $SQL;

			while($row = mysql_fetch_array($result))
			{
			$etdDate = $row["etdDate"];
			$strOrderNo = $row["strOrderNo"];
			$deliveryDate = $row["deliveryDate"];
			$TotWeeklyQty = $row["TotWeeklyQty"];
			$SQL1 = "SELECT (dblShipNowQuantitySea + dblShipNowQuantityAir)AS TotMonQty FROM monthlyshipmentschedule WHERE strSchedDate='$etdDate' AND 
			         strOrderNo='$strOrderNo' AND dtmDate='$deliveryDate' AND  strSchedNo='$WeeklySchedNo'";
		    $result1 = $db->RunQuery($SQL1);
			while($row1 = mysql_fetch_array($result1))
			{
			 $TotMonQty = $row1["TotMonQty"];
			}
            $balance = $TotMonQty - $TotWeeklyQty;
					 //echo $SQL1;
			$ResponseXML .= "<strWeek><![CDATA[".trim($row["strWeek"])  . "]]></strWeek>\n";	
			$ResponseXML .= "<etdDate><![CDATA[".trim($row["etdDate"])  . "]]></etdDate>\n";
    		$ResponseXML .= "<deldate><![CDATA[".trim($row["deliveryDate"])  . "]]></deldate>\n";	
		    $ResponseXML .= "<orderno><![CDATA[".trim($row["strOrderNo"])  . "]]></orderno>\n";
			$ResponseXML .= "<intStyleId><![CDATA[".trim($row["intStyleId"])  . "]]></intStyleId>\n";
			$ResponseXML .= "<strStyle><![CDATA[".trim($row["strStyle"])  . "]]></strStyle>\n";
			$ResponseXML .= "<orderqty><![CDATA[".trim($row["dblOrderQty"])  . "]]></orderqty>\n";
			$ResponseXML .= "<delqty><![CDATA[".trim($row["dblDeliveryQty"])  . "]]></delqty>\n";
			$ResponseXML .= "<description><![CDATA[".trim($row["strDescription"])."]]></description>\n";
			$ResponseXML .= "<unitprice><![CDATA[".number_format(trim($row["dblUnitPrice"]),2)."]]></unitprice>\n";	
			$ResponseXML .= "<merchandiser><![CDATA[".trim($row["name"])."]]></merchandiser>\n";
			$ResponseXML .= "<buyer><![CDATA[".trim($row["buyername"])."]]></buyer>\n";
			$ResponseXML .= "<intBuyerID><![CDATA[".trim($row["intBuyerId"])."]]></intBuyerID>\n";
			$ResponseXML .= "<scheduledate><![CDATA[".trim($row["strSchedDate"])."]]></scheduledate>\n";
			$ResponseXML .= "<dblPcsPerPack><![CDATA[".trim($row["dblPcsPerPack"])."]]></dblPcsPerPack>\n";
			$ResponseXML .= "<shipmode><![CDATA[".trim($row["shipmode"])."]]></shipmode>\n";
			$ResponseXML .= "<intShipmentModeId><![CDATA[".trim($row["intShipmentModeId"])."]]></intShipmentModeId>\n";
			$ResponseXML .= "<strVessal><![CDATA[".trim($row["strvessel"])."]]></strVessal>\n";
			$ResponseXML .= "<dtVessalDate><![CDATA[".trim($row["dtmVesddt"])."]]></dtVessalDate>\n";
			$ResponseXML .= "<strWearhouse><![CDATA[".trim($row["strWarehouse"])."]]></strWearhouse>\n";
			$ResponseXML .= "<strDimention><![CDATA[".trim($row["dblDimension"])."]]></strDimention>\n";
			$ResponseXML .= "<comnam><![CDATA[".trim($row["strCompany"])."]]></comnam>\n";
			$ResponseXML .= "<strColor><![CDATA[".trim($row["strColour"])."]]></strColor>\n";
            $ResponseXML .= "<monQtySea><![CDATA[".trim($row["dblMonQtySea"])."]]></monQtySea>\n";
			$ResponseXML .= "<monQtyAir><![CDATA[".trim($row["dblMonQtyAir"])."]]></monQtyAir>\n";
			$ResponseXML .= "<dblLength><![CDATA[".trim($row["dblLength"])."]]></dblLength>\n";
			$ResponseXML .= "<dblHight><![CDATA[".trim($row["dblHeight"])."]]></dblHight>\n";
			$ResponseXML .= "<dblWidth><![CDATA[".trim($row["dblWidth"])."]]></dblWidth>\n";
			$ResponseXML .= "<CBM><![CDATA[".trim($row["dblCBM"])."]]></CBM>\n";
			$ResponseXML .= "<dbllblcomposition><![CDATA[".trim($row["dbllblcomposition"])."]]></dbllblcomposition>\n";	
			$ResponseXML .= "<weeklyShipNowQtySea><![CDATA[".trim($row["weeklyShipNowQtySea"])."]]></weeklyShipNowQtySea>\n";
			$ResponseXML .= "<weeklyShipNowQtyAir><![CDATA[".trim($row["weeklyShipNowQtyAir"])."]]></weeklyShipNowQtyAir>\n";	
			$ResponseXML .= "<strRemarks><![CDATA[".trim($row["strRemarks"])."]]></strRemarks>\n";	
			$ResponseXML .= "<balance><![CDATA[".$balance."]]></balance>\n";	
			$ResponseXML .= "<strWashCode><![CDATA[".trim($row["strWashCode"])."]]></strWashCode>\n";			
			}
			$ResponseXML .= "</loadMonShipSched>";
			
		echo $ResponseXML;
}

if($id=="loadDestination")
{
 $styleID = $_GET["styleID"];
 $delDate = $_GET["delDate"];
 $etdDate = $_GET["etdDate"];

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<loadDest>";
	$SQL1 = "SELECT
				destination.strDestName,
				destination.intDestID
				FROM
				destination
				Inner Join orderdata_destination ON destination.intDestID = orderdata_destination.intDestinationId WHERE orderdata_destination.intStyleId='$styleID'";
		    $result1 = $db->RunQuery($SQL1);	
			//echo $SQL1;
			while($row1 = mysql_fetch_array($result1))
			{
			$intDestID = trim($row1["intDestID"]);
			$SQL2 = "SELECT weeklyshipmentschedule.dblShipNowQuantityAir,weeklyshipmentschedule.dblShipNowQuantitySea,weeklyshipmentschedule.dblQtyCtn
			         FROM weeklyshipmentschedule WHERE 
			         intStyleId='$styleID' AND deliveryDate='$delDate' AND intDestID='$intDestID' AND etdDate='$etdDate'";
			$result2 = $db->RunQuery($SQL2);
			//echo $SQL2 ;
			while($row2 = mysql_fetch_array($result2))
			{
			$dblShipNowQuantityAir = trim($row2["dblShipNowQuantityAir"]);
			$dblShipNowQuantitySea = trim($row2["dblShipNowQuantitySea"]);
			$dblQtyCtn             = trim($row2["dblQtyCtn"]);
			}
			
			 $ResponseXML .= "<strDestName><![CDATA[".trim($row1["strDestName"])  . "]]></strDestName>\n";	
			 $ResponseXML .= "<intDestID><![CDATA[".trim($row1["intDestID"])  . "]]></intDestID>\n";
			 $ResponseXML .= "<dblShipNowQuantitySea><![CDATA[".$dblShipNowQuantitySea  . "]]></dblShipNowQuantitySea>\n";
			 $ResponseXML .= "<dblShipNowQuantityAir><![CDATA[".$dblShipNowQuantityAir . "]]></dblShipNowQuantityAir>\n";	
			 $ResponseXML .= "<dblQtyCtn><![CDATA[".$dblQtyCtn . "]]></dblQtyCtn>\n";	

			}
	$ResponseXML .= "</loadDest>";
	echo $ResponseXML;
}
?>
