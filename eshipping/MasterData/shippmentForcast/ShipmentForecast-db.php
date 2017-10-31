<?php


session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 

$id 		= $_GET["id"];



if($id=="loadgrid")
{

	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML.= "<GridDetails>\n";
	
     $load_id=$_GET['load_id'];   
	
	 $sql="SELECT
                shipmentforecast_detail.intSerialNo,
                shipmentforecast_detail.strSC_No,
                shipmentforecast_detail.strBuyer,
                shipmentforecast_detail.strPoNo,
                shipmentforecast_detail.strStyleNo,
                shipmentforecast_detail.strQty,
                shipmentforecast_detail.intNetWt,
                shipmentforecast_detail.intGrsWt,
                shipmentforecast_detail.intUnitPrice,
                shipmentforecast_detail.strDesc,
                shipmentforecast_detail.strFabric,
                shipmentforecast_detail.strCountry,
                shipmentforecast_detail.strFactory,
                shipmentforecast_detail.dtmEX_FTY_Date,
                shipmentforecast_detail.strSeason
                FROM
                shipmentforecast_detail
				 WHERE `strBuyer` LIKE '%$load_id %'
				 AND shipmentforecast_detail.intSerialNo='0'";
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateArray 	= explode('-',$row["dtmEX_FTY_Date"]);
			$foramtDateArray= $dateArray[2]."/".$dateArray[1]."/".$dateArray[0];
                        
                        $ResponseXML .= "<SCNo><![CDATA[" . $row["strSC_No"]  . "]]></SCNo>\n";
                        $ResponseXML .= "<PoNo><![CDATA[" . $row["strPoNo"]  . "]]></PoNo>\n";
                        $ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></StyleNo>\n";
                        $ResponseXML .= "<Desc><![CDATA[" .$row["strDesc"]  . "]]></Desc>\n";
                        $ResponseXML .= "<Fabric><![CDATA[" .$row["strFabric"]  . "]]></Fabric>\n";
                        $ResponseXML .= "<Country><![CDATA[" .$row["strCountry"]  . "]]></Country>\n";
                        $ResponseXML .= "<Season><![CDATA[" .$row["strSeason"]  . "]]></Season>\n";
                        $ResponseXML .= "<UnitPrice><![CDATA[" .$row["intUnitPrice"]  . "]]></UnitPrice>\n";
                        $ResponseXML .= "<EX_FTY_Date><![CDATA[" .$foramtDateArray  . "]]></EX_FTY_Date>\n";
                        $ResponseXML .= "<Factory><![CDATA[" .$row["strFactory"]  . "]]></Factory>\n";
                        //$ResponseXML .= "<CtnMes><![CDATA[" .$row["strCtnMes"]  . "]]></CtnMes>\n";
                        $ResponseXML .= "<Qty><![CDATA[" .$row["strQty"]  . "]]></Qty>\n";
                      	$ResponseXML .= "<Net><![CDATA[" .$row["intNetWt"]  . "]]></Net>\n";
						$ResponseXML .= "<Grs><![CDATA[" . $row["intGrsWt"]  . "]]></Grs>\n";
			
			
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}


if($id=='saveHeader')
{
$Name		= $_GET["Name"];
$date		= $_GET["date"];
	 $sql_insert =  "INSERT INTO shipmentforecast_header 
                       (
                       strName,
                       dtmUp_Date,
                       intStatus    
                       )
                       VALUES
                       (
                       '$Name',
                       '$date',
                           '1' 
                        )";
	$result=$db->RunQuery($sql_insert);
	//$row_h=mysql_fetch_array($result);
        
       // echo $row_h["strName"];
       if($result)
       {
       $sql_serial =  "SELECT
                        shipmentforecast_header.intSerialNo,
                        shipmentforecast_header.strName
                        FROM
                        shipmentforecast_header
                        WHERE
                        shipmentforecast_header.strName='$Name'";
	$result_serial=$db->RunQuery($sql_serial);  
       $row=mysql_fetch_array($result_serial);
        echo $row['intSerialNo'];
       }
}	


if($id=='saveDetail')
{
$serialNo   = $_GET["serialNo"];
echo $SCno       = $_GET["SCno"];

	$sql =  "UPDATE shipmentforecast_detail SET intSerialNo='$serialNo' 
                        WHERE  shipmentforecast_detail.strSC_No='$SCno'";
	$result=$db->RunQuery($sql);
}






if($id=='saveStyleRatio')
{
$ScNo			= $_GET["ScNo"];
$PONO			= $_GET["PONO"];
$color			= $_GET["color"];
$size			= $_GET["size"];
$Qty			= $_GET["Qty"];


		 $sql_style =  "SELECT
						shipmentforecast_detail.strSC_No,
						shipmentforecast_detail.strPoNo,
						shipmentforecast_detail.strStyleNo
						FROM
						shipmentforecast_detail
						WHERE
						shipmentforecast_detail.strSC_No = '$ScNo' AND
						shipmentforecast_detail.strPoNo = '$PONO' 
						";
		$result_style=$db->RunQuery($sql_style);  
		$row=mysql_fetch_array($result_style);
		
		echo  $style=$row['strStyleNo'];


	if($result_style)
	{
	
	
		$sql_insert =  "INSERT INTO shipment_order_ratio
						(
						strScNo,
						strStyleNo,
						strBuyerPoNo,
						strColor,
						strSize,
						dblQty
						)
						VALUES
						(
						'$ScNo',
						'$style',
						'$PONO',
						'$color',
						'$size',
						'$Qty'
						)";
		$result=$db->RunQuery($sql_insert);
	}
}




?>
