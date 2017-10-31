<?php

include "../../../Connector.php";
$id=$_GET['id'];

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<DispatchNoteDetails>";
	$buyerId=$_GET["buyerId1"];
	
	$SQL = "SELECT DISTINCT
			shipmentpldetail.strPLNo,
			shipmentplheader.strStyle,
			orderspec.strOrder_No,
			orderspec.dblUnit_Price,
			orderspec.dblOrderQty
			FROM
			shipmentpldetail
			INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = shipmentpldetail.strPLNo
			INNER JOIN orderspec ON orderspec.strOrder_No = shipmentplheader.strStyle
			INNER JOIN buyers ON buyers.strBuyerID = orderspec.strBuyer
			WHERE buyers.strBuyerID=$buyerId;";

	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$plno=$row["strPLNo"];
		
		$sql_select="SELECT
					exportdispatchheader.intDispatchNo,
					exportdispatchheader.strBuyerCode,
					exportdispatchdetail.strPLNo
					FROM
					exportdispatchheader
					INNER JOIN exportdispatchdetail ON exportdispatchheader.intDispatchNo = exportdispatchdetail.intDispatchNo
					WHERE strBuyerCode=$buyerId AND strPLNo=$plno
					";
		$result_select=$db->RunQuery($sql_select);
		
		if(mysql_num_rows($result_select)==0)
		{
		$sql1="SELECT SUM(shipmentpldetail.dblQtyPcs) AS sumPLQty FROM shipmentpldetail WHERE strPLNo='$plno';";
		$result1 = $db->RunQuery($sql1);
		$row1 = mysql_fetch_array($result1);
		
		$ResponseXML .= "<PLNo><![CDATA[" . $row["strPLNo"]  . "]]></PLNo>\n";
		$ResponseXML .= "<Style><![CDATA[" . $row["strStyle"]  . "]]></Style>\n";
		$ResponseXML .= "<PONo><![CDATA[" . $row["strOrder_No"]  . "]]></PONo>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["dblUnit_Price"]  . "]]></Unit>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . $row["dblOrderQty"]  . "]]></OrderQty>\n";
		$ResponseXML .= "<PLQty><![CDATA[" . $row1["sumPLQty"]  . "]]></PLQty>\n";
		}
	}	 
	  
		$ResponseXML .= "</DispatchNoteDetails>";
		echo $ResponseXML;
}

if($id=='saveDispatchHeader')
{
	$buyerId   =$_GET['buyerId'];
	$dateDispatch=$_GET['dateDispatch'];
	$remarks=$_GET['remarks'];
	$forwaderId=$_GET['forwaderId'];
	
	$dateDispatchArray 	= explode('/',$dateDispatch);
	$FormatDateDispatch = $dateDispatchArray[2]."-".$dateDispatchArray[1]."-".$dateDispatchArray[0];
	$sql_incre="UPDATE syscontrol
				SET
				dblDispatchNo=dblDispatchNo+1;
				";
	$result_incre=$db->RunQuery($sql_incre);
	
	$sql_select="SELECT dblDispatchNo FROM sysControl;";
	$result_select=$db->RunQuery($sql_select);
	$row_select=mysql_fetch_array($result_select);
	
	$dispatchNo=$row_select['dblDispatchNo'];

	
	$sql="INSERT INTO exportdispatchheader
		 (intDispatchNo,dtmDate,strBuyerCode,strRemarks,intForwaderId)
		 values($dispatchNo,'$FormatDateDispatch','$buyerId','$remarks',$forwaderId);";
		 
	$result = $db->RunQuery($sql);
	if($result)
	{
		echo $dispatchNo;
	}
	else
		echo 0;	
}	

if($id=='saveDispatchDetail')
{
	$dispatchNo=$_GET['dispatchNo'];
	$plNo=$_GET['plNo'];
	$styleNo   =$_GET['styleNo'];
	$orderNo   =$_GET['orderNo'];
	$dispatchQty=$_GET['dispatchQty'];
	
	$sql="INSERT INTO exportdispatchdetail
		 (intDispatchNo,strPLNo,strStyleNo,strOrderNo,dblDispatchQty)
		 values($dispatchNo,$plNo,'$styleNo','$orderNo','$dispatchQty');";
		 
	$result = $db->RunQuery($sql);
	
}

