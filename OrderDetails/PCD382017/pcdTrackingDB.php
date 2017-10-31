<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="getScDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleId = $_GET["styleId"];
$bpo = $_GET["bpo"];
$buyer = $_GET["buyer"];
$matCategory = $_GET["matCategory"];
$grnDnQty="";

$PcdDateTo = $_GET["PcdDateTo"];
$pcdDateFrom = $_GET["pcdDateFrom"];
$buyer = $_GET["buyer"];
$chkBuyerFilter = $_GET["chkBuyerFilter"];

if($PcdDateTo!=""){
	$AppDateToArray		= explode('/',$PcdDateTo);
	//$AppDateToArray2		= explode(' ',$AppDateToArray[2]);	
	$toDate = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
	}
	
if($pcdDateFrom!=""){
	$AppDateFromArray		= explode('/',$pcdDateFrom);
	//$AppDateFromArray2		= explode(' ',$AppDateFromArray[2]);	
	$fromDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	}
	
	
	
	
$ResponseXML = "<XMLLoadDetails>\n";

				$sql="SELECT
				specification.intSRNO,
				materialratio.intStyleId,
				materialratio.strBuyerPONO,
				materialratio.strMatDetailID,
				Sum(materialratio.dblQty) AS matQty,
				materialratio.intStatus,
				orders.intBuyerID,
				matitemlist.strItemDescription,
				matmaincategory.strDescription,
				matitemlist.strUnit,
				buyers.strName,
				orders.dtPCD,
				deliveryschedule.estimatedDate
				FROM
				materialratio
				INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId
				INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
				INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
				INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
				INNER JOIN specification ON materialratio.intStyleId = specification.intStyleId
				LEFT JOIN deliveryschedule ON materialratio.intStyleId = deliveryschedule.intStyleId AND materialratio.strBuyerPONO = deliveryschedule.intBPO
				WHERE
				materialratio.intStatus = 1 ";

				if($styleId != 'Select One'){
							$sql .= " AND materialratio.intStyleId = '$styleId' ";
				  }
				  
				if($bpo != 'Select One'){
							$sql .= " AND materialratio.strBuyerPONO = '$bpo'";
				  }
				  
				
				  
				  if($buyer != 'Select One' ){
							$sql .= " AND buyers.intBuyerID = '$buyer' ";
				  }
				  
				  if($chkBuyerFilter == '1'){
				$sql .= " AND buyers.intAllianceBuyers = '1' ";
				}
				
				if($pcdDateFrom != "" && $PcdDateTo!=""){
							$sql .= " AND orders.dtPCD BETWEEN '$fromDate' AND '$toDate' ";
				  }
				  
				  
				
				$sql .=" GROUP BY
				materialratio.intStyleId,
				materialratio.strBuyerPONO,
				materialratio.strMatDetailID
				ORDER BY
				materialratio.intStyleId ASC,
				materialratio.strBuyerPONO ASC,
				materialratio.strMatDetailID ASC,
				matmaincategory.intID ASC";
				
				
