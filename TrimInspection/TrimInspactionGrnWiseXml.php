<?php
session_start();
include "../Connector.php";

$RequestType	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$UserID			= $_SESSION["UserID"];

if ($RequestType=="LoadGrnDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$orderNo	= $_GET["OrderNo"];
	$grnNo		= $_GET["grnNo"];
	$grnNoArray = explode('/',$grnNo);
	
	$ResponseXML .="<LoadGrnDetails>";
	
	$sql = "SELECT	concat(GD.intGRNYear,'/',GD.intGrnNo)as grnNo,GD.intStyleId,GD.strBuyerPONO,O.strOrderNo,O.strDescription,MIL.strItemDescription,
			GD.intMatDetailID,GD.strColor,GD.strSize,MIL.strUnit, orders.strStyle,GD.intTrimIStatus,
			GD.dblQty,GD.intPreInsp,GD.intPreInspQty,GD.intInspected,GD.dblInspPercentage,GD.intInspApproved,GD.intApprovedQty,
			GD.strComment,GD.intReject,GD.intRejectQty,GD.strReason,GD.intSpecialApp,GD.intSpecialAppQty,GD.strSpecialAppReason
			FROM orders AS O
			Inner Join grndetails AS GD ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON GD.intMatDetailID = MIL.intItemSerial
			Inner Join matsubcategory AS MSC ON MIL.intSubCatID = MSC.intSubCatNo
			Inner Join grnheader AS GH ON GD.intGrnNo = GH.intGrnNo AND GD.intGRNYear = GH.intGRNYear
			Inner Join orders ON GD.intStyleId = orders.intStyleId
			WHERE MSC.intInspection = '1' and GD.intTrimIStatus<>2 and GH.intStatus=1 ";
if($orderNo!="")
	$sql .= "and GD.intStyleId='$orderNo' ";	
if($grnNo!="")
	$sql .= "AND GD.intGrnNo =$grnNoArray[1] AND GD.intGRNYear =  $grnNoArray[0] ";
		
	$sql .= "AND GH.intCompanyID='$companyId' order by O.strOrderNo,O.strDescription,MIL.strItemDescription";
	//echo $sql;	
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<GRNNo><![CDATA[". $row["grnNo"] . "]]></GRNNo>\n";
		$ResponseXML .="<TrimIStatus><![CDATA[". $row["intTrimIStatus"] . "]]></TrimIStatus>\n";
		$ResponseXML .="<StyleID><![CDATA[". $row["intStyleId"] . "]]></StyleID>\n";
		$ResponseXML .="<Style><![CDATA[". $row["strStyle"] . "]]></Style>\n";
		$ResponseXML .="<BuyerPONO><![CDATA[". $row["strBuyerPONO"] . "]]></BuyerPONO>\n";
		$ResponseXML .="<OrderNo><![CDATA[". $row["strOrderNo"] . "]]></OrderNo>\n";
		$ResponseXML .="<Description><![CDATA[". $row["strDescription"] . "]]></Description>\n";	
		$ResponseXML .="<ItemDescription><![CDATA[". $row["strItemDescription"] . "]]></ItemDescription>\n";
		$ResponseXML .="<MatDetailID><![CDATA[". $row["intMatDetailID"] . "]]></MatDetailID>\n";					
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]. "]]></Size>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]. "]]></Unit>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]. "]]></Qty>\n";
			$PreInsp=$row["intPreInsp"];			
				if ($PreInsp==1)
				{
					$ResponseXML .= "<PreInsp><![CDATA[TRUE]]></PreInsp>\n";
				}
				else
				{
					$ResponseXML .= "<PreInsp><![CDATA[FALSE]]></PreInsp>\n";
				}
		$ResponseXML .= "<PreInspQty><![CDATA[" . $row["intPreInspQty"]. "]]></PreInspQty>\n";
			$VisInspected=$row["intInspected"];
			if ($VisInspected==1)
			{
				$ResponseXML .="<VisInspected><![CDATA[TRUE]]></VisInspected>\n";
			}			
			else
			{
				$ResponseXML .="<VisInspected><![CDATA[FALSE]]></VisInspected>\n";
			}
		$ResponseXML .= "<InspPercentage><![CDATA[" . $row["dblInspPercentage"]. "]]></InspPercentage>\n";	
			$Approved=$row["intInspApproved"];
			if ($Approved==1)
			{
				$ResponseXML .="<Approved><![CDATA[TRUE]]></Approved>\n";
			}
			else
			{
				$ResponseXML .="<Approved><![CDATA[FALSE]]></Approved>\n";
			}
		$ResponseXML .= "<ApprovedQty><![CDATA[" . $row["intApprovedQty"]. "]]></ApprovedQty>\n";			
		$ResponseXML .= "<ApprovedRemark><![CDATA[" . $row["strComment"]. "]]></ApprovedRemark>\n";
			$Reject=$row["intReject"];
			if ($Reject==1)
			{
				$ResponseXML .="<Reject><![CDATA[TRUE]]></Reject>\n";
			}
			else
			{
				$ResponseXML .="<Reject><![CDATA[FALSE]]></Reject>\n";
			}
		$ResponseXML .= "<RejectQty><![CDATA[" . $row["intRejectQty"]. "]]></RejectQty>\n";
		$ResponseXML .= "<RejectReason><![CDATA[" . $row["strReason"]. "]]></RejectReason>\n";
			$SpecialApp=$row["intSpecialApp"];
			if ($SpecialApp==1)
			{
				$ResponseXML .="<SpecialApp><![CDATA[TRUE]]></SpecialApp>\n";
			}
			else
			{
				$ResponseXML .="<SpecialApp><![CDATA[FALSE]]></SpecialApp>\n";
			}
		$ResponseXML .= "<SpecialAppQty><![CDATA[" . $row["intSpecialAppQty"]. "]]></SpecialAppQty>\n";
		$ResponseXML .= "<SpecialAppReason><![CDATA[" . $row["strSpecialAppReason"]. "]]></SpecialAppReason>\n";		
	}

	$ResponseXML .="</LoadGrnDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveGrnTrimInsDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$grnNo =$_GET["intGrnNo"];
	$grnArray =explode('/',$grnNo);
	$StyleId =$_GET["strStyleId"];
	$buyerPoNo =$_GET["BuyerPoNo"];
	$BuyerPoNo =str_replace("Main Ratio","#Main Ratio#",$buyerPoNo);
	$MatDetailID =$_GET["intMatDetailID"];
	$Color =$_GET["strColor"];
	$Size =$_GET["strSize"];
	
	$PreIns =$_GET["PreIns"];
	$PreInsQty =$_GET["PreInsQty"];
	
	$visIns =$_GET["visIns"];
	$visInsQty =$_GET["visInsQty"];
	$visInsQty =explode('%',$visInsQty);
	
	$approved =$_GET["approved"];
	$approvedQty =$_GET["approvedQty"];
	$approvedRemark =$_GET["approvedRemark"];
	
	$reject =$_GET["reject"];
	$rejectQty =$_GET["rejectQty"];
	$rejectRemark =$_GET["rejectRemark"];
	
	$spApp =$_GET["spApp"];
	$spAppQty =$_GET["spAppQty"];
	$spAppRemark =$_GET["spAppRemark"];
	
	$saveCount =$_GET["saveCount"];
		
	$ResponseXML .="<SaveGrnTrimInsDetails>";
	
	$SQL="UPDATE grndetails SET intPreInsp =$PreIns,intPreInspQty=$PreInsQty,intInspected=$visIns,dblInspPercentage=$visInsQty[0],intInspApproved=$approved,intApprovedQty=$approvedQty,strComment='$approvedRemark',intReject=$reject,intRejectQty=$rejectQty,strReason='$rejectRemark',intSpecialApp=$spApp,intSpecialAppQty=$spAppQty,strSpecialAppReason='$spAppRemark' WHERE intGrnNo=$grnArray[1] AND intGRNYear=$grnArray[0] AND intStyleId='$StyleId' AND strBuyerPONO='$BuyerPoNo' AND intMatDetailID=$MatDetailID AND strColor='$Color' AND strSize='$Size'";
	
	$result = $db->RunQuery($SQL);	
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	$ResponseXML .="</SaveGrnTrimInsDetails>";
	echo $ResponseXML;	
}
else if($RequestType=="URLLoadGRNNo")
{
$styleId	= $_GET["StyleId"];
	$sql= "SELECT DISTINCT CONCAT(GH.intGRNYear ,'/',GH.intGrnNo) AS grnNO 
			FROM grndetails GD
			inner join grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
			inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
			WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 ";
			
if($styleId!=""){
	$sql .= " and GD.intStyleId='$styleId'";
	}
	
	$sql .= " order by grnNO desc";
	
		echo "<option value =\"".""."\">"."Select One"."</option>";
	$result =$db->RunQuery($sql);	
	while($row =mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["grnNO"]."\">".$row["grnNO"]."</option>";
	}
}
?>