if($id=='loadDispatchDetails')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<DispatchDetails>";
	$dispatchNo=$_GET["dispatchNo"];
	
	$SQL = "SELECT DISTINCT
exportdispatchheader.intDispatchNo,
exportdispatchheader.intForwaderId,
exportdispatchheader.strRemarks,
exportdispatchheader.strBuyerCode,
exportdispatchheader.dtmDate,
exportdispatchdetail.strPLNo,
exportdispatchdetail.strStyleNo,
exportdispatchdetail.strOrderNo,
exportdispatchdetail.dblDispatchQty,
orderspec.dblUnit_Price,
orderspec.dblOrderQty
FROM
exportdispatchheader
INNER JOIN exportdispatchdetail ON exportdispatchheader.intDispatchNo = exportdispatchdetail.intDispatchNo
INNER JOIN orderspec ON orderspec.strOrder_No = exportdispatchdetail.strOrderNo
WHERE exportdispatchheader.intDispatchNo=$dispatchNo
";

	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$dateDispatchArray 	= explode('-',$row['dtmDate']);
		$FormatDateDispatch = $dateDispatchArray[2]."/".$dateDispatchArray[1]."/".$dateDispatchArray[0];
		
		$plno=$row["strPLNo"];
		$sql1="SELECT SUM(shipmentpldetail.dblQtyPcs) AS sumPLQty FROM shipmentpldetail WHERE strPLNo='$plno';";
		$result1 = $db->RunQuery($sql1);
		$row1 = mysql_fetch_array($result1);
	
		$ResponseXML .= "<BuyerCode><![CDATA[" . $row["strBuyerCode"]  . "]]></BuyerCode>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<DispatchDate><![CDATA[" . $FormatDateDispatch  . "]]></DispatchDate>\n";
		$ResponseXML .= "<ForwarderId><![CDATA[" . $row["intForwaderId"]  . "]]></ForwarderId>\n";
		$ResponseXML .= "<Style><![CDATA[" . $row["strStyleNo"]  . "]]></Style>\n";
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<DispatchQty><![CDATA[" . $row["dblDispatchQty"]  . "]]></DispatchQty>\n";
		$ResponseXML .= "<PLNo><![CDATA[" . $row["strPLNo"]  . "]]></PLNo>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["dblUnit_Price"]  . "]]></Unit>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . $row["dblOrderQty"]  . "]]></OrderQty>\n";
		$ResponseXML .= "<PLQty><![CDATA[" . $row1["sumPLQty"]  . "]]></PLQty>\n";
	}	 
	  
		$ResponseXML .= "</DispatchDetails>";
		echo $ResponseXML;		
}



if($id=='updateDispatchHeader')
{
	$dispatchNo=$_GET['dispatchNo'];
	$buyerId   =$_GET['buyerId'];
	$dateDispatch=$_GET['dateDispatch'];
	$remarks=$_GET['remarks'];
	$forwaderId=$_GET['forwaderId'];
	
	$dateDispatchArray 	= explode('/',$dateDispatch);
	$FormatDateDispatch = $dateDispatchArray[2]."-".$dateDispatchArray[1]."-".$dateDispatchArray[0];
	
	 $sql="UPDATE exportdispatchheader
		  SET
		  strBuyerCode='$buyerId',
	      dtmDate='$FormatDateDispatch',
          strRemarks='$remarks',
          intForwaderId=$forwaderId
          WHERE
          intDispatchNo=$dispatchNo";
		 
	$result = $db->RunQuery($sql);
	if($result)
	{
		echo 1;
	}
	else
		echo 0;	
}	



if($id=='updateDispatchDetail')
{
	$dispatchNo=$_GET['dispatchNo'];
	$plNo=$_GET['plNo'];
	$styleNo   =$_GET['styleNo'];
	$orderNo   =$_GET['orderNo'];
	$dispatchQty=$_GET['dispatchQty'];
	
	$sql="UPDATE exportdispatchdetail
		 SET
		 strPLNo='$plNo',
		 strStyleNo='$styleNo',
		 strOrderNo='$orderNo',
		 dblDispatchQty=$dispatchQty
		 
		 WHERE intDispatchNo=$dispatchNo;";
		 
	$result = $db->RunQuery($sql);
	
}





?>