$result=$db->RunQuery($sql);
//echo $sql;
while($row=mysql_fetch_array($result))
{
	$styleId = $row["intStyleId"];
	//if(trim($row["strBuyerPoNo"])=="#Main Ratio#")
	//	$buyerPoNo = "#Main Ratio#";
//	else 
		//$buyerPoNo = GetBuyerPoName($row["strBuyerPoNo"]);
	//	echo "bpo =".$row["strBuyerPoNo"];
	$poQty = GetPoDetails($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
	$grnDnQty = GetGrnQty($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
	$embType = GetEmbType($styleId);

	if($grnDnQty!=""){
	$grnDatenQty		= explode('|',$grnDnQty);
	$grnDate		= $grnDatenQty[1];	
	$grnQty = $grnDatenQty[0];
	}
	
	//echo "sssssssssss = ".$embType;
			
	$ResponseXML .= "<intSRNO><![CDATA[".$row["intSRNO"]."]]></intSRNO>\n";
	$ResponseXML .= "<strBuyerPONO><![CDATA[".$row["strBuyerPONO"]."]]></strBuyerPONO>\n";
	$ResponseXML .= "<buyerName><![CDATA[".$row["strName"]."]]></buyerName>\n";
	$ResponseXML .= "<strMatDetailID><![CDATA[".$row["strItemDescription"]."]]></strMatDetailID>\n";
	$ResponseXML .= "<matQty><![CDATA[".$row["matQty"]."]]></matQty>\n";
	$ResponseXML .= "<poQty><![CDATA[".$poQty."]]></poQty>\n";
	$ResponseXML .= "<grnQty><![CDATA[".$grnQty."]]></grnQty>\n";
	$ResponseXML .= "<styleId><![CDATA[".$row["intStyleId"]."]]></styleId>\n";
	$ResponseXML .= "<matId><![CDATA[".$row["strMatDetailID"]."]]></matId>\n";
	$ResponseXML .= "<gpQty><![CDATA[".$gpToPrasara."]]></gpQty>\n";
	$ResponseXML .= "<grnDate><![CDATA[".$grnDate."]]></grnDate>\n";
	$ResponseXML .= "<embType><![CDATA[".$embType."]]></embType>\n";
	
	
	$ResponseXML .= "<transInFTY><![CDATA[".$transInFTY."]]></transInFTY>\n";
	$ResponseXML .= "<pcd><![CDATA[".$row["dtPCD"]."]]></pcd>\n";
	$ResponseXML .= "<estimatedDate><![CDATA[".$row["estimatedDate"]."]]></estimatedDate>\n";

}
$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;
}


else if($RequestType == "getBPo"){
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 	$ResponseXML="";
	
    $stytleOrSc = $_GET["stytleOrSc"];
	$type = $_GET["type"];

	   $SQL = "SELECT
				deliveryschedule.intBPO,
				specification.intSRNO,
				orders.strStyle,
				specification.intStyleId
				FROM
				deliveryschedule
				INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
				INNER JOIN orders ON deliveryschedule.intStyleId = orders.intStyleId";
				
				if($type == 'sc'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				
				if($type == 'style'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				" GROUP BY	deliveryschedule.intBPO	";
	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\""."Select One"."\" selected=\"selected\">Select One</option>";
		$str .= "<option value=\""."#Main Ratio#"."\" >#Main Ratio#</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intBPO"] ."\">" . $row["intBPO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}



//Start functions

function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}

function GetPoDetails($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
purchaseorderdetails.intPoNo,
purchaseorderdetails.intStyleId,
purchaseorderdetails.intMatDetailID,
Sum(purchaseorderdetails.dblQty) AS PoQty,
purchaseorderdetails.strBuyerPONO
FROM
purchaseorderdetails
WHERE
purchaseorderdetails.intStyleId = '$styleId' AND
purchaseorderdetails.strBuyerPONO = '$bpo' AND
purchaseorderdetails.intMatDetailID = '$matId' 
GROUP BY
purchaseorderdetails.intStyleId,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["PoQty"];
}


function GetGrnQty($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
grndetails.intGrnNo,
grndetails.intStyleId,
grndetails.strBuyerPONO,
grndetails.intMatDetailID,
Sum(grndetails.dblQty) AS grnQty,
DATE(grnheader.dtmConfirmedDate) AS dtmConfirmedDate
FROM
grndetails
INNER JOIN grnheader ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
WHERE
grndetails.intStyleId = '$styleId' AND
grndetails.intMatDetailID = '$matId' AND
grndetails.strBuyerPONO = '$bpo'
GROUP BY
grndetails.intStyleId,
grndetails.strBuyerPONO,
grndetails.intMatDetailID";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
$grnQnD=$row["grnQty"]."|".$row["dtmConfirmedDate"];
return $grnQnD;
}



function GetEmbType($styleId)
{
global $db;
 $embType=0;
//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
orders.intStyleId,
orders.intWash,
orders.intPleating,
orders.intSmoking,
orders.intDA,
orders.intSA,
orders.intHTP,
orders.intBNP,
orders.intPressing,
orders.intPreSew,
orders.intCPL,
orders.intHW,
orders.intNA,
orders.strOther,
orders.intOther,
orders.intHeatSeal,
orders.intEMB,
orders.intPrint
FROM
orders
WHERE
orders.intStyleId ='$styleId'
";
$result=$db->RunQuery($sql);
$embCatArr=array(
			"Wash"=>'intWash',
			"Pleating"=>'intPleating',
			"Smoking"=>'intSmoking',
			"DA"=>'intDA',
			"SA"=>'intSA',
			"HTP"=>'intHTP',
			"BNP"=>'intBNP',
			"Pressing"=>'intPressing',
			"PreSew"=>'intPreSew',
			"CPL"=>'intCPL',
			"HW"=>'intHW',
			"Other"=>'strOther',
			"Other2"=>'intOther',
			"HeatSeal"=>'intHeatSeal',
			"EMB"=>'intEMB',
			"Print"=>'intPrint',
			"Non Emb"=>'intNA'
			);
//$embArr = array('Wash'=>'intWash','Pleating'=>'intPleating' );
//echo $sql;
	while($row = mysql_fetch_array($result)){
		$embType = array();
		foreach($embCatArr as $key => $column ) { 
			
			if(!empty($row[$column]) ) {
				$embType[$column] = $key;
			}
		}
		
		$embStr = implode(',',$embType);
		//print_r($embStr);exit;
			/*$embCat=array(
			"Wash"=>$row["intWash"],
			"Pleating"=>$row["intPleating"],
			"Smoking"=>$row["intSmoking"],
			"DA"=>$row["intDA"],
			"SA"=>$row["intSA"],
			"HTP"=>$row["intHTP"],
			"BNP"=>$row["intBNP"],
			"Pressing"=>$row["intPressing"],
			"PreSew"=>$row["intPreSew"],
			"CPL"=>$row["intCPL"],
			"HW"=>$row["intHW"],
			"Other"=>$row["strOther"],
			"Other2"=>$row["intOther"],
			"HeatSeal"=>$row["intHeatSeal"],
			"EMB"=>$row["intEMB"],
			"Print"=>$row["intPrint"],
			"Non Emb"=>$row["intNA"]
			); */
			/*foreach($embCat as $x=>$x_value)
			  {
			 // echo "Key=" . $x . ", Value=" . $x_value;
			 // echo "<br>";
			 	if($x_value==1){
					//$avbEmbCat = array($x);
					var_dump($x);
					}
					
			  }*/
			
			
			
	//	}
		 
	
	}
return $embStr;
}



?>